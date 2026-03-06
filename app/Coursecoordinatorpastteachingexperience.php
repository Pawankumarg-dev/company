<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coursecoordinatorpastteachingexperience extends Model
{
    //
    protected $fillable = [
        'coursecoordinator_id', 'designation', 'institute_name', 'state_id', 'joining_date', 'relieving_date'
    ];

    protected $dates = [
        'joining_date', 'relieving_date'
    ];

    public function coursecoordinator(){
        return $this->belongsTo('App\Coursecoordinator');
    }

    public function state(){
        return $this->belongsTo('App\State');
    }
}
