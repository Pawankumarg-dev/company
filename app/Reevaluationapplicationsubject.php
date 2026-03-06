<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
class Reevaluationapplicationsubject extends Model
{
    //
    protected $fillable = [
        'reevaluationapplication_id', 'exam_id', 'institute_id', 'approvedprogramme_id', 'candidate_id', 'subject_id',
        'application_id', 'reevaluation_applystatus', 'retotalling_applystatus', 'photocopying_applystatus',
        'actual_marks', 'reevaluated_marks', 'final_marks', 'publish_status', 'active_status','no_change'
    ];

    public function reevaluationapplication() {
        return $this->belongsTo('App\Reevaluationapplication');
    }

    public function exam() {
        return $this->belongsTo('App\Exam');
    }

    public function approvedprogramme() {
        return $this->belongsTo('App\Approvedprogramme');
    }

    public function institute() {
        return $this->belongsTo('App\Institute');
    }

    public function candidate() {
        return $this->belongsTo('App\Candidate');
    }

    public function subject() {
        return $this->belongsTo('App\Subject');
    }

    public function application() {
        return $this->belongsTo('App\Currentapplication');
    }
    public function newapplication() {
        return $this->belongsTo('App\Newapplication','application_id');
    }

public function allapplication()
{
    return $this->hasOne(\App\Allapplication::class, 'candidate_id', 'candidate_id')
                ->whereColumn('subject_id', 'reevaluationapplications.subject_id')
                ->where('exam_id', Session::get('exam_id'));
}
}
