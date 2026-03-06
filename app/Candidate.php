<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'approvedprogramme_id', 
        'enrolmentno', 
        'name',
        'fathername',
        'mothername',
        'percentage',
        'dob',
        'address',
        'paddress',
        'pincode',
        'ppincode',
        'contactnumber',
        'email',
        'photo',
        'doc_mark',
        'doc_dob',
        'doc_tenth',
        'doc_twelveth',
        'doc_application',
        'doc_disability',
        'doc_community',
        'doc_percentage_exception',
        'status_id',
        'community_id',
        'disability_id',
        'disabilitytype_id',
        'disability_name',
        'gender_id',
        'city_id',
        'paymentstatus_id',
        'debarred_status',
        'salutation_id',
        'doc_rci',
        'crr',
        'date_of_reg',
        'date_of_ren',
        'user_id',
        'coursepercentage',
        'course_percentage',
        'class',
        'whatsapp_number',
        'coursecompleted_status',
        'mobile_otp_verified_on',
        'email_otp_verified_on',
        'aadhar',
        'disabilityper',
        'nationality_id',
        'pwd',
        'isdisabled',
        'ews',
        'state_id',
        'lgstate_id',
        'district_id',
        'subdistrict_id',
        'village_id',
        'pstate_id',
        'pdistrict_id',
        'psubdistrict_id',
        'pvillage_id',
        'udid',
        'is_mobile_number_verified',
        'is_email_address_verified',
        'is_mobile_edited',
        'otp_notification_sent',
        'is_data_verified',
        'modify_data',
        'modify_mark',
        'is_duplicate_mobile',
        'duplicate_mobile_no',
        'new_changes',
        'signature',
        'incomplete_2024_data','emailotp','feepayment_status','epariveshreg','ip_address'
    ];

  /*  protected $dates = [
        'dob'
    ];
*/
    public function orders(){
        return $this->belongsToMany('App\Order');
    }

    public function order(){
        return $this->belongsTo('App\Order');
    }

    public function subjects(){
        return $this->belongsToMany('App\Subject','currentapplications','candidate_id','subject_id')->withPivot('id','exam_id','approvedprogramme_id','term','language_id','payment_status','active_status','status_id','penalty','externalexamcenter_id');
    }

    public function marks(){
        return $this->belongsToMany('App\Subject','marks','candidate_id','subject_id')->where('exam_id',22)->withPivot('internal','external');
    }
    public function currentapplicant(){
		return $this->belongsTo('App\Currentapplicant');
	}
    public function newapplicant(){
		return $this->belongsTo('App\Newapplicant');
	}
	public function approvedprogramme(){
		return $this->belongsTo('App\Approvedprogramme');
	}
    public function city(){
        return $this->belongsTo('App\City');
    }
	public function gender()
    {
        return $this->belongsTo('App\Gender');
    }
	public function disability()
    {
        return $this->belongsTo('App\Disability');
    }
    public function disabilitytype()
    {
        return $this->belongsTo('App\Disabilitytype');
    }
	public function community()
    {
        return $this->belongsTo('App\Community');
    }
	public function status()
	{
		return $this->belongsTo('App\Status');
	}
	public function candidatefiles()
	{
		return $this->hasMany('App\Candidatefile');
	}
    public function educations()
	{
		return $this->hasMany('App\Education');
	}
    public function backlogs()
	{
		return $this->hasMany('App\Backlog');
	}
	public function candidateapprovals()
	{
		return $this->hasMany('App\Candidateapproval');
	}
	public function salutation()
    {
        return $this->belongsTo('App\Salutation');
    }
	public function statushtml(){
		return  "<span class='label label-".$this->status->class."'>".$this->status->status."</span>";
	}
	public function scopeStatuscount($query,$apid,$status_id){
		return  $query->where('approvedprogramme_id',$apid)->where('status_id',$status_id)->get();
	}
    public function applications()
    {
        return $this->hasMany('App\Currentapplication');
    }
    
    public function newapplications()
    {
        return $this->hasMany('App\Newapplication');
    }
    
   
    public function attendances(){
        return $this->hasMany('App\Attendance');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function nationality()
    {
        return $this->belongsTo('App\Nationality');
    }
    public function withhelds(){
        return $this->hasMany('App\Withheld');
    }

    public function currentresults() {
        return $this->hasMany('App\Currentresult');
    }

    public function reevaluationresults() {
        return $this->hasMany('App\Reevaluationresult');
    }

    public function enrolmentpayments() {
        return $this->hasMany('App\Enrolmentpayment');
    }

    public function examinationpayments() {
        return $this->hasMany('App\Enrolmentpayment');
    }

    public function classattendancepercentages() {
        return $this->hasMany('App\Classattendancepercentage');
    }

    public function correctionquerycandidates()
    {
        return $this->hasMany('App\Correctionquerycandidate');
    }

    public function provisionalcertificates()
    {
        return $this->hasMany('App\Provisionalcertificate');
    }

    public function internalmarks() {
        return $this->hasMany('App\Internalmark');
    }

    public function approvedcandidatecount($count) {
        return $this->where("status_id", 2)->count();
    }

    public function candidatelist() {
	    return $this->where("status_id", 2)->orderBy("enrolmentno")->get();
    }

    public function paymentstatus()
    {
        return $this->belongsTo('App\Paymentstatus');
    }

    public function pendingverificationcount($cid) {
        return $this->enrolmentpayments()->where('candidate_id', $cid)->where('status_id', 6)->count();
    }

    public function candidateexamresultdates() {
        return $this->hasMany('App\Candidateexamresultdate');
    }

    public function examsubjectappliedstatus($eid, $sid) {
	    return $this->applications()->where('exam_id', $eid)->where('subject_id', $sid)->exists();
    }

    public function examlanguage($eid, $sid) {
        return $this->applications()->where('exam_id', $eid)->where('subject_id', $sid)->first()->language->language;
    }
    public function lgstate(){
        return $this->belongsTo('App\Lgstate','state_id','id');
    }

    public function district(){
        return $this->belongsTo('App\District');
    }

    public function subdistrict(){
        return $this->belongsTo('App\Subdistrict');
    }

    public function village(){
        return $this->belongsTo('App\Village');
    }


    public function plgstate(){
        return $this->belongsTo('App\Lgstate','pstate_id','id');
    }

    public function pdistrict(){
        return $this->belongsTo('App\District');
    }

    public function psubdistrict(){
        return $this->belongsTo('App\Subdistrict');
    }

    public function pvillage(){
        return $this->belongsTo('App\Village');
    }

    public function supplimentaryresults(){
        return $this->hasMany('App\Supplimentaryresult');
    }

    
    public function newresults(){
        return $this->hasMany('App\Newresult');
    }

    public function allresults(){
        return $this->hasMany('App\Allresult');
    }


    public function newresultreevaluations(){
        return $this->hasMany('App\Newresultreevaluation');
    }

    public function numbertoword($number){
        

        $words = array(
            '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five',
            '6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten',
            '11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fourteen','15' => 'fifteen',
            '16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty',
            '30' => 'thirty','40' => 'forty','50' => 'fifty','60' => 'sixty','70' => 'seventy',
            '80' => 'eighty','90' => 'ninety');
        
        //First find the length of the number
        $number_length = strlen($number);
        //Initialize an empty array
        $number_array = array(0,0,0,0,0,0,0,0,0);        
        $received_number_array = array();
        
        //Store all received numbers into an array
        for($i=0;$i<$number_length;$i++){    
              $received_number_array[$i] = substr($number,$i,1);    
          }
    
        //Populate the empty array with the numbers received - most critical operation
        for($i=9-$number_length,$j=0;$i<9;$i++,$j++){ 
            $number_array[$i] = $received_number_array[$j]; 
        }
    
        $number_to_words_string = "";
        //Finding out whether it is teen ? and then multiply by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
        for($i=0,$j=1;$i<9;$i++,$j++){
            //"01,23,45,6,78"
            //"00,10,06,7,42"
            //"00,01,90,0,00"
            if($i==0 || $i==2 || $i==4 || $i==7){
                if($number_array[$j]==0 || $number_array[$i] == "1"){
                    $number_array[$j] = intval($number_array[$i])*10+$number_array[$j];
                    $number_array[$i] = 0;
                }
                   
            }
        }
    
        $value = "";
        for($i=0;$i<9;$i++){
            if($i==0 || $i==2 || $i==4 || $i==7){    
                $value = $number_array[$i]*10; 
            }
            else{ 
                $value = $number_array[$i];    
            }            
            if($value!=0)         {    $number_to_words_string.= $words["$value"]." "; }
            if($i==1 && $value!=0){    $number_to_words_string.= "Crores "; }
            if($i==3 && $value!=0){    $number_to_words_string.= "Lakhs ";    }
            if($i==5 && $value!=0){    $number_to_words_string.= "Thousand "; }
            if($i==6 && $value!=0){    $number_to_words_string.= "Hundred "; }            
    
        }
        if($number_length>9){ $number_to_words_string = "Sorry This does not support more than 99 Crores"; }
        return ucwords(strtolower($number_to_words_string));
}
}
