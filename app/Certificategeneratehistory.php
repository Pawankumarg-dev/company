<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificategeneratehistory extends Model
{
    protected $fillable = [
        'user_id','exam_id','candidate_id'

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
