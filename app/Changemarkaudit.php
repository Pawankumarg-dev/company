<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Changemarkaudit extends Model
{
    protected $fillable = [
        'exam_id', 'currentapplication_id', 'application_id', 'old_mark', 'new_mark', 'markorattendance', 'user_id', 'inex','editornew','candidate_id','subject_id','ip_address','status'
    ];
	
}

