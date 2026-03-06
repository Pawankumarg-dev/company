<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Institute;
use Session;
use App\Currentapplicant;
use App\Candidate;
use App\Order;
use App\User;
use App\Reportedissue;
use Illuminate\Support\Facades\Hash;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use DB;
use App\Allapplication;
use PDF;
use Illuminate\Support\Str;


use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;


class PublicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     public function cbid(){
        $result = \App\Allresult::where('candidate_id',164318)->first();
        $cid = 164318;
        $term = 1;
        $applications = Allapplication::where('candidate_id',$cid)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
        })->get();
        $hastheory = Allapplication::where('candidate_id',$cid)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
            $q->where('subjecttype_id',1);
        })->count();
        
        $haspractical = Allapplication::where('candidate_id',$cid)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
            $q->where('subjecttype_id',2);
        })->count();

        $candidate = Candidate::find($cid);
        $d = new DNS2D();
        $sa = \App\Allapplicant::where('candidate_id',$cid)->first();
        $aid = $sa->id;
        $rid = $sa->randstrig;
        if(is_null($rid)){
            $rid= $this->generateRandomString();
            $sa->randstrig = $rid;
            $sa->save();
        }
        //echo $cid;
        
        $d->setStorPath('/var/www/rcinber/storage/framework/cache/');    
        $barcode =  $d->getBarcodeHTML(url("marksheet").$aid.'/'.$rid.'/'.$term.'/26', 'QRCODE',2.5,2.5);
        return view('common.marksheet_jan_2025_cbid_html',compact('applications','candidate','term','barcode','hastheory','haspractical'));
 
    }


