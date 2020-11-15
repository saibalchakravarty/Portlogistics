<?php

namespace App\Http\Requests;
use App\Http\Requests\JsonRequest;
use GuzzleHttp\Psr7\Request;
use Route;


class TruckFormRequest extends JsonRequest
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
        if ($this->isMethod('post')) {
            return [
                'truck_no' => 'required|max:10|unique:trucks,truck_no,'.$this->id,
                'truck_company_id' => 'required',
            ];
        }
        
        if ($this->isMethod('delete') || $this->isMethod('get')) {
            return [
                'id' => 'integer|gt:0'
            ];
        }
        if ($this->isMethod('put')) {
            return [
                'id' => 'integer|gt:0',
                'truck_no' => 'required|max:10|unique:trucks,truck_no,'.$this->id,
                'truck_company_id' => 'nullable|max:150',
            ];
        }
    }
    
    public function all($keys = null)
    {
        $data = parent::all();
        return array_merge($data, $this->route()->parameters());
    }

    public function messages()
    {
        return [
            'truck_no.required' => 'Truck/Dumper No is required',
            'truck_no.max' => 'Truck/Dumper No should not exceed 10 characters',
            'truck_no.unique' => 'Truck/Dumper No should be unique',
            'truck_company_id.required' => 'Please select trucking company',
        ];
    }
    
    public function attributes()
    {
        return [
            'id' => 'url key',
        ];
    }

}
