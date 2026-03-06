<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Externalexamcenterdetail extends Model
{
    //
    protected $fillable = [
        "exam_id", "institute_id", "externalexamcenter_id", "expert_id", "active_status"
    ];

    public function exam() {
        return $this->belongsTo('App\Exam');
    }

    public function institute() {
        return $this->belongsTo('App\Institute');
    }

    public function externalexamcenter() {
        return $this->belongsTo('App\Externalexamcenter');
    }
}
