<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EpariveshStudent extends Model
{
     protected $fillable = [];

      public function epariveshacadmic()
    {
        return $this->hasMany(Epariveshacadmic::class, 'eparivesh_student_id');
    }

    public function epariveshchoise()
    {
        return $this->hasMany(Epariveshchoise::class, 'eparivesh_student_id');
    }
    public function gender()
    {
        return $this->belongsTo('App\Gender');
    }
// public function epariveshacadmic()
// {
//     return $this->belongsTo(Epariveshacadmic::class); // or hasOne / hasMany depending on your schema
// }

// public function epariveshchoise()
// {
//     return $this->belongsTo(Epariveshchoise::class); // or hasOne / hasMany depending on your schema
// }
    
}
