<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Externalresult extends Model
{
    //
    protected $fillable = [
        'result', 'coursename'
    ];

    public function applications() {
        return $this->hasMany('App\Application');
    }
}
