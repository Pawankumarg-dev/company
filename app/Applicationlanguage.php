<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicationlanguage extends Model
{
    protected $fillable = [
        'subject_id','examtimetable_id','exam_id','no_of_languages'
    ];
}
