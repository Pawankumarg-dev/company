<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    //
    protected $fillable = [
        "code", "password", "title", "name", "relationtype_id", "relation_name", "dob", "gender_id", "has_disability",
        "contactnumber1", "contactnumber2", "email", "aadhaarcard_no", "debarred_status", "active_status", "has_crr_no",
        "crr_no", "crr_no_issued_year", "crr_no_expiry_year", "file_crr_no", "door_no", "building_name", "street1", "street2",
        "street3", "postoffice", "talukoffice", "city_id", "pincode", "landmark", "pancard_no", "bank_account_no",
        "bank_ifsc_code", "bank_branch_name", "paymentbank_id", "state_id", "file_bank_passbook", "user_id", "file_photo",
        "application_no", "application_status", "stages_passed"
    ];

    protected $dates = [
        'dob',
    ];

    public function relationtype() {
        return $this->belongsTo('App\Relationtype');
    }

    public function gender()
    {
        return $this->belongsTo('App\Gender');
    }

    public function city(){
        return $this->belongsTo('App\City');
    }

    public function paymentbank(){
        return $this->belongsTo('App\Paymentbank');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function expertqualifications(){
        return $this->hasMany('App\Expertqualification');
    }

    public function expertrciqualifications(){
        return $this->hasMany('App\Expertrciqualification');
    }

    public function expertnonteachingexperiences(){
        return $this->hasMany('App\Expertnonteachingexperience');
    }

    public function expertteachingexperiences(){
        return $this->hasMany('App\Expertteachingexperience');
    }

    public function expertlanguages(){
        return $this->hasMany('App\Expertlanguage');
    }
    public function externalexamcenterdetails(){
        return $this->hasMany('App\Externalexamcenterdetail');
    }
}
