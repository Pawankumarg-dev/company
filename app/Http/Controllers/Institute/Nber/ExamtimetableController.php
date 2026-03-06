<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Examtimetable;
use App\Programme;
use App\Subject;
use App\Exam;
use App\Institute;
use App\Examcenter;
use Session;
use Auth;

class ExamtimetableController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }
    public function index(Request $request){
        $examtimetables = Examtimetable::where('exam_id',$request->exam);/*->whereHas('exam',function($q) {
                    $q->whereHas('academicyear',function($r) {
                        $r->where('academicyear_id', Session::get('academicyear_id'));
                    });
                });*/

        $collections = $examtimetables->paginate(10);
    	$link = 'examtimetables';
    	$text = 'Timetable';
        $exams = Exam::all();
        $subjects = Subject::all();
        $programmes = Programme::all();
        $breadcrumblinkto = 'exams';
        $breadcrumblinktext = "Exams";
    	return view('nber.examtimetables.index',compact('collections','link','text','exams','subjects','programmes','breadcrumblinkto','breadcrumblinktext'));
    }

    public function questionpapers(Request $request){
      /*  if($request->has('day')){
            if($request->day=='tomorrow'){
                $examtimetables = Examtimetable::where('exam_id',$request->exam)->whereDate("startdate",'=',\Carbon\Carbon::tomorrow());
            }else{
                if($request->day=='all'){
                    $examtimetables = Examtimetable::where('exam_id',$request->exam);
                }else{
                    $examtimetables = Examtimetable::where('exam_id',$request->exam)->where("startdate",'=',$request->day);  
                }
            }
        }else{
            $examtimetables = Examtimetable::where('exam_id',$request->exam)->whereDate("startdate",'=',\Carbon\Carbon::today());    
        }
        */
        $startdates = array_unique(Examtimetable::where('exam_id',$request->exam)->orderBy('startdate')->lists('startdate')->toArray());
        //return $startdates;

        //$collections = $examtimetables->paginate(20);
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        $collections = Examtimetable::where('exam_id',22)->whereHas('subject',function($q) use($nber_id){
            $q->whereHas('programme',function($p) use($nber_id){
                $p->where('nber_id',$nber_id);
            });
            $q->where('subjecttype_id',1);
        })->paginate(20);
        $link = '';
        $text = 'Question Papers';
        $exams = Exam::all();
        $subjects = Subject::all();
        $programmes = Programme::all();
        $breadcrumblinkto = 'exams';
        $breadcrumblinktext = "Exams";

        return view('nber.questionpapers.index',compact('collections','link','text','exams','subjects','programmes','breadcrumblinkto','breadcrumblinktext','startdates'));
    }
    public function uploadquestionpaper(Request $r){
        $exam = Examtimetable::find($r->id);
        $file = $r->inputfile;
        if(!($file->isValid())){
            Session::put('error','Failed to Upload');
        }else{
            $filename = $r->id.'_'.$r->subject_id.'_'.str_random(8).'_'.$r->inputfile->getClientOriginalName();
            move_uploaded_file($file,'files/questionpapers/'.$filename);      
            $exam->update(['questionpaper'=>$filename]);
        }
       
        return back();
    }
    public function create(Request $request){
    	Examtimetable::create($request->all());
    	return back();// redirect('/examtimetables');
    }
    public function update(Request $request){
    	$examtimetable = Examtimetable::find($request->id);
    	$examtimetable->update($request->except('id'));
        //return $examtimetable->startdate;
    	return back();// redirect('/examtimetables');
    }
    public function examcenters(Request $request){
        $collections = Institute::with('examcenters')->paginate(200);
        $institutes = Institute::all();
        $exam = Exam::find($request->exam);
        $link = 'examcenters';
        $text = "Exam Centers (".$exam->name.")";
        $breadcrumblinkto = 'exams';
        $breadcrumblinktext ='Exams';
        return view('nber.examcenters.index',compact('collections','exam','link','text','institutes','breadcrumblinkto','breadcrumblinktext'));

    }
    public function updateexamcenter(Request $request){
        $examcenter = Examcenter::where('exam_id',$request->exam)->where('institute_id',$request->id);
        if($examcenter->count()>0){
            $examcenter= $examcenter->first();
            $examcenter->update(['examcenter_id'=>$request->examcenter_id]);
        }else{
            Examcenter::create(['exam_id'=>$request->exam,'institute_id'=>$request->id,'examcenter_id'=>$request->examcenter_id]);
        }
        $ins = Institute::find($request->id)->user->username;
        $exc  = Institute::find($request->examcenter_id)->user->username;

        $request->session()->flash('status', $ins .'\'s exam center changed to '. $exc );

        return back();

    }

    public function showexams() {

    }

    public function showexamtimetables($e_id) {
        $exam = Exam::find($e_id);

        $examtimetables = Examtimetable::select('examtimetables.*')
            ->join('subjects', 'subjects.id', '=', 'examtimetables.subject_id')
            ->join('programmes', 'programmes.id', '=', 'subjects.programme_id')
            ->where('examtimetables.exam_id', $exam->id)
            ->orderBy('examtimetables.startdate')
            ->orderBy('programmes.sortorder')
            ->orderBy('subjects.syear')
            ->orderBy('subjects.sortorder')
            ->get();

        $examstartdates = Examtimetable::where('exam_id', $exam->id)->groupBy('startdate')->get();

        return view('nber.examtimetables.showtimetables', compact('exam', 'examtimetables', 'examstartdates'));
    }
}
