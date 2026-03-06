<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coursecoordinatorknownlanguage extends Model
{
    //
    protected $fillable = [
        'coursecoordinator_id', 'language_id', 'read_status', 'write_status', 'speak_status', 'active_status'
    ];

    public function coursecoordinator(){
        return $this->belongsTo('App\Coursecoordinator');
    }

    public function language(){
        return $this->belongsTo('App\Language');
    }
}
