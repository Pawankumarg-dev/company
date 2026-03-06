<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consolidatedtheoryclassattendancepercentage extends Model
{
    //
    protected $fillable = [
        "candidate_id", "term", "percentage", "exception_status", "exception_document", "percentage_document",
        "eligibility_status", "active_status"
    ];

    public function candidate() {
        return $this->belongsTo('App\Candidate');
    }
}
