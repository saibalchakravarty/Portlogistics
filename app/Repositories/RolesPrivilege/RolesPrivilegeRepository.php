<?php

namespace App\Repositories\RolesPrivilege;
use App\Models\Privilege;
use App\Models\RoleAcces;
use App\Models\User;
use App\Models\AccessList;
use Exception;
use Log;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use DB;
Class RolesPrivilegeRepository {
    public $catchErrorMsg = 'Something Went Wrong';
    public $noRecordMsg = 'No Record Found';
    /*
    * Author : Ashish Barick
    * Function : To save privileges to its respective Menu screen
    */
    public function store($allInput)
    {
        global $catchErrorMsg;
        global $noRecordMsg;
        $fetch['status'] =true;
        try 
        {
            $rolePrivilege = new RoleAcces();
            $rolePrivilege->setConnection($allInput['connection']);
            $rolePrivilege->where('user_role_id',$allInput['roleId'])->delete();
            
            $privilegeArr = implode(',',$allInput['privileges']);
            
            $privilegeArr = explode(',',$privilegeArr);
            
            $privilegeArr = array_values(array_unique($privilegeArr));
            foreach($privilegeArr as $privilege)
            {
                $rolePrivilege->create([
                    "user_role_id" =>$allInput['roleId'],
                    "access_id" =>$privilege,
                    "created_by" =>$allInput['created_by'],
                    "updated_by" =>$allInput['updated_by']
                ]);
            }
            if(!$rolePrivilege)
            {
                $fetch['status'] = false;
                $fetch['message'] = $noRecordMsg;                  
            }
            else{
                 $fetch['message'] = 'Roles & Privileges data saved successfully';
            }
        } catch (Exception $e) {
            $fetch['status'] = false;
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = $catchErrorMsg;
            Log::error($e->getMessage());
        }
        unset($rolePrivilege);
        return $fetch;
    }
    public function showPrivileges($allInput)
    {
        global $catchErrorMsg;
        global $noRecordMsg;
        $fetch['status'] =true;
        try{
            $rolePrivilege = new RoleAcces();
            $accessList = new AccessList();
            $accessList->setConnection($allInput['connection']);
            $rolePrivilege->setConnection($allInput['connection']);
            $rolePrivilege =  $rolePrivilege->select('access_id')
                                            ->whereNotIn('access_id',$accessList->select('id')->whereIn('hierarchy',['p','c'])->get()->toArray())
                                            ->where('user_role_id',$allInput['id'])
                                            ->get()->toArray();
            if(!$rolePrivilege)
            {
                $fetch['status'] = false;
                $fetch['message'] = $noRecordMsg;
            }
            else{
                 $fetch['message'] = 'Privileges data fetched  Successfully';    
                 $fetch['result'] =  $rolePrivilege;
            }
            
        }catch(Exception $e){
            $fetch['status'] =false;
            Log::error($e->getMessage());
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = $catchErrorMsg;
       }
       unset($rolePrivilege);
       return $fetch;
    }
}