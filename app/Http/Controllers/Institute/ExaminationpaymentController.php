<?php

namespace App\Http\Controllers\Institute;

use App\Candidateexaminationpayment;
use App\Incidentalpayment;
use App\Institute;
use App\Application;
use App\Approvedprogramme;
use App\Candidate;
use App\Enrolmentpayment;
use App\Exam;
use App\Exambatch;
use App\Examinationfee;
use App\Examinationpayment;
use App\Order;
use App\Programme;
use App\Paymentbank;
use App\Paymenttype;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Session;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PDF;
use File;
use Auth;
use App\Examfeepayment;

class ExaminationpaymentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function savepayment(Request $r){
        $i = Institute::where('user_id',Auth::user()->id)->first();
        if($r->id==0){
            Examfeepayment::create([
                'exam_id' => 22,
                'nber_id' => $r->nber_id,
                'institute_id' => $i->id,
                'amount' => $r->amount,
                'details' => $r->details
            ]);
        }else{
            $e = Examfeepayment::find($r->id);
            $e->update([
                'amount' => $r->amount,
                'details' => $r->details
            ]);
        }
        Session::put('messages','Updated');
        return back();
    }
    public function index() {
        $institute = Institute::where("user_id", Auth::user()->id)->first();

        //$exam_ids = Application::whereIn("approvedprogramme_id", Approvedprogramme::where("institute_id", $institute->id)->pluck("id")->toArray())
  //          ->groupBy("exam_id")->pluck("exam_id")->toArray();
//
      //  $exams = Exam::whereIn("id", $exam_ids)->orderBy("date", "desc")->get(["id", "name"]);
        $exams = Exam::where('exam_application',1)->get();
        unset($exam_ids);

        return view('institute.examinationpayments.index', compact('institute', 'exams'));
    }

    public function showcourses($eid) {
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        if(is_null($institute)) {
            unset($institute);
            return redirect('/');
        }
        else {
            $exam = Exam::find($eid);

            if (is_null($exam)) {
                return redirect('/');
            } else {
                $approvedprogrammes = Approvedprogramme::select('approvedprogrammes.*')
                    ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
                    ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
                    ->join('applications', 'applications.approvedprogramme_id', '=', 'approvedprogrammes.id')
                    ->where('approvedprogrammes.institute_id', $institute->id)
                    ->where('applications.exam_id', $exam->id)
                //    ->where('programmes.nber_id',1)
                    ->groupBy('approvedprogrammes.id')
                    ->orderBy('programmes.sortorder')
                    ->orderBy('academicyears.year')
                    ->get();

                return view('institute.examinationpayments.showcourses', compact('institute', 'exam', 'approvedprogrammes', 'exambatches'));
            }
        }
    }

    public function paymentDetails($eid){
        $ins = Institute::where('user_id',Auth::user()->id)->first();
        if(is_null($ins)) {
            unset($ins);
            return redirect('/');
        }
        else {
            return view('institute.examinationpayments.paymentdetails', compact('ins'));
        }
    }

    public function showStudents($eid, $apid) {
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        if(is_null($institute)) {
            unset($institute);
            return redirect('/');
        }
        else {
            $exam = Exam::find($eid);

            if (is_null($exam)) {
                return redirect('/');
            }
            else {
                $approvedprogramme = Approvedprogramme::find($apid);
                unset($apid);

                if($approvedprogramme->institute_id == $institute->id) {
                    $candidates = Candidate::whereIn("id", $exam->examappliedcandidateids($exam->id, $approvedprogramme->id))->orderBy("enrolmentno")->get();

                    $allowOfflinePaymentLink = "No";

                    if($exam->id == 20) {
                        $offlinePaymentInstitutes = [];

                        if(in_array($approvedprogramme->institute->code, $offlinePaymentInstitutes)) {
                            $allowOfflinePaymentLink = "Yes";
                        }
                    }

                    return view('institute.examinationpayments.showstudents', compact('institute', 'exam', 'approvedprogramme', 'candidates', 'allowOfflinePaymentLink'));
                }
                else {
                    return redirect('/');
                }
            }
        }
    }

    public function showSampleStudents($eid, $apid) {
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        if(is_null($institute)) {
            unset($institute);
            return redirect('/');
        }
        else {
            $exam = Exam::find($eid);

            if (is_null($exam)) {
                return redirect('/');
            }
            else {
                $approvedprogramme = Approvedprogramme::find($apid);
                unset($apid);

                if($approvedprogramme->institute_id == $institute->id) {
                    $candidates = Candidate::whereIn("id", $exam->examappliedcandidateids($exam->id, $approvedprogramme->id))->orderBy("enrolmentno")->get();

                    return view('institute.examinationpayments.sample', compact('institute', 'exam', 'approvedprogramme', 'candidates'));
                }
                else {
                    return redirect('/');
                }
            }
        }
    }

    public function index1() {
        $institute = Institute::where("user_id", Auth::user()->id)->first();

        $examinationfees = Examinationfee::where('active_status', '1')->get();
        $examinationfee_ids = $examinationfees->pluck('id')->toArray();
        $programme_ids = $examinationfees->pluck('programme_id')->toArray();
        $academicyear_ids = $examinationfees->pluck('academicyear_id')->toArray();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->whereIn('programme_id', $programme_ids)
            ->whereIn('academicyear_id', $academicyear_ids)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();
        $candidate_ids = Candidate::whereIn('approvedprogramme_id', $approvedprogramme_ids)->pluck('id')->toArray();

        $examinationpayments = Examinationpayment::whereIn('examinationfee_id', $examinationfee_ids)
            ->whereIn('candidate_id', $candidate_ids)->groupBy('reference_number')->get();

        return view('institute.examinationpayments.index', compact('institute', 'examinationpayments'));
    }

    public function showexams() {
        $institute = Institute::where("user_id", Auth::user()->id)->first();

        //$exam_ids = Examinationfee::distinct("exam_id")->pluck("exam_id")->toArray();

        //$exams = Exam::whereIn("id", $exam_ids)->orderBy("date", "desc")->get();

        $exams = Exam::orderBy("date", "desc")->get();

        unset($exam_ids);

        return view('institute.examinationpayments.showexams', compact('institute', 'exams'));
    }

    public static function calculatestudentcount($e_id, $i_id) {
        $exam = Exam::find($e_id);

        $approvedprogramme_ids = Approvedprogramme::where("institute_id", $i_id)->pluck("id")->toArray();

        $studentcount = Application::where("exam_id", $exam->id)->whereIn("approvedprogramme_id", $approvedprogramme_ids)->select("candidate_id")->distinct()->get()->count();

        unset($exam);
        unset($approvedprogramme_ids);

        return $studentcount;
    }

    public static function calculatesubjectcount($e_id, $i_id) {
        $exam = Exam::find($e_id);

        $approvedprogramme_ids = Approvedprogramme::where("institute_id", $i_id)->pluck("id")->toArray();

        $subjectcount = Application::where("exam_id", $exam->id)->whereIn("approvedprogramme_id", $approvedprogramme_ids)->count();

        unset($exam);
        unset($approvedprogramme_ids);

        return $subjectcount;
    }

    public static function calculatecandidatesubjectcount($e_id, $c_id) {
        $exam = Exam::find($e_id);

        $subjectcount = Application::where("exam_id", $exam->id)->where("candidate_id", $c_id)->count();

        unset($exam);

        return $subjectcount;
    }

    public static function checkcandidate($eid, $cid) {
        $candidate = Candidate::find($cid);

        $examinationfeeid = Examinationfee::where("exam_id", $eid)->where("programme_id", $candidate->approvedprogramme->programme_id)
            ->where("academicyear_id", $candidate->approvedprogramme->academicyear_id)->first()->id;

        $data = Examinationpayment::where("examinationfee_id", $examinationfeeid)->where("candidate_id", $candidate->id)
            ->count();

        return $data;
    }

    public function selectstudents() {
        $institute = Institute::where("user_id", Auth::user()->id)->first();

        $examinationfees = Examinationfee::where('active_status', '1')->get();
        $examinationfee_ids = $examinationfees->pluck('id')->toArray();
        $programme_ids = $examinationfees->pluck('programme_id')->toArray();
        $academicyear_ids = $examinationfees->pluck('academicyear_id')->toArray();

        $exam_id = $examinationfees->unique('exam_id')->pluck('exam_id')->toArray();
        $currentexam = Exam::whereIn('id', $exam_id)->where('status_id', '1')->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->whereIn('programme_id', $programme_ids)
            ->whereIn('academicyear_id', $academicyear_ids)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();
        $candidate_ids = Candidate::whereIn('approvedprogramme_id', $approvedprogramme_ids)->pluck('id')->toArray();

        $applications = Application::whereIn('exam_id', $exam_id)->whereIn('candidate_id', $candidate_ids)->get();
        $applied_candidateids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();

        $candidates = Candidate::whereIn('id', $applied_candidateids)->orderBy('enrolmentno')->get();

        $examinationpayments = Examinationpayment::whereIn('examinationfee_id', $examinationfee_ids)->get();

        echo $examinationpayments;

        return view('institute.examinationpayments.selectstudents', compact('institute', 'examinationfees', 'applications', 'candidates', 'examinationpayments', 'currentexam'));
    }

    public function checkselectedstudents(Request $request) {
        $rules = [
            "payment_date" => "required",
        ];

        $messages = [
            "payment_date.required" => "Please select the Date of Enrolment Payment made"
        ];

        $validator = validator($request->all(), $rules, $messages);

        $validator->after(function ($validator) use($request){
            if(!$request->has('candidate_id')) {
                $validator->errors()->add('', 'Please select student(s) for enrolment payment');
            }
        });

        $this->validateWith($validator);

        //$candidate_ids = Candidate::whereIn('id', $request->candidate_id)->pluck('id')->toArray();
        $candidate_ids = serialize($request->candidate_id);

        return redirect('/institute/examinationpayments/addpayment/'.$request->exam_id.'/'.$request->payment_date.'/'.$candidate_ids);
    }

    public function addpayment($eid, $cid) {
        $exam = Exam::find($eid);

        if(!is_null($exam)) {
            $candidate = Candidate::find($cid);
            $examinationfee = Examinationfee::where('exam_id', $exam->id)->where('programme_id', $candidate->approvedprogramme->programme_id)
                ->where('academicyear_id', $candidate->approvedprogramme->academicyear_id)->first();

            if(!is_null($examinationfee)) {
                if(!is_null($candidate)) {
                    if(Application::where('exam_id', $exam->id)->where('candidate_id', $candidate->id)->count() > 0) {
                        $applications = Application::with('subject')->where('exam_id', $exam->id)
                            ->whereIn('payment_status', ['Not Entered', 'Rejected'])
                            ->where('candidate_id', $candidate->id)->get()
                            ->sortBy('subject.sortorder')
                            ->sortBy('subject.subjecttype_id');

                        if($applications->count() > 0) {
                            $institute = Institute::find($candidate->approvedprogramme->institute->id);

                            $paymenttypes = Paymenttype::all();
                            $paymentbanks = Paymentbank::orderBy('bankname')->get();

                            return view('institute.examinationpayments.addpaymentform', compact('institute', 'candidate', 'exam', 'paymenttypes', 'paymentbanks', 'applications', 'examinationfee'));
                        }
                        else {
                            return redirect('/institute/examinationpayments/showstudents/'.$exam->id.'/'.$candidate->approvedprogramme_id);
                        }
                    }
                    else {
                        return redirect('/institute/examinationpayments/showcourses/'.$exam->id);
                    }
                }
                else {
                    return redirect('/institute/examinationpayments/showcourses/'.$exam->id);
                }
            }
            else {
                return redirect('/institute/examinationpayments');
            }
        }
        else {
            return redirect('/institute/examinationpayments');
        }

        /*
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $exam = Exam::where('id', $eid)->first();

        $candidate = Candidate::find($cid);

        $applications = Application::where('exam_id', $exam->id)->where('candidate_id', $candidate->id)->get();

        $paymenttypes = Paymenttype::all();
        $paymentbanks = Paymentbank::orderBy('bankname')->get();

        $examinationfee = Examinationfee::where("exam_id", $eid)->where("programme_id", $candidate->approvedprogramme->programme_id)
            ->where("academicyear_id", $candidate->approvedprogramme->academicyear_id)->first();

        return view('institute.examinationpayments.addpaymentform', compact('institute', 'candidate', 'exam', 'paymenttypes', 'paymentbanks', 'applications', 'examinationfee'));
        */
    }

    public function oldaddpayment($exam_id, $payment_date, $cids) {
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $candidate_ids = unserialize($cids);

        $examinationfees = Examinationfee::where('active_status', '1')->get();

        $currentexam = Exam::where('id', $exam_id)->first();

        $applications = Application::whereIn('exam_id', $currentexam)->whereIn('candidate_id', $candidate_ids)->get();
        $candidates = Candidate::whereIn('id', $candidate_ids)->get();

        $applied_candidateids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();

        /*
        $enrolmentfee_ids = $enrolmentfees->pluck('id')->toArray();
        $enrolmentpayments = Enrolmentpayment::whereIn('enrolmentfee_id', $enrolmentfee_ids)->get();
        */

        $paymenttypes = Paymenttype::all();
        $paymentbanks = Paymentbank::orderBy('bankname')->get();

        return view('institute.examinationpayments.create', compact('institute', 'currentexam', 'payment_date',
            'candidates', 'examinationfees', 'paymenttypes', 'paymentbanks', 'applications'));
    }

    public function checkpayment(Request $request){
        $candidate = Candidate::where('id', $request->candidate_id)->first();
        $institute = Institute::where('user_id', Auth::user()->id)->first();
        $currentexam = Exam::where('id', $request->exam_id)->first();

        $count = Examinationpayment::where('reference_number', 'like', "EXP".$currentexam->date->format('mY').$institute->code."C".'%')->count();
        $count++;

        $file = $request->file('filename');
        $reference_number = "EXP".$currentexam->date->format('mY').$institute->code."C".str_pad($count, 3, '0', STR_PAD_LEFT);
        $filename = $reference_number.'.'.$file->getClientOriginalExtension();
        $destination = public_path()."/files/payments/examination/";

        $file->move($destination, $filename);

        $examinationfee = Examinationfee::find($request->examinationfee_id);
        $latefee_remark = "Yes";

        if(!is_null($examinationfee)) {
            if(date("Y-m-d", strtotime($request->payment_date)) <= $examinationfee->ontimepayment_enddate) {
                $latefee_remark = "No";
            }

            $examinationpayment = Examinationpayment::create([
                "examinationfee_id" => $examinationfee->id,
                "institute_id" => $institute->id,
                "candidate_id" => $candidate->id,
                "order_id" => 1,
                "payment_mode" => "Offline",
                "latefee_remark" => $latefee_remark,
                "paymenttype_id" => $request->paymenttype_id,
                "paymentbank_id" => $request->paymentbank_id,
                'payment_date' => date("Y-m-d", strtotime($request->payment_date)),
                "payment_number" => $request->payment_number,
                "filename" => $filename,
                "payment_remark" => $request->payment_remark,
                "amount_paid" => $request->amount_paid,
                "reference_number" => $reference_number,
                'name' => $request->name,
                'designation' => $request->designation,
                'mobilenumber' => $request->mobilenumber,
                'email' => $request->email,
                'status_id' => 6,
            ]);

            foreach ($request->application_ids as $application_id) {
                $candidateexaminationpayment = Candidateexaminationpayment::where('examinationpayment_id', $examinationpayment->id)
                    ->where('application_id', $application_id)
                    ->first();

                if(is_null($candidateexaminationpayment)) {
                    Candidateexaminationpayment::create([
                        "examinationpayment_id" => $examinationpayment->id,
                        "application_id" => $application_id,
                        "fee" => $examinationfee->exam_fee,
                        "status_id" => 6,
                    ]);
                }
            }
        }

        return redirect('/institute/examinationpayments/showstudents/'.$currentexam->id.'/'.$candidate->approvedprogramme_id);
    }

    public function viewstudentreceipt($eid, $cid) {
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        if(is_null($institute)) {
            unset($institute);
            return redirect('/');
        }
        else {
            $exam = Exam::find($eid);

            if (is_null($exam)) {
                return redirect('/');
            }
            else {
                $candidate = Candidate::find($cid);
                unset($cid);

                if($candidate->approvedprogramme->institute_id == $institute->id) {
                    $examinationfee_id = Examinationfee::where("exam_id", $eid)->where("programme_id", $candidate->approvedprogramme->programme_id)
                        ->where("academicyear_id", $candidate->approvedprogramme->academicyear_id)->first()->id;

                    $examinationpayments = Examinationpayment::where("examinationfee_id", $examinationfee_id)->where("candidate_id", $candidate->id)->get();
                    return view('institute.examinationpayments.viewstudentreceipt', compact('institute', 'exam', 'examinationpayments', 'candidate'));
                }
                else {
                    return redirect('/');
                }
            }
        }
    }

    public function downloadstudentreceipt($expid) {
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $examinationpayment = Examinationpayment::find($expid);

        return view('institute.examinationpayments.downloadstudentreceipt', compact('institute', 'examinationpayment'));
    }

    public function olddownloadreceipt($exam_id, $reference_number) {
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $examinationpayments = Examinationpayment::where('reference_number', $reference_number)->get();
        $common = $examinationpayments->where('reference_number', $reference_number)->first();
        $candidate_ids = $examinationpayments->pluck('candidate_id')->toArray();
        $currentexam = Exam::where('id', $exam_id)->first();

        $applications = Application::where('exam_id', $exam_id)->whereIn('candidate_id', $candidate_ids)->get();

        return view('institute.examinationpayments.download', compact('institute', 'examinationpayments', 'common', 'currentexam', 'applications'));
    }

    public function showexamcourselist($e_id, $iid) {
        $exam = Exam::find($e_id);
        unset($e_id);

        $approvedprogrammes = Approvedprogramme::where("institute_id", $iid)->get();

        $approvedprogramme_ids = $approvedprogrammes->pluck("id")->toArray();

        $candidate_ids = Application::where("exam_id", $exam->id)->whereIn("approvedprogramme_id", $approvedprogramme_ids)->pluck("candidate_id")->toArray();
        $candidates = Candidate::whereIn("id", $candidate_ids)->orderBy("enrolmentno")->groupBy("id")->get();

        return view('institute.examinationpayments.new.showstudentlist', compact('exam', 'candidates'));
    }

    public function showOnlinePaymentForm($exid, $cid) {
        $exam = Exam::find($exid);

        if(!is_null($exam)) {
            $candidate = Candidate::find($cid);
            $examinationfee_id = Examinationfee::where('exam_id', $exam->id)->where('programme_id', $candidate->approvedprogramme->programme_id)
                ->where('academicyear_id', $candidate->approvedprogramme->academicyear_id)->first()->id;

            if(!is_null($examinationfee_id)) {
                if(!is_null($candidate)) {
                    if(Application::where('exam_id', $exam->id)->where('candidate_id', $candidate->id)->count() > 0) {
                        $applications = Application::with('subject')->where('exam_id', $exam->id)
                            ->whereIn('payment_status', ['Not Entered', 'Rejected','Verification Pending'])
                            ->where('candidate_id', $candidate->id)->get()
                            ->sortBy('subject.sortorder')
                            ->sortBy('subject.subjecttype_id');
                        if($applications->count() > 0) {
                            $billing_notes = $exam->name." Examination Fee of ".$candidate->name."(".$candidate->enrolmentno.")";

                            $order_number = "EXP".$candidate->approvedprogramme->institute->code."OR".date('Ymdhis').$this->generateRandomString().rand(1000, 9999);

                            return view('institute.examinationpayments.show_online_payment_form', compact('exam', 'candidate', 'examinationfee_id', 'applications', 'billing_notes', 'order_number'));
                        }
                        else {
                            Session::put('error','Already Paid');
                           return redirect('/institute/examinationpayments/showstudents/'.$exam->id.'/'.$candidate->approvedprogramme_id);
                        }
                    }
                    else {
                        return redirect('/institute/examinationpayments/showcourses/'.$exam->id);
                    }
                }
                else {
                    return redirect('/institute/examinationpayments/showcourses/'.$exam->id);
                }
            }
            else {
                return redirect('/institute/examinationpayments');
            }
        }
        else {
            return redirect('/institute/examinationpayments');
        }
    }

    public function generateRandomString() {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 2; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function ccavenuePaymentGatewayRequestHandler(Request $request) {
        $data = $request->except('_token');

        $merchant_id = 692568;

        // merchant_param1 = ExamId,ExaminationfeeId,InstituteId,CandidateId
        $merchant_param1 = $request->exam_id . ',' . $request->examinationfee_id . ',' . $request->institute_id . ',' . $request->candidate_id;

        $data += ['redirect_url' => 'https://examcell.niepmdexaminationsnber.com/institute/examinationpayments/ccavenuepaymentgatewayresponsehandler'];
      //  $data += ['redirect_url' => 'https://examcell.niepmdexaminationsnber.com/ccav/ccavResponseHandler.php'];
        $data += ['cancel_url' => 'https://examcell.niepmdexaminationsnber.com/institute/examinationpayments/ccavenuepaymentgatewayfailpage'];
  //      $data += ['redirect_url' => 'https://rcinber.org.in/institute/examinationpayments/ccavenuepaymentgatewayresponsehandler/'];
//        $data += ['cancel_url' => 'https://rcinber.org.in//institute/examinationpayments/ccavenuepaymentgatewayfailpage'];
       
       $data += ['currency' => 'INR'];
        $data += ['merchant_id' => $merchant_id];
        $data += ['merchant_param1' => $merchant_param1];
        $data += ['merchant_param2' => 'Examination Fee'];

        $order = Order::where('order_number', $data['order_number'])->first();

        if (is_null($order)) {
            $order = Order::create([
                "order_number" => $data["order_number"],
                "ccavenue_referencenumber" => null,
                "bank_referencenumber" => null,
                "order_status" => "Initiated",
                "status_message" => null,
                "total_amount" => $data["amount"],
                "actual_amount" => $data["amount"],
                "transaction_fee" => 0.00,
                "service_fee" => 0.00,
                "payment_date" => date("Y-m-d"),
                "payment_remarks" => $data["merchant_param2"],
                "transaction_remarks" => $data["billing_notes"],
                "reference_parameters" => $data["merchant_param1"],
            ]);
        }

        $examinationpayment = Examinationpayment::where('examinationfee_id', $data["examinationfee_id"])->where('institute_id', $data["institute_id"])->where('candidate_id', $data["candidate_id"])->where('order_id', $order->id)->first();

        if (is_null($examinationpayment)) {
            $examinationpayment = Examinationpayment::create([
                "examinationfee_id" => $data["examinationfee_id"],
                "institute_id" => $data["institute_id"],
                "candidate_id" => $data["candidate_id"],
                "order_id" => $order->id,
                "payment_mode" => "Online",
                "paymenttype_id" => "4",
                "paymentbank_id" => "225",
                "payment_date" => $order->payment_date,
                "payment_number" => $order->order_number,
                "status_id" => 6,
                'reference_number' => $order->order_number,
                'amount_paid' => $order->actual_amount,
                'name' => $data["billing_name"],
                'designation' => $data["billing_address"],
                'mobilenumber' => $data["billing_tel"],
                'email' => $data["billing_email"],
            ]);
        }

        foreach ($request->application_ids as $application_id) {
            $candidateexaminationpayment = Candidateexaminationpayment::where('examinationpayment_id', $examinationpayment->id)
                ->where('application_id', $application_id)->first();

            if(is_null($candidateexaminationpayment)) {
                $candidateexaminationpayment = Candidateexaminationpayment::create([
                    "examinationpayment_id" => $examinationpayment->id,
                    "application_id" => $application_id,
                    "fee" => $examinationpayment->examinationfee->exam_fee,
                    "status_id" => 6,
                ]);

                $application = Application::find($candidateexaminationpayment->application_id);

                $application->update(["payment_status" => "Verification Pending"]);
            }
        }

        return view('institute.examinationpayments.paymentgateway_request_handler', compact('data', 'merchant_id', 'merchant_param1'));
    }

    public function ccavenuePaymentGatewayResponseHandler(Request $request) {
      //  return $_POST["encResp"];		
      //  set_time_limit(0);

        require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';

        error_reporting(0);

        $workingKey='8D29080EBDBF0C2E451319B1183A12EF';		//Working Key should be provided here.
        $order = null;

        if(count($request->all() > 0)) {
          //  if($request->has('encResp')) {
                $encResponse=$request->encResp;	
                $encResponse = $_POST["encResp"];		//This is the response sent by the CCAvenue Server
                $rcvdString=payment_decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.

                $decryptValues=explode('&', $rcvdString);
                $dataSize=sizeof($decryptValues);
                $total_amount = 0;

                for($i = 0; $i < $dataSize; $i++) {
                    $information=explode('=',$decryptValues[$i]);

                    if($i == 0) {
                        $order = Order::where('order_number', $information[1])->first();
                    }

                    if(!is_null($order)) {
                        if($i == 1) {
                            $order->update(["ccavenue_referencenumber" => $information[1]]);
                        }
                        if($i == 2) {
                            $order->update(["bank_referencenumber" => $information[1]]);
                        }
                        if($i == 3) {
                            $order->update(["order_status" => $information[1]]);

                            $examinationpayment = Examinationpayment::where('order_id', $order->id)->first();

                            if(!is_null($examinationpayment)) {
                                $examinationpayment->update([
                                    "user_id" => 22946, // UserId of accountadmin
                                    "verified_on" => date("Y-m-d"),
                                ]);

                                if(strtolower($order->order_status) == "shipped" || strtolower($order->order_status) == "success") {
                                    $examinationpayment->update([
                                        "status_id" => 2, // 2 - Approved Status
                                        "verify_remarks" => "Approved",
                                    ]);
                                }
                                if(strtolower($order->order_status) == "aborted" || strtolower($order->order_status) == "unsuccess" || strtolower($order->order_status) == "unsuccessful" || strtolower($order->order_status) == "failure") {
                                    $examinationpayment->update([
                                        "status_id" => 3, // 3 - Rejected Status
                                        "verify_remarks" => "Transaction Failed",
                                    ]);
                                }

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
                        }
                        if($i == 8) {
                            $order->update(["status_message" => $information[1]]);
                        }
                        if($i == 10) {
                            $order->update(["actual_amount" => $information[1]]);
                            $total_amount += $information[1];
                        }
                        if($i == 40) {
                            // if (isset($information[1]) && !is_null($information[1]) && !empty($information[1]) && !is_bool($information[1])) {
                            //     $order->update(["payment_date" => \DateTime::createFromFormat('d/m/Y H:i:s', $information[1])->format('Y-m-d H:i:s')]);
                            // }
                            $order->update(["payment_date" => date("Y-m-d H:i:s")]);
                        }
                        if($i == 42) {
                            $order->update(["transaction_fee" => $information[1]]);
                            $total_amount += $information[1];
                        }
                        if($i == 43) {
                            $order->update(["service_fee" => $information[1]]);
                            $total_amount += $information[1];
                            $order->update(["total_amount" => $total_amount]);
                        }
                    }

                }

                if(!is_null($order)) {
                    return redirect('/institute/examinationpayments/ccavenuepaymentgatewaypaymentstatus/'.$order->order_number);
                }
                else {
                    return redirect('/institute/examinationpayments/');
                }
           // }
            //else {
             //   return redirect('/institute/examinationpayments/');
           // }
        }
        else {
            return redirect('/institute/examinationpayments/');
        }

        /*
        $workingKey='8D29080EBDBF0C2E451319B1183A12EF';		//Working Key should be provided here.
        $encResponse=$request->encResp;			//This is the response sent by the CCAvenue Server
        $rcvdString=payment_decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.

        $decryptValues=explode('&', $rcvdString);
        $dataSize=sizeof($decryptValues);
        $total_amount = 0;

        for($i = 0; $i < $dataSize; $i++) {
            $information=explode('=',$decryptValues[$i]);

            if($i == 0) {
                $order = Order::where('order_number', $information[1])->first();
            }
            if($i == 1) {
                if(!is_null($order)) {
                    $order->update(["ccavenue_referencenumber" => $information[1]]);
                }
            }
            if($i == 2) {
                if(!is_null($order)) {
                    $order->update(["bank_referencenumber" => $information[1]]);
                }
            }
            if($i == 3) {
                if(!is_null($order)) {
                    $order->update(["order_status" => $information[1]]);
                }
            }
            if($i == 8) {
                if(!is_null($order)) {
                    $order->update(["status_message" => $information[1]]);
                }
            }
            if($i == 10) {
                if(!is_null($order)) {
                    $order->update(["actual_amount" => $information[1]]);
                    $total_amount += $information[1];
                }
            }
            if($i == 40) {
                if(!is_null($order)) {
                    $order->update(["payment_date" => \DateTime::createFromFormat('d/m/Y H:i:s', $information[1])->format('Y-m-d H:i:s')]);
                }
            }
            if($i == 42) {
                if(!is_null($order)) {
                    $order->update(["transaction_fee" => $information[1]]);
                    $total_amount += $information[1];
                }
            }
            if($i == 43) {
                if(!is_null($order)) {
                    $order->update(["service_fee" => $information[1]]);
                    $total_amount += $information[1];
                }
            }
        }

       if(is_null($order)) {
           return redirect('/institute/examinationpayments/');
       }
       else {
           return redirect('/institute/examinationpayments/ccavenuepaymentgatewaypaymentstatus/'.$order->order_number);
       }
        */
    }

    public function ccavenuePaymentGatewayPaymentStatus($order_num) {
        $order = Order::where('order_number', $order_num)->first();

        $order_data = explode(',', $order->reference_parameters);

        $exam_id = $order_data[0];

        $exam = Exam::find($exam_id);

        return view('institute.examinationpayments.payment_status', compact('order', 'exam'));
    }

    public function ccavenuePaymentGatewayFailPage(Request $request) {
        set_time_limit(0);
        error_reporting(0);

        return redirect('/institute/examinationpayments');
    }

    public function viewStudentPaymentDetails($eid, $cid) {
        $exam = Exam::find($eid);

        if (!is_null($exam)) {
           $candidate = Candidate::find($cid);

           if(!is_null($candidate)) {
               $examinationfee_id = Examinationfee::where('exam_id', $exam->id)->where('programme_id', $candidate->approvedprogramme->programme_id)
                   ->where('academicyear_id', $candidate->approvedprogramme->academicyear_id)->first()->id;

                $examinationpayments = Examinationpayment::where('examinationfee_id', $examinationfee_id)->where('candidate_id', $candidate->id)->get();

                if($examinationpayments->count() > 0) {
                    return view('institute.examinationpayments.view_student_payment_details', compact('exam', 'candidate', 'examinationpayments'));
                }
                else {
                    return redirect('/institute/examinationpayments/showstudents/'.$exam->id.'/'.$candidate->approvedprogramme_id);
                }
           }
           else {
               return redirect('/institute/examinationpayments/showcourses/'.$exam->id);
           }
        }
        else {
            return redirect('/institute/examinationpayments');
        }
    }
}
