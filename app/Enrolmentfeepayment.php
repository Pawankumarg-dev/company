<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrolmentfeepayment extends Model
{
    public $timestamps = false;
    
	protected $fillable = [
        'institute_id',
        'academicyear_id',
        'order_id',
        'orderstatus_id',
        'nber_id'
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

    public function institute(){
        return $this->belongsTo('App\Institute');
    }
}
