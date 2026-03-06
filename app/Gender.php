<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $fillable = [
        "gender"
    ];
	
	 public function candidates()
    {
        return $this->hasMany('App\Candidate');
    }

    public function examinerexperts() {
        return $this->hasMany('App\Examinerexpert');
    }

    public function experts(){
        return $this->hasMany('App\Experts');
    }

    public function baslpcandidates(){
        return $this->hasMany('App\Baslpcandidate');
    }

    public function coursecoordinators(){
        return $this->hasMany('App\Coursecoordinator');
    }
}
