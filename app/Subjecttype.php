<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subjecttype extends Model
{
    protected $fillable = [
        'type'
    ];
	
    public function subjects()
    {
        return $this->hasMany('App\Subject');
    }
}
