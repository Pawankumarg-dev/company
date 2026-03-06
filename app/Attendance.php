<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
	  
class Attendance extends Model
{
	protected $fillable = [
        'exam_id', 'candidate_id','attendance_t','attendance_p','exemption','document_t','document_p','document_exemption','term'
    ];
	
            
    public function candidate()
	{
		return $this->belongsTo('App\Candidate');
	}
	public function status(){
		return $this->belongsTo('App\Status','exemption');
	}
	public function exam()
{
    return $this->belongsTo('App\Exam');
}
}
