<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instituteinformationupdate extends Model
{
    //
    protected $fillable = [
        'institute_id', 'user_id', 'update_remarks', 'active_status', 'verified_on', 'verified_by'
    ];

    public function institute()
    {
        return $this->belongsTo('App\Institute');
    }

    public function instituteCount($id) {
        return self::where('institute_id', $id)->get()->count();
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
