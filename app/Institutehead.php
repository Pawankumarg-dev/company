<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institutehead extends Model
{
    //
    protected $fillable = [
        'institute_id', 'name', 'designation', 'qualification', 'rci_reg_no', 'email', 'contactnumber1',
        'contactnumber2', 'faxno'
    ];

    public function institute()
    {
        return $this->belongsTo('App\Institute');
    }
}
