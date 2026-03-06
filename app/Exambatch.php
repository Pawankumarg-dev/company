<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exambatch extends Model
{
    //
    protected $fillable = [
        'exam_id', 'programme_id', 'academicyear_id', 'term',
    ];

    public function exam(){
        return $this->belongsTo('App\Exam');
    }

    public function programme(){
        return $this->belongsTo('App\Programme');
    }

    public function academicyear(){
        return $this->belongsTo('App\Academicyear');
    }
}
