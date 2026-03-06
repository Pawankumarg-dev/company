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
        return view('student.profile.index',compact('candidate'));
    }
    public function msncert(){
        Session::put('use_password','-1');
        $candidate = Candidate::where('user_id',Auth::user()->id)->first();
        $use_password = User::find(Auth::user()->id)->use_password;
        $currentapplications = \App\Currentapplication::where('candidate_id',$candidate->id)->get();
        if($use_password != 1  ){
            return view('student.profile.createpassword',compact('candidate'));
        }
        return view('student.profile.msncert',compact('candidate','currentapplications'));
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
            $url = "https://rciregistration.nic.in/rehabcouncil/api/nber_student_otp.jsp?email=".$candidate->email."&otp=".$otp.'&type=1&name='.urlencode($candidate->name);
            try{
                $this->http_response($url);
            }
            catch(Exception $e){
                Session::flash('error','Could not send OTP., Please try again');
                return back();
            }
            $candidate->emailotp = $otp;
            $candidate->save();
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

    public function http_response($url, $status = null, $wait = 3)

    {
    
         
    
    
    
            // we fork the process so we don't have to wait for a timeout
    
    
                // we are the parent
    
                $ch = curl_init();
    
                curl_setopt($ch, CURLOPT_URL, $url);
    
                curl_setopt($ch, CURLOPT_HEADER, TRUE);
    
                curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
    
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    
                $head = curl_exec($ch);
    
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
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

