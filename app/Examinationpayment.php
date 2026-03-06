<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examinationpayment extends Model
{
    //
    protected $fillable = [
        'examinationfee_id', 'candidate_id', 'latefee_remark', 'paymenttype_id', 'paymentbank_id', 'payment_date',
        'payment_number', 'status_id', 'user_id', 'reference_number', 'filename', 'payment_remark', 'amount_paid',
        'institute_id', 'verify_remarks', 'verified_on', 'name', 'designation', 'mobilenumber', 'email',
        'order_id', 'payment_mode'
    ];

    protected $dates = [
        'payment_date', 'verified_on'
    ];

    public function examinationfee() {
        return $this->belongsTo('App\Examinationfee');
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

    public function institute() {
        return $this->belongsTo('App\Institute');
    }

    public function candidateexaminationpayments() {
        return $this->hasMany('App\Candidateexaminationpayment');
    }

    public function calculatecount($expid) {
        return $this->candidateexaminationpayments()->where("examinationpayment_id", $expid)->count();
    }

    public function calculateexamfee($expid) {
        return $this->candidateexaminationpayments()->where("examinationpayment_id", $expid)->sum('fee');
    }

    public function pendingverficationcount($ayid, $id) {
        $enrolmentfee_ids = Enrolmentfee::where('academicyear_id', $ayid)->pluck('id')->toArray();
        return $this->whereIn('enrolmenfee_id', $enrolmentfee_ids)->where('institute_id', $id)->where('status_id', 6)->count();
    }

    public function order() {
        return $this->belongsTo('App\Order');
    }
}
