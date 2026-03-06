<?php

namespace App\Http\Controllers\Common;

use App\Academicyear;
use App\Approvedprogramme;
use App\Examinationpayment;
use App\Incidentalfee;
use App\Incidentalpayment;
use App\Institute;
use App\Order;
use App\Paymentbank;
use App\Paymenttype;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Affiliationfee;
use App\Reevaluationapplication;
use App\Supplimentaryapplicant;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Configuration;
use Session;
use App\Enrolmentfeepayment;

use App\Newapplicant;
use App\Newapplication;

class IncidentalchargeController extends Controller
{
    //
    public function __construct()
    {
        
    }

    public function index() {
        $academicyears = Incidentalfee::select('academicyears.*')
            ->join('academicyears', 'academicyears.id', '=', 'incidentalfees.academicyear_id')
            ->groupBy('incidentalfees.academicyear_id')
            ->orderBy('academicyears.year', 'desc')
            ->get();

        return view('institute.incidentalpayments.index', compact('academicyears'));
    }


    public static function checkIncidentalChargesPaid($apid) {
        $apid1 = Approvedprogramme::find($apid);

        $incidentalfee = Incidentalfee::where('academicyear_id', $apid1->academicyear_id)->where('programme_id', $apid1->programme_id)->where('term', 1)->first();

        if(is_null($incidentalfee)) {
            $data = "";
            return $data;
        }
        else {
            $incidentalpayments = Incidentalpayment::where('incidentalfee_id', $incidentalfee->id)->where('institute_id', $apid1->institute_id)->get();
            if($incidentalpayments->count() == 0)
                return "NO INFORMATION";
            else {
                $count = 0;
                foreach($incidentalpayments as $inp)
                    if($inp->status_id == 2)
                        $count++;
                if($count == 0)
                    return "NOT APPROVED";
                else {
                    return "APPROVED";
                }
            }
        }
    }

    public function selectCourses($ayid, $apid, $infid) {
        /* old
        $academicyear = Academicyear::find($ayid);

        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $approvedprogrammes = Approvedprogramme::select('approvedprogrammes.*')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->where('approvedprogrammes.academicyear_id', $academicyear->id)
            ->where('approvedprogrammes.institute_id', $institute->id)
            ->orderBy('programmes.sortorder')->get();

        $programme_ids = $approvedprogrammes->pluck('programme_id')->toArray();

        $incidentalfees = Incidentalfee::where('academicyear_id', $academicyear->id)->whereIn('programme_id', $programme_ids)->get();

        $paymenttypes = Paymenttype::all();
        $paymentbanks = Paymentbank::orderBy('bankname')->get();

        return view('institute.incidentalpayments.selectcourses', compact('academicyear', 'institute', 'approvedprogrammes', 'incidentalfees', 'paymenttypes', 'paymentbanks'));
        */

        $academicyear = Academicyear::find($ayid);

        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $approvedprogramme = Approvedprogramme::find($apid);

        $incidentalfee = Incidentalfee::find($infid);

        $paymenttypes = Paymenttype::all();
        $paymentbanks = Paymentbank::orderBy('bankname')->get();

        return view('institute.incidentalpayments.selectcourses', compact('academicyear', 'institute', 'approvedprogramme', 'incidentalfee', 'paymenttypes', 'paymentbanks'));
    }

