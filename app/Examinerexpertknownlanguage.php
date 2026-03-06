<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examinerexpertknownlanguage extends Model
{
    //
    protected $fillable = [
        "examinerexpert_id", "language_id", "speak_status", "read_status", "write_status"
    ];

    public function examinerexpert() {
        return $this->belongsTo('App\Examinerexpert');
    }

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
