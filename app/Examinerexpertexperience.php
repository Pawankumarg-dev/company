<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examinerexpertexperience extends Model
{
    //
    protected $fillable = [
        "examinerexpert_id", "employer", "designation", "is_present", "from_date", "to_date"
    ];

    public function examinerexpert() {
        return $this->belongsTo("App\Examinerexpert");
    }
}
