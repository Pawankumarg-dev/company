<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nber extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'code', 'name','address'
    ];

    public function programmes() {
        return $this->hasMany('App\Programme');
    }

}
