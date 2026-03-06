<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Candidate;
use Auth;
use Session;
use App\User;
use Mail;
use App\Reevaluationapplicationfee;
use App\Reevaluationapplication;
use App\Newapplicant;

use Illuminate\Support\Facades\Hash;

class CandidateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:student']);
    }

    public function createpassword(Request $request){
        $rules = [
            'password' => 'required|confirmed'
        ];
        $messages = [
            'password' => 'Passwords do not match',
        ];
        
        $this->validate($request, $rules,$messages);
        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->password);
        $user->use_password = 1;
        $user->save();
        Session::put('use_password','-1');
        return back();
    }
    public function index(){
        $candidate = \App\Candidate::where('user_id',Auth::user()->id)->first();
        // /if(!Session::get('candidatename')){
//            if(!is_null($candidate)){
                Session::put('candidatename',$candidate->name);
                Session::put('academicyear_id',$candidate->approvedprogramme->academicyear_id);
  //          }
    //    }
        Session::put('use_password','-1');
        $use_password = User::find(Auth::user()->id)->use_password;
        if($use_password != 1  ){
            return view('student.profile.createpassword',compact('candidate'));
        }

       if ($candidate->language_id === null || $candidate->language_id === '') {
                $language = $candidate->approvedprogramme->institute->state->language_id;

            $languages = \App\Language::where('id',$language)->get();
            return view('student.profile.language', compact('languages','candidate'));
        }

        return view('student.profile.index',compact('candidate'));
    } 

 public function data_update(Request $request)
    {
       if (!$request->has('language_id') || !\App\Language::find($request->language_id)) {
            return redirect()->back()->with('error', 'Please select a valid language.');
        }
        $candidate = Candidate::where('user_id', Auth::id())->first();

        if (!$candidate) {
                            Session::flash('error','Candidate not found.');
            return back();
        }
        $candidate->language_id = $request->language_id;
        $candidate->save();
                    Session::flash('messages','Language updated successfully!');
        return back();
    }


    public function msncert(){
        Session::put('use_password','-1');
        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
        $use_password = User::find(Auth::user()->id)->use_password;
        $currentapplications = \App\Currentapplication::where('candidate_id',$candidate->id)->get();
        if($use_password != 1  ){
            return view('student.profile.createpassword',compact('candidate'));
        } 
        $reevauationapplicaiton = \App\Reevaluationapplication::where('candidate_id',$candidate->id)->where('exam_id',25)->where('orderstatus_id',1)->first();
        return view('student.profile.msncert',compact('candidate','currentapplications','reevauationapplicaiton'));
    }

    
    public function downloadmsrev($cid,$term){
        
        $sa = \App\Newapplicant::where('candidate_id',$cid)->first();
        $aid = $sa->id;
        $rid = $sa->randstrig;
        $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
         return redirect(url('/files/marksheet/25')."/RE_".$term.'_'.$rid.'_'.$applicantid.'.pdf?v='.$sa->candidate->newresultreevaluations()->first()->version);
    }
    public function downloadcertrev($cid){
       
        $sa = \App\Newapplicant::where('candidate_id',$cid)->first();
        $rid = $sa->randstrig;
        $applicantid = str_pad($sa->id,5,'0',STR_PAD_LEFT);
        return redirect(url('/files/certificate/25').'/RE_'.$rid.'_'.$applicantid.'.pdf?v='.$sa->candidate->newresultreevaluations()->first()->version);
    }
 
    public function generatemobileotp(Request $r){
        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
      /*  if($r->has('email')){
            $rules = [
                'email' => 'required|email|unique:candidates'
            ];
            $messages = [
                'email' => 'Please enter valid Email Address',
            ];
            $this->validate($r, $rules,$messages);
            $candidate->email = $r->email;
            $candidate->save();
        }*/
        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
        if($r->otp == 0){
            $otp = rand(100000, 999999);
  //                 $url = "https://rciregistration.nic.in/rehabcouncil/api/nber_student_otp.jsp?email=".$candidate->email."&otp=".$otp."&type=1&name=".urlencode($candidate->name);
		try{
  //              $return = $this->http_response($candidate->name,$candidate->email,$otp);
//		Session::flash('error',$url);
            }
            catch(Exception $e){
               // Session::flash('error','Could not send OTP., Please try again');
               // return back();
            }

          //$emailOTP = (new \App\Jobs\SendOTPEmail($candidate->id,$otp))->onQueue('emailotp');
          // $this->dispatch($emailOTP);
        //Mail::send('emails.otp', ['candidate'=>$candidate,'otp' => $otp], function ($m) use ($candidate,$otp) {
          //  $m->from('rcihelp.sje@nic.in', 'RCI NBER');
           // $m->cc('rci-depwd@gov.in');
            //$m->to($candidate->email, $candidate->name)->subject('RCI NBER - OTP to confirm email address');
            //   });               
          //  $candidate->emailotp = $otp;
           // $candidate->save();
        }else{
            if($candidate->emailotp == $r->otp){
                $candidate->is_email_address_verified = 'Yes';
                Session::flash('messages','Verified');
                $candidate->save();
                
            }else{
                Session::flash('error','Not Verified');
            }
        }
        return back();

        //return view('student.profile.verifyotp');
    }

    public function http_response($name, $email, $otp)

    {
    
         
    
    
                    $ch = curl_init();

                $url = "https://rciregistration.nic.in/rehabcouncil/api/nber_student_otp.jsp?email=".$email."&otp=".$otp."&type=1&name=".urlencode($name);
                
                curl_setopt($ch, CURLOPT_URL, $url);

                curl_setopt($ch, CURLOPT_HEADER, 0);

                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

                $httpCode = curl_exec($ch);


                curl_close($ch);


                return $httpCode;
                
    
    
    
          
        }
    public function confrimemail(Request $r){
        $user = User::find(Auth::user()->id);
        //return $user->confirmation_code . ',' . $r->otp;
        if($user->confirmation_code == $r->otp){
            $candidate = Candidate::where('user_id',Auth::user()->id)->first();
            $candidate->is_mobile_number_verified = 'Yes';
            $candidate->is_email_address_confirmed = 'Yes';
            $candidate->save();
            return redirect('/profile');
        }
        Session::put('error','Could not verify the OTP');
        return view('student.profile.verifyotp');
    }

    public function verify(Request $r){
    	$candidate = Candidate::where('user_id',Auth::user()->id)->first();
        
        if($r->dvalidation == 0){
            if($r->verify_comment == ''){
                Session::flash('error','Please mention the correction details');
                return back();
            }else{
                $candidate->status_id = 7;
                $candidate->save();
                $candidate->candidateapprovals()->create(['user_id'=>Auth::user()->id,'comment'=>$r->verify_comment]);
            }
         }
         if($r->is_data_verified){
            $candidate->is_mobile_number_verified = 'Yes';
            $candidate->is_data_verified = 'Yes';
            $candidate->save();
            $user = User::find($candidate->user_id);
            //$user->password = 'rand@asd.comasfa.scom';
            $user->save();
            Session::flash('messages','Thank you.');
         }else{
            Session::flash('error','Undertaking is not checked');
         }
         return back();
    }
}

