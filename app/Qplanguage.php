<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qplanguage extends Model
{
    
    public function language(){
        return $this->belongsTo('App\Language');
    }
}
