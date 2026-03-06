<?php

namespace App\Http\Requests\Exam;

use App\Http\Requests\Request;

class UpdateExamcenterRequest extends Request
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
        $exam_id = \App\Exam::where('scheduled_exam',1)->first()->id;
        return [
            'exam_id' => 'required|numeric|max:'.$exam_id.'|min:'.$exam_id,
        ];
    }

    public function messages()
    {
        return [
            'exam_id.min' => 'Cannot update to this exam',
            'exam_id.max' => 'Cannot update to this exam',
        ];
    }
}
