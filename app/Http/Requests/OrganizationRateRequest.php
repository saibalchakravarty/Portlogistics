<?php

namespace App\Http\Requests;

use App\Http\Requests\JsonRequest;

class OrganizationRateRequest extends JsonRequest {
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
            'currency_id' => 'required',
            'rate_per_trip' => 'required|numeric',
        ];
    }

    public function messages() {
        return [
            'currency_id.required' => 'Please provide currency_id',
            'rate_per_trip.required' => 'Please provide rate_per_trip',
            'rate_per_trip.numeric' => 'Please provide deecimal value',
        ];
    }
}