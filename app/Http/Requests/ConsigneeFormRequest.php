<?php

namespace App\Http\Requests;

use App\Http\Requests\JsonRequest;



class ConsigneeFormRequest extends JsonRequest
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
                'name' => 'required|max:50|unique:consignees,name,' . $this->id,
                'description' => 'nullable|string|max:150'
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
                'name' => 'required|max:50|unique:consignees,name,' . $this->id,
                'description' => 'nullable|string|max:150'
            ];
        }
    }

    public function all($keys = null)
    {
        $data = parent::all();
        return array_merge($data, $this->route()->parameters());
    }
    public function attributes()
    {
        return [
            'id' => 'url key',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Consignee name is required',
            'description.required'  => 'Description is required',
            'name.unique' => 'Consignee name should be unique'
        ];
    }
}
