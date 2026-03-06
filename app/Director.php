<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    //
    protected $fillable = [
        'user_id', 'title_id', 'name', 'designation', 'gender_id', 'dob', 'mobile_number',
        'email_address', 'active_status','admin','nber_id'
    ];

    

    public function user() {
        return $this->belongsTo('App\User');
    }

 

}
