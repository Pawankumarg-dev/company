<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qppattern extends Model
{
    protected $fillable = [
        'subject_id','examtimetable_id','heading','qpset','number_of_questions','number_of_questions_to_answer','marks_per_question','pagenumber'
    ];
}
