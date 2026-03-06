<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Markchange extends Model
{
    protected $fillable = [
        'term','user_id','comment','document','exam_id','subjecttype_id'
    ];
	
}
