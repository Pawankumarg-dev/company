<?php

namespace App\Http\Requests\EVC;

use App\Http\Requests\Request;

class UpdateEvaluationcenterRequest extends Request
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
            'code' => 'required',
            'name' =>  'required',
            'address' =>  'required',
           // 'username' => 'required|min:5',
            //'password' =>  'required|min:6',
           // 'deusername' => 'required|min:5',
            //'depassword' =>  'required|min:6'
        ];
    }
    public function messages()
    {
        return [
            'exam_id.min' => 'Cannot add to this exam',
            'exam_id.max' => 'Cannot add to this exam'
        ];
    }
}