<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Institute;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        /*
    	if(Institute::where('user_id',Auth::user()->id)->count() > 0){
    		return redirect('programmeslist');
    	}
		else{
			return redirect('dashboard');
		}*/


        if(Auth::user()->usertype_id==1){
           return redirect('/nber/dashboard');
        }
    	if(Auth::user()->usertype_id==2){
            $institute = \App\Institute::where('user_id',Auth::user()->id)->first();
          /*  if($institute->is_data_verified !=1 || $institute->is_mobile_verified !=1 || $institute->is_email_verified  !=1 || $institute->is_institute_head_verified  !=1 || $institute->is_institute_head_email_verified  !=1 || $institute->is_institute_head_mobile_verified !=1 || $institute->is_facilities_verified !=1){
              Session::put('error','Kindly update the profile to continue.');
              return redirect('institute/profile');
            } */
           //return "This website will be operational from 17th July 2023 8:00 AM Onwards";
          /* if($institute->is_password_updated != 1){
            Session::put('error','Kindly change your password');
            return redirect('institute/changepassword');
            } */
           return redirect('/notice');
           //return redirect('/enrolment');

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
            return redirect('/examcenter'); 
         }
         if(Auth::user()->usertype_id==7 ){
            return redirect('/evaluationcenter'); 
        }
        if(Auth::user()->usertype_id==8 ){
            return redirect('/evaluationcenter'); 
        }
    }


}
