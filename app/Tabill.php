<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabill extends Model
{

    protected $fillable = [
        'user_id',
        'amount',
        'bank_name',
        'account_holder_name',
        'account_number',
        'branch',
        'ifsc_code',
        'ta_form',
        'payment_status',
        'exam_id',
        'clo_report',
        'reason',
        'nber_id',
        'payment_for',
        'transaction_details'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }
    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }
    public function faculty()
    {
        return $this->belongsTo('App\Faculty');
    }
}
