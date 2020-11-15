<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\TruckCompany\TruckCompanyRepository;
use App\Http\Requests\TruckCompanyFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TruckCompanyController extends BaseController
{
    protected $truckCompanyRepository;

    public function __construct(TruckCompanyRepository $truckCompanyRepository)
    {
        $this->truckCompanyRepository = $truckCompanyRepository;
    }
    /**
    * @OA\GET(
    *   path="/truck-company",
    *   tags={"Trucking Company"},
    *   summary="Get list of truck companies",
    *   description="Returns list of truck companies",
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
    public function index(Request $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);
        $param['view'] = 'truck-companies.index';
        $truckCompany = $this->truckCompanyRepository->getAllTruckCompanies($param);
        $truckCompany['privileges'] =   isset($allInput['privilege_array']) ? $allInput['privilege_array'] : "";
        if(!$truckCompany['status']) {
            return $this->sendError($truckCompany, 'No record found !!!', $param);
        }
        return $this->sendResponse($truckCompany, $truckCompany['message'], $param);
    }
    /**
     * @OA\POST(
     ** path="/truck-company",
     *  tags={"Trucking Company"},
     *  summary="Trucking Company",
     *  @OA\RequestBody(
     *  required=true,
     *  description="Pass trucking company details",
     *  @OA\JsonContent(
     *  required={"name","email","mobile_no","contact_name","contact_mobile_no"},
     *  @OA\Property(property="name", type="string", format="text", example="ABC"),
     *  @OA\Property(property="email", type="string", format="email", example="test@gmail.com"),
     *  @OA\Property(property="mobile_no", type="string", format="number", example="7764893290"),
     *  @OA\Property(property="contact_name", type="string", format="text", example="test"),
     *  @OA\Property(property="contact_mobile_no", type="string", format="number", example="7764893290"),
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
    public function store(TruckCompanyFormRequest $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput); //in post you will need to pass like $this->getAuth($request->all());
        $allInput['created_by'] = $param['user_id'];
        $allInput['connection'] = $param['connection'];
        $response = $this->truckCompanyRepository->saveTruckCompany($allInput);
        if (!$response['status']) {
            return $this->sendError($response, $response['message'], $param);
        }
        return $this->sendResponse([], $response['message'], $param);
    }
    /**
     * @OA\GET(
     ** path="/truck-company/{id}",
     *  tags={"Trucking Company"},
     *  summary="Trucking Company",
     *  @OA\Parameter(
     *    description="ID of Trucking Company",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="1",
     *  @OA\Schema(
     *    type="integer",
     *    format="int64"
     * )
     * ),
     * @OA\Response(
     *  response=200,
     *  description="Success",
     *  @OA\MediaType(
     *  mediaType="application/json",
     *  )
     *  ),
     * security={{ "apiAuth": {} }}
     *)
     */  
    public function edit(TruckCompanyFormRequest $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput); //in post you will need to pass like $this->getAuth($request->all());
        $allInput['connection'] = $param['connection'];
        $allInput['id'] = $request->id;
        $response = $this->truckCompanyRepository->editTruckCompany($allInput);
        if(!$response['status']) {
            return $this->sendError($response, $response['message'], $param);
        }
        return $this->sendResponse($response['result'], $response['message'], $param);
    }
    /**
     * @OA\PUT(
     ** path="/truck-company/{id}",
     *  tags={"Trucking Company"},
     *  summary="Trucking Company",
     * @OA\Parameter(
     *    description="ID of Trucking Company",
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
     *  description="Update trucking details",
     *  @OA\JsonContent(
     *  required={"id","name","email","mobile_no","contact_name","contact_mobile_no"},
     *  @OA\Property(property="id", type="integer", format="int", example=1),
     *  @OA\Property(property="name", type="string", format="text", example="ABC"),
     *  @OA\Property(property="email", type="string", format="email", example="test@gmail.com"),
     *  @OA\Property(property="mobile_no", type="string", format="number", example="8686868687"),
     *  @OA\Property(property="contact_name", type="string", format="text", example="test name"),
     *  @OA\Property(property="contact_mobile_no", type="string", format="number", example="8686868686"),
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
    public function update(TruckCompanyFormRequest $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput); //in post you will need to pass like $this->getAuth($request->all());
        $allInput['updated_by'] = $param['user_id'];
        $allInput['connection'] = $param['connection'];
        $response = $this->truckCompanyRepository->updateTruckCompany($allInput);
        if (!$response['status']) {
            return $this->sendError($response, $response['message'], $param);
        }
        return $this->sendResponse([], $response['message'], $param);
    }
    /**
     * @OA\DELETE(
     ** path="/truck-company/{id}",
     *  tags={"Trucking Company"},
     *  summary="Trucking Company",
     *  @OA\Parameter(
     *    description="ID of Trucking Company",
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
    public function delete(TruckCompanyFormRequest $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput); //in post you will need to pass like $this->getAuth($request->all());
        $allInput['connection'] = $param['connection'];
        $allInput['id'] = $request->id;
        $response =  $this->truckCompanyRepository->deleteTruckCompany($allInput);
        if (!$response['status']) {
            return $this->sendError($response, $response['message'], $param);
        }
        return $this->sendResponse([], $response['message'], $param);
    }
}
