<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LocateInstituteRequest extends Request
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
        $rules = ['filter'=>'required'];
        if($this->request->has('filter')){
          //$rules['state_id'] = 'required|min:1';
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'state_id' => 'Please select a state'
        ];
    }
}