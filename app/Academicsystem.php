<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Academicsystem extends Model
{
    protected $fillable = [
        'name','months'
    ];
	public function programmegroups()
    {
        return $this->hasMany('App\Programmegroup');
    }
}
