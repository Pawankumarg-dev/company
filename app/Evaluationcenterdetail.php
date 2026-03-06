<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluationcenterdetail extends Model
{
    //
    protected $fillable = [
        "exam_id", "evaluationcenter_id", "externalexamcenter_id", "remarks", "active_status"
    ];

    public function exam() {
        return $this->belongsTo('App\Exam');
    }

    public function evaluationcenter() {
        return $this->belongsTo('App\Evaluationcenter');
    }

    public function externalexamcenter() {
        return $this->belongsTo('App\Externalexamcenter');
    }
}
