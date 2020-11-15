<?php

namespace App\Repositories\User;

use App\Models\User;
use Exception;
use Log;

class UserRepository
{
    public $catchErrorMsg = 'Something Went Wrong';
    /**
     * Get User Details By Id
     * @param  string $currentUserId
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserByUserId($userId)
    {
        try {
            $userArray = User::where('id', $userId)->first();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
        unset($userArray);
        return $userArray;
    }

    /**
     * @description Get all users
     * @author
     * @param array ['user_id','user_auth','browser','connection','cache_array','view'] 
     * @return array ['status','message','result']
     */
    public function getUsers($inputs)
    {
        global  $catchErrorMsg;
        $response['status'] = true;
        try {
            $users = new User();
            $users->setConnection($inputs['connection']);
            $users = $users::with('department')->with('userRole');
            if (isset($inputs['id']) && !empty($inputs['id'])) {
                $users = $users->where('id', $inputs['id']);
            }
            $users = $users->get();
            $response['result'] = $users;
            $response['message'] = 'Users fetched successfully';
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['status'] = false;
            $response['result'] = $e->getMessage();
            $response['message'] = $catchErrorMsg;
        }
        unset($users);
        return $response;
    }

    /**
     * @description Get user for department
     * @author
     * @param integer $field department id
     * @param array $value ['id',user_array','user_id','connection'] 
     * @return array ['status','message','result']
     */
    public function getUser($inputs)
    {
        global  $catchErrorMsg;
        $response['status'] = true;
        try {
            $user = new User();
            $user->setConnection($inputs['connection']);
            if (isset($inputs['id']) && !empty($inputs['id'])) {
                $user = $user->where('id', $inputs['id']);
            }
            if (isset($inputs['email']) && !empty($inputs['email'])) {
                $user = $user->where('email', $inputs['email']);
            }
            $user = $user->firstOrFail();
            $response['result'] = $user;
            $response['message'] = 'Users information fetched successfully';
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['status'] = false;
            $response['result'] = $e->getMessage();
            $response['message'] = $catchErrorMsg;
        }
        unset($user);
        return $response;
    }
    
    //Store or Update User Details
    public function saveUser($inputs) {
        global  $catchErrorMsg;
        $response['status'] = true;
        try {
            $user = new User();
            $user->setConnection($inputs['connection']);
            
            if (isset($inputs['id']) && !empty($inputs['id'])) {
                $user = $user->where('id', $inputs['id'])->first();
            }
            
            if(isset($inputs['first_name'])) {
                $user->first_name = $inputs['first_name'];
            }
            if(isset($inputs['last_name'])) {
                $user->last_name = $inputs['last_name'];
            }
            if(isset($inputs['email'])) {
                $user->email = $inputs['email'];
            }
            if(isset($inputs['mobile_no'])) {
                $user->mobile_no = $inputs['mobile_no'];
            }
            if(isset($inputs['address1'])) {
                $user->address1 = $inputs['address1'];
            }
            if(isset($inputs['address2'])) {
                $user->address2 = $inputs['address2'];
            }
            if(isset($inputs['department_id'])) {
                $user->department_id = $inputs['department_id'];
            }
            if(isset($inputs['role_id'])) {
                $user->role_id = $inputs['role_id'];
            }
            if(isset($inputs['department_id'])) {
                $user->department_id = $inputs['department_id'];
            }
            if(isset($inputs['city_id'])) {
                $user->city_id = $inputs['city_id'];
            }
            if(isset($inputs['state_id'])) {
                $user->state_id = $inputs['state_id'];
            }
            if(isset($inputs['pin_code'])) {
                $user->pin_code = $inputs['pin_code'];
            }
            if(isset($inputs['country_id'])) {
                $user->country_id = $inputs['country_id'];
            }
            if(isset($inputs['activated_at'])) {
                $user->activated_at = $inputs['activated_at'];
            }
            if(isset($inputs['is_active'])) {
                $user->is_active = $inputs['is_active'];
            }
            if(isset($inputs['password'])) {
                $user->password = $inputs['password'];
            }
            if(isset($inputs['hash_passcode'])) {
                $user->hash_passcode = $inputs['hash_passcode'];
            }
            if(isset($inputs['created_by'])) {
                $user->created_by = $inputs['created_by'];
            }
            if(isset($inputs['updated_at'])) {
                $user->updated_at = $inputs['updated_at'];
            }
            if(isset($inputs['updated_by'])) {
                $user->updated_by = $inputs['updated_by'];
            }
            
            if($user->save()) {
                $response['message'] = 'User updated successfully';
                $response['result'] = $user;
            } else {
                $response['status'] = false;
                $response['message'] = 'Unable update User data';
            }
            
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['result'] = $e->getMessage();
            $response['message'] = $catchErrorMsg;
        }
        unset($user);
        return $response;
    }

    public function checkIfEmailExist($data)
    {
        global  $catchErrorMsg;
        $fetch['status'] = false;
        $fetch['result'] = "User Doesn't Exist";
        try {
            $user = User::where('email',$data['email'])->firstOrFail();
            if(!empty($user))
            {
                $fetch['user'] = $user;
                $fetch['status'] = true;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $fetch['status'] = false;
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = $catchErrorMsg;
        }
        unset($user);
        return $fetch;
    }

    /*@Description : To save user profile image path in to users table
    * @author : Ashish Barick
    * @param : $allInput : Having parameters like connection,user_id,image_path etc..
    * @return : Bool(true/false)
    */
    public function saveProfileImage($allInput)
    {
        global  $catchErrorMsg;
        $fetch['status'] = true;
        try{
            $user = new User();
            $user->setConnection($allInput['connection']);
            $user = $user->find($allInput['user_id']);
            if($user) // Here first to validate if user_id exist
            {
                $user->image_path = $allInput['image_path'];
                $user->updated_by = $allInput['user_id'];
                if( $user->save()) 
                {
                    $fetch['message'] = "Profile image data saved successfully";
                }
                else
                {
                    $fetch['status'] = false;
                    $fetch['message'] = "Unable to save Image data ";
                }
            }
        }catch (Exception $e) {
            Log::error($e->getMessage());            
            $fetch['status'] = false;
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = $catchErrorMsg;
        }
        unset($user);
        return $fetch;
    }
}
