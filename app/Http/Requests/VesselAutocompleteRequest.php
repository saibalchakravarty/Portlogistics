<?php

namespace App\Http\Requests;
use App\Http\Requests\JsonRequest;

class VesselAutocompleteRequest extends JsonRequest
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
        if ($this->isMethod('get')) {
            return [
                'keyword' => 'required'
            ];
        }
    }

    /**
     * Get the validation messages
     */
    public function messages()
    {
        return [
            'keyword.required'=>'Keyword is required'
        ];
    }

    public function all($keys = null) 
    {
        $data = parent::all($keys);
        $data['keyword'] = $this->route('keyword');
        return $data;
    }
}
