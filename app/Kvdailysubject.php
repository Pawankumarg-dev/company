<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kvdailysubject extends Model
{
    public $timestamps = false;

    
    protected $fillable = [
        'evaluation_status'
    ];
   
    public function subject(){
        return $this->belongsTo('App\Subject');
    }
    public function externalexamcenter(){
        return $this->belongsTo('App\Externalexamcenter');
    }
}
