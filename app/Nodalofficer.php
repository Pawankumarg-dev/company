<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nodalofficer extends Model
{
    //
    protected $fillable = [
        'exam_id', 'code', 'password', 'name', 'designation', 'organization', 'email1', 'email2',
        'contactnumber1', 'contactnumber2', 'active_status'
    ];

    public function exam(){
        return $this->belongsTo('App\Exam');
    }
}
