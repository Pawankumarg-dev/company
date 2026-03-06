<?php

namespace App\Http\Controllers\Student\Exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\Applications\MainExamService;
use App\Studentlogin;
use Session;
use Auth;
use App\Services\DBService;
use DB;

class ApplicationController extends Controller
{

    private $examService;
    private $helperService;

    public function __construct(Request $r)
    {
        $this->examService = new MainExamService();
        $this->helperService = new HelperService();
    }

    public function index(Request $r)
    {

        if ($r->has('view')) {
            if ($r->view == 'result') {

            $allapplicant = \App\Allapplicant::where('candidate_id', $this->helperService->getCandidateID())->where('exam_id', 27)->first();

                if($allapplicant->blocked==0 || $allapplicant->blocked==2){
                                $allapplications = \App\Allapplication::where('candidate_id', $this->helperService->getCandidateID())->where('exam_id', 27)->where('blocked', 0)->get();

                }
                else{
                    $allapplications=[];
                }


                     
                $allapplicantrev = \App\Allapplication::where('candidate_id', $this->helperService->getCandidateID())->where('exam_id', 27)->whereNotNull('mark_ex_re')->get();

            //    $allapplicantrev=[];



                return view('student.exam.result', compact('allapplications','allapplicant','allapplicantrev'));
            }
         
        //      if ($r->view == 'confirmationpage') {
        //     $candidate = $this->helperService->getCandidate();
        //     return view('student/exam/confirmation', compact('subjects', 'candidate', 'applicant', 'exam', 'languages'));
        // }
        //     if($r->view =='confirm'){
        //         $allapplicant = \App\Allapplicant::where('candidate_id',$this->helperService->getCandidateID())->where('exam_id',27)->first();
        //         $allapplicant->confirmed = 1;
        //         $allapplicant->save();
        //         Session::flash('messages',"Your application is successfully submitted");
        //         return redirect(url('student/exam/applications'));
        //     }





        }

if ($r->has('view')) {


            if ($r->view == 'examform') {



        $Candidate = \App\Candidate::where('user_id', Auth::user()->id)->first();
            $theoty=1;
            $paractical=2;

        if($Candidate->approvedprogramme->programme_id == 57){
           $atte = \App\Attendance::where('candidate_id', $Candidate->id)
        ->selectRaw('MAX(attendance_t) as attendance_t, MAX(attendance_p) as attendance_p')
        ->first();

           if ($atte->attendance_t < 75.00) {
                $theoty=0;
            }
            if ($atte->attendance_p < 75.00) {
                 $paractical=0;
            }
        }


        // return $Candidate->approvedprogramme->academicyear_id; 




// $eligiable = DB::table('allexamresults')
//     ->select(
//         'candidate_id',
//         DB::raw('COUNT(sl_no_marksheet_term_one) AS term_one_exam_count'),
//         DB::raw('COUNT(sl_no_marksheet_term_two) AS term_two_exam_count')
//     )
//     ->where('candidate_id', $Candidate->id)
//     ->groupBy('candidate_id')
//     ->first(); // Use first() instead of get()

        if (
            // ($eligiable->term_one_exam_count > 3 || $eligiable->term_two_exam_count > 3) ||
        ($Candidate->approvedprogramme->programme->numberofterms == 1 && $Candidate->approvedprogramme->academicyear_id<11) || ($Candidate->approvedprogramme->programme->numberofterms == 2 && $Candidate->approvedprogramme->academicyear_id<10)

        ) {
            Session::flash('messages', "N+2 chances are over as per scheme of examination. You are not eligible for exam");
            return back();
        }

        // exam form
        $allapplicant = \App\Allapplicant::where('candidate_id', $Candidate->id)->where('exam_id',28)->first();
        $subjects = $this->examService->getSubjects();
        $exam = $this->examService->getExam();
        $languages = \App\Language::all();
        $applicant =  $this->examService->getApplicant();
        
        $reason = $this->examService->getReason();
        $exception =  0;
       
            if (!is_null($allapplicant)) {

                if($allapplicant->payment_status!=1){
                $allapplications = \App\Allapplication::where('candidate_id', $Candidate->id)->where('exam_id', 28)->where('blocked', 0)->get();

if (count($allapplications) > 0) { // ✅ works in older versions
    
            return view('student.exam.payment', compact(
                'subjects',
                'exam',
                'languages',
                'applicant',
                'exception',
                'reason',
                'Candidate'
            ));
        }
        else{
            Session::flash('messages', 'Please contact your institute/ Nber.');
            return redirect('/profile');
        }

            }
            else{

 $internalpass = DB::select("SELECT 
    GROUP_CONCAT(DISTINCT t.subject_id) AS internalpass
FROM
(
    -- From combinedapplications
    SELECT 
        na.candidate_id,
        na.subject_id
    FROM combinedapplications na
    INNER JOIN subjects s 
        ON s.id = na.subject_id
    WHERE 
        na.candidate_id = $Candidate->id
        AND na.mark_in >= s.imin_marks

    UNION

    -- From newinternalmarks
    SELECT 
        nim.candidate_id,
        nim.subject_id
    FROM newinternalmarks nim
    INNER JOIN subjects s 
        ON s.id = nim.subject_id
    WHERE 
        nim.candidate_id = $Candidate->id
        AND nim.internal >= s.imin_marks

        union

        select
        $Candidate->id AS candidate_id,
    s.id AS subject_id
FROM subjects s
WHERE 
    s.is_external = '1'
    AND s.is_internal = '0'
    and subjecttype_id in ($theoty,$paractical)

) t
GROUP BY t.candidate_id;");
            $orders  = \App\Order::where('id' , $applicant->order_id)->get();
           // dd( $orders);
                // dd($subjects);
            return view('student.exam.application',compact(
            'subjects',
            'exam',
            'languages',
            'applicant',
            'exception',
            'reason',
            'Candidate',
            'internalpass',
            'orders'
        ));
            }
        }else{

 $internalpass = DB::select("SELECT 
    t.candidate_id,
    GROUP_CONCAT(DISTINCT t.subject_id) AS internalpass
FROM
(
    -- From combinedapplications
    SELECT 
        na.candidate_id,
        na.subject_id
    FROM combinedapplications na
    INNER JOIN subjects s 
        ON s.id = na.subject_id
    WHERE 
        na.candidate_id = $Candidate->id
        AND na.mark_in >= s.imin_marks

    UNION

    -- From newinternalmarks
    SELECT 
        nim.candidate_id,
        nim.subject_id
    FROM newinternalmarks nim
    INNER JOIN subjects s 
        ON s.id = nim.subject_id
    WHERE 
        nim.candidate_id = $Candidate->id
        AND nim.internal >= s.imin_marks
 union

        select
        $Candidate->id AS candidate_id,
    s.id AS subject_id
FROM subjects s
WHERE 
    s.is_external = '1'
    AND s.is_internal = '0'
    and subjecttype_id in ($theoty,$paractical)
) t
GROUP BY t.candidate_id;");
           //dd('hello');
            return view('student.exam.application',compact(
            'subjects',
            'exam',
            'languages',
            'applicant',
            'exception',
            'reason',
             'Candidate',
            'internalpass'
        ));
        }



 // end exam form
            }
}

       








//remove content

        // $exam = $this->examService->getExam();
        // $subjects = $this->examService->getSubjects();
        // //return $subjects;
        // $languages = \App\Language::all();
        // $applicant =  $this->examService->getApplicant();
        // if ($r->view == 'confirmationpage') {
        //     $candidate = $this->helperService->getCandidate();
        //     return view('student/exam/confirmation', compact('subjects', 'candidate', 'applicant', 'exam', 'languages'));
        // }
        // $login = Studentlogin::where('candidate_id', $this->helperService->getCandidateID())->first();
        // $noofsubjects = 0;
        // $reason = $this->examService->getReason();
        // if (is_null($subjects)) {
        //     $noofsubjects = null;
        // } else {
        //     $noofsubjects = $subjects->count();
        // }
        // if (is_null($login)) {
        //     Studentlogin::create([
        //         'candidate_id' => $this->helperService->getCandidateID(),
        //         'noofsubjects' => $noofsubjects
        //     ]);
        // }
        // $exception =  0;
        // $approvedprogramme_id = \App\Candidate::where('user_id', Auth::user()->id)->first()->approvedprogramme_id;

        // // if($this->helperService->getCandidateID() == 140047){
        // $hallticket = \App\Hallticket::where('candidate_id', $this->helperService->getCandidateID())->where('exam_id', 27)->first();
        // if (is_null($hallticket)) {
        //     if (\App\Candidate::where('user_id', Auth::user()->id)->first()->status_id == 2) {
        //         ini_set('memory_limit', '-1');
        //         set_time_limit(0);
        //         //$sql = "CALL generateTHTForCandidate(27," . $this->helperService->getCandidateID() . ")";
        //         //DB::select($sql);
        //         //$r =  (new DBService)->fetch($sql);
        //     }
        // }
        // $hallticket = \App\Hallticket::where('candidate_id', $this->helperService->getCandidateID())->where('exam_id', 27)->first();
        // if (!is_null($hallticket)) {
        //     return view('student.exam.payment', compact(
        //         'subjects',
        //         'exam',
        //         'languages',
        //         'applicant',
        //         'exception',
        //         'reason',
        //         'approvedprogramme_id'
        //     ));
        // } else {
        //     $hallticket = \App\Practicalhallticket::where('candidate_id', $this->helperService->getCandidateID())->where('exam_id', 27)->first();
        //     if (!is_null($hallticket)) {
        //         return view('student.exam.payment', compact(
        //             'subjects',
        //             'exam',
        //             'languages',
        //             'applicant',
        //             'exception',
        //             'reason',
        //             'approvedprogramme_id'
        //         ));
        //     }

        //     $existing = \App\Allapplicant::where('candidate_id', $this->helperService->getCandidateID())->where('exam_id', 27)->first();
        //     if ($existing) {
        //         Session::flash('messages', 'Please contact your institute.');
        //         return back();
        //     } else {
        //         $candidate = $this->helperService->getCandidate();
        //         if (is_null($candidate->enrolmentno) || $candidate->enrolmentno == '') {
        //             Session::flash('messages', 'Contact your institute');
        //             return back();
        //         }
        //         $newinternal = \App\Newinternalmark::where('candidate_id', $this->helperService->getCandidateID())->first();
        //         if (!is_null($newinternal)) {
        //             Session::flash('messages','Application form is closed');
        //             return back();
        //             // return view('student.exam.additionalapplication', compact(
        //             //     'subjects',
        //             //     'exam',
        //             //     'languages',
        //             //     'applicant',
        //             //     'exception',
        //             //     'reason',
        //             //     'approvedprogramme_id'
        //             // ));
        //         }
        //     }
        // }


        //}
        // return view('student.exam.application',compact(
        //     'subjects',
        //     'exam',
        //     'languages',
        //     'applicant',
        //     'exception',
        //     'reason',
        //     'approvedprogramme_id'
        // ));
    }

    public function store(Request $r)
    {

       
        $approvedprogramme_id = \App\Candidate::where('user_id', Auth::user()->id)->first()->approvedprogramme_id;

        // if(Auth::user()->id != 134575){
        //     Session::put('messages','Exam application is closed');
        //     return back();
        // }


        $applicant = $this->examService->saveApplication();
        
        $payment = "Fresh";
        // if (is_null($applicant)) {
        //     $applicant = $this->examService->getApplicant();
        //     $payment = "Recheck";
        // }
        $candidate = $this->helperService->getCandidate();
        //No payment required for CBID
        // if($candidate->approvedprogramme->programme_id == 57){
        //     $applicant->payment_status = 1;
        //     $applicant->save();
        //     Session::flash('messages',"Applied");
        //     return redirect(url('student/exam/applications'));
        // }
        // if(!is_null($applicant) && $applicant->confirmed != 1 && $approvedprogramme_id == 8837){
        //   //  Session::flash('messages',"Applied");

        //     $applicant =  $this->examService->getApplicant();
        //     $exam = $this->examService->getExam();
        //     $subjects = $this->examService->getSubjects();
        //     $languages = \App\Language::all();
        //     return redirect(url('student/exam/applications')."?view=confirmationpage");
        //     //
        // }
        //Session::flash('messages',"Exam application are closed");
        return view('student.exam.payonline', compact(
            'candidate',
            'applicant',
            'payment'
        ));
        return redirect(url('student/exam/applications'));
    }
}
