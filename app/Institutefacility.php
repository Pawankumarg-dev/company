<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institutefacility extends Model
{
    //
    protected $fillable = [
        'institute_id', 'buildup_area', 'landarea', 'city_distance', 'postoffice_distance', 'available_rooms',
        'classroom_size', 'biometric_facility', 'cctv_facility'
    ];

    public function institute()
    {
        return $this->belongsTo('App\Institute');
    }
}
