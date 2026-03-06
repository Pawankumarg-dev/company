<?php

namespace App\Http\Controllers\Externalexamcenter;

use App\Application;
use App\Approvedprogramme;
use App\Candidate;
use App\Demo;
use App\Exam;
use App\Examtimetable;
use App\Externalexamcenter;
use App\Externalexamcenterdetail;
use App\Institute;
use App\Mark;
use App\Subject;
use DateTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use File;
use Input;
use Response;
use PDF;

class HomeController extends Controller
{
    //
    public function index() {
        $exam = Exam::where('id', '14')->first();
        $title = "March 2021 - Exam Center Login Page";

        return view('externalexamcenter.index', compact('exam', 'title'));
    }

    public function oldchecklogin(Request $request) {

        $validator = validator($request->all());

        $externalexamcenter = Externalexamcenter::where('code', $request->externalexamcenter_code)->first();

        $validator->after(function ($validator) use ($request, $externalexamcenter) {
            if(is_null($request->externalexamcenter_code) || is_null($request->externalexamcenter_password)) {
                if(is_null($request->externalexamcenter_code) && is_null($request->externalexamcenter_password)) {
                    $validator->errors()->add('externalexamcenter_code', 'Please enter the login credentials');
                    $validator->errors()->add('externalexamcenter_password', '');
                }
            }
            else{
                if(is_null($externalexamcenter)) {
                    $validator->errors()->add('externalexamcenter_code', 'Please enter the valid login credentials');
                }
                else{
                    $examcenterdetails = Externalexamcenterdetail::where('exam_id', $request->exam_id)->where('externalexamcenter_id', $externalexamcenter->id)->where('active_status', 1)->get();

                    if($examcenterdetails->count() == 0) {
                        $validator->errors()->add('externalexamcenter_code', 'Please enter the valid login credentials');
                    }
                    elseif($request->externalexamcenter_password != $externalexamcenter->password) {
                        $validator->errors()->add('externalexamcenter_code', '2. Please enter the valid login credentials');
                    }
                }
            }

        });

        $this->validateWith($validator);

        return redirect('/externalexamcenter/'.$externalexamcenter->id.'/show-home-page/'.$request->exam_id);
    }

    public function oldshow_home_page($exc_id, $e_id){
        $exam = $exam = Exam::where('id', $e_id)->first();
        $title = "Exam Center Home Page";
        $externalexamcenter = Externalexamcenter::where('id', $exc_id)->first();
        $examcenterdetails = Externalexamcenterdetail::where('exam_id', $exam->id)->where('externalexamcenter_id', $externalexamcenter->id)->where('active_status', 1)->get();

        $institute_ids = $examcenterdetails->pluck('institute_id')->toArray();
        $app_ids = Approvedprogramme::whereIn('institute_id', $institute_ids)->pluck('id')->toArray();

        $applications = Application::select("applications.subject_id")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->where('exam_id', $exam->id)->whereIn('approvedprogramme_id', $app_ids)
            ->where("subjects.subjecttype_id", 1)
            ->groupBy("applications.subject_id")
            ->get();

        $subject_ids = $applications->pluck('subject_id')->toArray();

        $approvedprogramme_ids = $applications->pluck('approvedprogramme_id')->unique()->toArray();
        $approvedprogrammes = Application::whereIn('approvedprogramme_id', $approvedprogramme_ids)->get();

        $examtimetables = Examtimetable::where('exam_id', $exam->id)->whereIn('subject_id', $subject_ids)->orderBy('startdate')->get();

        return view('externalexamcenter.home', compact('externalexamcenter','exam', 'title', 'examcenterdetails', 'approvedprogrammes', 'examtimetables'));
    }

