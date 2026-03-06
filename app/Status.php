<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'class', 'status'
    ];


    public function approvedprogrammes()
    {
        return $this->hasMany('App\Approvedprogramme');
    }

	 public function candidates()
    {
        return $this->hasMany('App\Candidate');
    }

	public function statushtml(){
		return  "<span class='label label-".$this->class."'>".$this->status."</span>";
	}

    public function enrolmentpayments() {
        return $this->hasMany('App\Enrolmentpayment');
    }

    public function examinerexpertroles() {
        return $this->hasMany('App\Examinerexpertrole');
    }

    public function examinerexperts() {
        return $this->hasMany('App\Examinerexpert');
    }

    public function examinationpayments() {
        return $this->hasMany('App\Enrolmentpayment');
    }

    public function classattendancepercentages() {
        return $this->hasMany('App\Classattendancepercentage');
    }

    public function incidentalpayments() {
        return $this->hasMany('App\Incidentalpayment');
    }
}
