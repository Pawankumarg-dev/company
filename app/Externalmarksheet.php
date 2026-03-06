<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Externalmarksheet extends Model
{
    //
    protected $fillable = [
        'exam_id', 'approvedprogramme_id', 'term', 'filename', 'subjecttype_id'
    ];
    public function exam(){
        return $this->belongsTo('App\Exam');
    }
    public function subjecttype(){
        return $this->belongsTo('App\Subjecttype');
    }
}
