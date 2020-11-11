<?php

namespace App\Http\Requests;
use App\Http\Requests\JsonRequest;

class SendEmailRequest extends JsonRequest
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
            'user_id'=>'required|numeric|gt:0',
            'email' => 'email',
            'name' => 'required|string|max:255',
            'template'=>'required|string|max:255'
        ];
    }

    /**
     * Get the validation messages
     */
    public function messages()
    {
        return [
            'user_id.required'=>'User Id is required',
            'email.required' => 'Email is required',
            'name.required'  => 'Name is required',
            'template.required'=>'Email Template is required'
        ];
    }
}
