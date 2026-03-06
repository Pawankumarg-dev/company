<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
	  
class Gracemarksfilter extends Model
{
	public $timestamps = false;
	public function candidate()
    {
    	return $this->belongsTo('App\Candidate');
    }
	public function programme()
    {
    	return $this->belongsTo('App\Programme');
    }
	public function approvedprogramme()
    {
    	return $this->belongsTo('App\Approvedprogramme');
    }
	public function reevaluationapplication(){
		return $this->belongsTo('App\Reevaluationapplicaiton');
	}

	public function currentapplicant(){
		return $this->belongsTo('App\Currentapplicant');
	}

}
