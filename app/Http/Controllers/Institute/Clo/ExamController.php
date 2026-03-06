<?php

namespace App\Http\Controllers\Clo;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Approvedprogramme;
use Illuminate\Support\Facades\App;
use Validator;
use App\Http\Controllers\Controller;
use Auth;
use App\Candidate;
use App\City;
use App\Community;
use App\Disability;
use App\Gender;
use App\Salutation;
use App\Subject;
use App\Application;
use App\Language;
use App\Programme;
use App\Institute;
use App\Exam;
use App\Examtimetable;
use App\Examcenter;
use App\Cloreportfile;
use App\Cloreport;
use Session;
use File;
use Input;
use Response;
use PDF;

class ExamController extends Controller
{
	public function __construct()
    {
        $this->middleware('clo');
    }

   

    public function uploadreports($exam_id){
    	$reports = Cloreportfile::where('exam_id','2')->get();
    	$exams = Examtimetable::where('exam_id',$exam_id)->where('enddate','<',\Carbon\Carbon::now())->groupBy('startdate')->get();
		//$today = Examtimetable::where('exam_id',$exam_id)->whereDate("startdate",'=',\Carbon\Carbon::today())->get();
		return view('clo.report.upload',compact('exams','today','exam_id','reports')) ;	
    }
    public function uploadreport($examtimetable_id,$cloreportfile_id,Request $request){
		$database = \Auth::user()->database_name;
    	
    	$rules = [
            'file' => 'required',
        ];
        $this->validate($request, $rules);
        $file = $request->file;

    	$clo = Session::get('clo');
    	if(!($file->isValid())){
            Session::put('error','Failed to Upload');
            return back();
        }else{
            $ex = explode('.', $path = $request->file->getClientOriginalName());
            $extn = end($ex);
            $filename = $examtimetable_id.'_'.$cloreportfile_id . '_'. rand(100,10000) . '.' . $extn ;
            move_uploaded_file($file,'files/'.$database.'/cloreport/'.$filename);
        }
    	

    	$cloreport = Cloreport::create(['clo_id'=>$clo->id,'cloreportfile_id'=>$cloreportfile_id,'file'=>$filename,'examtimetable_id'=>$examtimetable_id]);
    	Session::put('messages','Uploaded');
    	return back();
    }
	public function qpdownloads($exam_id){
		$questionpapers = Examtimetable::where('exam_id',$exam_id)->where('startdate','>',\Carbon\Carbon::now())->where('startdate','<',\Carbon\Carbon::now()->addHour(1))->get();
		$today = Examtimetable::where('exam_id',$exam_id)->whereDate("startdate",'=',\Carbon\Carbon::today())->get();
		return view('clo.questionpapers.download',compact('questionpapers','today','exam_id')) ;
	}

	public function qpdownload($et_id){		
		$et = Examtimetable::find($et_id);
		//$status = $et->exam->
		
		//$institute_id = Institute::where('user_id',Auth::user()->id)->first()->id;
		$clo = Session::get('clo');
		$institute_id = $clo->institute->first()->id;
		$exam_center = Examcenter::where('institute_id',$institute_id)->where('exam_id',$et->exam->id);
		$center = 1;
		if($exam_center->count() > 0){
			if($exam_center->first()->examcenter_id != $institute_id){
				$center = 0;
			}
		}
		$institutes_for = Examcenter::where('examcenter_id',$institute_id)->where('exam_id',$et->exam->id)->orderBy('institute_id')->lists('institute_id')->toArray();
		//$institute_ids =
		if($center==1){
			array_push($institutes_for,$institute_id);
		}
		//Session::put('error',json_encode($institutes_for));
		//return back();
		$programme_ids = array_unique(Approvedprogramme::whereIn('institute_id',$institutes_for)->orderBy('programme_id')->lists('programme_id')->toArray());
		//Session::put('error',json_encode($programme_ids));
		//return back();
		$programme_id = $et->subject->programme->id;
		if(in_array($programme_id, $programme_ids)){
			if($et->questionpaper){
				if($et->startdate > \Carbon\Carbon::now()){
					if($et->startdate < \Carbon\Carbon::now()->addHour(1) ){
						$file = public_path().'/files/questionpapers/'.$et->questionpaper;
						return Response::download($file);	
					}
				}
			}else{
				Session::put('error','Could not find the question paper to download');
				return back();
			}
		}else{

			Session::put('error','You are not autherized to download as your institute is not conducting this programme or the exam center is different');
			return back();
		}
		Session::put('error','Could not download');
		return back();
	}

    public function timetable(){
       
        $clo = Session::get('clo');
        $exam_id = 2;
        
        $timetable = Examtimetable::where('exam_id',$exam_id)->get();
        
  
        return view('clo.timetable',compact('candidate','timetable'));
    }
}

