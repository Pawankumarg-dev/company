<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Malpracticefile extends Model
{
    protected $fillable = [
        'description','file','malpractice_id'
    ];

     public function malpractice(){
        return $this->belongsTo('App\Malpractice');
    }
}
