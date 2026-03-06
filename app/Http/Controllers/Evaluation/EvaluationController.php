<?php

namespace App\Http\Controllers\Evaluation;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Evaluationcenter;

use App\Examtimetable;

use App\Evaluationcenterdetail;

use App\Approvedprogramme;

use App\Currentapplication;

use Illuminate\Support\Facades\DB;
use Auth;
use Session;

use App\Services\Exam\ExamService;
use App\Services\Common\HelperService;
use App\Services\Evaluation\EvaluationService;
use App\Services\Exam\TimetableService;

use App\Services\DBService;
use Maatwebsite\Excel\Facades\Excel;

class EvaluationController extends Controller
{
    private $examService;
    private $helperService;
    private $evaluationService;
    private $exam_id;
    private $timetableService;
    private $is_deo;

    public function __construct(ExamService $exam,HelperService $helper,EvaluationService $evaluation, TimetableService $timetable)
    {
        $this->middleware(['role:evaluationcenter']);
        $this->examService = $exam;
        $this->helperService = $helper;
        $this->exam_id = $this->helperService->getScheduledExamID();
        $this->evaluationService = $evaluation;
        $this->timetableService = $timetable;
        $this->is_deo = $this->evaluationService->isDEO();
    }

    public function index(Request $r){
        // $ecid =  $this->helperService->getEvaluationcenterID();
    //     if($r->has('download')){
         

    //         $sql = '
    //         select 
    //                 es.description,
    //                 es.examdate,
    //                 es.starttime,
    //                 es.endtime,
    //                 lgs.state_name as state,
    //                 eec.code,
    //                 eec.name,
    //                 i.rci_code,
    //                 i.name as institute,
    //                 p.abbreviation,
    //                 s.scode,
    //                 s.sname,
    //                 c.enrolmentno,
    //                 c.name as student,
    //                 a.answerbooklet_no,
    //                 if(ep.attn_verification = 1, "Verified", "Pending") as attendance_verification,
    //                 if(
    //                     abs.id is null, 
    //                     "Pending", 
    //                     if(
    //                         abs.scanned = 1, 
    //                         "Scanned", 
    //                         if(
    //                             pe.id is not null,
    //                             "Evaluator requested rescan",
    //                             "Pending"
    //                         )
    //                     )
    //                 ) as scanning_status,
    //                 if(
    //                     abs.id is null, 
    //                     "Pending", 
    //                     if(
    //                         abs.verified = 1, 
    //                         "Verified", 
    //                         "Pending"
    //                     )
    //                 ) as verification_status,
    //                 if(
    //                     abs.id is null, 
    //                     "Pending", 
    //                     if(
    //                         abs.uploaded = 1, 
    //                         "Verified", 
    //                         "Pending"
    //                     )
    //                 ) as upload_status,
    //                 if(
    //                     abs.id is null, 
    //                     "Pending", 
    //                     if(
    //                         abs.evaluated = 1, 
    //                         "Evaluated", 
    //                         "Pending"
    //                     )
    //                 ) as evaluation_status
    //         from 
    //             allapplications a
    //         left join 
    //             answerbookletscans abs
    //         on 
    //             abs.allapplication_id = a.id
    //         left join 
    //             pendingevaluations pe
    //         on 
    //             pe.allapplication_id = a.id and pe.reason_id = 1
    //         inner join
    //             candidates c
    //         on
    //             c.id = a.candidate_id
    //         inner join 
    //             approvedprogrammes ap 
    //         on 
    //             ap.id = c.approvedprogramme_id
    //         inner join
    //             programmes p
    //         on 
    //             p.id = ap.programme_id
    //         inner join 
    //             subjects s 
    //         on
    //             s.id = a.subject_id
    //         inner join
    //             examtimetables tt
    //         on
    //             tt.subject_id = s.id and tt.exam_id = ' . $this->exam_id . '
    //         inner join
    //             examschedules es 
    //         on 
    //             es.id = tt.examschedule_id
    //         inner join 
    //             institutes i
    //         on 
    //             i.id = ap.institute_id
    //         inner join
    //             examcenters ec 
    //         on 
    //             ec.exam_id =  ' . $this->exam_id . ' and ec.institute_id = ap.institute_id

    //         inner join
    //             externalexamcenters eec
    //         on 
    //             eec.id = ec.externalexamcenter_id
    //         inner join
    //             lgstates lgs
    //         on 
    //             lgs.id = eec.lgstate_id
    //         left join 
    //             evaluationcenterdetails evcd
    //         on
    //             evcd.evaluationcenter_id =  ' . $ecid . ' 
    //         and 
    //             evcd.externalexamcenter_id = ec.externalexamcenter_id
    //         and 
    //             evcd.exam_id =  ' . $this->exam_id . '
    //         inner join
    //             allexampapers ep
    //         on 
    //             ep.subject_id = s.id 
    //         and 
    //             ep.approvedprogramme_id = ap.id
    //         where
    //             a.blocked = 0
    //         and
    //             a.attendance_ex = 1
    //         and
    //         (
    //             (
    //                 '. $ecid .' = 64 and
    //                 (evcd.evaluationcenter_id = '. $ecid  .' or p.id = 57  )
    //             ) or 
    //             (
    //                 '. $ecid .' = 65 and
    //                 (evcd.evaluationcenter_id = '. $ecid  .' and  p.id != 57  )
    //             )
    //         )   
    //         group by 
    //             a.id
    //         order by
    //             es.examdate, es.starttime,es.endtime, lgs.state_name, eec.code, i.rci_code, c.enrolmentno;
    //         ';





    //         $results = (new DBService())->fetch($sql);
    //         Excel::create("AnswerBooklets", function ($excel) use ($results){
    //             $excel->sheet("AnswerBooklets", function ($sheet) use ($results){
    //                 $sheet->loadview("evaluationcenters/excel",compact('results'));
    //             });
    //         })->export('xlsx');
    //     }
    //     $sp= "evaluationcenterdashboard(".$this->exam_id.",".$ecid.",'summary')";
    //     $dashboard = (new DBService)->callSP($sp);
    //     $sp= "evaluationcenterdashboard(".$this->exam_id.",".$ecid.",'nber')";
    //     $courses = (new DBService)->callSP($sp);
    //    return view('evaluationcenters.notice',compact(
    //     'dashboard',
    //     'courses'
    //    ));

        $id =  $this->helperService->getEvaluationcenterID();
        $externalexamcenter_ids =  $this->evaluationService->getExternalexamcenterIDs($id);



        //$examcenter_ids = $this->evaluationService->getExamcenterIDs($externalexamcenter_ids);
        $course_id = null;
        if($r->has('course_id')){
            $course_id = $r->course_id;
             $institute_ids  = $this->evaluationService->getInstituteIDs($externalexamcenter_ids,$course_id);
            Session::put('institute_ids',$institute_ids);
            //$subjects = $this->evaluationService->getStats($institute_ids,null,'subject_id',$course_id);
            $exampapers = $this->evaluationService->getExamPapers($externalexamcenter_ids,$course_id);
            //return $subjects;
            $is_deo = $this->is_deo;
            $course = \App\Course::find($course_id);
            //return $exampapers;
            return view('evaluationcenters.index',compact('exampapers','is_deo','course'));
        }
        $courses = $this->evaluationService->getCourses($externalexamcenter_ids);
        //return $courses;
        return view('evaluationcenters.home',compact('courses'));
        
    }

