<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correctionquerycandidate extends Model
{
    //
    protected $fillable = [
        "application_code", "candidate_id", "namecorrection_status", "namecorrection_value", "namecorrection_updatestatus",
        "fathernamecorrection_status", "fathernamecorrection_value", "fathernamecorrection_updatestatus",
        "dobcorrection_status", "dobcorrection_value", "dobcorrection_updatestatus", "correctionquerystatus_id",
        "correctionquery_type", "payment_required", "proofdocument_required", "originaldocument_required",
        "payment_status", "proofdocument_status", "originaldocument_status",
        "created_on", "created_by", "verified_on", "verified_by", "printed_on",
        "printed_by", "completed_on", "despatch_id", "tracking_number", "despatched_on",
    ];

    protected $dates = [
        "created_on", "verified_on", "printed_on", "completed_on", "despatched_on",
    ];

    public function candidate() {
        return $this->belongsTo('App\Candidate');
    }

    public function correctionquerystatus() {
        return $this->belongsTo('App\Correctionquerystatus');
    }

    public function despatch() {
        return $this->belongsTo('App\Despatch');
    }

    public function correctionquerypayment()
    {
        return $this->hasMany('App\Correctionquerypayment');
    }

    public function correctionqueryproofdocument()
    {
        return $this->hasMany('App\Correctionqueryproofdocument');
    }

    public function correctionqueryoriginaldocument()
    {
        return $this->hasMany('App\Correctionqueryoriginaldocument');
    }
}
