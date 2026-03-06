<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
     protected $fillable = [
        'title',
        'publish_date',
        'status',
        'file_name'
    ];
}
