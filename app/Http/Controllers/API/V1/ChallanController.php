<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Challan\ChallanRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\Location\LocationRepository;
use Config;
use App\Services\BarcodeService;
use App\Http\Requests\EndTripRequest;
use App\Http\Controllers\API\V1\ShiftController;
use App\Traits\CustomTrait;
use App\Repositories\Organization\OrganizationRepository;
use App\Http\Requests\ScanChallanRequest;
use App\Http\Requests\FetchBarcodeRequest;
use App\Http\Requests\CreateChallanRequest;
use App\Services\PdfService;
use App\Repositories\BtopPlanning\BtopPlanningRepository;
use App\Repositories\BtopPlannedTruck\BtopPlannedTruckRepository;
use Carbon\Carbon;
use App\Http\Requests\InboundChallanListRequest;

class ChallanController extends BaseController {

    use CustomTrait;

    protected $challanRepository, $shiftController, $locationRepository, $organizationRepository, $btopPlannedTruckRepository, $pdfService;

    public function __construct(ChallanRepository $challanRepository, ShiftController $shiftController, LocationRepository $locationRepository, OrganizationRepository $organizationRepository, BtopPlannedTruckRepository $btopPlannedTruckRepository, PdfService $pdfService) {
        $this->challanRepository = $challanRepository;
        $this->shiftController = $shiftController;
        $this->locationRepository = $locationRepository;
        $this->organizationRepository = $organizationRepository;
        $this->btopPlannedTruckRepository = $btopPlannedTruckRepository;
        $this->pdfService = $pdfService;
    }

    /**
        @description : End trip Api
        @author : Itishree Nath
    */
    
    /**
    * @OA\POST(
    * path="/trip/end",
    * tags={"Challan"},
    * summary="End a trip",
    * @OA\RequestBody(
    *    required=true,
    *    description="Pass planning Id, Truck Id and Plot Id",
    *    @OA\JsonContent(
    *       required={"planning_id","truck_id","location_id"},
    *       @OA\Property(property="planning_id", type="integer", format="integer", example="1"),
    *       @OA\Property(property="truck_id", type="integer", format="integer", example="1"),
    *       @OA\Property(property="location_id", type="integer", format="integer", example="1"),
    *    ),
    * ),
    * @OA\Response(
    *      response=200,
    *      description="Success",
    *      @OA\MediaType(
    *           mediaType="application/json",
    *      )
    * ),
    * security={{ "apiAuth": {} }}
    *)
    **/
    public function endTrip(EndTripRequest $request) {

        $allInput = $request->all();
        $param = $this->getAuth($allInput);
        $allInput['connection'] = $param['connection'];
        $allInput['user_id'] = $param['user_id'];
        //to check Location is plot or not;

        $response = $this->locationRepository->getLocationById($allInput,Config::get('constants.location_plot'));
        if($response['status'] == true){
            //if location is plot, check whether the Trip has already ended or not 
            $response = $this->challanRepository->getChallanByInput($allInput);
            if($response['status'] == true)
            {
                if(!$response['result']['unloaded_at']){
                    //if not ended then update challan table and end trip
                    $challan_response = $this->challanRepository->updateChallanTableForEndTrip($allInput);
                    if($challan_response['status'] == false){
                        return $this->sendError($challan_response,'Something went wrong',$param);
                    }
                    //update status as 2-unloaded of btop_planned_trucks
                    $truck_response = $this->btopPlannedTruckRepository->updateStatusAsUnloaded($allInput);
                    if($truck_response['status'] == false){
                        return $this->sendError($truck_response,'Something went wrong',$param);
                    }
                    return $this->sendResponse([],"The trip ended successfully.",$param);
                }
                return $this->sendError(['The trip has already ended.'],'The trip has already ended.',$param);
            }
            return $this->sendError(['There is no such trip to be ended.'],'There is no such trip to be ended.',$param);
        }
        return $this->sendError(['This endtrip is not for this location.'],'This endtrip is not for this location.',$param);     
    }
    
    /**
        @description : Challan List View
        @author : Madhusmita Das
    */
    public function index(Request $request) {
        $inputs = $request->all();
        $auth = $this->getAuth($inputs);
        $inputs['connection'] = $auth['connection'];
        $inputs['user_id'] = $auth['user_id'];
        $privileges =   isset( $inputs['privilege_array'] )? $inputs['privilege_array'] : "";
        $shifts = $this->getDataFromJsonResponse($this->shiftController->index($request));
        return view('challans.index', compact('shifts', 'privileges'));
    }
    
