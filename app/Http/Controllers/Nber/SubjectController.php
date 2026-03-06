<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Programmegroup;

use App\Programme;

use App\Subject;

use App\Subjecttype;

use App\Examtimetable;

use Session;

use Auth;
class SubjectController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }
    public function fileupload(Request $r){
        return "Success";
    }

    public function timetable(){
        $id = Session::get('exam_id');
        $timetables = Examtimetable::where('exam_id',$id)->where('examdate','>','2023-09-08')->whereHas('subject',function($q){
            $q->where('subjecttype_id',1)->where('programme_id', '!=', 38);
        })->groupBy('examdate','starttime')->get();
        return view('nber.timetable.index',compact('timetables'));
    }

    public function questionpapers(Request $r)
    {
        $examdate = $r->examdate;
        $starttime = $r->starttime;
        $endtime = $r->endtime;
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        $timetables = Examtimetable::where('exam_id',22)->whereHas('subject',function($q) use($nber_id){
            $q->whereHas('programme',function($p) use($nber_id){
                $p->where('nber_id',$nber_id);
            });
            $q->where('subjecttype_id',1);
        });
        $languages = \App\Language::all();
        return view('nber.timetable.questionpapers',compact('timetables','examdate','starttime','endtime','languages'));
    }

    public function index($id,Request $r){
        
    	$collections = Subject::where('programme_id',$id);
        $programme = Programme::find($id)->course_name;
        $p = Programme::find($id);

        if($r->has('subjecttype_id')){
            $collections = $collections->whereIn('subjecttype_id',$r->subjecttype_id);
            $subjecttype_ids = implode(',',$r->subjecttype_id);
        }else{
            $subjecttype_ids = "1,2";
        }
        if($r->has('year')){
            $collections = $collections->whereIn('syear',$r->year);
            $years = implode(',',$r->year);
        }else{
            $years = "1,2";
        }
        $collections=$collections->orderBy('syear','asc')->orderBy('subjecttype_id')->orderBy('sortorder')->paginate(20);
        $pid = $id;
    	$link = 'subjects';
        $languages = \App\Language::all();
    	$breadcrumblinkto = 'programmes';
        $breadcrumblinktext = 'Programmes';
    	$text = ' Subjects for '. $programme;
    	$subjecttypes = Subjecttype::all();
        return view('nber.programmes.subjects',compact('collections','link','text','subjecttypes','pid','languages','p','subjecttype_ids','years'));
    }
    public function create(Request $request){
        echo json_encode($request->all());
    	$subject = Subject::create($request->all());
    	return back();
    }
    public function update(Request $request){
    	$sub = Subject::find($request->id);
    	$sub->update($request->except('id'));
      /*  $timetable = Examtimetable::where('exam_id',22)->where('subject_id',$request->id);
        if($timetable->count() > 0){
            $timetable=$timetable->first();
            $timetable->startdate = $request->startdate;
            $timetable->starttime = $request->starttime;
            $timetable->endtime = $request->endtime;
            $timetable->save();
        }else{
            Examtimetable::create([
                'examdate' => $request->startdate,
                'startdate' => $request->startdate,
                'starttime' => $request->starttime,
                'endtime' => $request->endtime,
                'exam_id' => 22,
                'subject_id' => $request->id
            ]);
        } */
        return back();
    }
}
