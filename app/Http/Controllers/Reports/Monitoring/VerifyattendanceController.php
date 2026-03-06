<?php

namespace App\Http\Controllers\Reports\Monitoring;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Services\Exam\ExamService;
use App\Services\Common\HelperService;


class VerifyattendanceController extends Controller
{
    private $examService;
    private $helperService;
    private $exam_id;

    public function __construct(ExamService $exam,HelperService $helper)
    {
        $this->middleware(['role:reports']);
        $this->examService = $exam;
        $this->helperService = $helper;
        $this->exam_id = $this->helperService->getScheduledExamID();

    }
    public function show($id,Request $r){
        $exam_id = $this->exam_id;
        $applications =   $this->examService->getApplicantions($id,$r->subject_id);
        $approvedprogramme = \App\Approvedprogramme::find($id);
        $schedule_id = $r->examschedule_id;
        $schedule = \App\Examschedule::find($schedule_id);
        $subject = \App\Subject::find($r->subject_id);
        $nber = null;
        $document = \App\Allexampaper::where('subject_id',$r->subject_id)->where('approvedprogramme_id',$id)->where('exam_id',$this->exam_id)->first()->filename;

        return view('reports.monitoring.attendance.verify',compact(
            'applications',
            'schedule',
            'exam_id',
            'approvedprogramme',
            'subject',
            'nber',
            'document'
        ));
    }
}
?>