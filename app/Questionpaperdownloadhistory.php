<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionpaperdownloadhistory extends Model
{
    protected $fillable = [
        'examtimetable_id','language_id','user_id','externalexamcenter_id','ip_address','agent','session_id','usertype_id'
    ];
}
