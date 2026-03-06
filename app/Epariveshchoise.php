<?php

namespace App;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Epariveshchoise extends Model
{
     protected $fillable = [];
     public function institute()
    {
        return $this->belongsTo('App\Institute');
    }
}
