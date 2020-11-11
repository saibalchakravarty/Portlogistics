<?php

namespace App\Services;
use Log;
use Exception;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

class SendEmailService {

    /**
     * @description send email
     * @author Gaurav Agrawal
     * @param array ['user_id','name','email','template','token','view','heading'] 
     * @return bool success or failure
     */
    public function sendEmail($email_data){
        return Mail::to($email_data['email'])->send(new SendEMail($email_data));
    }

    /**
     * @description Generate Email template from email template
     * @author Gaurav Agrawal
     * @param string template 
     * @return string template
     */
    public function generateEmailTemplate($template){
        return config('constants.email_template.'.$template);
    }
    

    /**
     * @description Generate Email heading from email template
     * @author Gaurav Agrawal
     * @param string template 
     * @return string heading
     */
    public function generateEmailHeading($template){
        return config('constants.email_heading.'.$template);
    }
}