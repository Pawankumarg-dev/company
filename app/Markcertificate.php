<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Markcertificate extends Model
{
    protected $fillable = [
        'slno', 'pagenumber'
    ];

    public function marks(){
        return $this->hasMany('App\Mark');
    }
}
