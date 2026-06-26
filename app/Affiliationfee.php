<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affiliationfee extends Model
{
    public $timestamps = false;
    
	protected $fillable = [
        'institute_id',
        'academicyear_id',
        'order_id',
        'orderstatus_id',
        'approvedprogramme_id',
    'bank_name',
    'branch_address',
    'account_number',
    'account_name',
    'ifsc_code',
    'transaction_details',
    'transaction_no',
    'amount',
    'term',
    'transaction_date'
    ];

    public function order(){
        return $this->belongsTo('App\Order');
    }
    public function academicyear(){
        return $this->belongsTo('App\Academicyear');
    }

    public function orders(){
        return $this->belongsToMany('App\Order');
    }
    public function approvedprogramme(){
		return $this->belongsTo('App\Approvedprogramme');
	}
    
}
