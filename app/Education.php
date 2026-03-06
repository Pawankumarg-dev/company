<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';
    public $timestamps = false;

    protected $fillable = [
        'candidate_id', 'board','yop','tmarks','omarks','percentage','subjects','edugrade',
    ];
}

