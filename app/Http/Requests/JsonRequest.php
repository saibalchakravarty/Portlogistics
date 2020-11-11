<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Log;

abstract class JsonRequest extends FormRequest
{
    protected function failedValidation(Validator $validator){


    	$response = [           
        'status' => 'failed',
        'message' => 'Validatoin Failed',
        ];
        $status_code = 429;
        $response['status_code'] = $status_code;
        $response['result'] = $validator->errors();
        
        Log::info(json_encode($response));
       /* if(isset($param['browser']) && $param['browser'] ==1 && !empty($param['view'])){
          return view($param['view'],$response); 
        }
        return response()->json($response, 422);
        */

        throw new HttpResponseException(response()->json($response, 200));
    }
}
