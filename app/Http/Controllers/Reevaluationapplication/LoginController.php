<?php

namespace App\Http\Controllers\Reevaluationapplication;

use App\Application;
use App\Candidate;
use App\Exam;
use App\Paymentbank;
use App\Paymenttype;
use App\Reevaluation;
use App\Reevaluationapplication;
use App\Reevaluationapplicationfee;
use App\Reevaluationapplicationpayment;
use Illuminate\Support\Facades\Mail;
use Session;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mark;
use App\Reevaluationapplicationsubject;
use Illuminate\Support\Facades\Session as FacadesSession;
use Symfony\Component\CssSelector\Node\FunctionNode;

class LoginController extends Controller
{
    //
    public function checkapplicationnumber(Request $request) {
        $rules = [
            'application_number' => 'required|exists:reevaluationapplications,application_number'
        ];

        $messages = [
            'application_number.required' => 'Re-Evaluation Application Number cannot be left blank. Please enter valid Application Number.',
            'application_number.exists' => 'You have entered Invalid Application Number. entered. Please enter valid Application Number.'
        ];

        $validator = validator($request->all(), $rules, $messages);

        $reevaluationapplication = Reevaluationapplication::where('application_number', trim(strtoupper($request->application_number)))->first();

        $validator->after(function ($validator) use ($reevaluationapplication) {
            if(is_null($reevaluationapplication)) {
                $validator->errors()->add('application_number', 'You have entered Invalid Application Number. entered. Please enter valid Application Number.');
            }
        });

        $this->validateWith($validator);

        Session::put('application_number', $reevaluationapplication->application_number);

        return redirect('/reevaluationapplication/login/showdashboard/'.$request->exam_id.'/'.$request->application_number);
    }

    public function showdashboard($eid, $application_number) {
        if(!Session::has('application_number') && Session::get('application_number') != $application_number) {
            return redirect('/reevaluationapplication/home/'.$eid);
        }
        else {
            $title = "Dashboard - Online ReEvaluation Application";
            $reevaluationapplication = Reevaluationapplication::where('application_number', $application_number)->first();

            if (!is_null($reevaluationapplication)) {

                return view('reevaluationapplication.dashboard', compact('title', 'reevaluationapplication', 'reevaluation'));
            }
        }
    }

    public function showsubjectdetailform($eid, $application_number) {
        if(!Session::has('application_number') && Session::get('application_number') != $application_number) {
            return redirect('/reevaluationapplication/home/'.$eid);
        }
        else {
            $title = "Add Subject Details - Online ReEvaluation Application";
            $reevaluationapplication = Reevaluationapplication::where('application_number', $application_number)->first();

            if(!is_null($reevaluationapplication)) {
                if(Reevaluationapplicationsubject::where('reevaluationapplication_id', $reevaluationapplication->id)->count() == 0) {
                    $applications = Application::where('exam_id', $reevaluationapplication->exam->id)->where('candidate_id', $reevaluationapplication->candidate->id)
                        ->whereHas('subject', function($query){
                            $query->where('subjecttype_id', 1);
                        })->where('publish_status', 1)->get();

                    $application_ids = $applications->pluck('id')->unique()->toArray();
                    
                    $marks = Mark::whereIn('application_id', $application_ids)->where('internalresult_id', 1)->where(function($query){
                        $query->where('external', '!=', '')->orWhere('external', '!=', 'Abs');
                    })->get();        

                    return view('reevaluationapplication.showsubjectdetailform', compact('title', 'reevaluationapplication', 'reevaluation', 'marks'));
                }
            }
        }
    }

    public function addsubjectdetail(Request $request) {
        $exam = Exam::find($request->exam_id);
        $reevaluationapplication = Reevaluationapplication::find($request->reevaluationapplication_id);

        if(Reevaluationapplicationsubject::where('exam_id', $reevaluationapplication->exam->id)->where('candidate_id', $reevaluationapplication->candidate_id)->count() == 0) {
            
            $sno = 0;
            foreach ($request->markid_select as $markselect){
                if($markselect == 1) {
                    $mark = Mark::find($request->mark_id[$sno]);

                    Reevaluationapplicationsubject::create([
                        "reevaluationapplication_id" => $reevaluationapplication->id,
                        "exam_id" => $reevaluationapplication->exam->id,
                        "institute_id" => $reevaluationapplication->candidate->approvedprogramme->institute_id,
                        "approvedprogramme_id" => $reevaluationapplication->candidate->approvedprogramme_id,
                        "candidate_id" => $reevaluationapplication->candidate->id,
                        "subject_id" => $mark->subject_id,
                        "application_id" => $mark->application_id,
                        "reevaluation_applystatus" => $request->reevaluation_applystatus[$sno],
                        "retotalling_applystatus" => $request->retotalling_applystatus[$sno],
                        "photocopying_applystatus" => $request->photocopying_applystatus[$sno],
                        "actual_marks" => trim((int) $mark->external+ (int) $mark->grace),
                        "publish_status" => 0,
                        "active_status" => 1
                    ]);
                }
                $sno++;
            }
        }
        return redirect('/reevaluationapplication/login/showdashboard/'.$reevaluationapplication->exam_id.'/'.$reevaluationapplication->application_number);
    }