    public function show($id,Request $r){
         ini_set('memory_limit','-1');

        $institute_ids = Session::get('institute_ids');
        if($r->has('downloaddummy')){
            $applications = $this->examService->getAllApplications($institute_ids,$id,1);
            $schedule = $this->timetableService->getSchedule($id);
            $subject = \App\Subject::find($id);
            $type = 'pdf';
            if($r->has('type')){
                $type = $r->type;
            }
            return view('evaluationcenters.dummy',compact('applications','schedule','subject','type'));
        }
        $subject = \App\Subject::find($id);


       
        //$subject_ids = $this->examService->addAlternative($id);
        //$approvedprogrammes =  $this->evaluationService->getApprovedprogrammes($institute_ids,$id,1);
        $is_deo = $this->is_deo;
        $ecid =  $this->helperService->getEvaluationcenterID();
        $externalexamcenter_ids =  $this->evaluationService->getExternalexamcenterIDs($ecid);



        // $subject_ids = $this->examService->addAlternative($subject->id);
      


        $applications =  \App\Allexamstudent::whereIn('externalexamcenter_id',$externalexamcenter_ids)->where('exam_id',27)->where('subject_id',$id)->where('attendance','!=',1)->get();


        // foreach($exampapers as $ep){
        //     $languages = \App\Language::whereIn('id',explode(',',$ep->language_ids))->select('id','language')->get();
        //     $ep['languages'] = $languages;
        // }

        $attendance  = 0;
        if($r->has('attendance')){
            $attendance = 1;
        }

        

        return view('evaluationcenters.show',compact('applications','subject','is_deo','attendance'));
    }

