<?php

namespace App\Services\Common;
use App\Http\Requests;

use Session;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Newapplicant;
use App\Exam;

class HelperService
{
    public function checkIfPublished($candidate_id){
        $applicant = Newapplicant::where('candidate_id',$candidate_id)->first();
        if(is_null($applicant)){
            return false;
        }
        return $applicant->block == 0 ? true : false;
    }


    function generateRandomString($length = 10) {
        $characters = '123456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public function getCandidateID(){
        return $this->getCandidate()->id;
    }
    
    public function getCandidate(){
        return \App\Candidate::where('user_id',Auth::user()->id)->first();
    }

    public function getNberID(){
        if(Auth::user()->usertype_id == 11){
            return  \App\Director::where('user_id',Auth::user()->id)->first()->nber_id;    
        }
        return  \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;

    }

    public function getNberORRCIID(){
        if(Auth::user()->id == 88387 ) { return 0;}
        if(Auth::user()->usertype_id == 9) { return 0;}
        return  \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
    }
    public function getPracticalExaminerID(){
        //return  \App\Practicalexaminer::where('user_id',Auth::user()->id)->first()->id;
        return \App\Faculty::where('user_id',Auth::user()->id)->first()->id;
    }

    public function getNberShortCode(){
        return  \App\Nber::find($this->getNberID())->short_code;     
    }

    public function isRCILogin(){
       return (Auth::user()->id == 882387);
    }
    public function getProgrammes($onlyNBER = null,$course_id = null){
        $programmes = \App\Programme::where('active_status',1);
        if((Auth::user()->usertype_id == 1 || Auth::user()->usertype_id == 11) && ( !$this->isRCILogin() || !is_null($onlyNBER))){
            $programmes = $programmes->where('nber_id',$this->getNberID());
            
        }
        if(!is_null($course_id)){
            $programmes = $programmes->where('course_id',$course_id);
        }
        return $programmes->get();
    }

    public function getCourses($onlyNBER = null){
        $courses = \App\Course::all();
        if((Auth::user()->usertype_id == 1 || Auth::user()->usertype_id == 11) && ( !$this->isRCILogin() || !is_null($onlyNBER))){
            $courses = \App\Course::where('nber_id',$this->getNberID())->get();
            
        }
        return $courses;
    }
    public function getScheduledExamID(){
        return $this->getScheduledExam()->id;
    }

    public function getScheduledExam(){
        return Exam::where('scheduled_exam',1)->first();
    }

    public function getExamType($id){
        return Exam::find($id)->examtype_id;
    }
    public function getInstituteID(){
        return \App\Institute::where('user_id',Auth::user()->id)->first()->id;
    }

    public function getInstitute(){
        return \App\Institute::where('user_id',Auth::user()->id)->first();
    }

    public function getExternalexamcenterID(){
        if(Auth::user()->usertype_id == 6){
            return \App\Externalexamcenter::where('user_id',Auth::user()->id)->first()->id;
        }
        return 0;
    }
    
    public function getExternalexamcenterIDOf($id){
        return \App\Externalexamcenter::find($id)->id;
    }
    public function getExternalexamcenter(){
        return \App\Externalexamcenter::where('user_id',Auth::user()->id)->first();
    }

    public function getEvaluationcenterID(){
        $auth_user_id = Auth::user()->id;
        return \App\Evaluationcenter::where('user_id',$auth_user_id)->orWhere('deuser_id',$auth_user_id)->first()->id;
    }

    public function createUser($usertypetable,$userType,$r,$user_id = 'user_id'){
        $user = \App\User::create([
            'username' => $r->username,
            'password' =>  Hash::make($r->password),
            'confirmed' => 0,
            'confirmation_code' => '111zzza',
            'usertype_id' => $userType,
            'email' => $r->email1,
            'use_password' => null
        ]);
        $usertypetable->$user_id = $user->id;
        $usertypetable->save();
    }

   

  

    public function updatePassword($table,$r,$user_id='user_id'){
        $user = \App\User::find($table->$user_id);
        $user->username = $r->username;
        if($r->password != ''){
            $user->password = Hash::make($r->password);
        }
        $user->save();
    }

    public function getInsitututeList(){
        $nber_id = $this->getNberID();
        $academicyear_id = \App\Academicyear::where('current',1)->first()->id;
        $institutes = \App\Institute::whereHas('approvedprogrammes',function($q) use($nber_id,$academicyear_id){
            $q->where('academicyear_id',$academicyear_id);
            $q->whereHas('programme',function ($r) use($nber_id){
                $r->where('nber_id',$nber_id);
            });
        })->get();
        return $institutes;
    }

    public function getAcademicYearID(){
        return  \App\Academicyear::where('current',1)->first()->id;
    }
    
    public function getAcademicYear(){
        return  \App\Academicyear::where('current',1)->first();
    }
    public function getUserName(){
        return Auth::user()->username;
    }

}