    public function showpaymentdetailform($eid, $application_number) {
        if(!Session::has('application_number') && Session::get('application_number') != $application_number) {
            return redirect('/reevaluationapplication/home/'.$eid);
        }
        else {
            $title = "Add Payment Details - Online ReEvaluation Application";
            $reevaluationapplication = Reevaluationapplication::where('application_number', $application_number)->first();

            if(!is_null($reevaluationapplication)) {
                if(Reevaluationapplicationpayment::where('reevaluationapplication_id', $reevaluationapplication->id)->count() == 0) {
                    $reevaluation = Reevaluation::where('exam_id', $reevaluationapplication->exam->id)->first();
                    $reevaluationapplicationfee = Reevaluationapplicationfee::where('exam_id', $reevaluationapplication->exam->id)->first();

                    $paymenttypes = Paymenttype::all();
                    $paymentbanks = Paymentbank::orderBy('bankname')->get();

                    return view('reevaluationapplication.showpaymentdetailform', compact('title', 'reevaluationapplication', 'reevaluation', 'reevaluationapplicationfee', 'paymenttypes', 'paymentbanks'));
                }
            }
        }
    }

    public function addpaymentdetail(Request $request) {
        $exam = Exam::find($request->exam_id);
        $reevaluation = Reevaluation::find($request->reevaluation_id);
        $reevaluationapplication = Reevaluationapplication::find($request->reevaluationapplication_id);
        $reevaluationapplicationfee = Reevaluationapplicationfee::find($request->reevaluationapplicationfee_id);
        $candidate = Candidate::find($request->candidate_id);

        if(Reevaluationapplicationpayment::where('exam_id', $exam->id)->where('candidate_id', $reevaluationapplication->candidate_id)->count() == 0) {
            
            $file = $request->file('filename');
            $filename = $reevaluationapplication->application_number.'.'.$file->getClientOriginalExtension();
            $destination = public_path()."/files/payments/reevaluation/";

            $file->move($destination, $filename);

            $reevaluationapplicationpayment = Reevaluationapplicationpayment::create([
                "reevaluationapplication_id" => $reevaluationapplication->id,
                "reevaluationapplicationfee_id" => $reevaluationapplicationfee->id,
                "exam_id" => $exam->id,
                "institute_id" => $candidate->approvedprogramme->institute_id,
                "approvedprogramme_id" => $candidate->approvedprogramme_id,
                "candidate_id" => $candidate->id,
                "paymenttype_id" => $request->paymenttype_id,
                "paymentbank_id" => $request->paymentbank_id,
                'payment_date' => date("Y-m-d", strtotime($request->payment_date)),
                "payment_number" => $request->payment_number,
                "filename" => $filename,
                "payment_remark" => $request->payment_remark,
                "amount_paid" => $request->amount_paid,
                "reference_number" => $reevaluationapplication->application_number,
                'name' => $request->name,
                'designation' => $request->designation,
                'mobilenumber' => $request->mobilenumber,
                'email' => $request->email,
                'status_id' => 6,
            ]);

            $this->sendmobilelogincredentials($exam->id, $reevaluationapplication->contactnumber, $reevaluationapplication->application_number);
            $this->sendemaillogincredentials($exam->id, $reevaluationapplication->email, $reevaluationapplication->application_number);

        }
        return redirect('/reevaluationapplication/login/showdashboard/'.$request->exam_id.'/'.$reevaluationapplication->application_number);

    }

    public function sendmobilelogincredentials($exam_id, $contactnumber, $application_number) {
        $api_key = '25FA4F48782DFA';
        $contacts = trim($contactnumber);
        $from = 'CHNBER';
        $template_id= '1207163196107801871';
        $link = file_get_contents('http://tinyurl.com/api-create.php?url='.'http://examcell.niepmdexaminationsnber.com/reevaluationapplication/home/'.$exam_id);
        $text = "Dear Candidate, Your Re-Evaluation Application (No. ".$application_number.") can be tracked on ".$link.". Regards, NIEPMD-NBER, Chennai.";

        $sms_text = urlencode($text);

        $api_url = "http://sms.godaddysms.com/app/smsapi/index.php?key=".$api_key."&campaign=0&routeid=13&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text."&template_id=".$template_id;

        //Submit to server

        $response = file_get_contents( $api_url);
    }

    public function sendemaillogincredentials($exam_id, $email, $application_number) {
        $data = "";
        try {
            $to_name = "Applicant";
            $to_email = trim($email);

            $data = [
                "link" => file_get_contents('http://tinyurl.com/api-create.php?url='.'http://examcell.niepmdexaminationsnber.com/reevaluationapplication/home/'.$exam_id),
                "application_number" => $application_number
            ];

            Mail::send('reevaluationapplication.sendemaillogincredentials', ['data' => $data], function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('Reference Number - Online Re-Evaluation Application');
                $message->from('niepmd.examinations@gmail.com','NIEPMD-NBER, Chennai');
            });

            $data = 1;
        }catch (\Exception $ex){
            //$data = 2;
            $data = $ex->getMessage();
        }

        //return response()->json($data);
    }

    public function logout($eid){
        Session::forget('application_number');

        return redirect('/reevaluationapplication/home/'.$eid);
    }
}
