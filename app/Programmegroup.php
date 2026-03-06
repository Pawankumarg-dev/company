<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programmegroup extends Model
{
    protected $fillable = [
        'tenth','twelveth','minage','name','noofterms','academicsystem_id','enrolment','exam_application','mark_entry_institutes','mark_entry_nber','questionpaper_download','hallticket_download','attendance_upload','publish_mark'
    ];
    public function programmes()
    {
        return $this->hasMany('App\Programme');
    }
    public function academicsystem()
    {
    	return $this->belongsTo('App\Academicsystem');
    }
    public function notrequiredfields()
    {
        return $this->hasMany('App\Notrequiredfield');
    }
    public function exams(){
        return $this->belongsToMany('App\Exam');
    }
}
