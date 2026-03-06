<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

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
        if ( Auth::check() && (Auth::user()->usertype_id == 14) )
        {
            //if(!Session::get('roles')){
                $faculty =  \App\Faculty::where('user_id',Auth::user()->id)->first();
                if(!is_null($faculty)){
                    $practicalexam = \App\Practicalexam::where('faculty_id',$faculty->id)->where('exam_id',27)->get();
                    if($practicalexam->count() > 0){
                        Session::put('role','practicalexaminer');
                    }
                   // if(!Session::get('username')){
                        $username = $faculty->name;
                        $username = "TEST";
                        Session::put('username',$username);
                    //}
                }
                
            //}
            return $next($request);
        }
     //  return redirect()->guest('login');
     return redirect()->guest('/');

    }
}
