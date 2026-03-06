<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paymenttype extends Model
{
    //
    protected $fillable = [
        'type', 'coursename'
    ];

    public function enrolmentpayments() {
        return $this->hasMany('App\Enrolmentpayment');
    }

    public function examinationpayments() {
        return $this->hasMany('App\Enrolmentpayment');
    }

    public function incidentalpayments() {
        return $this->hasMany('App\Incidentalpayment');
    }
}
