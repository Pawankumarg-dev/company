<?php

namespace App;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Approvedprogramme extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'institute_id', 'programme_id', 'academicyear_id','status_id','filename','maxintake','paid_for','updated_by',
        'created_by','deleted_by', 'allotted_count', 'registered_count', 'enrolment_count', 'current_term',
        'verificationpending_count', 'approved_count', 'pending_count', 'rejected_count','attendance_22','enable_admission','enable_admission_till'
        ];
    public function subjects(){
        
        return $this->belongsToMany('App\Subject','currentapplications','approvedprogramme_id','subject_id')->withPivot('exam_id','id','candidate_id');
        //,'internal','internalresult_id','internalattendance_id','internal_files','internal_file','total_mark','active_status');
    }

    public function exampapers(){
        return $this->hasMany('App\Exampaper');
    }
	public function programme()
    {
        return $this->belongsTo('App\Programme');
    }
	
	public function institute()
    {
        return $this->belongsTo('App\Institute');
    }
	
	public function academicyear()
    {
        return $this->belongsTo('App\Academicyear');
    }
	public function candidates(){
		return $this->hasMany('App\Candidate');
	}
	public function status()
	{
		return $this->belongsTo('App\Status');
	}
	public function programmeapprovalfiles()
	{
		return $this->hasMany('App\Programmeapprovalfile');
	}
	public function applications()
    {
        return $this->hasMany('App\Currentapplication');
    }
    public function applicants()
    {
        return $this->hasMany('App\Currentapplicant');
    }

    public function supplimentaryapplications()
    {
        return $this->hasMany('App\Supplimentaryapplication');
    }
    public function supplimentaryapplicants()
    {
        return $this->hasMany('App\Supplimentaryapplicant');
    }
    public function oldapplicants()
    {
        return $this->hasMany('App\Oldapplicant');
    }
    public function newapplicants()
    {
        return $this->hasMany('App\Newapplicant');
    }
    public function oldapplicantsofexam($exam_id){
        return $this->oldapplicants->where('exam_id',$exam_id);
    }
    public function withhelds(){
        return $this->hasMany('App\Withheld');
    }
    public function incidentalpayments() {
        return $this->hasMany('App\Incidentalpayment');
    }

    public function registeredcandidatecount($apid) {
        return $this->candidates()->where("approvedprogramme_id", $apid)->count();
    }

    public function approvedcandidatecount($apid) {
	    return $this->candidates()->where("approvedprogramme_id", $apid)->where("status_id", 2)->count();
    }

    public function pendingcandidatecount($apid) {
        return $this->candidates()->where("approvedprogramme_id", $apid)->where("status_id", 1)->count();
    }


    public function incomplete($apid) {
        return $this->candidates()->where("approvedprogramme_id", $apid)->where("status_id", 8)->count();
    }


    public function rejected($apid) {
        return $this->candidates()->where("approvedprogramme_id", $apid)->where("status_id", 3)->count();
    }


    public function verificationpending($apid) {
        return $this->candidates()->where("approvedprogramme_id", $apid)->where("status_id", 6)->count();
    }

    public function approvedcandidatelist($apid) {
	    return $this->candidates()->where("approvedprogramme_id", $apid)->where("status_id", 2)->orderBy(DB::raw("ISNULL(enrolmentno)"))->orderBy("enrolmentno")->get();
    }

    public function examappliedcandidatecount($eid, $apid) {
        return $this->applications()->where("exam_id", $eid)->where("approvedprogramme_id", $apid)->get()->unique("candidate_id")->count();
    }

    public function examappliedsubjectcount($eid, $apid) {
        return $this->applications()->where("exam_id", $eid)->where("approvedprogramme_id", $apid)->get()->count();
    }

    public function enrolmentcandidatecount($apid) {
        return $this->candidates()->where("approvedprogramme_id", $apid)->whereNotNull("enrolmentno")->count();
    }

    public function enrolmentcandidatelist($apid) {
        return $this->candidates()->where("approvedprogramme_id", $apid)->whereNotNull("enrolmentno")->orderBy("enrolmentno")->get();
    }

    public function mobileverified($apid){
        return $this->candidates()->where('approvedprogramme_id',$apid)->where('is_mobile_number_verified','Yes')->count();
    }

    public function admissiondeclaration(){
        return $this->hasOne('App\Admissiondeclaration');
    }

    
}
