<?php

namespace App\Http\Requests;

use App\Http\Requests\JsonRequest;

class LocationRequest extends JsonRequest {

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
                'location' => 'required|max:30|unique:locations,location,'.$this->id,
                'description' => 'max:150',
                'type' => 'required'
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
                'location' => 'required|max:30|unique:locations,location,'.$this->id,
                'description' => 'max:150',
                'type' => 'required'
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
            'location.required' => 'Please enter a location name',     
            'location.unique' => 'Location name should be unique',
            'location.max' => 'Location name should not exceed 30 characters',
            'description' => 'Location description should not exceed 150 characters', 
            'type' => 'Please select a location type'
        ];
    }

    public function attributes()
    {
        return [
            'id' => 'url key',
        ];
    }

}
