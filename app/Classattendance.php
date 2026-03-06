<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classattendance extends Model
{
    //
    protected $fillable = [
        'candidate_id', 'classattendancepercentage_id', 'theory_percentage', 'practical_percentage', 'attendance_percentage',
        'file_attendance_percentage', 'exception_percentage', 'file_exception_percentage', 'exception_percentage_remarks',
        'status_id', 'active_status', 'verified_by', 'verification_remarks'
    ];

    public function candidate(){
        return $this->belongsTo('App\Candidate');
    }

    public function classattendancepercentage(){
        return $this->belongsTo('App\Classattendancepercentage');
    }

    public function status(){
        return $this->belongsTo('App\Status');
    }
}
