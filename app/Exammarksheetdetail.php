<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exammarksheetdetail extends Model
{
    //
    protected $fillable = [
        'exam_id',
        'programme_id',
        'academicyear_id',
        'term',
        'examtype_id',
        'result_date',
        'publish_status',
    ];

    protected $dates = [
        'result_date',
    ];

    public function exam() {
        return $this->belongsTo('App\Exam');
    }

    public function programme() {
        return $this->belongsTo('App\Programme');
    }

    public function academicyear() {
        return $this->belongsTo('App\Academicyear');
    }

    public function examtype() {
        return $this->belongsTo('App\Examtype');
    }

    public function applications() {
        return $this->hasMany('App\Application');
    }
}
