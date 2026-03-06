<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Examattendancefile;

use App\Exam;


class ExamattendancefileController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }
    public function index(){
    	$collections = Examattendancefile::paginate(10);
    	$link = 'examattendancefiles';
    	$text = 'Exam Attendace Files';
    	$exams = Exam::all();
    	return view('nber.exams.attendancefiles',compact('collections','link','text','exams'));
    }
    public function create(Request $request){
    	Examattendancefile::create($request->all());
    	return back();//redirect('/examattendancefiles');
    }
    public function update(Request $request){
    	$examattendancefile = Examattendancefile::find($request->id);
    	$examattendancefile->update($request->except('id'));
    	return  back();// redirect('/examattendancefiles');
    }
}
