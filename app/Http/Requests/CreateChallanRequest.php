<?php

namespace App\Http\Requests;
use App\Http\Requests\JsonRequest;
use Config;

class CreateChallanRequest extends JsonRequest
{
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
            'plan_id' => $this->id_validation_rules,
            'truck_id' => $this->id_validation_rules,
            'origin_id' => $this->id_validation_rules,
            'destination_id' => $this->id_validation_rules,
            'consignee_id' => $this->id_validation_rules,
            'shift_id' => $this->id_validation_rules
        ];
    }

    /**
     * Get the validation messages
     */
    public function messages()
    {
        return [
            'plan_id.required'=>'Plan id is required',
            'truck_id.required'=>'Truck id is required',
            'origin_id.required'=>'Origin id is required',
            'destination_id.required'=>'Destination id is required',
            'consignee_id.required'=>'Consignee id is required',
            'shift_id.required'=>'Shift id is required'
        ];
    }
}
