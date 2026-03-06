<?php

namespace App\Http\Controllers\Examcenter\Exam;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Hash;

use App\Services\Exam\ExamService;
use App\Services\Common\HelperService;
use PDF;

class QuestionPaperController extends Controller
{
    private $examService;
    private $helperService;
    private $exam_id;

    public function __construct(ExamService $exam,HelperService $helper)
    {
        $this->middleware(['role:examcenter']);
        $this->examService = $exam;
        $this->helperService = $helper;
        $this->exam_id = 24;

    }
    public function index(Request $r){
        
      //  return '';
        /*$filename = 'files/questionpapers/25_1743_2_HUQSMyiDa4.pdf';
        $title = 'rcinber.org.in/'. Auth::user()->id;
        return view('examcenter.questionpaper.view',compact('filename','title'));
        return response()->file('',$headers); */
        if($r->examschedule_id == 31   ){
            $externalexamcenter = $this->helperService->getExternalexamcenter();
            //return $externalexamcenter;
           // if($externalexamcenter->second_year_strenght > 0){
                $exam_id = $this->exam_id;
                $schedule_id = $r->examschedule_id;
                $schedule = \App\Examschedule::find($schedule_id);
                $session_id = Session::getId();
                
            /*    $sql = "select s.id as subject_id, s.has_alternative, n.name_code, n.email, p.display_code, group_concat(distinct y.year) as batches, s.scode, s.sname,  count(*) as noofstudent, tt.id as id, group_concat(distinct a.language_id) as language_ids from newapplications na
                left join newapplicants a on a.id = na.newapplicant_id
                left join institutes i on i.id = a.institute_id
                left join examcenters ec on ec.institute_id = i.id
                left join examtimetables tt on tt.subject_id = na.subject_id
                left join examschedules es on es.id = tt.examschedule_id
                left join subjects s on s.id = na.subject_id
                left join programmes p on p.id = s.programme_id
                left join nbers n on n.id = p.nber_id
                left join approvedprogrammes ap on ap.id = a.approvedprogramme_id
                left join academicyears y on y.id = ap.academicyear_id
                where ec.externalexamcenter_id = ".$externalexamcenter->id." and es.id = ". $schedule_id ."
                group by tt.id";
                $result=  DB::select($sql);
                $exams = array_map(function ($value) {
                    return (array)$value;
                }, $result); */
                //return $exams[0];
                 $downloadedcount = \App\Exampaper::where('examschedule_id',$schedule_id)
                ->where('externalexamcenter_id',$externalexamcenter->id)
                ->whereNotNull('downloaded_session')->count();
                if($downloadedcount!=0){
                    $loggedinsession = \App\Exampaper::where('examschedule_id',$schedule_id)
                    ->where('externalexamcenter_id',$externalexamcenter->id)
                    ->whereNotNull('downloaded_session')->first()->downloaded_session ;
                    if($loggedinsession == $session_id){
                        $downloadedcount = 0;
                    }
                }
                $downloadedcount = 0;
                
                if($downloadedcount == 0){
                    $exams = \App\Exampaper::where('examschedule_id',$schedule_id)
                        ->where('externalexamcenter_id',$externalexamcenter->id)
                        ->groupBy('programme_id')
                        ->selectRaw('*, group_concat(distinct batch) as batches, sum(theory) as no_of_student')
                        ->get();
                    //  $alt1 = \App\Examtimetable::find(1701);
                    //  $alt2 = \App\Examtimetable::find(1652);
                    return view('examcenter.questionpaper.index',compact(
                        'exams',
                        'schedule',
                        'session_id'
                    ));
                }
            //}
        }
        return back();
        
    }

    public function show($id,Request $r){
        return '';
        $exam_id = $this->exam_id;
        $applications =   $this->examService->getApplicantions($id,$r->subject_id);
        $approvedprogramme = \App\Approvedprogramme::find($id);
        $schedule_id = $r->examschedule_id;
        $schedule = \App\Examschedule::find($schedule_id);
        return view('examcenter.attendance.mark',compact(
            'applications',
            'schedule',
            'exam_id',
            'approvedprogramme'
        ));
    }

    public function store(Request $r){
        return '';
        $applications =   $this->examService->getApplicantions($r->approvedprogramme_id,$r->subject_id);
        $message = '';
        $examcenter_id = $this->helperService->getExternalexamcenterID();
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
            $application->externalexamcenter_id = $examcenter_id;
            $application->save();
        }   
        if($message==''){
            Session::flash('messages','Updated');
        }else{
            Session::flash('error',$message);
        }
        return redirect('/examcenter/attendance?examschedule_id='.$r->examschedule_id);
    }
}