   public function savemark(Request $r){

    // echo $r->externalmark_1213244;

    // die();

  
 
        $externalexamcenter_id = $r->externalexamcenter_id;
        $subject_id = $r->subject_id;
        $message = '';

        $applications =  \App\Allexamstudent::where('externalexamcenter_id',$externalexamcenter_id)->where('exam_id',27)->where('subject_id',$subject_id)->where('attendance',1)->orderBy('language_id','candidate_id')->get();
 
        $subject = \App\Subject::where('id',$subject_id)->first();
        $max_mark = $subject->emax_marks;
        $count = 0;
    //       if (!$r->hasFile('uploaded_file')) {
    //     Session::put('error', 'Please choose a file');
    //     return back();
    // }

    $file = $r->file('uploaded_file');
    echo $fileName = '27_' . $externalexamcenter_id . '_' . $subject_id . '.' . $file->getClientOriginalExtension();
 
    
    $destinationPath = public_path('files/markfiles/');
    $file->move($destinationPath, $fileName);


        foreach($applications as $application){

                    $mark = 'externalmark_'.$application->id;
                    if($r->$mark > $max_mark){
                        $message = 'Marks for this subject cannot be more than '. $max_mark;
                    }else{
                        if($r->$mark == ''){
                            $message = 'Kindly Enter Marks for all the Students listed';
                        }else{
                                $application->external_mark = $r->$mark;
                                $application->mark_file = $fileName;
                                $application->save();
                            $count++;
                        }
                    }
            
            if($message==''){
                Session::put('messages','Updated');
                // $ep = \App\Allexampaper ::where('exam_id',27)->where('externalexamcenter_id',$externalexamcenter_id)->where('subject_id',$subject_id)->where('attendance',1)->first();
                // $ep->evaluated = $count;
                // $ep->save();
                // Session::put('message','marks_updated');

            }else{
                Session::put('error',$message);
            }
        }
        return back();
   }
   /*
    public function showsubjects(Request $r){
        //return 'Evaluation Center Login is closed';

        $examdate = $r->examdate;
        $starttime = $r->starttime;
        $endtime = $r->endtime;
        $evaluationcenter_id = Evaluationcenter::where('user_id',Auth::user()->id)->orWhere('deuser_id',Auth::user()->id)->first()->id;
        $examcenter_ids = Evaluationcenterdetail::where('evaluationcenter_id',$evaluationcenter_id)->pluck('externalexamcenter_id')->toArray();
        $institute_ids  = DB::select("select distinct institute_id from kvttis where externalexamcenter_id in (" . implode($examcenter_ids,',').")");
        $approvedprogrammes =    Approvedprogramme::whereIn('institute_id',array_pluck($institute_ids,'institute_id'))->get();
        return view('evaluationcenters.subjects',compact('examdate','starttime','endtime','approvedprogrammes'));
    }
    */
    public function markentry($externalexamcenter_id,$subject_id,Request $r){
       // return 'Evaluation Center Login is closed';

//        $examdate = $r->examdate;
       // return 'Evaluation Center Login is closed';

  /*      $starttime = $r->starttime;
        $endtime = $r->endtime;
        $kvdailysubject_id = $r->kvdailysubject_id;
        $evaluationcenter_id = Evaluationcenter::where('user_id',Auth::user()->id)->orWhere('deuser_id',Auth::user()->id)->first()->id;
        $examcenter_ids = Evaluationcenterdetail::where('evaluationcenter_id',$evaluationcenter_id)->pluck('externalexamcenter_id')->toArray();
        $institute_ids  = DB::select("select distinct institute_id from kvttis where externalexamcenter_id in (" . implode($examcenter_ids,',').")");
        $approvedprogramme_ids =    Approvedprogramme::whereIn('institute_id',array_pluck($institute_ids,'institute_id'))->pluck('id')->toArray();
        if(in_array($apid, $approvedprogramme_ids)){
            $timetable= Examtimetable::where('subject_id',$subject_id)->where('exam_id',22)->first();
            if($examdate==$timetable->examdate && $starttime == $timetable->starttime){
                $applications = Currentapplication::where('approvedprogramme_id',$apid)->where('subject_id',$subject_id)->get();
                $approvedprogramme = Approvedprogramme::find($apid);
            }else{
                return redirect('/evaluationcenter');
            }
            return view('evaluationcenters.markentry',compact('examdate','starttime','endtime','applications','approvedprogramme','kvdailysubject_id'));
        }else{
            return redirect('/evaluationcenter');
        } */
        // if(!$this->is_deo){
        //     return back();
        // }

$id =  $this->helperService->getEvaluationcenterID();
        if ($id == 65) {
    // $applications = \App\Allexamstudent::where('externalexamcenter_id', $externalexamcenter_id)
    //     ->where('exam_id', 27)
    //     ->where('subject_id', $subject_id)
    //     ->where('attendance', 1)
    //     ->orderBy('language_id','DESC')
    //     ->orderBy('candidate_id','DESC')
    //     ->get();
            $applications =  \App\Allexamstudent::where('externalexamcenter_id',$externalexamcenter_id)->where('exam_id',27)->where('subject_id',$subject_id)->where('attendance',1)->orderBy('language_id')->get();

} else {
    $applications =  \App\Allexamstudent::where('externalexamcenter_id',$externalexamcenter_id)->where('exam_id',27)->where('subject_id',$subject_id)->where('attendance',1)->orderBy('language_id','candidate_id')->get();
}



        // $applications =  \App\Allexamstudent::where('externalexamcenter_id',$externalexamcenter_id)->where('exam_id',27)->where('subject_id',$subject_id)->where('attendance',1)->orderBy('language_id','candidate_id')->get();

        
        // $evaluationcenter_id = $this->helperService->getEvaluationcenterID();
        // $evaluationcenter = $this->evaluationService->getEvaluationcenter($evaluationcenter_id);
        // $language = $r->has('language_id') ? \App\Language::find($r->language_id)->language : null;



        
        // // $approvedprogramme = Approvedprogramme::find($apid);
        // $schedule = $this->timetableService->getSchedule($subject_id);
        // $applications =   $this->examService->getApplicantions($apid,$subject_id,1);
        $subject = \App\Subject::find($subject_id);
        // $evaluationcenter_id = $this->helperService->getEvaluationcenterID();
        // $evaluationcenter = $this->evaluationService->getEvaluationcenter($evaluationcenter_id);

        return view('evaluationcenters.markentry',compact('applications','subject'));
    }


