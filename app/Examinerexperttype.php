<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examinerexperttype extends Model
{
    //
    protected $fillable = [
        "name", "abbreviation"
    ];

    public function examinerexpertroles() {
        return $this->hasMany('App\Examinerexpertrole');
    }
}
