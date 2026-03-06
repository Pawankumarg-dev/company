<?php

namespace App\Http\Controllers\Nber\Exam;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Examschedule; 
use App\Exam;

use App\Http\Requests\Exam\StoreScheduleRequest;

use App\Services\Exam\ScheduleService;

use Auth;

use Session;

class ScheduleController extends Controller
{
    private $exam_id;
    private $exam;
    private $scheduleService; 

    public function __construct(ScheduleService $schedule)
    {
       $this->middleware(['role:nber']);
        $this->exam_id = Session::get('exam_id');
        $this->exam = Exam::find($this->exam_id);
        $this->scheduleService = $schedule;
    }

    public function index(){
        $schedules = $this->scheduleService->getSchedule($this->exam_id);
        $exam = $this->exam;
        return view('nber.exam.schedule.index',compact('schedules','exam'));
    }

    public function create(){
        $exam = $this->exam;
        return view('nber.exam.schedule.create',compact('exam'));
    }

    public function store(StoreScheduleRequest $r){
        //return "";
        Examschedule::create($r->all());
        return redirect('nber/exam/schedules');
    }

    public function update($id,Request $r){
        //return "";
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        $schedule = \App\Examschedule::find($id);
        
        $schedule->nbers()->detach($nber_id);
        $schedule->nbers()->attach([$nber_id=>['password'=>$r->password]]);
        $timetables = \App\Examtimetable::where('examschedule_id',$id)->whereHas('subject',function ($q) use($nber_id){
            $q->whereHas('programme', function ($r) use($nber_id){
                $r->where('nber_id',$nber_id);
            });
        })->get();
        foreach($timetables as $tt){
            $tt->password = $r->password;
            $tt->save();
        }
        Session::flash('messages','Password Saved');
        return back();
    }


    public function show($id,Request $r){
        $exam = $this->exam;
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        $schedule = Examschedule::find($id);
        $show = 'courses';
        if($r->has('get') && $r->get == 'allEmailIDs'){
            $show = 'emails';
            $min = 1;
            $max = 5000;
            if($r->has('min')){
                $min=$r->min;
            }
            if($r->has('max')){
                $max=$r->max;
            }
            $sid = 0;
            if($r->has('sid')){
                $sid= $r->sid;
            }
            $emails = $this->scheduleService->getEmailIDs(25,$schedule,$min,$max,$sid);
            return view('nber.exam.schedule.show',compact('schedule','exam','nber_id','emails','min','show'));
        }
        return view('nber.exam.schedule.show',compact('schedule','exam','nber_id','show'));

        
    }
}
