<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacultyLanguage extends Model
{
    protected $fillable = [
        'faculty_id', 'exam_id', 'language_id','course_id'
    ];
}
