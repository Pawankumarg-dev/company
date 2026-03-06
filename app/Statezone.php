<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statezone extends Model
{
    protected $fillable = [
        'name','state'
    ];

    public function statedistricts(){
        return $this->hasMany('App\Statedistrict');
    }

}
