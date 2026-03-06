<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cloreportfile extends Model
{
    protected $fillable = [
        'description','exam_id'
    ];

     public function exam(){
        return $this->belongsTo('App\Exam');
    }
}