    public function dummynumbers($apid,$subject_id,Request $r){
        //return 'Evaluation Center Login is closed';

 	ini_set('memory_limit','-1');

       /* $examdate = $r->examdate;
        $starttime = $r->starttime;
        $endtime = $r->endtime;
        $kvdailysubject_id = $r->kvdailysubject_id;
        $evaluationcenter_id = Evaluationcenter::where('user_id',Auth::user()->id)->orWhere('deuser_id',Auth::user()->id)->first()->id;
        $examcenter_ids = Evaluationcenterdetail::where('evaluationcenter_id',$evaluationcenter_id)->pluck('externalexamcenter_id')->toArray();
        $institute_ids  = DB::select("select distinct institute_id from kvttis where externalexamcenter_id in (" . implode($examcenter_ids,',').")");
        $approvedprogramme_ids =    Approvedprogramme::whereIn('institute_id',array_pluck($institute_ids,'institute_id'))->pluck('id')->toArray();
        if(in_array($apid, $approvedprogramme_ids)){
            $timetable= Examtimetable::where('subject_id',$subject_id)->where('exam_id',22)->first();
            if($examdate==$timetable->examdate && $starttime == $timetable->starttime){
                $applications = Currentapplication::where('approvedprogramme_id',$apid)->where('subject_id',$subject_id)->get();
                $approvedprogramme = Approvedprogramme::find($apid);
            }else{
                return redirect('/evaluationcenter');
            }
            return view('evaluationcenters.dummy',compact('examdate','starttime','endtime','applications','approvedprogramme','kvdailysubject_id'));
        }else{
            return redirect('/evaluationcenter');
        } */
        if($this->is_deo){
            return back();
        }
        if($r->has('type')){
            $type = $r->type;
        }


        
        $approvedprogramme = Approvedprogramme::find($apid);


        $schedule = $this->timetableService->getSchedule($subject_id);


        
        // $applications =   $this->examService->getApplicantions_evalution($apid,$subject_id,1);






      
        $externalexamcenter_ids =  $this->evaluationService->getExternalexamcenterIDs($this->helperService->getEvaluationcenterID());

        $subject = \App\Subject::find($subject_id);

        $applications =  \App\Allexamstudent::whereIn('externalexamcenter_id',$externalexamcenter_ids)->where('exam_id',27)->where('subject_id',$subject_id)->where('attendance',1)->orderBy('externalexamcenter_id','candidate_id','language_id')->get();
 
        $applications = $applications->sortBy(function($a) {
            return $a->candidate->enrolmentno;
        });

        $subject = \App\Subject::find($subject_id);
        return view('evaluationcenters.dummy',compact('approvedprogramme','applications','schedule','subject','type'));
    }

