<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correctionquerycandidatedocument extends Model
{
    //
    protected $fillable = [
        "inward_number", "inward_date", "received_marksheet", "received_certificate", "document_remark"
    ];

    protected $dates = [
        "inward_date",
    ];
}
