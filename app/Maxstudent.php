<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maxstudent extends Model
{
	
	
    public function institute()
    {
        return $this->belongsTo('App\Institute');
    }

}

