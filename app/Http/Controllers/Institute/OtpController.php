<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Institute;
use App\User;
use App\Candidate;
use Session;
use Illuminate\Support\Facades\Hash;

class OtpController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function generate(Request $request)
    {
        

        
            $username=$request->username;
            //$findold_entry=User::where('username',$request->username)->get()->first();
            $candidate = Candidate::where('contactnumber',$username)->first();
            if(is_null($candidate)){
              return response()->json(['error' => 'Mobile number not found']);
            }
            if($candidate->is_duplicate_mobile ==1){
              return response()->json(['error'=>'Please check your mobile number']);
            }

            // Message detail
            //$apiKey = urlencode('NGU1MDM1NzY3ODc0MzM2NjRlNzQ2NDQ0NWEzMTczNGY=');
            //$numbers='91'.$request->username;
            //$numbers = array($numbers);
            //$sender = urlencode('DLNBER');
            $otp = rand(100000, 999999);
            // $message = "Regards from DEPWD, Your OTP is " . $otp;
           // $message = rawurlencode("Your One Time Password ".$otp.". Log in to RCI NBER account. Rehabilitation Council of India");
            //$numbers = implode(',', $numbers);
            // Prepare data for POST request
            //$username=$request->username;

            /*if(Candidate::where('contactnumber',$username)->count() > 1){
              return response()->json(['error'=>'Please check your mobile number']);
            }
            if(Candidate::where('contactnumber',$username)->count() == 0){
              
            }*/
            $user_id = $candidate->user_id;
            if($user_id > 0){
              $multiple_user_id = Candidate::where('user_id',$user_id)->count();
              if($multiple_user_id > 1){
                return response()->json(['error' => 'Please check your mobile number.']);
              }
              $user = User::find($candidate->user_id);
              if($user->username != $username){
                $user->username = $username;
                $user->save();
              }
            }
            $findold_entry  = User::where('username',$username)->first();
           // if(Candidate::where('contactnumber',$username)->count() == 1){// && $candidate->is_mobile_number_verified == "Yes"){
              if($findold_entry){
               // $findold_entry->password = "asfasdfasdfa@sdfsafadsca..com";
                //$findold_entry->save();
              }
                try{
                //    $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
                    // Send the POST request with cURL
                  //  $ch = curl_init('https://api.textlocal.in/send/');
                   // curl_setopt($ch, CURLOPT_POST, true);
                   // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    //$response = curl_exec($ch);
                    //curl_close($ch);
                    // dd($response);
                    $url = "https://rciregistration.nic.in/rehabcouncil/api/nber_student_otp.jsp?mobile=".$request->username."&otp=".$otp.'&type=2';
                    $this->http_response($url);

                  }
                      catch(Exception $e){
                         //die('Error: '.$e->getMessage());
                    return response()->json(['error'=>'Could not send OTP']);
        
                        }
              if($findold_entry)
              {  
             //   User::where('username',$request->username)->update(['password'=> Hash::make($otp), 'usertype_id'=>'3','confirmation_code' => $otp]);
                $user = User::where('username',$username)->first();
                $user->password = Hash::make("$otp");
                $user->confirmation_code = $otp;
                $user->save();
                $candidate->user_id = $user->id;
                $candidate->save();
  //               User::where('username',$request->username)->update(array('password'=> $otp, 'usertype_id'=>'3'));
              }
              else
              {
               $user = User::create([
                    'username' => $username,
                    'password' =>  Hash::make("$otp"),
                    'confirmed' => 0,
                    'confirmation_code' => $otp,
                    'usertype_id' => 3,
                    'email' => $candidate->email
                ]);
                $candidate->user_id = $user->id;
                $candidate->save();
              }
           /* }else{
              return response()->json(['error'=>'Could not find this mobile number in the candidate database.']);
            }*/
            return response()->json('success');

    }



}
