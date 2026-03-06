<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Candidate;
use Session;

class Student
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
        //if ( Auth::check() && (\App\Institute::where('user_id',Auth::user()->id)->count() > 0) )
        if ( Auth::check() && (Auth::user()->usertype_id == 3) )
        {
            if(!Session::get('academicyear_id') || !Session::get('candidate')){
                $candidate= \App\Candidate::where('user_id',Auth::user()->id)->first();
                if($candidate->status_id == 9){
                    return redirect(url('logoff'));
                }
                $academicyear_id = $candidate->approvedprogramme->academicyear_id;
                Session::put('academicyear_id',$academicyear_id);
                Session::put('candidate',$candidate);
            }
           
        	  return $next($request);           
        } 
    //   return redirect()->guest('login');
    return redirect()->guest('/');

    }
}
