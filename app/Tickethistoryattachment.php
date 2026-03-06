<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tickethistoryattachment extends Model
{
    public function tickethistory() {
        return $this->belongsTo('App\Tickethistory');
    }

    public function createdby() {
        return $this->belongsTo('App\User','user_id');
    }
}
