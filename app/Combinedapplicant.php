<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Combinedapplicant extends Model
{
	protected $fillable = [
	    'candidate_id', 'exam_id','approvedprogramme_id','is_marksheet_downloaded','is_certificate_downloaded','term_one_generated_date', 'term_one_generated_by', 'term_two_generated_date', 'term_two_generated_by', 'certificate_generated_date', 'certificate_generated_by', 'term_one_tti_downloaded_by', 'term_two_tti_downloaded_by', 'certificate_tti_downloaded_by', 'term_one_student_downloaded_on', 'term_two_student_downloaded_on', 'certificate_student_downloaded_on', 'term_one_public_verified_last_on', 'term_two_public_verified_last_on', 'certificate_date', 'marksheetissuded_date', 'certificate_public_verified_last_on','incomplete', 'mark_changed', 'gracemark_processed','gracemark_marksheet_processing',
        'reevaluation_term_one_result_id',
        'reevaluation_term_two_result_id',
        'reevaluation_final_result',
        'reevaluation_result_percentage',
        'reevaluation_slno_certificate',
        'reevaluation_certificate_date',
        'reevaluation_sl_no_marksheet_term_one',
        'reevaluation_sl_no_marksheet_term_two',
        'reevaluation_first_year_total',
        'reevaluation_second_year_total',
        'reevaluation_marksheetissuded_date',
        'institute_id',
        'approvedprogramme_id',
        'programme_id','language_id','order_id','amount','additional_amount','payment_status','lookup','additional_payment_status'
    ];
    
    public function applications()
    {
    	return $this->hasMany('App\Newapplication');
    }


    public function order(){
        return $this->belongsTo('App\Order');
    }

    public function orders(){
        return $this->belongsToMany('App\Order');
    }

    public function approvedprogramme()
    {
        return $this->belongsTo('App\Approvedprogramme');
    }

    public function candidate()
    {
        return $this->belongsTo('App\Candidate');
    }

    public function institute()
    {
        return $this->belongsTo('App\Institute');
    }
  
    public function programme(){
        return $this->belongsTo('App\Programme');
    }

    public function language(){
        return $this->belongsTo('App\Language');
    }

}
