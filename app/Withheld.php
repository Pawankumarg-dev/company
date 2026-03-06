<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withheld extends Model
{
    protected $fillable = [
        'exam_id', 'approvedprogramme_id', 'candidate_id', 'status'
    ];

    public function exam(){
        return $this->belongsTo('App\Exam');
    }

    public function approvedprogramme()
    {
        return $this->belongsTo('App\Approvedprogramme');
    }

    public function candidate(){
        return $this->belongsTo('App\Candidate');
    }
}
