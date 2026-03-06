<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'exam_id','subject_id','examtimetable_id','evaluator_id','allapplication_id','candidate_id','subjetofevaluator_id','question_no','mark','qppattern_id'
    ];
}
