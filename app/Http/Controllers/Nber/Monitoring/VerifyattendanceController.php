<?php

namespace App\Http\Controllers\Nber\Monitoring;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Services\Exam\ExamService;
use App\Services\Common\HelperService;
use \Session;
use Auth;
class VerifyattendanceController extends Controller
{
    private $examService;
    private $helperService;
    private $exam_id;

    public function __construct(ExamService $exam,HelperService $helper)
    {
        $this->middleware(['role:nber']);
        $this->examService = $exam;
        $this->helperService = $helper;
        $this->exam_id = Session::get('exam_id');

    }
    public function show($id,Request $r){
        $exam_id = $this->exam_id;
        $approvedprogramme = \App\Approvedprogramme::find($id);
        $subject = \App\Subject::find($r->subject_id);

        $applications =   $this->examService->getApplicantions($id,$r->subject_id,null,null,$this->exam_id,0);

            $applications =  \App\Allexamstudent::where('exam_id',$exam_id)->whereHas('candidate',function($q) use($id){
            $q->where('approvedprogramme_id',$id);
            })->where('subject_id',$subject->id)->get();


            // $applications =  \App\Allexamstudent::where('exam_id',$exam_id)->whereHas('candidate',function($q) use($id){
            // $q->where('approvedprogramme_id',$id);
            // })->where('alternativesubject_id',$subject->alternativesubject_id)->where('subject_id',$subject->id)->get();



        // if($r->approvedprogramme_id == 8837 ){
        //     $ec_id = \App\Allexampaper::where('approvedprogramme_id',$id)->first()->externalexamcenter_id;
        //     $district_id = \App\Externalexamcenter::find($ec_id)->district;
        //     $applications =   $this->examService->getApplicantions($r->approvedprogramme_id,$r->subject_id,null,null,27,$district_id);
        // }
        $schedule_id = $r->examschedule_id;
        $schedule = \App\Examschedule::find($schedule_id);
        $nber = $this->helperService->getNberID();
        $exampaper = \App\Allexampaper::where('subject_id',$r->subject_id)->where('approvedprogramme_id',$id)->where('exam_id',$this->exam_id)->first();

        return view('nber.monitoring.attendance.verify',compact(
            'applications',
            'schedule',
            'exam_id',
            'approvedprogramme',
            'subject',
            'nber',
            'exampaper'
        ));
    }

    public function update($id,Request $r){
        $exampaper = \App\Allexampaper::find($id);
        $exampaper->attn_verification = $r->attn_verification;
        if($r->attn_verification == 2){
            $exampaper->attn_rej_reason = $r->attn_rej_reason;
        }
        $exampaper->save();
        Session::put('messages','Updated');
        return back();
    }

    public function update_attendance(Request $r){


    $applications =  \App\Allexamstudent::where('approvedprogramme_id',$r->approvedprogramme_id)
    ->where('exam_id',$this->exam_id)
    ->where('subject_id','=',$r->subject_id)
    ->get();




        $message = '';
        $examcenter_id = $this->helperService->getExternalexamcenterID();
        $count = 0;
        $pcount = 0;
        $acount = 0;
        foreach($applications as $application){
            $attendance = 'attendence_'.$application->id;
            $ansbookletfield = 'ansbookno_'.$application->id;
            $application->attendance = $r->$attendance;
            if($r->$attendance < 1){
                $message = 'Kindly Mark Attendance for all the Students';
            }
            if($r->$ansbookletfield =='' && $r->$attendance ==1){
                $message = 'Kindly fill the Answerbooklet Number for all the Students';
            }else{
                $application->answerbooklet_no = $r->$ansbookletfield; 
            }
            $application->save();
        } 

        if($message==''){
            Session::flash('messages','Updated');
            $exampaper = \App\Allexampaper::where('approvedprogramme_id',$r->approvedprogramme_id)->where('subject_id',$r->subject_id)->where('exam_id',$this->exam_id)->first();
            $exampaper->attendance = $count;
            $exampaper->present = $pcount;
            $exampaper->absent = $acount;
            $exampaper->reason = $r->reason;

            $exampaper->updated_by = Auth::user()->id;
            $exampaper->save();
        }else{
            Session::flash('error',$message);
                    return back();

        }

         Session::put('messages','Updated');
        return back();

    }
}
?>