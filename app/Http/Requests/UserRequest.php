<?php

namespace App\Http\Requests;

use App\Http\Requests\JsonRequest;

class UserRequest extends JsonRequest {

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
        if ($this->isMethod('put')) {
            return [
                'id' => 'required|integer|gt:0',
                'email' => 'required|email|max:60',
                'first_name' => 'required|max:40',
                'last_name' => 'required|max:40',
                'mobile_no' => 'required|max:20',
                'address1' => 'max:60',
                'address2' => 'max:60',
                'country_id' => 'required',
                'state_id' => 'required',
                'city_id' => 'required',
                'pin_code' => 'required|max:10',
                'department_id' => 'required',
                'role_id' => 'required'
            ];
        } else {
            return [
                'email' => 'required|email|max:60',
                'first_name' => 'required|max:40',
                'last_name' => 'required|max:40',
                'mobile_no' => 'required|max:20',
                'address1' => 'max:60',
                'address2' => 'max:60',
                'country_id' => 'required',
                'state_id' => 'required',
                'city_id' => 'required',
                'pin_code' => 'required|max:10',
                'department_id' => 'required',
                'role_id' => 'required'
            ];
        }
    }

    public function messages() {
        if ($this->isMethod('put')) {
            return [
                'id.required' => 'User id is required',
                'email.required' => 'Please provide email id',
                'email.email' => 'Please provide a valid email id',
                'email.max' => 'Email id should not exceed 60 characters',
                'first_name.required' => 'Please provide firstname',
                'first_name.max' => 'Firstname should not exceed 40 characters',
                'last_name.required' => 'Please provide lastname',
                'last_name.max' => 'Lastname should not exceed 40 characters',
                'mobile_no.required' => 'Please provide phone number',
                'mobile_no.numeric' => 'Please provide a valid phone number',
                'mobile_no.max' => 'Phone number length should not exceed 20 characters',
                'address1.max' => 'Address1 length should not exceed 60 characters',
                'address2.max' => 'Address2 length should not exceed 60 characters',
                'country.required' => 'Please provide country',
                'state.required' => 'Please provide state',
                'city.required' => 'Please provide city',
                'pin_code.required' => 'Please provide pincode',
                'pin_code.numeric' => 'Please provide a valid pincode',
                'pin_code.max' => 'Pincode length should not exceed 10 characters',
                'department.required' => 'Please provide department',
                'role.required' => 'Please provide user role'
            ];
        } else {
            return [
                'email.required' => 'Please provide email id',
                'email.email' => 'Please provide a valid email id',
                'email.max' => 'Email id should not exceed 60 characters',
                'first_name.required' => 'Please provide firstname',
                'first_name.max' => 'Firstname should not exceed 40 characters',
                'last_name.required' => 'Please provide lastname',
                'last_name.max' => 'Lastname should not exceed 40 characters',
                'mobile_no.required' => 'Please provide phone number',
                'mobile_no.numeric' => 'Please provide a valid phone number',
                'mobile_no.max' => 'Phone number length should not exceed 20 characters',
                'address1.max' => 'Address1 length should not exceed 60 characters',
                'address2.max' => 'Address2 length should not exceed 60 characters',
                'country.required' => 'Please provide country',
                'state.required' => 'Please provide state',
                'city.required' => 'Please provide city',
                'pin_code.required' => 'Please provide pincode',
                'pin_code.numeric' => 'Please provide a valid pincode',
                'pin_code.max' => 'Pincode length should not exceed 10 characters',
                'department.required' => 'Please provide department',
                'role.required' => 'Please provide user role'
            ];
        }
    }
    public function all($keys = null) {
        $data = parent::all($keys);
        $data['id'] = $this->route('id');
        return $data;
    }
}
