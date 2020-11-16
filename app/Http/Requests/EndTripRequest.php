<?php

namespace App\Http\Requests;

use App\Http\Requests\JsonRequest;
use Config;

class EndTripRequest extends JsonRequest {

    protected $id_validation_rules;
    public function __construct()
    {
        $this->id_validation_rules = Config::get('constants.id_validation_rules');
    }
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
            'plan_id' => $this->id_validation_rules,
            'truck_id' => $this->id_validation_rules,
            'destination_id' => $this->id_validation_rules
        ];
    }

    public function messages() {
        
        return [
            'planning_id' => 'Plan id is required', 
            'truck_id' => 'Truck id is required', 
            'destination_id' => 'Destination id is required'
        ];
    }

}
