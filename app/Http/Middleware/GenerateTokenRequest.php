<?php

namespace App\Http\Requests;

use App\Http\Requests\JsonRequest;

class GenerateTokenRequest extends JsonRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'user_id' => 'bail|required|regex:/^[0-9\s\.]+$/'
        ];
    }

    public function messages() {
        
        return [
            'user_id.required' => 'User ID is required',
            'user_id.regex' => 'Please Enter Valid Regex',            
        ];
    }

}
