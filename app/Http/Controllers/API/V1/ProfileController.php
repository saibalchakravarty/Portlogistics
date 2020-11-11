<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangeNameRequest;
use App\Http\Requests\ImageUploadRequest;
use App\Repositories\User\UserRepository;
use App\Traits\CustomTrait;
use App\Services\ImageUploadService;
use Config;
class ProfileController extends BaseController {
    
    use CustomTrait;
    protected $userRepository;
    protected $imageUploadService;
    
    public function __construct(UserRepository $userRepository, ImageUploadService $imageUploadService) {
        $this->userRepository = $userRepository;
        $this->imageUploadService = $imageUploadService;
    }
    
    public function index(Request $request) {
        return view('profile.index');
    }
    
    public function updateName(ChangeNameRequest $request) {
        $inputs = $request->all();
        $auth = $this->getAuth($inputs);
        $data['connection'] = $auth['connection'];
        $data['id'] = $auth['user_id'];
        $data['first_name'] = $inputs['first_name'];
        $data['last_name'] = $inputs['last_name'];
        $data['updated_by'] = $auth['user_id'];
        $data['updated_at'] = date("Y-m-d H:i:s");
        $user = $this->userRepository->saveUser($data);
        if(!$user) {
            return $this->sendError('Something went wrong','Something went wrong',$auth);
        }
        //Update Auth Values
        if(isset(Auth::user()->auth_browser)) {
            Auth::user();
        }
        return $this->sendResponse($user['result'],"Name updated successfully",$auth);
    }
    
    public function updatePassword(ChangePasswordRequest $request) {
        $status = $this->validateCurrentPassword($request);
        $inputs = $request->all();
        $auth = $this->getAuth($inputs);
        if($status == 'false') {
            return $this->sendError('Current password entered is incorrect','Current password entered is incorrect',$auth);
        }
        $data['connection'] = $auth['connection'];
        $data['id'] = $auth['user_id'];
        $data['password'] = Hash::make($inputs['new_password']);
        $data['hash_passcode'] = $this->getHashPassCode($inputs['new_password']);
        $data['updated_by'] = $auth['user_id'];
        $data['updated_at'] = date("Y-m-d H:i:s");
        $user = $this->userRepository->saveUser($data);
        if(!$user) {
            return $this->sendError($user,'Something went wrong',$auth);
        }
        //Update Auth Values
        if(isset(Auth::user()->auth_browser)) {
            Auth::user();
        }
        return $this->sendResponse($user,"Password updated successfully",$auth);
    }
    
    public function validateCurrentPassword(Request $request) {
        $status = 'false';
        if($request->has('old_password')) {
            $inputs = $request->all();
            $auth = $this->getAuth($inputs);
            if(Hash::check($inputs['old_password'], $auth['user_auth']->password)) {
                $status = 'true';
            } else {
                $status = 'false';
            }
        } else {
            $status = 'false';
        }
        return $status;
    }
    /*
    * Author : Ashish Barick
    * @param : Upload Profile Image
    * Created_at : 10/09/2020 
    */
    public function profileImageUpload(ImageUploadRequest  $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);//in post you will need to pass like 
        $allInput['updated_by']         = $param['user_id'];
        $allInput['user_id']            = $param['user_id'];
        $allInput['connection']         = $param['connection'];
        $allInput['organization_id']    = $param['user_auth']['organization_id'];
        $allInput['last_image']         = $param['user_auth']['image_path'];
        $allInput['image_upload']       = Config::get('filesystems.image_upload');
        $response =  $this->imageUploadService->customImageUpload($allInput);
        if($response['status'] == false){
            return $this->sendError($response,$response['message'],$param);
        }
        return $this->sendResponse([],$response['message'],$param);
    }
}