<?php

namespace App\Http\Controllers\Nber;

use App\Academicyear;
use App\Application;
use App\Approvedprogramme;
use App\Candidate;
use App\Exam;
use App\Exambatch;
use App\Examinationfee;
use App\Examinationpayment;
use App\Institute;
use App\Programme;
use App\Status;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExaminationPaymentController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index() {
        $exam_ids = Examinationfee::groupBy('exam_id')->pluck('exam_id')->toArray();
        $exams = Exam::whereIn('id', $exam_ids)->orderBy('date', 'desc')->get();

        return view('nber.examinationpayments.index', compact('exams'));
    }

    public function display($exam_id) {
        $examinationfees = Examinationfee::where('exam_id', $exam_id)->get();
        $examinationfee_ids = $examinationfees->pluck('id')->unique()->toArray();

        $collections = Examinationpayment::whereIn('examinationfee_id', $examinationfee_ids)->groupBy('reference_number')
            ->orderBy('reference_number')->paginate(15);

        $exam = Exam::where('id', $exam_id)->first();

        $link = 'examinationpayments';
        $text = $exam->name.' Examination Payments';

        $examinationpayments = Examinationpayment::whereIn('examinationfee_id', $examinationfee_ids)->get();

        //$applications = Application::where('exam_id', $exam_id)->select('candidate_id')->get();

        //return view('nber.examinationpayments.view', compact('commonexaminationpayments', 'exam', 'examinationpayments', 'applications'));
        return view('nber.examinationpayments.view', compact('link', 'text', 'collections', 'exam', 'examinationpayments'));

    }

    public static function totalamount($reference_number) {
        $amount = 0;

        $examinationpayments = Examinationpayment::where('reference_number', $reference_number)->get();

        foreach ($examinationpayments as $ep) {
            $amount += $ep->examinationfee->exam_fee;

            if($ep->latefee_remark == 'Yes') {
                $amount += $ep->examinationfee->late_fee;
            }
        }

        return $amount;
    }

    public static function appliedsubject($exam_id, $reference_number) {
        $examinationpayments = Examinationpayment::where('reference_number', $reference_number)->get();
        $candidate_ids = $examinationpayments->pluck('candidate_id')->unique()->toArray();

        $subjects = Application::where('exam_id', $exam_id)->whereIn('candidate_id', $candidate_ids)->count();

        return $subjects;
    }

    public function sampleexampayments($exam_id) {
        //find the examination
        $exam = Exam::find($exam_id);

        //find examinationfees and examinationpayments
        $examinationfees = Examinationfee::where('exam_id', $exam->id)->get();
        $examinationfee_ids = $examinationfees->pluck('id')->unique()->toArray();
        $examinationpayments = Examinationpayment::whereIn('examinationfee_id', $examinationfee_ids)->orderBy('reference_number')->get();
        $commonpayments = Examinationpayment::whereIn('examinationfee_id', $examinationfee_ids)->groupBy('reference_number')->orderBy('reference_number')->get();

        $applications = Application::where('exam_id', $exam_id)->get();
        $candidate_ids = $applications->pluck('candidate_id')->unique()->toArray();

        $candidates = Candidate::whereIn('id', $candidate_ids)->orderBy('enrolmentno')->get();
        $approvedprogramme_ids = $candidates->pluck('approvedprogramme_id')->unique()->toArray();

        $approvedprogrames = Approvedprogramme::whereIn('id', $approvedprogramme_ids)->get();
        $institute_ids = $approvedprogrames->pluck('institute_id')->unique()->toArray();
        $programme_ids = $approvedprogrames->pluck('programme_id')->unique()->toArray();
        $academicyear_ids = $approvedprogrames->pluck('academicyear_id')->unique()->toArray();

        $institutes = Institute::whereIn('id', $institute_ids)->orderBy('code')->get();
        $programmes = Programme::whereIn('id', $programme_ids)->get();
        $academicyears = Academicyear::whereIn('id', $academicyear_ids)->orderBy('year')->get();

        return view('nber.examinationpayments.sample', compact('exam', 'institutes', 'programmes', 'academicyears', 'candidates', 'applications', 'commonpayments'));
    }

    public function showInstituteLists($e_id) {
        $exam = Exam::find($e_id);

        if(is_null($exam)) {
            return redirect('/nber/examinationpayments/');
        }
        else {
            //return view('nber.examinationpayments.showInstituteLists', compact('exam'));
            return view('nber.examinationpayments.showInstituteLists', compact('exam'));
        }
    }

    public function showPaymentDetails($e_id, $i_id) {
        $exam = Exam::find($e_id);

        $institute = Institute::where('id', $i_id)->first();

        return view('nber.examinationpayments.showPaymentDetails', compact('exam', 'institute'));
    }

    public function sampleInstituteDisplay($e_id, $i_id) {
        $exam = Exam::find($e_id);

        $institute = Institute::where('id', $i_id)->first();

        $data = Approvedprogramme::select(array('programmes.abbreviation as programme', 'academicyears.year as batch', 'subjects.syear as syear', 'subjecttypes.type as stype', DB::raw('count(distinct applications.candidate_id) as candcount'), DB::raw('count(applications.subject_id) as subcount')))
            ->join('applications', 'applications.approvedprogramme_id', '=', 'approvedprogrammes.id')
            ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
            ->join('subjecttypes', 'subjecttypes.id', '=', 'subjects.subjecttype_id')
            ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->where('applications.exam_id', $exam->id)
            ->where('institutes.id', $institute->id)
            ->groupBy('applications.approvedprogramme_id')
            ->groupBy('subjects.syear')
            ->groupBy('subjects.subjecttype_id')
            ->orderBy('institutes.code')->orderBy('programmes.sortorder')->orderBy('academicyears.year')
            ->get();

       dd($data);
        /*
        $collections = Approvedprogramme::select(array('approvedprogrammes.*', 'subjects.syear as syear', 'subjecttypes.type as stype', DB::raw('count(distinct applications.candidate_id) as candcount'), DB::raw('count(applications.subject_id) as subcount')))
            ->join('applications', 'applications.approvedprogramme_id', '=', 'approvedprogrammes.id')
            ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
            ->join('subjecttypes', 'subjecttypes.id', '=', 'subjects.subjecttype_id')
            ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->where('applications.exam_id', $exam->id)
            ->where('institutes.id', $institute->id)
            ->groupBy('applications.approvedprogramme_id')
            ->groupBy('subjects.syear')
            ->groupBy('subjects.subjecttype_id')
            ->orderBy('institutes.code')->orderBy('programmes.sortorder')->orderBy('academicyears.year')
            ->get();

        return view('nber.examinationpayments.viewinstitutepaymentdetails', compact('exam', 'institute', 'collections'));
        */

        //return view('nber.examinationpayments.new.showInstituteList', compact('exam', 'institute'));
    }

    public function getData(Request $request) {
        $data = Institute::where('code', $request->code)->first()->toArray();

        return response()->json($data);
    }

    public function getConsolidatedApplicationData(Request $request) {
        $data = Approvedprogramme::select(array('programmes.abbreviation as programme', 'academicyears.year as batch', 'subjects.syear as syear', 'subjecttypes.type as stype', DB::raw('count(distinct applications.candidate_id) as candcount'), DB::raw('count(applications.subject_id) as subcount')))
            ->join('applications', 'applications.approvedprogramme_id', '=', 'approvedprogrammes.id')
            ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
            ->join('subjecttypes', 'subjecttypes.id', '=', 'subjects.subjecttype_id')
            ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->where('applications.exam_id', $request->eid)
            ->where('institutes.id', $request->iid)
            ->groupBy('applications.approvedprogramme_id')
            ->groupBy('subjects.syear')
            ->groupBy('subjects.subjecttype_id')
            ->orderBy('institutes.code')->orderBy('programmes.sortorder')->orderBy('academicyears.year')
            ->get();

        return response()->json($data);
    }

    public function getExaminationPaymentData(Request $request) {

        $data = Examinationpayment::select(array('examinationpayments.', DB::raw('count(distinct examinationpayments.candidate_id) as candcount')))
            ->join('examinationfees', 'examinationfees.id', '=', 'examinationpayments.examinationfee_id')
            ->join('paymentbanks', 'paymentbanks.id', '=', 'examinationpayments.paymentbank_id')
            ->join('paymenttypes', 'paymenttypes.id', '=', 'examinationpayments.paymenttype_id')
            ->where('examinationfees.exam_id', $request->eid)
            ->where('examinationpayments.institute_id', $request->iid)
            ->groupBy('examinationpayments.reference_number')
            ->orderBy('examinationpayments.created_at')
            ->get();

        return response()->json($data);
    }

    public function updateStatus(Request $request) {
        $examinationpayments = Examinationpayment::where('reference_number', $request->reference_number)->get();

        if(!is_null($examinationpayments)) {
            foreach ($examinationpayments as $examinationpayment) {
                $examinationpayment->update([
                    "user_id" => Auth::user()->id,
                    "status_id" => $request->status_id,
                    "verify_remarks" => $request->verify_remarks,
                    "verified_on" => date_format(date_create_from_format("d-m-Y", $request->verified_on), "Y-m-d"),
                ]);

                if($examinationpayment->status_id == 2) {
                    foreach ($examinationpayment->candidateexaminationpayments as $candidateexaminationpayment) {
                        if(!is_null($candidateexaminationpayment->application)){
                            $candidateexaminationpayment->application->update([
                                "payment_status" => "Approved"
                            ]);
                        }
                    }
                }
                else {
                    foreach ($examinationpayment->candidateexaminationpayments as $candidateexaminationpayment) {
                        if(!is_null($candidateexaminationpayment->application)){
                            $candidateexaminationpayment->application->update([
                                "payment_status" => "Rejected"
                            ]);
                        }
                    }
                }
            }

            unset($examinationpayments);

            $data = Status::find($request->status_id)->status;
        }

        return response()->json($data);
    }

    public function viewReceipt($reference_number) {
        $examinationpayments = Examinationpayment::where('reference_number', $reference_number)->get();
        $common = $examinationpayments->where('reference_number', $reference_number)->first();

        $institute = Institute::where('id', $common->institute_id)->first();
        $candidate_ids = $examinationpayments->pluck('candidate_id')->toArray();
        $currentexam = Exam::where('id', $common->examinationfee->exam->id)->first();

        $applications = Application::where('exam_id', $common->examinationfee->exam->id)->whereIn('candidate_id', $candidate_ids)->get();

        return view('nber.examinationpayments.viewReceipt', compact('institute', 'examinationpayments', 'common', 'currentexam', 'applications'));
    }

    public function showVerificationStatus($eid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/examinationpayments/');
        }
        else {
            $examinationpayments = Examinationpayment::whereHas('examinationfee', function($query) use($exam){
                $query->where('exam_id', $exam->id);
            })->get(['status_id']);

            $approvedCount = $examinationpayments->where('status_id', 2)->count();
            $rejectedCount = $examinationpayments->where('status_id', 1)->count();
            $pendingCount = $examinationpayments->where('status_id', 3)->count();
            $verificationPendingCount = $examinationpayments->where('status_id', 6)->count();
            $totalCount = $examinationpayments->count();

            return view('nber.examinationpayments.show_verification_status', compact('exam', 'approvedCount', 'rejectedCount', 'pendingCount', 'verificationPendingCount', 'totalCount'));
        }
    }

    public function viewVerificationPendingLists($eid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/examinationpayments/');
        }
        else {
            $examinationpayments = Examinationpayment::whereHas('examinationfee', function($query) use($exam){
                $query->where('exam_id', $exam->id);
            })->where('status_id', 6)->orderBy('created_at', 'desc')
                ->get(['id','institute_id', 'candidate_id', 'payment_mode', 'reference_number', 'created_at']);

            $approvedCount = $examinationpayments->where('status_id', 2)->count();
            $rejectedCount = $examinationpayments->where('status_id', 1)->count();
            $pendingCount = $examinationpayments->where('status_id', 3)->count();
            $verificationPendingCount = $examinationpayments->where('status_id', 6)->count();

            return view('nber.examinationpayments.view_verificationpending_list', compact('exam', 'examinationpayments'));
        }
    }

    public function viewApprovedLists($eid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/examinationpayments/');
        }
        else {
            $examinationpayments = Examinationpayment::whereHas('examinationfee', function($query) use($exam){
                $query->where('exam_id', $exam->id);
            })->where('status_id', 2)->orderBy('created_at', 'desc')
                ->get(['id','institute_id', 'candidate_id', 'payment_mode', 'reference_number', 'created_at']);

            $approvedCount = $examinationpayments->where('status_id', 2)->count();
            $rejectedCount = $examinationpayments->where('status_id', 1)->count();
            $pendingCount = $examinationpayments->where('status_id', 3)->count();
            $verificationPendingCount = $examinationpayments->where('status_id', 6)->count();

            return view('nber.examinationpayments.view_approved_list', compact('exam', 'examinationpayments'));
        }
    }

    public function viewPendingLists($eid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/examinationpayments/');
        }
        else {
            $examinationpayments = Examinationpayment::whereHas('examinationfee', function($query) use($exam){
                $query->where('exam_id', $exam->id);
            })->where('status_id', 1)->orderBy('created_at', 'desc')
                ->get(['id','institute_id', 'candidate_id', 'payment_mode', 'reference_number', 'created_at']);

            $approvedCount = $examinationpayments->where('status_id', 2)->count();
            $rejectedCount = $examinationpayments->where('status_id', 1)->count();
            $pendingCount = $examinationpayments->where('status_id', 3)->count();
            $verificationPendingCount = $examinationpayments->where('status_id', 6)->count();

            return view('nber.examinationpayments.view_pending_list', compact('exam', 'examinationpayments'));
        }
    }

    public function viewRejectedLists($eid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/examinationpayments/');
        }
        else {
            $examinationpayments = Examinationpayment::whereHas('examinationfee', function($query) use($exam){
                $query->where('exam_id', $exam->id);
            })->where('status_id', 3)->orderBy('created_at', 'desc')
                ->get(['id','institute_id', 'candidate_id', 'payment_mode', 'reference_number', 'created_at']);

            $approvedCount = $examinationpayments->where('status_id', 2)->count();
            $rejectedCount = $examinationpayments->where('status_id', 1)->count();
            $pendingCount = $examinationpayments->where('status_id', 3)->count();
            $verificationPendingCount = $examinationpayments->where('status_id', 6)->count();

            return view('nber.examinationpayments.view_rejected_list', compact('exam', 'examinationpayments'));
        }
    }

    public function viewCandidatePaymentDetails($eid, $epid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/examinationpayments/');
        }
        else {
            $examinationpayment = Examinationpayment::find($epid);

            if(is_null($examinationpayment)) {
                return redirect('/nber/examinationpayments/showverificationstatus/'.$exam->id);
            }
            else {
               return view('nber.examinationpayments.view_payment_details', compact('exam', 'examinationpayment'));
            }
        }
    }

    public function updateVerificationRemarks(Request $request) {
        $examinationpayment = Examinationpayment::find($request->examinationpayment_id);

        $examinationpayment->update([
            "user_id" => Auth::user()->id,
            "status_id" => $request->verification_status,
            "verify_remarks" => $request->verification_remarks,
            "verified_on" => date('Y-m-d')
        ]);

        if($examinationpayment->status_id == 2) {
            foreach ($examinationpayment->candidateexaminationpayments as $candidateexaminationpayment) {
                if(!is_null($candidateexaminationpayment->application)){
                    $candidateexaminationpayment->application->update([
                        "payment_status" => "Approved"
                    ]);
                }
            }
        }
        else {
            foreach ($examinationpayment->candidateexaminationpayments as $candidateexaminationpayment) {
                if(!is_null($candidateexaminationpayment->application)){
                    $candidateexaminationpayment->application->update([
                        "payment_status" => "Rejected"
                    ]);
                }
            }
        }

        return redirect()->back()->with(['message' => 'Verification Remarks updated successfully', 'status_class' => $examinationpayment->status->class]);
    }

    public function showVerificationPendingInstituteLists($eid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/examinationpayments/');
        }
        else {
           $institutes = Examinationpayment::whereHas('examinationfee', function($query) use($exam){
               $query->where('exam_id', $exam->id);
           })->where('status_id', 6)->groupBy('institute_id')->get()->map(function ($query){
               return $query->institute;
           })->sortBy('code');

            return view('nber.examinationpayments.show_verification_pending_institute_lists', compact('exam', 'institutes'));
        }
    }

    public function showInstituteVerificationPendingDetails($eid, $iid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/examinationpayments/');
        }
        else {
            $institute = Institute::find($iid);

            if(is_null($institute)) {
                return redirect('/nber/examinationpayments/nber/examinationpayments/showverificationstatus/'.$exam->id);
            }
            else {
                $examinationpayments = Examinationpayment::whereHas('examinationfee', function($query) use($exam){
                    $query->where('exam_id', $exam->id)->select('id');
                })->where('institute_id', $institute->id)->where('status_id', 6)
                    ->get(['id','institute_id', 'candidate_id', 'reference_number', 'payment_mode', 'created_at']);

                $institutes = Institute::whereHas('examinationpayments', function($query) use($exam) {
                    $query->whereHas('examinationfee', function($query) use($exam){
                        $query->where('exam_id', $exam->id)->select('id');
                    })->where('status_id', 6)->select('id');
                })->orderBy('code')->get(['id', 'code']);

                return view('nber.examinationpayments.show_institute_verification_pending_details', compact('exam', 'institute', 'institutes', 'examinationpayments'));
            }
        }
    }

    public function showPendingInstituteLists($eid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/examinationpayments/');
        }
        else {
            $institutes = Examinationpayment::whereHas('examinationfee', function($query) use($exam){
                $query->where('exam_id', $exam->id);
            })->where('status_id', 1)->groupBy('institute_id')->get()->map(function ($query){
                return $query->institute;
            })->sortBy('code');

            return view('nber.examinationpayments.show_pending_institute_lists', compact('exam', 'institutes'));
        }
    }

    public function showInstitutePendingDetails($eid, $iid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/examinationpayments/');
        }
        else {
            $institute = Institute::find($iid);

            if(is_null($institute)) {
                return redirect('/nber/examinationpayments/nber/examinationpayments/showverificationstatus/'.$exam->id);
            }
            else {
                $examinationpayments = Examinationpayment::whereHas('examinationfee', function($query) use($exam){
                    $query->where('exam_id', $exam->id)->select('id');
                })->where('institute_id', $institute->id)->where('status_id', 1)
                    ->get(['id','institute_id', 'candidate_id', 'reference_number', 'payment_mode', 'created_at']);

                $institutes = Institute::whereHas('examinationpayments', function($query) use($exam) {
                    $query->whereHas('examinationfee', function($query) use($exam){
                        $query->where('exam_id', $exam->id)->select('id');
                    })->where('status_id', 1)->select('id');
                })->orderBy('code')->get(['id', 'code']);

                return view('nber.examinationpayments.show_institute_pending_details', compact('exam', 'institute', 'institutes', 'examinationpayments'));
            }
        }
    }

    public function showApprovedInstituteLists($eid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/examinationpayments/');
        }
        else {
            $institutes = Examinationpayment::whereHas('examinationfee', function($query) use($exam){
                $query->where('exam_id', $exam->id);
            })->where('status_id', 2)->groupBy('institute_id')->get()->map(function ($query){
                return $query->institute;
            })->sortBy('code');

            return view('nber.examinationpayments.show_approved_institute_lists', compact('exam', 'institutes'));
        }
    }

    public function showInstituteApprovedDetails($eid, $iid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/examinationpayments/');
        }
        else {
            $institute = Institute::find($iid);

            if(is_null($institute)) {
                return redirect('/nber/examinationpayments/nber/examinationpayments/showverificationstatus/'.$exam->id);
            }
            else {
                $examinationpayments = Examinationpayment::whereHas('examinationfee', function($query) use($exam){
                    $query->where('exam_id', $exam->id)->select('id');
                })->where('institute_id', $institute->id)->where('status_id', 2)
                    ->get(['id','institute_id', 'candidate_id', 'reference_number', 'payment_mode', 'created_at']);

                $institutes = Institute::whereHas('examinationpayments', function($query) use($exam) {
                    $query->whereHas('examinationfee', function($query) use($exam){
                        $query->where('exam_id', $exam->id)->select('id');
                    })->where('status_id', 2)->select('id');
                })->orderBy('code')->get(['id', 'code']);

                return view('nber.examinationpayments.show_institute_approved_details', compact('exam', 'institute', 'institutes', 'examinationpayments'));
            }
        }
    }

    public function showRejectedInstituteLists($eid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/examinationpayments/');
        }
        else {
            $institutes = Examinationpayment::whereHas('examinationfee', function($query) use($exam){
                $query->where('exam_id', $exam->id);
            })->where('status_id', 3)->groupBy('institute_id')->get()->map(function ($query){
                return $query->institute;
            })->sortBy('code');

            return view('nber.examinationpayments.show_rejected_institute_lists', compact('exam', 'institutes'));
        }
    }

    public function showInstituteRejectedDetails($eid, $iid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/examinationpayments/');
        }
        else {
            $institute = Institute::find($iid);

            if(is_null($institute)) {
                return redirect('/nber/examinationpayments/nber/examinationpayments/showverificationstatus/'.$exam->id);
            }
            else {
                $examinationpayments = Examinationpayment::whereHas('examinationfee', function($query) use($exam){
                    $query->where('exam_id', $exam->id)->select('id');
                })->where('institute_id', $institute->id)->where('status_id', 3)
                    ->get(['id','institute_id', 'candidate_id', 'reference_number', 'payment_mode', 'created_at']);

                $institutes = Institute::whereHas('examinationpayments', function($query) use($exam) {
                    $query->whereHas('examinationfee', function($query) use($exam){
                        $query->where('exam_id', $exam->id)->select('id');
                    })->where('status_id', 3)->select('id');
                })->orderBy('code')->get(['id', 'code']);

                return view('nber.examinationpayments.show_institute_rejected_details', compact('exam', 'institute', 'institutes', 'examinationpayments'));
            }
        }
    }
}
