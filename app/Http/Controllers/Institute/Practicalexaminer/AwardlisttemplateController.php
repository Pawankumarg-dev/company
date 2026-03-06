<?php

namespace App\Http\Controllers\Practicalexaminer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use Session;

use App\Http\Requests;

class AwardlisttemplateController extends Controller
{
    private $helperService;

    public function __construct(HelperService $help)
    {
        $this->middleware(['role:practicalexaminer']);
        $this->helperService = $help;
    }
    public function store(Request $r){
        $practicalexaminer_id = $this->helperService->getPracticalExaminerID();
        $practicalexaminer  = \App\Practicalexaminer::find($practicalexaminer_id);
        //$date = \Carbon\Carbon::now()->toDateString();
        $date = Session::get('date');
        $downloadTime = \Carbon\Carbon::now()->toDateTimeString();
        $term = $r->term;
        $templates = \App\Awardlisttemplate::where('practicalexaminer_id',$practicalexaminer_id)
                    ->where('exam_date',$date)
                    ->where('practicalexam_id',$r->practicalexam_id)
                    ->where('institute_id',$r->institute_id)
                    ->where('approvedprogramme_id',$r->approvedprogramme_id)
                    ->where('term',$term)
                    ->get();
        foreach($templates as $t){
            $t->subjects()->detach();
            $t->delete();
        }

        $template = \App\Awardlisttemplate::create([
            'practicalexaminer_id' => $practicalexaminer_id,
            'exam_date' => $date,
            'practicalexam_id' => $r->practicalexam_id,
            'institute_id' => $r->institute_id,
            'approvedprogramme_id' => $r->approvedprogramme_id,
            'term' => $term,
            'downloaded_at' => $downloadTime
        ]);
        
        
        $approvedprogramme = \App\Approvedprogramme::find($r->approvedprogramme_id);
       // $practicalexam  = \App\Practicalexam::find($r->practicalexam_id);
        $subjects = \App\Subject::where('syear',$term)
                    ->where('subjecttype_id',2)
                    ->where('programme_id',$approvedprogramme->programme_id)
                    ->get();
        
        foreach($subjects as $subject){
            if($r->has('chk_'.$subject->id)){
                $template->subjects()->attach($subject->id);
                Session::put($subject->scode,'yes');
            }
        }   

        $subject_ids =  $template->subjects()->pluck('id');
        $candidate_ids = \App\Newapplication::whereHas('newapplicant', function($q) use($r){
                    $q->where('approvedprogramme_id',$r->approvedprogramme_id);
                })->whereIn('subject_id',$subject_ids)
                ->pluck('candidate_id')->unique()->toArray();
        $candidates = \App\Candidate::whereIn('id',$candidate_ids)->get();
        if($candidates->count()==0){
            $template->subjects()->detach();
            $template->delete();
            Session::flash('error','No Applications found');
            $practicalexams = \App\Practicalexam::where('practicalexaminer_id',$practicalexaminer_id)->orderBy('institute_id')->get();
            return redirect('practicalexam/home');
        }
        return view('practicalexaminer.awardlisttemplate.template',compact(
            'approvedprogramme',
            'term',
            'template',
            'candidates',
            'practicalexaminer'
        ));
    }
    public function show($id,Request $r){
        
        $subject_id = $r->subject_id;
        $template = \App\Awardlisttemplate::find($id);
        $ap = \App\Approvedprogramme::find($template->approvedprogramme_id);
        $applications = \App\Newapplication::whereHas('newapplicant',function($q) use ($template){
            $q->where('approvedprogramme_id',$template->approvedprogramme_id);
        })->where('subject_id',$subject_id)
        ->get();
        $subject = \App\Subject::find($subject_id);
        return view('practicalexaminer.awardlisttemplate.show',compact('template','applications','ap','subject'));
    }
    public function update($id,Request $request){
    
        $file = $request->marksheet;
        if(!is_file($file)){
            Session::flash('error','Plese choose a file');
            return back();
        }
        $datetime = \Carbon\Carbon::now()->toDateTimeString();
        
        $fname = $id.'_'.$datetime;
        $destination = public_path()."/files/externalpractical/".$fname;
        try{
            move_uploaded_file( $file, $destination);
        }catch(Exception $e){
            Session::flash('error','Upload Failed!');
            return back();
        }
        $template= \App\Awardlisttemplate::find($id);
        $template->marksheet_uploaded_at = $datetime;
        $template->marksheet = $fname;
        $template->save();
        Session::flash('messages','File Uploaded');
        return back();
    }
}
