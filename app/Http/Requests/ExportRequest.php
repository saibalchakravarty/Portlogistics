<?php

namespace App\Http\Requests;

use App\Http\Requests\JsonRequest;

class ExportRequest extends JsonRequest
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
            'key' => 'required|max:15'
        ];
    }
    public function messages()
    {
        return [
            'key.required' => 'Export key is not defined!'    
        ];
    }
}
