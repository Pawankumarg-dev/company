<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bloodgroup extends Model
{
    //
    protected $fillable = [
        'type'
    ];

    public function nbers() {
        return $this->hasMany('App\Nber');
    }
}
