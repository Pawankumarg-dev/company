<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
	protected $fillable = [
        'code', 'abbreviation', 'name','numberofterms','enrolmentcode','programmegroup_id', 'active_status', 'sortorder',
        'recognised_by', 'approval_letter_required','rci_code','course_id'
    ];

    public function course(){
        return $this->belongsTo(('App\Course'));
    }
	
    public function approvedprogrammes()
    {
        return $this->hasMany('App\Approveprogramme');
    }
    public function subjects(){
        return $this->hasMany('App\Subject');
    }
    public function nber(){
        return $this->belongsTo('App\Nber');
    }
    public function programmegroup()
    {
    	return $this->belongsTo('App\Programmegroup');
    }

    public function examresultdates() {
        return $this->hasMany('App\Examresultdate');
    }

    public function coursecoordinators()
    {
        return $this->hasMany('App\Coursecoordinator');
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

    public function getCourseNameAttribute(){
        return $this->course->name . " Rev. " . $this->revision_year;
    }
}
