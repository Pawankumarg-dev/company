<?php

namespace App\Http\Controllers\Nber\Exam;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Hash;

use App\Services\Exam\ExamService;
use App\Services\Common\HelperService;
use App\Services\Exam\ScheduleService;
use Maatwebsite\Excel\Facades\Excel;

use PDF;

class AttendancetrackingController extends Controller
{
    private $examService;
    private $helperService;
    private $scheduleService;

    public function __construct(ExamService $exam,HelperService $helper, ScheduleService $schedule)
    {
       $this->middleware(['role:nber']);
        $this->examService = $exam;
        $this->helperService = $helper;
        $this->scheduleService = $schedule;

    }
    public function index(Request $r){
        $examcenters = \App\Examcenter::where('exam_id',25)->get();
        $schedules = null;
        $externalexamcenter_id = null;
        $exam_id = 25;
        $schedules = $this->examService->getSchedules($exam_id,$r->externalexamcenter_id);
        if($r->has('externalexamcenter_id')){
            $externalexamcenter_id = $r->externalexamcenter_id;
        }
        
        return view('nber.exam.attendance.schedule',compact(
            'schedules',
            'examcenters',
            'externalexamcenter_id'
        ));
    }

    public function show($id,Request $r){

        /*$institute_ids = \App\Supplimentaryapplicant::groupBy('institute_id')->pluck('institute_id')->unique()->toArray();
        $institutues = \App\Institute::whereIn('id',$institute_ids)->get();
        foreach($institutues as $institute){

            $exam_centers = \App\Examcenter::whereHas('states',function($q) use($institute){
                $q->where('lgstate_id',$institute->state_id);
            });
            if($exam_centers->count()==1){
                $exam_center = $exam_centers->first();
            }
            if($exam_centers->count()>1){
                $institute_rci_district = $institute->rci_district;
                $zone_id = \App\Statedistrict::where('name',$institute_rci_district)->first()->statezone_id;
                $exam_centers_with_zone = \App\Examcenter::whereHas('states',function($q) use($institute,$zone_id){
                    $q->where('lgstate_id',$institute->state_id);
                    $q->where('statezone_id',$zone_id);
                });
                if($exam_centers_with_zone->count()==1){
                    $exam_center = $exam_centers_with_zone->first();
                }
            }
            $institute->examcenter_se_24 = $exam_center->id;
            $institute->save();
        } */
        $exam_id = 25;
        $nber_id = $this->helperService->getNberID();
        $schedule_id = $r->examschedule_id;
        $schedule = \App\Examschedule::find($schedule_id);
        if($id > 0){
            $externalexamcenter = \App\Externalexamcenter::find($id);
            $externalexamcenter_id = $externalexamcenter->id;
        }else{
            //$subject_ids = $this->scheduleService->getSubjectIDs($schedule_id,$exam_id);
            if($exam_id == 25){
                //$applications =\App\Newapplication::whereIn('subject_id',$subject_ids)->get();
                $applications = \App\Exampaper::where('examschedule_id',$schedule_id)
                                ->whereHas('programme',function($q) use($nber_id){
                                    $q->where('nber_id',$nber_id);
                                })->orderBy('externalexamcenter_id')->orderBy('institute_id')->get();

            }else{
                //$applications =\App\Supplimentaryapplication::whereIn('subject_id',$subject_ids)->get();
            }
            //return $applications;
            return view('nber.exam.attendance.excel2',compact('applications'));
            Excel::create('attendance', function ($excel) use($applications){
                $excel->sheet('attendance', function ($sheet) use($applications){
                    $sheet->loadview('nber.exam.attendance.excel1',[
                        'applications' => $applications
                    ]);
                });
            })->export('xls');
        }
        $approvedprogrammes = $this->examService->getApprovedProgrammes($exam_id,$externalexamcenter->id,$schedule_id);
        $nber_id = $this->helperService->getNberID();
        $exampapers = \App\Exampaper::whereHas('programme',function($q) use($nber_id){
            $q->where('nber_id',$nber_id);
        })->get();
        //return $approvedprogrammes->pluck('institute_id');
        return view('nber.exam.attendance.index',compact(
            'approvedprogrammes',
            'schedule',
            'exam_id',
            'externalexamcenter_id',
            'externalexamcenter'
        ));
    }

    public function edit($id,Request $r){
        $externalexamcenter = \App\Externalexamcenter::find($id);
        $exam_id = 25;
        $applications =   $this->examService->getApplicantions($r->approvedprogramme_id,$r->subject_id);
        $approvedprogramme = \App\Approvedprogramme::find($r->approvedprogramme_id);
        $schedule_id = $r->examschedule_id;
        $schedule = \App\Examschedule::find($schedule_id);
        return view('nber.exam.attendance.attendance',compact(
            'applications',
            'schedule',
            'exam_id',
            'approvedprogramme',
            'externalexamcenter'
        ));
    }
}