<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidateexamresultdate extends Model
{
    use SoftDeletes;

    //
    protected $fillable = [
        'exam_id', 'candidate_id', 'withheld_status', 'withheld_remarks', 'specialcase_status', 'specialcase_remarks',
        'publish_status', 'publish_date',

        'underreview_status', 'underreview_remarks'
    ];

    protected $dates = [
        'publish_date'
    ];

    public function exam(){
        return $this->belongsTo('App\Exam');
    }

    public function candidate(){
        return $this->belongsTo('App\Candidate');
    }
}
