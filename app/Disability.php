<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disability extends Model
{
	protected $fillable = [
        'disability', 
    ];
    public function candidates()
    {
        return $this->hasMany('App\Candidate');
    }
}
