<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Candidate;
use Auth;
use App\Application;
use App\Approvedprogramme;
use App\Exam;
use App\Attendance;
use Session;
use PDF;
use File;
use App\Language;
use App\Configuration;
use App\Newapplicant;
use App\Newapplication;
use App\Order;

use App\Supplimentaryapplicant;

use App\Supplimentaryapplication;

use Illuminate\Support\Facades\DB;

use App\Services\Exam\ApplicantService;

class HallticketController extends Controller
{

    private $applicantService;


    public function __construct(ApplicantService $applicant)
    {
        $this->middleware(['role:student']);
        $this->applicantService = $applicant;

    }

    public function june2025recheckPayment(){
        
        set_time_limit(0);

        require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';

        error_reporting(0);
        
        
        $candidate = \App\Candidate::where('user_id',Auth::user()->id)->first();

        $nber_id = $candidate->approvedprogramme->programme->nber_id;
        $working_key = \App\Configuration::where('attribute','ccavenue_working_key_nber_'.$nber_id)->first()->value;
        $access_code = \App\Configuration::where('attribute','ccavenue_access_code_nber_'.$nber_id)->first()->value;

        $applicant = \App\Allapplicant::where('exam_id',27)->where('candidate_id',$candidate->id)->first();
        $order = $applicant->orders()->first();
        //return $order->order_number;
        // $merchant_json_data =
        // array(
        //     'order_no' => $order->order_number,
        //     'reference_no' => $order->ccavenue_referencenumber
        // );

        $merchant_json_data =
        array(
            'order_email'=> $candidate->email,
            'from_date' => '10-05-2025',
            'order_bill_tel' => $candidate->contactnumber
        );
        
        $merchant_data = json_encode($merchant_json_data);
        $encrypted_data = payment_encrypt($merchant_data, $working_key);
      //  $final_data = 'enc_request='.$encrypted_data.'&access_code='.$access_code.'&command=orderStatusTracker&request_type=JSON&response_type=JSON';
        $final_data = 'enc_request='.$encrypted_data.'&access_code='.$access_code.'&command=orderLookup&request_type=JSON&response_type=JSON';

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
        return response()->json(['return'=>$information]);
        $dataSize = sizeof($information);
        for ($i = 0; $i < $dataSize; $i++) {
            $info_value = explode('=', $information[$i]);
            if ($info_value[0] == 'enc_response') {
                if ($info_value[1] == 'You are not allowed to perform this operation') {
                    $applicant->payment_status = 4;
                    $applicant->save();
                }
                $status = payment_decrypt(trim($info_value[1]), $working_key);
                return response()->json(['respnose'=>$status]);
            }
        }
        $obj = json_decode($status);
//                 echo "Response is: ".$result .'<br />';
//                 echo "Data Size: "; 
//                 echo $dataSize . '<br />';
//                 echo "Status is "; 

//                 echo $status;
//                 echo "Obj is" ;
//                 echo $obj;
//                 echo "order status";
//                 echo $obj->Order_Status_Result->order_status;
// dd();
        return response()->json($obj);
        if($obj->Order_Status_Result->order_status == 'Shipped'){
            $order->order_status = "Success";
            $order->save();
            $applicant->payment_status = 1;
            $applicant->order_id=$order->id;
            $applicant->save();
        }
        return response()->json($applicant->payment_status);
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
        $type = Session::get('type');
        $exam_id = Session::get('exam_id');


if($type=='examfee'){
                        $supplimentaryapplicant = \App\Allapplicant::where('exam_id',$exam_id)->where('candidate_id',$candidate->id)->where('payment_status','!=',1)->first();


}
else{



        if($type=='supplimentary'){
            $supplimentaryapplicant = Supplimentaryapplicant::where('exam_id',24)->where('candidate_id',$candidate->id)->where('payment_status','!=',1)->first();
        }else{
            if($type=='examapplication'){
                $supplimentaryapplicant = Newapplicant::where('exam_id',25)->where('candidate_id',$candidate->id)->where('payment_status','!=',1)->first();
            }else{
                if($type=='supplimentary2025'){
                                            $supplimentaryapplicant = \App\Allapplicant::where('exam_id',26)->where('candidate_id',$candidate->id)->where('payment_status','!=',1)->first();

                   
                }else{
                     if($type=='june2025'){
                        $supplimentaryapplicant = \App\Allapplicant::where('exam_id',27)->where('candidate_id',$candidate->id)->where('payment_status','!=',1)->first();
                    }else{
                    // $supplimentaryapplicant = Newapplicant::where('exam_id',25)->where('candidate_id',$candidate->id)->where('additional_payment_status','!=',1)->first();
                    }
                }
            }
        }
    }
      //  $reevaluationfee = Reevaluationapplicationfee::where('exam_id',22)->first();
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
                          
                                $order->update(["ccavenue_referencenumber" => $information[1]]);
                         
                        }
                        if($i == 2) {
                            $order->update(["bank_referencenumber" => $information[1]]);
                        }
                        if($i == 3) {
                            $order->update(["order_status" => $information[1]]);
                            if($information[1]=="Success"){
                                $supplimentaryapplicant->payment_status = 1;
                                $supplimentaryapplicant->order_id=$order->id;
                                $supplimentaryapplicant->save();
                            }
                        }
                        if($i == 8) {
                            $order->update(["status_message" => $information[1]]);
                        }
                        if($i == 10) {
                            if($order->actual_amount != $information[1]){
                                $supplimentaryapplicant->payment_status = 0;
                                $supplimentaryapplicant->save();
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
                // if($order->order_status == 'Invalid'){
                //     Session::put('error', $order->status_message);
                //     if($type=='supplimentary'){
                //         return redirect('examapplication');
                //     }else{
                //         if($type=='supplimentary2025'){
                //             return redirect('student/exam/applications');
                //         }else{
                //             return redirect('examapplication/25');
                //         }
                //     }
                // }
                if($order->order_status != "Success"){
                    if(Session::get('order_number') != $order->order_number){
                        $order->order_status = "Failed";
                        $order->save();
                        if($type=='examapplication'){
                            $supplimentaryapplicant->payment_status = 20;
                        }
                        if($type=='add_examapplication'){
                            $supplimentaryapplicant->additional_payment_status = 30;
                        }
                        if($type=='supplimentary2025'){
                            $supplimentaryapplicant->payment_status = 0;
                        }
                        $supplimentaryapplicant->order_id= 0;
                        $supplimentaryapplicant->save(); 
                    }else{
                        //$supplimentaryapplicant->payment_status = 3;
                        //$supplimentaryapplicant->save();


                        $merchant_json_data =
                        array(
                            'order_no' => $order->order_number,
                            'reference_no' => $order->ccavenue_referencenumber
                        );

                        // $merchant_json_data =
                        // array(
                        //     'order_email'=> $candidate->email,
                        //     'from_date' => '03-03-2024',
                        //     'order_bill_tel' => $candidate->contactnumber
                        // );
                        
                        $merchant_data = json_encode($merchant_json_data);
                        $encrypted_data = payment_encrypt($merchant_data, $working_key);
                        $final_data = 'enc_request='.$encrypted_data.'&access_code='.$access_code.'&command=orderStatusTracker&request_type=JSON&response_type=JSON';
                      //  $final_data = 'enc_request='.$encrypted_data.'&access_code='.$access_code.'&command=orderLookup&request_type=JSON&response_type=JSON';

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
                                if ($info_value[1] == 'You are not allowed to perform this operation') {
                                    $supplimentaryapplicant->payment_status = 4;
                                    $supplimentaryapplicant->save();
                                }
                                $status = payment_decrypt(trim($info_value[1]), $working_key);
                            }
                        }
                        $obj = json_decode($status);
        //                 echo "Response is: ".$result .'<br />';
        //                 echo "Data Size: "; 
        //                 echo $dataSize . '<br />';
        //                 echo "Status is "; 

        //                 echo $status;
        //                 echo "Obj is" ;
        //                 echo $obj;
        //                 echo "order status";
        //                 echo $obj->Order_Status_Result->order_status;
        // dd();
                        if($obj->Order_Status_Result->order_status == 'Shipped'){
                            $order->order_status = "Success";
                            $order->save();
                            if($type=='supplimentary2025'){
                                $supplimentaryapplicant->payment_status = 1;
                            }
                            if($type=='june2025'){
                                $supplimentaryapplicant->payment_status = 1;
                            }
                            if($type=='examapplication'){
                                $supplimentaryapplicant->payment_status = 1;
                            }
                            if($type=='add_examapplication'){
                                $supplimentaryapplicant->additional_payment_status = 1;
                            }
                            $supplimentaryapplicant->order_id=$order->id;
                            $supplimentaryapplicant->save();
                        }
                    }
                }
                if($supplimentaryapplicant->payment_status == 1){
                    //    $this->fireMail($candidate,$reevaluationapplication,$reevaluationfee);
                }
                
