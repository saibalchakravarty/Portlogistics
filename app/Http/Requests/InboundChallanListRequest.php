<?php

namespace App\Http\Requests;
use App\Http\Requests\JsonRequest;

class InboundChallanListRequest extends JsonRequest
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
                'plan_id' => 'required|integer|gt:0',
                'plot_id'=>'required|integer|gt:0'
            ];
        }
    }

    /**
     * Get the validation messages
     */
    public function messages()
    {
        return [
            'plan_id.required'=>'Plan id is required',
            'plot_id.required'=>'Plot id is required'
        ];
    }

    public function all($keys = null) 
    {
        $data = parent::all($keys);
        $data['plan_id'] = $this->route('plan_id');
        $data['plot_id'] = $this->route('plot_id');
        return $data;
    }
}
