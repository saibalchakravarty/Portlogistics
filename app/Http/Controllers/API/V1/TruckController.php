<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Truck\TruckRepository;
use App\Http\Requests\TruckFormRequest;
use App\Repositories\TruckCompany\TruckCompanyRepository;
use Config;

class TruckController extends BaseController
{
    protected $truckRepository,$truckCompanyRepository;
    public function __construct(TruckRepository $truckRepository,TruckCompanyRepository $truckCompanyRepository) {
        $this->truckRepository = $truckRepository;
        $this->truckCompanyRepository = $truckCompanyRepository;
    }

    /**
    * @OA\GET(
    *   path="/truck",
    *   tags={"Truck"},
    *   summary="Get list of trucks",
    *   description="Returns list of trucks",
    *   @OA\Response(
    *       response=200,
    *       description="Success",
    *       @OA\MediaType(
    *           mediaType="application/json",
    *        )
    *       ),
    *   security={{ "apiAuth": {} }}
    *     )
    */
    public function getAllTrucks(Request $request) 
    {
        $data['status'] = false;
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);        
        $param['view'] = 'truck.index';
        $trucks = $this->truckRepository->getAllTrucks($param);
        $trucking_company = $this->truckCompanyRepository->getAllTruckCompanies($param);
        if($trucks['status'] == true && $trucking_company['status'] == true)
        {
            $data['status'] = true;
            $data['trucks'] = $trucks['trucks'];
            $data['trucking_company'] = $trucking_company['truck_company'];
            $data['privileges'] =   isset( $allInput['privilege_array'] )? $allInput['privilege_array'] : "";
        }
        if($data['status'] == false){
           return $this->sendError($data,'No record found !!!', $param);
        }
        return $this->sendResponse($data,'Truck data fetch sucessfully', $param);
    }

    /**
     * @OA\POST(
     ** path="/truck",
     *  tags={"Truck"},
     *  summary="Truck",
     *  @OA\RequestBody(
     *  required=true,
     *  description="Pass truck details",
     *  @OA\JsonContent(
     *  required={"truck_no","truck_company_id"},
     *  @OA\Property(property="truck_no", type="string", format="text", example="DL2345"),
     *  @OA\Property(property="truck_company_id", type="integer", format="int", example=1),
     *  ),
     * ),
     *  @OA\Response(
     *  response=200,
     *  description="Success",
     *  @OA\MediaType(
     *  mediaType="application/json",
     *  )
     *  ),
     * security={{ "apiAuth": {} }}
     *)
     */
    public function storeTrucks(TruckFormRequest $request){ 
        
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);
        $allInput['created_by'] = $param['user_id'];
        $allInput['connection'] = $param['connection'];
        //dd($allInput);
        if($allInput['truck_company_id'] == null)
        {
            $allInput['truck_company_id'] = Config::get('constants.default_truck_company');;
        }
        $response = $this->truckRepository->saveTruck($allInput);
        if($response['status'] == false){
            return $this->sendError($response,$response['message'],$param);
        }
        return $this->sendResponse([],$response['message'],$param); 
    }

    /**
     * @OA\GET(
     ** path="/truck/{id}",
     *  tags={"Truck"},
     *  summary="Get Truck Details By Truck ID ",
     *   @OA\Parameter(
     *    description="ID of Truck",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="1",
     *  @OA\Schema(
     *    type="integer",
     *    format="int64"
     * )
     * ),
     *  @OA\Response(
     *  response=200,
     *  description="Success",
     *  @OA\MediaType(
     *  mediaType="application/json",
     *  )
     *  ),
     * security={{ "apiAuth": {} }}
     *)
     */
    public function editTrucks(TruckFormRequest $request){        
        $allInput = $request->all();        
        $param  = $this->getAuth($allInput); 
        $allInput['connection'] = $param['connection'];
        $allInput['id'] = $request->id;
        $response = $this->truckRepository->editTruck($allInput);

        if($response['status'] == false){
            return $this->sendError($response,'Record not found',$param);
        }
        return $this->sendResponse($response['result'],$response['message'],$param);
    }

    /**
     * @OA\PUT(
     ** path="/truck/{id}",
     *  tags={"Truck"},
     *  summary="Truck",
     *  @OA\Parameter(
     *    description="ID of Truck",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="1",
     *  @OA\Schema(
     *    type="integer",
     *    format="int64"
     * )
     * ),
     *  @OA\RequestBody(
     *  required=true,
     *  description="Update truck details by truck id",
     *  @OA\JsonContent(
     *  required={"id","truck_no","truck_company_id"},
     *  @OA\Property(property="id", type="integer", format="int", example=1),
     *  @OA\Property(property="truck_no", type="string", format="text", example="DL2345"),
     *  @OA\Property(property="truck_company_id", type="integer", format="int", example=1),
     *  ),
     * ),
     *  @OA\Response(
     *  response=200,
     *  description="Success",
     *  @OA\MediaType(
     *  mediaType="application/json",
     *  )
     *  ),
     * security={{ "apiAuth": {} }}
     *)
     */
    public function updateTrucks(TruckFormRequest $request){        
        $allInput = $request->all();
        $param  = $this->getAuth($allInput); 
        $allInput['updated_by'] = $param['user_id'];
        $allInput['connection'] = $param['connection'];
        $response = $this->truckRepository->updateTruck($allInput);
        if($response['status'] == false){
            return $this->sendError($response,$response['message'],$param);
        }
        return $this->sendResponse([],$response['message'],$param); 
    }

    /**
     * @OA\DELETE(
     ** path="/truck/{id}",
     *  tags={"Truck"},
     *  summary="Truck",
     *   @OA\Parameter(
     *    description="ID of Truck",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="1",
     *  @OA\Schema(
     *    type="integer",
     *    format="int64"
     * )
     * ),
     *  @OA\Response(
     *  response=200,
     *  description="Success",
     *  @OA\MediaType(
     *  mediaType="application/json",
     *  )
     *  ),
     * security={{ "apiAuth": {} }}
     *)
     */
    public function deleteTrucks(TruckFormRequest $request){        
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);
        $allInput['connection'] = $param['connection'];
        $allInput['id'] = $request->id;
        $response =  $this->truckRepository->deleteTruck($allInput);
        if($response['status'] == false){
            return $this->sendError($response,$response['message'],$param);
        }
        return $this->sendResponse([],$response['message'],$param);
    }
}
