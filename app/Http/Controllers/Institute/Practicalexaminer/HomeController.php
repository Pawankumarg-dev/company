<?php

namespace App\Http\Controllers\Practicalexaminer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use Session;

use App\Http\Requests;

class HomeController extends Controller
{
    private $helperService;

    public function __construct(HelperService $help)
    {
        $this->middleware(['role:practicalexaminer']);
        $this->helperService = $help;
    }
    public function index(Request $r){
        $practicalexaminer_id = $this->helperService->getPracticalExaminerID();
        $practicalexams = \App\Practicalexam::where('practicalexaminer_id',$practicalexaminer_id)->orderBy('institute_id')->get();
        $date = \Carbon\Carbon::now()->toDateString();
        if(Session::has('date')){
            $date = Session::get('date');
        }
        if($r->has('date')){
            $date =  $r->date == '2024-06-24' ? $r->date : $date;
            $date =  $r->date == '2024-06-25' ? $r->date : $date;
            $date =  $r->date == '2024-06-26' ? $r->date : $date;
            $date =  $r->date == '2024-06-27' ? $r->date : $date;
            $date =  $r->date == '2024-06-28' ? $r->date : $date;
            $date =  $r->date == '2024-06-29' ? $r->date : $date;
            $date =  $r->date == '2024-06-30' ? $r->date : $date;
            $date =  $r->date == '2024-07-01' ? $r->date : $date;
            $date =  $r->date == '2024-07-02' ? $r->date : $date;
            $date =  $r->date == '2024-07-03' ? $r->date : $date;
            $date =  $r->date == '2024-07-04' ? $r->date : $date;
            $date =  $r->date == '2024-07-05' ? $r->date : $date;
            $date =  $r->date == '2024-07-06' ? $r->date : $date;
            $date =  $r->date == '2024-07-07' ? $r->date : $date;
            $date =  $r->date == '2024-07-08' ? $r->date : $date;
            $date =  $r->date == '2024-07-09' ? $r->date : $date;
            $date =  $r->date == '2024-07-10' ? $r->date : $date;
            $date =  $r->date == '2024-07-11' ? $r->date : $date;
            $date =  $r->date == '2024-07-12' ? $r->date : $date;
            $date =  $r->date == '2024-07-13' ? $r->date : $date;
            $date =  $r->date == '2024-07-14' ? $r->date : $date;
            $date =  $r->date == '2024-07-15' ? $r->date : $date;
            $date =  $r->date == '2024-07-16' ? $r->date : $date;
            $date =  $r->date == '2024-07-17' ? $r->date : $date;
        }
        Session::put('date',$date);
        return view('practicalexaminer.home.index',compact(
            'practicalexams','practicalexaminer_id'
        ));
    }
    public function update($id,Request $request){
            $subject_id = $request->subject_id;
            $template = \App\Awardlisttemplate::find($id);
            
            $ap = \App\Approvedprogramme::find($template->approvedprogramme_id);
            $applications = \App\Newapplication::whereHas('newapplicant',function($q) use ($template){
                $q->where('approvedprogramme_id',$template->approvedprogramme_id);
            })->where('subject_id',$subject_id)
            ->get();

            
            
            foreach($applications as $application){
                $key = 'mark_'.$application->id;
                if($request->has($key)){
                    $application->external_mark = $request->$key;
                    $application->save();
                }
            }
            $subject = $template->subjects()->where('subject_id',$subject_id)->first();
            $subject->pivot->marks_upload = 1;
            $subject->pivot->date_uploaded = $date = \Carbon\Carbon::now()->toDateTimeString();
            $subject->pivot->save();
            Session::flash('messages','Uploaded');
            return back();
    }
}
