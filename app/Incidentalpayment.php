<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incidentalpayment extends Model
{
    //
    protected $fillable = [
        'incidentalfee_id', 'institute_id', 'approvedprogramme_id', 'paymenttype_id', 'paymentbank_id', 'payment_date',
        'payment_number', 'status_id', 'user_id', 'reference_number', 'filename', 'payment_remark', 'amount_paid',
        'verify_remarks', 'verified_on', 'institute_id', 'name', 'designation', 'mobilenumber', 'email', 'order_id',
        'payment_mode'
    ];

    protected $dates = [
        'payment_date', 'verified_on'
    ];

    public function incidentalfee() {
        return $this->belongsTo('App\Incidentalfee');
    }

    public function institute() {
        return $this->belongsTo('App\Institute');
    }

    public function approvedprogramme() {
        return $this->belongsTo('App\Approvedprogramme');
    }

    public function paymenttype() {
        return $this->belongsTo('App\Paymenttype');
    }

    public function paymentbank() {
        return $this->belongsTo('App\Paymentbank');
    }

    public function status() {
        return $this->belongsTo('App\Status');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function order() {
        return $this->belongsTo('App\Order');
    }
}
