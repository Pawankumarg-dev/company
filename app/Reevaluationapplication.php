<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
class Reevaluationapplication extends Model
{
    //
    protected $fillable = [
        'application_number', 'reevaluation_id', 'exam_id', 'institute_id', 'approvedprogramme_id', 'candidate_id',
        'contactnumber', 'email', 'status_id', 'status_remarks', 'active_status','order_id','orderstatus_id','amount','nber_id', 
        'term_one_result_id', 'term_two_result_id', 'final_result', 'result_percentage', 'slno_certificate', 'certificate_date', 'sl_no_marksheet_term_one', 'sl_no_marksheet_term_two', 'marksheetissuded_date', 'first_year_total','second_year_total'
    ];
    public function order(){
        return $this->belongsTo('App\Order');
    }
    
    public function orders(){
        return $this->belongsToMany('App\Order');
    }



    public function reevaluation() {
        return $this->belongsTo('App\Reevaluation');
    }

    public function refund() {
        return $this->hasOne('App\Refund');
    }

    public function exam() {
        return $this->belongsTo('App\Exam');
    }

    public function institute() {
        return $this->belongsTo('App\Institute');
    }

    public function approvedprogramme() {
        return $this->belongsTo('App\Approvedprogramme');
    }

    public function candidate() {
        return $this->belongsTo('App\Candidate');
    }

    public function status() {
        return $this->belongsTo('App\Status');
    }

    public function reevaluationapplicationsubjects() {
        return $this->hasMany('App\Reevaluationapplicationsubject');
    }

    public function reevaluationapplicationpayments() {
        return $this->hasMany('App\Reevaluationapplicationpayment');
    }
public function applicant()
{
    return $this->hasOne(\App\Allapplicant::class, 'candidate_id', 'candidate_id')
                ->where('exam_id', Session::get('exam_id'));
}

}
