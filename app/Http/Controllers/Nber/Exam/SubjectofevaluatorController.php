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

class SubjectofevaluatorController extends Controller
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
        $this->exam_id = 27;
        $this->exam = Exam::find($this->exam_id);
        $this->timetableService = $timetable;
        $this->scheduleService = $schedule;
    }

    public function update($id,Request $r){
        
        $tt = \App\Examtimetable::find($id);
        $sofe = \App\Subjectofevaluator::where('examtimetable_id',$id)->where('faculty_id',$r->evaluator_id)->where('language_id',$r->language_id)->where('exam_id',$this->exam_id)->first();
        if(is_null($sofe)){
            \App\Subjectofevaluator::create([
                'examtimetable_id' => $id,
                'subject_id' => $tt->subject_id,
                'faculty_id' => $r->evaluator_id,
                'language_id'=> $r->language_id,
                'exam_id' => $this->exam_id
            ]);
            Session::flash('messages','Updated');
        }else{
            Session::flash('messages','Already exists');
        }
        return back();
    }


    public function destroy($id){
        //return "Nah nah";
        $sofe = \App\Subjectofevaluator::find($id);
        $sofe->delete();
        Session::flash('messages','Deleted');
        return back();
    }


}
