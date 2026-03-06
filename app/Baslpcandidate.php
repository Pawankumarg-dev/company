<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baslpcandidate extends Model
{
    //
    protected $fillable = [
        "roll_no", "title", "name", "relationtype_id", "relation_name", "dob", "gender_id", "community_id",
        "contactnumber1", "contactnumber2",
        "email", "address", "city_id", "pincode", "file_photo", "application_year", "active_status"
    ];

    protected $dates = [
        "dob"
    ];

    public function relationtype() {
        return $this->belongsTo('App\Relationtype');
    }

    public function gender()
    {
        return $this->belongsTo('App\Gender');
    }

    public function community()
    {
        return $this->belongsTo('App\Community');
    }

    public function city(){
        return $this->belongsTo('App\City');
    }

    public function baslpexamcenterdetails(){
        return $this->hasMany('App\Baslpexamcenterdetail');
    }
}
