<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practicalexam extends Model
{
    //
    protected $fillable = [
        "exam_id", "institute_id", "common_code", "exam_date", "exam_date2", "coursecoordinator_name", "coursecoordinator_contactnumber",
        "coursecoordinator_whatsappnumber", "coursecoordinator_email", "status_id", "to_instituteemail", "active_status",'practicalexaminer_id','faculty_id','programme_id','course_id','emailed'
    ];

    protected $dates = ["exam_date", "exam_date2"];

    public function exam() {
        return $this->belongsTo("App\Exam");
    }

    public function institute() {
        return $this->belongsTo("App\Institute");
    }

    public function course(){
        return $this->belongsTo('App\Course');
    }

    public function status() {
        return $this->belongsTo("App\Status");
    }

    public function geotaggedphotos(){
        return $this->hasMany('App\Geotaggedphoto');
    }
    public function faculty(){
        return $this->belongsTo('App\Faculty');
    }
    public function practicalexaminer(){
        return $this->belongsTo('App\Practicalexaminer');
    }

    public function awardlisttemplates(){
        return $this->hasMany('App\Awardlisttemplate');
    }

    public function subjects(){
        return $this->belongsToMany('App\Subject');
    }
}
