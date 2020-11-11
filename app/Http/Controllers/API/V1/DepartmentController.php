<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Department\DepartmentRepository;
use App\Http\Requests\DepartmentRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use Log;

class DepartmentController extends BaseController {
    
    protected $departmentRepository, $userRepository;
    
    public function __construct(DepartmentRepository $departmentRepository, UserRepository $userRepository){
        $this->departmentRepository = $departmentRepository;
        $this->userRepository = $userRepository;
    }

    
    public function index(Request $request){
        $inputs = $request->all();
        $auth  = $this->getAuth($inputs);
        if(isset($inputs['id']) && !empty($inputs['id'])) {
            $auth['id'] = $inputs['id'];
        }
        $response = $this->departmentRepository->getDepartments($auth);
        if($response['status'] == false){
           return $this->sendError($response,'No record found !!!', $auth);
        }
        return $this->sendResponse($response['result'],'Records fetched sucessfully', $auth);
    }

    /**
    * @OA\GET(
    *   path="/department",
    *   tags={"Department"},
    *   summary="Get list of departments",
    *   description="Returns list of departments",
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
    public function getAllDepartments(Request $request){
        $inputs = $request->all();
        $auth  = $this->getAuth($inputs); 
        $auth['view'] = 'department.index';

        $response = $this->departmentRepository->getAllDepartments($auth);   
        $response['privileges'] = isset( $inputs['privilege_array'] )? $inputs['privilege_array'] : "";
        if ($response['status'] == false)

        {
            return $this->sendError($department,'No record found !!!', $auth);
        } else {
            return $this->sendResponse($response,'Department data fetch sucessfully', $auth);

        }
        //return view('department.index');
    }
    
    /**
     * @OA\Post(
     ** path="/department",
     *  tags={"Department"},
     *  summary="Department",
     *  @OA\RequestBody(
     *  required=true,
     *  description="Pass department details",
     *  @OA\JsonContent(
     *  required={"name","description"},
     *  @OA\Property(property="name", type="string", format="text", example="Management"),
     *  @OA\Property(property="description", type="string", format="text", example="Management"),
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
    public function storeDepartments(DepartmentRequest $request){ 
        
        $inputs = $request->all();
        $auth  = $this->getAuth($inputs);
        $inputs['created_by'] = $auth['user_id'];
        $inputs['connection'] = $auth['connection'];
        //dd($inputs);
        $response = $this->departmentRepository->store($inputs);
        if($response['status'] == false){
            return $this->sendError($response,'Something went wrong',$auth);
        }
        return $this->sendResponse([],$response['message'],$auth); 
    }
    
    /**
     * @OA\Get(
     ** path="/department/{id}",
     *  tags={"Department"},
     *  summary="Department",
     *  description="Edit department details",
     *  @OA\Parameter(
     *    description="ID of department",
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
    public function editDepartments(DepartmentRequest $request)
    {
        $inputs = $request->all();
        $auth  = $this->getAuth($inputs); 
        $inputs['connection'] = $auth['connection'];
        //@Author : Ashish Barick, changes : add $inputs['id'] = $request->id; for getting data from url
        $inputs['id'] = $request->id;
        $response = $this->departmentRepository->edit($inputs);
        if($response['status'] == false){
            return $this->sendError($response,'Record not found',$auth);
        }
        return $this->sendResponse($response['result'],$response['message'],$auth);
    }
    
    /**
     * @OA\Put(
     ** path="/department/{id}",
     *  tags={"Department"},
     *  summary="Department",
     *  description="Update cargo details",
     *  @OA\Parameter(
     *    description="ID of department",
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
     *  description="update department details",
     *  @OA\JsonContent(
     *  required={"name","description"},
     *  @OA\Property(property="name", type="string", format="text", example="Development"),
     *  @OA\Property(property="description", type="string", format="text", example="Developers Dept"),
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
    public function updateDepartments(DepartmentRequest $request)
    {   
        $inputs = $request->all();
        $auth  = $this->getAuth($inputs); 
        $inputs['updated_by'] = $auth['user_id'];
        $inputs['connection'] = $auth['connection'];
        //@Author : Ashish Barick, changes : add $inputs['id'] = $request->id; for getting data from url
        $inputs['id'] = $request->id;
        $response = $this->departmentRepository->update($inputs);
        if($response['status'] == false){
            return $this->sendError($response,'Something went wrong',$auth);
        }
        return $this->sendResponse([],$response['message'],$auth);
    }
    
    /**
     * @OA\Delete(
     ** path="/department/{id}",
     *  tags={"Department"},
     *  summary="Department",
     *  description="Delete department details",
     *  @OA\Parameter(
     *    description="ID of department",
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
    public function deleteDepartments(DepartmentRequest $request)
    {
        $inputs = $request->all();
        $auth  = $this->getAuth($inputs);
        $inputs['connection'] = $auth['connection'];
        //@Author : Ashish Barick, changes : add $inputs['id'] = $request->id; for getting data from url
        $inputs['id'] = $request->id;
        /* $validate_user = $this->userRepository->getUser('department_id', $inputs['id']);
        //dd($validate_user);
        if($validate_user != null)
        {
            return $this->sendError(['Sorry this department cannot be deleted.It has a user.'],'Sorry this department cannot be deleted.It has a user.',$auth);
        } This check is handle in the catch block of repository*/
        $response = $this->departmentRepository->destroy($inputs);
        if($response['status'] == false){
            return $this->sendError($response,'Something went wrong',$auth);
        }
        return $this->sendResponse([],$response['message'],$auth);   
    }
}

