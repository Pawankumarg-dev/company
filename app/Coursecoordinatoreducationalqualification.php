<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coursecoordinatoreducationalqualification extends Model
{
    //
    protected $fillable = [
        'coursecoordinator_id', 'coursecoordinatorcourse_id', 'institute_name', 'state_id', 'completion_year'
    ];

    public function coursecoordinator(){
        return $this->belongsTo('App\Coursecoordinator');
    }

    public function coursecoordinatorcourse(){
        return $this->belongsTo('App\Coursecoordinatorcourse');
    }

    public function state(){
        return $this->belongsTo('App\State');
    }
}
