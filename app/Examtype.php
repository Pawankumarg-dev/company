<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examtype extends Model
{
    protected $fillable = [
        'name', 
    ];

    public function exams(){
        return $this->hasMany('App\Exam');
    }

    public function applications() {
        return $this->hasMany('App\Application');
    }

    public function exammarksheetdetails() {
        return $this->hasMany('App\exammarksheetdetails');
    }
}