    /**
        @description : Challan List by Ajax
        @author : Madhusmita Das
    */
    public function getChallanList(Request $request) {
        $inputs = $request->all();
        $auth = $this->getAuth($inputs);

        //For Pagination
        $columns = $inputs['columns'];
        $start = $inputs['start'];
        $limit = $inputs['length'];
        $order = [];
        $where = trim($inputs['search']['value']);
        if(!empty($where)) {
            $where = preg_replace('/[^a-zA-Z0-9 ]/s','', $where);
        }
        
        if(isset($inputs['order'])) {
            $orderBy = $inputs['order'][0];
            if ($orderBy['column'] > 0) {
                $order['field'] = $columns[$orderBy['column']]['data'];
                $order['dir'] = $orderBy['dir'];
            }
        }
        
        $filterCondition = $this->getFilterConditions($inputs['filterParams']);
        $challans = $this->challanRepository->getListChallans($auth, $start, $limit, $order, $where, $filterCondition, false);
        $allRecord = $this->challanRepository->getListChallans($auth, $start, $limit, $order, $where, $filterCondition, true);
        
        /*Start :: Get Challan Counts Based On Filter*/
        $challanCountResponse = $this->challanRepository->getReconciledCounts($auth, $filterCondition);
        $challanCounts = [];
        if ($challanCountResponse !== false) {
            $challanCounts = $challanCountResponse['result'];
        }
        /*End :: Get Challan Counts Based On Filter*/
        
        $data = [];
        foreach ($challans as $challan) {
            $checked = ($challan->is_deposit == '1') ? 'checked' : '';
            $disabled = ($challan->is_deposit == '1') ? 'disabled' : '';
            $data[] = [
                'id' => '<input type="checkbox"  class="challan_id" value="' . $challan->id . '" data-reconcile-status = "'.$challan->is_deposit.'" ' . $checked .' '. $disabled . '/>',
                'challan_no' => '<a href="'.url('/').'/'.$challan->pdf_path.'" target="_blank">'.$challan->challan_no.'</a>',
                'type' => $challan->type,
                'truck_no' => $challan->truck_no,
                'origin' => $challan->origin,
                'cargo_name' => $challan->cargo_name,
                'date_from' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $challan->date_from)->format('d/m/Y H:i:s'),
                'date_to' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $challan->date_to)->format('d/m/Y H:i:s'),
                'shift_name' => $challan->shift_name,
                'status' => $challan->status
            ];
        }
        $response = array(
            "recordsTotal" => count($allRecord),
            "recordsFiltered" => count($allRecord),
            "data" => $data,
            'challanCounts' => $challanCounts
        );
        return json_encode($response);
    }

    /**
        @description : Inbound Challan List Api
        @author : Itishree Nath
    */
    
    /** 
    * @OA\GET(
    * path="/challan/inbound-list/{plan_id}/{plot_id}",
    * tags={"Challan"},
    * summary="Inbound Challan List",
    * @OA\RequestBody(
    *    required=true,
    *    description="Pass Plan Id and Plot Id",
    *    @OA\JsonContent(
    *       required={"plan_id","plot_id"},
    *       @OA\Property(property="plan_id", type="integer", format="integer", example="1"),
    *       @OA\Property(property="plot_id", type="integer", format="integer", example="1"),
    *    ),
    * ),
    * @OA\Response(
    *      response=200,
    *      description="Success",
    *      @OA\MediaType(
    *           mediaType="application/json",
    *      )
    * ),
    * security={{ "apiAuth": {} }}
    *)
    **/
    public function getInboundChallanList(InboundChallanListRequest $request) {
        $allInput = $request->all();
        $param = $this->getAuth($allInput);
        $allInput['connection'] = $param['connection'];
        $allInput['user_id'] = $param['user_id'];
        $allInput['planning_id'] = $allInput['plan_id'];
        $allInput['location_id'] = $allInput['plot_id'];
        //to get Organization details
        $org_response = $this->organizationRepository->getOrganizationById($param['user_auth']->organization_id, $allInput);
        if($org_response['status'] == false) {
            return $this->sendError([$org_response['message']], $org_response['message'], $param);
        }
        $organization = $org_response['result'];

        //to check Location is plot or not;
        $location_response = $this->locationRepository->getLocationById($allInput,Config::get('constants.location_plot'));
        if($location_response['status'] == false){
            return $this->sendError(['Please provide a correct plot no.'],'Please provide a correct plot no.',$param);            
        }

        //fetch planned loaded truck details from btop_planned_trucks (input:planning_id)
        $planned_trucks_response = $this->btopPlannedTruckRepository->getPlannedLoadedTrucksById($allInput);
        if($planned_trucks_response['status'] == false){
            return $this->sendError(['There is no planned trucks for this plot.'],'There is no planned trucks for this plot.',$param);
        }else {
            if($planned_trucks_response['result']->isEmpty()) {
                return $this->sendError(['No record found. Please provide correct information.'], 'No record found. Please provide correct information.', $param);
            } else {              
                $data =[];
                $data['planning_id'] = $allInput['plan_id'];
                $data['organization'] = ['id' => $organization->id, 'name' => $organization->name];
                $data['trucks'] = [];
                foreach($planned_trucks_response['result'] as $key => $trucks_response) {
                    $row = [];
                    $allInput['truck_id'] = $trucks_response->truck_id;
                    $challan_response = $this->challanRepository->getInboundChallanList($allInput);
                    if ($challan_response['status'] == true) {
                        $row['truck'] = ['id' => $trucks_response->truck->id, 'name' => $trucks_response->truck->truck_no];
                        $challan = $challan_response['result'];
                        $row['challan'] = ['id' => $challan->id, 'challan_no' => $challan->challan_no, 'loaded_at' => $challan->loaded_at, 'shift_id' => $challan->shift->id, 'shift_name' => $challan->shift->name];    
                        $data['trucks'][] = $row;
                    }
                }
                if(empty($data['trucks'])) {
                    return $this->sendError(['No challan record found for this destination location.'], 'No challan record found for this destination location.', $param);
                }
                return $this->sendResponse($data, "Inbound challan list fetched successfully", $param);
            }
        }   
    }
    
    /**
        @description : Reconcile Challan
        @author : Madhusmita Das
    */
    
    /**
    * @OA\POST(
    * path="/challan/reconcile",
    * tags={"Challan"},
    * summary="Reconcile Challan(s)",
    * @OA\RequestBody(
    *    required=true,
    *    description="Pass Challan Id(s) in an array",
    *    @OA\JsonContent(
    *       required={"challan_ids"},
    *       @OA\Property(
    *           property="challan_ids", 
    *           type="array",
    *           @OA\Items(
    *               type="string",
    *               example="1"
    *           ),
    *      ),
    *    ),
    * ),
    * @OA\Response(
    *      response=200,
    *      description="Success",
    *      @OA\MediaType(
    *           mediaType="application/json",
    *      )
    * ),
    * security={{ "apiAuth": {} }}
    *)
    **/
    public function reconcileChallan(Request $request) {
        $inputs = $request->input();
        $auth = $this->getAuth($inputs);
        $inputs['connection'] = $auth['connection'];
        $inputs['user_id'] = $auth['user_id'];
        $response = $this->challanRepository->reconcileChallan($inputs);
        if ($response['status'] == false) {
            return $this->sendError(['Something went wrong'], 'Something went wrong', $auth);
        }

        return $this->sendResponse(["Selected challans reconciled successfully."], "Selected challans reconciled successfully.", $auth);

    }

    /**
        @description : Scan Challan Api
        @author : Madhusmita Das
    */
    
    /** 
    * @OA\POST(
    * path="/challan/scan",
    * tags={"Challan"},
    * summary="Scan Challan",
    * @OA\RequestBody(
    *    required=true,
    *    description="Pass Challan No. and Plot Id",
    *    @OA\JsonContent(
    *       required={"planning_id","location_id"},
    *       @OA\Property(property="challan_no", type="string", format="string", example="2020092570488"),
    *       @OA\Property(property="plot_id", type="integer", format="integer", example="1"),
    *    ),
    * ),
    * @OA\Response(
    *      response=200,
    *      description="Success",
    *      @OA\MediaType(
    *           mediaType="application/json",
    *      )
    *   ),
    * security={{ "apiAuth": {} }}
    *)
    **/
    public function scanChallanApi(ScanChallanRequest $request) {
        $inputs = $request->input();
        $auth = $this->getAuth($inputs);
        $inputs['connection'] = $auth['connection'];
        $inputs['user_id'] = $auth['user_id'];
        $inputs['location_id'] = $inputs['plot_id'];
        $org_response = $this->organizationRepository->getOrganizationById($auth['user_auth']->organization_id, $inputs);

        //Get organization details
        if ($org_response['status'] == false) {
            return $this->sendError([$org_response['message']], $org_response['message'], $auth);
        }

        //Get challan details
        $challan_response = $this->challanRepository->getChallanDetails($inputs);
        if ($challan_response['status'] == false) {
            return $this->sendError([$challan_response['message']], $challan_response['message'], $auth);
        }

        //Validate Inputs
        $challan = $challan_response['result'];
        $organization = $org_response['result'];

        if ($challan->destination->type != Config::get('constants.location_plot')) {
            return $this->sendError(['Please provide a correct plot no.'], 'Please provide a correct plot no.', $auth);
        } else if ($challan->destination_location_id != $inputs['location_id']) {
            return $this->sendError(['This challan belongs to a different location'], 'This challan belongs to a different location', $auth);
        } else if ((!empty($challan->unloaded_at)) || ($challan->status == '2')) {
            return $this->sendError(['The trip is already ended'], 'The trip is already ended', $auth);
        } else if ($challan->is_scanned == '1') {
            return $this->sendError(['This challan is already scanned'], 'This challan is already scanned', $auth);
        }

        $update_challan = $this->challanRepository->updateChallanScanStatus($inputs);
        if ($update_challan['status'] == false) {
            return $this->sendError(['Something went wrong. Please try again.'], 'Something went wrong. Please try again.', $auth);
        }

        $data = [
            'planning_id' => $challan->btop_planning_id,
            'trucks' => ['id' => $challan->truck->id, 'truck_no' => $challan->truck->truck_no],
            'organization' => ['id' => $organization->id, 'name' => $organization->name],
            'plot' => ['id' => $challan->destination->id, 'name' => $challan->destination->location],
        ];

        return $this->sendResponse($data, "Challan scanned successfully", $auth);
    }

    /**
        @description : Fetch Barcode Api
        @author : Madhusmita Das
    */
    
    /** 
    * @OA\GET(
    * path="/challan/barcode/{plan_id?}/{plot_id?}/{truck_id?}",
    * tags={"Challan"},
    * summary="Fetch Barcode",
    * @OA\RequestBody(
    *    required=true,
    *    description="Pass Plan Id, Truck Id and Plot Id",
    *    @OA\JsonContent(
    *       required={"planning_id","truck_id","location_id"},
    *       @OA\Property(property="plan_id", type="integer", format="integer", example="1"),
    *       @OA\Property(property="plot_id", type="integer", format="integer", example="1"),
    *       @OA\Property(property="truck_id", type="integer", format="integer", example="1"),
    *    ),
    * ),
    * @OA\Response(
    *      response=200,
    *      description="Success",
    *      @OA\MediaType(
    *           mediaType="application/json",
    *      )
    *   ),
    * security={{ "apiAuth": {} }}
    *)
    **/
    public function fetchBarcodeApi(FetchBarcodeRequest $request) {
        $inputs = $request->all();
        $auth = $this->getAuth($inputs);
        $inputs['connection'] = $auth['connection'];
        $inputs['user_id'] = $auth['user_id'];
        $inputs['planning_id'] = $inputs['plan_id'];
        $inputs['location_id'] = $inputs['plot_id'];

        //Get organization details
        $org_response = $this->organizationRepository->getOrganizationById($auth['user_auth']->organization_id, $inputs);

        if ($org_response['status'] == false) {
            return $this->sendError([$org_response['message']], $org_response['message'], $auth);
        }
        $organization = $org_response['result'];

        //Get location details
        $location_response = $this->locationRepository->getLocationById($inputs, Config::get('constants.location_plot'));
        if ($location_response['status'] == false) {
            return $this->sendError(['Please provide a correct plot no.'], 'Please provide a correct plot no.', $auth);
        }

        //Get challan details
        $challan_response = $this->challanRepository->getFilteredChallans($inputs);
        if ($challan_response['status'] == false) {
            return $this->sendError(['Some error occured'], 'Some error occured', $auth);
        } else {
            if ($challan_response['result']->isEmpty()) {
                return $this->sendError(['No record found. Please provide correct information.'], 'No record found. Please provide correct information.', $auth);
            } else {
                $challans = [];
                foreach ($challan_response['result'] as $challan) {
                    $challan->barcode_path = (isset($challan->barcode_path) && !empty($challan->barcode_path)) ? url('/') . '/' . $challan->barcode_path : '';
                    $challans[] = ['id' => $challan->id, 'challan_no' => $challan->challan_no, 'barcode_path' => $challan->barcode_path];
                }
                $data = [
                    'challan' => $challans,
                    'planning_id' => $inputs['planning_id'],
                    'location_id' => $inputs['location_id'],
                    'organization' => ['id' => $organization->id, 'name' => $organization->name]
                ];
                return $this->sendResponse($data, "Challan details fecthed successfully", $auth);
            }
        }
    }

    /**
        @description : Create Challan Api
        @author : Madhusmita Das
    */
    
    /** 
    * @OA\POST(
    * path="/challan",
    * tags={"Challan"},
    * summary="Create Challan",
    * @OA\RequestBody(
    *    required=true,
    *    description="Pass Planning Id, Truck Id, Origin Location Id i.e Berth Id, Destination Location Id i.e Plot Id, Consignee Id, Shift Id",
    *    @OA\JsonContent(
    *       required={"planning_id", "truck_id", "origin_location_id", "destination_location_id", "consignee_id", "shift_id"},
    *       @OA\Property(property="planning_id", type="string", format="string", example="2020092570488"),
    *       @OA\Property(property="truck_id", type="integer", format="integer", example="1"),
    *       @OA\Property(property="origin_location_id", type="integer", format="integer", example="1"),
    *       @OA\Property(property="destination_location_id", type="integer", format="integer", example="1"),
    *       @OA\Property(property="consignee_id", type="integer", format="integer", example="1"),
    *       @OA\Property(property="shift_id", type="integer", format="integer", example="1"),
    *    ),
    * ),
    * @OA\Response(
    *      response=200,
    *      description="Success",
    *      @OA\MediaType(
    *           mediaType="application/json",
    *      )
    *   ),
    * security={{ "apiAuth": {} }}
    *)
    **/
    public function createChallan(CreateChallanRequest $request) {
        $inputs = $request->input();
        $auth = $this->getAuth($inputs);
        $inputs['connection'] = $auth['connection'];
        $ObjBtopPlanningRepository = new BtopPlanningRepository();
        
        //Get organization details
        $org_response = $this->organizationRepository->getOrganizationById($auth['user_auth']->organization_id, $inputs);
        if ($org_response['status'] == false) {
            return $this->sendError([$org_response['message']], $org_response['message'], $auth);
        }
        $organization = $org_response['result'];
        
        //Validate origin
        $origin_inputs['connection'] = $auth['connection'];
        $origin_inputs['location_id'] = $inputs['origin_location_id'];
        $origin_response = $this->locationRepository->getLocationById($origin_inputs, Config::get('constants.location_berth'));
        if ($origin_response['status'] == false) {
            $message = 'Please provide a correct berth id';
            return $this->sendError([$message], $message, $auth);
        }
        $origin = $origin_response['result'];
        
        //Validate destination
        $destination_inputs['connection'] = $auth['connection'];
        $destination_inputs['location_id'] = $inputs['destination_location_id'];
        $destination_response = $this->locationRepository->getLocationById($destination_inputs, Config::get('constants.location_plot'));
        if ($destination_response['status'] == false) {
            $message = 'Please provide a correct plot id';
            return $this->sendError([$message], $message, $auth);
        }
        $destination = $destination_response['result'];
        
        //Validate Planning Details
        $planning_response = $ObjBtopPlanningRepository->getPlanningInfo($inputs);
        if ($planning_response['status'] == false) {
            return $this->sendError([$planning_response['message']], $planning_response['message'], $auth);
        }
        $planning = $planning_response['result'];
        
        if($planning->berth_location_id != $inputs['origin_location_id']) {
            $message = "The provided berth doesn't belongs to this planning id. Please provide correct information.";
            return $this->sendError([$message], $message, $auth);
        }
        
        //Validate truck id
        $planned_truck_response = $ObjBtopPlanningRepository->getPlannedTrucksByPlanningId($inputs);
        if ($planned_truck_response['status'] == false) {
            return $this->sendError($planned_truck_response['message'], $planned_truck_response['message'], $auth);
        } else if($planned_truck_response['result']->isEmpty()) {
            $message = "The given truck doesn't belongs to this planning. Please provide correct information.";
            return $this->sendError([$message], $message, $auth);
        }
        
        //Validate consignee id
        $planning_detail_response = $ObjBtopPlanningRepository->getPlanningDetailsPlanningId($inputs);
        if ($planning_detail_response['status'] == false) {
            return $this->sendError($planning_detail_response['message'], $planning_detail_response['message'], $auth);
        } else if($planning_detail_response['result']->isEmpty()) {
            $message = "The given consignee or plot does't belongs to this planning";
            return $this->sendError([$message], $message, $auth);
        }
        
        //Validate challan
        $inputs['status'] = '1'; //unload pending
        $challan_response = $this->challanRepository->getFilteredChallans($inputs);
        if ($challan_response['status'] == false) {
            return $this->sendError(['Some error occured'], 'Some error occured', $auth);
        } else {
            if (!$challan_response['result']->isEmpty()) {
                $message = 'Challan is already created for this trip';
                return $this->sendError([$message], $message, $auth);
            } else {
                //Insert Challan
                $challan_input['connection'] = $auth['connection'];
                $challan_input['btop_planning_id'] = $inputs['planning_id'];
                $challan_input['origin_location_id'] = $inputs['origin_location_id'];
                $challan_input['destination_location_id'] = $inputs['destination_location_id'];
                $challan_input['truck_id'] = $inputs['truck_id'];
                $challan_input['shift_id'] = $inputs['shift_id'];
                $challan_input['cargo_id'] = $planning->cargo_id;
                $challan_input['consignee_id'] = $inputs['consignee_id'];
                $challan_input['challan_no'] = date('Ymd').rand(100,100000);
                $challan_input['type'] = '1'; //btop
                $challan_input['status'] = '1'; //unload pending
                $challan_input['is_deposit'] = '0'; //not reconciled
                $challan_input['is_scanned'] = '0';
                $challan_input['created_by'] = $challan_input['loaded_by'] = $auth['user_id'];
                $challan_input['loaded_at'] = date('Y-m-d H:i:s');
                
                //Barcode Generation
                $ObjBarcodeService = new BarcodeService();
                $barcode_response = $ObjBarcodeService->generate($challan_input, $auth);
                if($barcode_response['status'] == true && !empty($barcode_response['barcode_path'])) {
                    $challan_input['barcode_path'] = $barcode_response['barcode_path'];
                } else {
                    $message = "Unable to generate barcode. Please try again.";
                    return $this->sendError([$message], $message, $auth);
                }
                
                //PDF Generation and Update
                $pdf_response = $this->pdfService->createPdf($challan_input, $planning, $organization, $origin, $destination, $auth);
                if($pdf_response['status'] == true) {
                    $challan_input['pdf_path'] = $pdf_response['pdf_path'];
                } else {
                    $message = "Unable to generate challan. Please try again.";
                    return $this->sendError([$message], $message, $auth);
                }
                //Insert Challan In DB
                $challan_result = $this->challanRepository->saveChallan($challan_input);
                if($challan_result['status'] == false) {
                    return $this->sendError(['Error occured in updating challan data'], 'Error occured in updating challan data', $auth);
                }
                
                //Update Status of Truck
                $truck_inputs = ['connection' => $auth['connection'], 'truck_id' => $inputs['truck_id'], 'user_id' => $auth['user_id'], 'planning_id' => $inputs['planning_id']];
                $truck_response = $this->btopPlannedTruckRepository->updateStatusAsLoaded($truck_inputs);
                if($truck_response['status'] == false) {
                    return $this->sendError(['Error occured in updating truck status'], 'Error occured in updating truck status', $auth);
                }
                
                $challan = $challan_result['result'];
                $response_data = $pdf_response['data'];
                $response_data['challan'] = ['id' => $challan->id, 'challan_no' => $challan->challan_no];
                $response_data['barcode_path'] = url('/').'/'.$challan_input['barcode_path'];
                $response_data['pdf_path'] = url('/').'/'.$challan_input['pdf_path'];
                $response_data['planning_id'] = $planning->id;
                $response_data['date_from'] = $planning->date_from;
                $response_data['date_to'] = $planning->date_to;
                return $this->sendResponse($response_data, "Challan generated successfully", $auth);
            }
        }
    }
}
