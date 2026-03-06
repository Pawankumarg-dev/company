<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paymentbank extends Model
{
    //
    protected $fillable = [
        'bankname',
    ];

    public function enrolmentpayments() {
        return $this->hasMany('App\Enrolmentpayment');
    }

    public function examinerexperts() {
        return $this->hasMany('App\Examinerexpert');
    }

    public function examinationpayments() {
        return $this->hasMany('App\Enrolmentpayment');
    }

    public function experts(){
        return $this->hasMany('App\Expert');
    }

    public function incidentalpayments() {
        return $this->hasMany('App\Incidentalpayment');
    }
}
