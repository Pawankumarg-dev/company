<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'order_number', 'ccavenue_referencenumber', 'bank_referencenumber', 'order_status', 'status_message', 'total_amount',
        'actual_amount', 'transaction_fee', 'service_fee', 'payment_date', 'transaction_remarks', 'reference_parameters',
        'payment_remarks','billing_name','billing_designation','billing_tel','billing_email','candidate_id',
    ];

    protected $dates = [
        'payment_date'
    ];

    public function affiliationfees(){
        return $this->belongsToMany('App\Affiliationfee');
    }
    public function enrolmentfeepayments(){
        return $this->belongsToMany('App\Enrolmentfeepayment');
    }
}
