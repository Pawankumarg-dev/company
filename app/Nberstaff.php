<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nberstaff extends Model
{
    //
    protected $fillable = [
        'user_id', 'title_id', 'name', 'designation', 'gender_id', 'dob', 'mobile_number',
        'email_address', 'active_status','admin','nber_id'
    ];

    protected $dates = [
        'dob'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function title() {
        return $this->belongsTo('App\Title');
    }

    public function gender() {
        return $this->belongsTo('App\Gender');
    }
}
