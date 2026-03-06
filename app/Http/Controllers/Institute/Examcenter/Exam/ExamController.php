<?php

namespace App\Http\Controllers\Examcenter\Exam;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Hash;

use App\Services\Exam\ExamService;
use App\Services\Common\HelperService;

use PDF;

class ExamController extends Controller
{
    private $examService;
    private $helperService;

    public function __construct(ExamService $exam,HelperService $helper)
    {
        $this->middleware(['role:examcenter']);
        $this->examService = $exam;
        $this->helperService = $helper;

    }
    public function index(){
        $externalexamcenter_id = $this->helperService->getExternalexamcenterID();
        $externalexamcenter = $this->helperService->getExternalexamcenter();
        
        $exam_id = 25;
       // $schedules = $this->examService->getSchedules($exam_id,$externalexamcenter_id);

        $schedule_ids = \App\Exampaper::where('externalexamcenter_id',$externalexamcenter_id)->pluck('examschedule_id')->toArray();
        $schedules = \App\Examschedule::whereIn('id',$schedule_ids)->get();

        $count = [];
        foreach($schedules as $s){
            //$s['count'] = $this->examService->getStudentCount($exam_id,$externalexamcenter_id,$s->id);
            $s['count'] = \App\Exampaper::where('examschedule_id',$s->id)->where('externalexamcenter_id',$externalexamcenter_id)->sum('theory');
        }
        return view('examcenter.schedule',compact(
            'schedules',
            'externalexamcenter'
        ));
    }

    public function show($id,Request $r){
        $examcenter = $this->helperService->getExternalexamcenter();
        $applications = $this->examService->getStudentList(25,$examcenter->id,$id);
        $schedule = \App\Examschedule::find($id);
        set_time_limit(300);
        $format = 'html';
        if($r->has('format') && !($r->format=='html')){
            $format = 'pdf';
            view()->share('applications',$applications);
            view()->share('schedule',$schedule);
            view()->share('examcenter',$examcenter);
            view()->share('format',$format);
        }
        $headers = array(
            'Content-Type: application/pdf',
        );
        if($r->has('roomallocation')){
            if($format=='html'){
                return view('examcenter.roomallocation',compact(
                    'applications','schedule','examcenter','format'
                ));
            }
            $pdf = PDF::loadView('examcenter.roomallocation')->setPaper('a4', 'portrait');   
            return $pdf->download('room_allocation_'.$schedule->examdate.'.pdf'); 
        }
        if($format=='html'){
            return view('examcenter.attendancesheet',compact(
                'applications','schedule','examcenter','format'
            ));
        }
        $pdf = PDF::loadView('examcenter.attendancesheet')->setPaper('a4', 'portrait');
        return $pdf->download('attendance_sheet_'.$schedule->examdate.'.pdf');
    }
}