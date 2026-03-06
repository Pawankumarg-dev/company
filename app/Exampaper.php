<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exampaper extends Model
{
    public $timestamps = false;
    
	protected $fillable = [
        'exam_id',
        'approvedprogramme_id',
        'programme_id',
        'institute_id',
        'examcenter_id',
        'externalexamcenter_id',
        'examschedule_id',
        'examtimetable_id',
        'subject_id',
        'morning',
        'afternoon',
        'scan_copy',
        'attendance',
        'downloaded_session',
        'present',
        'absent',
        'evaluated',
        'password'
    ];

    public function approvedprogramme()
    {
    	return $this->belongsTo('App\Approvedprogramme');
    }
    public function programme()
    {
    	return $this->belongsTo('App\Programme');
    }
    public function institute()
    {
        return $this->belongsTo('App\Institute');
    }
    public function exam(){
        return $this->belongsTo('App\Exam');
    }
    public function externalexamcenter(){
        return $this->belongsTo('App\Externalexamcenter');
    }
    public function examschedule(){
        return $this->belongsTo('App\Examschedule');
    }
    public function examtimetable(){
        return $this->belongsTo('App\Examtimetable');
    }
    public function subject(){
        return $this->belongsTo('App\Subject');
    }
    public function evaluationcenter(){
        return $this->belongsTo('App\Evaluationcenter');
    }
}