    public function oldshowExamSchedules($exc_id, $e_id) {
        $exam = $exam = Exam::where('id', $e_id)->first();
        $title = "Attendance Sheet - Exam Schedules Page";
        $externalexamcenter = Externalexamcenter::where('id', $exc_id)->first();
        $examcenterdetails = Externalexamcenterdetail::where('exam_id', $exam->id)->where('externalexamcenter_id', $externalexamcenter->id)->where('active_status', 1)->get();

        $institute_ids = $examcenterdetails->pluck('institute_id')->toArray();
        $app_ids = Approvedprogramme::whereIn('institute_id', $institute_ids)->pluck('id')->toArray();

        $applications = Application::select("applications.subject_id")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->where('exam_id', $exam->id)->whereIn('approvedprogramme_id', $app_ids)
            ->where("subjects.subjecttype_id", 1)
            ->groupBy("applications.subject_id")
            ->get();

        $subject_ids = $applications->pluck('subject_id')->toArray();
        $examtimetables = Examtimetable::where('exam_id', $exam->id)->whereIn('subject_id', $subject_ids)->groupBy('startdate')->orderBy('startdate')->get();

        return view('externalexamcenter.attendancesheets.showexamschedules', compact('externalexamcenter', 'exam', 'title', 'examcenterdetails', 'examtimetables'));
    }

