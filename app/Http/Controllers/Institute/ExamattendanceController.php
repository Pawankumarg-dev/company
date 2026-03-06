<?php

namespace App\Http\Controllers\Institute;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Approvedprogramme;
use Illuminate\Support\Facades\App;
use Validator;
use App\Http\Controllers\Controller;
use Auth;
use App\Candidate;
use App\City;
use App\Community;
use App\Disability;
use App\Gender;
use App\Salutation;
use App\Subject;
use App\Application;
use App\Language;
use App\Programme;
use App\Institute;
use App\Exam;
use App\Examtimetable;
use App\Examcenter;
use App\Examattendancefile;
use App\Examattendance;

use Session;
use File;
use Input;
use Response;
use PDF;

class ExamattendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }
    public function uploadattendance($examtimetable_id,Request $request){
    	
   /* 	$rules = [
            'file' => 'required',
        ];
        $this->validate($request, $rules); */
        $count = 0 ;
        $examattendancefiles = Examattendancefile::all();
   
        $file = $request->file;
        foreach($examattendancefiles as $i){
    	   //return $file->examattendancefile_id;
            if($file[$i->id]){
            	if(!($file[$i->id]->isValid())){
                    Session::put('error','Failed to Upload');
                    return back();
                }else{
                    $ex = explode('.', $path = $file[$i->id]->getClientOriginalName());
                    $extn = end($ex);
                    $filename = $examtimetable_id.'_' .$i->id. '_'. rand(100,10000) . '.' . $extn ;
                    move_uploaded_file($file[$i->id],'files/examattendance/'.$filename);
                    $examattendance = Examattendance::create(['examattendancefile_id'=>$i->id,'file'=>$filename, 'examtimetable_id' => $examtimetable_id]);
                }
            }
        }

    	Session::put('messages','Uploaded');
    	return back();
    }
}