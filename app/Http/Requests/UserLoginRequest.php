<?php

namespace App\Http\Requests;

use App\Http\Requests\JsonRequest;

class UserLoginRequest extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'email' => 'required|max:255',
            'password' => 'required',
        ];
    }


    public function messages() {
        
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email',
            'email.max' => 'Email id should not exceed 255 characters',
            'password.required' => 'Password is required',
        ];
    }


}
