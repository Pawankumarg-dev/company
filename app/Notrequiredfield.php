<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notrequiredfield extends Model
{
    protected $fillable = [
        'name','programmegroup_id' 
    ];
	
	 public function programmegroup()
    {
        return $this->belongsTo('App\Programmegroup');
    }
}
