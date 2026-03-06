<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrolmentfee extends Model
{
    //
    protected $fillable = [
        'academicyear_id', 'programme_id', 'enrolment_fee', 'late_fee', 'ontimepayment_startdate',
        'ontimepayment_enddate', 'penaltypayment_startdate', 'penaltypayment_enddate',
        'superlate_fee', 'superlatepayment_startdate', 'superlatepayment_enddate',
    ];

    protected $dates = [
        'ontimepayment_startdate', 'ontimepayment_enddate', 'penaltypayment_startdate', 'penaltypayment_enddate',
    ];

    public function academicyear() {
        return $this->belongsTo('App\Academicyear');
    }

    public function programme() {
        return $this->belongsTo('App\Programme');
    }

    public function enrolmentpayments() {
        return $this->hasMany('App\Enrolmentpayment');
    }
}
