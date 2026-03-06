<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Masterlist extends Model
{
    protected $table = 'approvedprogrammes';

    protected $fillable = [
        'institute_id', 'programme_id', 'academicyear_id','status_id','filename','maxintake','paid_for','updated_by',
        'created_by','deleted_by', 'allotted_count', 'registered_count', 'enrolment_count', 'current_term',
        'verificationpending_count', 'approved_count', 'pending_count', 'rejected_count'
        ];
	
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
        return $this->hasMany('App\Application');
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
	    return $this->candidates()->where("approvedprogramme_id", $apid)->where("status_id", 2)->count('id');
    }

    public function pendingcandidatecount($apid) {
        return $this->candidates()->where("approvedprogramme_id", $apid)->where("status_id", 1)->count('idphpphp');
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
}
