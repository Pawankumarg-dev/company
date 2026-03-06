<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paymentstatus extends Model
{
    //
    protected $fillable = [
        'class', 'status'
    ];

    public function statushtml(){
        return  "<span class='label label-".$this->class."'>".$this->status."</span>";
    }

    public function candidates()
    {
        return $this->hasMany('App\Candidate');
    }
}
