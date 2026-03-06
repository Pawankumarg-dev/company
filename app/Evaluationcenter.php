<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluationcenter extends Model
{
    //
    protected $fillable = [
        "code", "name", "password", "address", "state", "pincode", "active_status", "evaluationcenteruser_id",'enable_markentry','lgstate_id',
        'contactnumber1','contactnumber2','email1','email2','contactperson','deuser_id'
    ];

    public function evaluationcenteruser() {
        return $this->belongsTo('App\Evaluationcenteruser');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function deuser(){
        return $this->belongsTo('App\User','deuser_id');
    }

    public function externalexamcenters(){
        return $this->belongsToMany('App\Externalexamcenter','evaluationcenterdetails','evaluationcenter_id','externalexamcenter_id');
    }

    public function lgstate(){
        return $this->belongsTo('App\Lgstate');
    }

}
