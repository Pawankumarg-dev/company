<?php

namespace App\Http\Middleware;

use Closure;

use App\Role;
use Session;

use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        
        if(Auth::check() && !is_null($role)){
            $usertype_id = Auth::user()->usertype_id ;
            $user_id = Auth::user()->id;
            $role_id = \App\Role::where('role_name',$role)->first()->id;
            if ($usertype_id != $role_id) 
            {
                return redirect('/');
            }
            
            // NBER Session
            if ($usertype_id == 1) {
                $admin =\App\Nberstaff::where('user_id',$user_id)->first()->admin;
                
                if(!Session::get('admin')){
                    
                    Session::put('admin',$admin);
                }


                
                if(!Session::get('academicyear_id') || !Session::get('academicyear')){
                    $academicyear= \App\Academicyear::where('current',1)->first();
                    $academicyear_id = $academicyear->id;
                    $academicyearname = $academicyear->year;
                    Session::put('academicyear_id',$academicyear_id);
                    Session::put('academicyear',$academicyearname);
                }
                if(!Session::get('exam_id') || !Session::get('examname')){
                    $exam= \App\Exam::where('scheduled_exam',1)->first();
                    $exam_id = $exam->id;
                    $examname = $exam->name;
                    Session::put('exam_id',$exam_id);
                    Session::put('examname',$examname);
                }
            }

            //Institute Session
            if ( $usertype_id == 2) 
            {
                $institute_location = \App\Institute::where('user_id', $user_id)->first(); 
                if(!Session::get('academicyear_id') || !Session::get('academicyear') || !Session::get('institute_location') ){
                    $academicyear= \App\Academicyear::where('current',1)->first();
                    $academicyear_id = $academicyear->id;
                    $academicyearname = $academicyear->year;
                    Session::put('institute_location',$institute_location);
                    Session::put('academicyear_id',$academicyear_id);
                    Session::put('academicyear',$academicyearname);
                }
            }


            if ( $usertype_id == 3) 
            {
                $candidate= \App\Candidate::where('user_id',$user_id)->first();
                if($candidate->status_id == 9){
                    return redirect(url('logoff'));
                }
                $academicyear_id = $candidate->approvedprogramme->academicyear_id;
                Session::put('academicyear_id',$academicyear_id);
                Session::put('candidate',$candidate);
            }
            if ( $usertype_id == 4) 
            {
                $clo = \App\Clo::where('user_id',Auth::user()->id)->first();
                Session::put('clo',$clo);
            }

            // RCI Session
            if ( $usertype_id == 5) 
            {
                if(!Session::get('username')){
                    $academicyear= \App\Academicyear::where('current',1)->first();
                    $academicyear_id = $academicyear->id;
                    $academicyearname = $academicyear->year;
                    Session::put('academicyear_id',$academicyear_id);
                    Session::put('academicyear',$academicyearname);
                }
            }

            // Practical Examiner Session
            if ( $usertype_id == 10) 
            {
                if(!Session::get('username')){
                    $username = \App\Practicalexaminer::where('user_id',$user_id)->first()->name;
                    Session::put('username',$username);
                }
            }
            // evalutor
            if ( $usertype_id == 13) 
            {
                if(!Session::get('username')){
                    $username = \App\Evaluator::where('user_id',$user_id)->first()->name;
                    Session::put('username',$username);
                }
            }
            if ( $usertype_id == 14) 
            {
                $faculty =  \App\Faculty::where('user_id',Auth::user()->id)->first();
                $practicalexam = \App\Practicalexam::where('faculty_id',$faculty->id)->where('exam_id',27)->get();
                if($practicalexam->count() > 0){
                    Session::put('role','practicalexaminer');
                }
                if(!Session::get('username')){
                    $username = $faculty->name;
                    Session::put('username',$username);
                }
            }
            return $next($request);
        }
        return redirect('/');
    }
}
