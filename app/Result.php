<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'result'
    ];

    public function marks() {
        return $this->hasMany('App\Mark');
    }

    public function applications() {
        return $this->hasMany('App\Application');
    }
}
