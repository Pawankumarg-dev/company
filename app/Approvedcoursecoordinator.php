<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approvedcoursecoordinator extends Model
{
    //
    protected $fillable = [
        "coursecoordinator_id", "institute_id", "programme_id", "joining_date", "relieving_date", "active_status"
    ];

    protected $dates = [
        "joining_date", "relieving_date",
    ];

    public function coursecoordinator()
    {
        return $this->belongsTo('App\Coursecoordinator');
    }
    public function institute()
    {
        return $this->belongsTo('App\Institute');
    }
    public function programme()
    {
        return $this->belongsTo('App\Programme');
    }
}
