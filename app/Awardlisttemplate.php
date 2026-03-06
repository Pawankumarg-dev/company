<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Awardlisttemplate extends Model
{
    //
    protected $fillable = [
        "practicalexam_id", "exam_date",'practicalexaminer_id','institute_id','approvedprogramme_id','term','downloaded_at','marksheet','marksheet_uploaded_at','faculty_id'
    ];

    

    public function practicalexam() {
        return $this->belongsTo("App\Practicalexam");
    }

    public function subjects() {
        return $this->belongsToMany("App\Subject")->withPivot('marks_upload','date_uploaded');
    }
    public function approvedprogramme(){
        return $this->belongsTo('App\Approvedprogramme');
    }

    public function institute(){
        return $this->belongsTo('App\Institute');
    }
    public function faculty(){
        return $this->belongsTo('App\Faculty');
    }
    public function practicalexaminer(){
        return $this->belongsTo('App\Practicalexaminer');
    }
}
