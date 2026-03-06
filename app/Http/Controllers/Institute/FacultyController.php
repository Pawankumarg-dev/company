<?php

namespace App\Http\Controllers\Institute;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

use App\Http\Requests;

use App\Faculty;

use App\Institute;

use App\Approvedprogramme;

use App\Programme;

use App\Course;
use App\Language;
use Auth;
use File;
use App\Subjecttype;
use App\Subject;
use Session;
use App\FacultyResponsibility;
use App\FacultyLanguage;
class FacultyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }
    public function index(){
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        $institute_id = $institute->id;
        $faculties = Faculty::where('institute_id',$institute_id)->get();
        $programme_ids = Approvedprogramme::where('institute_id',$institute_id)->where('academicyear_id','>',10)->pluck('programme_id')->unique()->toArray();
        $language = Language::get();

        $course_ids = Programme::whereIn('id',$programme_ids)->pluck('course_id')->unique()->toArray();
        $courses = Course::whereIn('id',$course_ids)->groupBy('name')->get();
        //if($institute->active_status ==0 ){
        //    $programmes = Programme::all();
        //}
        return view('institute.faculties.index',compact('faculties','courses','institute_id','language'));
    }

    public function remove(Request $r){
                            return response()->json(['error'=>'Could not delete during exam time']);

        $institute_id = Institute::where('user_id',Auth::user()->id)->first()->id;
        $faculty = Faculty::find($r->faculty_id);
        if($faculty->institute_id == $institute_id){
            $faculty->delete();
            FacultyResponsibility::where('faculty_id', $r->faculty_id)->delete();
            FacultyLanguage::where('faculty_id', $r->faculty_id)->delete();
            return response()->json('success');
        }
        return response()->json(['error'=>'Could not delete']);
    }
    public function changetype($id,Request $r){
        $institute_id = Institute::where('user_id',Auth::user()->id)->first()->id;
        $faculty = Faculty::find($id);
        if($faculty->institute_id == $institute_id){
            if($faculty->core == 1){
                $faculty->core = 0;
            }else{
                if(is_null($faculty->core)){
                    $faculty->core = $r->core;
                }else{
                    $faculty->core = 1;
                }
            }
            $faculty->save();
            Session::put('message','Changed');
        }
        return back();
    }
    public function pulldetails(){
        //$faculties = Faculty::where('id','<','10')->get();
        $faculties = Faculty::where('email',null)->get();
        foreach($faculties as $f){
            try{
                $ch = curl_init('https://rciregistration.nic.in/rehabcouncil/api/findbycrrno.jsp?id='.$f->crr_no);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                $newfaculty = json_decode($response); 
                if( $newfaculty != 0 && isset($newfaculty[0])){
                    if(isset($newfaculty[0]->RegistrationExpiedDate)){
                        $f->crr_expiry = $newfaculty[0]->RegistrationExpiedDate;
                    }
                    if(isset($newfaculty[0]->MobileNo)){
                        $f->mobileno = $newfaculty[0]->MobileNo;
                    }
                    if(isset($newfaculty[0]->EmailId)){
                        $f->email = $newfaculty[0]->EmailId;
                    }
                    $f->save();
                }

            }
            catch(Exception $e){
            }
        }
    }

    public function store(Request $r){
        $institute_id = Institute::where('user_id',Auth::user()->id)->first()->id;
        if($r->typeoffaculty == 'withcrr'){
            $faculty = Faculty::where('crr_no',$r->crrno)->first();
            if(is_null($faculty)){
                try{
                $ch = curl_init('https://rciregistration.nic.in/rehabcouncil/api/findbycrrno.jsp?id='.$r->crrno);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                $newfaculty = json_decode($response);
                }
                catch(Exception $e){
                    //return response()->json(['error'=>'Could not fetch Faculty details. Please try again later.']);
                    Session::put('error','Could not fetch Faculty details.');
                    return back();
                }
                if($newfaculty==0){
                    Session::put('error','Could not fetch Faculty details.');
                    return back();
                }
                Faculty::create([
                        'crr_no' => $r->crrno,
                        'name' => $newfaculty[0]->Name,
                        'crr_expiry' => $newfaculty[0]->RegistrationExpiedDate,
                        'institute_id' => $institute_id,
                        'photo' => $newfaculty[0]->photopath,
                        'qualification' => $newfaculty[0]->QualifciationAndPassingYear,
                        'mobileno' =>$newfaculty[0]->MobileNo,
                        'email' =>$newfaculty[0]->EmailId,
                        'core' => $r->type
                ]);
                Session::put('message','Faculty Added');
                return back();
            }else{

                Session::put('error','Faculty already exists in the database');
                return back();

            }
        }else{
            try{
                $filename = uniqid(time(), true);
                move_uploaded_file($r->photo, public_path()."/files/faculties/".$filename);
            }catch(Exception $e){
                Session::put('error','Could not upload file');
            }
            Faculty::create([
                'crr_no' => $r->crrno,
                'name' => $r->name,
                'institute_id' => $institute_id,
                'photo' => url('files/faculties') . '/' . $filename,
                'qualification' => $r->qualification,
                'mobileno' =>$r->mobile,
                'email' =>$r->email,
                'core' => 0
            ]);
            Session::put('message','Faculty Added');
            return back();
        }
    }
    public function updatecourse(Request $r){
        $institute_id = Institute::where('user_id',Auth::user()->id)->first()->id;
        $faculty = Faculty::find($r->id);
        if(($institute_id==$faculty->institute_id && $faculty->core == 1 ) || $faculty->core != 1){
            if(!$faculty->courses()->where('course_id',$r->course_id)->exists()){
                $faculty->courses()->attach($r->course_id);
            }
            if($r->coordinator == 1){
                $existing = Faculty::where('institute_id',$institute_id)->where('course_corordinator_for',$r->course_id)->get();
                if($existing->count() > 0 ){
                    foreach($existing as $e){
                        $e->course_corordinator_for = null;
                        $e->save();
                    }
                }
                $faculty->course_corordinator_for = $r->course_id;
            }else{
                $faculty->course_corordinator_for = null;
            }
            $faculty->save();
            \App\Facultysubject::where('institute_id',$institute_id)->where('faculty_id',$r->id)->where('course_id',$r->course_id)->delete();
            foreach(explode(',',$r->subjects) as $subject){
                \App\Facultysubject::create([
                    'institute_id' => $institute_id,
                    'subject_id' => $subject,
                    'faculty_id' => $r->id,
                    'course_id' => $r->course_id
                ]);
            }

            FacultyResponsibility::where('faculty_id', $r->id)
            ->where(function($query) use ($r) {
                $query->where('course_id', $r->course_id)
                      ->orWhereNull('course_id');
            })->delete();

            foreach(explode(',',$r->responsibility_type) as $responsibility){
                if (!empty($responsibility)) {

            $resp = new FacultyResponsibility();
            $resp->responsibility_type =$responsibility;
            $resp->course_id = $r->course_id;
            $resp->faculty_id = $r->id;
            $resp->exam_id = 27;  
            $resp->save();
            }
        }


        FacultyLanguage::where('faculty_id', $r->id)
        ->where(function($query) use ($r) {
            $query->where('course_id', $r->course_id)
                  ->orWhereNull('course_id');
        })->delete();
            foreach(explode(',',$r->language) as $lang){
                if (!empty($lang)) {
                $responsibility = new FacultyLanguage();
                $responsibility->course_id = $r->course_id;
                $responsibility->language_id =$lang;
                $responsibility->faculty_id = $r->id;
                $responsibility->exam_id = 27;  
                $responsibility->save();
                }
            }
           return response()->json('success');
        }else{
            return response()->json(['error'=>'Could not update']);
        }
    }
    public function removecourse(Request $r){
        $institute_id = Institute::where('user_id',Auth::user()->id)->first()->id;
        $faculty = Faculty::find($r->id);
        if($institute_id==$faculty->institute_id){
            if($faculty->courses()->where('course_id',$r->course_id)->exists()){
                $faculty->courses()->detach($r->course_id);
            }

            FacultyLanguage::where('faculty_id', $r->id)
            ->where(function($query) use ($r) {
                $query->where('course_id', $r->course_id)
                      ->orWhereNull('course_id');
            })->delete();

            FacultyResponsibility::where('faculty_id', $r->id)
            ->where(function($query) use ($r) {
                $query->where('course_id', $r->course_id)
                      ->orWhereNull('course_id');
            })->delete();

           return response()->json('success');
        }else{
            return response()->json(['error'=>'Could not update']);
        }
    }
    public function responsiblity_edit(Request $request){

        if($request->faculty_id){

            $FacultyResponsibility=FacultyResponsibility::where('faculty_id',$request->faculty_id)->where('course_id',$request->course_id)->pluck('responsibility_type');;
            $FacultyLanguage=FacultyLanguage::where('faculty_id',$request->faculty_id)->where('course_id',$request->course_id)->pluck('language_id');;
            $Facultysubject=\App\Facultysubject::where('institute_id',$request->institute_id)->where('faculty_id',$request->faculty_id)->where('course_id',$request->course_id)->pluck('subject_id');;
            $course_id=$request->institute_id;

            $existing = Faculty::where('id',$request->faculty_id)->where('institute_id',$request->institute_id)->where('course_corordinator_for',$request->course_id)->pluck('course_corordinator_for');

            return response()->json([
                'FacultyResponsibility' => $FacultyResponsibility,
                'FacultyLanguage' => $FacultyLanguage,
                'Facultysubject' => $Facultysubject,
                'course_id' => $course_id,
                'existing' => $existing
            ]);
        //    return response()->json($course_id);
        }else{
            return response()->json(['error'=>'Could not update']);
        }
    }
 

}