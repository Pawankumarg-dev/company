<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nbercloupdate extends Model
{
    //
    protected $fillable = [
        "user_id", "clo_id", "remarks"
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function clo() {
        return $this->belongsTo('App\Clo');
    }
}
