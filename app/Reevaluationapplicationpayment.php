<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reevaluationapplicationpayment extends Model
{
    //
    protected $fillable = [
        'reevaluationapplication_id', 'reevaluationapplicationfee_id', 'exam_id', 'institute_id', 'approvedprogramme_id',
        'candidate_id', 'paymenttype_id', 'paymentbank_id', 'payment_date', 'amount_paid', 'payment_number', 'reference_number',
        'payment_remark', 'filename', 'name', 'designation', 'mobilenumber', 'email', 'user_id', 'status_id', 'verify_remarks',
        'verified_on', 'active_status'
    ];

    protected $dates = [
        'payment_date', 'verified_on'
    ];

    public function reevaluationapplication() {
        return $this->belongsTo('App\Reevaluationapplication');
    }

    public function reevaluationapplicationfee() {
        return $this->belongsTo('App\Reevaluationapplicationfee');
    }

    public function exam() {
        return $this->belongsTo('App\Exam');
    }

    public function approvedprogramme() {
        return $this->belongsTo('App\Approvedprogramme');
    }

    public function institute() {
        return $this->belongsTo('App\Institute');
    }

    public function candidate() {
        return $this->belongsTo('App\Candidate');
    }

    public function paymenttype() {
        return $this->belongsTo('App\Paymenttype');
    }

    public function paymentbank() {
        return $this->belongsTo('App\Paymentbank');
    }

    public function status() {
        return $this->belongsTo('App\Status');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }


}
