<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplimentaryresult extends Model
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
    ];
}
