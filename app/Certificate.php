<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    //
    protected $fillable = [
        "exam_id", "candidate_id", "serial_number"
    ];

    public function exam() {
        return $this->belongsTo('App\Exam');
    }

    public function candidate_id() {
        return $this->belongsTo('App\Candidate');
    }
}
