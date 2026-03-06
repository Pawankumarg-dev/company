<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institutecode extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'institute_id','nber_id','code'
    ];
    
}
