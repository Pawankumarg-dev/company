<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
	protected $fillable = [
        'community', 
    ];

   	public function candidates()
    {
        return $this->hasMany('App\Candidate');
    }

    public function baslpcandidates()
    {
        return $this->hasMany('App\Baslpcandidate');
    }
}
