<?php

namespace App\Http\Controllers\API\V1;
use App\Libraries\SendEmailLibrary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SendEmailRequest;
use Illuminate\Http\Response;

class SendEmailController extends BaseController

{
    protected $sendEmailLibrary;

    public function __construct(SendEmailLibrary $sendEmailLibrary){
        $this->sendEmailLibrary = $sendEmailLibrary;
    }

    /**
     * @OA\Post(
     ** path="/send-email",
     *  tags={"User"},
     *  summary="User",
     *  @OA\RequestBody(
     *  required=true,
     *  description="Pass email details for send email",
     *  @OA\JsonContent(
     *  required={"user_id","name","email","template"},
     *  @OA\Property(property="user_id", type="integer", format="number", example=1),
     *  @OA\Property(property="name", type="string", format="text", example="test"),
     *  @OA\Property(property="email", type="string", format="email", example="test@gmail.com"),
     *  @OA\Property(property="template", type="string", format="text", example="register"),
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
    public function sendEmail(SendEmailRequest $request){
        $email_data = $request->all();
        $status = $this->sendEmailLibrary->modify($email_data);
        if($status['status']=='failed'){
        return $this->sendError($status['message'],[],401);
        }
        return $this->sendResponse([],$status['message'],200);       
    }

}
