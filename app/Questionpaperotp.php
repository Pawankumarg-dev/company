<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionpaperotp extends Model
{
    protected $fillable = [
        'externalexamcenter_id','examschedule_id','otp','exam_id','verified','verified_at'
    ];
	
}
