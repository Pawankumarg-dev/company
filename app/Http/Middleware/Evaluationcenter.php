<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class Evaluationcenter
{
    public function handle($request, Closure $next)
    {
        if ( Auth::check() && (Auth::user()->usertype_id == 7 || Auth::user()->usertype_id == 8 ) )
        {
           // $markentry = 0;
           // if(Auth::user()->usertype_id == 8){
            //    $markentry=1;
            //}
        //    $markentry = \App\Evaluationcenter::where('user_id',Auth::user()->id)->first()->enable_markentry;
            //Session::put('markentry',$markentry);
            return $next($request);
        }
        return redirect()->guest('/');
    }
}
