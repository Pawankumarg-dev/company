<?php

namespace App\Http\Requests\Exam;

use App\Http\Requests\Request;

class StoreScheduleRequest extends Request
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
        $exam_id = 27;
        return [
            'exam_id' => 'required|numeric|max:'.$exam_id.'|min:'.$exam_id,
            'examdate' => 'required',
            'starttime' => 'required',
            'endtime' => 'required',
            'user_id' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'exam_id.min' => 'Cannot add to this exam',
            'exam_id.max' => 'Cannot add to this exam',
            'examdate' => 'Already exists'
        ];
    }
}
