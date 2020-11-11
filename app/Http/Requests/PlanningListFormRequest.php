<?php

namespace App\Http\Requests;
use App\Http\Requests\JsonRequest;


class PlanningListFormRequest extends JsonRequest
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
                'origin_id' => 'required|integer|gt:0|digits_between:1,15',
            ];
         }
    }
    public function attributes()
    {
        return [
            'origin_id' => 'Berth location id',
        ];
    }

    public function all($keys = null) 
    {
        $data = parent::all($keys);
        $data['origin_id'] = $this->route('origin_id');
        return $data;
    }
}
