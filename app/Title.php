<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    //
    protected $fillable = [
        'title'
    ];

    public function coursecoordinators(){
        return $this->hasMany('App\Coursecoordinator');
    }
}
