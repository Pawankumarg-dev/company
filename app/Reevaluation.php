<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reevaluation extends Model
{
    //
    protected $fillable = [
        'exam_id', 'application_count', 'lastdate', 'resultdate', 'publish_status'
    ];

    protected $dates = [
        'lastdate', 'resultdate'
    ];

    public function exam(){
        return $this->belongsTo('App\Exam');
    }

    public function reevaluationresults() {
        return $this->hasMany('App\Reevaluationresult');
    }
}
