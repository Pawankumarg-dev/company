<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nberdesignation extends Model
{
    //
    protected $fillable = [
        'designation', 'coursename'
    ];

    public function nbers() {
        return $this->hasMany('App\Nber');
    }
}
