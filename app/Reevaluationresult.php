<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reevaluationresult extends Model
{
    //
    protected $fillable = [
        'reevaluation_id', 'mark_id', 'application_id', 'candidate_id', 'subject_id',
        'actual_external_mark', 'reevaluated_external_mark', 'reevaluation_remarks',
        'publish_status'
    ];

    public function reevaluation() {
        return $this->belongsTo('App\Reevaluation');
    }

    public function mark() {
        return $this->belongsTo('App\Mark');
    }

    public function application() {
        return $this->belongsTo('App\Application');
    }

    public function candidate() {
        return $this->belongsTo('App\Candidate');
    }

    public function subject() {
        return $this->belongsTo('App\Subject');
    }

}
