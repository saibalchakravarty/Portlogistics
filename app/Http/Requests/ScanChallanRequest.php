<?php

namespace App\Http\Requests;
use App\Http\Requests\JsonRequest;

class ScanChallanRequest extends JsonRequest
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
            'challan_no' => 'required|max:60',
            'plot_id'=>'required|integer|gt:0'
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
            'plot_id.required'=>'Plot id is required'
        ];
    }
}
