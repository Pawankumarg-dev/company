<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Markentry extends Model
{
    protected $fillable = [
        'exam_id', 'approvedprogramme_id','internal_theory','internal_practical','external_practical'
    ];
}
