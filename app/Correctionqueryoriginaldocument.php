<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correctionqueryoriginaldocument extends Model
{
    //
    protected $fillable = [
        "correctionquerycandidate_id", "inward_number", "inward_date", "document_type", "document_number", "document_remark",
        "verified_by", "verified_on"
    ];

    protected $dates = [
        "inward_date", "verified_on",
    ];

    public function correctionquerycandidate() {
        return $this->belongsTo('App\Correctionquerycandidate');
    }
}
