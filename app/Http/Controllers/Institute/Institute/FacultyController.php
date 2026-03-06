<?php

namespace App\Http\Controllers\Institute;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

use App\Http\Requests;

use App\Faculty;

use App\Institute;

use App\Approvedprogramme;

use App\Programme;

use Auth;

class FacultyController extends Controller
{
    public function index(){
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        $institute_id = $institute->id;
        $faculties = Faculty::where('institute_id',$institute_id)->get();
        $programme_ids = Approvedprogramme::where('institute_id',$institute_id)->where('academicyear_id','>',8)->pluck('programme_id')->unique()->toArray();
        $programmes = Programme::whereIn('id',$programme_ids)->get();
        if($institute->active_status ==0 ){
            $programmes = Programme::all();
        }
        return view('institute.faculties.index',compact('faculties','programmes'));
    }

    public function remove(Request $r){
        $institute_id = Institute::where('user_id',Auth::user()->id)->first()->id;
        $faculty = Faculty::find($r->faculty_id);
        if($faculty->institute_id == $institute_id){
            $faculty->delete();
            return response()->json('success');
        }
        return response()->json(['error'=>'Could not delete']);
    }
    
    public function store(Request $r){
        $institute_id = Institute::where('user_id',Auth::user()->id)->first()->id;
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
           return response()->json(['error'=>'Could not fetch Faculty details. Please try again later.']);
           }
           Faculty::create([
                'crr_no' => $r->crrno,
                'name' => $newfaculty[0]->Name,
                'crr_expiry' => $newfaculty[0]->RegistrationExpiedDate,
                'institute_id' => $institute_id,
           ]);
           return response()->json('success');
        }else{
            return response()->json(['error'=>'Faculty already exists in the database']);
        }
    }
    public function updatecourse(Request $r){
        $institute_id = Institute::where('user_id',Auth::user()->id)->first()->id;
        $faculty = Faculty::find($r->id);
        if($institute_id==$faculty->institute_id){
            if(!$faculty->programmes()->where('programme_id',$r->programme_id)->exists()){
                $faculty->programmes()->attach($r->programme_id);
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
            if($faculty->programmes()->where('programme_id',$r->programme_id)->exists()){
                $faculty->programmes()->detach($r->programme_id);
            }
           return response()->json('success');
        }else{
            return response()->json(['error'=>'Could not update']);
        }
    }
}