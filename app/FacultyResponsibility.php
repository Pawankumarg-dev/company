<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacultyResponsibility extends Model
{
    protected $fillable = [
        'faculty_id', 'exam_id', 'responsibility_type','verified','evaluator_verified','practical_examiner_verified','clo_verified','course_id'
    ];

  
}
