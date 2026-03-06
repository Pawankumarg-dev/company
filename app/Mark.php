<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Mark extends Model
{
     protected $fillable = [
         'exam_id', 'candidate_id', 'subject_id',
         'internalattendance_id', 'internal', 'internalresult_id', 'internal_lock', 'internal_file',
         'externalattendance_id', 'external', 'externalresult_id', 'external_lock', 'external_file',
         'grace', 'total_mark', 'result_id','application_id', 'marksheet_number',
         'markcertificate_id', 'mark_entered_by', 'active_status',
    ];


    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }

     public function application()
     {
         return $this->belongsTo('App\Application');
     }

    public function candidate()
    {
        return $this->belongsTo('App\Candidate');
    }

    /*
    public function result(){
        if($this->result_id==1){
            return 'Pass';
        }else{
            return 'Fail';
        }
    }
    */

    public function certificate(){
        return $this->belongsTo('App\Markcertificate');
    }

    public function result() {
         return $this->belongsTo('App\Result');
    }

    public function reevaluationresults() {
        return $this->hasMany('App\Reevaluationresult');
    }
}

