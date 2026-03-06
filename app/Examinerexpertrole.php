<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examinerexpertrole extends Model
{
    //
    protected $fillable = [
        "examinerexpert_id", "examinerexperttype_id", "status_id", "user_id"
    ];

    public function examinerexpert() {
        return $this->belongsTo('App\Examinerexpert');
    }

    public function examinerexperttype() {
        return $this->belongsTo('App\Examinerexperttype');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
 }
