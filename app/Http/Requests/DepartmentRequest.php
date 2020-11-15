<?php

namespace App\Http\Requests;
use App\Http\Requests\JsonRequest;

class DepartmentRequest extends JsonRequest
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
                'name' => 'required|max:50|unique:departments,name,'.$this->id,
                'description' => 'max:150',          
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
                'name' => 'required|max:50|unique:departments,name,'.$this->id,
                'description' => 'nullable|max:150',
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
            'name.required' => 'Department name is required',
            'name.unique' => 'Department name should be unique',
            'name.max'  => 'Department name should not exceed 50 characters',
            'description.max'  => 'Description should not exceed 150 characters',
        ];
    }
}
