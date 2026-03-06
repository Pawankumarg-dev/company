<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kvtti extends Model
{
    //

    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
     'externalexamcenter_id','institute_id',
    ];

    
}
