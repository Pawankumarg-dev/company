<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sessionvalidation extends Model
{
    protected $fillable = [
        'user_id','session_id','ip' 
    ];
}
