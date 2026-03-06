<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answerkey extends Model
{
    protected $fillable = [
        'subject_id','examtimetable_id','answerkey','total_marks','qpset'
    ];
}
