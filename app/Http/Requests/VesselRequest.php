<?php

namespace App\Http\Requests;

use App\Http\Requests\JsonRequest;

class VesselRequest extends JsonRequest
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
                'name'          => 'required|max:50|unique:vessels,name,' . $this->id,
                'description'   => 'nullable|max:150|',
                'loa'           => 'nullable|numeric',
                'beam'          => 'nullable|numeric',
                'draft'         => 'nullable|numeric',
            ];
        }
        if ($this->isMethod('delete') || $this->isMethod('get')) {
            return [
                'id' => 'integer|gt:0',
                'key'=>'nullable|string'
            ];
        }
        if ($this->isMethod('put')) {
            return [
                'id' => 'integer|gt:0',
                'name'          => 'required|max:50|unique:vessels,name,' . $this->id,
                'description'   => 'nullable|max:150|',
                'loa'           => 'nullable|numeric',
                'beam'          => 'nullable|numeric',
                'draft'         => 'nullable|numeric'
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
            'key'=>'keyword'
        ];
    }

    public function messages()
    {

        return [
            'name'          => 'Vessel name is required',
            'name.unique'   => 'Vessel name should be unique',
            'description'   => 'Description is Alphanumeric',
            'loa'           => 'LOA is decimal format',
            'beam'          => 'Beam is decimal format',
            'draft'         => 'Draft is decimal format',
        ];
    }
}
