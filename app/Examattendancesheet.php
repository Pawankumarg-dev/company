<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examattendancesheet extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'approvedprogramme_id','exam_id','subject_id','filename'
    ];

}
