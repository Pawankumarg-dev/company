<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nberleveltype extends Model
{
    //
    protected $fillable = [
        'level',
    ];

    public function nbers() {
        return $this->hasMany('App\Nber');
    }
}
