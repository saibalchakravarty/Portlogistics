<?php

namespace App\Http\Requests;
use App\Http\Requests\JsonRequest;

class CreateChallanRequest extends JsonRequest
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
            'user_id'=>'required',
            'planning_id' => 'required',
            'truck_id'=>'required',
            'origin_location_id'=>'required',
            'destination_location_id'=>'required',
            'consignee_id'=>'required',
            'shift_id'=>'required'
        ];
    }

    /**
     * Get the validation messages
     */
    public function messages()
    {
        return [
            'user_id.required'=>'User id is required',
            'planning_id.required'=>'Planning id is required',
            'truck_id.required'=>'Truck id is required',
            'origin_location_id.required'=>'Origin id is required',
            'destination_location_id.required'=>'Destination id is required',
            'consignee_id.required'=>'Consignee id is required',
            'shift_id.required'=>'Shift id is required'
        ];
    }
}
