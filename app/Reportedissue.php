<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reportedissue extends Model
{
    
	protected $fillable = [
        'institute_id',
        'issuetype',
        'comment',
        'contactperson',
        'contactnumber',
        'prn',
        'is_student',
        'academicyear_id',
        'programme_id',
        'nber_id',
        'solutions',
        'solved',
        'tracking_id',
        'otherreason'
    ];

    public function institute() {
        return $this->belongsTo('App\Institute');
    }

    public function academicyear() {
        return $this->belongsTo('App\Academicyear');
    }

    public function programme() {
        return $this->belongsTo('App\Programme');
    }
}
