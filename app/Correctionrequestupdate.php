<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correctionrequestupdate extends Model
{
    //
    protected $fillable = [
        "correctionrequest_id", "update_remarks", "user_id", "active_status"
    ];

    public function correctionrequest() {
        return $this->belongsTo('App\Correctionrequest');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
