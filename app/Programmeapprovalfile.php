<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programmeapprovalfile extends Model
{
    protected $fillable = [
        'approvedprogramme_id', 'filename',
    ];
	
    public function approvedprogramme()
    {
        return $this->belongsTo('App\Approveprogramme');
    }
}
