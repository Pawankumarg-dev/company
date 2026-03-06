<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oldapplicant extends Model
{
	protected $fillable = [
	    'candidate_id', 'exam_id','approvedprogramme_id',
    ];
    
    public function applications()
    {
    	return $this->hasMany('App\Application');
    }

    public function approvedprogramme()
    {
        return $this->belongsTo('App\Approvedprogramme');
    }

    public function candidate()
    {
        return $this->belongsTo('App\Candidate');
    }
  
}
