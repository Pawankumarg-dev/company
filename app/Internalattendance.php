<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Internalattendance extends Model
{
    //
    protected $fillable = [
        'attendance'
    ];

    public function applications() {
        return $this->hasMany('App\Applications');
    }
}
