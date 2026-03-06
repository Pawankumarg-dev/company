<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examschedule extends Model
{
    protected $fillable = [
        'exam_id', 'examdate', 'starttime', 'endtime', 'user_id', 'description','qpset','trackattendance'
    ];

    public function exam(){
        return $this->belongsTo('App\Exam');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function examtimetables(){
        return $this->hasMany('App\Examtimetable');
    }

    public function daytimetable($pid){
        return $this->hasMany('App\Examtimetable')->whereHas('subject',function($q) use($pid){
            $q->where('programme_id',$pid);
        })->first();
    }

    public function nbers(){
        return $this->belongsToMany('App\Nber')->withPivot('password');
    }

    
}
