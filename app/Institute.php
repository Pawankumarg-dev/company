<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    
    protected $fillable = [
        'user_id', 'name', 'enrolmentcode', 'contact','contactnumber1','contactnumber2','email','address','pincode',
        'city_id', 'created_by', 'updated_by','deleted_by', 'edit_status', 'address1', 'address2', 'address3',
        'postoffice', 'landmark', 'website', 'verify_status', 'code', 'faxno',
        'street_address', 'email2', 'active_status','rci_code','externalexamcenter_id','state_id',
        'is_password_updated','is_data_verified','is_mobile_verified','is_email_verified','is_institute_head_verified','is_institute_head_email_verified','is_institute_head_mobile_verified','is_facilities_verified','examcenter_se_24'
    ];
	
	public function user()
    {
        return $this->belongsTo('App\User');
    }
	public function approvedprogrammes()
    {
        return $this->hasMany('App\Approvedprogramme');
    }

    public function additionalpracticalexams()
    {
        return $this->hasMany('App\Additionalpracticalexam');
    }


    public function affiliationfees(){
        return $this->hasMany('App\Affiliationfee');
    }

    public function exampayments(){
        return $this->belongsToMany('App\Nber','examfeepayments','institute_id','nber_id')->where('exam_id',22)->withPivot('amount','payment_method','details','nber_doc','id');
    }
  
    public function examcenters()
    {
        return $this->hasMany('App\Examcenter');
    }
    public function examcenter($exam_id){
        if($this->examcenters()->onlyExam($exam_id)->count()>0){
            return $this->examcenters()->onlyExam($exam_id)->first()->examcenter;
        }else{
            return $this;
        }
    }

    public function city() {
        return $this->belongsTo('App\City');
    }

    public function district() {
        return $this->belongsTo('App\District');
    }


    public function state() {
        return $this->belongsTo('App\Lgstate','state_id','id');
    }

    public function clo(){
        return $this->belongsToMany('App\Clo')->withPivot('exam_id');;
    }

    public function institutehead()
    {
        return $this->hasOne('App\Institutehead');
    }

    public function coursecoordinators()
    {
        return $this->hasMany('App\Coursecoordinator');
    }

    public function faculties(){
        return $this->hasMany('App\Faculty');
    }
    public function institutefacility()
    {
        return $this->hasOne('App\Institutefacility');
    }
    public function externalexamcenterdetails(){
        return $this->hasMany('App\Externalexamcenterdetail');
    }
    public function externalexamcenter(){
        return $this->belongsTo('App\Externalexamcenter');
    }

    public function institutecertificateincharge()
    {
        return $this->hasOne('App\Institutecertificateincharge');
    }

    public function instituteinformationupdates()
    {
        return $this->hasMany('App\Instituteinformationupdate');
    }

    public function enrolmentpayments()
    {
        return $this->hasMany('App\Enrolmentpayment');
    }

    public function examinationpayments()
    {
        return $this->hasMany('App\Examinationpayment');
    }

    public function coursecoordinatorupdates()
    {
        return $this->hasMany('App\Coursecoordinatorupdate');
    }

    public function enrolmentfeepayments(){
        return $this->hasMany('App\Enrolmentfeepayment');
    }

    public function pendingverificationcount($ayid, $instid) {
        $enrolmentfee_ids = Enrolmentfee::where('academicyear_id', $ayid)->pluck('id')->toArray();

        return $this->enrolmentpayments()->whereIn('enrolmentfee_id', $enrolmentfee_ids)->where('institute_id', $instid)->where('status_id', 6)->count();
    }

    public function displayexaminationpaymentpendingverificationcount($eid, $iid) {
        $examinationfee_ids = Examinationfee::where('exam_id', $eid)->pluck('id')->toArray();
        return $this->examinationpayments()->whereIn('examinationfee_id', $examinationfee_ids)->where('institute_id', $iid)->where('status_id', 6)->count();
    }

    public function examcenter24se(){
        return $this->belongsTo('App\Externalexamcenter','examcenter_se_24');
    }
    public function externalExamCenters()
    {
        return $this->hasMany(ExternalExamCenter::class); // Adjust as needed
    }
   
}
