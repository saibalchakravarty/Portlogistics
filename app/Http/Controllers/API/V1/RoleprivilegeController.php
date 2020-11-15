<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\RolesPrivilege\RolesPrivilegeRepository;
use Cache;
class RoleprivilegeController extends BaseController
{   
    protected $userRoleRepository;
    public function __construct(RolesPrivilegeRepository $rolesPrivilegeRepository)
    {
        $this->rolesPrivilegeRepository = $rolesPrivilegeRepository;
    }
    
    /*
    *Author : Ashish Barick
    * Function : Is to save privileges into role_privileges table
    * @param : Recieve Request parameter
    */
    public function savePrivileges(Request $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);//in post you will need to pass like $this->getAuth($request->all());
        $allInput['created_by'] = $param['user_id'];
        $allInput['updated_by'] = $param['user_id'];
        $allInput['connection'] = $param['connection'];
        $organizationId = $param['user_auth']['organization_id'];
        $userRoleId =  $allInput['roleId'];
        $key = 'roleCache-'.$organizationId.':'.$userRoleId;
        Cache::forget($key);
        $response = $this->rolesPrivilegeRepository->store($allInput);
        if(!$response['status'] ){
            return $this->sendError($response,$response['message'],$param);

        }
        return $this->sendResponse([],$response['message'],$param); 
    }
    public function getPrivileges(Request $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput); //in post you will need to pass like $this->getAuth($request->all());
        $allInput['connection'] = $param['connection'];
        $response = $this->rolesPrivilegeRepository->showPrivileges($allInput);
        if(!$response['status'] ){
            return $this->sendError($response,'Record not found',$param);
        }
        return $this->sendResponse($response['result'],$response['message'],$param);
    }
    
}
