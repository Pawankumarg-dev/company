<?php

namespace App\Http\Controllers\Nber;

use App\Application;
use App\Approvedprogramme;
use App\Exam;
use App\Examanswersheet;
use App\Examtimetable;
use App\Externalexamcenter;
use App\Language;
use App\Candidate;
use App\Markexamattendance;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClassroomattendanceController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index($id,$exam_id){
        $ap = Approvedprogramme::with('candidates')->find($id);
        if($ap){
            return view('nber.attendance.classroom_attendance',compact('ap','exam_id','id'));
        }
        else{
            return redirect('/');
        }
    } 


 
}
