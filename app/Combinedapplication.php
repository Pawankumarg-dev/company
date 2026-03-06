<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Combinedapplication extends Model
{
	protected $fillable = [];
        public $timestamps = false;

public function subject()
{
    return $this->belongsTo(Subject::class); // or hasOne / hasMany depending on your schema
}

}
