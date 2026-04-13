<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PracticalExamSubject extends Model
{
     protected $table = 'practicalexam_subject';
    protected $fillable = ['practicalexam_id', 'subject_id'];

    public function practicalExam()
    {
        return $this->belongsTo(PracticalExam::class, 'practicalexam_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
