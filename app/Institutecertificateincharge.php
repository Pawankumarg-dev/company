<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institutecertificateincharge extends Model
{
    //
    protected $fillable = [
        'institute_id', 'name', 'designation', 'contactnumber1', 'contactnumber2', 'email'
    ];

    public function institute()
    {
        return $this->belongsTo('App\Institute');
    }
}
