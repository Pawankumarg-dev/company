<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statedistrict extends Model
{
    protected $fillable = [
        'name','state','statezone_id'
    ];

    public function statezone(){
        return $this->belongsTo('App\Statezone');
    }
}
