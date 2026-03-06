<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reevaluationpayment extends Model
{
    //
    protected $fillable = [
        'reevaluationapplication_id', 'paymenttype_id', 'reevaluationfee_id',
        'paymentbank_id', 'payment_type', 'amount_paid', 'payment_number', 'payment_status', 'payment_date',
        'verified_date', 'verified_by',
        'receipt_number', 'receipt_date',
        'active_status'
    ];

    

    protected $dates = [
        'payment_date', 'receipt_date', 'verified_date'
    ];

    public function reevaluationapplication() {
        return $this->belongsTo('App\Reevaluationapplication');
    }

    public function paymenttype() {
        return $this->belongsTo('App\Paymenttype');
    }

    public function reevaluationfee() {
        return $this->belongsTo('App\Reevaluationfee');
    }

    public function paymentbank() {
        return $this->belongsTo('App\Paymentbank');
    }
}
