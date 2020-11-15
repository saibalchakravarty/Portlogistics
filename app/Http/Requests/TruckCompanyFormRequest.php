<?php

namespace App\Http\Requests;
use App\Http\Requests\JsonRequest;
use GuzzleHttp\Psr7\Request;
use Route;


class TruckCompanyFormRequest extends JsonRequest
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
                'name' => 'required|max:100|unique:truck_companies,name,'.$this->id,
                'email' => 'required|max:60',            
                'mobile_no' => 'required|max:15',            
                'contact_name' => 'max:35',            
                'contact_mobile_no' => 'max:15',            
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
                'name' => 'required|max:100|unique:truck_companies,name,'.$this->id,
                'email' => 'required|max:60',            
                'mobile_no' => 'required|max:15',            
                'contact_name' => 'max:35',            
                'contact_mobile_no' => 'max:15',
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
            'name.required' => 'Trucking Company name is required',
            'name.unique' => 'Trucking Company name should be unique',
            'email.required'  => 'Email is required',
            'email.max' => 'Email should not exceed 60 characters',
            'mobile_no.required'  => 'Mobile Number is required',
        ];
    }
    
    public function attributes()
    {
        return [
            'id' => 'url key',
        ];
    }

}
