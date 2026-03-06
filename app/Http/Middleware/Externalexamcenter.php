<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use App\User;

class Externalexamcenter
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
        if ( Auth::check() && (Auth::user()->usertype_id == 6) )
        {
            return $next($request);
            
        }
       return redirect()->guest('/');
        
       //return redirect()->guest('login');
    }
}