    public function printcover($apid,$subject_id,Request $r){
        if($this->is_deo){
            return back();
        }
        $approvedprogramme = Approvedprogramme::find($apid);
        $subject = \App\Subject::find($subject_id);
        $schedule = $this->timetableService->getSchedule($subject_id);
        return view('evaluationcenters.printcover',compact('approvedprogramme','subject','schedule'));
    }

    public function printfoilsheet($externalexamcenter_id,$subject_id,$apid,Request $r){
        if($this->is_deo){
            return back();
        }
       /// return 'Evaluation Center Login is closed';

       /* $examdate = $r->examdate;
        $language = \App\Language::find($r->language_id);
        $starttime = $r->starttime;
        $kvdailysubject_id = $r->kvdailysubject_id;
        $subject = \App\Subject::find($subject_id);
        $evaluationcenter = Evaluationcenter::where('user_id',Auth::user()->id)->orWhere('deuser_id',Auth::user()->id)->first();
        $evaluationcenter_id = $evaluationcenter->id;
        $examcenter_ids = Evaluationcenterdetail::where('evaluationcenter_id',$evaluationcenter_id)->pluck('externalexamcenter_id')->toArray();
        $institute_ids  = DB::select("select distinct institute_id from kvttis where externalexamcenter_id in (" . implode($examcenter_ids,',').")");
        $approvedprogramme_ids =    Approvedprogramme::whereIn('institute_id',array_pluck($institute_ids,'institute_id'))->pluck('id')->toArray();
        if(in_array($apid, $approvedprogramme_ids)){
            $timetable= Examtimetable::where('subject_id',$subject_id)->where('exam_id',22)->first();
            if($examdate==$timetable->examdate && $starttime == $timetable->starttime){
                $applications = Currentapplication::where('approvedprogramme_id',$apid)->where('language_id',$r->language_id)->where('subject_id',$subject_id)->get();
                $approvedprogramme = Approvedprogramme::find($apid);
            }else{
                return redirect('/evaluationcenter');
            }
            return view('evaluationcenters.foilsheet',compact('language','subject','applications','approvedprogramme','evaluationcenter'));
        }else{
            return redirect('/evaluationcenter');
        } */
        $approvedprogramme = Approvedprogramme::find($apid);
        $schedule = $this->timetableService->getSchedule($subject_id);
        $language_id = $r->has('language_id') ? $r->language_id : null;
        // $applications =   $this->examService->getApplicantions($apid,$subject_id,1,$language_id);
                // $externalexamcenter_ids =  $this->evaluationService->getExternalexamcenterIDs($this->helperService->getEvaluationcenterID());

                $applications =  \App\Allexamstudent::where('externalexamcenter_id',$externalexamcenter_id)->where('exam_id',27)->where('subject_id',$subject_id)->where('attendance',1)->orderBy('language_id','candidate_id')->get();

        $subject = \App\Subject::find($subject_id);
        $evaluationcenter_id = $this->helperService->getEvaluationcenterID();
        $evaluationcenter = $this->evaluationService->getEvaluationcenter($evaluationcenter_id);
        $language = $r->has('language_id') ? \App\Language::find($r->language_id)->language : null;
        return view('evaluationcenters.foilsheet',compact('approvedprogramme','applications','schedule','subject','evaluationcenter','language'));
    }




      public function printcouversheet($externalexamcenter_id,$subject_id,$apid,Request $r){
        if($this->is_deo){
            return back();
        }
        $approvedprogramme = Approvedprogramme::find($apid);
        $schedule = $this->timetableService->getSchedule($subject_id);
        $language_id = $r->has('language_id') ? $r->language_id : null;
        $applications =  \App\Allexamstudent::where('externalexamcenter_id',$externalexamcenter_id)->where('exam_id',27)->where('subject_id',$subject_id)->where('attendance',1)->orderBy('language_id','candidate_id')->get();
        $subject = \App\Subject::find($subject_id);
        $evaluationcenter_id = $this->helperService->getEvaluationcenterID();
        $evaluationcenter = $this->evaluationService->getEvaluationcenter($evaluationcenter_id);
        $language = $r->has('language_id') ? \App\Language::find($r->language_id)->language : null;

        return view('evaluationcenters.couversheet',compact('approvedprogramme','applications','schedule','subject','evaluationcenter','language'));
    }
    /*public function enablemarkentry(){
        $evaluationcenter = Evaluationcenter::where('user_id',Auth::user()->id)->orWhere('deuser_id',Auth::user()->id)->first();
        $evaluationcenter->enable_markentry = 1;
        $evaluationcenter->save();
        Session::put('message','Mark entry enabled, please select the date and time of examination to proceed.');
        return back();
    } */
}
