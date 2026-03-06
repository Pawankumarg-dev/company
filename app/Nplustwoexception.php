<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nplustwoexception extends Model
{
    protected $fillable = [
      'candidate_id','allapplicant_id','reason','document','status','exam'
    ];

    
}
