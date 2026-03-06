<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examinerexpert extends Model
{
    //
    protected $fillable = [
        "name", "password", "relationtype_id", "relation_name", "dob", "doc_dob", "photo", "signature", "gender_id",
        "contactnumber1", "contactnumber2", "email", "aadhaarcard_no", "address1", "address2", "address3",
        "city_id", "postoffice", "rci_crrno", "doc_rci_crrno", "pancard_no", "doc_pancard", "bankaccount_no",
        "ifsc_code", "paymentbank_id", "doc_passbook", "code", "active_status", "status_id", "user_id",
        "debarred_status"
    ];


    public function relationtype() {
        return $this->belongsTo('App\Relationtype');
    }

    public function gender() {
        return $this->belongsTo('App\Gender');
    }

    public function status() {
        return $this->belongsTo('App\Status');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function paymentbank() {
        return $this->belongsTo('App\Paymentbank');
    }

    public function examinerexpertroles() {
        return $this->hasMany('App\Examinerexpertrole');
    }

    public function examinerexpertknownlanguages() {
        return $this->hasMany('App\Examinerexpertknownlanguage');
    }

    public function examinerexpertqualifications() {
        return $this->hasMany('App\Examinerexpertqualification');
    }

    public function examinerexpertexperiences() {
        return $this->hasMany('App\Examinerexpertexperience');
    }
}