    public function addPaymentDetails(Request $request) {
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $count = Incidentalpayment::where('reference_number', 'like', "INP".date("Y").$institute->code."C".'%')->get();
        $filecount = $count->count();
        $filecount++;

        $file = $request->file('filename');
        $reference_number = "INP".date("Y").$institute->code."C".str_pad($filecount, 3, '0', STR_PAD_LEFT);
        $filename = $reference_number.'.'.$file->getClientOriginalExtension();
        $destination = public_path()."/files/payments/incidentalcharge/";

        $file->move($destination, $filename);

        Incidentalpayment::create([
            'incidentalfee_id' => $request->incidentalfee_id,
            'institute_id' => $request->institute_id,
            'approvedprogramme_id' => $request->approvedprogramme_id,
            'order_id' => 1,
            'payment_mode' => 'Offline',
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

        return redirect('/institute/incidentalpayments/'.$request->academicyear_id);
    }

    public function oldaddPaymentDetails(Request $request) {
        $count = 0;
        foreach ($request->incidentalfee as $f) {
            if($request->has($f)) {
                echo $request->approvedprogramme_id[$count]."<br>";
                $count++;
            }
        }
        /*
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $count = Incidentalpayment::where('reference_number', 'like', "INP".date("Y").$institute->code."C".'%')->get();
        $filecount = $count->unique('reference_number')->count();
        $filecount++;

        $file = $request->file('filename');
        $reference_number = "INP".date("Y").$institute->code."C".str_pad($filecount, 3, '0', STR_PAD_LEFT);
        $filename = $reference_number.'.'.$file->getClientOriginalExtension();
        $destination = public_path()."/files/payments/incidentalcharge/";

        $file->move($destination, $filename);

        $count = 0;
        foreach ($request->incidentalfee as $f) {

            Incidentalpayment::create([
                'incidentalfee_id' => $f,
                'approvedprogramme_id' => $request->approvedprogramme_id[$count],
                'paymenttype_id' => $request->paymenttype_id,
                'paymentbank_id' => $request->paymentbank_id,
                'payment_date' => date("Y-m-d", strtotime($request->payment_date)),
                'payment_number' => $request->payment_number,
                'payment_remark' => $request->payment_remark,
                'filename' => $filename,
                'reference_number' => $reference_number,
                'amount_paid' => $request->amount_paid,
                'status_id' => 5,
            ]);

            $count++;
        }

        return redirect('/institute/incidentalpayments/'.$request->academicyear_id);
        */

    }

    public function downloadreceipt($infid) {
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $affiliationfee  = Affiliationfee::find($infid);

        return view('institute.incidentalpayments.downloadreceipt', compact('institute', 'affiliationfee'));
    }

    public function olddownloadreceipt($ref_num) {
        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $incidentalpayments = Incidentalpayment::where('reference_number', $ref_num)->get();
        $common = $incidentalpayments->where('reference_number', $ref_num)->first();

        return view('institute.incidentalpayments.downloadreceipt', compact('institute', 'incidentalpayments', 'common'));
    }

    public function showOnlinePaymentForm($ayid, $apid, $infid) {
        $academicyear = Academicyear::find($ayid);

        $institute = Institute::where('user_id', Auth::user()->id)->first();

        $approvedprogramme = Approvedprogramme::find($apid);

        $incidentalfee = Incidentalfee::find($infid);

        $billing_notes = "Affiliation fee Payment of ".$approvedprogramme->institute->code.' for '.$approvedprogramme->programme->course_name." - ".$approvedprogramme->academicyear->year." (".$incidentalfee->term." year)";

        $order_number = "INP".$approvedprogramme->institute->code."OR".date('Ymdhis').$this->generateRandomString().rand(1000, 9999);
        $ref_num = rand(1000000000,9999999999);

        return view('institute.incidentalpayments.showonlinepaymentform', compact('academicyear', 'institute', 'approvedprogramme', 'incidentalfee', 'order_number', 'billing_notes','ref_num'));
    }

    public function showDetails(Request $r) {
        if($r->type=='reevaluation'){
            $billing_name = $r->billing_name;
            $billing_designation = $r->billing_designation;
            $billing_tel = $r->billing_tel;
            $billing_email = $r->billing_email;
            $nber_id = $r->nber_id;
            Session::put('nber_id',$nber_id);
            
            $candidate = \App\Candidate::where('user_id',Auth::user()->id)->first();
            $billing_notes = "Reevaluation fee payment for  - " . $candidate->enrolmentno;
            if($r->has('reevaluationapplication_id')){
                $reevaluationapplication = Reevaluationapplication::find($r->reevaluationapplication_id);
                Session::put('total',$reevaluationapplication->amount);
            }else{
                $reevaluationapplication = Reevaluationapplication::where('exam_id',22)->where('candidate_id',$candidate->id);
                Session::put('total',$r->amount);
            }
            $order_number = "REE".$candidate->id."OR".date('Ymdhis').$this->generateRandomString().rand(1000, 9999);
            Session::put('order_number',$order_number);
            if($reevaluationapplication->count() == 0){
                $count = Reevaluationapplication::where('exam_id',22)->where('nber_id',$nber_id)->count();
                $count++;
                $nber  = \App\Nber::find($nber_id)->short_code;
                $applicationnumber = '22'.$nber.'REAPPN'.$this->generateRandomString().rand(1000, 9999).str_pad($count, 4, '0', STR_PAD_LEFT);
                $reevaluationapplication = Reevaluationapplication::create([
                    'orderstatus_id' => 0,
                    'order_id' => 0,
                    'nber_id' =>  $nber_id,
                    'application_number' => $applicationnumber,
                    'reevaluation_id' => 12,
                    'exam_id' => 22,
                    'institute_id' => $candidate->approvedprogramme->institute_id,
                    'approvedprogramme_id' => $candidate->approvedprogramme_id,
                    'candidate_id' => $candidate->id,
                    'contactnumber' => $candidate->contactnumber,
                    'email' => $candidate->email,
                    'status_id' => 1,
                    'active_status' => 1,
                    'amount' => $r->amount
                ]);

                $subjects = \App\Subject::where('programme_id',$candidate->approvedprogramme->programme_id)->get();
                foreach($subjects as $subject){
                    if($r->has('reevaluation_'.$subject->id) || $r->has('retotal_'.$subject->id) ||$r->has('photocopy_'.$subject->id) ){
                        $currentapplication_id = \App\Currentapplication::where('candidate_id',$candidate->id)->where('subject_id',$subject->id)->first()->id;
                        $reevaluationapplicationsubjects = \App\Reevaluationapplicationsubject::create([
                            'reevaluationapplication_id' => $reevaluationapplication->id,
                            'exam_id' => 22,
                            'institute_id' =>$candidate->approvedprogramme->institute_id,
                            'approvedprogramme_id' => $candidate->approvedprogramme_id,
                            'candidate_id' => $candidate->id,
                            'subject_id' => $subject->id,
                            'application_id' => $currentapplication_id,
                            'reevaluation_applystatus' => $r->has('reevaluation_'.$subject->id) ? 1 : 0,
                            'retotalling_applystatus'  => $r->has('retotal_'.$subject->id) ? 1 : 0,
                            'photocopying_applystatus'  => $r->has('photocopy_'.$subject->id) ? 1 : 0,
                            'publish_status' => 0,
                            'active_status' => 1
                        ]); 
                    }
                }
            }
            $academicyear_id=11;
            $institute = Institute::find($candidate->approvedprogramme->institute_id);
            return view('student.reevaluation.submit',compact('institute','academicyear_id','billing_notes','billing_designation','billing_name','billing_tel','billing_email','nber_id'));
        }

        if($r->type=='supplimentary'){
            $type = 'supplimentary';
            $billing_name = $r->billing_name;
            $billing_designation = $r->billing_designation;
            $billing_tel = $r->billing_tel;
            $billing_email = $r->billing_email;
            $nber_id = $r->nber_id;
            Session::put('nber_id',$nber_id);
            
            $candidate = \App\Candidate::where('user_id',Auth::user()->id)->first();
            $billing_notes = "Supplimentary exam fee payment for  - " . $candidate->enrolmentno;
            if($r->has('supplimentaryapplicant_id')){
                $supplimentaryapplicant = Supplimentaryapplicant::find($r->supplimentaryapplicant_id);
                Session::put('total',$supplimentaryapplicant->amount);
            }else{
                $supplimentaryapplicant = Supplimentaryapplicant::where('exam_id',24)->where('candidate_id',$candidate->id);
                Session::put('total',$r->amount);
            }
            $order_number = "REE".$candidate->id."OR".date('Ymdhis').$this->generateRandomString().rand(1000, 9999);
            Session::put('order_number',$order_number);
            if($supplimentaryapplicant->count() == 0){
                $nber  = \App\Nber::find($nber_id)->short_code;
            }
            $academicyear_id=11;
            $institute = Institute::find($candidate->approvedprogramme->institute_id);
            return view('student.examapplication.submit',compact('type','institute','academicyear_id','billing_notes','billing_designation','billing_name','billing_tel','billing_email','nber_id'));
        }

        if($r->type=='examapplication'){
            $type = 'examapplication';
            $billing_name = $r->billing_name;
            $billing_designation = $r->billing_designation;
            $billing_tel = $r->billing_tel;
            $billing_email = $r->billing_email;
            $nber_id = $r->nber_id;
            Session::put('nber_id',$nber_id);
            
            $candidate = \App\Candidate::where('user_id',Auth::user()->id)->first();
            $billing_notes = "Exam Application fee payment for  - " . $candidate->enrolmentno;
            if($r->has('newapplicant_id')){
                $newapplicant = Newapplicant::find($r->newapplicant_id);
                Session::put('total',$newapplicant->amount);
            }else{
                $newapplicant = Newapplicant::where('exam_id',25)->where('candidate_id',$candidate->id);
                Session::put('total',$r->amount);
            }
            $order_number = "EA".$candidate->id."OR".date('Ymdhis').$this->generateRandomString().rand(1000, 9999);
            Session::put('order_number',$order_number);
            if($newapplicant->count() == 0){
                $nber  = \App\Nber::find($nber_id)->short_code;
            }
            $academicyear_id=$candidate->approvedprogramme->academicyear_id;
            $institute = Institute::find($candidate->approvedprogramme->institute_id);
            return view('student.examapplication.submit',compact('type','institute','academicyear_id','billing_notes','billing_designation','billing_name','billing_tel','billing_email','nber_id'));
        }


        if($r->type=='add_examapplication'){
            $type = 'add_examapplication';
            $billing_name = $r->billing_name;
            $billing_designation = $r->billing_designation;
            $billing_tel = $r->billing_tel;
            $billing_email = $r->billing_email;
            $nber_id = $r->nber_id;
            Session::put('nber_id',$nber_id);
            
            $candidate = \App\Candidate::where('user_id',Auth::user()->id)->first();
            $billing_notes = "Additional Exam Application fee payment for  - " . $candidate->enrolmentno;
            if($r->has('newapplicant_id')){
                $newapplicant = Newapplicant::find($r->newapplicant_id);
                Session::put('total',$newapplicant->additional_amount);
            }else{
                $newapplicant = Newapplicant::where('exam_id',25)->where('candidate_id',$candidate->id);
                Session::put('total',$r->additional_amount);
            }
            $order_number = "AEA".$candidate->id."OR".date('Ymdhis').$this->generateRandomString().rand(1000, 9999);
            Session::put('order_number',$order_number);
            if($newapplicant->count() == 0){
                $nber  = \App\Nber::find($nber_id)->short_code;
            }
            $academicyear_id=$candidate->approvedprogramme->academicyear_id;
            $institute = Institute::find($candidate->approvedprogramme->institute_id);
            return view('student.examapplication.submit',compact('type','institute','academicyear_id','billing_notes','billing_designation','billing_name','billing_tel','billing_email','nber_id'));
        }


        $academicyear = \App\Academicyear::where('current',1)->first();
        $academicyear_id = $academicyear->id;
        $academicyearname = $academicyear->year;
        $institute = Institute::where('user_id', Auth::user()->id)->first();
        $order_number = "INP".$institute->user->username."OR".date('Ymdhis').$this->generateRandomString().rand(1000, 9999);
        Session::put('order_number',$order_number);
        if($r->type=='enrolment'){
            $billing_notes = "Enrolment fee payment for the year - " . $academicyearname;
            Session::put('total',$r->amount);
            $billing_name = $r->billing_name;
            $billing_designation = $r->billing_designation;
            $billing_tel = $r->billing_tel;
            $billing_email = $r->billing_email;
            $nber_id = $r->nber_id;
            $enrolmentfee  = Enrolmentfeepayment::where('institute_id',$institute->id)->where('academicyear_id',$academicyear_id)->where('orderstatus_id','!=',1)->where('nber_id',$nber_id);
            if($enrolmentfee->count() == 0){
                Enrolmentfeepayment::create([
                    'institute_id' => $institute->id,
                    'academicyear_id' => $academicyear_id,
                    'orderstatus_id' => 0,
                    'order_id' => 0,
                    'nber_id' =>  $nber_id,
                ]);
            }
            $enrolmentfee  = Enrolmentfeepayment::where('institute_id',$institute->id)->where('academicyear_id',$academicyear_id)->where('orderstatus_id','!=',1)->where('nber_id',$nber_id)->first();
            return view('institute.enrolmentfee.submit',compact('institute','academicyear_id','billing_notes','billing_designation','billing_name','billing_tel','billing_email','nber_id'));
        }

        
        
        
        $billing_notes = "Affiliation fee payment for the year - " . $academicyearname;
        
       // $ref_num = rand(1000000000,9999999999);
        $currentorder = Academicyear::find($academicyear_id)->order;
        $affiliationfee  = Affiliationfee::where('institute_id',$institute->id)->where('academicyear_id',$academicyear_id);
        if($affiliationfee->count() == 0){
            Affiliationfee::create([
                'institute_id' => $institute->id,
                'academicyear_id' => $academicyear_id,
                'orderstatus_id' => 0,
                'order_id' => 0,
            ]);
        }
        $affiliationfee  = Affiliationfee::where('institute_id',$institute->id)->where('academicyear_id',$academicyear_id)->first();

        $total = 0;
        $noofterms = 0;
        foreach($institute->approvedprogrammes as $ap){
        //    if($ap->candidates->count()>0){
                $noofterms = $ap->programme->numberofterms;
                $sortorder = $ap->academicyear->order; 
                for ($i = 1; $i < $noofterms + 1; $i++){
                    if($sortorder == $currentorder){
                        $count = \App\Incidentalfee::where('programme_id',$ap->programme_id)->where('academicyear_id',$academicyear_id)->where('term',$i)->count();
                        //if($count>0){
                            $fee = \App\Incidentalfee::where('programme_id',$ap->programme_id)->where('academicyear_id',$academicyear_id)->where('term',$i)->first()->fee; 
                            $total += $fee;
//                        }
                    }
                    $sortorder += 1; 
                }
       //     }
        }
        Session::put('total',$total);
        return view('institute.incidentalpayments.showdetails', compact('academicyear_id','academicyearname','institute', 'currentorder','billing_notes','affiliationfee'));
    }
    public function uattest(){
        $institute_id = Institute::where('user_id',Auth::user()->id)->first()->id;
        $affiliationfee  = Affiliationfee::where('institute_id',$institute_id)->where('academicyear_id',11)->first();
        $affiliationfee->order_id = 0;
        $affiliationfee->orderstatus_id = 0;
        $affiliationfee->save();
        return back();
    }
    public function ccavenuePaymentGatewayRequestHandler(Request $request) {
        
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        $academicyear_id = \App\Academicyear::where('current',1)->first()->id;
        $data = $request->except('_token');

        $affiliationfee  = Affiliationfee::where('institute_id',$institute->id)->where('academicyear_id',$academicyear_id)->first();
        
        $merchant_id = Configuration::where('attribute','ccavenue_merchant_id')->first()->value;

        $merchant_param1 = $request->affiliationfee_id.','.$request->institute_id.','.$request->affiliationfee_id.','.$request->academicyear_id;

        $data += ['redirect_url' => "https://rcinber.org.in/institute/incidentalpayments/ccavenuepaymentgatewayresponsehandler"];
        $data += ['cancel_url' => "https://rcinber.org.in/institute/incidentalpayments/ccavenuepaymentgatewayresponsehandler"];
      //  $data += ['cancel_url' => "https://beta.rcinber.org.in/institute/incidentalpayments/ccavenuepaymentgatewayfailpage/"];

        $data += ['currency' => 'INR'];
        $data += ['merchant_id' => $merchant_id];
        $data += ['merchant_param1' => $merchant_param1];
        $data += ['merchant_param2' => 'Affiliation Fee'];
        $data['amount'] = Session::get('total');

        $order = Order::where('order_number',Session::get('order_number'))->count();
        if($order > 0){
            Session::put('messages','Session Expired!, Please try again');
            return back();
        }
        $order = Order::create([
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

        $affiliationfee->orders()->attach($order->id);
        Session::put('data',$data);
        Session::put('order_number',$data["order_number"]);
        Session::put('nber_id',$nber_id);
     //   Session::put('merchant_id',$merchant_id);
      //  Session::put('merchant_param1',$merchant_param1);

        return view('institute.incidentalpayments.paymentgateway_request_handler');
    }

    public function ccavenuePaymentGatewayResponseHandler(Request $request) {
        
        set_time_limit(0);

        require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';

        error_reporting(0);

     //   $workingKey='14D6680B5D2CCFA76948FA57501E7090';		//Working Key should be provided here.
      //  $encResponse=$request->encResp;			//This is the response sent by the CCAvenue Server
       // $rcvdString=payment_decrypt($encResponse,$workingKey);	
        //return $rcvdString;

        $working_key = Configuration::where('attribute','ccavenue_working_key')->first()->value;
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        $academicyear_id = Session::get('academicyear_id');
        $access_code = \App\Configuration::where('attribute','ccavenue_access_code')->first()->value;

        $affiliationfee  = Affiliationfee::where('institute_id',$institute->id)->where('academicyear_id',$academicyear_id)->first();

        if(count($request->all() > 0)) {
            if($request->has('encResp')) {
                $encResponse=$request->encResp;		
                $rcvdString=payment_decrypt($encResponse,$working_key);		//Crypto Decryption used as per the specified working key.
                $decryptValues=explode('&', $rcvdString);
                $dataSize=sizeof($decryptValues);
                $total_amount = 0;
            //    return $decryptValues;
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
                                $affiliationfee->orderstatus_id = 1;
                                $affiliationfee->order_id=$order->id;
                                $affiliationfee->save();
                            }
                        }
                        if($i == 8) {
                            $order->update(["status_message" => $information[1]]);
                        }
                        if($i == 10) {
                            
                            if($order->actual_amount != $information[1]){
                                $affiliationfee->orderstatus_id = 0;
                                $affiliationfee->save();
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
                        $affiliationfee->orderstatus_id = 0;
                        $affiliationfee->order_id= 0;
                        $affiliationfee->save();
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
                            $affiliationfee->orderstatus_id = 1;
                            $affiliationfee->order_id=$order->id;
                            $affiliationfee->save();
                        }
                    }
                }
                return redirect('/institute/affiliationfee');
            }
            else {
                return redirect('/institute/affiliationfee');
            }
        }
        else {
            return redirect('/institute/affiliationfee');
        }

        /* Old Codes
        for($i = 0; $i < $dataSize; $i++)
        {
            $information=explode('=',$decryptValues[$i]);
            if($i == 0) { $order_details += ["order_number" => $information[1]]; }
            if($i == 1) { $order_details += ["ccavenue_referencenumber" => $information[1]]; }
            if($i == 2) { $order_details += ["bank_referencenumber" => $information[1]]; }
            if($i == 3) { $order_details += ["order_status" => $information[1]];  $order_status=$information[1]; }
            if($i == 8) { $order_details += ["status_message" => $information[1]]; }
            if($i == 10) { $order_details += ["actual_amount" => $information[1]]; $total_amount += $information[1]; }
            if($i == 11) { $name = $information[1]; }
            if($i == 12) { $designation = $information[1]; }
            if($i == 17) { $mobilenumber = $information[1]; }
            if($i == 18) { $email = $information[1]; }
            if($i == 26) { $order_details += ["reference_parameters" => $information[1]]; $reference_parameters = $information[1]; }
            if($i == 39) { $order_details += ["billing_notes" => $information[1]]; }
            if($i == 40) { $order_details += ["payment_date" => \DateTime::createFromFormat('d/m/Y H:i:s', $information[1])->format('Y-m-d H:i:s')]; }
            if($i == 42) { $order_details += ["transaction_fee" => $information[1]]; $total_amount += $information[1]; }
            if($i == 43) { $order_details += ["service_fee" => $information[1]]; $total_amount += $information[1]; }
        }
        $order_details += ["payment_remarks" => "Incidental Charges"];
        $order_details += ["total_amount" => $total_amount];

        if($order_status==="Success")
        {
            echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";

        }
        else if($order_status==="Aborted")
        {
            echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";

        }
        else if($order_status==="Failure")
        {
            echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
        }
        else
        {
            echo "<br>Security Error. Illegal access detected";

        }

        if(Order::where('order_number', $order_details["order_number"])->count() == 0) {
            $order = Order::create([
                "order_number" => $order_details["order_number"],
                "ccavenue_referencenumber" => $order_details["ccavenue_referencenumber"],
                "bank_referencenumber" => $order_details["bank_referencenumber"],
                "order_status" => $order_details["order_status"],
                "status_message" => $order_details["status_message"],
                "total_amount" => $order_details["total_amount"],
                "actual_amount" => $order_details["actual_amount"],
                "transaction_fee" => $order_details["transaction_fee"],
                "service_fee" => $order_details["service_fee"],
                "payment_date" => $order_details["payment_date"],
                "payment_remarks" => $payment_remarks,
                "transaction_remarks" => $order_details["billing_notes"],
                "reference_parameters" => $order_details["reference_parameters"],
            ]);

            $order_data = explode(',', $order_details["reference_parameters"]);

            $incidentalfee_id = $order_data[0];
            $institute_id = $order_data[1];
            $approvedprogramme_id = $order_data[2];

            if(Incidentalpayment::where('order_id', $order->id)->count() == 0) {
                $incidentalpayment = Incidentalpayment::create([
                    "incidentalfee_id" => $incidentalfee_id,
                    "institute_id" => $institute_id,
                    "approvedprogramme_id" => $approvedprogramme_id,
                    "order_id" => $order->id,
                    "payment_mode" => "Online",
                    "paymenttype_id" => "4",
                    "paymentbank_id" => "225",
                    "payment_date" => $order->payment_date->format('Y-m-d'),
                    "payment_number" => $order->order_number,
                    "status_id" => 6,
                    'reference_number' => $order->order_number,
                    'amount_paid' => $order->actual_amount,
                    'name' => $name,
                    'designation' => $designation,
                    'mobilenumber' => $mobilenumber,
                    'email' => $email,
                ]);
            }

            redirect('/institute/incidentalpayments/ccavenuepaymentgatewaypaymentstatus/'.$order->order_number);
        }
        */
    }

    public function ccavenuePaymentGatewayPaymentStatus($order_num) {
        $order = Order::where('order_number', $order_num)->first();

        $order_data = explode(',', $order->reference_parameters);

        //$incidentalfee_id = $order_data[0];
        //$institute_id = $order_data[1];
        $approvedprogramme_id = $order_data[2];

        $approvedprogramme = Approvedprogramme::find($approvedprogramme_id);

        return view('institute.incidentalpayments.payment_status', compact('order', 'approvedprogramme'));
    }

    public function ccavenuePaymentGatewayFailPage(Request $request) {
        set_time_limit(0);
        error_reporting(0);
        Session::flash('error',"Payment failed");
        return redirect('/institute/affiliationfee');
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

    public function testing() {
        $billing_date = "27/02/2022 05:22:23";

        $date = \DateTime::createFromFormat('d/m/Y H:i:s', '27/02/2022 23:22:23');
        echo $date->format('Y-m-d H:i:s').'<br>';

        echo \DateTime::createFromFormat('d/m/Y H:i:s', '27/02/2022 23:22:23')->format('Y-m-d H:i:s').'<br>';

        $data = [];
        $data += ["id" => '1'];
        $data += ["sid" => '2'];
        $data += ["did" => '3'];
        $str = "";

        $str = "51, 199, 3108";
        $t = explode(",",$str);
        echo $t[0];
    }
}
