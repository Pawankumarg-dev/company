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

class AttendanceController extends Controller
{
    private $examService;
    private $helperService;
    private $exam_id;

    public function __construct(ExamService $exam,HelperService $helper)
    {
        $this->middleware(['role:examcenter']);
        $this->examService = $exam;
        $this->helperService = $helper;
        $this->exam_id = 25;

    }
    public function index(Request $r){
        $externalexamcenter = $this->helperService->getExternalexamcenter();
        $exam_id = $this->exam_id;
        $schedule_id = $r->examschedule_id;
        $schedule = \App\Examschedule::find($schedule_id);
       //$approvedprogrammes = $this->examService->getApprovedProgrammes($exam_id,$externalexamcenter->id,$schedule_id);
        $approvedprogrammes  = \App\Exampaper::where('externalexamcenter_id',$externalexamcenter->id)->where('examschedule_id',$schedule_id)->get();
        //$approvedprogrammes = \App\Approvedprogramme::whereIn('id',$approvedprogramme_ids)
        
        return view('examcenter.attendance.index',compact(
            'approvedprogrammes',
            'schedule',
            'exam_id'
        ));
    }

    public function show($id,Request $r){

        $exam_id = $this->exam_id;
        $applications =   $this->examService->getApplicantions($id,$r->subject_id);
        $approvedprogramme = \App\Approvedprogramme::find($id);
        $schedule_id = $r->examschedule_id;
        $schedule = \App\Examschedule::find($schedule_id);
        $subject = \App\Subject::find($r->subject_id);
        return view('examcenter.attendance.mark',compact(
            'applications',
            'schedule',
            'exam_id',
            'approvedprogramme',
            'subject'
        ));
    }

    public function store(Request $r){

        $applications =   $this->examService->getApplicantions($r->approvedprogramme_id,$r->subject_id);
        $message = '';
        $examcenter_id = $this->helperService->getExternalexamcenterID();
        $count = 0;
        $pcount = 0;
        $acount = 0;
        foreach($applications as $application){
            $attendance = 'attendence_'.$application->id;
            $ansbookletfield = 'ansbookno_'.$application->id;
            $application->externalattendance_id = $r->$attendance;
            if($r->$attendance < 1){
                $message = 'Kindly Mark Attendance for all the Students';
            }
            if($r->$ansbookletfield =='' && $r->$attendance ==1){
                $message = 'Kindly fill the Answerbooklet Number for all the Students';
            }else{
                $application->answerbooklet_no = $r->$ansbookletfield; 
            }
            $pcount += $r->$attendance == 1 ? 1:0;
            $acount += $r->$attendance == 2 ? 1:0; 
            $application->externalexamcenter_id = $examcenter_id;
            $count++;
            $application->save();
        }   
        if($message==''){
            Session::flash('messages','Updated');
            $exampaper = \App\Exampaper::where('approvedprogramme_id',$r->approvedprogramme_id)->where('subject_id',$r->subject_id)->first();
            $exampaper->attendance = $count;
            $exampaper->present = $pcount;
            $exampaper->absent = $acount;
            $exampaper->save();
        }else{
            Session::flash('error',$message);
        }
        return redirect('/examcenter/attendance?examschedule_id='.$r->examschedule_id);
    }
}