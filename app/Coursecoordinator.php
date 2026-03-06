<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coursecoordinator extends Model
{
    //
    protected $fillable = [
        'institute_id', 'code', 'title_id', 'name', 'dob', 'gender_id', 'disability_status',
        'mobile_number', 'whatsapp_number',
        'email_address',
        'address', 'city_id', 'pincode',
        'registration_number', 'rci_qualifications', 'other_qualifications',
        'courses_handling', 'present_working_status', 'teaching_experience',
        'active_status'
    ];

    protected $dates = [
        'dob',
    ];

    public function institute() {
        return $this->belongsTo('App\Institute');
    }
    public function title(){
        return $this->belongsTo('App\Title');
    }
    public function salutation(){
        return $this->belongsTo('App\Salutation');
    }
    public function relationtype(){
        return $this->belongsTo('App\Relationtype');
    }
    public function gender(){
        return $this->belongsTo('App\Gender');
    }
    public function city() {
        return $this->belongsTo('App\City');
    }
    public function coursecoordinatorcoursetype() {
        return $this->belongsTo('App\Coursecoordinatorcoursetype');
    }
    public function coursecoordinatorpastteachingexperiences() {
        return $this->hasMany('App\Coursecoordinatorpastteachingexperience');
    }
}
