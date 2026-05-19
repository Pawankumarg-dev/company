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
    private $exam_id;
    public function __construct(ExamService $exam,HelperService $helper)
    {
        $this->middleware(['role:examcenter']);
        $this->examService = $exam;
        $this->helperService = $helper;
        $this->exam_id =  $this->helperService->getScheduledExamID();
        $this->exam_id = 28;

    }
    public function index(){
        if(Auth::user()->id == 230434){
            return redirect(url('logoff'));
        }
        $externalexamcenter_id = $this->helperService->getExternalexamcenterID();
        $externalexamcenter = $this->helperService->getExternalexamcenter();


    //$exam_id = $this->helperService->getScheduledExamID();
       // $schedules = $this->examService->getSchedules($exam_id,$externalexamcenter_id);

    //     $schedule_ids = \App\Allexampaper::where('exam_id',$this->exam_id)->where('externalexamcenter_id',$externalexamcenter_id)->pluck('examschedule_id')->toArray();
    //    // return $schedule_ids;
    //     $schedules = \App\Examschedule::whereIn('id',$schedule_ids)->where('exam_id',$this->exam_id)->orderBy('examdate')->orderBy('starttime')->get();
    //     $count = [];
    //     foreach($schedules as $s){
    //         //$s['count'] = $this->examService->getStudentCount($exam_id,$externalexamcenter_id,$s->id);
    //         $s['count'] = \App\Allexampaper::where('exam_id',$this->exam_id)->where('examschedule_id',$s->id)->where('externalexamcenter_id',$externalexamcenter_id)->sum('theory');
    //     }

         //new code 
                 $exam_id=  $this->exam_id;

        $schedules = DB::table('allexamstudents')
        ->join('externalexamcenters', function ($join) use($exam_id) {
            $join->on('allexamstudents.externalexamcenter_id', '=', 'externalexamcenters.id')
                ->where('externalexamcenters.exam_id', '=' , $exam_id);
        })
        ->join('examschedules', 'allexamstudents.examschedule_id', '=', 'examschedules.id')
        ->where('allexamstudents.exam_id', $exam_id)
        ->where('allexamstudents.externalexamcenter_id',  $externalexamcenter_id)
        ->select(
            'examschedules.id',
            DB::raw('COUNT(examschedules.id) as count'),
            'examschedules.description',
            'examschedules.examdate',
            'examschedules.starttime',
            'examschedules.endtime',
            'examschedules.user_id',
            'examschedules.qpset',
            'examschedules.year',
            'examschedules.examtype_id'
        )
        ->groupBy('examschedules.id')
        ->orderBy('examschedules.examdate', 'ASC')
        ->orderBy('examschedules.starttime', 'ASC')
        ->get();
       
        
        return view('examcenter.schedule',compact(
            'schedules',
            'externalexamcenter'
        ));
    }

    public function show($id,Request $r){



        $examcenter = $this->helperService->getExternalexamcenter();
                $exam = \App\Exam::find($this->exam_id);

        $schedule = \App\Examschedule::find($id);
        set_time_limit(300);
        $format = 'html';
        // if($r->has('format') && !($r->format=='html')){
        //     $format = 'pdf';
        //     view()->share('applications',$applications);
        //     view()->share('schedule',$schedule);
        //     view()->share('examcenter',$examcenter);
        //     view()->share('format',$format);
        // }
        // $headers = array(
        //     'Content-Type: application/pdf',
        // );
        if($r->has('roomallocation')){
            
            if($format=='html'){


                 $applications = $this->examService->getStudentList($this->exam_id,$examcenter->id,$id,'approvedprogramme_id');

        

                return view('examcenter.roomallocation',compact(
                    'applications','schedule','examcenter','format','exam'
                ));
            }
            $pdf = PDF::loadView('examcenter.roomallocation')->setPaper('a4', 'portrait');   
            return $pdf->download('room_allocation_'.$schedule->examdate.'.pdf'); 
        }
        if($format=='html'){
           // return $applications;
           $applications = $this->examService->getStudentList($this->exam_id,$examcenter->id,$id,'approvedprogramme_id');
           //return $applications;
            return view('examcenter.attendancesheet',compact(
                'applications','schedule','examcenter','format','exam'
            ));
        }
        $pdf = PDF::loadView('examcenter.attendancesheet')->setPaper('a4', 'portrait');
        return $pdf->download('attendance_sheet_'.$schedule->examdate.'.pdf');
    }


    public function evalution_center(){
        $externalexamcenter_id = $this->helperService->getExternalexamcenterID();

$data = DB::table('evaluationcenterdetails')
    ->join('nbers', 'evaluationcenterdetails.nber_id', '=', 'nbers.id')
    ->join('programmes', 'programmes.nber_id', '=', 'nbers.id')
->join('allexamstudents', function ($join) {
    $join->on('allexamstudents.externalexamcenter_id', '=', 'evaluationcenterdetails.externalexamcenter_id')
         ->on('allexamstudents.exam_id', '=', 'evaluationcenterdetails.exam_id');
})

->join('subjects', 'subjects.id', '=', 'allexamstudents.subject_id')
    ->join('evaluationcenters', 'evaluationcenterdetails.evaluationcenter_id', '=', 'evaluationcenters.id')
    
    ->where('evaluationcenterdetails.exam_id', $this->exam_id)
        ->where('evaluationcenterdetails.externalexamcenter_id', $externalexamcenter_id)


    ->select(
        'nbers.name_code',
        'evaluationcenters.name',
        'evaluationcenters.address',
        'evaluationcenters.state',
        'evaluationcenters.active_status',
        'evaluationcenters.contactnumber1',
        'evaluationcenters.contactnumber2',
        'evaluationcenters.email1',
        'evaluationcenters.email2',
                'evaluationcenters.pincode',

        DB::raw('GROUP_CONCAT(distinct(subjects.scode)) as scodes'),
        DB::raw('GROUP_CONCAT(distinct(subjects.omr_code)) as omr_codes')
    )

    ->groupBy('evaluationcenters.id')
    
    ->get();

            return view('examcenter.evalutioncenter',compact('data'));

    }
}