public function cbid_gen(){
    $job = (new \App\Jobs\GenerateJan2025SuppCBIDMarksheet())->onQueue('cbid');
    $this->dispatch($job);
}





     public function recheckStatusAllPaymentStatusAPI(){
        // return back();
         set_time_limit(0);
 
         require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';
 
         error_reporting(0);
         $nber_id = $nid;
         $working_key = 'ACBC6204DCC88029C2D3CCA4629BFBC7';
         $access_code = 'AVKW04LG64BE84WKEB';
         $merchant_json_data =
         array(
            "order_no"=> "EA114659OR20240529122540DL6803",
            "reference_no"=> "113305792337"
         );
         $merchant_data = json_encode($merchant_json_data);
         $encrypted_data = payment_encrypt($merchant_data, $working_key);
         
         // Tried with above and below encrypted_data, attached the result in word file
         //$encrypted_data = 'f56b009aaf279bf3e206742c712b8ca6dd7d03c09aa3ec360b9a5be664aa74dc44be420b1409b239d107e074ea893ede927c8ddbf4d1cd620b0aece9826763cccea9f11dbf5034061534a0c769e94932';
         
         // Tried with and without version=1.2 , attached the result in word file
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
         echo "Request is: ". $final_data .'<br />';
         echo "Response is: ".$result .'<br />';
         echo "Data Size: "; 
         echo $dataSize . '<br />';
         for ($i = 0; $i < $dataSize; $i++) {
             echo 'Information[i]'. $information[$i]. '<br />';
             $info_value = explode('=', $information[$i]);
             echo "Info Value:";
             echo $info_value[0] . '<br />';
             if ($info_value[0] == 'enc_response') {
                 $status = payment_decrypt(trim($info_value[1]), $working_key);
             }
         }
         echo "Status: ";
         echo $status .'<br />';
         dd();
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

     public function recheckStatusAllPayment(){
        // return back();
         set_time_limit(0);
 
         require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';
 
         error_reporting(0);
        //  /$nber_id = $nid;
         $working_key = 'ACBC6204DCC88029C2D3CCA4629BFBC7';
         $access_code = 'AVKW04LG64BE84WKEB';
         $merchant_json_data =
         array(
             "from_date" => "01-12-2024",
             "to_date" => "11-01-2025",
             'order_email' => 'kk9936389@gmail.com',
             "page_number"=> 1
         );
         $merchant_data = json_encode($merchant_json_data);
         $encrypted_data = payment_encrypt($merchant_data, $working_key);
         
         // Tried with above and below encrypted_data, attached the result in word file
         //$encrypted_data = '19f239de0675a42b3011ec760ec3075f3ed58a0f02781209ba3d8c602c7d1c90bc29c21103f7054fbfa2112a1ee0a0a551d8ca7fa3844f5a41528a902dcdd75a831b993b3dfe4b0d2992800e7e30be69';
         
         // Tried with and without version=1.2 , attached the result in word file
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
         echo "Request is: ". $final_data .'<br />';
         echo "Response is: ".$result .'<br />';
         echo "Data Size: "; 
         echo $dataSize . '<br />';
         for ($i = 0; $i < $dataSize; $i++) {
             echo 'Information[i]'. $information[$i]. '<br />';
             $info_value = explode('=', $information[$i]);
             echo "Info Value:";
             echo $info_value[0] . '<br />';
             if ($info_value[0] == 'enc_response') {
                 $status = payment_decrypt(trim($info_value[1]), $working_key);
             }
         }
         echo "Status: ";
         echo $status .'<br />';
         dd();
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

     
    public function recheckStatusorderLookup($cid){
        // return back();
         set_time_limit(0);
 
         require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';
 
         error_reporting(0);
         $candidate = \App\Candidate::find($cid);
         $nber_id = $candidate->approvedprogramme->programme->nber_id;
         $working_key = \App\Configuration::where('attribute','ccavenue_working_key_nber_'.$nber_id)->first()->value;
         $access_code = \App\Configuration::where('attribute','ccavenue_access_code_nber_'.$nber_id)->first()->value;
         $order=Order::find($oid);
         $merchant_json_data =
         array(
            'order_email'=> $candidate->email,
            'from_date' => '20-12-2025',
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
         echo "Request is: ". $final_data .'<br />';
         echo "Response is: ".$result .'<br />';
         echo "Data Size: "; 
         echo $dataSize . '<br />';
         for ($i = 0; $i < $dataSize; $i++) {
             echo 'Information[i]:'. $information[$i]. '<br />';
             $info_value = explode('=', $information[$i]);
             echo "Info Value:";
             echo $info_value[0] . '<br />';
             if ($info_value[0] == 'enc_response') {
                 $status = payment_decrypt(trim($info_value[1]), $working_key);
             }
         }
         echo "Status: ";
         echo $status .'<br />';
         dd();
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
 
    
    public function recheckStatus($nid,$oid){
       // return back();
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
            'reference_no' => $order->ccavenue_referencenumber
        );
        //return $merchant_json_data;
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
        echo "Request is: ". $final_data .'<br />';
        echo "Response is: ".$result .'<br />';
        echo "Data Size: "; 
        echo $dataSize . '<br />';
        for ($i = 0; $i < $dataSize; $i++) {
            echo 'Information[i]'. $information[$i]. '<br />';
            $info_value = explode('=', $information[$i]);
            echo "Info Value:";
            echo $info_value[0] . '<br />';
            if ($info_value[0] == 'enc_response') {
                $status = payment_decrypt(trim($info_value[1]), $working_key);
            }
        }
        echo "Status: ";
        echo $status .'<br />';
        dd();
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

    
    public function resettootp(){
        //Session::put('messages','Please use the OTP to login and create new password');
        Session::put('messages','Please use the DOB and Enrolment Number to login and create new password');
        $user = \App\User::where('username',Session::get('mobile'))->first();
        /*
        $user->use_password = 0;
        $user->save();*/
        Session::put('use_password','0');
        return back();
    }

    public function changePassword(Request $r){
        //Session::put('messages','Please use the DOB to login and create new password');
        if(Session::get('use_password') == '0'){
            $this->validate($r, [
                'username' => 'required',
                'dob' => 'required|date',
                'enrolmentno' => 'required',
            ]);
        }
        if(Session::get('use_password') == '1'){
            $this->validate($r, [
                'password' => 'required',
            ]);
        }      

        $user = \App\User::where('username',$r->username)->first();
        $candidate = \App\Candidate::where('contactnumber',$r->username)->first();
        if(is_null($user)){
            if(!is_null($candidate)){
                if($candidate->duplicate_mobile_no == 1){
                    Session::flash('error','Duplicate mobile number found, please update the correct mobile number in the portal');    
                }else{
                    $user = \App\User::create([
                        'username' => $candidate->contactnumber,
                        'password' =>  Hash::make("abc$#ef"),
                        'confirmed' => 0,
                        'confirmation_code' => '111zzza',
                        'usertype_id' => 3,
                        'email' => $candidate->email,
                        'use_password' => 0
                    ]);
                    $candidate->user_id = $user->id;
                    $candidate->save();
                }
                Session::put('use_password','0');
                Session::put('mobile',$r->mobilenu);
            }else{
                Session::flash('error','Mobile number not found');
                Session::put('use_password','-1');
            }
         }else{
            if(!is_null($candidate)){
                if(is_null($candidate->user_id)){
                    $candidate->user_id = $user->id;
                    $candidate->save();
                }
            }
         }
        // Validate Enrolment number and DOB
        if ($candidate->dob == $r->dob && $candidate->enrolmentno == $r->enrolmentno) {
            Auth::login($user);
            return redirect('profile');
        }else{
            if(Session::get('use_password') == '0'){
            return redirect()->back()->with('error', 'Enrolment number or date of birth does not match our records.');
            }
        }
    }

    public function qplogin(){
       //return redirect('/');
        return view('auth.director.login');
    }

    public function qploginotp(Request $r){
        $user = \App\User::where('username',$r->username)->first();
        if(is_null($user) || $user->usertype_id != 11){
            return response()->json(['error'=>'Not valid user']);
        }
        
    }

    public function studentlogin(Request $r){


        
        $user = \App\User::where('username',$r->mobilenu)->first();
        if(is_null($user)){
            $candidate = \App\Candidate::where('contactnumber',$r->mobilenu)->first();
            if(!is_null($candidate)){
                if($candidate->duplicate_mobile_no == 1){
                    Session::flash('error','Duplicate mobile number found, please update the correct mobile number in the portal');    
                }else{
                    $user = \App\User::create([
                        'username' => $candidate->contactnumber,
                        'password' =>  Hash::make("abc$#ef"),
                        'confirmed' => 0,
                        'confirmation_code' => '111zzza',
                        'usertype_id' => 3,
                        'email' => $candidate->email,
                        'use_password' => 0
                    ]);
                    $candidate->user_id = $user->id;
                    $candidate->save();
                    Session::put('use_password','2');
                }
                Session::put('mobile',$r->mobilenu);
                if($candidate->is_mobile_number_verified == 'No'){
                    Session::put('use_password','2');
                }
            }else{
                Session::flash('error','Mobile number not found');
                Session::put('use_password','-1');
            }
        }else{      
                $candidate_count = \App\Candidate::where('contactnumber',$r->mobilenu)->count();    
                if($candidate_count > 1){
                    $oldaccount  = \App\Candidate::where('contactnumber',$r->mobilenu)->whereHas('approvedprogramme',function($q){
                        $q->where('academicyear_id','!=',12);
                    })->first();
                    if(is_null($oldaccount)){
                        Session::flash('error','Mobile number not found');
                        Session::put('use_password','-1');
                    }else{
                        if($oldaccount->coursecompleted_status == 1){
                            $oldaccount->user_id = 0;
                            $oldaccount->contactnumber = $oldaccount->contactnumber . '-CC';
                            $oldaccount->save();
                        }
                    }
                }
                $candidate_count = \App\Candidate::where('contactnumber',$r->mobilenu)->count();    
                if($candidate_count == 1){
                    $candidate = \App\Candidate::where('contactnumber',$r->mobilenu)->first();    
                    if(!is_null($candidate)){
                        $candidate->user_id = $user->id;
                        $candidate->save();
                    }else{
                        Session::flash('error','Mobile number not found');
                        Session::put('use_password','-1');
                    }
                    if($user->use_password == 1){
                        Session::put('use_password','1');
                    }else{
                        Session::put('use_password','2');
                    }
                }else{
                    Session::flash('error','Please check the mobile number');
                    return back();
                }
                Session::put('mobile',$r->mobilenu);
        }
        return back();

    }

    public function cancellogin(Request $r){
        Session::put('use_password','-1');
        return back();
    }
    private function genms($term,$currentapplicant){
        if($term == 1 && is_null($currentapplicant->sl_no_marksheet_term_one)){
            Session::put('messages','Not generated');
            return 0;
        }
        if($term == 2 && is_null($currentapplicant->sl_no_marksheet_term_two)){
            Session::put('messages','Not generated');
            return  0;
        }
        if($term == 1 && is_null($currentapplicant->term_one_result_id)){
            Session::put('messages','Not generated');
            return 0;
        } 
        if($term == 2 && is_null($currentapplicant->term_two_result_id)){
            Session::put('messages','Not generated');
            return 0;
        } 
        $cid = $currentapplicant->id;
        $applicantid = str_pad($cid,5,'0',STR_PAD_LEFT);
        $rid = $currentapplicant->randstrig;
        $file = '/var/www/html/rcinber/public/files/marksheet/22/'.$term.'_'.$rid.'_'.$applicantid.'.pdf';
        /*$filename = $currentapplicant->candidate->enrolmentno.'.pdf';
            $headers = array(
            'Content-Type: application/pdf',
        );*/
       /* if(file_exists($file)){
            return response()->download($file, $filename, $headers);
        }else{*/
            $job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,$term))->onQueue('ttipm');
            $this->dispatch($job);
       // }
    }

     public function dispatcher(){
        $images = \App\Tmpimage::all();
        foreach($images as $image){
            $copyimage = (new \App\Jobs\Copyimages($image->image))->onQueue('copyimage');
            $this->dispatch($copyimage);
        }
        return 'done';
        return '';
        set_time_limit(0);

        require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';

        error_reporting(0);
        $reevaluationapplications = \App\Reevaluationapplication::where('exam_id',22)->where('orderstatus_id',0)->get();
        $cofapp = 0;
        $cofor = 0;
        $scofor = 0;
        foreach($reevaluationapplications as $application){
            $cofapp += 1;
            $candidate = \App\Candidate::where('id',$application->candidate_id)->first();
            $nber_id = $candidate->approvedprogramme->programme->nber_id;
            echo $candidate->id;
            foreach($application->orders as $order){
                $working_key = \App\Configuration::where('attribute','ccavenue_working_key_nber_'.$nber_id)->first()->value;
                $access_code = \App\Configuration::where('attribute','ccavenue_access_code_nber_'.$nber_id)->first()->value;
                $order=Order::find($order->id);
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
                    $reevaluationapplication = $application;
                    $scofor += 1;
                    $reevaluationapplication->orderstatus_id = 1;
                    $reevaluationapplication->order_id=$order->id;
                    $reevaluationapplication->save();
                    $reevaluationfee = \App\Reevaluationapplicationfee::where('exam_id',22)->first();
                    
                }
                
            }
        }
        echo $cofapp . ' - ' . $cofor . '  -  ' . $scofor;

        //$job = (new \App\Jobs\GenerateNonCRRMarksheet())->onQueue('withoutcrr');
 //       $this->dispatch($job);
        //return 'Done';
     /*    $currentapplicants = Currentapplicant::where('incomplete',1)->get();
        foreach($currentapplicants as $ca){
            $this->genms(1,$ca);
            $this->genms(2,$ca);
        }
       $images = \App\Tmpimage::all();
        foreach($images as $image){
            $copyimage = (new \App\Jobs\Copyimages($image->image))->onQueue('copyimage');
            $this->dispatch($copyimage);
        }
        return 'done';
        $cids = \App\Regen::all();
        foreach($cids as $cid){
            $currentapplicant = Currentapplicant::where('candidate_id',$cid->candidate_id)->first();
            if(!is_null($currentapplicant->sl_no_marksheet_term_one) && !is_null($currentapplicant->term_one_result_id)){
               $job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,1))->onQueue('regen');
               $this->dispatch($job);
           }
       }*/

       /*
        $ids = [31,36];
        $cas = Currentapplicant::whereHas('approvedprogramme',function($q) use($ids){
            $q->whereIn('programme_id',$ids);
        })->get();*/
       /* $cas = Currentapplicant::whereHas('approvedprogramme',function($q){
            $q->where('id',5748);
        })->get();
        echo $cas->count();
         
        foreach($cas as $currentapplicant){
            echo $currentapplicant->candidate->enrolmentno;
             if(!is_null($currentapplicant->sl_no_marksheet_term_one) && !is_null($currentapplicant->term_one_result_id)){
                $job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,1))->onQueue('islrtc');
                $this->dispatch($job);
            }
        /*    if(!is_null($currentapplicant->sl_no_marksheet_term_two) && !is_null($currentapplicant->term_two_result_id)){
                $job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,2))->onQueue('final');
                $this->dispatch($job);
            } 
            if(!is_null($currentapplicant->slno_certificate) && $currentapplicant->final_result == 1){
                $job = (new \App\Jobs\GenerateCertificate($currentapplicant->candidate_id))->onQueue('certificate');
                $this->dispatch($job);
            } */
      //  }
     }
    public function marksheet($aid,$rid,$term,$exam_id){
        $ca  =  Currentapplicant::find($aid);
        if(!is_null($ca) && $ca->randstrig == $rid && $ca->withheld == 0){
            $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
            $file = '/var/www/html/rcinber/public/files/marksheet/'.$exam_id.'/'.$term.'_'.$rid.'_'.$applicantid.'.pdf';
            if(file_exists($file)){
                if($term == 1 ){
                    $ca->term_one_public_verified_last_on  = \Carbon\Carbon::now();
                }
                if($term == 2 ){
                    $ca->term_two_public_verified_last_on  = \Carbon\Carbon::now();
                }
                $ca->save();
                return response()->file($file);
            }else{
                return 'Not valid marksheet';
            }
        }else{
            return 'Not valid marksheet';
        }
    }
    public function logout(Request $request){
        $request->session()->invalidate();
        //return "Logged Out";
        $rememberMeCookie = Auth::getRecallerName();
        // $sid =  Session::driver()->getId();
        Auth::logout();
        Session::flush();
        // Session::forget('laravel_session');
        // Session::forget('XSRF-TOKEN');
        // Session::forget($sid);
        $cookie = Cookie::forget($rememberMeCookie);
        Cookie::queue(Cookie::forget('laravel_session',null,'.nber-rehabcouncil.gov.in'));
        //return Redirect::to('/')

        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                //return $cookie;
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time()-3600);
                setcookie($name, '', time()-3600, '/');
            }
        }
        return redirect('/login');
    }
    public function certificate($rid,$aid){
        $ca  =  Currentapplicant::find($aid);
        if(!is_null($ca) && $ca->randstrig == $rid && $ca->withheld == 0){
            $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
            $file = '/var/www/html/rcinber/public/files/certificate/22/'.$rid.'_'.$applicantid.'.pdf';
            if(file_exists($file)){
                $ca->certificate_public_verified_last_on = \Carbon\Carbon::now();
                $ca->save();
                return response()->file($file);
            }else{
                return 'Not valid Certficate';
            }
        }else{
            return 'Not valid certficate';
        }
    }
     public function evallogin(){
        // $request->session()->invalidate();
        // //return "Logged Out";
       
        // $sid =  Session::driver()->getId();
        // Auth::logout();
        // Session::flush();
        // Session::forget('laravel_session');
        // Session::forget('XSRF-TOKEN');
        // Session::forget($sid);
        return view('auth.evaluationcenter.login');
    }

    public function evlogin(){
        return view('auth.evaluators.login');
    }

    public function loginqp(Request $r){
        $r->session()->invalidate();
        return redirect('/qp/login');
    }
    public function mslogin(Request $request){
        
        //return "Logged Out";
        return view('auth.director.mslogin');
    }
     public function redirect(){
        return redirect('/');

     }
    public function welcome()
    {
        if(Auth::check()){
            if(Auth::user()->usertype_id==1){
                Session::regenerate();
                return redirect('/nber/dashboard');
            }
            if(Auth::user()->usertype_id==2){
              /*  if(Auth::user()->confirmed == 0){
                    return redirect('institute/changepassword');
                }*/
            $institute = \App\Institute::where('user_id',Auth::user()->id)->first();
           /* if($institute->is_data_verified !=1 || $institute->is_mobile_verified !=1 || $institute->is_email_verified  !=1 || $institute->is_institute_head_verified  !=1 || $institute->is_institute_head_email_verified  !=1 || $institute->is_institute_head_mobile_verified !=1 || $institute->is_facilities_verified !=1){
              Session::put('error','Kindly update the profile to continue.');
              return redirect('institute/profile');
            } */
            return redirect('/notice');
            }
            if(Auth::user()->usertype_id==3 ){
                return redirect('/profile'); 
            }
            if(Auth::user()->usertype_id==4 ){
                // return "This website currently unavailable";
            return redirect('clo'); 
            }
            if(Auth::user()->usertype_id==5 ){
                return redirect('/rci/dashboard'); 
            }
            if(Auth::user()->usertype_id==6 ){
                return redirect('/examcenter/schedule'); 
            }
            if(Auth::user()->usertype_id==7 ){
                return redirect('/evaluationcenter'); 
            }
            if(Auth::user()->usertype_id==8 ){
                return redirect('/evaluationcenter'); 
            }
            if(Auth::user()->usertype_id==9 ){
                return redirect('/reports'); 
            }
            if(Auth::user()->usertype_id==14 ){
                return redirect('/practicalexam/home'); 
            }
            if(Auth::user()->usertype_id==11 ){
                return redirect('/qp/exam/timetable'); 
            }
            if(Auth::user()->usertype_id==12 ){
                if(Auth::user()->confirmed !=1)
                return view('auth.director.reset');
            }
            if(Auth::user()->usertype_id==13 ){
                return redirect('/evaluators'); 
            }
        }
       return view('home');
    }
    public function reset(Request $request)
    {
    

        return view('auth.director.reset');
    }

    public function sendOtp(Request $request)
    {
    

        $user = User::where('id', Auth::user()->id)->first();
        $user->password = Hash::make($request->password);
        $user->confirmed =1;
        $user->save();
        // Mail::to($user->email)->send(new OtpMail($otp));

        return redirect('/');
    }
    public function getinstitute(Request $request)
    {
        $academicYearId = $request->input('academic_year_id');
        $nberId = $request->input('nber_id');
        $institute = DB::table('institutes')
        ->join('approvedprogrammes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
        ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
        ->select('institutes.id', 'institutes.name', 'institutes.rci_code')
        ->where('programmes.nber_id', $nberId)
        ->where('approvedprogrammes.academicyear_id', $academicYearId)
        ->groupBy('institutes.id')
        ->get();
        return response()->json([
            'institute' => $institute
        ]);
    }
    public function getProgrammes(Request $request)
        {
            $academicYearId = $request->input('academic_year_id');
            $nberId = $request->input('nber_id');
            $institute_id = $request->input('institute_id');
            $programmes = DB::table('programmes')
            ->join('approvedprogrammes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->where('approvedprogrammes.academicyear_id', $academicYearId)
            ->where('programmes.nber_id', $nberId)
            ->where('approvedprogrammes.institute_id', $institute_id)
            ->select('programmes.abbreviation', 'programmes.id', 'approvedprogrammes.academicyear_id')
            ->groupBy('programmes.id')
            ->get();
            return response()->json([
                'programmes' => $programmes
            ]);
        }
    
    public function grievances(){
        $prgms = \App\Programme::where('active_status',1)->orderby('abbreviation')->get();
        $nbers = \App\Nber::all();
        $academicyear = \App\Academicyear::where('id','>',9)->get();
        $institute = Institute::whereNull('deleted_at')->where('active_status',1)->select('id', 'name', 'rci_code')->get();
        return view('grievances',compact('prgms','nbers','academicyear','institute'));
    }
    public function grievances_save(Request $r){
        $rules = [
            'issuetype' => 'required||not_in:0',
            'comment' => 'required',
            'contactperson' => 'required',
            'contactnumber' => 'required',
            'nber_id' => 'required',
        ];
        $messages = [
            'issuetype.required' => 'Please select the Issue Type',
            'issuetype.not_in' => 'Please select the Issue Type',
            'comment.required' => 'Please describe the issue in detail',
            'contactperson.required' => 'Please enter your name',
            'contactnumber.required' => 'Please enter your Contact Number',
            'nber.required'=>'Please choose the NBER'
        ];
        $this->validate($r, $rules,$messages);

        $timestamp = round(microtime(true));
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
        for ($i = 0; $i < 5; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $tracking_id=$randomString.$timestamp;
        $ri = Reportedissue::create(
            [
            'tracking_id'=>$tracking_id,
            'institute_id'=>$r->institute_id,
            'issuetype' => $r->issuetype,
            'comment' => $r->comment,
            'contactperson' => $r->contactperson,
            'contactnumber' => $r->contactnumber,
            'prn' => $r->prn,
            'otherreason' => $r->otherreason,
            'is_student' => $r->is_student,
            'academicyear_id' => $r->academicyear_id,
            'programme_id' => $r->programme_id,
            'nber_id' => $r->nber_id
        ]);
     
        Session::put('messages',"Your grievance is submitted successfully. Tracking Id is: $tracking_id");
        return redirect('grievances')->with('success', 'Your grievance is submitted successfully. Tracking Id is:'. $tracking_id);
       

    }

   
   public function exam_timetable(Request $r){
        $timetables = null;
        $course = null;
        $exam = \App\Exam::find(27);
        $academicyear_id = 12;
        $syear = 1;
        $revision_year = null;
        if($r->has('course_id')){
            
            if($r->has('academicyear_id')){
                $academicyear_id = $r->academicyear_id;
            }
            if($r->has('syear')){
                $syear = $r->syear;
            }
            $ry = $revision_year = \App\Revisionyear::where('course_id',$r->course_id)->where('academicyear_id',$academicyear_id)->first();
            if(!is_null($ry)){
                $revision_year=$ry->revision_year;
            }
            
            
            if(is_null($revision_year)){
                $ry = $revision_year = \App\Revisionyear::where('course_id',$r->course_id)->first();
                if(!is_null($ry)){
                    $revision_year=$ry->revision_year;
                }
            }
            if(is_null($revision_year)){
                Session::put('messages','No time table found ');
                return back();
            }
            $course_id=$r->course_id;
            $timetables = \App\Examtimetable::where('exam_id',$exam->id)
            ->whereHas('subject',function($q) use($course_id,$syear,$revision_year){
                $q->where('syear',$syear);
                $q->where('subjecttype_id',1);
                $q->whereHas('programme',function ($s) use($course_id,$revision_year){
                    $s->where('course_id',$course_id);
                    $s->where('revision_year',$revision_year);
                });
            //})->whereNotIn('id',[2354,2421,2460,2516,2502])->get();
            })->get();
            $course = \App\Course::find($course_id);
           
        }
        $courses = \App\Course::groupBy('coursemaster_id')->orderBy('name')->get();

        return view('notices.timetable',
            compact(
                'timetables',
                'exam',
                'courses',
                'course','academicyear_id','syear'
            )
        );
    }

    public function notices_circulars(){
        $notice = \App\Notice::where('status', 1)->orderBy('publish_date', 'desc')->get();     
        return view('notices.index',compact('notice'));
    }
    public function track(){
        return view('tracking');
    }
    public function trackingstatus(Request $request){
        $trackingstatus = Reportedissue::where('tracking_id',$request->trackingNumber)->first();

        if ($trackingstatus) {
            return response()->json([
                'status' => 'success',
                'data' => $trackingstatus
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Tracking number not found'
            ], 404);
        }
    }

public function cert_gen(Request $request)
{
    $exam_id = 26;
    $term = 1;
    $cid = 164404;
// Combinedapplication

// Allexamstudentapplication
//Allexamresult
    $applications = \App\Allapplication::where('candidate_id', $cid)
        ->where('exam_id', $exam_id)
        ->whereHas('subject', function ($q) use ($term) {
            $q->where('syear', $term);
        })->get();


        echo 'ss';
die();
    $paper = \App\Allapplication::where('candidate_id', $cid)
        ->where('exam_id', $exam_id)
        ->join('subjects', 'allapplications.subject_id', '=', 'subjects.id')
        ->where('subjects.syear', $term)
        ->select('subjects.subjecttype_id', DB::raw('count(*) as total'))
        ->groupBy('subjects.subjecttype_id')
        ->get();
    $hastheory = $paper->where('subjecttype_id', 1)->pluck('total')->first() ?? 0;
    $haspractical = $paper->where('subjecttype_id', 2)->pluck('total')->first() ?? 0;

    $candidate = Candidate::find($cid);

    $applicant = \App\Allapplicant::where('candidate_id', $cid)
        ->where('exam_id', $exam_id)
        ->firstOrFail();
$examresult = \App\Allresult::where('candidate_id', $cid)
        ->where('exam_id', $exam_id)->first();
        

    if (is_null($applicant->randstrig)) {
        $applicant->randstrig = Str::upper(Str::random(8));
        $applicant->save();
    }

    $aid = $applicant->id;
    $rid = $applicant->randstrig;

    $barcode = (new DNS2D)->setStorPath(storage_path('framework/cache'))
        ->getBarcodeHTML(url("marksheet/{$aid}/{$rid}/{$term}/{$exam_id}"), 'QRCODE', 2.5, 2.5);

    $applicantid = str_pad($aid, 5, '0', STR_PAD_LEFT);
    $file = public_path("files/marksheet/{$term}_{$rid}_{$applicantid}.pdf");

    view()->share(compact('applications', 'candidate', 'term', 'barcode', 'hastheory', 'haspractical'));
    $pdf = PDF::loadView('common.commonmarksheet')->setPaper('a4', 'landscape');
    file_put_contents($file, $pdf->output());

    // Optional certificate generation
    $final_result = 0;
    if ($final_result == 1) {
        $barcode = (new DNS2D)->getBarcodeHTML(url("certificate/{$exam_id}/{$rid}/{$applicantid}"), 'QRCODE', 2.5, 2.5);
        view()->share(compact('candidate', 'barcode'));
        $pdf = PDF::loadView('common.certificate_jan_2025_supp')->setPaper('a4', 'portrait');
        file_put_contents($file, $pdf->output());
    }

    return response()->json([
        'message' => 'PDF(s) generated',
        'file' => $file
    ]);
}

 public function http_response($mobile, $otp)

    {
                $ch = curl_init();

		$baseURL= "https://smsgw.sms.gov.in/failsafe/HttpLink?username=depwd.sms&pin=De%40Pw%23789&";
		$replyTo ="RCIGOV";
		$messageBody = "Your one time password is ".$otp.". Rehabilitation Council of India";
		$messageBody = urlencode($messageBody);
    		$dlt_entity_id = '1401370180000040261';
    		$dlt_template_id = '1407165908962485291';
		$URI= $baseURL;
		$URI.="signature=".$replyTo;
		$URI .= "&mnumber=".$mobile;
   		$URI .= "&message=".$messageBody;
		$URI .= "&dlt_entity_id=".$dlt_entity_id;
		$URI .= "&dlt_template_id=".$dlt_template_id;
 
                curl_setopt($ch, CURLOPT_URL, $URI);
    
                curl_setopt($ch, CURLOPT_HEADER, 0);
    
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

		$httpCode = curl_exec($ch);
    
    
                curl_close($ch);

                return $httpCode;
    
        }


public function track_admission(Request $request)
{

$date= \Carbon\Carbon::now()->toDateString();

if($date <= '2025-09-20'){
$choice=1;
}
else{
    $choice=2;
}

    $student = null;
    $institute = null;
    $courseabbrivation = [];
    $display = 0;
    $registration_no='';
$mobile='';
$email='';
$instituteIds=[];

    if (!$request->has('registration_no') || !$request->has('mobile') || !$request->has('email')) {
        return view('notices.admissiontrack', compact('student', 'instituteIds', 'courseabbrivation', 'display','registration_no','mobile','email'));
    }

    $student = \App\EpariveshStudent::where('RegistrationNo', $request->registration_no)->first();

    if (!$student) {
        return back()->with('error', 'Student not found.');
    }


$registration_no=$request->registration_no;
$mobile=$request->mobile;
$email=$request->email;



    if (!empty($student->mobile) && !empty($student->email)) {

    $sscheck = \App\EpariveshStudent::where('RegistrationNo',$request->registration_no)->where('mobile',$mobile)->where('email',$email)->first();
 if (!$sscheck) {
        return back()->with('error', 'Invalid Mobile and email.');
    }

        $instituteIds = \App\Epariveshchoise::where('eparivesh_student_id', $student->id)
            ->where('choiceorder','>',1)
              ->orderBy('choiceorder')
            ->get();

    //     $institute = \App\Institute::whereIn('id', $instituteIds)->get();

    // $courseabbrivation = \App\Epariveshchoise::where('eparivesh_student_id', $student->id)
    //         ->where('choiceorder','>',1)
    // ->select('courseabbrivation', 'programme_id')
    // ->get();

http://localhost:8000/sheet-vacnat
    return redirect('/sheet-vacnat');

        // return view('notices.admissiontrack', compact('student', 'instituteIds', 'courseabbrivation', 'display','registration_no','mobile','email'));
    }

    $session_otp = Session::get('verification_otp');

    if ($request->otp == $session_otp && !empty($request->otp)) {
        // Save user data


          $existingStudent = \App\EpariveshStudent::where('mobile', $request->mobile)->first();

    if (!$existingStudent) {

        if($_SERVER["REMOTE_ADDR"]!='103.153.58.147'){

  $student->session1 =Session::getId();
        $student->ip1 =$_SERVER["REMOTE_ADDR"];


        $student->mobile = $request->mobile;
        $student->email = $request->email;
        $student->otp1 = $request->otp;

        $student->save();


Session::forget('verification_otp');


        }
       
    }
    return redirect('/sheet-vacnat');


       $instituteIds = \App\Epariveshchoise::where('eparivesh_student_id', $student->id)
            ->where('choiceorder','>',1)
              ->orderBy('choiceorder')
            ->get();


        return view('notices.admissiontrack', compact('data','student', 'instituteIds', 'courseabbrivation', 'display','registration_no','mobile','email'));
    } else {

if(!empty($request->otp)){
        return back()->with('error', 'wrong otp.');


}


         $existingStudent = \App\EpariveshStudent::where('mobile', $request->mobile)->first();

    if ($existingStudent) {
               return back()->with('error', 'Invalid Mobile and email.');
    }

        $otp = rand(100000, 999999);
            $session_otp = Session::get('verification_otp');

            if ($session_otp == '') {
    Session::put('verification_otp', $otp);
    $this->http_response($request->mobile, $otp);
}

        $display = 1; // Show OTP input field again





        return view('notices.admissiontrack', compact('student', 'instituteIds', 'courseabbrivation', 'display','registration_no','mobile','email'));
    }
}
public function sheet_vacnat(Request $r)
{
        if($r->has('course_id')){

        $course = \App\Course::where('id','!=',26)->get();

$programme_ids = \App\Programme::where('course_id',$r->course_id)->pluck('id')->toArray();

$approvedprogramme = \App\Approvedprogramme::whereIn('programme_id', $programme_ids)
    ->where('academicyear_id', 14)
    ->whereColumn('registered_count', '<', 'maxintake')
    ->get()
    ->sortBy(function($item) {
        return $item->institute->state->state_name;
    });
return view('notices.vacant', compact('approvedprogramme','course'));


        }
        $course = \App\Course::where('id','!=',26)->get();

$approvedprogramme = \App\Approvedprogramme::with(['institute.state', 'programme'])
    ->where('academicyear_id', 14)
    ->whereColumn('registered_count', '<', 'maxintake')
    ->get()
    ->filter(function ($item) {
        // Ensure both institute and state exist
        return $item->institute && $item->institute->state;
    })
    ->sortBy(function ($item) {
        return $item->institute->state->state_name . '|' . $item->programme->abbreviation;
    });
return view('notices.vacant', compact('approvedprogramme','course'));

}




}