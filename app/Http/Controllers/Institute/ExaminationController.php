<?php

namespace App\Http\Controllers\Institute;

use App\Academicyear;
use App\Approvedprogramme;
use App\Candidate;
use App\City;
use App\Exam;
use App\Externalexamcenter;
use App\Gender;
use App\Incidentalfee;
use App\Incidentalpayment;
use App\Institute;
use App\Practicalexam;
use App\Practicalexamfeedetail;
use App\Practicalexaminer;
use App\State;
use App\Subject;
use App\Title;
use Illuminate\Http\Request;

use App\Markentry;

use App\Exambatch;
use App\Examresultdate;
use App\Internalmark;
use App\Mark;
use App\Withheld;

use App\Application;
use App\Language;
use App\Programme;
use App\Examtimetable;
use App\Examcenter;
use App\Http\Requests;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Session;
use Illuminate\Support\Facades\DB;

use App\Currentapplicant;

use App\Currentapplication;

class ExaminationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function index() {
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        if(is_null($institute)) {
            unset($institute);
            return redirect('/');
        }
        else {
            $exams = Exam::orderBy('date', 'Desc')->get();

            return view('institute.examinations.index', compact('institute', 'exams'));
        }
    }

    public function showlists($e_id) {
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        if(is_null($institute)) {
            unset($institute);
            return redirect('/');
        }
        else {
            $exam = Exam::find($e_id);

            return view('institute.examinations.showlist', compact('institute', 'exam'));
        }
    }

    public function markentry(Request $r){
        return 'Closed';
        $apid = $r->apid;
        $institute_id = Institute::where('user_id', Auth::user()->id)->first()->id;
        $ap  = Approvedprogramme::find($apid);
        if($ap->institute_id == $institute_id){
        $pid = $ap->programme_id;
        $subjects  = Subject::where('programme_id',$pid)->orderBy('syear')->orderBy('subjecttype_id')->orderBy('sortorder')->get();
        $markentries = Markentry::where('exam_id',22)->where('approvedprogramme_id',$apid)->first();
        return view('institute.markentry.index',compact('subjects','ap','markentries'));
        }else{
            return redirect('/');
        }
    }

    public function internal($apid, $sid){
        return 'Closed';

        $institute_id = Institute::where('user_id', Auth::user()->id)->first()->id;
        $approvedprogramme  = Approvedprogramme::find($apid);
        if($approvedprogramme->institute_id == $institute_id){
            $applications = Currentapplication::where('approvedprogramme_id',$apid)->where('subject_id',$sid);
            if($applications->count()> 0){
                $applications = $applications->get();
                return view('institute.markentry.internal',compact('applications','approvedprogramme'));
            }else{
                return view('institute.markentry.noapplications');
            }
        }else{
            return redirect('/');
        }
    }
    public function saveinternal(Request $r){
        return 'Closed';

        $institute_id = Institute::where('user_id', Auth::user()->id)->first()->id;
        $approvedprogramme  = Approvedprogramme::find($r->approvedprogramme_id);
        $subject = Subject::find($r->subject_id);
        $message = '';
        if($approvedprogramme->institute_id == $institute_id){
            if($approvedprogramme->programme_id == $subject->programme_id){
                $applications = Currentapplication::where('approvedprogramme_id',$r->approvedprogramme_id)->where('subject_id',$r->subject_id)->get();
                foreach($applications as $application){
                    $attendance = 'attendence_'.$application->id;
                    $internalfield = 'internal_'.$application->id;
                    $application->internalattendance_id = $r->$attendance;
                    if($r->$attendance < 1){
                        $message = 'Kindly Mark Attendance for all the Students';
                    }
                    if($r->$internalfield =='' && $r->$attendance ==1){
                        $message = 'Please enter marks for all the student present';
                    }else{
                        $application->internal_mark = $r->$internalfield; 
                    }
                    $application->save();
                }   
                if($message==''){
                    Session::put('messages','Updated');
                }else{
                    Session::put('error',$message);
                }
                return back();
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }

    }

    public function uploadawardlist(Request $request){
        return 'Closed';

        $type = $request->type;
        $file = $request->$type;
        $apid = $request->approvedprogramme_id;
        if ($request->hasFile($type)){
            $filename = '22_'.$apid.'_'.$type.'.pdf';
            move_uploaded_file($file,"files/markfiles/".$filename);
            $markentries = Markentry::where('exam_id',22)->where('approvedprogramme_id',$apid)->first();
            if(!is_null($markentries)){
                $markentries->$type = $filename;
                $markentries->save();
            }else{
                Markentry::create([
                    'exam_id' => 22,
                    'approvedprogramme_id' => $apid,
                    $type => $filename
                ]);
            }
            Session::put('messages','Updated');
            return back();
        }else{
            Session::put('error','Could not upload file. Please select pdf only');
            return back();
        }
    }
    public function external($apid, $sid){
        return 'Closed';

        $institute_id = Institute::where('user_id', Auth::user()->id)->first()->id;
        $approvedprogramme  = Approvedprogramme::find($apid);
        $subject = Subject::find($sid);
        if($subject->subjecttype_id == 2){
            if($approvedprogramme->institute_id == $institute_id){
                $applications = Currentapplication::where('approvedprogramme_id',$apid)->where('subject_id',$sid);
                if($applications->count()> 0){
                    $applications = $applications->get();
                    return view('institute.markentry.external',compact('applications','approvedprogramme'));
                }else{
                    return view('institute.markentry.noapplications');
                }
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
        
    }
    public function saveexternal(Request $r){
        return 'Closed';

        $institute_id = Institute::where('user_id', Auth::user()->id)->first()->id;
        $approvedprogramme  = Approvedprogramme::find($r->approvedprogramme_id);
        $subject = Subject::find($r->subject_id);
        $message = '';
        if($approvedprogramme->institute_id == $institute_id && $subject->subjecttype_id == 2){
            if($approvedprogramme->programme_id == $subject->programme_id){
                $applications = Currentapplication::where('approvedprogramme_id',$r->approvedprogramme_id)->where('subject_id',$r->subject_id)->get();
                foreach($applications as $application){
                    $attendance = 'attendence_'.$application->id;
                    $externalfield = 'external_'.$application->id;
                    $application->externalattendance_id = $r->$attendance;
                    if($r->$attendance < 1){
                        $message = 'Kindly Mark Attendance for all the Students';
                    }
                    if($r->$externalfield =='' && $r->$attendance ==1){
                        $message = 'Please enter marks for all the student present';
                    }else{
                        $application->external_mark = $r->$externalfield; 
                    }
                    $application->save();
                }   
                if($message==''){
                    Session::put('messages','Updated');
                }else{
                    Session::put('error',$message);
                }
                return back();
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }

    }

    public function showApplications($e_id) {
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        

        if(is_null($institute)) {
            unset($institute);
            return redirect('/');
        }
        else {
           $exam = Exam::find($e_id);

           // if(is_null($exam)) {
           //     return redirect('/');
           // }
           // else {
               // $exambatches = Exambatch::where("exam_id", $exam->id)->get();
               // $nber_id = 1;
               // $allprogramme_ids = Exambatch::where("exam_id", $exam->id)->pluck("programme_id")->unique()->toArray();
              //  $programme_ids = \App\Programme::whereIn('id',$allprogramme_ids)->pluck('id')->toArray();
            //    $academicyear_ids = Exambatch::where("exam_id", $exam->id)->pluck("academicyear_id")->unique()->toArray();
                $current_ay_id = Academicyear::where('current',1)->first()->id;
               //$current_ay_id = 11;
              /*  $approvedprogrammes = Approvedprogramme::select('approvedprogrammes.*')
                    ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
                    ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
                    ->where('approvedprogrammes.institute_id', $institute->id)
                //    ->whereIn('programmes.id', $programme_ids)
                //    ->whereIn('academicyears.id', $academicyear_ids)
                    ->where('academicyear_id','>',7)
                    ->where('academicyear_id','!=',$current_ay_id)
                    ->where('status_id', '2')
                    ->orderBy('programmes.sortorder')
                    ->orderBy('academicyears.year')
                    ->get(); */
                    $approvedprogrammes = Approvedprogramme::where('institute_id',$institute->id)
                            ->where('academicyear_id','<=',$current_ay_id)
                            ->where('academicyear_id','>',$current_ay_id - 4)
                            ->orderBy('academicyear_id','desc')->get();
                  //  $institute = Institute::where('user_id',Auth::user()->id)->first();
                   // $approvedprogrammes= Approvedprogramme::where('institute_id',$institute->id)->where('academicyear_id','>',8)->where('academicyear_id','!=',11)->get();
               // return $approvedprogrammes;
                return view('institute.examapplications.show_applications', compact('approvedprogrammes','exam','current_ay_id'));
         //   }
/*
            $approvedprogrammes = Approvedprogramme::select('approvedprogrammes.*')
                ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
                ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
                ->where('institute_id', $institute->id)
                ->orderBy('programmes.sortorder')
                ->orderBy('academicyears.year')
                ->get();

            $exambatches = Exambatch::where('exam_id', $exam->id)->get();
            $erds = Examresultdate::where('exam_id', $exam->id)->get();
*/

            //return view('institute.examinations.examapplications', compact('institute', 'exam', 'approvedprogrammes', 'exambatches', 'erds'));
            //return view('institute.examinations.showapplications', compact('institute', 'exam', 'approvedprogrammes', 'exambatches', 'erds'));
        }
    }

    public function examapplicationforms($eid, $apid) {
        return 'Closed';

        $ap = Approvedprogramme::find($apid);
        if($ap) {
            if($ap->institute_id == Institute::where('user_id',Auth::user()->id)->first()->id) {
                $withheld_candidateid = Withheld::where('status', '1')->distinct('candidate_id')->pluck('candidate_id')->toArray();
                $exam = Exam::find($eid);
                $candidates = Candidate::where('approvedprogramme_id',$ap->id)->whereNotNull('enrolmentno')
                    ->where('enrolmentno', '!=', '')->orderBy('enrolmentno')
                    ->whereNotIn('id', $withheld_candidateid)
                    ->get();
                $languages = Language::all();
                $exambatch = Exambatch::where('exam_id', $exam->id)->where('programme_id', $ap->programme_id)
                    ->where('academicyear_id', $ap->academicyear_id)->get();

                $linkopen_number = '1';
                $penalty = 'No';

                $allowapplication = 1;
                $errormessage = "";
                $ayid = Academicyear::where("year", "2019")->first()->id;
                $ap2019 = Approvedprogramme::where("institute_id", $ap->institute_id)->where("academicyear_id", $ayid)
                    ->where("programme_id", $ap->programme_id)
                    ->where("status_id", "2")->first();

                if(is_null($ap2019)) {
                    $allowapplication = 0;
                }
                else {
                    if($ap2019->enrolmentcandidatecount($ap2019->id) == 0) {
                        $allowapplication = 0;
                    }
                    else {
                        $incidentalfee = Incidentalfee::where("academicyear_id", $ayid)->where("programme_id", $ap->programme_id)->get();
                        $incidentalfee_ids = $incidentalfee->pluck("id")->toArray();

                        $incidentalcharges = Incidentalpayment::whereIn("incidentalfee_id", $incidentalfee_ids)->where("institute_id", $ap->institute_id)->get();

                        if(!is_null($incidentalcharges)) {
                            $firstterm = 0;

                            if($ap->programme->numberofterms == 1) {
                                foreach ($incidentalcharges as $incidentalcharge) {
                                    if($incidentalcharge->incidentalfee->term == 1) {
                                        if($incidentalcharge->status_id == 2) {
                                            $firstterm++;
                                        }
                                    }

                                    if($firstterm > 0) {
                                        $allowapplication = 0;
                                    }
                                    else {
                                        $errormessage = "Afflication fee payment Not Approved";
                                    }
                                }
                            }
                            else {
                                $secondterm = 0;
                                foreach ($incidentalcharges as $incidentalcharge) {
                                    if($incidentalcharge->incidentalfee->term == 1) {
                                        if($incidentalcharge->status_id == 2) {
                                            $firstterm++;
                                        }
                                    }
                                    if($incidentalcharge->incidentalfee->term == 2) {
                                        if($incidentalcharge->status_id == 2) {
                                            $secondterm++;
                                        }
                                    }

                                    if($firstterm > 0 && $secondterm > 0) {
                                        $allowapplication = 0;
                                    }
                                    else {
                                        $errormessage = "Affiliation fee Payment Not Approved";
                                    }
                                }
                            }
                        }
                        else {
                            $errormessage = "Affiliation fee Not Entered";
                        }
                    }
                }

                return view('institute.exam.index',compact('candidates','ap','languages','exam', 'linkopen_number', 'penalty', 'exambatch', 'allowapplication', 'errormessage'));
            }
            else {
                return redirect('/institute/examinations/applications/'.$eid);
            }
        }
        else {

        }
    }
    public function downloadMarksheets($cid){
        $candidate = Candidate::where('id',$cid)->with('currentapplicant')->first();
        $currentapplications = Currentapplication::where('candidate_id',$candidate->id)->get();
        if(Institute::where('user_id',Auth::user()->id)->first()->id == $candidate->approvedprogramme->institute_id){
            $applicant =  Currentapplicant::where('candidate_id',$cid)->first();
            return view('institute.examapplications.downloadmarksheetsandcertificates', compact('candidate','currentapplications'));
        }else{
            return back();
        }
    }
    public function showCandidateLists($eid, $apid) {
        $exam = Exam::find($eid);

        if(!is_null($exam)) {
            $approvedprogramme = Approvedprogramme::with('candidates')->find($apid);
          //  $candidates = Candidate::where('approvedprogramme_id', $approvedprogramme->id)
          //  ->whereNotNull('enrolmentno')
           // ->orderBy('enrolmentno')->get(['id', 'enrolmentno', 'name', 'approvedprogramme_id']);
           // $remarks = "NIL";
        return view('institute.examapplications.show_candidate_lists', compact('approvedprogramme','exam'));
    
     /*     if(!is_null($approvedprogramme)) {
                $exambatch_terms = Exambatch::where('exam_id', $exam->id)->where('programme_id', $approvedprogramme->programme_id)
                    ->where('academicyear_id', $approvedprogramme->academicyear_id)->pluck('term')->unique()->toArray();

                if(count($exambatch_terms) == 0) {
                    unset($exambatch_terms);

                    return redirect('/institute/examinations/applications/'.$exam->id);
                }
                else {
                    $incidentalcharge_required = "Yes";
                    $remarks = null;

                    $incidentalfees = Incidentalfee::where('programme_id', $approvedprogramme->programme_id)
                        ->where('academicyear_id', $approvedprogramme->academicyear_id)
                        ->whereIn('term', $exambatch_terms)->orderBy('term')->get();

                    if($incidentalfees->count() == 0) {
                        $incidentalcharge_required = "No";

                        $remarks = "NIL";
                    }
                    else {
                        foreach ($incidentalfees as $incidentalfee) {
                            if($incidentalfee->incidentalpayments()->where('institute_id', $approvedprogramme->institute_id)->where('status_id', 2)->count() == 0) {
                                if(!is_null($remarks))
                                    $remarks .= " & ";
                                $remarks .= $incidentalfee->term.' year - Affiliation fee is not approved';
                            }
                        }

                        if(is_null($remarks)) {
                            $pendingInstitutes = array();

                            if(in_array($approvedprogramme->institute->code, $pendingInstitutes)) {
                                $remarks = "Contact Accountant, NIEPMD-NBER";
                            }
                            
                            if(is_null($remarks)) {
                                // $allowInstitutes = array("HY01", "RJ25", "RJ26", "UP16", "UP90", "UP57", "CH06", "HY16");
                                $allowInstitutes = [$approvedprogramme->institute->code];
                                if(in_array($approvedprogramme->institute->code, $allowInstitutes)) {
                                    $remarks = "NIL";
                                }
                                else {
                                    $remarks = "";
                                }
                            }
                        }
                    }

                    $candidates = Candidate::where('approvedprogramme_id', $approvedprogramme->id)
                        ->whereNotNull('enrolmentno')->orderBy('enrolmentno')->get(['id', 'enrolmentno', 'name', 'approvedprogramme_id']);

                    return view('institute.examapplications.show_candidate_lists', compact('exam', 'approvedprogramme', 'candidates', 'remarks'));
                }
            }
            else {
                return redirect('/institute/examinations/applications/'.$exam->id);
            } */
        } 
        else {
            return redirect('/');
        }
    }

    public function viewCandidateApplication($eid, $apid, $cid) {
        return '';
        $candidate = Candidate::find($cid);
        
        return view('institute.examapplications.view_candidate_application', compact('candidate'));

        $exam = Exam::find($eid);

        if(!is_null($exam)) {
            $approvedprogramme = Approvedprogramme::find($apid);

            if(!is_null($approvedprogramme)) {
                $candidate = Candidate::find($cid);

                if(!is_null($candidate) || $candidate->approvedprogramme_id == $approvedprogramme->id) {
                    $exambatch_terms = Exambatch::where('exam_id', $exam->id)->where('programme_id', $approvedprogramme->programme_id)
                        ->where('academicyear_id', $approvedprogramme->academicyear_id)->pluck('term')->unique()->toArray();

                    if(count($exambatch_terms) == 0) {
                        unset($exambatch_terms);

                        return redirect('/institute/examinations/applications/'.$exam->id);
                    }
                    else {
                        $applications = $candidate->applications()->where('exam_id', $exam->id)->groupBy('subject_id')->get(['language_id', 'subject_id']);

                        $subject_ids = $applications->pluck('subject_id')->toArray();

                        $subjects = Subject::where('programme_id', $approvedprogramme->programme_id)
                            ->where('syllabus_type', 'New')
                            ->whereIn('syear', $exambatch_terms)
                            ->whereIn('id', $subject_ids)
                            ->orderBy('subjecttype_id')
                            ->orderBy('sortorder')
                            ->get(['id', 'scode', 'sname', 'syear', 'subjecttype_id']);
                        

                            $current_exam = Exam::where('exam_application',1)->first();
                            if($candidate->approvedprogramme->academicyear_id == $current_exam->academicyear_id){
                                $termsubjects = \App\Subject::where('syear',1)->where('programme_id',$candidate->approvedprogramme->programme_id)->get();
                                $backlogsubjects = null;
                            }else{
                                if($candidate->approvedprogramme->academicyear_id == ($current_exam->academicyear_id - 1)){
                                    $termsubjects = \App\Subject::where('syear',2)->where('programme_id',$candidate->approvedprogramme->programme_id)->get();
                                 /*   $backlogsubject_ids = DB::select("select subject_id from marks
                                    where candidate_id = " . $candidate->id . " 
                                    group by `subject_id`
                                    having sum(result_id) =0"); */
                                    $backlogsubjects = \App\Subject::where('syear',1)->where('programme_id',$candidate->approvedprogramme->programme_id)->get();
                                //    $backlogsubjects = \App\Subject::whereIn('id',array_pluck($backlogsubject_ids,'subject_id'))->get();
                                }else{
                                    $termsubjects = null;
                                  /*  $backlogsubject_ids =DB::select("select subject_id from marks
                                    where candidate_id = " . $candidate->id . "
                                    group by `subject_id`
                                    having sum(result_id) =0");
                                    $backlogsubjects = \App\Subject::whereIn('id',array_pluck($backlogsubject_ids,'subject_id'))->get();
                                    */
                                    $backlogsubjects = \App\Subject::where('programme_id',$candidate->approvedprogramme->programme_id)->get();

                                }
                            }
                    

                        unset($subject_ids);

                        return view('institute.examapplications.view_candidate_application', compact('exam', 'approvedprogramme', 'candidate', 'subjects', 'termsubjects', 'backlogsubjects', 'applications'));
                    }
                }
                else {
                    return redirect('/institute/examinations/applications/'.$exam->id.'/'.$approvedprogramme->id);
                }
            }
            else {
                return redirect('/institute/examinations/applications/'.$exam->id);
            }
        }
        else {
            return redirect('/institute/examinations');
        }
    }
    public function candidateExamApplicationForm($eid, $apid, $cid) {
            return '';
            $exam = Exam::find($eid);
            if(empty($exam) || $exam->exam_application != 1){
                return back();
            }
            $approvedprogramme = Approvedprogramme::find($apid);
        
           if(!is_null($approvedprogramme)) {
                $candidate = Candidate::find($cid);
                if(!is_null($candidate) && $candidate->coursecompleted_status != 1) {
                    $subjects = DB::select(' select t2.subject_id as id, s.scode, st.type as type, s.sname, s.syear from (
                        select subject_id, result_id as result_id from
                        (select subject_id, result_id from currentapplications ca
                        where candidate_id = '.$cid.'
                        union 
                        select subject_id, result_id from applications a
                        where candidate_id = '.$cid.') as t1
                        group by subject_id
                        having result_id = 0 ) as t2 
                        left join subjects s on s.id = t2.subject_id 
                        left join subjecttypes st on st.id = s.subjecttype_id
                        order by s.syear');
                        $languages = Language::where('language', '!=', 'NOT APPLICABLE')->get(['id', 'language']);
                        return view('institute.examapplications.candidate_exam_application_form', compact('exam', 'approvedprogramme', 'candidate', 'subjects', 'languages'));
                }
                else {
                    Session::put('message','Please check the eligibility / The student has already completed the course.');
                    return redirect('/institute/examinations/applications/'.$exam->id.'/'.$approvedprogramme->id);
                }
            }
            else {
                return redirect('/institute/examinations/applications/'.$exam->id);
            }
     
    }

   /*
    public function candidateExamApplicationForm($eid, $apid, $cid) {
        $exam = Exam::find($eid);

        if(!is_null($exam) && $exam->exam_application == 1) {
            $approvedprogramme = Approvedprogramme::find($apid);

            if(!is_null($approvedprogramme)) {
                $candidate = Candidate::find($cid);

                if((!is_null($candidate) || $candidate->approvedprogramme_id == $approvedprogramme->id) && $candidate->coursecompleted_status != 1) {
                   // $exambatch_terms = Exambatch::where('exam_id', $exam->id)->where('programme_id', $approvedprogramme->programme_id)
                    //    ->where('academicyear_id', $approvedprogramme->academicyear_id)->pluck('term')->unique()->toArray();

                   // if(count($exambatch_terms) == 0) {
                    //    unset($exambatch_terms);
                    //    return redirect('/institute/examinations/applications/'.$exam->id);
                   // }
                    //else {
                      //  $withheldCandidates = array('232042501','232042502','232042503','232042504','232042505','232042506','232042507','232042508','232042509','232042510','232042511','232042512','232042513','232042514','232042515','232042516','232042517','232042518','232042519','232042520','232042521','232042522','232042523');
                      //  $subjects = null;
                       // if(!in_array($candidate->enrolmentno, $withheldCandidates)) {
                            $appliedsubject_ids = $candidate->applications()->where('exam_id', $exam->id)->groupBy('subject_id')->pluck('subject_id')->toArray();

                        /*    $subjects = Subject::where('programme_id', $approvedprogramme->programme_id)
                                ->where('syllabus_type', 'New')
                                ->whereIn('syear', $exambatch_terms)
                                ->whereNotIn('id', $appliedsubject_ids)
                                ->orderBy('syear')
                                ->orderBy('subjecttype_id')
                                ->orderBy('sortorder')
                                ->get(['id', 'scode', 'sname', 'syear', 'subjecttype_id', 'imin_marks', 'imax_marks', 'emin_marks']);

                            unset($appliedsubject_ids);

                            if(count($subjects) != 0) {
                                $oldapplications = Application::where('candidate_id', $candidate->id)->get(['id', 'subject_id']);
                                $oldmarks = Mark::whereIn('application_id', $oldapplications->pluck('id')->toArray())
                                    ->where('external', '!=', '')->where('external', '!=', 'Abs')
                                    ->where('internal', '!=', '')->where('internal', '!=', 'Abs')
                                    ->get(['application_id', 'internal', 'external', 'grace']);

                                if($oldapplications->count() != 0) {
                                    if($oldmarks->count() != 0) {
                                        $subjects = $subjects->reject(function ($subject, $key) use($oldapplications, $oldmarks) {
                                            if($oldapplications->where('subject_id', $subject->id)->count() > 0) {
                                                $pass_count = 0;
                                                foreach($oldapplications->where('subject_id', $subject->id) as $key => $application) {
                                                    $marks = $oldmarks->where('application_id', $application->id);

                                                    if(count($marks) > 0) {
                                                        foreach ($marks as $mark) {
                                                            if(((int) $mark->external + (int) $mark->grace) >= $subject->emin_marks && (int) $mark->internal >= $subject->imin_marks){
                                                                $pass_count++;
                                                            }
                                                        }
                                                    }

                                                    if($pass_count != 0) {
                                                        return $subject;
                                                    }
                                                }
                                            }
                                        });
                                    }
                                }
                            } */

                      //  }

/*                      $current_exam = Exam::where('exam_application',1)->first();
                      if($candidate->approvedprogramme->academicyear_id == $current_exam->academicyear_id){
                          $termsubjects = \App\Subject::where('syear',1)->where('programme_id',$candidate->approvedprogramme->programme_id)->pluck('id')->toArray();
                          $backlogsubjects = null;
                      }else{
                          if($candidate->approvedprogramme->academicyear_id == ($current_exam->academicyear_id - 1)){
                              $termsubjects = \App\Subject::where('syear',2)->where('programme_id',$candidate->approvedprogramme->programme_id)->pluck('id')->toArray();
                              $backlogsubject_ids = DB::select("select subject_id from marks
                              where candidate_id = " . $candidate->id . " 
                              group by `subject_id`
                              having sum(result_id) =0");
                              $backlogsubjects = \App\Subject::whereIn('id',array_pluck($backlogsubject_ids,'subject_id'))->pluck('id')->toArray();
                          }else{
                              $termsubjects = null;
                              $backlogsubject_ids =DB::select("select subject_id from marks
                              where candidate_id = " . $candidate->id . "
                              group by `subject_id`
                              having sum(result_id) =0");
                              $backlogsubjects = \App\Subject::whereIn('id',array_pluck($backlogsubject_ids,'subject_id'))->pluck('id')->toArray();
                          }
                      }

                        if($backlogsubjects == null){
                            $subjects = \App\Subject::whereIn('id',$termsubjects)->get();
                        }else{
                            $subjects = \App\Subject::whereIn('id',array_merge($backlogsubjects,$termsubjects))->get();
                        }

                        $languages = Language::where('language', '!=', 'NOT APPLICABLE')->get(['id', 'language']);

                        $ExamCentreStates = Externalexamcenter::where('active_status', 1)->pluck('state')->toArray();
                        //$states = State::whereIn('state_name', $ExamCentreStates)->orderBy('state_name')->get(['state_name']);

                        return view('institute.examapplications.candidate_exam_application_form', compact('exam', 'approvedprogramme', 'candidate', 'subjects', 'languages'));
                 //   }
                }
                else {
                    Session::put('message','Please check the eligibility / The student has already completed the course.');
                    return redirect('/institute/examinations/applications/'.$exam->id.'/'.$approvedprogramme->id);
                }
            }
            else {
                return redirect('/institute/examinations/applications/'.$exam->id);
            }
        }
        else {
            return redirect('/institute/examinations');
        }
    }
    */

    public function checkMobileNumberExist(Request $request) {
        $mobileNumberCount = Candidate::where('contactnumber', $request->mobileNumber)->count();

        $responseData = "Not Exist";

        if($mobileNumberCount != 0) {
            if($mobileNumberCount == 1) {
                $candidateMobileNoFound = Candidate::find($request->candidateId)->where('contactnumber', $request->mobileNumber)->exists();

                if($candidateMobileNoFound == null)
                    $responseData = "No Self-Exist";
                else
                    $responseData = "Self-Exist";
            }
            else {
                $responseData = "Exist";
            }
        }

        return response()->json($responseData);
    }

    public function sendMobileNumberVerificationCode(Request $request) {
        $api_key = '25FA4F48782DFA';
        $contacts = trim($request->mobileNumber);
        $from = 'CHNBER';
        $template_id = '1207165062729800473';
        $verificationCode = trim($request->verificationCode);
        $sms_text = urlencode('Dear Student, '.$verificationCode.' is the mobile verification code. Regards, NIEPMD-NBER, Chennai.');

        $api_url = "http://sms.godaddysms.com/app/smsapi/index.php?key=" . $api_key . "&campaign=0&routeid=13&type=text&contacts=" . $contacts . "&senderid=" . $from . "&msg=" . $sms_text . "&template_id=" . $template_id;

        $responseData = file_get_contents($api_url);

        return response()->json($responseData);
    }

    public function checkEmailAddressExist(Request $request) {
        $emailAddressCount = Candidate::where('email', $request->emailAddress)->count();

        $responseData = "Not Exist";

        if($emailAddressCount != 0) {
            if($emailAddressCount == 1) {
                $candidateEmailAddressFound = Candidate::find($request->candidateId)->where('email', $request->emailAddress)->exists();

                if($candidateEmailAddressFound == null)
                    $responseData = "No Self-Exist";
                else
                    $responseData = "Self-Exist";
            }
            else {
                $responseData = "Exist";
            }
        }

        return response()->json($responseData);
    }

    public function sendEmailAddressVerificationCode(Request $request) {
        $responseData = "";
        try {
            $verificationCode = trim($request->verificationCode);
            $to_name = "Applicant";
            $to_email = trim($request->emailAddress);
            $exam = Exam::find($request->examId);

            Mail::send('institute.examapplications.send_email_address_verification_code', ['verificationCode' => $verificationCode, 'exam' => $exam], function($message) use ($to_name, $to_email, $exam) {
                $message->to($to_email, $to_name)
                    ->subject('Student Email Verification Code - '.$exam->name.' Examination Application');
                $message->from('nber.notifications@gmail.com','NIEPMD-NBER, Chennai');
            });

            $responseData = 1;
        }
        catch (\Exception $ex){
            $responseData = $ex->getMessage();
        }

        return response()->json($responseData);
    }

    public function applyCandidateExamApplication(Request $request) {
       return "Closed";
        $sno = -1;
        $candidate = Candidate::find($request->candidateId);
       $applications = array();
        foreach ($request->subjectAppliedStatus as $subjectIdCheckbox){
            $sno++;
            if($subjectIdCheckbox == '1') {
                $applications[$request->subjectId[$sno]] =[
                    "exam_id" => $request->examId,
                    "approvedprogramme_id" => $request->approvedprogrammeId,
                    "term" => $request->term[$sno],
                    "language_id" => $request->languageId,
                    "payment_status" => "Not Entered",
                    "active_status" => 1,
                    "status_id" => 6,
                    "linkopen_number" => 1,
                    "penalty" => "No",
                    "externalexamcenter_id" => 1,
                ];
            }
        }
        $candidate->subjects()->detach();
        $candidate->subjects()->sync($applications);
        return redirect('/institute/examinations/applications/'.$request->examId.'/'.$candidate->approvedprogramme_id.'/'.$candidate->id)->with(['message' => "Successfully Applied"]);
    }

    public function practicalexaminers($e_id) {
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        if(is_null($institute)) {
            unset($institute);
            return redirect('/');
        }
        else {
            $exam = Exam::find($e_id);

            $programmes = Application::join("subjects", "subjects.id", "=", "applications.subject_id")
                ->join("approvedprogrammes", "approvedprogrammes.id", "=", "applications.approvedprogramme_id")
                ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
                ->where('approvedprogrammes.institute_id', $institute->id)
                ->where('applications.exam_id', $exam->id)
                ->where('subjects.subjecttype_id', 2)
                ->groupBy("programmes.common_code")->get(["programmes.id", "programmes.common_name", "programmes.common_code"]);

            return view('institute.practicalexaminers.index', compact('institute', 'exam', 'programmes'));
        }
    }

    public function addfeedetails($e_id, $common_code) {
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        if(is_null($institute)) {
            unset($institute);
            return redirect('/');
        }
        else {
            $exam = Exam::find($e_id);
            $common_name = Programme::where('common_code', $common_code)->first()->common_name;

            $approvedprogramme_ids = Approvedprogramme::
                 join("applications", "applications.approvedprogramme_id", "=", "approvedprogrammes.id")
                ->join("subjects", "subjects.id", "=", "applications.subject_id")
                ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
                ->where('approvedprogrammes.institute_id', $institute->id)
                ->where('applications.exam_id', $exam->id)
                ->where('subjects.subjecttype_id', 2)
                ->where('programmes.common_code', $common_code)
                ->groupBy("approvedprogrammes.id")->pluck("approvedprogrammes.id")->toArray();

            $approvedprogrammes = Approvedprogramme::with("academicyear")
                ->whereIn("id", $approvedprogramme_ids)->get()->sortBy('academicyear.year');

            return view('institute.practicalexaminers.addfeedetails', compact('institute', 'exam', 'approvedprogrammes', 'common_code', 'common_name'));
        }
    }

    public function updateexamfee(Request $request) {
        $sno = 0;

        foreach ($request->approvedprogramme_id as $approvedprogrammeid) {
            $practicalexamfeedetail = Practicalexamfeedetail::where("practicalexam_id", $request->practicalexam_id)->where('approvedprogramme_id', $approvedprogrammeid)->first();

            if(is_null($practicalexamfeedetail)) {
                Practicalexamfeedetail::create([
                    "practicalexam_id" => $request->practicalexam_id,
                    "approvedprogramme_id" => $approvedprogrammeid,
                    "candidate_count" => $request->candidate_count[$sno],
                    "paper_count" => $request->paper_count[$sno],
                    "payment_date" => $request->payment_date[$sno],
                    "transaction_number" => $request->transaction_number[$sno],
                    "amount_paid" => $request->amount_paid[$sno],
                    "payment_remark" => $request->payment_remark[$sno],
                    "active_status" => 1,
                ]);
            }
            else {
                $practicalexamfeedetail->update([
                    "candidate_count" => $request->candidate_count[$sno],
                    "paper_count" => $request->paper_count[$sno],
                    "payment_date" => $request->payment_date[$sno],
                    "transaction_number" => $request->transaction_number[$sno],
                    "amount_paid" => $request->amount_paid[$sno],
                    "payment_remark" => $request->payment_remark[$sno],
                    "active_status" => 1,
                ]);
            }
            unset($practicalexamfeedetail);
            $sno++;
        }
        unset($sno);

        return redirect()->back();
    }

    public function addexamdetails($e_id, $common_code){
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        if(is_null($institute)) {
            unset($institute);
            return redirect('/');
        }
        else {
            $exam = Exam::find($e_id);
            $common_name = Programme::where('common_code', $common_code)->first()->common_name;

            $practicalexam = Practicalexam::where("exam_id", $exam->id)->where("institute_id", $institute->id)->where("common_code", $common_code)->first();

            $approvedprogramme_ids = Approvedprogramme::
            join("applications", "applications.approvedprogramme_id", "=", "approvedprogrammes.id")
                ->join("subjects", "subjects.id", "=", "applications.subject_id")
                ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
                ->where('approvedprogrammes.institute_id', $institute->id)
                ->where('applications.exam_id', $exam->id)
                ->where('subjects.subjecttype_id', 2)
                ->where('programmes.common_code', $common_code)
                ->groupBy("approvedprogrammes.id")->pluck("approvedprogrammes.id")->toArray();

            $approvedprogrammes = Approvedprogramme::with("academicyear")
                ->whereIn("id", $approvedprogramme_ids)->get()->sortBy('academicyear.year');

            return view('institute.practicalexaminers.addfeedetails', compact('institute', 'exam', 'practicalexam', 'approvedprogrammes', 'common_code', 'common_name'));
        }
    }

    public function updatepracticalexam(Request $request) {
        $practicalexam = Practicalexam::where("exam_id", $request->exam_id)->where('institute_id', $request->institute_id)
            ->where("common_code", $request->common_code)->first();

        if(is_null($practicalexam)) {
            Practicalexam::create([
                "exam_id" => $request->exam_id,
                "institute_id" => $request->institute_id,
                "common_code" => $request->common_code,
                "exam_date" => $request->exam_date,
                "coursecoordinator_name" => $request->coursecoordinator_name,
                "coursecoordinator_contactnumber" => $request->coursecoordinator_contactnumber,
                "coursecoordinator_whatsappnumber" => $request->coursecoordinator_whatsappnumber,
                "coursecoordinator_email" => $request->coursecoordinator_email,
                "status_id" => 5,
                "active_status" => 1,
            ]);
        }

        unset($practicalexam);
        return redirect()->back();
    }

    public function examinerdetails($e_id, $pe_id) {
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        if(is_null($institute)) {
            unset($institute);
            return redirect('/');
        }
        else {
            $exam = Exam::find($e_id);
            $practicalexam = Practicalexam::where("id", $pe_id)->where("institute_id", $institute->id)->first();

            if(is_null($practicalexam)) {
                unset($exam);
                unset($practicalexam);
            }
            else {
                $common_name = Programme::where("common_code", $practicalexam->common_code)->first()->common_name;
                $practicalexaminers = Practicalexaminer::where("practicalexam_id", $practicalexam->id)->get();

                return view('institute.practicalexaminers.practicalexaminers', compact('institute', 'exam', 'practicalexam', 'common_name' ,'practicalexaminers'));
            }
        }
    }

    public function addinternalexaminer($e_id, $pe_id) {
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        if(is_null($institute)) {
            unset($institute);
            return redirect('/');
        }
        else {
            $exam = Exam::find($e_id);
            $practicalexam = Practicalexam::where("id", $pe_id)->where("institute_id", $institute->id)->first();

            if(is_null($practicalexam)) {
                unset($exam);
                unset($practicalexam);
            }
            else {
                $common_name = Programme::where("common_code", $practicalexam->common_code)->first()->common_name;
                $practicalexaminers = Practicalexaminer::where("practicalexam_id", $practicalexam->id)->get();
                $titles = Title::all();
                $genders = Gender::all();
                $cities = City::all();
                $states = State::orderBy('state_name')->get();

                return view('institute.practicalexaminers.addinternalexaminer', compact('institute', 'exam', 'practicalexam', 'common_name', 'practicalexaminers', 'titles', 'genders', 'cities', 'states'));
            }
        }
    }

    public function updateinternalexaminer(Request $request) {
        Practicalexaminer::create([
            "practicalexam_id" => $request->practicalexam_id,
            "practicalexaminertype_id" => 1,
            "title_id" => $request->title_id,
            "name" => $request->name,
            "age" => $request->age,
            "gender_id" => $request->gender_id,
            "qualification" => $request->qualification,
            "crrnumber" => $request->crrnumber,
            "experience" => $request->experience,
            "address" => $request->address,
            "city_id" => $request->city_id,
            "pincode" => $request->pincode,
            "contactnumber" => $request->contactnumber,
            "whatsappnumber" => $request->whatsappnumber,
            "email" => $request->email,
            "active_status" => 1,
        ]);

        return redirect('institute/examinations/practicalexaminers/examinerdetails/'.$request->exam_id.'/'.$request->practicalexam_id);
    }

    public function addexternalexaminer($e_id, $pe_id) {
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        if(is_null($institute)) {
            unset($institute);
            return redirect('/');
        }
        else {
            $exam = Exam::find($e_id);
            $practicalexam = Practicalexam::where("id", $pe_id)->where("institute_id", $institute->id)->first();

            if(is_null($practicalexam)) {
                unset($exam);
                unset($practicalexam);
            }
            else {
                $common_name = Programme::where("common_code", $practicalexam->common_code)->first()->common_name;
                $practicalexaminers = Practicalexaminer::where("practicalexam_id", $practicalexam->id)->get();
                $titles = Title::all();
                $genders = Gender::all();
                $cities = City::all();
                $states = State::orderBy('state_name')->get();

                return view('institute.practicalexaminers.addexternalexaminer', compact('institute', 'exam', 'practicalexam', 'common_name', 'practicalexaminers', 'titles', 'genders', 'cities', 'states'));
            }
        }
    }

    public function updateexternalexaminer(Request $request) {
        Practicalexaminer::create([
            "practicalexam_id" => $request->practicalexam_id,
            "practicalexaminertype_id" => 2,
            "title_id" => $request->title_id,
            "name" => $request->name,
            "age" => $request->age,
            "gender_id" => $request->gender_id,
            "qualification" => $request->qualification,
            "crrnumber" => $request->crrnumber,
            "experience" => $request->experience,
            "address" => $request->address,
            "city_id" => $request->city_id,
            "pincode" => $request->pincode,
            "contactnumber" => $request->contactnumber,
            "whatsappnumber" => $request->whatsappnumber,
            "email" => $request->email,
            "active_status" => 1,
        ]);

        return redirect('institute/examinations/practicalexaminers/examinerdetails/'.$request->exam_id.'/'.$request->practicalexam_id);
    }

    public function viewpracticalexaminers($e_id, $p_id) {
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        if(is_null($institute)) {
            unset($institute);
            return redirect('/');
        }
        else {
            $exam = Exam::find($e_id);
            $programme = Programme::find($p_id);

            return view('institute.practicalexaminers.view', compact('institute', 'exam', 'programme'));
        }
    }

    public function addpracticalexaminers($e_id, $p_id) {
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        if(is_null($institute)) {
            unset($institute);
            return redirect('/');
        }
        else {
            $exam = Exam::find($e_id);
            $programme = Programme::find($p_id);

            return view('institute.practicalexaminers.addform', compact('institute', 'exam', 'programme'));
        }
    }
    /*
    public function addexamdetails($e_id, $common_code) {
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        if(is_null($institute)) {
            unset($institute);
            return redirect('/');
        }
        else {
            $exam = Exam::find($e_id);
            $common_name = Programme::where('common_code', $common_code)->first()->common_name;

            $approvedprogramme_ids = Approvedprogramme::
                 join("applications", "applications.approvedprogramme_id", "=", "approvedprogrammes.id")
                ->join("subjects", "subjects.id", "=", "applications.subject_id")
                ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
                ->where('approvedprogrammes.institute_id', $institute->id)
                ->where('applications.exam_id', $exam->id)
                ->where('subjects.subjecttype_id', 2)
                ->where('programmes.common_code', $common_code)
                ->groupBy("approvedprogrammes.id")->pluck("approvedprogrammes.id")->toArray();

            $approvedprogrammes = Approvedprogramme::with("academicyear")
                ->whereIn("id", $approvedprogramme_ids)->get()->sortBy('academicyear.year');

            return view('institute.practicalexaminers.addexamdetails', compact('institute', 'exam', 'approvedprogrammes', 'common_code', 'common_name'));
        }
    }
    */

    public function getExamCentres(Request $request){
        $data = Externalexamcenter::where('state', $request->state)->where('active_status', 1)
            ->orderBy('name')->get(['id', 'name', 'code', 'district']);

        return response()->json($data);
    }
}
