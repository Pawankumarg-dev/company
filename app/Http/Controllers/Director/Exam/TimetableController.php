<?php

namespace App\Http\Controllers\Director\Exam;

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

class TimetableController extends Controller
{
    private $exam_id;
    private $exam;
    private $helper;
    private $timetableService; 
    private $scheduleService; 


    public function __construct(HelperService $helper,TimetableService $timetable, ScheduleService $schedule)
    {
        $this->middleware(['role:director']);
        $this->helper = $helper;
        //$this->exam_id = $this->helper->getScheduledExamID();
        $this->exam_id = 27;
        $this->exam = Exam::find($this->exam_id);
        $this->timetableService = $timetable;
        $this->scheduleService = $schedule;
    }

    public function index(Request $r){
        
        $timetables = null;
        $programme = null;
        $countofcandidates  = null;
        $course = null;
        $programmes = $this->helper->getProgrammes();
        $nber_id = \App\Director::where('user_id',Auth::user()->id)->first()->nber_id;
        $exam = $this->exam;
        //$courses = $this->helper->getCourses();
        $sql = "SELECT 
                        if(char_length(omr_code)=4,'Common',c.name) as course, 
                        s.syear, 
                        GROUP_CONCAT(distinct s.scode) as scode, 
                        s.omr_code,
                        s.sname,
                        if(char_length(omr_code)=4,'Multiple',ifnull(p.revision_year,'Old')) as revision 
                FROM subjects s 
                INNER JOIN programmes p ON p.id = s.programme_id
                INNER JOIN courses c on c.id = p.course_id 
            WHERE s.qp_required = 1  and  s.qp_prepared_by_nber_id = ". $nber_id ."  AND s.subjecttype_id = 1 AND s.is_external = 1 GROUP BY s.omr_code ORDER BY if(char_length(omr_code)=4,'Common',c.name), s.syear, s.sortorder, p.revision_year";

        $timetables = (new DBService())->fetch($sql);
        
        return view('director.exam.timetable.index',
            compact(
                'timetables',
                'exam',
                'programmes',
                'programme',
                'countofcandidates',
                'courses',
                'course'
            )
        );
    }

    public function create(Request $r){
        
        $existing_subjects = $this->timetableService->getTimetable($r->programme_id,$this->exam_id)->pluck('subject_id')->toArray();
        $subjects = \App\Subject::where('subjecttype_id',1)
                    ->where('programme_id',$r->programme_id)
                    ->whereNotIn('id',$existing_subjects)
                    ->get();
        $schedules = $this->scheduleService->getSchedule($this->exam_id);
        $exam = $this->exam;
        $programme = \App\Programme::find($r->programme_id);
        return view('nber.exam.timetable.create',compact(
            'exam',
            'subjects',
            'schedules',
            'programme'
        ));
    }

    public function store(StoreTimetableRequest $r){
        Examtimetable::create($r->all());
        return redirect('nber/exam/timetable?programme_id='.$r->programme_id);
    }

    public function show($id, Request $r){
        $subject_id = \App\Subject::where('omr_code',$id)->where('qp_required',1)->first()->id;
        $timetable = Examtimetable::where('subject_id',$subject_id)->where('exam_id',27)->first();
        $omr_code = $id;
        $exam = $this->exam;
        Session::forget('errors');
            
        //$languages = $this->timetableService->getLanguages($this->exam_id,$timetable->subject_id);
        $languages = \App\Language::all();
       // $notappliedlanguages = $this->timetableService->getNonLanguages();
        return view('director.exam.timetable.show',compact(
            'timetable',
            'languages',
            'exam',
            'omr_code'
        ));
    }

    public function destroy($id){
        return 'Nah nah';
        $timetable = Examtimetable::find($id);
        $timetable->delete();
        Session::flash('messages','Deleted');
        return back();
    }


}
