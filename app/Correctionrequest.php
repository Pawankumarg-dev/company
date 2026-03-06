<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correctionrequest extends Model
{
    //
    protected $fillable = [
        "reference_number", "candidate_id", "subject", "status", "active_status"
    ];

    public function candidate() {
        return $this->belongsTo('App\Candidate');
    }
}
