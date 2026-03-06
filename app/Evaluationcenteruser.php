<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Evaluationcenteruser extends Authenticatable
{
    //
    protected $fillable = [
        'code', 'email', 'password', 'active_status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'evaluationcenteruser';
}
