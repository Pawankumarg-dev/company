<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correctionquerycandidatepayment extends Model
{
    //
    protected $fillable = [
        "correctionquerycandidate_id", "inward_number", "inward_date",
        "paymenttype_id", "paymentbank_id", "payment_date", "payment_number", "payment_remark", "amount_paid",
        "verified_by", "verified_on",
    ];

    protected $dates = [
        "inward_date", "payment_date", "verified_on"
    ];

    public function correctionquerycandidate() {
        return $this->belongsTo('App\Correctionquerycandidate');
    }

    public function paymenttype() {
        return $this->belongsTo('App\Paymenttype');
    }

    public function paymentbank() {
        return $this->belongsTo('App\Paymentbank');
    }
}
