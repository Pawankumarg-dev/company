<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'username', 'email', 'password','usertype_id', 'confirmation_code','database_name','id', 'use_password'
    ];
     

    public function getJWTIdentifier()
    {
        return $this->getKey(); // Eloquent model method
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
	/* The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	public function sessionvalidations(){
        return $this->hasMany('App\Sessionvalidation');
    }
	public function institute()
    {
        return $this->belongsTo('App\Institute');
    }
	public function candidateapprovals()
    {
        return $this->hasMany('App\Candidateapproval');
    }

    public function enrolmentpayments() {
        return $this->hasMany('App\Enrolmentpayment');
    }

    public function nbers() {
        return $this->hasMany('App\Nber');
    }

    public function examinerexpertroles() {
        return $this->hasMany('App\Examinerexpertrole');
    }

    public function examinerexperts() {
        return $this->hasMany('App\Examinerexpert');
    }

    public function examinationpayments() {
        return $this->hasMany('App\Enrolmentpayment');
    }

    public function experts(){
        return $this->hasMany('App\Expert');
    }

    public function incidentalpayments() {
        return $this->hasMany('App\Incidentalpayment');
    }

    public function instituteinformationupdates() {
	    return $this->hasMany('App\Instituteinformationupdate');
    }

    public function nberstaffs() {
        return $this->hasMany('App\Nberstaff');
    }

    public function nbersmsupdates() {
        return $this->hasMany('App\Nbersmsupdate');
    }
}
