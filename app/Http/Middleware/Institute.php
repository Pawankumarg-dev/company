<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Academicyear;

class Institute
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
        if ( Auth::check() && (Auth::user()->usertype_id == 2) )
        {
         // \Illuminate\Support\Facades\DB::setDefaultConnection(Auth::user()->database_name);
         // $ni = \App\Configuration::where('attribute','niname')->first()->value;
          //$logo = \App\Configuration::where('attribute','logo')->first()->value;
          //Session::set('ni',$ni);
          //Session::set('logo',$logo);
          //$institute = \App\Institute::where('user_id',Auth::user()->id)->first();
          $institute_location = \App\Institute::where('user_id', Auth::user()->id)->first(); 
          if(!Session::get('academicyear_id') || !Session::get('academicyear') || !Session::get('institute_location') ){
            $academicyear= Academicyear::where('current',1)->first();
            $academicyear_id = $academicyear->id;
            $academicyearname = $academicyear->year;
            Session::put('institute_location',$institute_location);
            Session::put('academicyear_id',$academicyear_id);
            Session::put('academicyear',$academicyearname);
          }



       
        	  return $next($request);           
        } 
        
       return redirect()->guest('/');
    }
}
