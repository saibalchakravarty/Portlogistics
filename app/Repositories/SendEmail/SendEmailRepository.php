<?php

namespace App\Repositories\SendEmail;

use App\Models\UserSendEmail;
use Exception;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendEmailRepository {

    /**
     * @description save send email details
     * @author Gaurav Agrawal
     * @param array ['user_id','name','email','template','token'] 
     * @return bool success or failure
     */
    public function saveSendEmail($email_data) {
        try {
            UserSendEmail::create(
                    [
                        'user_id' => $email_data['user_id'],
                        'token' => $email_data['token'],
                        'email_template' => $email_data['template'],
                    ]
            );
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
        return true;
    }

    /**
     * @description check email already sent
     * @author Gaurav Agrawal
     * @param integer user_id 
     * @return array ['isError','data']
     */
    public function checkSendEmail($user_id) {
        try {
            $UserSendEmail = UserSendEmail::where('user_id', $user_id)->first(); //Please do not put firstOrFail() here, otherwise send email functionality won't work
            if ($UserSendEmail == null) {
                return ['isError' => false, 'data' => []];
            }
            return ['isError' => false, 'data' => $UserSendEmail];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['isError' => true, 'data' => []];
        }
    }

    /**
     * @description update Send email details
     * @author Gaurav Agrawal
     * @param array ['user_id','name','email','template','token'] 
     * @return bool success or failure
     */
    public function updateSendEmail($email_data) {
        try {
            UserSendEmail::where('user_id', $email_data['user_id'])
                    ->update([
                        'token' => $email_data['token'],
                        'email_template' => $email_data['template'],
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
        return true;
    }

}
