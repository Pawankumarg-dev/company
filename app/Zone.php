<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    //
    protected $fillable = [
        "name", "code",
    ];

    public function externalexamcenters()
    {
        return $this->hasMany('App\Externalexamcenter');
    }
}
