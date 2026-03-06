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

class Practicalexaminer
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
        if ( Auth::check() && (Auth::user()->usertype_id == 10) )
        {
            if(!Session::get('username')){
                $username = \App\Practicalexaminer::where('user_id',Auth::user()->id)->first()->name;
                Session::put('username',$username);
            }
            return $next($request);
        }
     //  return redirect()->guest('login');
     return redirect()->guest('/');

    }
}
