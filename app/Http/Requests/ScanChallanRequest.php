<?php

namespace App\Http\Requests;
use App\Http\Requests\JsonRequest;
use Config;

class ScanChallanRequest extends JsonRequest
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
            'challan_no' => 'required|max:60',
            'destination_id' => $this->id_validation_rules
        ];
    }

    /**
     * Get the validation messages
     */
    public function messages()
    {
        return [
            'user_id.required'=>'User id is required',
            'challan_no.required'=>'Challan no. is required',
            'challan_no.max'=>'Please enter a valid challan no.',
            'destination_id.required'=>'Destination id is required'
        ];
    }
}
