<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Internalmark extends Model
{
    //
    protected $fillable = [
        'exam_id', 'application_id', 'candidate_id', 'subject_id', 'internal', 'active_status'
    ];

    public function exam(){
        return $this->belongsTo('App\Exam');
    }
    public function application(){
        return $this->belongsTo('App\Application');
    }
    public function candidate(){
        return $this->belongsTo('App\Candidate');
    }
    public function subject(){
        return $this->belongsTo('App\Subject');
    }
}
