<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidatefile extends Model
{
     protected $fillable = [
        'candidate_id', 'filename','description',
    ];
	
    public function candidate()
    {
        return $this->belongsTo('App\Candidate');
    }
}
