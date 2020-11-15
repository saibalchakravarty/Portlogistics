<?php

namespace App\Http\Controllers\API\V1;
use App\Http\Requests\ConsigneeFormRequest;
use App\Repositories\Consignee\ConsigneeRepository;
use Illuminate\Http\Request;

class ConsigneeController extends BaseController
{
    protected $consigneeRepository;
    public function __construct(ConsigneeRepository $consigneeRepository){
        $this->consigneeRepository = $consigneeRepository;
    }
    /**
    * @OA\Get(
    *   path="/consignee",
    *   tags={"Consignee"},
    *   summary="Get list of consignees",
    *   description="Returns list of consignees",
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
    public function index(Request $request){
        $allInput = $request->all();
        $param  = $this->getAuth($allInput); //in post you will need to pass like $this->getAuth($request->all());
        $allInput['connection'] = $param['connection'];
        $param['view'] = 'consignee.index';
        $response = $this->consigneeRepository->getAllConsignees($allInput);
        $response['privileges'] =   isset( $allInput['privilege_array'] )? $allInput['privilege_array'] : "";
        if(!$response['status']){
           return $this->sendError($response,$response['message'], $param);
        }
        return $this->sendResponse($response,$response['message'], $param);
    }
     /**
     * @OA\Post(
     ** path="/consignee",
     *  tags={"Consignee"},
     *  summary="Consignee",
     *  @OA\RequestBody(
     *  required=true,
     *  description="Pass consignee details",
     *  @OA\JsonContent(
     *  required={"name","description"},
     *  @OA\Property(property="name", type="string", format="text", example="Tata Power"),
     *  @OA\Property(property="description", type="string", format="text", example="Tata Power"),
     *  ),
     * ),
     *  @OA\Response(
     *  response=200,
     *  description="Success",
     *  @OA\MediaType(
     *  mediaType="application/json",
     *  )
     *  ),
     *  security={{ "apiAuth": {} }}
     *  )
     */
    public function store(ConsigneeFormRequest $request){
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);
        $allInput['created_by'] = $param['user_id'];
        $allInput['connection'] = $param['connection'];
        $existName = $this->consigneeRepository->checkUniqueConsigneeName($allInput);
        if(!$existName['status']){
            return $this->sendError($existName['data'],$existName['message'],$param);
        }   
        $response = $this->consigneeRepository->storeConsignee($allInput);
        if(!$response['status']){
            return $this->sendError($response['data'],$response['message'],$param);
        }
        return $this->sendResponse($response['data'],$response['message'],$param);    
    }
    /**
     * @OA\Delete(
     ** path="/consignee/{id}",
     *  tags={"Consignee"},
     *  summary="Consignee",
     *  description="Delete consignee details",
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
    public function destroy(ConsigneeFormRequest $request){
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);
        $allInput['id'] = $request->id;
        $allInput['connection'] = $param['connection'];
        $existId = $this->consigneeRepository->checkExistsConsigneeById($allInput);   
        if(!$existId['status']){
            return $this->sendError($existId['data'],$existId['message'],$param);
        }
        $response = $this->consigneeRepository->deleteConsigneeById($allInput);
        if(!$response['status']){
            return $this->sendError($response['data'],$response['message'],$param);
        }
        return $this->sendResponse($response['data'],$response['message'],$param);    
    }
    /**
     * @OA\Get(
     ** path="/consignee/{id}",
     *  tags={"Consignee"},
     *  summary="Consignee",
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
    public function show(ConsigneeFormRequest $request){
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);
        $allInput['id'] = $request->id;
        $allInput['connection'] = $param['connection'];
        $response = $this->consigneeRepository->getConsigneeById($allInput);
        if(!$response['status']){
            return $this->sendError($response['data'],$response['message'],$param);
        }
        return $this->sendResponse($response['data'],$response['message'],$param);    
    }
    /**
     * @OA\Put(
     ** path="/consignee/{id}",
     *  tags={"Consignee"},
     *  summary="Consignee",
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
     *  description="Update consignee details",
     *  @OA\JsonContent(
     *  required={"name","description"},
     *  @OA\Property(property="name", type="string", format="text", example="Tata Power"),
     *  @OA\Property(property="description", type="string", format="text", example="Tata power"),
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
    public function update(ConsigneeFormRequest $request){
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);   
        $allInput['updated_by'] = $param['user_id'];
        $allInput['connection'] = $param['connection'];
        $existId = $this->consigneeRepository->checkExistsConsigneeById($allInput);
        if(!$existId['status']){
            $send = $this->sendError($existId['data'],$existId['message'],$param);
        }
        $existName = $this->consigneeRepository->checkUniqueConsigneeName($allInput);
        if(!$existName['status']){
            $send = $this->sendError($existName['data'],$existName['message'],$param);
        } 
        $response = $this->consigneeRepository->updateConsigneeById($allInput);
        if(!$response['status']){
            $send = $this->sendError($response['data'],$response['message'],$param);
        }
        if($response['status']){
            $send = $this->sendResponse($response['data'],$response['message'],$param);
        }
        return $send;    
    }
    
}
