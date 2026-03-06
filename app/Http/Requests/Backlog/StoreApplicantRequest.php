<?php

namespace App\Http\Requests\Backlog;

use App\Http\Requests\Request;

class StoreApplicantRequest extends Request
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
            //'exam_id' => 'required|numeric|max:23|min:20'
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