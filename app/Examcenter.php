<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examcenter extends Model
{
    protected $fillable = [
        'exam_id', 'externalexamcenter_id', 'institute_id'
    ];


	public function institute()
    {
        return $this->belongsTo('App\Institute');
    }

	public function institutes()
    {
        return $this->hasMany('App\Institute');
    }

	public function externalexamcenter()
    {
        return $this->belongsTo('App\Externalexamcenter');
    }

	public function exam()
    {
        return $this->belongsTo('App\Exam');
    }
    
    public function scopeOnlyExam($query,$id)
    {
        return $query->where('exam_id', $id);
    }

    public function states(){
        return $this->belongsToMany('App\Lgstate')->withPivot('statezone_id');
    }
    
}
