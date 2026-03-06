<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
	protected $fillable = [
        'name', 'nber_id','programme_id'
    ];
	
    public function programmes()
    {
        return $this->hasMany('App\Programme');
    }
    public function nber(){
        return $this->belongsTo('App\Nber');
    }

    public function programme(){
        return $this->belongsTo('App\Programme');
    }
}
