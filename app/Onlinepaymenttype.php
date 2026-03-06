<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Onlinepaymenttype extends Model
{
    //
    protected $fillable = [
        'type', 'tag', 'billing_notes', 'tablename', 'blade_file'
    ];
}
