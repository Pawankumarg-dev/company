<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ApprovedProgram;
class Faculty extends Model
{
    //
    protected $fillable = [
        'institute_id', 
        'joining_date',
        'crr_no',
        'crr_registration_date',
        'crr_expiry',
        'mobileno',
        'name',
        'fathername',
        'address',
        'state',
        'district',
        'city',
        'pin',
        'qualification',
        'programme_id',
        'photo',
        'email',
        'course_corordinator_for',
        'core',
        'verified',
        'user_id',
        'password',
        'emailed',
        'nber_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function programmes()
    {
    	return $this->belongsToMany('App\Programme');
    }

    public function courses()
    {
    	return $this->belongsToMany('App\Course');
    }

    public function coordinator(){
        return $this->belongsTo('App\Course','course_corordinator_for');
    }

    public function facultysubjects(){
        return $this->hasMany('App\Facultysubject');
    }

    public function approveprogrammes()
    {
        return $this->hasMany('App\Approvedprogramme');
    }
    public function responsibility()
    {
        return $this->hasMany('App\FacultyResponsibility');
    }
    
}

