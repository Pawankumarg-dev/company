<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itsmincident extends Model
{
    
    protected $fillable = [
        'issue',
        'description',
        'solution',
        'reported_on',
        'resolved_on',
        'user_id',
        'itsmincidentstatus_id'
    ];
   
    public function itsmincidentstatus(){
        return $this->belongsTo('\App\Itsmincidentstatus');
    }
}
