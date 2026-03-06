<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Malpractice extends Model
{
    protected $fillable = [
        'description','exam_id','title','clo_id'
    ];

     public function exam(){
        return $this->belongsTo('App\Exam');
    }
    public function malpracticefiles(){
    	return $this->hasMany('App\Malpracticefile');
    }
}
