<?php

namespace App\Http\Controllers\Nber\Monitoring;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Services\Exam\ExamService;
use App\Services\Common\HelperService;
use \Session;

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

        $applications =   $this->examService->getApplicantions($id,$r->subject_id,null,null,$this->exam_id,0);
        if($r->approvedprogramme_id == 8837 ){
            $ec_id = \App\Allexampaper::where('approvedprogramme_id',$id)->first()->externalexamcenter_id;
            $district_id = \App\Externalexamcenter::find($ec_id)->district;
            $applications =   $this->examService->getApplicantions($r->approvedprogramme_id,$r->subject_id,null,null,27,$district_id);
        }
        $schedule_id = $r->examschedule_id;
        $schedule = \App\Examschedule::find($schedule_id);
        $subject = \App\Subject::find($r->subject_id);
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
}
?>