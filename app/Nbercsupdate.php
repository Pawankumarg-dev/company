<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nbercsupdate extends Model
{
    //
    protected $fillable = [
        "user_id", "centersuperintendent_id", "remarks"
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function centersuperintendent() {
        return $this->belongsTo('App\Centersuperintendent');
    }
}
