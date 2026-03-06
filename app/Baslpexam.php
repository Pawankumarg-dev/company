<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baslpexam extends Model
{
    //
    protected $fillable = [
        "name", "date", "starttime", "endtime", "active_status"
    ];

    protected $dates = [
        "date",
    ];



    public function baslpexamcenterdetails(){
        return $this->hasMany('App\Baslpexamcenterdetail');
    }
}
