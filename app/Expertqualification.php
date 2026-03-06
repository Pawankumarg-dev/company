<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expertqualification extends Model
{
    //
    protected $fillable = [
        "expert_id", "course_type", "course_name", "course_mode", "institute_name", "state_id", "exambody_name",
        "course_complete_year", "certificate_no"
    ];

    public function expert() {
        return $this->belongsTo('App\Expert');
    }

    public function state() {
        return $this->belongsTo('App\State');
    }
}
