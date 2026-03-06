<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name', 'state_id'
    ];

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function institute()
    {
        return $this->belongsTo('App\Institute');
    }

    public function experts(){
        return $this->hasMany('App\Expert');
    }

    public function baslpcandidates(){
        return $this->hasMany('App\Baslpcandidate');
    }

    public function baslpexamcenters(){
        return $this->hasMany('App\Baslpexamcenter');
    }
}
