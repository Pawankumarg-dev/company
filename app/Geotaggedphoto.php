<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geotaggedphoto extends Model
{
    //
    protected $fillable = [
        "practicalexam_id", "exam_date",'file','comment','institute_id','practicalexaminer_id','faculty_id'
    ];

    public function practicalexam(){
        return $this->belongsTo('App\Practicalexam');
    }

    public function faculty(){
        return $this->belongsTo('App\Faculty');
    }

}
