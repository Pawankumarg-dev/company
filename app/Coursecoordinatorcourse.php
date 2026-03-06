<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coursecoordinatorcourse extends Model
{
    //
    protected $fillable = [
        'coursecoordinatorcoursetype_id', 'course_mode', 'course_name', 'course_code'
    ];

    public function coursecoordinatorcoursetype(){
        return $this->belongsTo('App\Coursecoordinatorcoursetype');
    }


}
