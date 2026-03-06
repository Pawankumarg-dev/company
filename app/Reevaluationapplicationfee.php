<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reevaluationapplicationfee extends Model
{
    //
    protected $fillable = [
        'exam_id', 'reevaluation_fee', 'retotalling_fee', 'photocopying_fee', 'active_status'
    ];

    public function exam() {
        return $this->belongsTo('App\Exam');
    }
}
