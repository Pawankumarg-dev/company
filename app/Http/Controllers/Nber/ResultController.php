<?php

namespace App\Http\Controllers\Nber;

use App\Application;
use App\Approvedprogramme;
use App\Candidate;
use App\Candidateexamresultdate;
use App\Exam;
use App\Exambatch;
use App\Mark;
use App\Examresultdate;
use App\Withheld;
use Carbon\Carbon;
use App\Subject;
use App\Programme;
use App\Nberstaff;
use App\Institute;
use Auth;
use App\Currentapplicant;
use App\Currentapplication;

use App\Slno;
use Session;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index(Request $r) {
      //  $exams = Exam::orderBy('date', 'desc')->get();

        //return view('nber.examresults.index', compact('exams'));
        $nber_id = Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        $courses  = Programme::where('nber_id',$nber_id)->get();
        if($r->has('attendance')){
            $attendance = $r->attendance;
        }else{
            $attendance= 0;
        }
        return view('nber.missingresults.index',compact('courses','attendance'));
    }

    public function deleteca($aid){
        Session::put('messages','Not available');
        return back();
        $ca = Currentapplication::find($aid);
        if($ca->subject->syear == 1){
            $ca->delete();
            Session::put('messages','Deleted');
            $cuapp = Currentapplicant::find($ca->currentapplicant_id);
            $cuapp->mark_changed = 1;
            $fyp = $cuapp->first_year_pappers;
            $fyp = $fyp -1;
            $cuapp->first_year_pappers = $fyp;
            $cuapp->save();
        }else{
            Session::put('messages','Second year paper cannot be deleted');
        }
        return back();
    }

    public function verify($aid){
        Session::put('messages','Not available');
//        return back();
        $ca =Currentapplicant::find($aid);
        $ca->incomplete = 0;
        $ca->modify_mark = 0;
        //$ca->duplicate_entry = 0;
        $ca->save();
        return back();
    }
    public function listinstitutes($pid,Request $r){
        $attendance = 0;
        if($r->has('attendance')){
            $attendance = $r->attendance;
        }
        if($attendance==1){
            $apids = Currentapplicant::where('class_room_attendnace_missing',1)->whereHas('approvedprogramme',function($q) use($pid){
                $q->where('programme_id',$pid);
            })->pluck('approvedprogramme_id')->toArray();
        }else{
            $apids = Currentapplicant::where('modify_mark',1)->whereHas('approvedprogramme',function($q) use($pid){
                $q->where('programme_id',$pid);
            })->pluck('approvedprogramme_id')->toArray();
        }
        $institutes = Institute::whereHas('approvedprogrammes', function ($q) use ($apids) {
            $q->whereIn('id', $apids);
         })->get();
         $p = Programme::find($pid);
         return view('nber.missingresults.institutes',compact('institutes','p','attendance'));
    }

    public function showentries($pid,$cid){
       /* $approvedprogrammes = Approvedprogramme::where('programme_id',$pid)->where('institute_id',$iid)->pluck('id')->toArray();
        $currentapplicants = Currentapplicant::where('incomplete',1)->whereHas('approvedprogramme',function($q) use ($approvedprogrammes){
            $q->whereIn('id',$approvedprogrammes);
        })->pluck('candidate_id')->toArray();
        $currentapplications = Currentapplication::whereIn('candidate_id',$currentapplicants)->paginate(50); */
        $currentapplications = Currentapplication::where('candidate_id',$cid)->paginate(50);
        $applications = Application::where('candidate_id',$cid)->paginate(50);
        
        $candidate = Candidate::find($cid);
        $iid  = $candidate->approvedprogramme->institute_id;
        $p = Programme::find($pid);
        $i = Institute::find($iid);
        return view('nber.missingresults.entries',compact('currentapplications','applications','candidate','p','i'));
    }

    public function classroomattendance(Request $r){
        $rules = [
            "theory" => "required|numeric|min:0|max:100",
            "practical" => "required|numeric|min:0|max:100",
        ];

        $messages = [
            "theory.required" => "Please enter Theory Attendnace",
            "practical.required" => "Please enter Practical Attendnace"
        ];

        $validator = Validator($r->all(), $rules, $messages);
        $attendance = \App\Attendance::where('exam_id',22)->where('candidate_id',$r->cid)->first();
        if(!is_null($attendance)){
            $attendance->attendance_t = $r->theory;
            $attendance->attendance_p = $r->practical;
            $attendance->save();
        }else{
            $attendance = \App\Attendance::create([
                'exam_id' => 22,
                'attendance_t' => $r->theory,
                'attendance_p' => $r->practical,
                'candidate_id' => $r->cid,
                'document_t' => '',
                'document_p' => '',
                'exemption' => ''
            ]);
        }
        $ca = Currentapplicant::where('candidate_id',$r->cid)->first();
        if($attendance->attendance_t > 74.99 && $attendance->attendance_p > 74.99){
            $ca->attendance = 1;
            $ca->incomplete = 1;    
        }else{
            $ca->attendance = 0;
        }
        
        $ca->save();
        Session::put('messages','Updated');
        //return 'complete';
        return redirect('/nber/publishresult/'.$ca->candidate->approvedprogramme->programme_id.'/'.$ca->candidate->approvedprogramme->institute_id.'/studentlist?attendance=1');

    }
    public function studentlist($pid,$iid,Request $r){
        $attendance = 0;
        if($r->has('attendance')){
            $attendance = $r->attendance;
        }
        $approvedprogrammes = Approvedprogramme::where('programme_id',$pid)->where('institute_id',$iid)->pluck('id')->toArray();
        if($attendance==1){
        $currentapplicants = Currentapplicant::where('class_room_attendnace_missing',1)->whereHas('approvedprogramme',function($q) use ($approvedprogrammes){
            $q->whereIn('id',$approvedprogrammes);
        })->paginate(100);
        }else{
            $currentapplicants = Currentapplicant::where('modify_mark',1)->whereHas('approvedprogramme',function($q) use ($approvedprogrammes){
                $q->whereIn('id',$approvedprogrammes);
            })->paginate(100);
        }
        $p = Programme::find($pid);
        $i = Institute::find($iid);
        return view('nber.missingresults.studentlist',compact('currentapplicants','p','i','attendance'));
    }
    

  

  


    public function generatemsc($cid,Request $r){
        //Session::put('messages','Not available');
        //return back();
        $currentapplicant = Currentapplicant::where('candidate_id',$cid)->first();
        if($currentapplicant->withheld == 1){
            Session::put('messages','Result Withheld');
            return back();
        }
        $currentapplications = Currentapplication::where('candidate_id',$cid)->get();
        $publish = 1;
        $passed_subjects_term_one = 0;
        $passed_subjects_term_two = 0;
        $first_year_total = 0;
        $second_year_total = 0;
        $first_year_total = Currentapplication::where('candidate_id',$cid)->whereHas('subject',function($q){
            $q->where('syear',1);
        })->sum('internal_mark') 
        + 
        Currentapplication::where('candidate_id',$cid)->whereHas('subject',function($q){
            $q->where('syear',1);
        })->sum('external_mark') 
        +
        Currentapplication::where('candidate_id',$cid)->whereHas('subject',function($q){
            $q->where('syear',1);
        })->sum('grace') 
        ;

        $second_year_total = Currentapplication::where('candidate_id',$cid)->whereHas('subject',function($q){
            $q->where('syear',2);
        })->sum('internal_mark') 
        + 
        Currentapplication::where('candidate_id',$cid)->whereHas('subject',function($q){
            $q->where('syear',2);
        })->sum('external_mark') 
        +   
        Currentapplication::where('candidate_id',$cid)->whereHas('subject',function($q){
            $q->where('syear',2);
        })->sum('grace');
       

        // return $second_year_total;

        if($currentapplicant->attendance == 1){
            foreach($currentapplications as $ca){
                $external_mark = $ca->external_mark + $ca->grace;
                if(
                    ($ca->internalattendance_id == 1 || $ca->subject->is_internal == 0) 
                    && 
                    ($ca->internal_mark >= $ca->subject->imin_marks ||  $ca->subject->is_internal == 0 )
                    &&
                    ($ca->externalattendance_id == 1 || $ca->subject->is_external == 0) 
                    &&
                    ($external_mark >= $ca->subject->emin_marks ||  $ca->subject->is_external == 0 )
                    && 
                    (!is_null($ca->external_mark) ||  $ca->subject->is_external == 0)
                    &&
                    (!is_null($ca->internal_mark) ||  $ca->subject->is_internal == 0)
                ){
                    $ca->result_id = 1;
                    $ca->reevaluation_result_id = 1;
                    if($ca->subject->syear==1){
                        $passed_subjects_term_one ++; 
                    }
                    if($ca->subject->syear==2){
                        $passed_subjects_term_two ++; 
                    }
                }else{
                    $ca->result_id = 0;
                    $ca->reevaluation_result_id = 0;
                }
                if($ca->internalattendance_id == 0 && $ca->subject->is_internal == 1){
                    $publish = 0;
                }
                if($ca->externalattendance_id == 0 && $ca->subject->is_external == 1){
                    $publish = 0;
                }
               /* if($ca->subject->syear==1){
                    if($ca->subject->is_external == 1){
                        $first_year_total += $ca->external_mark;
                    }
                    if($ca->subject->is_internal == 1){
                        $first_year_total += $ca->internal_mark;
                    }
                }
                if($ca->subject->syear==2){
                    if($ca->subject->is_external == 1){
                        $second_year_total += $ca->external_mark;
                    }
                    if($ca->subject->is_internal == 1){
                        $second_year_total += $ca->internal_mark;
                    }
                } */
                $ca->save();
                
            }
        }else{
            Session::put('messages','Attendance is less than 75%');
            return back();
        }
        if($publish == 0){
            Session::put('messages','Please complete entering exam attendnace and marks for all the subject');
            return back();
        }
        $nber_id = Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        $candidate = Candidate::find($currentapplicant->candidate_id);
        if($currentapplicant->approvedprogramme->academicyear_id == 10 && $currentapplicant->approvedprogramme->programme->numberofterms == 1){
            if($passed_subjects_term_one == $currentapplicant->papers_required_to_pass_this_year){
                $currentapplicant->term_one_result_id = 1;
                $currentapplicant->final_result = 1;
                $candidate->coursecompleted_status = 1;
                $currentapplicant->result_percentage = round(($first_year_total / $currentapplicant->approvedprogramme->programme->first_year_max) * 100,2);
                if($currentapplicant->slno_certificate < 1){
                    $slno = Slno::where('nber_id', $nber_id)->where('key_val','slno_certificate')->first();
                    $slno_certificate = $slno->slno;
                    $slno_certificate ++;
                    $slno->slno = $slno_certificate;
                    $slno->save();
                    $currentapplicant->slno_certificate = $slno_certificate;
                }
                $currentapplicant->certificate_date = date("Y-m-d");
                $currentapplicant->save();
                $job = (new \App\Jobs\GenerateCertificate($currentapplicant->candidate_id))->onQueue('missingcertificate');
                $this->dispatch($job);
            }else{
                $currentapplicant->term_one_result_id = 0;
                $currentapplicant->final_result = 0;
                $candidate->coursecompleted_status = 0;
            }
            if($currentapplicant->sl_no_marksheet_term_one < 1){
                $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_one')->first();
                $sl_no_marksheet_term_one = $slno->slno;
                $sl_no_marksheet_term_one ++;
                $currentapplicant->sl_no_marksheet_term_one = $sl_no_marksheet_term_one;
                $slno->slno = $sl_no_marksheet_term_one;
                $slno->save();
            }
            $currentapplicant->first_year_total = $first_year_total;
            $currentapplicant->marksheetissuded_date = date("Y-m-d");
            $currentapplicant->save();
            $candidate->save();
            $job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,1))->onQueue('missingms');
            $this->dispatch($job);
            Session::put('messages','Generated');
        }

        if($currentapplicant->approvedprogramme->academicyear_id == 10 && $currentapplicant->approvedprogramme->programme->numberofterms == 2){
            if($passed_subjects_term_one == $currentapplicant->papers_required_to_pass_this_year){
                $currentapplicant->term_one_result_id = 1;
                $currentapplicant->result_percentage = round(($first_year_total / $currentapplicant->approvedprogramme->programme->first_year_max) * 100,2);
            }else{
                $currentapplicant->term_one_result_id = 0;
            }
            $currentapplicant->final_result = 0;
            
            $currentapplicant->first_year_total = $first_year_total;
            if($currentapplicant->sl_no_marksheet_term_one < 1){
                $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_one')->first();
                $sl_no_marksheet_term_one = $slno->slno;
                $sl_no_marksheet_term_one ++;
                $currentapplicant->sl_no_marksheet_term_one = $sl_no_marksheet_term_one;
                $slno->slno = $sl_no_marksheet_term_one;
                $slno->save();
            }
            $currentapplicant->marksheetissuded_date = date("Y-m-d");
            $currentapplicant->save();
            $job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,1))->onQueue('missingms');
            $this->dispatch($job);
            Session::put('messages','Generated');
        }
        if($currentapplicant->approvedprogramme->academicyear_id == 9 && $currentapplicant->approvedprogramme->programme->numberofterms == 2){
            $papers_passed_last_year = Application::where('candidate_id',$cid)->where('result_id',1)->count();
            $papers_passed_last_year_marks = Application::where('candidate_id',$cid)->where('result_id',1)->get();
            $previous_exam_total =  $papers_passed_last_year_marks->sum('external_mark') + $papers_passed_last_year_marks->sum('internal_mark') + $papers_passed_last_year_marks->sum('grace');
            /*foreach($papers_passed_last_year_marks as $pm){
                if($ca->subject->is_external == 1){
                    $previous_exam_total = $previous_exam_total + $pm->external_mark;
                }
                if($ca->subject->is_internal == 1){
                    $previous_exam_total = $previous_exam_total + $pm->internal_mark;
                }
            }
            return $previous_exam_total; */
            if($passed_subjects_term_one + $papers_passed_last_year == $currentapplicant->papers_required_to_pass_previous_year){
                $currentapplicant->term_one_result_id = 1;
            }else{
                $currentapplicant->term_one_result_id = 0;
                $currentapplicant->final_result = 0;
                $candidate->coursecompleted_status = 0;
            }
            if($passed_subjects_term_two == $currentapplicant->papers_required_to_pass_this_year){
                $currentapplicant->term_two_result_id = 1;
            }else{
                $currentapplicant->term_two_result_id = 0;
                $currentapplicant->final_result = 0;
                $candidate->coursecompleted_status = 0;
            }
            $currentapplicant->save();
            //return $first_year_total . ',' . $second_year_total . ',' . $previous_exam_total;
            if($currentapplicant->term_two_result_id == 1 && $currentapplicant->term_one_result_id == 1){
                $currentapplicant->final_result = 1;
                $candidate->coursecompleted_status = 1;
                $currentapplicant->result_percentage = round((($first_year_total + $second_year_total + $previous_exam_total) / ($currentapplicant->approvedprogramme->programme->first_year_max + $currentapplicant->approvedprogramme->programme->second_year_max)) * 100,2);
                if($currentapplicant->slno_certificate < 1){
                    $slno = Slno::where('nber_id', $nber_id)->where('key_val','slno_certificate')->first();
                    $slno_certificate = $slno->slno;
                    $slno_certificate ++;
                    $slno->slno = $slno_certificate;
                    $slno->save();
                    $currentapplicant->slno_certificate = $slno_certificate;
                }
                $currentapplicant->certificate_date = date("Y-m-d");
                $currentapplicant->save();
                $candidate->save();
                $job = (new \App\Jobs\GenerateCertificate($currentapplicant->candidate_id))->onQueue('missingcertificate');
                $this->dispatch($job);
            }
            if($currentapplicant->sl_no_marksheet_term_one < 1 && $currentapplicant->first_year_pappers > 0){
                $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_one')->first();
                $sl_no_marksheet_term_one = $slno->slno;
                $sl_no_marksheet_term_one ++;
                $currentapplicant->sl_no_marksheet_term_one = $sl_no_marksheet_term_one;
                $slno->slno = $sl_no_marksheet_term_one;
                $slno->save();
            }
            if($currentapplicant->sl_no_marksheet_term_two < 1){
                $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_two')->first();
                $sl_no_marksheet_term_two = $slno->slno;
                $sl_no_marksheet_term_two ++;
                $currentapplicant->sl_no_marksheet_term_two = $sl_no_marksheet_term_two;
                $slno->slno = $sl_no_marksheet_term_two;
                $slno->save();
            }
            $currentapplicant->first_year_total = $first_year_total;
            $currentapplicant->second_year_total = $second_year_total;
            $currentapplicant->marksheetissuded_date = date("Y-m-d");
            $currentapplicant->save();
            if($currentapplicant->first_year_pappers > 0){
                $job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,1))->onQueue('missingms');
                $this->dispatch($job);
            }


            $job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,2))->onQueue('missingms');
            $this->dispatch($job);
            Session::put('messages','Generated');
        }
        if(($currentapplicant->approvedprogramme->academicyear_id < 9 && $currentapplicant->approvedprogramme->programme->numberofterms == 2) or ($currentapplicant->approvedprogramme->academicyear_id < 10 && $currentapplicant->approvedprogramme->programme->numberofterms == 1)){
        //    $papers_passed_last_year = Application::where('candidate_id',$cid)->where('result_id',1)->count();
         //   $papers_passed_last_year_marks = Application::where('candidate_id',$cid)->where('result_id',1)->get();
         //   $previous_exam_total =  $papers_passed_last_year_marks->sum('external_mark') + $papers_passed_last_year_marks->sum('internal_mark');
            /*foreach($papers_passed_last_year_marks as $pm){
                if($ca->subject->is_external == 1){
                    $previous_exam_total = $previous_exam_total + $pm->external_mark;
                }
                if($ca->subject->is_internal == 1){
                    $previous_exam_total = $previous_exam_total + $pm->internal_mark;
                }
            }
            return $previous_exam_total; */
            if($r->has('percentage') && $r->percentage > 45){
                $currentapplicant->term_one_result_id = 1;
                if($currentapplicant->approvedprogramme->programme->numberofterms==2){
                    $currentapplicant->term_two_result_id = 1;
                }
            }else{
                if($r->first_year){
                    $currentapplicant->term_one_result_id = 1;
                }else{
                    $currentapplicant->term_one_result_id = 0;
                }   
                if($r->second_year){
                    $currentapplicant->term_two_result_id = 1;
                }else{
                    $currentapplicant->term_two_result_id = 0;
                }   
            }
            $currentapplicant->marksheetissuded_date = date("Y-m-d");
            $currentapplicant->save();
           /* $first_year_total = Currentapplication::where('candidate_id',$cid)->where('result_id',1)->whereHas('subject',function($q){
                $q->where('syear',1);
            })->sum('internal_mark') 
            + 
            Currentapplication::where('candidate_id',$cid)->where('result_id',1)->whereHas('subject',function($q){
                $q->where('syear',1);
            })->sum('external_mark') ;

            $second_year_total = Currentapplication::where('candidate_id',$cid)->where('result_id',1)->whereHas('subject',function($q){
                $q->where('syear',2);
            })->sum('internal_mark') 
            + 
            Currentapplication::where('candidate_id',$cid)->where('result_id',1)->whereHas('subject',function($q){
                $q->where('syear',2);
            })->sum('external_mark') ;*/

            if($currentapplicant->sl_no_marksheet_term_one < 1 && $currentapplicant->first_year_pappers > 0){
                $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_one')->first();
                $sl_no_marksheet_term_one = $slno->slno;
                $sl_no_marksheet_term_one ++;
                $currentapplicant->sl_no_marksheet_term_one = $sl_no_marksheet_term_one;
                $currentapplicant->first_year_total = $first_year_total;
                $slno->slno = $sl_no_marksheet_term_one;
                $slno->save();
            }
            if($currentapplicant->sl_no_marksheet_term_two < 1 && $currentapplicant->second_year_pappers > 0){
                $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_two')->first();
                $sl_no_marksheet_term_two = $slno->slno;
                $sl_no_marksheet_term_two ++;
                $currentapplicant->sl_no_marksheet_term_two = $sl_no_marksheet_term_two;
                $currentapplicant->second_year_total = $second_year_total;
                $slno->slno = $sl_no_marksheet_term_two;
                $slno->save();
            }
            
            $currentapplicant->save();
            
            if(($currentapplicant->term_two_result_id == 1 && $currentapplicant->term_one_result_id == 1 && $currentapplicant->approvedprogramme->programme->numberofterms == 2)
                or($currentapplicant->term_one_result_id == 1 && $currentapplicant->approvedprogramme->programme->numberofterms == 1)
            ){
                $currentapplicant->final_result = 1;
                $candidate->coursecompleted_status = 1;
                $currentapplicant->result_percentage = $r->percentage;
                if($currentapplicant->slno_certificate < 1){
                    $slno = Slno::where('nber_id', $nber_id)->where('key_val','slno_certificate')->first();
                    $slno_certificate = $slno->slno;
                    $slno_certificate ++;
                    $slno->slno = $slno_certificate;
                    $slno->save();
                    $currentapplicant->slno_certificate = $slno_certificate;
                }
                $currentapplicant->certificate_date = date("Y-m-d");
                $currentapplicant->save();
                $job = (new \App\Jobs\GenerateCertificate($currentapplicant->candidate_id))->onQueue('missingcertificate');
                $this->dispatch($job);
            }else{
                $currentapplicant->final_result = 0;
                $candidate->coursecompleted_status = 0;
                $currentapplicant->certificate_date = null;
                $currentapplicant->slno_certificate = null;
                $currentapplicant->save();
            }
            if($currentapplicant->first_year_pappers > 0){
                $job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,1))->onQueue('missingms');
                $this->dispatch($job);
            }
            if($currentapplicant->second_year_pappers > 0){
                $job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,2))->onQueue('missingms');
                $this->dispatch($job);
            }
            $candidate->save();
            Session::put('messages','Generated'); 
        }

        return back();
    }

    public function savemissingmarks(Request $r){
        if($r->has('internal_mark')){
            foreach($r->internal_mark as $aid => $value){
                $ca = Currentapplication::find($aid);
                $cuapp = Currentapplicant::find($ca->currentapplicant_id);
                if($r->internalattendance_id[$aid]==1 && $value !=''){
                    $ca->internal_mark = $value;
                }
                if($r->internalattendance_id[$aid]==0 && $value !=''){
                    Session::put('message','Attendance needs to be marked to enter marks');
                }
                $ca->internalattendance_id  = $r->internalattendance_id[$aid];
                $cuapp->mark_changed = 1;
                $cuapp->save();
                $ca->save();
            }
        }
        if($r->has('external_mark')){
            foreach($r->external_mark as $aid => $value){
                $ca = Currentapplication::find($aid);
                $cuapp = Currentapplicant::find($ca->currentapplicant_id);
                if($r->externalattendance_id[$aid]==1 && $value !=''){
                    $ca->external_mark = $value;
                }
                if($r->externalattendance_id[$aid]==0 && $value !=''){
                    Session::put('message','Attendance needs to be marked to enter marks');
                }
                $ca->externalattendance_id  = $r->externalattendance_id[$aid];
                $cuapp->mark_changed = 1;
                $cuapp->save();
                $ca->save();
            }
        }

        return back();
    }
    public function form($exam_id) {
        $exam = Exam::where('id', $exam_id)->first();

        return view('nber.examresults.form', compact('exam'));
    }

    public function checkresult(Request $request) {
        $rules = [
            "enrolmentno" => "required",
        ];

        $messages = [
            "enrolmentno.required" => "Please enter the Student's Enrolment Number"
        ];

        $validator = Validator($request->all(), $rules, $messages);

        $candidate = Candidate::where('enrolmentno', $request->enrolmentno)->first();
        $validator->after(function ($validator) use ($request, $candidate) {
            if ($candidate) {
                $application = Application::where('exam_id', $request->exam_id)->where('candidate_id', $candidate->id)->first();

              if (is_null($application)) {
                    $validator->errors()->add('enrolmentno', 'No Exam Result Published');
                }
            }
        });

        $this->validateWith($validator);

        return redirect()->route('/nber/examresult/viewresult', ["exam_id" => $request->exam_id, "candidate_id" => $candidate->id]);

    }

    public function showCandidateList($eid) {
        $exam = Exam::find($eid);

        if($exam) {
            $candidates = Candidate::whereHas('applications', function ($query) use($exam){
                $query->where('exam_id', $exam->id)->groupBy('candidate_id');
            })->get(['enrolmentno', 'name']);


            /*
             $candidates = Candidate::join('applications', 'applications.candidate_id', '=', 'candidates.id')
                ->join('approvedprogrammes', 'approvedprogrammes.id', '=', 'applications.approvedprogramme_id')
                ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
                ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
                ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
                ->where('applications.exam_id', $exam->id)
                ->whereNotNull('candidates.enrolmentno')
                ->groupBy('applications.candidate_id')
                ->orderBy('institutes.code')
                ->orderBy('programmes.common_code')
                ->orderBy('academicyears.year')
                ->orderBy('candidates.enrolmentno')
                ->get(['candidates.enrolmentno', 'candidates.name', 'candidates.approvedprogramme_id']);


             * $candidates = Candidate::with(array('applications' => function($query) use($exam){
                $query->where('exam_id', $exam->id)->groupBy('candidate_id');
            }))->get(['candidates.enrolmentno', 'candidates.name']);
              $candidates = Candidate::whereHas('applications', function ($query) use($exam){
                $query->where('exam_id', $exam->id)->groupBy('candidate_id');
            })->get(['enrolmentno', 'name']);

             */
            echo $candidates;

            //return view('nber.examresults.show_candidate_list', compact('exam'));
        }
        else {
            unset($exam);
            return redirect('nber/exams');
        }
    }

    public function viewresult($exam_id, $candidate_id) {
        $exam = Exam::where('id', $exam_id)->first();
        $candidate = Candidate::where('id', $candidate_id)->first();

        $applications = Application::select('applications.*')
            ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
            ->join('subjecttypes', 'subjecttypes.id', '=', 'subjects.subjecttype_id')
            ->where('applications.exam_id', $exam->id)
            ->where('applications.candidate_id', $candidate->id)
            ->where('applications.publish_status', '1')
            ->orderBy('subjects.syear')->orderBy('subjecttypes.id')->orderBy('sortorder')->get();

        $application_ids = $applications->pluck('id')->toArray();

        $marks = Mark::whereIn('application_id', $application_ids)->get();

        $candidateexamresultdate = Candidateexamresultdate::where('exam_id', $exam->id)
            ->where('candidate_id', $candidate->id)
            ->first();

        $withheld = Withheld::where('exam_id', $exam->id)->where('candidate_id', $candidate->id)->where('status', '1')->count();
        $withheldStatusCount = $applications->where('withheld_status', 1)->count();

        if ($exam->id < 20) {
            return view('nber.examresults.result', compact('exam', 'applications', 'candidate', 'marks', 'candidateexamresultdate', 'withheld', 'withheldStatusCount'));
        } else {
            return view('nber.examresults.january2023_result', compact('exam', 'applications', 'candidate', 'marks', 'candidateexamresultdate', 'withheld', 'withheldStatusCount'));
        }
    }

    public function markspdf($exam_id, $programme_id, $institute_id, $approvedprogramme_id){
        // $exam - Exams
        $exam = Exam::find($exam_id);

        // $ap - Approvedprogrammes
        $ap = Approvedprogramme::find($approvedprogramme_id);

        // $app - Applications
        $app = Application::where('exam_id', $exam->id)->where('approvedprogramme_id', $ap->id)->get();

        //$cid = Candidate::candidate



    }

}
