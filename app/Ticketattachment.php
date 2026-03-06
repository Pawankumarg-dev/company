<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticketattachment extends Model
{
    public function ticket() {
        return $this->belongsTo('App\Ticket');
    }

    public function createdby() {
        return $this->belongsTo('App\User','user_id');
    }

}
