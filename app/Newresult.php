<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newresult extends Model
{
    protected $fillable = [
        'candidate_id',
        'status_id',
        'first_year_result',
        'second_year_result',
        'marksheet_sl_no_first_year',
        'marksheet_sl_no_second_year',
        'course_complete_status',
        'final_percentage',
        'tmp_status_id',
        'check_first_year_marksheet_pdf',
        'check_second_year_marksheet_pdf',
        'check_certificate_pdf'
    ];

    public function candidate(){
        return $this->belongsTo('App\Candidate');
    }
}