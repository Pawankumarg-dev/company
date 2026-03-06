<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classattendancepercentage extends Model
{
    //
    protected $fillable = [
        'programme_id', 'academicyear_id', 'term', 'minimum_theory_percentage', 'minimum_practical_percentage',
        'exception_percentage', 'scheme_of_examination', 'active_status'
    ];

    public function programme(){
        return $this->belongsTo('App\Programme');
    }

    public function academicyear(){
        return $this->belongsTo('App\Academicyear');
    }

    public function classattendancepercentages() {
        return $this->hasMany('App\Classattendancepercentage');
    }
}
