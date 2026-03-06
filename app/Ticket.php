<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function institute() {
        return $this->belongsTo('App\Institute');
    }

    public function programme() {
        return $this->belongsTo('App\Programme');
    }

    public function approvedprogramme() {
        return $this->belongsTo('App\Approvedprogramme');
    }

    public function createdby() {
        return $this->belongsTo('App\User','created_by');
    }

    public function closedby() {
        return $this->belongsTo('App\User','closed_by');
    }
    public function nber() {
        return $this->belongsTo('App\Nber');
    }
    public function category() {
        return $this->belongsTo('App\Tickettype','tickettype_id');
    }
    public function issuetype() {
        return $this->belongsTo('App\Issuetype');
    }

    public function academicyear() {
        return $this->belongsTo('App\Academicyear');
    }

    public function owner(){
        return $this->belongsTo('App\Ticketholder','ticketholder_id');
    }

    public function status(){
        return $this->belongsTo('App\Ticketstatus','ticketstatus_id');
    }
    

}
