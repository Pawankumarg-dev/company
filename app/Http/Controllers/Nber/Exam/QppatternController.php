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

class QppatternController extends Controller
{
    private $exam_id;
    private $exam;
    private $helper;
    private $timetableService; 
    private $scheduleService; 


    public function __construct(HelperService $helper,TimetableService $timetable, ScheduleService $schedule)
    {
       $this->middleware(['role:nber']);
        $this->helper = $helper;
        $this->exam_id = $this->helper->getScheduledExamID();
        $this->exam = Exam::find($this->exam_id);
        $this->timetableService = $timetable;
        $this->scheduleService = $schedule;
    }

    public function update($id,Request $r){
        
        $tt = \App\Examtimetable::find($id);
        \App\Qppattern::create([
            'examtimetable_id' => $id,
            'subject_id' => $tt->subject_id,
            'heading' => $r->heading,
            'pagenumber'=> $r->pagenumber,
            'number_of_questions' => $r->number_of_questions,
            'number_of_questions_to_answer' => $r->number_of_questions_to_answer,
            'marks_per_question' => $r->marks_per_question,
            'qpset' => $tt->examschedule->qpset
        ]);
        Session::flash('messages','Uploaded');
        return back();
    }


    public function destroy($id){
        return 'Nah nah';
        $timetable = \App\Qppattern::find($id);
        $timetable->delete();
        Session::flash('messages','Deleted');
        return back();
    }


}
