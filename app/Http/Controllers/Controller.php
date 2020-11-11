<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //url=L5_SWAGGER_CONST_HOST,
	/**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Port Logistics API",
     *      description="Port Logistics API",
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      
     *      url= "http://port_logistic.com/",
     *      description=""
     * )
     * @OA\SecurityScheme(
     *     type="http",
     *     description="Login with email and mobile to get the authentication token",
     *     name="Token based",
     *     in="header",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     securityScheme="apiAuth",
     * )
     *
     *
    */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
