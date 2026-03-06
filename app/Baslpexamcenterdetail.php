<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baslpexamcenterdetail extends Model
{
    //
    protected $fillable = [
        "baslpexam_id", "baslpexamcenter_id", "baslpcandidate_id", "active_status"
    ];

    public function baslpexam() {
        return $this->belongsTo('App\Baslpexam');
    }

    public function baslpexamcenter() {
        return $this->belongsTo('App\Baslpexamcenter');
    }

    public function baslpcandidate() {
        return $this->belongsTo('App\Baslpcandidate');
    }
}
