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

    public function __construct(HelperService $help)
    {
        $this->middleware(['role:faculty']);
        $this->helperService = $help;
    }
    public function index(Request $r){
        $examstartdate = '2025-05-20';
        $examenddate = '2025-06-15';
       // $examstartdate =  \Carbon\Carbon::now()->subDay()->subDay()->subDay()->toDateString();
        $practicalexaminer_id = $this->helperService->getPracticalExaminerID();
        
        $practicalexams = \App\Practicalexam::where('exam_id',27)->where('faculty_id',$practicalexaminer_id)->orderBy('institute_id')->get();
        foreach($practicalexams as $pe){

            $examstartdate= $pe->start_date;


            // if($pe->course_id == 1){
            //     $examstartdate = '2025-05-20';
            // }
        }
        $date = \Carbon\Carbon::now()->toDateString();
        if($date > $examenddate){
            $date = $examenddate;
        }
        if(Session::has('date')){
            $date = Session::get('date');
        }
        
        if($r->has('date')){
            $fromdate = \Carbon\Carbon::parse($examstartdate)->toDateString();
            for ($i = 0; $i < 60; $i++) {
                $fromdate = \Carbon\Carbon::parse($fromdate)->addDay()->toDateString();
                $date =  $r->date == $fromdate ? $r->date : $date;
            }
        }
        // $job = (new \App\Jobs\GeneratePEPassword())->onQueue('gpepwd');
        // $this->dispatch($job);

        Session::put('date',$date);
        
        return view('practicalexaminer.home.index',compact(
            'practicalexams','practicalexaminer_id','examstartdate'
        ));
    }


     public function appointment(Request $r){
// $nber = \App\Nber::where('id', 1)->first();
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
    INNER JOIN awardlisttemplates als 
    ON
    practicalexams.id = als.practicalexam_id AND marksheet IS NOT NULL 
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
		( courses.nber_id = nbers.id AND courses.id not in (7,23) ) OR 
        ( institutes.idd_under_nber_id = nbers.id AND courses.id in (7,23) ) 
WHERE
	practicalexams.start_date IS NOT NULL AND practicalexams.exam_id=27 and
	f.id ='.$faculty->id;

		$paractical =  (new DBService)->fetch($paractical);
    view()->share('paractical', $paractical);

    return PDF::loadView('practicalexaminer.appointment')
->setPaper('a4', 'portrait')
              ->download('Examiner_Appointment_Letter.pdf');
      return view('practicalexaminer.appointment',compact('paractical'));

    }





    public function update($id,Request $request){
        //return "Closed";
            $subject_id = $request->subject_id;
            $template = \App\Awardlisttemplate::find($id);
            
            $ap = \App\Approvedprogramme::find($template->approvedprogramme_id);
            $applications = \App\Allapplication::whereHas('candidate',function($q) use ($template){
                $q->where('approvedprogramme_id',$template->approvedprogramme_id);
            })->where('subject_id',$subject_id)->where('exam_id',27)
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
