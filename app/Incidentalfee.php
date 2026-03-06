<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incidentalfee extends Model
{
    //
    protected $fillable = [
        'programme_id', 'academicyear_id', 'term', 'fee'
    ];

    public function programme() {
        return $this->belongsTo('App\Programme');
    }

    public function academicyear() {
        return $this->belongsTo('App\Academicyear');
    }

    public function incidentalpayments() {
        return $this->hasMany('App\Incidentalpayment');
    }
}
