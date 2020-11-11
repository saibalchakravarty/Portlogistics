<?php

namespace App\Http\Requests;

use App\Http\Requests\JsonRequest;

class EndTripRequest extends JsonRequest {

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
            'planning_id' => 'required',
            'user_id' => 'required',
            'truck_id' => 'required',
            'location_id' => 'required'
        ];
    }

    public function messages() {
        
        return [
            'planning_id' => 'planning_id is required',     
            'user_id' => 'user_id is required',
            'truck_id' => 'truck_id is required', 
            'location_id' => 'location_id is required'
        ];
    }

}
