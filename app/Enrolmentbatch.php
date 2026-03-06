<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrolmentbatch extends Model
{
    //
    protected $fillable = [
        "academicyear_id", "programme_id", "active_status"
    ];

    public function academicyear() {
        return $this->belongsTo('App\Academicyear');
    }

    public function programme() {
        return $this->belongsTo('App\Programme');
    }
}
