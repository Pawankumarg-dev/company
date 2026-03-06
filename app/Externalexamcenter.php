<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Externalexamcenter extends Model
{
    //
    protected $fillable = [
        "code", "name", "address", "district", "state", "pincode", "contactnumber1", "contactnumber2", "email1","email2", "user_id",
        "active_status", "password", "zone_id",'cloname','contactperson','clocontact','cloemail','lgstate_id','seats_per_room','qpuser_id','qppassoword','exam_id','district',
        'confirm_availability','confirm_address','confirm_mobile','confirm_email','superintendent_declearation','superintendent','session_min_capacity','classrooms',
'washrooms','cctv_facility','computers','printers','photocopiers','scanners','support_staff','technical_staff','accessibility','drinking_water','security_guards','special_permissions_details','classroom_count','open_space','principal_name','principal_mobile','principal_whatsapp'
    ];

    public function questionpaperotps(){
        return $this->hasMany('App\Questionpaperotp');
    }

    public function questionpaperdownloadhistories(){
        return $this->hasMany('App\Questionpaperdownloadhistory');
    }

    public function city() {
        return $this->belongsTo('App\City');
    }
    public function institute(){
        return $this->belongsTo('App\Institute');
    }
    public function lgstate(){
        return $this->belongsTo('App\Lgstate');
    }

    public function lgdistrict(){
        return $this->belongsTo('App\District','district');
    }

    public function externalexamcenterdetails(){
        return $this->hasMany('App\Externalexamcenterdetail');
    }

    public function applications()
    {
        return $this->hasMany('App\Application');
    }

    public function zone() {
        return $this->belongsTo('App\Zone');
    }

    public function markexamattendances() {
        return $this->hasMany('App\Examattendance');
    }

    public function evaluationcenter(){
        return $this->belongsToMany('App\Evaluationcenter','evaluationcenterdetails','externalexamcenter_id','evaluationcenter_id');
    }

    public function user(){
        return $this->belongsTo('App\User');

    }
}
