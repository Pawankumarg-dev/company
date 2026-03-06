<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facultysubject extends Model
{
    public $timestamps = false;
    
	protected $fillable = [
        'institute_id',
        'faculty_id',
        'course_id',
        'subject_id',
    ];

    public function subject() {
        return $this->belongsTo('App\Subject');
    }


}
