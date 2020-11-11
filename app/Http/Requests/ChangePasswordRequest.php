<?php

namespace App\Http\Requests;

use App\Http\Requests\JsonRequest;

class ChangePasswordRequest extends JsonRequest {

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
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required_with:new_password|same:new_password'
        ];
    }

    public function messages() {
        return [
            'old_password.required' => 'Please enter current password',
            'new_password.required' => 'Please enter new password',
            'new_password.min' => 'Password length should not be less than 8 characters',
            'confirm_password.required_with' => 'Please confirm your passowrd',
            'confirm_password.same' => 'New Password and Confirm Password must be same',
        ];
    }

}
