<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidateexaminationpayment extends Model
{
    //
    protected $fillable = [
        'examinationpayment_id', 'application_id', 'fee', 'status_id'
    ];

    public function examinationpayment() {
        return $this->belongsTo('App\Examinationpayment');
    }

    public function application() {
        return $this->belongsTo('App\Application');
    }
}
