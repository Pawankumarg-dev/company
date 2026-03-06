<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expertteachingexperience extends Model
{
    //
    protected $fillable = [
        "expert_id", "organization_name", "organization_address", "state_id", "organization_category", "organization_type",
        "is_presently_working", "designation", "department", "from_date", "to_date", "experience", "file_experience"
    ];

    protected $dates = [
        "from_date", "to_date"
    ];

    public function expert() {
        return $this->belongsTo('App\Expert');
    }

    public function state() {
        return $this->belongsTo('App\State');
    }
}
