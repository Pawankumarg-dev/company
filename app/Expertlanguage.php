<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expertlanguage extends Model
{
    //
    protected $fillable = [
        "expert_id", "language_id", "speak_status", "read_status", "write_status",
    ];

    public function expert() {
        return $this->belongsTo('App\Expert');
    }

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
