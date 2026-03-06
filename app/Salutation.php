<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salutation extends Model
{
    protected $fillable = [
        'salutation', 
    ];
	
	 public function candidates()
    {
        return $this->hasMany('App\Candidate');
    }

    public function coursecoordinators(){
        return $this->hasMany('App\Coursecoordinator');
    }
}
