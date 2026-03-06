<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examattendance extends Model
{
    protected $fillable = [
        'examtimetable_id','examattendancefile_id','file'
    ];

     public function examattendancefile(){
        return $this->belongsTo('App\Examattendancefile');
    }
    public function examtimetable(){
    	return $this->belongsTo('App\Examtimetable');
    }
}
