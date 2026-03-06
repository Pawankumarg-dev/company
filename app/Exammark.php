<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exammark extends Model
{
    //
    protected $fillable = [
        "candidate_id", "subject_id", "exam_id", "internal_mark", "external_mark", "grace_mark", 
        "grace_mark_status", "total_mark", "withheld_status", "pass_status", "active_status"
    ];

    public function candidate(){
        return $this->belongsTo('App\Candidate');
    }

    public function subject(){
        return $this->belongsTo('App\Subject');
    }

    public function exam(){
        return $this->belongsTo('App\Exam');
    }
}
