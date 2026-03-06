<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'state_name'
    ];

   	public function cities()
    {
        return $this->hasMany('App\City');
    }

    public function experts(){
        return $this->hasMany('App\Expert');
    }

    public function expertqualifications(){
        return $this->hasMany('App\Expertqualification');
    }

    public function expertrciqualifications(){
        return $this->hasMany('App\Expertrciqualification');
    }

    public function expertnonteachingexperiences(){
        return $this->hasMany('App\Expertnonteachingexperience');
    }

    public function expertteachingexperiences(){
        return $this->hasMany('App\Expertteachingexperience');
    }

    public function coursecoordinatorups()
    {
        return $this->hasMany('App\Coursecoordinatorupdate');
    }

    public function coursecoordinatoreducationalqualifications()
    {
        return $this->hasMany('App\Coursecoordinatoreducationalqualification');
    }

    public function coursecoordinatorpastteachingexperiences()
    {
        return $this->hasMany('App\Coursecoordinatorpastteachingexperience');
    }
}
