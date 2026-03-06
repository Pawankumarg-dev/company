<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluationcenterincharge extends Model
{
    //
    protected $fillable = [
        "exam_id", "evaluationcenter_id", "code", "name", "designation", "contactnumber", "email", "active_status"
    ];

    public function exam() {
        return $this->belongsTo("App\Exam");
    }

    public function evaluationcenter() {
        return $this->belongsTo("App\Evaluationcenter");
    }
}
