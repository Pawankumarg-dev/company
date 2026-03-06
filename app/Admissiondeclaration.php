<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admissiondeclaration extends Model
{
    protected $fillable = [
        'approvedprogramme_id','institute_id','academicyear_id','email','name','institute_name','otp','no_of_candidates','opt_verified_on','mobile',
        'previous_candidates','previous_name','previous_email','previous_mobile','previous_verified_on'
    ];
	public function institute()
    {
        return $this->belongsTo('App\Institute');
    }
    public function approvedprogramme()
    {
        return $this->belongsTo('App\Approvedprogramme');
    }
}
