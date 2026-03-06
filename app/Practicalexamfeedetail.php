<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practicalexamfeedetail extends Model
{
    //
    protected $fillable = [
        "practicalexam_id", "approvedprogramme_id", "candidate_count", "paper_count", "payment_date",
        "transaction_number", "amount_paid", "payment_remarks", "active_status"
    ];

    public function exam() {
        return $this->belongsTo("App\Exam");
    }

    public function practicalexam() {
        return $this->belongsTo("App\practicalexam");
    }

    public function approvedprogramme() {
        return $this->belongsTo("App\Approvedprogramme");
    }
}