                if($type=='supplimentary'){
                    return redirect('examapplication');
                }else{
                    if($type=='supplimentary2025' || $type=='june2025'){
                        return redirect('student/exam/applications');
                    }
                    return redirect('examapplication/25');
                }
            }
            else {
                if($type=='supplimentary'){
                    return redirect('examapplication');
                }else{
                    if($type=='supplimentary2025' || $type=='june2025'){
                        return redirect('student/exam/applications');
                    }else{
                        return redirect('examapplication/25');
                    }
                }
            }
        }
        else {
            if($type=='supplimentary'){
                return redirect('examapplication');
            }else{
                if($type=='supplimentary2025' || $type=='june2025'){
                    return redirect('student/exam/applications');
                }else{
                    return redirect('examapplication/25');
                }
            }
        }
    }

    public function ccavenuePaymentGatewayRequestHandler(Request $request) {
        $payment = $request->payment;
        $data = $request->except('_token');
        $return = 0;
       // $institute = Institute::where('user_id',Auth::user()->id)->first();
       // $academicyear_id = \App\Academicyear::where('current',1)->first()->id;
        $nber_id = Session::get('nber_id');

        $exam_id=$request->exam_id;


        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
         Session::put('type',$request->type);
        //$enrolmentfee  = Enrolmentfeepayment::where('institute_id',$institute->id)e->where('academicyear_id',$academicyear_id)->where('orderstatus_id','!=',1)->where('nber_id',$nber_id)->first();
         Session::put('exam_id',$request->exam_id);


 if($request->type=='examfee' && $request->exam_id > 25){
            $applicant = \App\Allapplicant::where('exam_id',$request->exam_id)->where('candidate_id',$candidate->id)->first();
        }else{
        
        if($request->type=='supplimentary'){
            $applicant = Supplimentaryapplicant::where('exam_id',24)->where('candidate_id',$candidate->id)->first();
        }else{
            if($request->type=='supplimentary2025'){
                $applicant = \App\Allapplicant::where('exam_id',26)->where('candidate_id',$candidate->id)->first();
                
                if($payment == 'Recheck'){
                    $return = $this->recheckSupplimentaryPayment($applicant->id);
                }
            }else{
                if($request->type=='june2025'){
                    $applicant = \App\Allapplicant::where('exam_id',27)->where('candidate_id',$candidate->id)->first();
                    
                    if($payment == 'Recheck'){
                        $return = $this->recheckSupplimentaryPayment($applicant->id);
                    }
                }else{
                    $applicant = Newapplicant::where('exam_id',25)->where('candidate_id',$candidate->id)->first();
                }
            }
        }
    }
        if($return == 1) {
            return redirect('student/exam/applications');
        }
        $merchant_id = Configuration::where('attribute','ccavenue_merchant_id_nber_'.$nber_id)->first()->value;
        
        
        // merchant_param1 = EnrolmentfeeId,InstituteId,CandidateId
        $merchant_param1 =  '01,' . $candidate->id . ',' . $nber_id;

        //$data += ['redirect_url' => "https://rcinber.org.in/institute/enrolmentpayments/ccavenuepaymentgatewayresponsehandler"];
        //$data += ['cancel_url' => "https://rcinber.org.in/institute/enrolmentpayments/ccavenuepaymentgatewayresponsehandler"];
        $data += ['redirect_url' => url("/student/examapplication/ccavenuepaymentgatewayresponsehandler")];
        $data += ['cancel_url' => url("student/examapplication/ccavenuepaymentgatewayresponsehandler")];

        $data += ['currency' => 'INR'];
        $data += ['merchant_id' => $merchant_id];
        $data += ['merchant_param1' => $merchant_param1];
        if($request->type=='supplimentary2025'){
            $data += ['merchant_param2' => 'Supplimentary 2025 Exam Fee'];
        }else{
            $data += ['merchant_param2' => 'Exam Fee'];
        }
        $data['amount'] = Session::get('total');

      //  $ordercount = Order::where('order_number', Session::get('order_number'))->count();
        //  $order = $applicant->orders()->first();
        // if ($order > 0) {
        //     Session::put('messages','Session Expired!, Please try again');
        //     return back();
        // }



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
                "candidate_id" => $candidate->id,

            ]);
           // $enrolmentfee->orders()->attach($order->id);
            //  $applicant->orders()->attach($order->id);

            $applicant->order_id = $order->id;
            $applicant->save();
            Session::put('order_number',$data["order_number"]);
        
        Session::put('data',$data);
        Session::put('nber_id',$nber_id);
        return view('student.reevaluation.paymentgateway_request_handler');
    }

    public function examapplication24(Request $r){
        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
        $na = Newapplicant::where('candidate_id',$candidate->id)->first();
        if(!is_null($na)){
            $this->saveapplications($r,$candidate,$na,1);
        }else{
            $na = Newapplicant::create([
                'candidate_id' => $candidate->id,
                'exam_id' => 25,
                'institute_id' => $candidate->approvedprogramme->institute_id,
                'programme_id' =>  $candidate->approvedprogramme->programme_id,
                'approvedprogramme_id' => $candidate->approvedprogramme_id,
                'language_id' => $r->languageId
             ]);
            $this->saveapplications($r,$candidate,$na,1);
        }
        return redirect('examapplication/25');
    }

    public function saveapplications($r,$candidate,$na,$additional){
            $count = 0;
            $scount = 0;
            $payablecount = 0;
            foreach ($r->subjectAppliedStatus as $subjectIdCheckbox){
                if($subjectIdCheckbox == '1') {
                    $subject = \App\Subject::find($r->subjectId[$count]);
                    if(!$subject->alternative){
                        Newapplication::create([
                            'candidate_id' => $candidate->id,
                            'newapplicant_id' => $na->id,
                            'subject_id' => $r->subjectId[$count],
                            'additional_application' => 1
                        ]);
                    }else{
                        $applied = Newapplication::where('candidate_id',$candidate->id)->where('subject_id',$subject->alternative_of)->first();
                        if(!is_null($applied)){
                            $applied->alternative_paper = $r->subjectId[$count];
                            $applied->save();
                        }else{
                            Newapplication::create([
                                'candidate_id' => $candidate->id,
                                'newapplicant_id' => $na->id,
                                'subject_id' => $subject->alternative_of,
                                'alternative_paper' =>  $r->subjectId[$count],
                                'additional_application' => 1
                        ]);
                        }

                    }
                   $scount++;
                   if($subject->is_external==1){
                        $payablecount++;
                   }
                }
                $count++;
            }
            $na->amount = 100 * $payablecount;
            if($additional==1){
                $na->additional_amount = 100 * $payablecount;
            }
            $na->save();
    }


    public function examapplication(Request $r){
        
        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
        $sa = Supplimentaryapplicant::where('candidate_id',$candidate->id)->first();
        if(!is_null($sa)){
            Session::put('error','Already Applied');
            return back();
        }else{
            $sa = Supplimentaryapplicant::create([
                'candidate_id' => $candidate->id,
                'exam_id' => 24,
                'institute_id' => $candidate->approvedprogramme->institute_id,
                'programme_id' =>  $candidate->approvedprogramme->programme_id,
                'approvedprogramme_id' => $candidate->approvedprogramme_id,
                'language_id' => $r->languageId
             ]);
            $count = 0;
            $subjects = '';
            $scount = 0;
            foreach ($r->subjectAppliedStatus as $subjectIdCheckbox){
                if($subjectIdCheckbox == '1') {
                   Supplimentaryapplication::create([
                        'candidate_id' => $candidate->id,
                        'supplimentaryapplicant_id' => $sa->id,
                        'subject_id' => $r->subjectId[$count]
                   ]);
                   $scount++;
                }
                $count++;
            }
            $sa->amount = 100 * $scount;
            $sa->save();
            return back();
        }
    }
    public function cancelapplication($id){
        $sa = Supplimentaryapplicant::find($id);
        if(!is_null($sa)){
            $candidate = Candidate::where('user_id',Auth::user()->id)->first();
            if($candidate->id == $sa->candidate_id){
            $sa->orders()->detach();
            $sa->applications()->delete();
            $sa->delete();
            Session::put('messages','Cancelled');
            }else{
                Session::put('messages','Could not cancel');
            }
        }
        return back();
    }

    public function cancelapplication25($id){
        $sa = Newapplicant::find($id);
        if(!is_null($sa)){
            $candidate = Candidate::where('user_id',Auth::user()->id)->first();
            if($candidate->id == $sa->candidate_id){
            $sa->orders()->detach();
            $sa->applications()->delete();
            $sa->delete();
            Session::put('messages','Cancelled');
            }else{
                Session::put('messages','Could not cancel');
            }
        }
        return back();
    }

    public function applyjune2024(Request $r){
        $candidate = \App\Candidate::where('user_id',Auth::user()->id)->first();
        $candidate_id= $candidate->id;
        $exam = Exam::find(25);
        if(!is_null($candidate_id)){
            $na = \App\Newapplicant::where('candidate_id',$candidate_id)->first();
            $approvedprogramme = $candidate->approvedprogramme;
            $course_id = $approvedprogramme->programme->course_id;
            if(is_null($na)){
                if($course_id == 16 || $course_id == 20){
            //if(is_null($na) || $r->has('additional')){
                //return 'Application is closed';
                    $eligible_first_year = true;
                    $eligible_second_year = true;
                    if($candidate->no_of_first_year_attempts > 2){
                        $eligible_first_year = false;
                    }
                    if($approvedprogramme->programme->numberofterms == 2){
                        if(!$eligible_first_year){
                            if(($candidate->practical_first_year + $candidate->theroy_first_year) == ($candidate->theroy_first_year_passed + $candidate->practical_first_year_passed) ){
                                $eligible_first_year = true;
                            }
                        }
                    }
                    if($candidate->no_of_second_year_attempts > 2){
                        $eligible_second_year = false;
                    }
                    if($eligible_first_year && $eligible_second_year ){
                        if($candidate->approvedprogramme->academicyear_id > 7){
                            if($candidate->coursecompleted_status != 1){
                                $attendance = \App\Attendance::where('candidate_id',$candidate_id)->where('exam_id',25)->first();
                                if(is_null($attendance) && $candidate->approvedprogramme->academicyear_id < 10){
                                    $attendance = \App\Attendance::where('candidate_id',$candidate_id)->where('exam_id',22)->first();
                                }
                                if(!is_null($attendance)){
                                    if(($attendance->attendance_t >= 75 || ($attendance->attendance_t >= 70 && $attendance->exemption == 1) ) && ($attendance->attendance_p >= 75 || ($attendance->attendance_p >= 70 && $attendance->exemption == 1) )  ){
                                        $programme_id = $candidate->approvedprogramme->programme_id;
                                        if($candidate->approvedprogramme->academicyear_id == 12){
                                            /* REGULAR EXAM */
                                            $subjects = DB::select('
                                            select s.id, s.scode, st.type as type, s.sname, s.syear, alternative, alternative_of,  s.has_alternative from subjects s 
                                            left join subjecttypes st on st.id = s.subjecttype_id
                                            left join programmes p on p.id = s.programme_id
                                                where   p.id = '.$programme_id.' and s.syear = 1 and s.alternative = 0 order by s.syear, s.subjecttype_id, s.has_alternative, s.sortorder
                                            ');

                                            /* Addiional Applications for those missed to apply for practical */
    /*
                                            $subjects = DB::select('
                                            select s.id, s.scode, st.type as type, s.sname, s.syear, alternative, alternative_of,  s.has_alternative from subjects s 
                                    left join subjecttypes st on st.id = s.subjecttype_id
                                            left join programmes p on p.id = s.programme_id
                                            left join newapplications na on na.candidate_id = '. $candidate_id.' and na.subject_id = s.id
                                                where   p.id = '.$programme_id.'  and s.syear = 1 and s.subjecttype_id = 2 and s.alternative = 0  and na.subject_id is null                                             
                                                order by s.syear, s.subjecttype_id, s.has_alternative, s.sortorder
                                            ');
    */
                                        }else{
                                            /* REGULAR EXAM */
                                            
                                            $subjects = DB::select(' 
                                            select s.id, s.scode, st.type as type, s.sname, s.syear, s.alternative, s.alternative_of, s.has_alternative from subjects s 
                                            left join programmes p on p.id = s.programme_id
                                            left join subjecttypes st on st.id = s.subjecttype_id
                                            where     p.id = '.$programme_id.'  and  s.id  not in (
                                            select distinct t2.subject_id  from (
                                        select   subject_id,  sum(if(result_id=1,1,0)) as result_id from
                                                (select subject_id, reevaluation_result_id as result_id from currentapplications ca
                                                where candidate_id = '.$candidate_id .'
                                                union 
                                                select subject_id,  result_id from applications a
                                                where candidate_id = '.$candidate_id .'
                                                union
                                                select subject_id, result_id from supplimentaryapplications sa
                                                where candidate_id = '.$candidate_id .'
                                                ) as t1

                                                group by subject_id
                                                having result_id != 0 ) as t2
                                                left join subjects s on s.id = t2.subject_id 
                                                ) 
                                                order by s.syear, s.subjecttype_id, s.sortorder
                                                ');
                                                    

                                                    /* Addiional Applications for those missed to apply for practical */
                                                /*$subjects = DB::select('
                                                select s.id, s.scode, st.type as type, s.sname, s.syear, s.alternative, s.alternative_of, s.has_alternative from subjects s 
                                            left join programmes p on p.id = s.programme_id
                                            left join subjecttypes st on st.id = s.subjecttype_id
                                            left join newapplications na on na.candidate_id =  '. $candidate_id.' and na.subject_id = s.id 
                                            where   s.subjecttype_id = 2 and   p.id = '.$programme_id.'  and na.subject_id is null  and  s.id  not in (
                                            select distinct t2.subject_id  from (
                                        select   subject_id,  sum(if(result_id=1,1,0)) as result_id from
                                                (select subject_id, reevaluation_result_id as result_id from currentapplications ca
                                                where candidate_id = '.$candidate_id .'
                                                union 
                                                select subject_id,  result_id from applications a
                                                where candidate_id = '.$candidate_id .'
                                                ) as t1
                                                group by subject_id
                                                having result_id != 0 ) as t2
                                                left join subjects s on s.id = t2.subject_id 
                                                ) 
                                                order by s.syear, s.subjecttype_id, s.sortorder
                                                ');*/
                                        }
                                        $languages = Language::where('language', '!=', 'NOT APPLICABLE')->get(['id', 'language']);

                                        return view('student.examapplication.candidate_exam_application_form_june_2024', compact('exam', 'approvedprogramme', 'candidate', 'subjects', 'languages'));
                                        
                                    }else{
                                        Session::flash('messages','Classroom attendance is not sufficient');   
                                    }
                                }else{
                                    Session::flash('messages','Classroom attendance is not available');   
                                }
                            }else{
                                Session::flash('messages','Course completed');
                            }
                        }else{
                            Session::flash('messages','Please check the eligiblity.');
                        }
                    }else{
                        Session::flash('messages','Please check the eligiblity..');
                    }
                }else{
                    Session::flash('messages','Exam Applications not open.');
                }
            }else{
                //if($na->payment_status == 0){
                 //   $this->recheckSupplimentaryPayment($sa->id);
                //}
                $na = \App\Newapplicant::where('candidate_id',$candidate_id)->first();

                $fy_count = $this->getNumberOfPapers($na,1);
                $sy_count = $this->getNumberOfPapers($na,2);

                $institute = \App\Institute::find($candidate->approvedprogramme->institute_id);

                //$exam_center = $this->applicantService->getExamcenter($institute);
                
                return view('student.examapplication.candidate_exam_application_june_2024', compact('exam','na', 'approvedprogramme', 'candidate','fy_count','sy_count'));
            }
        }
        //Session::flash('messages','Please check the eligibiliy');
        return back();
        
    }
    public function apply(){
        $candidate = \App\Candidate::where('user_id',Auth::user()->id)->first();
        $candidate_id= $candidate->id;
        $exam = Exam::find(25);
        if(!is_null($candidate_id)){
            $ca = \App\Currentapplicant::where('candidate_id',$candidate_id)->first();
            $sa = \App\Supplimentaryapplicant::where('candidate_id',$candidate_id)->first();
            $approvedprogramme = $candidate->approvedprogramme;
            if(is_null($sa)){
                $eligible = 0;
                if(is_null($ca)){
                    $eligible = 1;
                }else{
                    if(
                        //!($ca->gracemark_marksheet_processing == 0  && $ca->gracemark_processed == 1)
                        $ca->withheld == 0
                        && $ca->incomplete != 1
                    ){
                        $eligible = 1;
                    }
                }
                if($eligible){
                    if($candidate->approvedprogramme->academicyear_id > 7 && $candidate->approvedprogramme->academicyear_id  < 11  ){
                        if($candidate->coursecompleted_status != 1){
                            $subjects = DB::select(' select t2.subject_id as id, s.scode, st.type as type, s.sname, s.syear from (
                                select subject_id,  sum(if(result_id=1,1,0)) as result_id, internal_mark from
                                (select subject_id, reevaluation_result_id as result_id, internal_mark as internal_mark from currentapplications ca
                                where candidate_id = '.$candidate_id.'
                                union 
                                select subject_id,  result_id, internal_mark as internal_mark from applications a
                                where candidate_id = '.$candidate_id.') as t1
                                group by subject_id
                                having result_id = 0 ) as t2
                                left join subjects s on s.id = t2.subject_id 
                                left join subjecttypes st on st.id = s.subjecttype_id
                                where subjecttype_id = 1 and (s.imin_marks  <=  t2.internal_mark or s.is_internal = 0 )
                                order by s.syear');
                            $languages = Language::where('language', '!=', 'NOT APPLICABLE')->get(['id', 'language']);
                            return view('student.examapplication.candidate_exam_application_form', compact('exam', 'approvedprogramme', 'candidate', 'subjects', 'languages'));
                        }else{
                            Session::flash('messages','Course completed');
                        }
                    }else{
                        Session::flash('messages','Please check the eligiblity.');
                    }
                }else{
                    Session::flash('messages','Please check the eligiblity..');
                }
            }else{
                if($sa->payment_status == 0){
                 //   $this->recheckSupplimentaryPayment($sa->id);
                }
                $sa = \App\Supplimentaryapplicant::where('candidate_id',$candidate_id)->first();

                $fy_count = $this->getNumberOfPapers($sa,1);
                $sy_count = $this->getNumberOfPapers($sa,2);

                $institute = \App\Institute::find($candidate->approvedprogramme->institute_id);

                $exam_center = $this->applicantService->getExamcenter($institute);
                
                return view('student.examapplication.candidate_exam_application', compact('exam','sa', 'approvedprogramme', 'candidate','fy_count','sy_count','exam_center'));
            }
        }
        //Session::flash('messages','Please check the eligibiliy');
        return back();
        
    }
    public function downloadht($cid,$id,$term)
    {

        $applicant = \App\Supplimentaryapplicant::where('candidate_id',$cid)->first();
        if($applicant->block != 1 ){
            $format = 'pdf';
                
            $district_id = $applicant->candidate->district_id;
            $exam_center = $this->applicantService->getExamcenter($applicant->institute,2,$district_id);
            view()->share('applicant',$applicant);
            view()->share('exam_center',$exam_center);
            view()->share('term',$term);
            view()->share('format',$format);

            $headers = array(
                'Content-Type: application/pdf',
            );
            try{
                $pdf = PDF::loadView('common.exam.hallticket')->setPaper('a4', 'portrait');
                return $pdf->download('hallticket_'.$applicant->candidate->enrolmentno.'_term_'.$term.'.pdf');
            }catch(\Exception $e){
                $format = 'html';
                return view('common.exam.hallticket',compact(
                    'applicant',
                    'exam_center',
                    'term',
                    'format'
                ));
            }
        }

    }

    public function getNumberOfPapers($sa,$year){
        $count = 0;
        foreach($sa->applications as $application){
            if($application->subject->syear == $year){
                $count ++;
            }
        }
        return $count;
    }
    public function index(){
        $c = Candidate::where('user_id',Auth::user()->id)->first();
        return view('student.hallticket.index',compact('c'));
    }

    public function recheckSupplimentaryPayment($rid){
        set_time_limit(0);
        //return "Y";
        require_once base_path().'/resources/views/paymentgateway/CryptoNewForAPI.blade.php';
        
        error_reporting(0);
        $type = Session::get('type');
        if($type=='supplimentary'){
            $applicant = Supplimentaryapplicant::find($rid);
        }else{
            if($type=='supplimentary2025'){
                $applicant = \App\Allapplicant::find($rid);
            }else{
                $applicant = Newapplicant::find($rid);
            }
        }
        $nber_id = $applicant->candidate->approvedprogramme->programme->nber_id;
        $amount = $applicant->amount;
        
        $working_key = \App\Configuration::where('attribute','ccavenue_working_key_nber_'.$nber_id)->first()->value;
        $access_code = \App\Configuration::where('attribute','ccavenue_access_code_nber_'.$nber_id)->first()->value;
        //$order=Order::find($oid);
        $candidate = Candidate::where('id',$applicant->candidate_id)->first();
        if(is_null($candidate->email)){
            Session::put('error','Kindly Update your email Address to continue.');
            if($type=='supplimentary2025'){
                return redirect('student/exam/applications');
            }
            return back();
        }
        if($candidate->duplicate_mobile_no == 1){
            Session::put('error','Please ensure the mobile number is unique.');
            if($type=='supplimentary2025'){
                return redirect('student/exam/applications');
            }
            return back();
        }

        if($type=='supplimentary'){
        $merchant_json_data =
        array(
            'order_email'=> $candidate->email,
            'from_date' => '03-03-2024',
            'order_bill_tel' => $candidate->contactnumber
        );
        }else{
            if($type=='supplimentary2025'){
                $merchant_json_data =
                array(
                    'order_email'=> $candidate->email,
                    'from_date' => '20-12-2024',
                    'order_bill_tel' => $candidate->contactnumber
                );   
            }
            $merchant_json_data =
            array(
                'order_email'=> $candidate->email,
                'from_date' => '20-12-2024',
                'order_bill_tel' => $candidate->contactnumber
            );  
        }
        
        $merchant_data = json_encode($merchant_json_data);
        $encrypted_data = payment_encryptapi($merchant_data, $working_key);
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
       // echo "Response is: ".$result .'<br />';
       // echo "Data Size: "; 
       // echo $dataSize . '<br />';
        $dataSize = sizeof($information);
        for ($i = 0; $i < $dataSize; $i++) {
            $info_value = explode('=', $information[$i]);
            if ($info_value[0] == 'enc_response') {
                $status = payment_decryptapi(trim($info_value[1]), $working_key);
                
            }
        }

        //echo $status;
        //dd();
        $obj = json_decode($status);
        $success = false;
        $count  = 0;
        $o = '';
        if(!is_null($obj->Order_Lookup_Result->error_desc)){
            Session::flash('error',$obj->Order_Lookup_Result->error_desc);
            //$applicant->orders()->detach();
            $applicant->payment_status = 0;
            $applicant->order_id = null;
            $applicant->save();
            if($type=='supplimentary2025'){
                return 0;
            }
            return back();

        }
      //  $applicant->orders()->detach();
       
       if($obj->Order_Lookup_Result->total_records > 1){
            foreach($obj->Order_Lookup_Result->order_Status_List->order as $order){
                $count ++;
                $ordernumber = $order->order_no;
                $reference_no = $order->reference_no;
                $order_amt = $order->order_amt;
                $order_date_time = \Carbon\Carbon::parse($order->order_date_time)->format('Y-m-d H:i:s');
                $order_notes = $order->order_notes;
                $sorder = Order::where('order_number',$ordernumber)->first();
                $order_status = $sorder->order_status;
                if($order->order_status == 'Shipped' && $order->order_amt == $amount){
                    $order_status = "Success";
                    $success = true;
                    $applicant->order_id=$sorder->id;
                }
                if(!is_null($sorder)){
                    $sorder->order_status = $order_status;
                    $sorder->payment_date = $order_date_time;
                    $sorder->save();
                }else{
                    $sorder = Order::firstOrCreate([
                        "order_number" => $ordernumber,
                        "ccavenue_referencenumber" => $reference_no,
                        "bank_referencenumber" => null,
                        "order_status" => $order_status,
                        "status_message" => null,
                        "total_amount" => $amount,
                        "actual_amount" => $amount,
                        "transaction_fee" => 0.00,
                        "service_fee" => 0.00,
                        "payment_date" => $order_date_time,
                        "payment_remarks" => 'Throught Email and phone lookup - Supplementary 2025',
                        "transaction_remarks" => $order_notes,
                        "reference_parameters" => '',
                        "billing_name" => $candidate->name,
                        "billing_designation" => 'Student',
                        "billing_tel" => $candidate->contactnumber,
                        "billing_email" => $candidate->email,
                    ]);
                }
                $applicant->orders()->attach($sorder->id); 
                
            }
        }else{
            $order = $obj->Order_Lookup_Result->order_Status_List->order;
            $count++;
            $ordernumber = $order->order_no;
            $reference_no = $order->reference_no;
            $order_amt = $order->order_amt;
            $order_date_time = \Carbon\Carbon::parse($order->order_date_time)->format('Y-m-d H:i:s');
            $order_notes = $order->order_notes;
            $sorder = Order::where('order_number',$ordernumber)->first();
            $order_status = $sorder->order_status;
            if($order->order_status == 'Shipped' && $order->order_amt == $amount){
                $order_status = "Success";
                $success = true;
                $applicant->order_id=$sorder->id;
            }
            if(!is_null($sorder)){
                $sorder->order_status = $order_status;
                $sorder->payment_date = $order_date_time;
                $sorder->save();
            }else{
                $sorder = Order::firstOrCreate([
                    "order_number" => $ordernumber,
                    "ccavenue_referencenumber" => $reference_no,
                    "bank_referencenumber" => null,
                    "order_status" => $order_status,
                    "status_message" => null,
                    "total_amount" => $amount,
                    "actual_amount" => $amount,
                    "transaction_fee" => 0.00,
                    "service_fee" => 0.00,
                    "payment_date" => $order_date_time,
                    "payment_remarks" => 'Throught Email and phone lookup - Supp 2025 ',
                    "transaction_remarks" => $order_notes,
                    "reference_parameters" => '',
                    "billing_name" => $candidate->name,
                    "billing_designation" => 'Student',
                    "billing_tel" => $candidate->contactnumber,
                    "billing_email" => $candidate->email,
                ]);
            }
            $applicant->orders()->attach($sorder->id); 
            
        }
        if($success == true){
            $applicant->payment_status = 2;
            $applicant->save();
            Session::put('messages','Payment is successful');
            return 1;
        }else{
            $applicant->payment_status = 0;
            $applicant->order_id= null;
            $applicant->save();
            //Session::put('messages','Fetched current status from payment gateway. Payment is not successful ');
            return 0;
        }
        return '1';
    }

    public function timetable(){
        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
        $exam_id = 2;
        $applications = Application::where('candidate_id',$candidate->id)->where('exam_id',$exam_id)->whereHas('subject', function($query) use ($exam_id){
                    $query->whereHas('examtimetables', function($r) use($exam_id){
                        $r->where('exam_id',$exam_id);
                    });
            })->with('subject')->get();
            $count = 1;
            $table  = '';

            $applications->map(function ($appn) use($exam_id){
                $startdate = $appn->subject->startdate($exam_id);
                $appn['startdate'] = $startdate;
                return $appn;
            });
            
            foreach($applications->sortBy('startdate') as $a){
                $startdate = $a->subject->startdate($exam_id);
                if($startdate!=''){
                    $startdatetime = \Carbon\Carbon::parse($startdate)->toFormattedDateString() . ' '.  \Carbon\Carbon::parse($startdate)->format('h:i A') . ' to ';
                }else{
                    $startdatetime = '';
                }
                $enddate  = $a->subject->enddate($exam_id);
                if($enddate!=''){
                    $endtime = \Carbon\Carbon::parse($enddate)->format('h:i A');
                }else{
                    $endtime ='';
                }
                $table .= '<tr><td>'.$count.'</td><td align="left">'.$a->subject->scode.'</td><td  align="left">'. $a->subject->sname.'</td><td align="left">'. $startdatetime . $endtime .'</td><td></td></tr>';
        $count +=1;
            }


        $timetable ="<table style='width:100%;' class='table'>".$table."</table>";
        return view('student.hallticket.timetable',compact('candidate','timetable'));
    }
    public function download(Request $request){
        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
        //return $candidate->attendances->where('exam_id','2')->count();
        //if(Auth::user()->id==$candidate->approvedprogramme->institute->user_id){
            //$application = Application::find($request->application_id);
            if($candidate->attendances){
                if($candidate->attendances->where('exam_id','2')->count()<1){
                    Session::flash('error','Hallticket not ready!  Contact your Institute. ');
                    return back();
                }else{
                    if($candidate->attendances->where('exam_id','2')->first()->attendance_t < 75){
                        if($candidate->attendances->where('exam_id','2')->first()->exemption != 2){
                            Session::flash('error','Hallticket not ready!   Contact your Institute.');
                            return back();
                        }
                    }
                }
            }else{
                 Session::flash('error','Hallticket not ready!   Contact your Institute.');
                return back();
  
            }
            if($candidate->approvedprogramme->programme->programmegroup->hallticket_download!=1){
                Session::flash('error','Hallticket not ready! Pleaese try again later.');
                return back();
            }
            $exam_id = $request->exam_id;
            $exam = Exam::find($exam_id);
            $date = \Carbon\Carbon::parse($candidate->dob);
            $dob =  $date->toFormattedDateString();

            $applications = Application::where('candidate_id',$candidate->id)->where('exam_id',$exam_id)->whereHas('subject', function($query) use ($exam_id){
                    $query->whereHas('examtimetables', function($r) use($exam_id){
                        $r->where('exam_id',$exam_id);
                    });
            })->with('subject')->get();
            $count = 1;
            $table  = '';

            $applications->map(function ($appn) use($exam_id){
                $startdate = $appn->subject->startdate($exam_id);
                $appn['startdate'] = $startdate;
                return $appn;
            });
            
            foreach($applications->sortBy('startdate') as $a){
                $startdate = $a->subject->startdate($exam_id);
                if($startdate!=''){
                    $startdatetime = \Carbon\Carbon::parse($startdate)->toFormattedDateString() . '<br />'.  \Carbon\Carbon::parse($startdate)->format('h:i A') . ' to ';
                }else{
                    $startdatetime = '';
                }
                $enddate  = $a->subject->enddate($exam_id);
                if($enddate!=''){
                    $endtime = \Carbon\Carbon::parse($enddate)->format('h:i A');
                }else{
                    $endtime ='';
                }
                $table .= '<tr><td>'.$count.'</td><td align="left">'.$a->subject->scode.'</td><td width="300px" align="left">'. $a->subject->sname.'</td><td align="left">'. $startdatetime . $endtime .'</td><td></td></tr>';
        $count +=1;
            }


            $html = '<style> html{margin:2 5px;} </style>
            <body style="margin:0px;">
            <table border="1" style="border-collapse:collapse; font-size:14px;" cellpadding="0" cellspacing="0" width="100%" bordercolor="#000000">
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="center" width="110">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td><br><img src="'. public_path() . '/images/hallticket/niepmd.png" width="70"  style ="padding-left:5px;" height="90"></td>
                                        </tr>
                                    </table>
                                </td>
                                <td align="center">
                                    <b><font size="4">National Board of Examination in Rehabilitation</font></b><br>
                                    (An Adjunct Body of RCI, under MSJE, DEPwD,GoI)<br/>
                                    Examination Conducted by:<br>
                                    <b><font size="2">National Institute for Empowerment of Persons with Multiple Disabilities (NIEPMD)</font></b><br>
                                    (DEPwD, MSJE, GoI)<br>
                                    East Coast Road, Muttukadu, Kovalam, P.O, Chennai-603 112, Tamil Nadu.<br>
                                    NBER-RCI, Fax: 044-27472389 Tel: 044-27472104, 27472113, 27472046 / Extn: 492<br>
                                    Website: www.niepmd.tn.nic.in &nbsp;&nbsp;&nbsp;Email: niepmd.examinations@gmail.com                       
                                </td>
                                <td width="110" align="center">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td valign="top">
                                                <b><u><font face="Calibri" size="2">CANDIDATE\'S COPY</font></u></b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><br><img src="'. public_path() . '/images/hallticket/rci.png" width="72" height="90"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr height="8">
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center" style="line-height:1.2em;">
                                    <b><font size="3">EXAMINATION '. $exam->name .'</font></b><br>
                                    <b><font size="2">HALL - TICKET</font></b>
                                </td>
                            </tr>
                            <tr height="8">
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table border="0" cellpadding="10" cellspacing="0" width="96%" style="font-size:12px;">
                                        <tr>
                                            <td width="80%">
                                                <!-- <b>S.No. 17</b> --><br>
                                                <table border="0" cellpadding="1" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#000000">
                                                    <tr style="height:40px;">
                                                        <td width="33%">&nbsp;<b>Enrollment Number</b></td>
                                                        <td width="33%">&nbsp;<b>'. $candidate->enrolmentno .'</b></td>
                                                        <td>&nbsp;<b>Programme: '. $candidate->approvedprogramme->programme->course_name .'</b></td>
                                                    </tr>
                                                    <tr style="height:40px;">
                                                        <td>&nbsp;<b>Name of the Candidate</b></td>
                                                        
                                                        <td colspan="2">&nbsp;'. $candidate->name .'</td>
                                                    </tr>
                                                    <tr style="height:40px;">
                                                        <td>&nbsp;<b>Fathers Name</b></td>
                                                        
                                                        <td>&nbsp;'. $candidate->fathername .'</td><td>
                                                        DOB: '. $dob .'
                                                        </td>
                                                    </tr>
                                                    <tr style="height:40px;">
                                                        <td>&nbsp;<b>Name of the Institute</b></td>
                                                        <td colspan="2">&nbsp;'. $candidate->approvedprogramme->institute->name .'</td>
                                                    </tr>
                                                    <tr style="height:100px;">
                                                        <td style="vertical-align:top;">&nbsp;<b>Examination Center</b></td>
                                                        <td colspan="2">&nbsp;'. $candidate->approvedprogramme->institute->examcenter($exam_id)->name . '<br />'. $candidate->approvedprogramme->institute->examcenter($exam_id)->address .' '. $candidate->approvedprogramme->institute->examcenter($exam_id)->pincode .'</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td align="center">
                                                <br>
                                                <table border="0" cellpadding="0" cellspacing="0" width="110" height="120" style="border-collapse:collapse;" bordercolor="#000000">
                                                    <tr>
                                                        <td align="center"><img src="'. public_path() . '/files/enrolment/photos/' . $candidate->photo .'" width="110" height="120"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <table border="1" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#000000">
                                                    <tr>
                                                        <td style="height:60px;">&nbsp;Signature of the Candidate</td>
                                                        <td width="180px;">&nbsp;</td>
                                                        <td style="padding:5px;">Counter Signature of the Centre Co-ordinator With Institute Seal</td>
                                                        <td width="180px">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="right">
                                                <img src="'. public_path() . '/images/hallticket/sign.png"  height="38" alt="DCE Signature"><br>
                                                <b>DCE, NBER-NIEPMD</b>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>    
                    </td>
                </tr>
            </table>
    <br>
    <br>
    <br>
    <!-- ==================================================== Examination Centre Copy ==================================================== -->
    <table border="1" style="border-collapse:collapse; font-size:14px;" cellpadding="0" cellspacing="0" width="100%" bordercolor="#000000">
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center" width="110">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><br><img src="'. public_path() . '/images/hallticket/niepmd.png" width="70" height="90" style="padding-left:5px;"></td>
                                </tr>
                            </table>
                        </td>
                        <td align="center">
                            <b><font size="4">National Board of Examination in Rehabilitation</font></b><br>
                            (An Adjunct Body of RCI, under MSJE, DEPwD,GoI)<br/>
                            Examination Conducted by:<br>
                            <b><font size="2">National Institute for Empowerment of Persons with Multiple Disabilities (NIEPMD)</font></b><br>
                            (DEPwD, MSJE, GoI)<br>
                            East Coast Road, Muttukadu, Kovalam, P.O, Chennai-603 112, Tamil Nadu.<br>
                            NBER-RCI, Fax: 044-27472389 Tel: 044-27472104, 27472113, 27472046 / Extn: 492<br>
                            Website: www.niepmd.tn.nic.in &nbsp;&nbsp;&nbsp;Email: niepmd.examinations@gmail.com                       
                        </td>
                        <td width="110" align="center">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td valign="top">
                                        <b><u><font face="Calibri" size="2">EXAMINATION CENTRE COPY</font></u></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td><br><img src="'. public_path() . '/images/hallticket/rci.png" width="72" height="90"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr height="8">
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center" style="line-height:1.2em;">
                            <b><font size="3">EXAMINATION '. $exam->name .'</font></b><br>
                            <b><font size="2">HALL - TICKET</font></b>
                        </td>
                    </tr>
                    <tr height="8">
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table border="0" cellpadding="10" cellspacing="0" width="96%" style="font-size:12px;">
                                <tr>
                                    <td width="80%">
                                        <!-- <b>S.No. 17</b> --><br>
                                        <table border="0" cellpadding="1" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#000000">
                                            <tr style="height:40px;">
                                                <td width="33%">&nbsp;<b>Enrollment Number</b></td>
                                                <td width="33%">&nbsp;<b>'. $candidate->enrolmentno .'</b></td>
                                                <td>&nbsp;<b>Programme: '. $candidate->approvedprogramme->programme->course_name .'</b></td>
                                            </tr>
                                            <tr style="height:40px;">
                                                <td>&nbsp;<b>Name of the Candidate</b></td>
                                                <td colspan="2">&nbsp;'. $candidate->name .'</td>
                                            </tr>
                                            <tr style="height:40px;">
                                                        <td>&nbsp;<b>Fathers Name</b></td>
                                                        
                                                        <td>&nbsp;'. $candidate->fathername .'</td><td>
                                                        DOB: '. $dob .'
                                                        </td>
                                                    </tr>
                                                    <tr style="height:40px;">
                                                        <td>&nbsp;<b>Name of the Institute</b></td>
                                                        <td colspan="2">&nbsp;'. $candidate->approvedprogramme->institute->name .'</td>
                                                    </tr>
                                                    <tr style="height:100px;">
                                                        <td style="vertical-align:top;">&nbsp;<b>Examination Center</b></td>
                                                        <td colspan="2">&nbsp;'. $candidate->approvedprogramme->institute->examcenter($exam_id)->name . '<br />'. $candidate->approvedprogramme->institute->examcenter($exam_id)->address .' '. $candidate->approvedprogramme->institute->examcenter($exam_id)->pincode .'</td>
                                                    </tr>

                                        </table>
                                    </td>
                                    <td align="center">
                                                <br>
                                                <table border="0" cellpadding="0" cellspacing="0" width="110" height="120" style="border-collapse:collapse;" bordercolor="#000000">
                                                    <tr>
                                                        <td align="center"><img src="'. public_path() . '/files/enrolment/photos/' . $candidate->photo .'" width="110" height="120"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table border="1" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#000000">
                                            <tr>
                                                        <td style="height:60px;">&nbsp;Signature of the Candidate</td>
                                                        <td width="180px;">&nbsp;</td>
                                                        <td style="padding:5px;">Counter Signature of the Centre Co-ordinator With Institute Seal</td>
                                                        <td width="180px">&nbsp;</td>
                                                    </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right">
                                        <img src="'. public_path() . '/images/hallticket/sign.png"  height="38" alt="DCE Signature"><br>
                                        <b>DCE, NBER-NIEPMD</b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>    
            </td>
        </tr>
    </table>
    <table border="0" style="border-collapse:collapse;" cellpadding="0" cellspacing="0" width="90%" height="100%" bordercolor="#000000">
                    <tr style="align:center;">
                        <td colspan="2" width="100" style="font-size:16px;">
                            <br>
                            <center>THEORY</center>
                            </br>
                            <table border="1" cellpadding="8" cellspacing="0" width="90%" style="border-collapse:collapse;" bordercolor="#000000">
                                <tr height="40px">
                                    <th width="20px">Sl. No.</th>
                                    <th width="50px">Course Code</th>
                                    <th width="300px">Course Name</th>
                                    <th width="150px">Exam Date and time</th>
                                    <th width="170px">Signature of the Candidate with date<br>(to be signed at the time of appearing for each examination)
                                </tr>
                                '.$table.'
                            </table>
                <p><center>..2</center></p>
            </td>
        </tr>
    </table>
            
            </body>';
            //$html = '<img src="'. public_path() . '/images/hallticket/niepmd.png" width="70" height="90"> </img>';
            //return $html;
                $pdf = PDF::setOptions(['isRemoteEnabled' => true])->loadHtml($html);
                //return $pdf->stream();
                return $pdf->download($candidate->enrolmentno.'.pdf');
            //}
    }

}

