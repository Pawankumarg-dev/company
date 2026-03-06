<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Externalattendance extends Model
{
    //
    protected $fillable = [
        'attendance'
    ];

    public function applications() {
        return $this->hasMany('App\Applications');
    }

    public function markexamattendances() {
        return $this->hasMany('App\Examattendance');
    }
}
