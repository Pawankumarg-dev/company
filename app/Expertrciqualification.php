<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expertrciqualification extends Model
{
    //
    protected $fillable = [
        "expert_id", "rcicourse_id", "institute_name", "state_id", "exambody_name", "course_complete_year", "certificate_no"
    ];

    public function expert() {
        return $this->belongsTo('App\Expert');
    }

    public function rcicourse() {
        return $this->belongsTo('App\Rcicourse');
    }

    public function state() {
        return $this->belongsTo('App\State');
    }

}
