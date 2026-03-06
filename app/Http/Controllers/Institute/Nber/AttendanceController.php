<?php

namespace App\Http\Controllers\Nber;

use App\Application;
use App\Approvedprogramme;
use App\Exam;
use App\Examanswersheet;
use App\Examtimetable;
use App\Externalexamcenter;
use App\Language;
use App\Candidate;
use App\Markexamattendance;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\Exam\ApplicantService; 
use App\Services\Common\HelperService;

class AttendanceController extends Controller
{
    //

    protected $ApplicantService;
    protected $exam_id;
    protected $helperService;
    protected $exam;

    public function __construct(ApplicantService $applicant, HelperService $helper)
    {
       $this->middleware(['role:nber']);
        $this->ApplicantService = $applicant;
        $this->exam_id = Session::get('exam_id');
        $this->exam = Exam::find($this->exam_id);
        $this->ApplicantService->assignmodel($this->exam_id);
        $this->helperService = $helper;
    }


    public function attendanceIndex(Request $r,$exam_id){

        //$ap = Approvedprogramme::with('candidates')->find($id);

        $programme = $this->ApplicantService->getProgramme($r);
        $institute = $this->ApplicantService->getInstitute($r);
        $academicyear = $this->ApplicantService->getAcademicyear($r);
        //$applicants= $this->ApplicantService->getApplicants(100);

        $programmes = $this->helperService->getProgrammes(1);
        $institutes = $this->helperService->getInsitututeList();
        $academicyears = \App\Academicyear::where('id','>',9)->where('id','<=',11)->get();

        $programme = null;
        $approvedprogramme = null;
        if($r->has('programme_id')){
            $programme =\App\Programme::find($r->programme_id);
            $approvedprogramme = Approvedprogramme::where('programme_id',$r->programme_id);
        }

        $institute = null;
        if($r->has('institute_id')){
         $institute =\App\Institute::find($r->institute_id);
         if(is_null($approvedprogramme)){
            $approvedprogramme = Approvedprogramme::where('institute_id',$r->institute_id);
         }else{
            $approvedprogramme = $approvedprogramme->where('institute_id',$r->institute_id);
         }
        }     

        $academicyear = null;
        if($r->has('academicyear_id')){
            $academicyear = \App\Academicyear::find($r->academicyear_id);
            if(is_null($approvedprogramme)){
                $approvedprogramme = Approvedprogramme::where('academicyear_id',$r->academicyear_id);
            }else{
                $approvedprogramme = $approvedprogramme->where('academicyear_id',$r->academicyear_id);
            }
        }

        // $approvedprogrammes = Approvedprogramme::where('programme_id', $programme->id)
        // ->where('institute_id', $institute->id)
        // ->where('academicyear_id', $academicyear->id)
        // ->get(['programme_id', 'institute_id', 'academicyear_id']);
        //)
        $approvedprogramme = $approvedprogramme->get();

        $exam = \App\Exam::find($exam_id);
        $nber = $this->helperService->getNberShortCode();

            return view('nber.attendance.democlassroom_attendance',compact(
                'ap',
                'exam_id',
                'id',
                'programmes',
                'institutes',
                'exam',
                'programme',
                'institute',
                'academicyears',
                'academicyear',
                'nber',
                'approvedprogramme'
            ));
       
    } 

}
