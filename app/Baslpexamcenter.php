<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baslpexamcenter extends Model
{
    //
    protected $fillable = [
        "code", "name", "abbreviation", "address", "city_id", "pincode", "landmark", "contactnumber1", "contactnumber2",
        "email", "sortorder"
    ];


    public function city(){
        return $this->belongsTo('App\City');
    }

    public function baslpexamcenterdetails(){
        return $this->hasMany('App\Baslpexamcenterdetail');
    }
}
