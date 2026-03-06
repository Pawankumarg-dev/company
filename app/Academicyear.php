<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Academicyear extends Model
{
	
	protected $fillable = [
        'year','current','accademicsession','previous_academicyear_id'
    ];
	
	
    public function approvedprogrammes()
    {
        return $this->hasMany('App\Approvedprogramme');
    }

    public function exams(){
        return $this->hasMany('App\Exam');
    }

    public function examresultdates() {
        return $this->hasMany('App\Examresultdate');
    }

    public function enrolmentfees() {
        return $this->hasMany('App\Enrolmentfee');
    }

    public function exambatches(){
        return $this->hasMany('App\Exambatch');
    }

    public function examinationfees() {
        return $this->hasMany('App\Examinationfee');
    }

    public function classattendancepercentages() {
        return $this->hasMany('App\Classattendancepercentage');
    }

    public function incidentalfees() {
        return $this->hasMany('App\Incidentalfee');
    }

    public function exammarksheetdetails() {
        return $this->hasMany('App\Exammarksheetdetails');
    }
}

