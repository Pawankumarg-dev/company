<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examinationfee extends Model
{
    //
    protected $fillable = [
        "exam_id", "programme_id", "academicyear_id", "exam_fee", "late_fee", "ontimepayment_startdate",
        "ontimepayment_enddate", "penaltypayment_startdate", "penaltypayment_enddate", "active_status"
    ];

    protected $dates = [
        'ontimepayment_startdate', 'ontimepayment_enddate', 'penaltypayment_startdate', 'penaltypayment_enddate',
    ];

    public function exam() {
        return $this->belongsTo('App\Exam');
    }

    public function programme() {
        return $this->belongsTo('App\Programme');
    }

    public function academicyear() {
        return $this->belongsTo('App\Academicyear');
    }
}
