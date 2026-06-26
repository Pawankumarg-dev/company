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
     

        $id =  $this->helperService->getEvaluationcenterID();
        $externalexamcenter_ids =  $this->evaluationService->getExternalexamcenterIDs($id);
$nber_id= \App\Evaluationcenterdetail::where('exam_id',$this->exam_id)
                        ->where('evaluationcenter_id',$id)
                        ->pluck('nber_id')->toArray();


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

            $exam_id=$this->exam_id;
            // return $exampapers;
            return view('evaluationcenters.index',compact('exampapers','is_deo','course','exam_id'));
        }
        $courses = $this->evaluationService->getCourses($externalexamcenter_ids,$nber_id);
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
      


        $applications =  \App\Allexamstudent::whereIn('externalexamcenter_id',$externalexamcenter_ids)->where('exam_id',$this->exam_id)->where('subject_id',$id)->where('attendance','!=',1)->get();


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

        $applications =  \App\Allexamstudent::where('externalexamcenter_id',$externalexamcenter_id)->where('exam_id',$this->exam_id)->where('subject_id',$subject_id)->where('attendance',1)->orderBy('language_id','candidate_id')->get();
 
        $subject = \App\Subject::where('id',$subject_id)->first();
        $max_mark = $subject->emax_marks;
        $count = 0;
    //       if (!$r->hasFile('uploaded_file')) {
    //     Session::put('error', 'Please choose a file');
    //     return back();
    // }

    $file = $r->file('uploaded_file');
    echo $fileName = $this->exam_id.'_' . $externalexamcenter_id . '_' . $subject_id . '.' . $file->getClientOriginalExtension();
 
    
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


    $applications =  \App\Allexamstudent::where('externalexamcenter_id',$externalexamcenter_id)->where('exam_id',$this->exam_id)->where('subject_id',$subject_id)->where('attendance',1)->orderBy('language_id','candidate_id')->get();


 $exam=\App\Exam::where('scheduled_exam',1)->first();

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

        return view('evaluationcenters.markentry',compact('applications','subject','exam'));
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

        $applications =  \App\Allexamstudent::whereIn('externalexamcenter_id',$externalexamcenter_ids)->where('exam_id',$this->exam_id)->where('subject_id',$subject_id)->where('attendance',1)->orderBy('externalexamcenter_id','candidate_id','language_id')->get();
 
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

                $applications =  \App\Allexamstudent::where('externalexamcenter_id',$externalexamcenter_id)->where('exam_id',$this->exam_id)->where('subject_id',$subject_id)->where('attendance',1)->orderBy('language_id','candidate_id')->get();

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
        $applications =  \App\Allexamstudent::where('externalexamcenter_id',$externalexamcenter_id)->where('exam_id',$this->exam_id)->where('subject_id',$subject_id)->where('attendance',1)->orderBy('language_id','candidate_id')->get();
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
