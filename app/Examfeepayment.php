<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examfeepayment extends Model
{
    protected $fillable = [
        "exam_id", "nber_id", "amount", "institute_id", "payment_method","details","nber_doc"
    ];
}
