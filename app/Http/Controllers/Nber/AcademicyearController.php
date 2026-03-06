<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Academicyear;
use App\Exam;
use App\Programme;
use App\Incidentalfee;
use App\Masterlist;
use Session;

class AcademicyearController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }
    public function changeayid($id){
        $academicyear= Academicyear::find($id);
        $academicyearname = $academicyear->year;
        Session::put('academicyear',$academicyearname);
        Session::put('academicyear_id',$id);
        return back();
    }
    public function changeeyid($id){
        $exam= Exam::find($id);
        $examname = $exam->name;
        Session::put('examname',$examname);
        Session::put('exam_id',$id);
        return back();
    }
}
