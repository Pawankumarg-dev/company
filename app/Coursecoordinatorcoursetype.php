<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coursecoordinatorcoursetype extends Model
{
    //
    protected $fillable = [
        'council_name', 'council_code', 'certificate_name', 'certificate_code'
    ];

    public function coursecoordinatorcourses() {
        return $this->hasMany('App\Coursecoordinatorcourse');
    }

    public function coursecoordinators() {
        return $this->hasMany('App\Courseordinators');
    }
}
