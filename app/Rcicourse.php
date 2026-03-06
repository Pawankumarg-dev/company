<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rcicourse extends Model
{
    //
    protected $fillable = [
        "name", "abbreviation", "mode"
    ];

    public function expertrciqualifications(){
        return $this->hasMany('App\Expertrciqualification');
    }
}
