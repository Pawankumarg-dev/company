<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidateDataHistory extends Model
{
    protected $table = 'candidate_history';
    protected $fillable = [
        
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
        'doc_disability',
        'doc_community',
        'doc_percentage_exception',
        'community_id',
        'disability_id',
        'disability_name',
        'gender_id',
        'city_id',
        'status_id',
        'user_id',
        'coursepercentage',
        'course_percentage',
        'class',
        'coursecompleted_status',
        'nationality_id',
        'isdisabled',
        'aadhar',
        'udid',
        'ews',
        'district_id',
        'subdistrict_id',
        'village_id',
        'state_id',
        'pstate_id',
        'pdistrict_id',
        'psubdistrict_id',
        'pvillage_id',
        'doc_tenth',
        'doc_twelveth',
        'doc_application',
        'disabilitytype_id',  
        'disabilityper',        
        'pwd', 'education',
       

        
    ];

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
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function nationality()
    {
        return $this->belongsTo('App\Nationality');
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
}
