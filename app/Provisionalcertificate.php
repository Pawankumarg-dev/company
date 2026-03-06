<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provisionalcertificate extends Model
{
    //
    protected $fillable = [
        'candidate_id', 'folio_number', 'authorised_sign', 'status', 'publish_status', 'print_date',
        'despatch_date', 'tracking_number',
        'exam_id', 'active_status', 'download_count', ''
    ];

    protected $dates = [
        'received_date', 'despatch_date', 'print_date',
    ];

    public function candidate() {
        return $this->belongsTo('App\Candidate');
    }

    public function exam() {
        return $this->belongsTo('App\Exam');
    }
}
