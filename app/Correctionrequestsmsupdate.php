<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correctionrequestsmsupdate extends Model
{
    //
    protected $fillable = [
        "correctionrequest_id", "contactnumber", "smstemplate_id", "sms_content", "response"
    ];

    public function correctionrequest() {
        return $this->belongsTo("App\Correctionrequest");
    }
}
