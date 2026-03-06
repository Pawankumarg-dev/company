<?php

namespace App\Http\Controllers\Reevaluationapplication;

use App\Application;
use App\Candidate;
use App\Candidateexamresultdate;
use App\Exam;
use App\Examresultdate;
use App\Mark;
use App\Paymentbank;
use App\Paymenttype;
use App\Practicalexam;
use App\Practicalexamfeedetail;
use App\Practicalexaminer;
use App\Reevaluation;
use App\Reevaluationapplication;
use App\Reevaluationapplicationfee;
use App\Reevaluationapplicationpayment;
use App\Reevaluationapplicationsubject;
use App\Withheld;
use Session;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Currentapplication;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    //
    public function showhomepage($eid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/reevaluationapplication/error');
        }
        else {
            if($exam->reevaluation_status == 1) {
                $title = $exam->name." - Online Re-Evaluation Application";
                $reevaluation = Reevaluation::where('exam_id', $exam->id)->first();
                return view('reevaluationapplication.home', compact('title', 'exam', 'reevaluation'));
            }
            else {
                return redirect('/reevaluationapplication/error');
            }
        }
    }

    public function showerrorpage() {
        echo "Error";
    }

    public function showcandidateconfirmpage($eid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/reevaluationapplication/error');
        }
        else {
            if($exam->reevaluation_status == 1) {
                $title = " New Online Re-Evaluation Application  - ".$exam->name." Examinations";
                return view('reevaluationapplication.confirmcandidate', compact('title', 'exam'));
            }
            else {
                return redirect('/reevaluationapplication/error');
            }
        }
    }

    public function checkcandidatedetail(Request $request) {
        $rules = [
            'enrolmentno' => 'required|numeric|exists:candidates,enrolmentno'
        ];

        $messages = [
            'enrolmentno.required' => 'Enrolment Number cannot be left blank. Please enter valid Enrolment Number.',
            'enrolmentno.exists' => 'You have entered Invalid Enrolment Number. entered. Please enter valid Enrolment Number.'
        ];

        $validator = validator($request->all(), $rules, $messages);

        $candidate = Candidate::where('enrolmentno', trim($request->enrolmentno))->first();

        $validator->after(function ($validator) use ($request, $candidate) {
            if(!is_null($candidate)) {
             //   $candidateexamresultdate = Candidateexamresultdate::where('exam_id', $request->exam_id)->where('candidate_id', $candidate->id)->first();

               // if(!is_null($candidateexamresultdate)) {
                 //   if($candidateexamresultdate->withheld_status === 1 || $candidateexamresultdate->underreview_status === 1) {
                      //  $validator->errors()->add('enrolmentno', 'Re-Evaluation - NOT APPLICABLE');
                   // }
                   // else {
                       // if($candidateexamresultdate->publish_status === 1 && !is_null($candidateexamresultdate->publish_date)) {
                            if(Reevaluationapplication::where('exam_id', $request->exam_id)->where('candidate_id', $candidate->id)->count() > 0) {
                                $validator->errors()->add('enrolmentno', 'You have already applied Re-Evaluation. Please try to login with your Re-Evaluation Application Number.');
                            }
                            else {
                                $applications = Currentapplication::where('exam_id', $request->exam_id)->where('candidate_id', $candidate->id)
                                    ->whereHas('subject', function($query){
                                        $query->where('subjecttype_id', 1);
                                    })->where('publish_status', 1)->get();

                                if(is_null($applications)) {
                                    $validator->errors()->add('enrolmentno', 'No Theory Paper(s) applied.');
                                }
                                else {
                                    $applicationcount = $applications->count();
                                    $failcount = 0;
                                    $markcount = 0;
                                    foreach($applications as $application) {
                                        $marks = Mark::where('application_id', $application->id)->get();
                                        foreach ($marks as $mark) {
                                            $markcount++;
                                            if($mark->internalresult_id != '1' || $mark->external == 'Abs' || $mark->external == "") {
                                                $failcount++;
                                            }
                                        }
                                    }

                                    if($markcount > $applicationcount) {
                                        $validator->errors()->add('enrolmentno', 'Please contact NIEPMD-NBER');
                                    }
                                    else {
                                        if($failcount == 0) {

                                        }
                                        else {
                                            if($applicationcount == $failcount) {
                                               // $validator->errors()->add('enrolmentno', 'Re-Evaluation - NOT APPLICABLE');
                                            }
                                            elseif ($applicationcount < $failcount) {
                                                $validator->errors()->add('enrolmentno', 'Please contact NIEPMD-NBER');
                                            }
                                            else {

                                            }
                                        }
                                    }
                                }
                            }
                      //  }
                      //  else {
                       //     $validator->errors()->add('enrolmentno', 'Exam Results Not Published');
                       // }
                    //}
                //}
                //else {
                //    $validator->errors()->add('enrolmentno', 'Exam Results Not Published');
                //}

                /*
                $withheld = Withheld::where('exam_id', $request->exam_id)->where('candidate_id', $candidate->id)->where('status', 1)->first();

                if(!is_null($withheld)) {
                    $validator->errors()->add('enrolmentno', 'Re-Evaluation - NOT APPLICABLE');
                }
                else {
                    if(Reevaluationapplication::where('exam_id', $request->exam_id)->where('candidate_id', $candidate->id)->count() > 0) {
                        $validator->errors()->add('enrolmentno', 'You have already applied Re-Evaluation');
                    }
                    else {
                        $applications = Application::where('exam_id', $request->exam_id)->where('candidate_id', $candidate->id)
                            ->whereHas('subject', function($query){
                                $query->where('subjecttype_id', 1);
                            })->where('publish_status', 1)->get();

                        if(is_null($applications)) {
                            $validator->errors()->add('enrolmentno', 'No Theory Paper(s) applied.');
                        }
                        else {
                            $applicationcount = $applications->count();
                            $failcount = 0;
                            $markcount = 0;
                            foreach($applications as $application) {
                                $marks = Mark::where('application_id', $application->id)->get();
                                foreach ($marks as $mark) {
                                    $markcount++;
                                    if($mark->internalresult_id != '1' || $mark->external == 'Abs' || $mark->external == "") {
                                        $failcount++;
                                    }
                                }
                            }

                            if($markcount > $applicationcount) {
                                $validator->errors()->add('enrolmentno', 'Please contact NIEPMD-NBER');
                            }
                            else {
                                if($failcount == 0) {

                                }
                                else {
                                    if($applicationcount == $failcount) {
                                        $validator->errors()->add('enrolmentno', 'Re-Evaluation - NOT APPLICABLE');
                                    }
                                    elseif ($applicationcount < $failcount) {
                                        $validator->errors()->add('enrolmentno', 'Please contact NIEPMD-NBER');
                                    }
                                    else {

                                    }
                                }
                            }
                        }
                    }
                }
                */
            }
            else {
                $validator->errors()->add('enrolmentno', 'Please check your Enrolment No.');
            }
        });

        $this->validateWith($validator);

        Session::put('candidateid', $candidate->id);

        return redirect('/reevaluationapplication/newapplicationform/'.$request->exam_id.'/'.$candidate->id);
    }

    public function newapplicationform($eid, $cid) {
        if(Session::has('candidateid') && Session::get('candidateid') != $cid) {
            return redirect('/reevaluationapplication/home/'.$eid);
        }
        else {
            $exam = Exam::find($eid);

            if(is_null($exam)) {
                return redirect('/reevaluationapplication/error');
            }
            else {
                if($exam->reevaluation_status == 1) {
                    $title = " Online Re-Evaluation Application  - ".$exam->name." Examinations";
                    $candidate = Candidate::find($cid);

                    $applications = Currentapplication::where('exam_id', $exam->id)->where('candidate_id', $candidate->id)
                        ->whereHas('subject', function($query){
                            $query->where('subjecttype_id', 1);
                        })->get();

                    $application_ids = $applications->pluck('id')->unique()->toArray();

                    $reevaluation = Reevaluation::where('exam_id', $exam->id)->first();

                    $reevaluationapplicationfee = Reevaluationapplicationfee::where('exam_id', $exam->id)->first();

                    $paymenttypes = Paymenttype::all();
                    $paymentbanks = Paymentbank::orderBy('bankname')->get();

                    $marks = Mark::whereIn('application_id', $application_ids)->where('internalresult_id', 1)->where(function($query){
                        $query->where('external', '!=', '')->orWhere('external', '!=', 'Abs');
                    })->get();
                    $marks = Currentapplication::where('exam_id', $exam->id)->where('candidate_id', $candidate->id)
                    ->whereHas('subject', function($query){
                        $query->where('subjecttype_id', 1);
                    })->get();

                    return view('reevaluationapplication.newapplicationform', compact('title', 'exam', 'candidate', 'marks', 'paymenttypes', 'paymentbanks', 'reevaluationapplicationfee', 'reevaluation'));
                }
                else {
                    return redirect('/reevaluationapplication/error');
                }
            }
        }
    }

    public function sendmobileverificationcode(Request $request) {
        $api_key = '25FA4F48782DFA';
        $contacts = trim($_POST["mobilenumber"]);
        $from = 'CHNBER';
        $template_id = '1207163196088903761';
        $verificationcode = $_POST["verificationcode"];
        $sms_text = urlencode($verificationcode.' is the OTP generated for verification of mobile number. Regards, NIEPMD-NBER, Chennai.');

        $api_url = "http://sms.godaddysms.com/app/smsapi/index.php?key=" . $api_key . "&campaign=0&routeid=13&type=text&contacts=" . $contacts . "&senderid=" . $from . "&msg=" . $sms_text . "&template_id=" . $template_id;

//Submit to server

        $response = file_get_contents($api_url);

        echo json_encode($response);
        exit;
    }

    public function sendemailverificationcode(Request $request) {
        $data = "";
        try {
            $verificationcode = trim($request->verificationcode);
            $to_name = "Applicant";
            $to_email = trim($request->email);

            Mail::send('reevaluationapplication.sendemailverificationcode', ['verificationcode' => $verificationcode], function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('Email Verification Code - Online Re-Evaluation Application');
                $message->from('niepmd.examinations@gmail.com','NIEPMD-NBER, Chennai');
            });

            $data = 1;
        }catch (\Exception $ex){
            //$data = 2;
            $data = $ex->getMessage();
        }

        echo $data;

        //return response()->json($data);
    }

    public function addapplication(Request $request) {
        $exam = Exam::find($request->exam_id);
        $reevaluation = Reevaluation::find($request->reevaluation_id);
        $reevaluationapplicationfee = Reevaluationapplicationfee::find($request->reevaluationapplicationfee_id);
        $candidate = Candidate::find($request->candidate_id);

        if(Reevaluationapplication::where('exam_id', $exam->id)->where('candidate_id', $candidate->id)->count() == 0) {
            $count = Reevaluationapplication::where('exam_id', $exam->id)->count();
            $count++;

            $application_number = $exam->id."REVAPPN".str_pad($count, 4, '0', STR_PAD_LEFT);

            $reevaluationapplication = Reevaluationapplication::create([
                "application_number" => $application_number,
                "reevaluation_id" => $reevaluation->id,
                "exam_id" => $exam->id,
                "institute_id" => $candidate->approvedprogramme->institute_id,
                "approvedprogramme_id" => $candidate->approvedprogramme_id,
                "candidate_id" => $candidate->id,
                "contactnumber" => trim($request->applicant_mobilenumber),
                "email" => trim($request->applicant_email),
                "status_id" => 6,
                "active_status" => 1
            ]);

            $reevaluation->update([
                "application_count" => $count
            ]);

            $sno = 0;
            foreach ($request->markid_select as $markselect){
                if($markselect == 1) {
                    $mark = Mark::find($request->mark_id[$sno]);

                    Reevaluationapplicationsubject::create([
                        "reevaluationapplication_id" => $reevaluationapplication->id,
                        "exam_id" => $exam->id,
                        "institute_id" => $candidate->approvedprogramme->institute_id,
                        "approvedprogramme_id" => $candidate->approvedprogramme_id,
                        "candidate_id" => $candidate->id,
                        "subject_id" => $mark->subject_id,
                        "application_id" => $mark->application_id,
                        "reevaluation_applystatus" => $request->reevaluation_applystatus[$sno],
                        "retotalling_applystatus" => $request->retotalling_applystatus[$sno],
                        "photocopying_applystatus" => $request->photocopying_applystatus[$sno],
                        "actual_marks" => $mark->external,
                        "publish_status" => 0,
                        "active_status" => 1
                    ]);
                }
                $sno++;
            }

            $file = $request->file('filename');
            $filename = $application_number.'.'.$file->getClientOriginalExtension();
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
                "reference_number" => $application_number,
                'name' => $request->name,
                'designation' => $request->designation,
                'mobilenumber' => $request->mobilenumber,
                'email' => $request->email,
                'status_id' => 6,
            ]);

            $this->sendmobilelogincredentials($exam->id, $reevaluationapplication->contactnumber, $application_number);
            $this->sendemaillogincredentials($exam->id, $reevaluationapplication->email, $application_number);
        }
        else {
            return redirect('/reevaluationapplication/home/'.$exam->id);
        }

        Session::flush();

        return redirect('/reevaluationapplication/displayapplicationnumber/'.$exam->id.'/'.$candidate->id);
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

    public function displayapplicationnumber($eid, $cid) {
        $title = "Online ReEvaluation Application";
        $exam = Exam::find($eid);
        $candidate = Candidate::find($cid);

        $reevaluationapplication = Reevaluationapplication::where('exam_id', $exam->id)->where('candidate_id', $candidate->id)->first();

        if(!is_null($reevaluationapplication)) {
            $reevaluationapplicationpayment = Reevaluationapplicationpayment::where('reevaluationapplication_id', $reevaluationapplication->id)->get();
            $reevaluationapplicationsubjects = Reevaluationapplicationsubject::where('reevaluationapplication_id', $reevaluationapplication->id)->get();
            return view('reevaluationapplication.displayapplicationnumber', compact('exam', 'candidate', 'reevaluationapplication', 'title', 'reevaluationapplicationpayment', 'reevaluationapplicationsubjects'));
        }
        else {
            return redirect('/reevaluationapplication/home/'.$eid);
        }
    }


}
