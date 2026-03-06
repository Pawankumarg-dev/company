<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Sessionvalidation;

class Validatesession
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

        if ( Auth::check()  )
        {
            //Session::put('error','Testing');
         $user_id = Auth::user()->id;
            $ip = $_SERVER["REMOTE_ADDR"];
            $session_id = Session::getId();
            $session = Sessionvalidation::where('session_id',$session_id)->first();
            if(is_null($session)){
                Sessionvalidation::create([
                    'user_id' => $user_id,
                    'ip' => $ip,
                    'session_id' => $session_id
                ]);
            }else{
                if($session->ip != $ip){
                    //$session->delete();
                    //Auth::logout();
                }
            }           
        }
        return $next($request);

    }
}