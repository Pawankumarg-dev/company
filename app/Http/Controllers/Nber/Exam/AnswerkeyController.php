<?php

namespace App\Http\Controllers\Nber\Exam;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Exam;
use App\Examtimetable;

use App\Http\Requests\Exam\StoreTimetableRequest;

use App\Services\Common\HelperService;
use App\Services\Exam\TimetableService;
use App\Services\Exam\ScheduleService;

use Auth;
use Session;

use App\Services\DBService;

class AnswerkeyController extends Controller
{
    private $exam_id;
    private $exam;
    private $helper;
    private $timetableService; 
    private $scheduleService; 

    private $nber_id;

    public function __construct(HelperService $helper,TimetableService $timetable, ScheduleService $schedule)
    {
       $this->middleware(['role:nber']);
        $this->helper = $helper;
        $this->exam_id = $this->helper->getScheduledExamID();
        //$this->exam_id = Session::get('exam_id');
        $this->exam_id = 27;
        $this->exam = Exam::find($this->exam_id);
        $this->timetableService = $timetable;
        $this->scheduleService = $schedule;
        $this->nber_id = $this->helper->getNberID();
    }

    public function update($id,Request $r){
        
        try{
            $file = $r->answerkey;
            $randstring = $this->helper->generateRandomString();
            $filename = $id . '_' . $randstring . '.pdf';
            move_uploaded_file($file,"files/answerkeys/".$filename);
            $answerkey = \App\Answerkey::where('examtimetable_id',$id)->first();
            $tt = \App\Examtimetable::find($id);
            if(is_null($answerkey)){
                \App\Answerkey::create([
                    'examtimetable_id' => $id,
                    'subject_id' => $tt->subject_id,
                    'answerkey' => $filename,
                    'total_marks'=> $r->total_marks,
                    'qpset' => $tt->examschedule->qpset
                ]);
            }else{
                $answerkey->answerkey = $filename;
                $answerkey->total_marks = $r->total_marks;
                $answerkey->save();
            }
            Session::flash('messages','Uploaded');
        }catch(Exception $e){
            Session::flash('error','Could not upload');
        }
        return back();
    }

 
   
    public function show($id, Request $r){
        $timetable = Examtimetable::find($id);
        $patterns = \App\Qppattern::where('examtimetable_id',$id)->get();
        //$evaluators = \App\Subjectofevaluator::where('examtimetable_id',$id)->get();
        $evaluators = \App\Subjectofevaluator::where('subject_id',$timetable->subject_id)->where('exam_id',$this->exam_id)->get();
        $sp = "getAllFacultyList(".$this->nber_id.",'Evaluator')";
        $allevaluators = (new DBService)->callSP($sp,false);

        $exam = $this->exam;
         
        $sql = "select 
                count(*) as no_of_applications, 
                sum(if(a.blocked=0 and a.attendance_ex = 1,1,0)) as no_of_present, 
                sum(if(a.blocked=0 and ifnull(a.attendance_ex,0) = 0,1,0)) as pending_to_mark_attendance,
                sum(if(a.blocked=0 and ifnull(a.attendance_ex,0) = 1 and e.attn_verification = 1,1,0)) as verified_attendance
            from allapplications a 
            inner join candidates c 
            on c.id = a.candidate_id
            left join allexampapers e 
            on e.approvedprogramme_id = c.approvedprogramme_id and e.subject_id = a.subject_id
            where a.subject_id = " .$timetable->subject_id  .' and a.exam_id = '. $this->exam_id ;


        
        $status = (New DBService())->fetch($sql)[0];

        $sql = "
            select 
                l.id,
                l.language, 
                count(*) as no_of_applications
            from
                allapplications aa
            inner join
                allapplicants a on a.id = aa.applicant_id
            inner join languages l on l.id = a.language_id
            where 
               
                aa.subject_id = ".$timetable->subject_id .' and 
                aa.exam_id = ' . $this->exam_id .'
            group by l.id';
        $languages = (New DBService())->fetch($sql);
        return view('nber.exam.answerkey.show',compact(
            'timetable',
            'exam',
            'patterns',
            'status',
            'languages',
            'evaluators',
            'allevaluators'
        ));
    }

   


}
