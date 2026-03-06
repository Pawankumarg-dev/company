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
use Illuminate\Support\Facades\Hash;


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
    
    public function resettootp(){
        //Session::put('messages','Please use the OTP to login and create new password');
        Session::put('messages','Please use the DOB and Enrolment Number to login and create new password');
        $user = \App\User::where('username',Session::get('mobile'))->first();
        $user->use_password = 0;
        $user->save();
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
                    if($oldaccount->coursecompleted_status == 1){
                        $oldaccount->user_id = 0;
                        $oldaccount->contactnumber = $oldaccount->contactnumber . '-CC';
                        $oldaccount->save();
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
        return view('auth.evaluationcenter.login');
    }
     public function redirect(){
        return redirect('/');

     }
    public function welcome()
    {
        if(Auth::check()){
            if(Auth::user()->usertype_id==1){
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
            if(Auth::user()->usertype_id==10 ){
                return redirect('/practicalexam/home'); 
            }
        }
       return view('home');
    }


}
