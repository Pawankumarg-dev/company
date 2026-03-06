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

class TimetableController extends Controller
{
    private $exam_id;
    private $exam;
    private $helper;
    private $timetableService; 
    private $scheduleService; 


    public function __construct(HelperService $helper,TimetableService $timetable, ScheduleService $schedule)
    {
       $this->middleware(['role:nber']);
        $this->exam_id = Session::get('exam_id');
        $this->exam = Exam::find($this->exam_id);
        $this->helper = $helper;
        $this->timetableService = $timetable;
        $this->scheduleService = $schedule;
    }

    public function index(Request $r){
        $timetables = null;
        $programme = null;
        $countofcandidates  = null;
        if($r->has('programme_id')){
            $timetables = $this->timetableService->getTimetable($r->programme_id,$this->exam_id)->get();
            $programme = \App\Programme::find($r->programme_id);
            $countofcandidates = $this->scheduleService->getCandidatesCount($r->programme_id);
        }
        $exam = $this->exam;
        $programmes = $this->helper->getProgrammes();
        return view('nber.exam.timetable.index',
            compact(
                'timetables',
                'exam',
                'programmes',
                'programme',
                'countofcandidates'
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
        $timetable = Examtimetable::find($id);

        $exam = $this->exam;
            
        $languages = $this->timetableService->getLanguages(25,$timetable->subject_id);
        $notappliedlanguages = $this->timetableService->getNonLanguages();
        return view('nber.exam.timetable.show',compact(
            'timetable',
            'languages',
            'exam',
            'notappliedlanguages'
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
