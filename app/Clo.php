<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clo extends Model
{
    //
    protected $fillable = [
        "exam_id", "nodalofficer_id", "externalexamcenter_id", "code", "password", "title_id", "name", "email1",
        "email2", "contactnumber1", "contactnumber2", "user_id", "active_status"
    ];

    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }

    public function nodalofficer()
    {
        return $this->belongsTo('App\Nodalofficer');
    }

    public function externalexamcenter()
    {
        return $this->belongsTo('App\Externalexamcenter');
    }
    public function institute()
    {
    	return $this->belongsTo('App\Institute');
    }

    public function Lgstate(){
        return $this->hasMany('App\Lgstate');
    }
    public function title()
    {
        return $this->belongsTo('App\Title');
    }

   



}
