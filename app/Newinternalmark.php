<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newinternalmark extends Model
{
    //
    protected $fillable = [
        'exam_id', 'application_id', 'candidate_id', 'subject_id', 'internal', 'active_status','approvedprogramme_id','attendance'
    ];

    public function exam(){
        return $this->belongsTo('App\Exam');
    }
    public function newapplication(){
        return $this->belongsTo('App\Newapplication');
    }
    public function candidate(){
        return $this->belongsTo('App\Candidate');
    }
    public function subject(){
        return $this->belongsTo('App\Subject');
    }
}
