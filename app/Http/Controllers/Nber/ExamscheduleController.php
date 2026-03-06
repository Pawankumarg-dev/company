<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Examschedule;
use App\Exam;

use App\Http\Requests\Examschdule\StoreExamscheduleRequest;

use Session;

class ExamscheduleController extends Controller
{
    private $exam_id;
    private $exam;

    public function __construct()
    {
       $this->middleware(['role:nber']);
        $this->exam_id = Session::get('exam_id');
        $this->exam = Exam::find($this->exam_id);
    }

    public function index(){
        $schedules = Examschedule::where('exam_id',$this->exam_id)->get();
        return view('nber.exam.schedule.index',compact('schedules','exam'));
    }

    public function create(){
        return view('nber.exam.schedule.create',compact('exam'));
    }

    public function store(StoreExamscheduleRequest $r){
        Examschedule::create($r->all());
        return redirect('nber/exam/schedules');
    }

}
