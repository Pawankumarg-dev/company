<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'institute_id', 'academicyear_id', 'totalamount','transactionid','date','bank','remark','status_id','type'
    ];
	
    public function institute()
    {
        return $this->belongsTo('App\Institute');
    }
	public function status()
    {
        return $this->belongsTo('App\Status');
    }
}