    public function oldviewAttendanceSheets($exc_id, $e_id, $et_startdate) {
        $exam = Exam::where('id', $e_id)->first();

        $externalexamcenter = Externalexamcenter::where('id', $exc_id)->first();
        $externalexamcenterdetails = Externalexamcenterdetail::where('exam_id', $exam->id)->where('externalexamcenter_id', $externalexamcenter->id)->where('active_status', 1)->get();
        $examtimetables = Examtimetable::where('startdate', $et_startdate)->get();

        $institute_ids = $externalexamcenterdetails->pluck('institute_id')->toArray();
        $app_ids = Approvedprogramme::whereIn('institute_id', $institute_ids)->pluck('id')->toArray();
        $subject_ids = $examtimetables->pluck('subject_id')->toArray();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->where('exam_id', $exam->id)->whereIn('approvedprogramme_id', $app_ids)
            ->where("subjects.subjecttype_id", '1')
            ->whereIn("applications.subject_id", $subject_ids)
            ->get();

        $approvedprogramme_ids = $applications->unique('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();

        $candidate_ids = $applications->pluck("candidate_id")->toArray();

        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();

        $approvedprogrammes = Approvedprogramme::select("approvedprogrammes.*")
            ->join("academicyears", "academicyears.id", "=", "approvedprogrammes.academicyear_id")
            ->whereIn("approvedprogrammes.id", $approvedprogramme_ids)
            ->orderBy("academicyears.year")
            ->get();

        $date = Examtimetable::where('startdate', $et_startdate)->first();

        $title = $externalexamcenter->code." - Attendance Sheet - ".$date->startdate->format('dmYA');

        return view('externalexamcenter.attendancesheets.viewattendancesheets', compact('exam', 'externalexamcenter', 'title', 'externalexamcenterdetail', 'applications', 'examtimetables', 'approvedprogrammes', 'candidates'));

    }

    public function checklogin(Request $request) {
        $validator = validator($request->all());
        $externalexamcenter = Externalexamcenter::where('code', $request->externalexamcenter_code)->where('active_status', '1')->first();

        $validator->after(function ($validator) use ($request, $externalexamcenter) {
            if(is_null($request->externalexamcenter_code) || is_null($request->externalexamcenter_password)) {
                if(is_null($request->externalexamcenter_code) && is_null($request->externalexamcenter_password)) {
                    $validator->errors()->add('externalexamcenter_code', 'Please enter the login credentials');
                    $validator->errors()->add('externalexamcenter_password', '');
                }
            }
            else {
                if(is_null($externalexamcenter)) {
                    $validator->errors()->add('externalexamcenter_code', 'Please enter the valid login credentials');
                }
                else {
                    if($request->externalexamcenter_password != $externalexamcenter->password) {
                        $validator->errors()->add('externalexamcenter_code', 'Please enter the valid login credentials');
                    }
                }
            }
        });

        $this->validateWith($validator);
        return redirect('/externalexamcenter/'.$externalexamcenter->id.'/show-home-page/'.$request->exam_id);
    }

    public function show_home_page($exc_id, $e_id){
        $exam = $exam = Exam::where('id', $e_id)->first();
        $title = $exam->name." - Exam Center Home Page";
        $externalexamcenter = Externalexamcenter::where('id', $exc_id)->first();
        $examcenterdetails = Externalexamcenterdetail::where('exam_id', $exam->id)->where('externalexamcenter_id', $externalexamcenter->id)->where('active_status', 1)->get();

        $institute_ids = $examcenterdetails->pluck('institute_id')->toArray();
        $app_ids = Approvedprogramme::whereIn('institute_id', $institute_ids)->pluck('id')->toArray();

        $applications = Application::select("applications.subject_id")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->where('exam_id', $exam->id)->whereIn('approvedprogramme_id', $app_ids)
            ->where("subjects.subjecttype_id", 1)
            ->groupBy("applications.subject_id")
            ->get();

        $subject_ids = $applications->pluck('subject_id')->toArray();

        $approvedprogramme_ids = $applications->pluck('approvedprogramme_id')->unique()->toArray();
        $approvedprogrammes = Application::whereIn('approvedprogramme_id', $approvedprogramme_ids)->get();

        $examtimetables = Examtimetable::where('exam_id', $exam->id)->whereIn('subject_id', $subject_ids)->orderBy('startdate')->get();

        return view('externalexamcenter.home', compact('externalexamcenter','exam', 'title', 'examcenterdetails', 'approvedprogrammes', 'examtimetables'));
    }

    public function show_question_papers($exc_id, $e_id){
    $exam = $exam = Exam::where('id', $e_id)->first();
    $title = "Exam Centre Home Page";
    $externalexamcenter = Externalexamcenter::where('id', $exc_id)->first();
    $examcenterdetails = Externalexamcenterdetail::where('exam_id', $exam->id)->where('externalexamcenter_id', $externalexamcenter->id)->where('active_status', 1)->get();

    $institute_ids = $examcenterdetails->pluck('institute_id')->toArray();
    $app_ids = Approvedprogramme::whereIn('institute_id', $institute_ids)->pluck('id')->toArray();

    $applications = Application::select("applications.subject_id")
        ->join("subjects", "subjects.id", "=", "applications.subject_id")
        ->where('exam_id', $exam->id)->whereIn('approvedprogramme_id', $app_ids)
        ->where("subjects.subjecttype_id", 1)
        ->groupBy("applications.subject_id")
        ->get();

    $subject_ids = $applications->pluck('subject_id')->toArray();

    $approvedprogramme_ids = $applications->pluck('approvedprogramme_id')->unique()->toArray();
    $approvedprogrammes = Application::whereIn('approvedprogramme_id', $approvedprogramme_ids)->get();

    $date = date("Y-m-d");
    $currentdate = new DateTime(date("Y-m-d H:i"));

    $examtimetables = Examtimetable::where('exam_id', $exam->id)->whereIn('subject_id', $subject_ids)->where('examdate', $date)->orderBy('startdate')->get();

    $startdates = Examtimetable::select('startdate')->where('exam_id', $exam->id)->whereIn('subject_id', $subject_ids)->where('examdate', $date)->groupBy('startdate')->orderBy('startdate')->get();

    return view('externalexamcenter.showquestionpaper', compact('externalexamcenter','exam', 'title', 'examcenterdetails', 'approvedprogrammes', 'examtimetables', 'startdates', 'date', 'currentdate'));
    //echo $date;
}

    public function show_attendance_sheet($exc_id, $e_id){
        $exam = Exam::where('id', $e_id)->first();
        $title = "Attendance Sheet Download Page";
        $externalexamcenter = Externalexamcenter::where('id', $exc_id)->first();
        $examcenterdetails = Externalexamcenterdetail::where('exam_id', $exam->id)->where('externalexamcenter_id', $externalexamcenter->id)->where('active_status', 1)->get();

        $institute_ids = $examcenterdetails->pluck('institute_id')->toArray();
        $app_ids = Approvedprogramme::whereIn('institute_id', $institute_ids)->pluck('id')->toArray();

        $applications = Application::select("applications.subject_id")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->where('exam_id', $exam->id)->whereIn('approvedprogramme_id', $app_ids)
            ->where("subjects.subjecttype_id", 1)
            ->groupBy("applications.subject_id")
            ->get();

        $subject_ids = $applications->pluck('subject_id')->toArray();

        $approvedprogramme_ids = $applications->pluck('approvedprogramme_id')->unique()->toArray();
        $approvedprogrammes = Application::whereIn('approvedprogramme_id', $approvedprogramme_ids)->get();

        $examtimetables = Examtimetable::where('exam_id', $exam->id)->whereIn('subject_id', $subject_ids)->orderBy('startdate')->get();

        return view('externalexamcenter.showattendancesheet', compact('externalexamcenter','exam', 'title', 'examcenterdetails', 'approvedprogrammes', 'examtimetables', 'startdates', 'date', 'currentdate'));
    }

    public function showExamSchedules($exc_id, $e_id) {
        $exam = Exam::where('id', $e_id)->first();
        $title = "December 2020 - Attendance Sheet - Exam Schedules Page";
        $externalexamcenter = Externalexamcenter::where('id', $exc_id)->where('active_status', '1')->first();

        $applications = Application::
            join("examtimetables", "examtimetables.id", "=", "applications.examtimetable_id")
            ->where("applications.externalexamcenter_id", $externalexamcenter->id)
            ->where("applications.hallticket_status", "1")
            ->where("applications.exam_id", $exam->id)
            ->groupBy("examtimetables.id")
            ->orderBy("examtimetables.startdate")
            ->orderBy("examtimetables.id")
            ->get();

        $examtimetable_ids = $applications->pluck('examtimetable_id')->unique()->toArray();

        $examtimetables = Examtimetable::whereIn('id', $examtimetable_ids)->orderBy('examdate')->get();

        $commonexamtimetables = Examtimetable::whereIn('id', $examtimetable_ids)->orderBy('startdate')->groupBy('startdate')->get();

        return view('externalexamcenter.attendancesheets.showexamschedules', compact('externalexamcenter', 'exam', 'title', 'examtimetables', 'commonexamtimetables'));

        /*
        $examcenterdetails = Externalexamcenterdetail::where('exam_id', $exam->id)->where('externalexamcenter_id', $externalexamcenter->id)->where('active_status', 1)->get();

        $institute_ids = $examcenterdetails->pluck('institute_id')->toArray();
        $app_ids = Approvedprogramme::whereIn('institute_id', $institute_ids)->pluck('id')->toArray();

        $applications = Application::select("applications.subject_id")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->where('exam_id', $exam->id)->whereIn('approvedprogramme_id', $app_ids)
            ->where("subjects.subjecttype_id", 1)
            ->groupBy("applications.subject_id")
            ->get();

        $subject_ids = $applications->pluck('subject_id')->toArray();
        $examtimetables = Examtimetable::where('exam_id', $exam->id)->whereIn('subject_id', $subject_ids)->groupBy('startdate')->orderBy('startdate')->get();

        return view('externalexamcenter.attendancesheets.showexamschedules', compact('externalexamcenter', 'exam', 'title', 'examcenterdetails', 'examtimetables'));
        */
        }

    public function download_attendance_sheet($exc_id, $et_id){
        $examtimetable = Examtimetable::where('id', $et_id)->first();
        $title = "Attendance Sheet";
        $externalexamcenter = Externalexamcenter::where('id', $exc_id)->first();
        $exam = Exam::where('id', $examtimetable->exam_id)->first();

        $examcenterdetails = Externalexamcenterdetail::where('exam_id', $exam->id)->where('externalexamcenter_id', $externalexamcenter->id)->where('active_status', 1)->get();

        $institute_ids = $examcenterdetails->pluck('institute_id')->toArray();
        $app_ids = Approvedprogramme::whereIn('institute_id', $institute_ids)->pluck('id')->toArray();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->where('exam_id', $exam->id)->whereIn('approvedprogramme_id', $app_ids)
            ->where("subjects.id", $examtimetable->subject->id)
            ->get();

        $approvedprogramme_ids = $applications->pluck('approvedprogramme_id')->unique()->toArray();

        $approvedprogrammes = Approvedprogramme::select("approvedprogrammes.*")
            ->join("academicyears", "academicyears.id", "=", "approvedprogrammes.academicyear_id")
            ->whereIn("approvedprogrammes.id", $approvedprogramme_ids)
            ->orderBy("academicyears.year")
            ->get();

        $candidate_ids = $applications->pluck('approvedprogramme_id')->unique()->toArray();

        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')->orderBy('enrolmentno')->get();

        return view('externalexamcenter.downloadattendancesheet', compact('externalexamcenter','exam', 'title', 'examcenterdetails', 'approvedprogrammes', 'examtimetable', 'candidates'));
    }

    public function viewAttendanceSheets($e_id, $exc_id, $et_id) {
        $exam = Exam::where('id', $e_id)->first();
        $title = "December 2020 Examination";

        $externalexamcenter = Externalexamcenter::where('id', $exc_id)->where('active_status', '1')->first();
        $examtimetable = Examtimetable::find($et_id);

        if(!is_null($externalexamcenter)) {
            $applications = Application::where("applications.externalexamcenter_id", $exc_id)->where("applications.exam_id", $e_id)
                ->where("applications.examtimetable_id", $et_id)->where("hallticket_status", 1)
                ->join("marks", "marks.application_id", "=", "applications.id")
                ->where("marks.internalresult_id", "1")
                ->get();

            $approvedprogramme_ids = $applications->pluck('approvedprogramme_id')->unique()->toArray();

            $approvedprogrammes = Approvedprogramme::select("approvedprogrammes.*")
                ->join("institutes", "institutes.id", "=", "approvedprogrammes.institute_id")
                ->join("academicyears", "academicyears.id", "=", "approvedprogrammes.academicyear_id")
                ->whereIn("approvedprogrammes.id", $approvedprogramme_ids)
                ->orderBy("institutes.code")
                ->orderBy("academicyears.year")
                ->get();

            $candidate_ids = $applications->pluck("candidate_id")->toArray();

            $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
                ->orderBy('enrolmentno')->get();

            return view('externalexamcenter.attendancesheets.viewattendancesheets', compact('exam', 'externalexamcenter', 'title', 'applications', 'examtimetable', 'approvedprogrammes', 'examtimetable', 'candidates'));

        }
        else {
            redirect('/');
        }
        /*
        $examtimetables = Examtimetable::where('startdate', $et_startdate)->get();

        $institute_ids = $externalexamcenterdetails->pluck('institute_id')->toArray();
        $app_ids = Approvedprogramme::whereIn('institute_id', $institute_ids)->pluck('id')->toArray();
        $subject_ids = $examtimetables->pluck('subject_id')->toArray();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->where('exam_id', $exam->id)->whereIn('approvedprogramme_id', $app_ids)
            ->where("subjects.subjecttype_id", '1')
            ->whereIn("applications.subject_id", $subject_ids)
            ->get();

        $approvedprogramme_ids = $applications->unique('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();

        $candidate_ids = $applications->pluck("candidate_id")->toArray();

        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();

        $approvedprogrammes = Approvedprogramme::select("approvedprogrammes.*")
            ->join("academicyears", "academicyears.id", "=", "approvedprogrammes.academicyear_id")
            ->whereIn("approvedprogrammes.id", $approvedprogramme_ids)
            ->orderBy("academicyears.year")
            ->get();

        $date = Examtimetable::where('startdate', $et_startdate)->first();

        $title = $externalexamcenter->code." - Attendance Sheet - ".$date->startdate->format('dmYA');

        return view('externalexamcenter.attendancesheets.viewattendancesheets', compact('exam', 'externalexamcenter', 'title', 'externalexamcenterdetail', 'applications', 'examtimetables', 'approvedprogrammes', 'candidates'));
        */
    }

    public function download_question_papers($et_id){
       $examtimetables = Examtimetable::where('id', $et_id)->first();

       if(!is_null($examtimetables)){
           if(!is_null($examtimetables->questionpaper)) {
               $file = public_path().'/files/questionpapers/'.$examtimetables->questionpaper;
               return Response::download($file);
           }
       }
    }

    public function showmarkattendanceforms($exc_id, $e_id, $et_startdate) {
        $exam = Exam::where('id', $e_id)->first();

        $externalexamcenter = Externalexamcenter::where('id', $exc_id)->first();
        $externalexamcenterdetails = Externalexamcenterdetail::where('exam_id', $exam->id)->where('externalexamcenter_id', $externalexamcenter->id)->where('active_status', 1)->get();
        $examtimetables = Examtimetable::where('startdate', $et_startdate)->get();

        $institute_ids = $externalexamcenterdetails->pluck('institute_id')->toArray();
        $app_ids = Approvedprogramme::whereIn('institute_id', $institute_ids)->pluck('id')->toArray();
        $subject_ids = $examtimetables->pluck('subject_id')->toArray();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->where('applications.exam_id', $exam->id)->whereIn('applications.approvedprogramme_id', $app_ids)
            ->where("subjects.subjecttype_id", '1')
            ->whereIn("applications.subject_id", $subject_ids)
            ->get();

        $approvedprogramme_ids = $applications->unique('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();

        $candidate_ids = $applications->pluck("candidate_id")->toArray();

        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();

        $approvedprogrammes = Approvedprogramme::select("approvedprogrammes.*")
            ->join("academicyears", "academicyears.id", "=", "approvedprogrammes.academicyear_id")
            ->join("institutes", "institutes.id", "=", "approvedprogrammes.institute_id")
            ->join("programmes", "programmes.id", "=", "approvedprogrammes.programme_id")
            ->whereIn("approvedprogrammes.id", $approvedprogramme_ids)
            ->orderBy("institutes.code")
            ->orderBy("programmes.sortorder")
            ->orderBy("academicyears.year")
            ->get();

        $date = Examtimetable::where('startdate', $et_startdate)->first();

        $title = $externalexamcenter->code." - Mark Attendance - ".$date->startdate->format('d-m-Y A');

        return view('externalexamcenter.attendancesheets.showmarkattendanceforms', compact('exam', 'externalexamcenter', 'title', 'externalexamcenterdetail', 'applications', 'examtimetables', 'approvedprogrammes', 'candidates', 'date'));
    }

    public function markattendanceforms(Request $request) {
        $count = 0;

        foreach ($request->application_id as $app) {
            if($request->ext_attendance[$count] == "Absent") {
                echo '<br>'.$app.' '.$request->ext_attendance[$count];

                $application = Application::find($app);

                $mark = Mark::where('application_id', $application->id)->first();

                if(is_null($mark)) {

                    Mark::create([
                        "application_id" => $application->id,
                        "exam_id" => $application->exam_id,
                        "subject_id" => $application->subject_id,
                        "external" => "Abs",
                        "externalresult_id" => "0",
                        "external_lock" => "0",
                        "active_status" => "1",
                    ]);
                }
                else {
                    $mark->update([
                        "external" => "Abs",
                        "externalresult_id" => "0",
                        "external_lock" => "0",
                        "active_status" => "1",
                    ]);
                }

            }
            $count++;
        }

        return redirect('/externalexamcenter/'.$request->externalexamcenter_id.'/attendance-sheet/'.$request->exam_id.'/show-markedattendances/'.$request->examstartdate);

        }

    public function showmarkedattendances($exc_id, $e_id, $et_startdate) {
        $exam = Exam::where('id', $e_id)->first();

        $externalexamcenter = Externalexamcenter::where('id', $exc_id)->first();
        $externalexamcenterdetails = Externalexamcenterdetail::where('exam_id', $exam->id)->where('externalexamcenter_id', $externalexamcenter->id)->where('active_status', 1)->get();
        $examtimetables = Examtimetable::where('startdate', $et_startdate)->get();

        $institute_ids = $externalexamcenterdetails->pluck('institute_id')->toArray();
        $app_ids = Approvedprogramme::whereIn('institute_id', $institute_ids)->pluck('id')->toArray();
        $subject_ids = $examtimetables->pluck('subject_id')->toArray();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->where('applications.exam_id', $exam->id)->whereIn('applications.approvedprogramme_id', $app_ids)
            ->where("subjects.subjecttype_id", '1')
            ->whereIn("applications.subject_id", $subject_ids)
            ->get();

        $approvedprogramme_ids = $applications->unique('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();

        $candidate_ids = $applications->pluck("candidate_id")->toArray();

        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();

        $approvedprogrammes = Approvedprogramme::select("approvedprogrammes.*")
            ->join("academicyears", "academicyears.id", "=", "approvedprogrammes.academicyear_id")
            ->join("institutes", "institutes.id", "=", "approvedprogrammes.institute_id")
            ->join("programmes", "programmes.id", "=", "approvedprogrammes.programme_id")
            ->whereIn("approvedprogrammes.id", $approvedprogramme_ids)
            ->orderBy("institutes.code")
            ->orderBy("programmes.sortorder")
            ->orderBy("academicyears.year")
            ->get();

        $date = Examtimetable::where('startdate', $et_startdate)->first();

        $title = $externalexamcenter->code." - Mark Attendance Preview - ".$date->startdate->format('d-m-Y A');

        return view('externalexamcenter.attendancesheets.showmarkedattendanceforms', compact('exam', 'externalexamcenter', 'title', 'externalexamcenterdetail', 'applications', 'examtimetables', 'approvedprogrammes', 'candidates', 'date'));
    }

    public function showmarkabsenteeforms($exc_id, $e_id, $et_startdate) {
        $exam = Exam::where('id', $e_id)->first();

        $externalexamcenter = Externalexamcenter::where('id', $exc_id)->first();
        $externalexamcenterdetails = Externalexamcenterdetail::where('exam_id', $exam->id)->where('externalexamcenter_id', $externalexamcenter->id)->where('active_status', 1)->get();
        $examtimetables = Examtimetable::where('startdate', $et_startdate)->get();

        $institute_ids = $externalexamcenterdetails->pluck('institute_id')->toArray();
        $app_ids = Approvedprogramme::whereIn('institute_id', $institute_ids)->pluck('id')->toArray();
        $subject_ids = $examtimetables->pluck('subject_id')->toArray();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->where('applications.exam_id', $exam->id)->whereIn('applications.approvedprogramme_id', $app_ids)
            ->where("subjects.subjecttype_id", '1')
            ->whereIn("applications.subject_id", $subject_ids)
            ->get();

        $approvedprogramme_ids = $applications->unique('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();

        $application_ids = $applications->pluck('id')->toArray();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        $candidate_ids = $applications->pluck("candidate_id")->toArray();

        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();

        $approvedprogrammes = Approvedprogramme::select("approvedprogrammes.*")
            ->join("academicyears", "academicyears.id", "=", "approvedprogrammes.academicyear_id")
            ->join("institutes", "institutes.id", "=", "approvedprogrammes.institute_id")
            ->join("programmes", "programmes.id", "=", "approvedprogrammes.programme_id")
            ->whereIn("approvedprogrammes.id", $approvedprogramme_ids)
            ->orderBy("institutes.code")
            ->orderBy("programmes.sortorder")
            ->orderBy("academicyears.year")
            ->get();

        $date = Examtimetable::where('startdate', $et_startdate)->first();

        $title = $externalexamcenter->code." - Mark Attendance - ".$date->startdate->format('d-m-Y A');

        foreach ($marks as $mark) {
            echo 'Candidate Enrolmentno: '.$mark->application->candidate->enrolmentno.' External: '.$mark->external.'<br>';
        }

        //return view('externalexamcenter.attendancesheets.showmarkabsenteeforms', compact('exam', 'externalexamcenter', 'title', 'externalexamcenterdetail', 'applications', 'examtimetables', 'approvedprogrammes', 'candidates', 'date', 'marks'));
    }

    public function markabsenteesforms(Request $request) {
        $count = 0;

        foreach ($request->ext_attendance as $ext_attendance) {
            if($ext_attendance == 'Absent') {
                $application = Application::find($request->application_id[$count]);

                $mark = Mark::where('application_id', $application->id)->first();

                if(is_null($mark)) {
                    Mark::create([
                        "application_id" => $application->id,
                        "exam_id" => $application->exam_id,
                        "subject_id" => $application->subject_id,
                        "external" => 'Abs',
                        "externalresult_id" => "0",
                        "external_lock" => "0",
                        "active_status" => "1",
                    ]);
                }
                else {
                    $mark->update([
                        "external" => 'Abs',
                        "externalresult_id" => "0",
                        "external_lock" => "0",
                        "active_status" => "1",
                    ]);
                }
            }

            /*
            if($ext_attendance == 'Abs') {
                $application = Application::find($request->application_id[$count]);

                $mark = Mark::where('application_id', $application->id)->first();

                if(is_null($mark)) {
                    Mark::create([
                        "application_id" => $application->id,
                        "exam_id" => $application->exam_id,
                        "subject_id" => $application->subject_id,
                        "external" => 'Abs',
                        "externalresult_id" => "0",
                        "external_lock" => "0",
                        "active_status" => "1",
                    ]);
                }
                else {
                    $mark->update([
                        "external" => 'Abs',
                        "externalresult_id" => "0",
                        "external_lock" => "0",
                        "active_status" => "1",
                    ]);
                }
            }
            */
        }

        //return redirect('/externalexamcenter/'.$request->externalexamcenter_id.'/attendance-sheet/'.$request->exam_id.'/show-markedabsentees/'.$request->examstartdate);
    }

    public function showmarkedabsentees($exc_id, $e_id, $et_startdate) {
        $exam = Exam::where('id', $e_id)->first();

        $externalexamcenter = Externalexamcenter::where('id', $exc_id)->first();
        $externalexamcenterdetails = Externalexamcenterdetail::where('exam_id', $exam->id)->where('externalexamcenter_id', $externalexamcenter->id)->where('active_status', 1)->get();
        $examtimetables = Examtimetable::where('startdate', $et_startdate)->get();

        $institute_ids = $externalexamcenterdetails->pluck('institute_id')->toArray();
        $app_ids = Approvedprogramme::whereIn('institute_id', $institute_ids)->pluck('id')->toArray();
        $subject_ids = $examtimetables->pluck('subject_id')->toArray();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->where('applications.exam_id', $exam->id)->whereIn('applications.approvedprogramme_id', $app_ids)
            ->where("subjects.subjecttype_id", '1')
            ->whereIn("applications.subject_id", $subject_ids)
            ->get();

        $approvedprogramme_ids = $applications->unique('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();

        $candidate_ids = $applications->pluck("candidate_id")->toArray();

        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();

        $approvedprogrammes = Approvedprogramme::select("approvedprogrammes.*")
            ->join("academicyears", "academicyears.id", "=", "approvedprogrammes.academicyear_id")
            ->join("institutes", "institutes.id", "=", "approvedprogrammes.institute_id")
            ->join("programmes", "programmes.id", "=", "approvedprogrammes.programme_id")
            ->whereIn("approvedprogrammes.id", $approvedprogramme_ids)
            ->orderBy("institutes.code")
            ->orderBy("programmes.sortorder")
            ->orderBy("academicyears.year")
            ->get();

        $date = Examtimetable::where('startdate', $et_startdate)->first();

        $title = $externalexamcenter->code." - Mark Attendance Preview - ".$date->startdate->format('d-m-Y A');

        return view('externalexamcenter.attendancesheets.showmarkedabsentees', compact('exam', 'externalexamcenter', 'title', 'externalexamcenterdetail', 'applications', 'examtimetables', 'approvedprogrammes', 'candidates', 'date'));
    }

    public function show_demo_question_papers($exc_id, $e_id){
        $exam = Exam::where('id', $e_id)->first();
        $title = $exam->name." Examination";
        $externalexamcenter = Externalexamcenter::where('id', $exc_id)->first();

        return view('externalexamcenter.questionpapers.demoquestion', compact('externalexamcenter','exam', 'title', 'examcenterdetails', 'approvedprogrammes', 'examtimetables', 'startdates', 'date', 'currentdate'));
        //echo $date;
    }

    public function downloadpaper1(){
        $file = public_path().'/files/documents/Subject-1.pdf';
        return Response::download($file);
    }
    public function downloadpaper2(){
        $file = public_path().'/files/documents/Subject-2.pdf';
        return Response::download($file);
    }
    public function downloadpaper3(){
        $file = public_path().'/files/documents/Subject-3.pdf';
        return Response::download($file);
    }

    public function getinfo1(Request $request) {
        Demo::create([
            "externalexamcentercode" => $request->externalexamcentercode,
            "subject" => $request->subject,
            "download" => 1
        ]);

        $data = '1';
        return response()->json($data);
    }

    public function getinfo2(Request $request) {
        Demo::create([
            "externalexamcentercode" => $request->externalexamcentercode,
            "subject" => $request->subject,
            "download" => 1
        ]);

        $data = '1';
        return response()->json($data);
    }

    public function getinfo3(Request $request) {
        Demo::create([
            "externalexamcentercode" => $request->externalexamcentercode,
            "subject" => $request->subject,
            "download" => 1
        ]);

        $data = '1';
        return response()->json($data);
    }


}
