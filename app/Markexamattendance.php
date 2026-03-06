<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Markexamattendance extends Model
{
    //
    protected $fillable = [
        "exam_id", "externalexamcenter_id", "examtimetable_id", "application_id", "language_id",
        "externalattendance_id", "filename", "answersheet_serialnumber", "dummy_number", "approvedprogramme_id", "bundle_number", "mark"
    ];

    public function exam() {
        return $this->belongsTo('App\Exam');
    }

    public function externalexamcenter() {
        return $this->belongsTo('App\Externalexamcenter');
    }

    public function examtimetable() {
        return $this->belongsTo('App\Examtimetable');
    }

    public function application() {
        return $this->belongsTo('App\Application');
    }

    public function language() {
        return $this->belongsTo('App\Language');
    }

    public function externalattendance() {
        return $this->belongsTo('App\Externalattendance');
    }

    public function approvedprogramme() {
        return $this->belongsTo('App\Approvedprogramme');
    }
}
