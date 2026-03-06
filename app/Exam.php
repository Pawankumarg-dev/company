<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'name', 'date','examtype_id','academicyear_id','status_id', 'exam_application', 'institute_markentry',
        'attendance_upload', 'hallticket_download', 'questionpaper_download', 'exambundle_status','nber_markentry','evaluation_status','reevaluation_status','examination_status'
    ];

    protected $dates = [
        'date'
    ];

    public function examtype(){
        return $this->belongsTo('App\Examtype');
    }

    public function academicyear(){
        return $this->belongsTo('App\Academicyear');
    }

    public function examtimetables(){
    	return $this->hasMany('App\Examtimetable');
    }
    public function applications(){
        return $this->hasMany('App\Application');
    }
    public function examcenters()
    {
        return $this->hasMany('App\Examcenter');
    }
    public function programmegroups(){
        return $this->belongsToMany('App\Programmegroup');
    }
    public function withhelds(){
        return $this->hasMany('App\Withheld');
    }
    public function examresultdates(){
        return $this->hasMany('App\Examresultdate');
    }

    public function reevaluations(){
        return $this->hasMany('App\Reevaluation');
    }
    public function exambatches(){
        return $this->hasMany('App\Exambatches');
    }
    public function examinationfees() {
        return $this->hasMany('App\Examinationfee');
    }
    public function externalexamcenterdetails(){
        return $this->hasMany('App\Externalexamcenterdetail');
    }
    public function exammarksheetdetails() {
        return $this->hasMany('App\Exammarksheetdetail');
    }
    public function exambundlenumbers() {
        return $this->hasMany('App\Exambundlenumber');
    }
    public function internalmarks() {
        return $this->hasMany('App\Internalmark');
    }

    public function appliedcandidatecount($eid, $iid) {
        return $this->applications()->where("exam_id", $eid)->whereIn("approvedprogramme_id", Approvedprogramme::where("institute_id", $iid)->pluck("id")->toArray())
            ->get(["candidate_id"])->unique("candidate_id")->count();
    }

    public function appliedsubjectcount($eid, $iid) {
        return $this->applications()->where("exam_id", $eid)->whereIn("approvedprogramme_id", Approvedprogramme::where("institute_id", $iid)->pluck("id")->toArray())
            ->get(["subject_id"])->count();
    }

    public function examappliedcandidateids($eid, $apid) {
        return $this->applications()->where("exam_id", $eid)->where("approvedprogramme_id", $apid)->groupBy("candidate_id")->pluck("candidate_id")->toArray();
    }
}
