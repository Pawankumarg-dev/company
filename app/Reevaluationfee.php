<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reevaluationfee extends Model
{
    //
    protected $fillable = [
        'exam_id', 'reevaluation_fee', 'retotalling_fee', 'answerscriptcopy_fee', 'active_status'
    ];


}
