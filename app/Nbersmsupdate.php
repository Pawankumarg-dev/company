<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nbersmsupdate extends Model
{
    //
    protected $fillable = [
        'user_id', 'type', 'mobile_number', 'otp', 'sms', 'remarks'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
