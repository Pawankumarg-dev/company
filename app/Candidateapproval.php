<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidateapproval extends Model
{
    protected $fillable = [
        'user_id', 'candidate_id','comment',
    ];
	
    public function candidate()
    {
        return $this->belongsTo('App\Candidate');
    }
	public function user()
    {
        return $this->belongsTo('App\User');
    }
}
