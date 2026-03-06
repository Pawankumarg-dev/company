<?php

namespace App\Http\Controllers\Institute;

use App\Academicyear;
use App\Approvedprogramme;
use App\Candidate;
use App\Enrolmentfee;
use App\Enrolmentpayment;
use App\Exam;
use App\Institute;
use App\Order;
use App\Paymentbank;
use App\Paymenttype;
use Illuminate\Http\Request;
use App\Configuration;
use Session;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use PDF;
use File;
use Auth;

use App\Enrolmentfeepayment;

class EnrolmentpaymentController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('institute', ['except' => ['ccavenuePaymentGatewayResponseHandler']]);
    }

    public function index() {
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $academicyear_ids = Approvedprogramme::where('institute_id', $institute->id)->pluck('academicyear_id')->toArray();

        $academicyears = Academicyear::whereIn('id', $academicyear_ids)->orderBy('year', 'desc')->get();

        return view('institute.enrolmentpayments.index', compact('institute', 'academicyears'));
    }

    public function showCourses($ayid) {
        $institute = Institute::where('user_id', Auth::user()->id)->first();
        $academicyear = Academicyear::find($ayid);

        $approvedprogrammes = Approvedprogramme::where("academicyear_id", $academicyear->id)->where("institute_id", $institute->id)
            ->where("status_id", 2)->get();

        return view('institute.enrolmentpayments.showcourses', compact('institute', 'academicyear', 'approvedprogrammes'));
    }

    public function showStudents($apid) {
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        if(is_null($institute)) {
            unset($institute);

            return redirect('/');
        }
        else {
            $approvedprogramme = Approvedprogramme::find($apid);

            if(is_null($approvedprogramme)) {
                unset($institute);
                unset($approvedprogramme);

                return redirect('/institute/enrolmentpayments');
            }
            else {
                $candidates = Candidate::where('approvedprogramme_id', $approvedprogramme->id)->where('status_id', 2)->orderBy('enrolmentno')->get(['id', 'name', 'enrolmentno', 'photo', 'paymentstatus_id']);

                return view('institute.enrolmentpayments.showstudents', compact('approvedprogramme', 'candidates'));
            }
        }
    }

    public function checkenrolmentfee($apid) {
        $approvedprogramme = Approvedprogramme::find($apid);

        return view('institute.enrolmentpayments.checkenrolmentfee', compact('approvedprogramme'));
    }

    public function addpaymentform($cid) {
        $candidate = Candidate::find($cid);

        if(is_null($candidate)) {
            return $this->index();
        }
        else {
            if($candidate->approvedprogramme->institute_id == Institute::where("user_id", Auth::user()->id)->first()->id) {
                $enrolmentfee = Enrolmentfee::where("academicyear_id", $candidate->approvedprogramme->academicyear_id)->where("programme_id", $candidate->approvedprogramme->programme_id)->first();
                $paymenttypes = Paymenttype::all();
                $paymentbanks = Paymentbank::orderBy("bankname")->get();
                return view('institute.enrolmentpayments.addpaymentform', compact('candidate', 'paymentbanks', 'paymenttypes', 'enrolmentfee'));
            }
            else {
                return $this->index();
            }
        }
    }

    public function addpaymentdetails(Request $request) {
        $candidate = Candidate::where('id', $request->candidate_id)->first();

        $count = Enrolmentpayment::where('reference_number', 'like', "ENP".$candidate->approvedprogramme->academicyear->year.$candidate->approvedprogramme->institute->code."C".'%')->count();
        $count++;

        $file = $request->file('filename');
        $reference_number = "ENP".$candidate->approvedprogramme->academicyear->year.$candidate->approvedprogramme->institute->code."C".str_pad($count, 3, '0', STR_PAD_LEFT);
        $filename = $reference_number.'.'.$file->getClientOriginalExtension();
        $destination = public_path()."/files/payments/enrolment/";

        $file->move($destination, $filename);

        $enrolmentpayment = Enrolmentpayment::create([
            'enrolmentfee_id' => $request->enrolmentfee_id,
            'institute_id' => $request->institute_id,
            'candidate_id' => $request->candidate_id,
            "order_id" => 1,
            "payment_mode" => "Offline",
            'fee_exemption' => $request->fee_exemption,
            'latefee_remark' => $request->latefee_remark,
            'paymenttype_id' => $request->paymenttype_id,
            'paymentbank_id' => $request->paymentbank_id,
            'payment_date' => date("Y-m-d", strtotime($request->payment_date)),
            'payment_number' => $request->payment_number,
            'payment_remark' => $request->payment_remark,
            'filename' => $filename,
            'reference_number' => $reference_number,
            'amount_paid' => $request->amount_paid,
            'name' => $request->name,
            'designation' => $request->designation,
            'mobilenumber' => $request->mobilenumber,
            'email' => $request->email,
            'status_id' => 6,
        ]);

        if(!is_null($enrolmentpayment)) {
            $enrolmentpayment->candidate->update(["paymentstatus_id" => 2]);
        }

        return $this->showstudents($candidate->approvedprogramme_id);
    }

    public function viewstudentpaymentdetails($cid) {
        $candidate = Candidate::find($cid);

        if(is_null($candidate)) {
            return $this->index();
        }
        else {
            if($candidate->approvedprogramme->institute_id == Institute::where("user_id", Auth::user()->id)->first()->id) {
                $enrolmentpayments = Enrolmentpayment::where("candidate_id", $candidate->id)->get();
                return view('institute.enrolmentpayments.viewstudentpaymentdetails', compact('candidate', 'enrolmentpayments'));
            }
            else {
                return $this->index();
            }
        }
    }

    public function showAcademicYear($ayid) {
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $currentyear = Academicyear::where('id', $ayid)->first();

        $enrolmentfees = Enrolmentfee::where('academicyear_id', $currentyear->id)->get();
        $enrolmentfee_ids = $enrolmentfees->pluck('id')->toArray();

        $approvedprogramme_ids = Approvedprogramme::where('institute_id', $institute->id)->where('academicyear_id', $currentyear->id)->pluck('id')->toArray();
        $candidate_ids = Candidate::whereIn('approvedprogramme_id', $approvedprogramme_ids)->pluck('id')->toArray();

        $enrolmentpayments = Enrolmentpayment::whereIn('enrolmentfee_id', $enrolmentfee_ids)->whereIn('candidate_id', $candidate_ids)
            ->groupBy('reference_number')->get();

        return view('institute.enrolmentpayments.showacademicyears', compact('institute', 'currentyear', 'enrolmentpayments', 'enrolmentfees'));
    }

    public function selectstudents($ayid) {
        $institute = Institute::where('user_id', Auth::user()->id)->first();
        $currentyear = Academicyear::where('id', $ayid)->first();
        $enrolmentfees = Enrolmentfee::where('academicyear_id', $currentyear->id)->get();
        $enrolmentfee_ids = $enrolmentfees->pluck('id')->toArray();
        $enrolmentpayments = Enrolmentpayment::whereIn('enrolmentfee_id', $enrolmentfee_ids)->get();

        return view('institute.enrolmentpayments.selectstudents', compact('institute', 'currentyear', 'enrolmentpayments'));
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

        return redirect('/institute/enrolmentpayments/addpayment/'.$request->payment_date.'/'.$candidate_ids);

    }

    public function addpayment($payment_date, $cids) {
        $candidate_ids = unserialize($cids);
        $candidates = Candidate::whereIn('id', $candidate_ids)->get();

        $institute = Institute::where('user_id', Auth::user()->id)->first();
        $currentyear = Academicyear::where('current', '1')->orderBy('year')->first();

        $enrolmentfees = Enrolmentfee::where('academicyear_id', $currentyear->id)->get();


        /*
        $enrolmentfee_ids = $enrolmentfees->pluck('id')->toArray();
        $enrolmentpayments = Enrolmentpayment::whereIn('enrolmentfee_id', $enrolmentfee_ids)->get();
        */

        $paymenttypes = Paymenttype::all();
        $paymentbanks = Paymentbank::orderBy('bankname')->get();

        return view('institute.enrolmentpayments.create', compact('institute', 'currentyear', 'payment_date',
            'candidates', 'enrolmentfees', 'paymenttypes', 'paymentbanks'));
    }

    public function checkpayment(Request $request){
        $rules = [
            "paymenttype_id" => "required",
            "paymentbank_id" => "required",
            "payment_number" => "required | alpha_num",
            "amount_paid" => "required",
            "filename" => "required | max: 1024"
        ];

        $messages = [
            "paymenttype_id.min" => "Please select a Payment Mode from the given option",
            "paymentbank_id.min" => "Please select a Payment Bank from the given option" ,
            "payment_number.required" => "Please enter the Transaction Id / Number",
            "amount_paid.required" => "Please enter the Amount Paid",
            "filename.required" => "Please upload the Scanned copy of Payment Slip",
            "filename.max" => "The uploaded file should be less than 1 MB"
        ];

        $validator = validator($request->all(), $rules, $messages);

        $validator->after(function ($validator) use($request){
            if($request->has('paymenttype_id')) {
                if($request->paymenttype_id == '0') {
                    $validator->errors()->add('paymenttype_id', "Please select a Payment Mode from the given option");
                }
            }

            if($request->has('paymentbank_id')) {
                if($request->paymenttype_id == '0') {
                    $validator->errors()->add('paymentbank_id', "Please select a Payment Bank from the given option");
                }
            }

            if($request->has('filename')) {
                $file = $request->file('filename');
                if($file->getClientOriginalExtension() != 'jpg' && $file->getClientOriginalExtension() != 'pdf') {
                    $validator->errors()->add('filename', "The uploaded file should in .jpg  or .pdf format");
                }
            }
        });

        $this->validateWith($validator);
        /*
        $candidates = Candidate::whereIn('id', $request->candidate_id)->get();
        $institute = Institute::where('user_id', Auth::user()->id)->first();
        $currentyear = Academicyear::where('current', '1')->orderBy('year')->first();

        $count = Enrolmentpayment::distinct('payment_number')->count('payment_number');
        $count++;

        $file = $request->file('filename');
        $reference_number = "ENP".$currentyear->year.$institute->code."C".$count;
        $filename = $reference_number.'.'.$file->getClientOriginalExtension();
        $destination = public_path()."/files/payments/enrolment/";

        $file->move($destination, $filename);

        foreach ($candidates as $c) {
            $enrolmentfee = Enrolmentfee::where('academicyear_id', $c->approvedprogramme->academicyear_id)
                ->where('programme_id', $c->approvedprogramme->programme_id)->first();
            $latefee_remark = "Yes";

            if(!is_null($enrolmentfee)) {
                if($request->payment_date <= $enrolmentfee->ontimepayment_enddate) {
                    $latefee_remark = "No";
                }

                Enrolmentpayment::create([
                    "enrolmentfee_id" => $enrolmentfee->id,
                    "candidate_id" => $c->id,
                    "latefee_remark" => $latefee_remark,
                    "paymenttype_id" => $request->paymenttype_id,
                    "paymentbank_id" => $request->paymentbank_id,
                    "payment_date" => $request->payment_date,
                    "payment_number" => $request->payment_number,
                    "status_id" => 5,
                    "filename" => $filename,
                    "payment_remark" => $request->payment_remark,
                    "amount_paid" => $request->amount_paid,
                    "reference_number" => $reference_number,
                ]);
            }
        }

        return redirect('/institute/enrolmentpayments/');
        */
    }

    public function downloadreceipt($enpid) {
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $enrolmentpayment = Enrolmentpayment::find($enpid);

        //$pdf = PDF::loadView('institute.enrolmentpayments.sample', compact('institute', 'enrolmentpayments', 'common'));

        //return $pdf->download('Enrolment Payment Acknowledgement -'.$institute->code.'.pdf');

        return view('institute.enrolmentpayments.downloadreceipt', compact('institute', 'enrolmentpayment'));
    }

    public function olddownloadreceipt($reference_number) {
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $enrolmentpayments = Enrolmentpayment::where('reference_number', $reference_number)->get();
        $common = $enrolmentpayments->where('reference_number', $reference_number)->first();

        //$pdf = PDF::loadView('institute.enrolmentpayments.sample', compact('institute', 'enrolmentpayments', 'common'));

        //return $pdf->download('Enrolment Payment Acknowledgement -'.$institute->code.'.pdf');

        return view('institute.enrolmentpayments.download', compact('institute', 'enrolmentpayments', 'common'));
    }

    public function showOnlinePaymentForm($cid) {
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        if(is_null($institute)) {
            unset($institute);

            return redirect('/');
        }
        else {

            $candidate = Candidate::where('id', $cid)->where('status_id', 2)->first();

            if(is_null($candidate)) {
                unset($institute);
                unset($candidate);

                return redirect('/institute/enrolmentpayments');
            }
            else {
                /*
                    1 -> Not Entered
                    3 -> Pending
                    3 -> Rejected
                 */
                $paymentStatusIdForPayment = array(1, 3, 5);

                if(!in_array($candidate->paymentstatus_id, $paymentStatusIdForPayment)) {
                    unset($institute);
                    unset($candidate);
                    unset($paymentStatusIdForPayment);
                }
                else {
                    $approvedprogramme = $candidate->approvedprogramme;
                    $enrolmentfee = Enrolmentfee::where("academicyear_id", $candidate->approvedprogramme->academicyear_id)->where("programme_id", $candidate->approvedprogramme->programme_id)->first();
                    $amount = $enrolmentfee->enrolment_fee + $enrolmentfee->late_fee;
                    $billing_notes = $approvedprogramme->institute->code." Enrolment Fee of ".$candidate->name." - ".$approvedprogramme->programme->course_name."(".$approvedprogramme->academicyear->year.")";
                    $order_number = "ENP".$candidate->approvedprogramme->institute->code."OR".date('Ymdhis').$this->generateRandomString().rand(1000, 9999);

                    return view('institute.enrolmentpayments.show_online_payment_form', compact('candidate', 'institute', 'approvedprogramme', 'enrolmentfee', 'amount', 'billing_notes', 'order_number'));
                }
            }
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
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        $academicyear_id = \App\Academicyear::where('current',1)->first()->id;
        $nber_id = $request->nber_id;
        $enrolmentfee  = Enrolmentfeepayment::where('institute_id',$institute->id)->where('academicyear_id',$academicyear_id)->where('orderstatus_id','!=',1)->where('nber_id',$nber_id)->first();
       
        $merchant_id = Configuration::where('attribute','ccavenue_merchant_id_nber_'.$request->nber_id)->first()->value;

        // merchant_param1 = EnrolmentfeeId,InstituteId,CandidateId
        $merchant_param1 =  '01,' . $request->institute_id . ',' . $request->nber_id;

        //$data += ['redirect_url' => "https://rcinber.org.in/institute/enrolmentpayments/ccavenuepaymentgatewayresponsehandler"];
        //$data += ['cancel_url' => "https://rcinber.org.in/institute/enrolmentpayments/ccavenuepaymentgatewayresponsehandler"];
        $data += ['redirect_url' => "https://rcinber.org.in/institute/enrolmentpayments/ccavenuepaymentgatewayresponsehandler"];
        $data += ['cancel_url' => "https://rcinber.org.in/institute/enrolmentpayments/ccavenuepaymentgatewayresponsehandler"];

        $data += ['currency' => 'INR'];
        $data += ['merchant_id' => $merchant_id];
        $data += ['merchant_param1' => $merchant_param1];
        $data += ['merchant_param2' => 'Enrolment Fee'];
        $data['amount'] = Session::get('total');

        $order = Order::where('order_number', Session::get('order_number'))->count();

        if ($order > 0) {
            Session::put('messages','Session Expired!, Please try again');
            return back();
        }
        $order = Order::firstOrCreate([
            "order_number" => $data["order_number"],
            "ccavenue_referencenumber" => $data['ref_num'],
            "bank_referencenumber" => null,
            "order_status" => "Initiated",
            "status_message" => null,
            "total_amount" => Session::get('total'),
            "actual_amount" => Session::get('total'),
            "transaction_fee" => 0.00,
            "service_fee" => 0.00,
            "payment_date" => date("Y-m-d"),
            "payment_remarks" => $data["merchant_param2"],
            "transaction_remarks" => $data["billing_notes"],
            "reference_parameters" => $data["merchant_param1"],
            "billing_name" => $data["billing_name"],
            "billing_designation" => $data["billing_designation"],
            "billing_tel" => $data["billing_tel"],
            "billing_email" => $data["billing_email"],
        ]);
        $enrolmentfee->orders()->attach($order->id);
        Session::put('data',$data);
        Session::put('order_number',$data["order_number"]);
        Session::put('nber_id',$nber_id);
        return view('institute.enrolmentfee.paymentgateway_request_handler');
    }

    public function ccavenuePaymentGatewayResponseHandler(Request $request) {
        set_time_limit(0);

        require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';

        error_reporting(0);
        $nber_id = Session::get('nber_id');
        $working_key = \App\Configuration::where('attribute','ccavenue_working_key_nber_'.$nber_id)->first()->value;
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        $academicyear_id = Session::get('academicyear_id');
        $access_code = \App\Configuration::where('attribute','ccavenue_access_code_nber_'.$nber_id)->first()->value;
        $enrolmentfee  = Enrolmentfeepayment::where('institute_id',$institute->id)->where('academicyear_id',$academicyear_id)->where('orderstatus_id','!=',1)->where('nber_id',$nber_id)->first();
        
        if(count($request->all() > 0)) {
            if($request->has('encResp')) {
                $encResponse=$request->encResp;			//This is the response sent by the CCAvenue Server
                $rcvdString=payment_decrypt($encResponse,$working_key);		//Crypto Decryption used as per the specified working key.

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
                            $ifexists = Order::where('ccavenue_referencenumber',$information[1])->count();
                            if($ifexists < 1){
                                $order->update(["ccavenue_referencenumber" => $information[1]]);
                            }else{
                                $order->update(["ccavenue_referencenumber" => 'Duplicate - ' . $information[1]]);
                            }
                        }
                        if($i == 2) {
                            $order->update(["bank_referencenumber" => $information[1]]);
                        }
                        if($i == 3) {
                            $order->update(["order_status" => $information[1]]);
                            if($information[1]=="Success"){
                                $enrolmentfee->orderstatus_id = 1;
                                $enrolmentfee->order_id=$order->id;
                                $enrolmentfee->save();
                            }
                        }
                        if($i == 8) {
                            $order->update(["status_message" => $information[1]]);
                        }
                        if($i == 10) {
                            if($order->actual_amount != $information[1]){
                                $enrolmentfee->orderstatus_id = 0;
                                $enrolmentfee->save();
                                $order->update(["order_status" => 'Failed']);
                            }else{
                                $order->update(["actual_amount" => $information[1]]);
                                $total_amount += $information[1];
                            }
                        }
                        if($i == 40 && $order->order_status == "Success") {
                            $order->update(["payment_date" => \DateTime::createFromFormat('d/m/Y H:i:s', $information[1])->format('Y-m-d H:i:s')]);
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
                if($order->order_status == "Success"){
                    if(Session::get('order_number') != $order->order_number){
                        $order->order_status = "Failed";
                        $order->save();
                        $enrolmentfee->orderstatus_id = 0;
                        $enrolmentfee->order_id= 0;
                        $enrolmentfee->save();
                    }else{
                        $merchant_json_data =
                        array(
                            'order_no' => $order->order_number,
                            'reference_no' => $order->ccavenue_referencenumber
                        );
                        
                        $merchant_data = json_encode($merchant_json_data);
                        $encrypted_data = payment_encrypt($merchant_data, $working_key);
                        $final_data = 'enc_request='.$encrypted_data.'&access_code='.$access_code.'&command=orderStatusTracker&request_type=JSON&response_type=JSON';
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "https://apitest.ccavenue.com/apis/servlet/DoWebTrans");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_VERBOSE, 1);
                        curl_setopt($ch, CURLOPT_HTTPHEADER,'Content-Type: application/json') ;
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $final_data);
                        // Get server response ...
                        $result = curl_exec($ch);
                        curl_close($ch);
                        $status = '';
                        $information = explode('&', $result);
                        
                        $dataSize = sizeof($information);
                        for ($i = 0; $i < $dataSize; $i++) {
                            $info_value = explode('=', $information[$i]);
                            if ($info_value[0] == 'enc_response') {
                                $status = payment_decrypt(trim($info_value[1]), $working_key);
                                
                            }
                        }
                        $obj = json_decode($status);
                        if($obj->Order_Status_Result->order_status == 'Shipped'){
                            $order->order_status = "Success";
                            $order->save();
                            $enrolmentfee->orderstatus_id = 1;
                            $enrolmentfee->order_id=$order->id;
                            $enrolmentfee->save();
                        }
                    }
                }
                if($enrolmentfee->orderstatus_id ==1){
                    $academicyear = \App\Academicyear::where('current',1)->first();
                    $iid = \App\Institute::where('user_id',Auth::user()->id)->first()->id;
                    $approvedprogrammes = \App\Approvedprogramme::where('institute_id',$iid)->where('academicyear_id',$academicyear->id)->get();
                    foreach($approvedprogrammes as $ap){
                        //$candidates = $ap->candidates->where('status_id',2)->count();
                        $candidates = $ap->candidates->whereIn('status_id',[1,2,4,5,6,7,8])->count();
                        $pending_enrollment = $ap->candidates->where('status_id',2)->where('enrolmentno',null)->count();
                        $startingno = $candidates - $pending_enrollment + 1;
                        foreach($ap->candidates->where('status_id',2)->where('enrolmentno',null)->sortBy('name') as $candidate){
                            $enrolmentno = str_pad($ap->programme->enrolmentcode,2,'0',STR_PAD_LEFT) . $ap->academicyear->enrolmentcode . str_pad($ap->institute->enrolmentcode,3,'0',STR_PAD_LEFT) . str_pad($startingno,2,'0',STR_PAD_LEFT);
                            $candidate->enrolmentno = $enrolmentno;
                            $candidate->save();
                            $startingno ++;
                        }
                    }
                }
                return redirect('institute/enrolmentfee');
            }
            else {
                return redirect('institute/enrolmentfee');
            }
        }
        else {
            return redirect('institute/enrolmentfee');
        }
    }

    public function ccavenuePaymentGatewayPaymentStatus($order_num) {
        $order = Order::where('order_number', $order_num)->first();

        $enrolmentpayment = Enrolmentpayment::where('order_id', $order->id)->first();

        return view('institute.enrolmentpayments.payment_status', compact('order', 'enrolmentpayment'));
    }

    public function ccavenuePaymentGatewayFailPage(Request $request) {
        set_time_limit(0);
        error_reporting(0);

        return redirect('/institute/enrolmentpayments');
    }
}
