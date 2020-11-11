<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Vessel\VesselRepository;
use App\Repositories\Dashboard\DashboardRepository;
use App\Services\CargoService;
use App\Repositories\Consignee\ConsigneeRepository;
use App\Repositories\Shift\ShiftRepository;

class DashboardController extends BaseController
{
    protected $cargoService;
    protected $vesselRepository;
    protected $consigneeRepository;

    public function __construct(CargoService $cargoService, VesselRepository $vesselRepository, ConsigneeRepository $consigneeRepository, DashboardRepository $dashboardRepository, ShiftRepository $shiftRepository)
    {
        $this->cargoService         = $cargoService;
        $this->vesselRepository     = $vesselRepository;
        $this->consigneeRepository     = $consigneeRepository;
        $this->dashboardRepository     = $dashboardRepository;
        $this->shiftRepository      = $shiftRepository;
    }
    /*
		Author : Ashish Barick
		Purpose : This function is returning data  Like list of Vessel, Cargo and Customer for Dashboard page
    */
    public function show(Request $request)
    {
        $dataArr = array();
        $allInput                   = $request->all();
        $param                    = $this->getAuth($allInput);
        $allInput['connection']   = $param['connection'];
        $param['view']               = 'home';
        $dataArr[]                   = $this->vesselRepository->getAllVessel($param);
        $dataArr[]                   = $this->cargoService->getAllCargos($param);
        $dataArr[]                   = $this->consigneeRepository->getAllConsignees($allInput);
        $dataArr[]                = $this->shiftRepository->getShifts($param);
        /*if($dataArr['status'] == false){
           return $this->sendError($dataArr,'No record found !!!', $param);
        }*/
        return $this->sendResponse($dataArr, 'Dashboard data fetched sucessfully', $param);
    }

    /*
		Author : Ashish Barick
		Purpose : This function is returning data for Dashboard boxes 
    */

      /**
     * @OA\Post(
     * path="/dashboard",
     * summary="Dashboard Details",
     * description="Pass Dashboard request parameters",
     * tags={"Dashboard Details"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     * required=true,
     * description="Pass Dashboard request parameters",
     * @OA\JsonContent(
     * required={"date","vessel","customer","cargo"},
     * @OA\Property(property="date", type="string", format="date", example="10/21/2020"),
     * @OA\Property(property="vessel",type="array", collectionFormat="multi",@OA\Items(type="string",example="'all',1,2,3")),
     * @OA\Property(property="customer",type="array",collectionFormat="multi",@OA\Items(type="string",example="'all',1,2,3")),
     *@OA\Property(property="cargo",type="array",collectionFormat="multi",@OA\Items(type="string",example="'all',1,2,3")),
     *          )
     *     ),
     *  @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     * )
     */
    public function fetchDetails(Request $request)
    {
        $allInput                 = $request->all();
        //dd($allInput);
        $param                  = $this->getAuth($allInput);
        $allInput['connection'] = $param['connection'];
        $response = $this->dashboardRepository->getDetails($allInput);
        if ($response['status'] == false) {
            return $this->sendError($response, 'Something wen\'t wrong', $param);
        }
        return $this->sendResponse($response, "Data fetched successfully.", $param);
    }
}
