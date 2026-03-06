<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technicalissue extends Model
{
    
	protected $fillable = [
        'institute_id',
        'programme_id',
        'approvedprogramme_id',
        'issue',
        'description',
        'reported_by',
        'user_id',
        'nber_id',
        'solution',
        'solved',
        'created_at',
        'updated_at',
        'solved_at'
    ];

    public function institute() {
        return $this->belongsTo('App\Institute');
    }

    public function approvedprogrammes() {
        return $this->belongsTo('App\Approvedprogramme');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
    public function nber() {
        return $this->belongsTo('App\Nber');
    }
}
