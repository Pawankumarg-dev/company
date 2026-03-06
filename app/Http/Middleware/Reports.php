<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Academicyear;

class Reports
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
        if ( Auth::check() && (Auth::user()->usertype_id == 9) )
        {
            if(!Session::get('academicyear_id') || !Session::get('academicyear')){
                $academicyear= Academicyear::where('current',1)->first();
                $academicyear_id = $academicyear->id;
                $academicyearname = $academicyear->year;
                Session::put('academicyear_id',$academicyear_id);
                Session::put('academicyear',$academicyearname);
            }
            return $next($request);
            
        }
     //  return redirect()->guest('login');
     return redirect()->guest('/');

    }
}
