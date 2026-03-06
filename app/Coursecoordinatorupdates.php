<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coursecoordinatorupdates extends Model
{
    //
    protected $fillable = [
        'institute_id', 'coursecoordinator_id', 'update_remarks',
    ];

    public function institute(){
        return $this->belongsTo('App\Institute');
    }
    public function coursecoordinator(){
        return $this->belongsTo('App\Coursecoordinator');
    }
}
