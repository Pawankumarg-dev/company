<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relationtype extends Model
{
    //
    protected $fillable = [
        'name'
    ];

    public function examinerexperts() {
        return $this->hasMany('App\Examinerexpert');
    }

    public function experts(){
        return $this->hasMany('App\Expert');
    }

    public function baslpcandidates(){
        return $this->hasMany('App\Baslpcandidate');
    }
}
