<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Approvedprogramme;
use App\Candidate;
use App\Institute;
use App\Payment;
use App\Academicyear;
use App\Application;
use App\Attendance;
use App\Nberstaff;
use App\Exam;

class Nber
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //if ( Auth::check() &&  (Institute::where('user_id',Auth::user()->id)->count() == 0) )
        if ( Auth::check() && (Auth::user()->usertype_id == 1) )
        {
            

           // \Illuminate\Support\Facades\DB::setDefaultConnection(Auth::user()->database_name);
            //$ni = \App\Configuration::where('attribute','niname')->first()->value;
            //$logo = \App\Configuration::where('attribute','logo')->first()->value;
            $admin =0;
            if(Nberstaff::where('user_id',Auth()->user()->id)->first()->admin == 1){
                $admin = 1;
                Session::put('admin',$admin);
            }
            if(!Session::get('academicyear_id') || !Session::get('academicyear')){
                $academicyear= Academicyear::where('current',1)->first();
                $academicyear_id = $academicyear->id;
                $academicyearname = $academicyear->year;
                Session::put('academicyear_id',$academicyear_id);
                Session::put('academicyear',$academicyearname);
           }
           if(!Session::get('exam_id') || !Session::get('examname')){
                $exam= Exam::where('scheduled_exam',1)->first();
                $exam_id = $exam->id;
                $examname = $exam->name;
                Session::put('exam_id',$exam_id);
                Session::put('examname',$examname);
            }
            return $next($request);
            
        }
       return redirect()->guest('/');

    }
}
