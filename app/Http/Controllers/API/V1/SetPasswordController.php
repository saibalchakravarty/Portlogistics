<?php

namespace App\Http\Controllers\API\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Libraries\SendEmailLibrary;
use App\Models\User;
use App\Models\UserSendEmail;
use App\Traits\CustomTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SetPasswordController extends BaseController {
    
    use CustomTrait;
    protected $sendEmailLibrary;
    
    public function __construct(SendEmailLibrary $sendEmailLibrary) {
        $this->sendEmailLibrary = $sendEmailLibrary;
    }
    
    public function sendEmail(Request $request) {
        $request->validate(['email' => 'required|email']);
        $email = $request->input()['email'];
        $message = '';
        $status = '';
        $user = User::where('email', $email)->first();
        if(null != $user) {
            $data = ['user_id' => $user->id, 'name' => $user->first_name.' '.$user->last_name, 'template' => 'reset_password', 'email' => $email];
            $response = $this->sendEmailLibrary->modify($data);
            if($response['status'] == 'success') {
                $message = "An email with the password reset link has been sent to your email id. Please use the link to reset your password.";
                $status = 'success';
            } else {
                $message = "An error occured. Please try again.";
                $status = 'error';
            }
        } else {
            $message = "The user doesn't exist. Please contact the administrator.";
            $status = 'error';
        }
        return redirect()->back()->with($status, $message);
    }
    
    public function savePassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8'
        ]);
        $request->session()->flush();
        $inputs = $request->all();
        $message = '';
        $status = '';
        $userSendEmail = UserSendEmail::where('token', $inputs['token'])->first();
        if(null == $userSendEmail) {
            $message = 'The link is not valid';
            $status = 'error';
        } else {
            $diff = Carbon::parse($userSendEmail->updated_at)->diffInSeconds(Carbon::now());
            $user = User::where('id', $userSendEmail->user_id)->first();
            if($diff > config('constants.email_token_expiry_time')) {
                if(empty($user->password) && empty($user->hash_passcode)) {
                    $message = "The validity of the link has ended. Please contact the administrator.";
                    $status = 'error';
                } else {
                    $message = "The validity of the link has ended. Please reset you password again.";
                    $status = 'error';
                }
            } else {
                if(empty($user->password) && empty($user->hash_passcode)) {
                    $user->is_active = '1';
                    $user->activated_at = date("Y-m-d H:i:s");
                }
                $user->password = Hash::make($inputs['password']);
                $user->hash_passcode = $this->getHashPassCode($inputs['password']);
                $user->save();
                $this->guard()->login($user);
                return redirect()->route('home')->with('success', 'Password set successfully');
            }
        }
        return redirect()->back()->with($status, $message);
    }
    protected function guard() {
        return Auth::guard();
    }
}
