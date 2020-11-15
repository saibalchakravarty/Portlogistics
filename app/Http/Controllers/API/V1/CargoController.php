<?php

namespace App\Http\Controllers\API\V1;
use App\Services\CargoService;
use App\Http\Requests\CargoFormRequest;
use Illuminate\Http\Request;
use Validator;
use Crypt;
class CargoController extends BaseController
{
    protected $cargoService;
    public function __construct(CargoService $cargoService){
        $this->cargoService = $cargoService;
    }

    /**
    * @OA\GET(
    *   path="/cargo",
    *   tags={"Cargo"},
    *   summary="Get list of cargos",
    *   description="Returns list of cargos",
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
    public function getAllCargo(Request $request){
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);
        $param['view'] = 'cargo.index';
        $cargo = $this->cargoService->getAllCargos($param);
        $cargo['privileges'] = isset( $allInput['privilege_array'] )? $allInput['privilege_array'] : "";
        if(!$cargo['status']){
           return $this->sendError($cargo,'No record found !!!', $param);
        }
        return $this->sendResponse($cargo,'Cargo data fetch sucessfully', $param);
    }

    /**
     * @OA\Post(
     ** path="/cargo",
     *  tags={"Cargo"},
     *  summary="Cargo",
     *  @OA\RequestBody(
     *  required=true,
     *  description="Pass cargo details",
     *  @OA\JsonContent(
     *  required={"name","instruction"},
     *  @OA\Property(property="name", type="string", format="text", example="Aluminium"),
     *  @OA\Property(property="instruction", type="string", format="text", example="Handle with care"),
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
    public function store(CargoFormRequest $request){
        $allInput = $request->all();
        $param  = $this->getAuth($allInput); //in post you will need to pass like $this->getAuth($request->all());
        $allInput['created_by'] = $param['user_id'];
        $allInput['connection'] = $param['connection'];
        $response = $this->cargoService->saveCargo($allInput);
        if(!$response['status']){
            return $this->sendError($response,$response['message'],$param);
        }
        return $this->sendResponse([],$response['message'],$param);    
    }

    /**
     * @OA\Delete(
     ** path="/cargo/{id}",
     *  tags={"Cargo"},
     *  summary="Cargo",
     *  description="Delete cargo details",
     *  @OA\Parameter(
     *    description="ID of cargo",
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
    public function delete(CargoFormRequest $request){
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);//in post you will need to pass like $this->getAuth($request->all());
        $allInput['connection'] = $param['connection'];
        $allInput['id'] = $request->id;
        $response = $this->cargoService->deleteCargo($allInput);
        if(!$response['status']){
            return $this->sendError($response['result'],$response['message'],$param);
        }
        return $this->sendResponse($response['result'],$response['message'],$param);    
    }
    
     /**
     * @OA\Get(
     ** path="/cargo/{id}",
     *  tags={"Cargo"},
     *  summary="Cargo",
     *  description="Edit cargo details",
     *  @OA\Parameter(
     *    description="ID of consignee",
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
    public function edit(CargoFormRequest $request){
        $allInput = $request->all();
        $param  = $this->getAuth($allInput); //in post you will need to pass like $this->getAuth($request->all());
        $allInput['connection'] = $param['connection'];
        $allInput['id'] =$request->id;
        $response = $this->cargoService->editCargo($allInput);
        if(!$response['status']){
            return $this->sendError($response['result'],$response['message'],$param);
        }
        return $this->sendResponse($response['result'],$response['message'],$param);    
    }
    
    /**
     * @OA\Put(
     ** path="/cargo/{id}",
     *  tags={"Cargo"},
     *  summary="Cargo",
     *  description="Update cargo details",
     *  @OA\Parameter(
     *    description="ID of consignee",
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
     *  description="update cargo details",
     *  @OA\JsonContent(
     *  required={"name","instruction"},
     *  @OA\Property(property="name", type="string", format="text", example="Iron"),
     *  @OA\Property(property="instruction", type="string", format="text", example="Iron Ore"),
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
    public function update(CargoFormRequest $request){
        $allInput = $request->all();

        $param  = $this->getAuth($allInput); //in post you will need to pass like $this->getAuth($request->all());
        $allInput['updated_by'] = $param['user_id'];
        $allInput['connection'] = $param['connection'];
        $allInput['id'] = $request->id;
        $response = $this->cargoService->updateCargo($allInput);
        if(!$response['status']){
            return $this->sendError($response['result'],$response['message'],$param);
        }
        return $this->sendResponse($response['result'],$response['message'],$param);    
    }
}