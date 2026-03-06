<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cloreport extends Model
{
    protected $fillable = [
        'clo_id','examtimetable_id','cloreportfile_id','file'
    ];

     public function cloreportfile(){
        return $this->belongsTo('App\Cloreportfile');
    }

    public function examtimetable(){
    	return $this->belongsTo('App\Examtimetable');
    }
}
