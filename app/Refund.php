<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    public $timestamps = false;

    protected $fillable = [
       'reevaluationapplication_id', 'cname', 'bank', 'ifsccode', 'accountno','refno','refunddate'
    ];

    public function Reevaluationapplication(){
        return $this->belongsTo('App\Reevaluationapplication');
    }

    
    

}
