<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Downloadquestionpaperupdate extends Model
{
    //
    protected $fillable = [
        "externalexamcenter_id", "examtimetable_id"
    ];
}
