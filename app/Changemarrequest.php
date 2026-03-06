<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Changemarrequest extends Model
{
     protected $fillable = [
        'exam_id', 'application_id', 'newdata', 'markorattendance', 'user_id', 'inex','editornew','candidate_id','subject_id','ip_address','internalattendance_id','edit','nber_id','status'
    ];

      public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
    public function candidate() {
        return $this->belongsTo('App\Candidate');
    }
        public function subject(){
    	return $this->belongsTo('App\Subject');
    }
}
