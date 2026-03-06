<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
	
	protected $fillable = [
        'language','code'
    ];
	
    public function applications()
    {
        return $this->hasMany('App\Application');
    }

    public function examinerexpertknownlanguages() {
        return $this->hasMany('App\Examinerexpertknownlanguage');
    }

    public function expertlanguages(){
        return $this->hasMany('App\Expertlanguage');
    }

    public function coursecoordinatorknownlanguages(){
        return $this->hasMany('App\Coursecoordinatorknownlanguage');
    }

    public function markexamattendances() {
        return $this->hasMany('App\Examattendance');
    }
    public function examtimetables(){
        return $this->belongsToMany('App\Examtimetable')->withPivot('question_paper');
    }
}
