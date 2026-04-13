<?php

namespace App\Http\Controllers\Practicalexaminer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use Session;
use Illuminate\Support\Facades\Hash;
use App\Services\DBService;
use Auth;
use App\Http\Requests;
use PDF;

class HomeController extends Controller
{
    private $helperService;
    private $exam_id;

    public function __construct(HelperService $help)
    {
        $this->middleware(['role:faculty']);
        $this->helperService = $help;
                $this->exam_id = 28;

    }
    public function index(Request $r){

        $examstartdate = '2026-03-24';
        $examenddate = '2026-04-06';
        $practicalexaminer_id = $this->helperService->getPracticalExaminerID();

        $date = \Carbon\Carbon::now()->toDateString();
    
        if(Session::has('date')){
            Session::put('date', $date);
        }


        $practicalexams = \App\Practicalexam::where('exam_id',$this->exam_id)->whereNull('deleted_at')->where('faculty_id',$practicalexaminer_id)->orderBy('institute_id')->get();
       

        return view('practicalexaminer.home.index',compact(
            'practicalexams','practicalexaminer_id','examstartdate'
        ));
    }


     public function appointment(Request $r){
            $exam = \App\Exam::where('id',$this->exam_id)->first();
                $faculty =  \App\Faculty::where('user_id',Auth::user()->id)->first();
       $paractical = 'SELECT
       nbers.logo,
	nbers.short_name_code, 
    	nbers.address as nber_address, 
    	nbers.email as nber_email, 
nbers.practical_exam_contact_1,
nbers.practical_exam_contact_2,
nbers.practical_exam_contact_3,
	institutes.rci_code AS exam_center, 
	courses.`name`, 
	practicalexams.start_date, 
	practicalexams.end_date, 
	f.`name` AS faculty_name, 
	f.address, 
	f.email, 
	f.crr_no AS username, 
	f.`password` AS `password`
	
FROM
	practicalexams
	INNER JOIN
	faculties AS f
	ON 
		f.id = practicalexams.faculty_id
	INNER JOIN
	institutes
	ON 
		practicalexams.institute_id = institutes.id
	INNER JOIN
	courses
	ON 
		practicalexams.course_id = courses.id
	INNER JOIN
	nbers
	ON 
		courses.nber_id = nbers.id 
WHERE
	practicalexams.start_date IS NOT NULL and practicalexams.deleted_at is NULL AND practicalexams.exam_id='.$this->exam_id.' and
	f.id ='.$faculty->id;
		$paractical =  (new DBService)->fetch($paractical);
    view()->share('paractical', $paractical);
view()->share('exam', $exam);

    return PDF::loadView('practicalexaminer.appointment')
->setPaper('a4', 'portrait')
              ->download('Examiner_Appointment_Letter.pdf');


      return view('practicalexaminer.appointment',compact('paractical','exam'));

    }





    public function update($id,Request $request){
       // return "Closed";
            $subject_id = $request->subject_id;
            $template = \App\Awardlisttemplate::find($id);
            
            $ap = \App\Approvedprogramme::find($template->approvedprogramme_id);
            $applications = \App\Allapplication::whereHas('candidate',function($q) use ($template){
                $q->where('approvedprogramme_id',$template->approvedprogramme_id);
            })->where('subject_id',$subject_id)->where('exam_id',$this->exam_id)
            ->get();

            foreach($applications as $application){
                $key = 'mark_'.$application->id;
                $absent = 'absent_'.$application->id;
               // if($application->applicant->block == 1){
                    if($request->has($absent)){
                        $application->attendance_ex = 2;
                    }
                    if($request->has($key)){
                        $application->mark_ex = $request->$key;
                        $application->attendance_ex = 1;
                    }
                    $application->save();
                //}
            }
            $subject = $template->subjects()->where('subject_id',$subject_id)->first();
            $subject->pivot->marks_upload = 1;
            $subject->pivot->date_uploaded = $date = \Carbon\Carbon::now()->toDateTimeString();
            $subject->pivot->save();
            Session::flash('messages','Uploaded');
            return back();
    }
}
