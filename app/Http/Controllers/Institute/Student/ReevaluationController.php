<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Reevaluationapplication;

use App\Http\Requests;
use App\Candidate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Institute;
use App\Configuration;
use App\Order;
use App\User;
use App\Reevaluationapplicationfee;

use App\Refund;

class ReevaluationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['role:student']);
    }

    public function index(Request $r){
        
   /*     if($r->type=='reevaluation'){
            $billing_notes = "Reevaluation fee payment for  - " . $r->billing_name;
            Session::put('total',$r->amount);
            $billing_name = $r->billing_name;
            $billing_designation = $r->billing_designation;
            $billing_tel = $r->billing_tel;
            $billing_email = $r->billing_email;
            $nber_id = $r->nber_id;
            $candidate = Candidate::where('user_id',Auth::user()->id)->first();
            $reevaluationapplication = Reevaluationapplication::where('exam_id',22)->where('candidate_id',$candidate->id);
            if($reevaluationapplication->count() == 0){
                $count = Reevaluationapplication::where('exam_id',22)->where('nber_id',$nber_id)->count();
                $count++;
                $nber  = \App\Nber::find($nber_id)->short_code;
                $applicationnumber = '22'.$nber.'REAPPN'.str_pad($count, 4, '0', STR_PAD_LEFT);
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
        }*/
        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
        $reevaluationfee = Reevaluationapplicationfee::where('exam_id',22)->first();
        $reevaluationapplication = Reevaluationapplication::where('exam_id',22)->where('candidate_id',$candidate->id)->first();
        $use_password = User::find(Auth::user()->id)->use_password;
        Session::put('use_password','-1');
        if($use_password != 1  ){
            return view('student.profile.createpassword',compact('candidate'));
        }
        return view('student.reevaluation.index',compact('candidate','reevaluationfee','reevaluationapplication'));
    }

    public function ccavenuePaymentGatewayRequestHandler(Request $request) {
        
        $data = $request->except('_token');
       // $institute = Institute::where('user_id',Auth::user()->id)->first();
       // $academicyear_id = \App\Academicyear::where('current',1)->first()->id;
        $nber_id = Session::get('nber_id');
        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
        
        //$enrolmentfee  = Enrolmentfeepayment::where('institute_id',$institute->id)->where('academicyear_id',$academicyear_id)->where('orderstatus_id','!=',1)->where('nber_id',$nber_id)->first();
        $reevaluationapplication = Reevaluationapplication::where('exam_id',22)->where('candidate_id',$candidate->id)->first();
       
        $merchant_id = Configuration::where('attribute','ccavenue_merchant_id_nber_'.$nber_id)->first()->value;
        
        
        // merchant_param1 = EnrolmentfeeId,InstituteId,CandidateId
        $merchant_param1 =  '01,' . $candidate->id . ',' . $nber_id;

        //$data += ['redirect_url' => "https://rcinber.org.in/institute/enrolmentpayments/ccavenuepaymentgatewayresponsehandler"];
        //$data += ['cancel_url' => "https://rcinber.org.in/institute/enrolmentpayments/ccavenuepaymentgatewayresponsehandler"];
        $data += ['redirect_url' => "https://rcinber.org.in/student/reevaluation/ccavenuepaymentgatewayresponsehandler"];
        $data += ['cancel_url' => "https://rcinber.org.in/student/reevaluation/ccavenuepaymentgatewayresponsehandler"];

        $data += ['currency' => 'INR'];
        $data += ['merchant_id' => $merchant_id];
        $data += ['merchant_param1' => $merchant_param1];
        $data += ['merchant_param2' => 'Reevaluation Fee'];
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
       // $enrolmentfee->orders()->attach($order->id);
        $reevaluationapplication->orders()->attach($order->id);
        
        Session::put('data',$data);
        Session::put('order_number',$data["order_number"]);
        Session::put('nber_id',$nber_id);
        return view('student.reevaluation.paymentgateway_request_handler');
    }

    public function ccavenuePaymentGatewayResponseHandler(Request $request) {
        
        set_time_limit(0);

        require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';

        error_reporting(0);
        $nber_id = Session::get('nber_id');
        $working_key = \App\Configuration::where('attribute','ccavenue_working_key_nber_'.$nber_id)->first()->value;
        //$institute = Institute::where('user_id',Auth::user()->id)->first();
        //$academicyear_id = Session::get('academicyear_id');
        $access_code = \App\Configuration::where('attribute','ccavenue_access_code_nber_'.$nber_id)->first()->value;
        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
        
        //$enrolmentfee  = Enrolmentfeepayment::where('institute_id',$institute->id)->where('academicyear_id',$academicyear_id)->where('orderstatus_id','!=',1)->where('nber_id',$nber_id)->first();
        $reevaluationapplication = Reevaluationapplication::where('exam_id',22)->where('candidate_id',$candidate->id)->where('orderstatus_id','!=',1)->first();
        $reevaluationfee = Reevaluationapplicationfee::where('exam_id',22)->first();
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
                                $reevaluationapplication->orderstatus_id = 1;
                                $reevaluationapplication->order_id=$order->id;
                                $reevaluationapplication->save();
                            }
                        }
                        if($i == 8) {
                            $order->update(["status_message" => $information[1]]);
                        }
                        if($i == 10) {
                            if($order->actual_amount != $information[1]){
                                $reevaluationapplication->orderstatus_id = 0;
                                $reevaluationapplication->save();
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
                if($order->order_status == 'Invalid'){
                    Session::put('error', $order->status_message);
                    return redirect ('reevaluation');
                }
                if($order->order_status == "Success"){
                    if(Session::get('order_number') != $order->order_number){
                        $order->order_status = "Failed";
                        $order->save();
                        $reevaluationapplication->orderstatus_id = 0;
                        $reevaluationapplication->order_id= 0;
                        $reevaluationapplication->save(); 
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
                            $reevaluationapplication->orderstatus_id = 1;
                            $reevaluationapplication->order_id=$order->id;
                            $reevaluationapplication->save();
                            
                            
                        }
                    }
                }
                if($reevaluationapplication->orderstatus_id == 1){
                    $this->fireMail($candidate,$reevaluationapplication,$reevaluationfee);
                }
                return redirect('reevaluation');
            }
            else {
                return redirect('reevaluation');
            }
        }
        else {
            return redirect('reevaluation');
        }
    }

    private function fireMail($candidate,$reevaluationapplication,$reevaluationfee){
       // $job = (new \App\Jobs\SendReevalConfirmation($candidate,$reevaluationapplication,$reevaluationfee))->onQueue('reevaluation');
        //$this->dispatch($job);
    }

    public function recheckStatus($nid,$oid){
        set_time_limit(0);

        require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';

        error_reporting(0);
        $nber_id = $nid;
        $working_key = \App\Configuration::where('attribute','ccavenue_working_key_nber_'.$nber_id)->first()->value;
        $access_code = \App\Configuration::where('attribute','ccavenue_access_code_nber_'.$nber_id)->first()->value;
        $order=Order::find($oid);
        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
        $merchant_json_data =
        array(
            'order_no' => $order->order_number,
            //'reference_no' => $order->ccavenue_referencenumber
        );
        
        $merchant_data = json_encode($merchant_json_data);
        $encrypted_data = payment_encrypt($merchant_data, $working_key);
        $final_data = 'enc_request='.$encrypted_data.'&access_code='.$access_code.'&command=orderStatusTracker&request_type=JSON&response_type=JSON';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.ccavenue.com/apis/servlet/DoWebTrans");
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
            $reevaluationapplication = Reevaluationapplication::where('exam_id',22)->where('candidate_id',$candidate->id)->first();
            $reevaluationapplication->orderstatus_id = 1;
            $reevaluationapplication->order_id=$order->id;
            $reevaluationapplication->save();
            $reevaluationfee = Reevaluationapplicationfee::where('exam_id',22)->first();
         //   $this->fireMail($candidate,$reevaluationapplication,$reevaluationfee);
            Session::put('messages','Payment is successful');
        }else{
            Session::put('messages','Fetched current status from payment gateway. Payment is not successful ');
        }
        
        return back();
    
    }

     public function recheckStatusAll($rid){
        set_time_limit(0);

        require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';

        error_reporting(0);
        $reevaluationapplication = Reevaluationapplication::find($rid);
        $nber_id = $reevaluationapplication->nber_id;
        $amount = $reevaluationapplication->amount;
        $working_key = \App\Configuration::where('attribute','ccavenue_working_key_nber_'.$nber_id)->first()->value;
        $access_code = \App\Configuration::where('attribute','ccavenue_access_code_nber_'.$nber_id)->first()->value;
        //$order=Order::find($oid);
        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
        $merchant_json_data =
        array(
            'order_email'=> $candidate->email,
            'from_date' => '01-12-2023',
            'order_bill_tel' => $candidate->contactnumber
        );
        
        $merchant_data = json_encode($merchant_json_data);
        $encrypted_data = payment_encrypt($merchant_data, $working_key);
        $final_data = 'enc_request='.$encrypted_data.'&access_code='.$access_code.'&command=orderLookup&request_type=JSON&response_type=JSON';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.ccavenue.com/apis/servlet/DoWebTrans");
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
        $success = false;

        foreach($obj->Order_Lookup_Result->order_Status_List->order as $order){
            if($order->order_bank_response == 'SUCCESS' && $order->order_amt == $amount){
                $success = true;
                $ordernumber = $order->order_no;
                $reference_no = $order->reference_no;
                $order_amt = $order->order_amt;
                $order_date_time = $order->order_date_time;
                $order_notes = $order->order_notes;
                $order = Order::where('order_number',$ordernumber)->first();
                if($order->count() > 0){
                    $order->order_status = "Success";
                    $order->save();
                }else{
                    $order = Order::firstOrCreate([
                        "order_number" => $ordernumber,
                        "ccavenue_referencenumber" => $reference_no,
                        "bank_referencenumber" => null,
                        "order_status" => "Success",
                        "status_message" => null,
                        "total_amount" => $amount,
                        "actual_amount" => $amount,
                        "transaction_fee" => 0.00,
                        "service_fee" => 0.00,
                        "payment_date" => date($order_date_time),
                        "payment_remarks" => 'Throught Email and phone lookup',
                        "transaction_remarks" => $order_notes,
                        "reference_parameters" => '',
                        "billing_name" => $candidate->name,
                        "billing_designation" => 'Student',
                        "billing_tel" => $candidate->contactnumber,
                        "billing_email" => $candidate->email,
                    ]);
                }
                $reevaluationapplication->orders()->attach($order->id);
                $reevaluationapplication->orderstatus_id = 1;
                $reevaluationapplication->order_id=$order->id;
                $reevaluationapplication->save();
            }
        }
        if($success == true){
            Session::put('messages','Payment is successful');
        }else{
            Session::put('messages','Fetched current status from payment gateway. Payment is not successful ');
        }
        
        return back();
    }


    public function bankdetails(Request $r){
        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
        $reevaluationapplication = Reevaluationapplication::find($r->reevaluationapplication_id);
        if($reevaluationapplication->candidate_id = $candidate->id){
            $rules = [
                "cname" => "required|string|min:4|max:255",
                "bank" => "required|string|min:4|max:255",
                "ifsccode" => "required|string|min:5|max:255",
                "accountno" => "required|string|min:6|max:255",
            ];
    
            $messages = [
                "cname.required" => "Please enter the Name"
            ];
            
            $this->validate($r, $rules, $messages);
             if(is_null($reevaluationapplication->refund)){
                Refund::create($r->toArray());
             }else{
                $refund = Refund::where('reevaluationapplication_id',$r->reevaluationapplication_id)->first();
                $refund->update($r->toArray());
             }
        }
        Session::put('messages','Updated bank details');
        return back();
    }

    public function cancel($id){
        $r = Reevaluationapplication::find($id);
        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
        if($candidate->id == $r->candidate_id){
        $r->orders()->detach();
        $r->reevaluationapplicationsubjects()->delete();
        $r->delete();
        Session::put('messages','Cancelled');
        }else{
            Session::put('messages','Could not cancel');
        }
        return back();
    }

    public function receipt($id){
        $reevaluationapplication = Reevaluationapplication::find($id);
        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
        $reevaluationfee = Reevaluationapplicationfee::where('exam_id',22)->first();
        if($candidate->id == $reevaluationapplication->candidate_id){
            return view('student.reevaluation.receipt', compact('reevaluationapplication','candidate','reevaluationfee'));
        }
        return back();
    }

}