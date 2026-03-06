<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
//use App\Clo;
use Session;
use App\Examcenter;
use App\Approvedprogramme;

class Clo
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
        if ( Auth::check() && (Auth::user()->usertype_id == 4) )
        {
           /* $clo = \App\Clo::where('user_id',Auth::user()->id)->first();
                $institute_id = $clo->institute()->first()->id;
                $exam_center = Examcenter::where('institute_id',$institute_id)->where('exam_id','2');
                $center = 1;
                if($exam_center->count() > 0){
                    if($exam_center->first()->examcenter_id != $institute_id){
                        $center = 0;
                    }
                }
                $institutes_for = Examcenter::where('examcenter_id',$institute_id)->where('exam_id','2')->orderBy('institute_id')->lists('institute_id')->toArray();
                
                if($center==1){
                    array_push($institutes_for,$institute_id);
                }
                
                $programme_ids = array_unique(Approvedprogramme::whereIn('institute_id',$institutes_for)->orderBy('programme_id')->lists('programme_id')->toArray());
                
                Session::put('programme_ids',$programme_ids);
                Session::put('clo',$clo);
                \Illuminate\Support\Facades\DB::setDefaultConnection(Auth::user()->database_name);*/
        	   return $next($request);           
            
        } 
        return redirect()->guest('/');

      // return redirect()->guest('login');
    }
}
