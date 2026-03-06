<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subjectofevaluator extends Model
{
    protected $fillable = [
        'subject_id','examtimetable_id','evaluator_id','exam_id','language_id','faculty_id'
    ];

    public function evaluator()
    {
    	return $this->belongsTo('App\Evaluator');
    }

    public function faculty()
    {
    	return $this->belongsTo('App\Faculty');
    }

    public function examtimetable()
    {
    	return $this->belongsTo('App\Examtimetable');
    }

    public function subject()
    {
    	return $this->belongsTo('App\Subject');
    }

    public function language()
    {
    	return $this->belongsTo('App\Language');
    }

}
