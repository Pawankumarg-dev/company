<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluator extends Model
{
    protected $fillable = [
        'subject_id','examtimetable_id','evaluator_id','exam_id','language_id','institute_id','is_verified','password'
    ];

    public function institute()
    {
    	return $this->belongsTo('App\Institute');
    }

    public function Lgstate(){
        return $this->hasMany('App\Lgstate');
    }
   

}
