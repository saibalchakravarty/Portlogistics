<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\UserRole\UserRoleRepository;
use App\Http\Requests\UserRoleRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use Log;

class UserRoleController extends BaseController {
    
    protected $userRoleRepository;
    
    public function __construct(UserRoleRepository $userRoleRepository){
        $this->userRoleRepository = $userRoleRepository;
    }
    
    /**
    * @OA\POST(
    *   path="/roles",
    *   tags={"User"},
    *   summary="Get list of user roles",
    *   description="Returns list of user roles",
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
        $inputs = $request->all();
        $auth  = $this->getAuth($inputs);
        if(isset($inputs['id']) && !empty($inputs['id'])) {
            $auth['id'] = $inputs['id'];
        }
        $response = $this->userRoleRepository->getRoles($auth);
        if(!$response['status'] ){
           return $this->sendError($response,'No record found !!!', $auth);
        }
        return $this->sendResponse($response['result'],$response['message'], $auth);
    }
    
    /**
    * @OA\GET(
    *   path="/role",
    *   tags={"Role"},
    *   summary="Get list of Roles",
    *   description="Returns list of Roles",
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
    public function getRole(Request $request)
    {
        $dataArr = array();
        $allInput       = $request->all();
        $param          = $this->getAuth($allInput);
        $param['view']  = 'rolePrivileges.index';
        $role           = $this->userRoleRepository->getRolesForPriviliges($param);
        $menuPrivilege  = $this->userRoleRepository->getAllMenuPrivilegesList($param);
        $dataArr[] =  $role;
        $dataArr[] =  $menuPrivilege;
        $dataArr['privileges'] =  isset( $allInput['privilege_array'] )? $allInput['privilege_array'] : "";

        if(!$role['status'] ){
           return $this->sendError($dataArr,'No record found !!!', $param);
        }
        return $this->sendResponse($dataArr,'Role data fetch sucessfully', $param);
    }
    /**
     * @OA\Post(
     ** path="/role",
     *  tags={"Role"},
     *  summary="Role",
     *  @OA\RequestBody(
     *  required=true,
     *  description="Pass role details",
     *  @OA\JsonContent(
     *  required={"name"},
     *  @OA\Property(property="name", type="string", format="text", example="ADMIN")
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
    public function storeRole(UserRoleRequest $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth( $allInput);
        $allInput['created_by'] = $param['user_id'];
        $allInput['connection'] = $param['connection'];
        $response = $this->userRoleRepository->store($allInput);
        if(!$response['status']){
            return $this->sendError($response,$response['message'],$param);
        }
        return $this->sendResponse([],$response['message'],$param);  
    }
     /**
     * @OA\Put(
     ** path="/role/{id}",
     *  tags={"Role"},
     *  summary="Role",
     *  description="Update role details",
     *  @OA\Parameter(
     *    description="ID of role",
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
     *  description="update role details",
     *  @OA\JsonContent(
     *  required={"name"},
     *  @OA\Property(property="name", type="string", format="text", example="Iron")
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
    public function updateRole(UserRoleRequest $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);
        $allInput['updated_by'] = $param['user_id'];
        $allInput['connection'] = $param['connection'];
        $allInput['id'] = $request->id;
        $response = $this->userRoleRepository->update($allInput);
        if(!$response['status']){
            return $this->sendError($response,$response['message'],$param);
        }
        return $this->sendResponse([],$response['message'],$param);           
    }
    /**
     * @OA\Delete(
     ** path="/role/{id}",
     *  tags={"Role"},
     *  summary="Role",
     *  description="Delete role details",
     *  @OA\Parameter(
     *    description="ID of role",
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
    public function destroyRole(UserRoleRequest $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);//in post you will need to pass like $this->getAuth($request->all());
        $allInput['connection'] = $param['connection'];
        $allInput['id'] = $request->id;
        $response = $this->userRoleRepository->destroy($allInput);
        if(!$response['status'] ){
            return $this->sendError($response,$response['message'],$param);
        }
        return $this->sendResponse([],$response['message'],$param);          
    }
     /**
     * @OA\Get(
     ** path="/role/{id}",
     *  tags={"Role"},
     *  summary="Role",
     *  description="Edit role details",
     *  @OA\Parameter(
     *    description="ID of role",
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
    public function editRole(UserRoleRequest $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput); //in post you will need to pass like $this->getAuth($request->all());
        $allInput['connection'] = $param['connection'];
        $allInput['id'] = $request->id;
        $response = $this->userRoleRepository->edit($allInput);
        if(!$response['status']){
            return $this->sendError($response,'Record not found',$param);
        }
        return $this->sendResponse($response['result'],$response['message'],$param);
    }
    
}