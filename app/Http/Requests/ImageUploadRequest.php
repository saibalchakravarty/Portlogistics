<?php

namespace App\Http\Requests;
use App\Http\Requests\JsonRequest;
use Config;


class ImageUploadRequest extends JsonRequest
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
        $imageDetail = Config::get('filesystems.image_upload');
        $docType = implode(',', $imageDetail['doc_type']);
        return [
            'image' => "required|image|mimes:".$docType."|max:".$imageDetail['size'].""
        ];
    }

    public function messages()
{
    return [
        'image.required' => 'Please upload an Image.',     
    ];
}

}
