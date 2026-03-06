<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrolmentpayment extends Model
{
    //
    protected $fillable = [
        'enrolmentfee_id', 'candidate_id', 'latefee_remark', 'paymenttype_id', 'paymentbank_id', 'payment_date',
        'payment_number', 'status_id', 'user_id', 'reference_number', 'filename', 'payment_remark', 'amount_paid',
        'fee_exemption', 'institute_id', 'verify_remarks', 'verified_on', 'name', 'designation', 'mobilenumber', 'email',
        'order_id', 'payment_mode'
    ];

    protected $dates = [
        'payment_date', 'verified_on'
    ];

    public function enrolmentfee() {
        return $this->belongsTo('App\Enrolmentfee');
    }

    public function candidate() {
        return $this->belongsTo('App\Candidate');
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

    public function institute() {
        return $this->belongsTo('App\Institute');
    }

    public function order() {
        return $this->belongsTo('App\Order');
    }
}


