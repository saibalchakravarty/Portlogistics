<?php

namespace App\Http\Requests;

use App\Http\Requests\JsonRequest;

class ChangeNameRequest extends JsonRequest {

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
            'first_name' => 'required|max:40',
            'last_name' => 'required|max:40'
        ];
    }

    public function messages() {
        return [
            'first_name.required' => 'Please enter first name',
            'first_name.max' => 'First name cannot exceed 40 characters',
            'last_name.required' => 'Please enter last name',
            'last_name.max' => 'Last name cannot exceed 40 characters'
        ];
    }

}
