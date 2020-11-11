<?php

namespace App\Http\Requests;

use App\Http\Requests\JsonRequest;

class UserRoleRequest extends JsonRequest {

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
        if ($this->isMethod('post')) {
            return [
                'name'          => 'required|max:50|regex:/^[ a-zA-Z0-9\s]+$/|unique:user_roles,name,'.$this->id
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
                'name' => 'required|max:50|regex:/^[ a-zA-Z0-9\s]+$/|unique:user_roles,name,'.$this->id
            ];
        }
        
    }
    public function all($keys = null)
    {
        $data = parent::all();
        $data =  array_merge($data, $this->route()->parameters());
        return $data;
    }

    public function messages() {
        
        return [
            'name'          => 'Role name is required',
            'name.unique'   => 'Role Name should be unique',  
        ];
    }

}
