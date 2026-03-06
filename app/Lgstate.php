<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lgstate extends Model
{
    public function statezones(){
        return $this->hasMany('App\Statezone');
    }

    public function districts() {
        return $this->hasMany('App\District','state_code','state_code','code');
    }

    public function language(){
                return $this->belongsTo('App\Language','language_id','id');

    }

}
