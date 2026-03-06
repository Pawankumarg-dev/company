<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answerbookletscan extends Model
{
	
	protected $fillable = [
        'allapplication_id','evaluationcenter_id','scanned','pages','verified','uploaded','evaluated'
    ];
	public function allapplication(){
        return $this->belongsTo('App\Allapplication');
    }
}

