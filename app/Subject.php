<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
	protected $fillable = [
        'programme_id', 'pabbrvn','sortorder','scode', 'subjecttype_id', 'sname','imin_marks','imax_marks','emin_marks','emax_marks', 'total_marks', 'syear','syllabus_type','alternative_paper','is_internal','is_external','omr_code','dummy'
    ];
	
    
    public function programme()
    {
    	return $this->belongsTo('App\Programme');
    }

    public function applications()
    {
        return $this->hasMany('App\Application');
    }

    public function subjecttype(){
        return $this->belongsTo('App\Subjecttype');
    }

    public function examtimetables(){
        return $this->hasMany('App\Examtimetable');
    }
    public function examdate($exam_id){
        if($this->examtimetables()->where('exam_id',$exam_id)->count()>0){
            return $this->examtimetables()->where('exam_id',$exam_id)->first()->examdate;
        }else{
            return '';
        }

    }
    public function startdate($exam_id){
        if($this->examtimetables()->where('exam_id',$exam_id)->count()>0){
            return $this->examtimetables()->where('exam_id',$exam_id)->first()->startdate;
        }else{
            return '';
        }

    }
    public function starttime($exam_id){
        if($this->examtimetables()->where('exam_id',$exam_id)->count()>0){
            return $this->examtimetables()->where('exam_id',$exam_id)->first()->starttime;
        }else{
            return '';
        }

    }
    public function endtime($exam_id){

        if($this->examtimetables()->where('exam_id',$exam_id)->count()>0){
            return $this->examtimetables()->where('exam_id',$exam_id)->first()->endtime;
        }else{
            return '';
        }

        /*
        if($this->examtimetables()->where('exam_id',$exam_id)->count()>0){
            return $this->examtimetables()->where('exam_id',$exam_id)->whereBetween('startdate', ['2018-09-10 10:00:00', '2018-09-13 10:00:00'])->first()->startdate;
        }else{
            return '';
        }
        */
    }
    public function enddate($exam_id){

        if($this->examtimetables()->where('exam_id',$exam_id)->count()>0){
            return $this->examtimetables()->where('exam_id',$exam_id)->first()->enddate;
        }else{
            return '';
        }

        /*
        if($this->examtimetables()->where('exam_id',$exam_id)->count()>0){
            return $this->examtimetables()->where('exam_id',$exam_id)->whereBetween('enddate', ['2018-09-10 13:00:00', '2018-09-13 13:00:00'])->first()->startdate;
        }else{
            return '';
        }
        */
    }

    public function reevaluationresults() {
        return $this->hasMany('App\Reevaluationresult');
    }

    public function marks() {
        return $this->hasMany('App\Mark');
    }

    public function internalmarks() {
        return $this->hasMany('App\Internalmark');
    }
}
