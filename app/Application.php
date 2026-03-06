<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
	protected $fillable = [
	    'candidate_id', 'subject_id','language_id','status_id','exam_id', 'term', 'approvedprogramme_id', 'linkopen_number',
        'penalty',
        'examtype_id',
        'dummy_number',
        'bundle_number',
        'internalattendance_id', 'internal', 'internalresult_id', 'internal_lock', 'internal_file', 'grace',
        'externalattendance_id', 'external', 'externalresult_id', 'external_lock', 'external_file',
        'total', 'result_id', 'active_status', 'publish_date', 'publish_status',
        'exammarksheetdetail_id', 'marksheet_number', 'withheld_status', 'externalexamcenter_id', 'examtimetable_id',
        "hallticket_status",
        'payment_status', 'external_mark', 'internal_mark','applicant_id','ignore_entry'
    ];
    
    public function approvedprogramme()
    {
    	return $this->belongsTo('App\Approvedprogramme');
    }
    public function candidate(){
    	return $this->belongsTo('App\Candidate');
    }
    public function subject(){
    	return $this->belongsTo('App\Subject');
    }
    public function language(){
    return $this->belongsTo('App\Language');
}
    public function status(){
        return $this->belongsTo('App\Status');
    }
    public function mark(){
        return $this->hasOne('App\Mark');
    }
    public function exam(){
        return $this->belongsTo('App\Exam');
    }
    public function scopeWithexam($query,$id){
        return $query->where('exam_id',$id);
    }

    public function reevaluationresults() {
        return $this->hasMany('App\Reevaluationresult');
    }

    public function result() {
        return $this->belongsTo('App\Result');
    }

    public function examtype() {
        return $this->belongsTo('App\Examtype');
    }

    public function exammarksheetdetail() {
        return $this->belongsTo('App\Exammarksheetdetail');
    }

    public function internalattendance() {
        return $this->belongsTo('App\Internalattendance');
    }

    public function externalattendance() {
        return $this->belongsTo('App\Externalattendance');
    }

    public function internalresult() {
        return $this->belongsTo('App\Internalresult');
    }

    public function externalresult() {
        return $this->belongsTo('App\Externalresult');
    }

    public function internalmarks() {
        return $this->hasMany('App\Internalmark');
    }

    public function externalexamcenter() {
        return $this->belongsTo('App\Externalexamcenter');
    }

    public function examtimetable() {
        return $this->belongsTo('App\Examtimetable');
    }


}
