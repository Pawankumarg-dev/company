<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examinerexpertqualification extends Model
{
    //
    protected $fillable = [
        "examinerexpert_id", "qualification", "from_date", "to_date"
    ];

    public function examinerexpert() {
        return $this->belongsTo("App\Examinerexpert");
    }
}
