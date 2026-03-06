<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examtimetable extends Model
{
    protected $fillable = [
        'subject_id', 'startdate','enddate','exam_id','questionpaper', 'password', "examdate", "starttime", "endtime", 'examschedule_id','user_id','name','qp_process'
    ];

    protected $dates = [
        "startdate", "enddate", "examdate"
    ];

    public function exam(){
        return $this->belongsTo('App\Exam');
    }

    public function subject(){
    	return $this->belongsTo('App\Subject');
    }

    public function cloreports(){
    	return $this->hasMany('App\Cloreport');
    }

    public function answerkeys(){
        return $this->hasMany('App\Answerkey');
    }

    public function qppatterns(){
        return $this->hasMany('App\Qppattern');
    }

    
    public function applicationlanguages(){
        return $this->hasMany('App\Applicationlanguage');
    }

    public function subjectofevaluators(){
        return $this->hasMany('App\Subjectofevaluator');
    }

    public function examattendances(){
        return $this->hasMany('App\Examattendance');
    }

    public function applications()
    {
        return $this->hasMany('App\Application');
    }

    public function markexamattendances() {
        return $this->hasMany('App\Examattendance');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function examschedule(){
        return $this->belongsTo('App\Examschedule');
    }

    public function daysubject($schedule_id,$programme_id){
        return $this->belongsTo('App\Subject')->where('programme_id',$programme_id);
    }

    public function languages(){
        return $this->belongsToMany('App\Language')->withPivot('rand_string','question_paper_1','question_paper_2','question_paper_3','alternativesubject_id');
    }

}
