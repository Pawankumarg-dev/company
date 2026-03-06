<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practicalhallticket extends Model
{
	protected $fillable = [
        'downloaded'
    ];
	
    public function allapplicant() {
        return $this->belongsTo('App\Allapplicant');
    }

}
