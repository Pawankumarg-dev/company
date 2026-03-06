<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendingevaluation extends Model
{
    protected $fillable = [
        'exam_id','allapplication_id','evaluator_id','reason_id','resolved_at'
    ];
}
