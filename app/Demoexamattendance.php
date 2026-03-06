<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demoexamattendance extends Model
{
    //
    protected $fillable = [
        "exam", "subject_id", "language_id", "enrolmentno", "name",
        "externalattendance_id", "filename", "answersheet_serialnumber"
    ];

    public function language() {
        return $this->belongsTo('App\Language');
    }

    public function externalattendance() {
        return $this->belongsTo('App\Externalattendance');
    }
}
