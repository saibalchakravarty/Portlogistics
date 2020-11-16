<?php

namespace App\Http\Requests;

use App\Http\Requests\JsonRequest;
use Config;

class FetchBarcodeRequest extends JsonRequest {

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
            'destination_id' => $this->id_validation_rules,
            'truck_id' => $this->id_validation_rules
        ];
    }

    /**
     * Get the validation messages
     */
    public function messages() {
        return [
            'plan_id.required' => 'Plan id is required',
            'destination_id.required' => 'Destination id is required',
            'truck_id.required' => 'Truck id is required'
        ];
    }

    public function all($keys = null) {
        $data = parent::all($keys);
        $data['plan_id'] = $this->route('plan_id');
        $data['destination_id'] = $this->route('destination_id');
        $data['truck_id'] = $this->route('truck_id');
        return $data;
    }

}
