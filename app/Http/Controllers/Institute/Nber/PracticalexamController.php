<?php

namespace App\Http\Controllers\Nber;

use App\Application;
use App\Approvedprogramme;
use App\Candidate;
use App\City;
use App\Exam;
use App\Gender;
use App\Institute;
use App\Practicalexam;
use App\Practicalexamfeedetail;
use App\Practicalexaminer;
use App\Programme;
use App\State;
use App\Subject;
use App\Title;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PracticalexamController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function showLists($examid) {
        $exam = Exam::find($examid);

        $approvedprogrammes = Approvedprogramme::select(array('approvedprogrammes.*', DB::raw('count(distinct applications.candidate_id) as count')))
            ->join('applications', 'applications.approvedprogramme_id', '=', 'approvedprogrammes.id')
            ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
            ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->where('applications.exam_id', $exam->id)
            ->where('subjects.subjecttype_id', '2')
            ->groupBy('applications.approvedprogramme_id')
            ->orderBy('institutes.code')->orderBy('programmes.sortorder')->orderBy('academicyears.year')
            ->get();

        return view('nber.practicalexams.showlists', compact('exam', 'approvedprogrammes'));
    }

    public function showlistsexcel($examid) {
        $exam = Exam::find($examid);

        $approvedprogrammes = Approvedprogramme::select(array('approvedprogrammes.*', DB::raw('count(distinct applications.candidate_id) as candcount'), DB::raw('count(applications.subject_id) as subcount')))
            ->join('applications', 'applications.approvedprogramme_id', '=', 'approvedprogrammes.id')
            ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
            ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->where('applications.exam_id', $exam->id)
            ->where('subjects.subjecttype_id', '2')
            ->groupBy('applications.approvedprogramme_id')
            ->orderBy('institutes.code')->orderBy('programmes.sortorder')->orderBy('academicyears.year')
            ->get();

        $filename = $exam->name.' Examinations - Consolidated Practical Applications Count Details dtd '.date('d-m-Y');
        $sheetname = $exam->name;

        Excel::create($filename, function ($excel) use($sheetname, $exam, $approvedprogrammes){
            $excel->sheet($sheetname, function ($sheet) use($exam, $approvedprogrammes){
                $sheet->loadview('nber.practicalexams.showlistsexcel', compact('exam', 'approvedprogrammes'));
            });
        })->export('xlsx');
    }

    public function showSubjects($examid, $apid) {
        $exam = Exam::find($examid);
        $approvedprogramme = Approvedprogramme::find($apid);

        $subjects = Application::select('subjects.*')
            ->where('approvedprogramme_id', $approvedprogramme->id)
            ->where('exam_id', $exam->id)
            ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
            ->where('subjects.subjecttype_id', '2')
            ->groupBy('subjects.scode')
            ->orderBy('subjects.syear')->orderBy('subjects.sortorder')
            ->get();

        return view('nber.practicalexams.showsubjects', compact('exam', 'approvedprogramme', 'subjects'));
    }

    public function downloadAttendanceSheet($examid, $apid, $sid) {
        $exam = Exam::find($examid);
        $approvedprogramme = Approvedprogramme::find($apid);
        $subject = Subject::find($sid);

        $applications = Application::select('applications.*')
            ->join('candidates', 'candidates.id', '=', 'applications.candidate_id')
            ->where('applications.approvedprogramme_id', $approvedprogramme->id)
            ->where('applications.exam_id', $exam->id)
            ->where('applications.subject_id', $subject->id)
            ->orderBy('candidates.enrolmentno')
            ->get();

        return view('nber.practicalexams.downloadattendancesheet', compact('exam', 'approvedprogramme', 'subject', 'applications'));
    }

    public function home($eid) {
        $title = "Practical Exams";
        $exam = Exam::find($eid);

        return view('nber.practicalexams.examiners.index', compact('title', 'exam'));
    }

    /*
    public function showinstituteslist($eid) {
        $title = "Practical Exams";
        $exam = Exam::find($eid);

        $institutes = Practicalexam::select("institutes.id", "institutes.code", "institutes.name")
            ->join("institutes", "institutes.id", "=", "practicalexams.institute_id")
            ->where("practicalexams.exam_id", $exam->id)
            ->groupBy('practicalexams.institute_id')
            ->orderBy("institutes.code")->get();

        return view('nber.practicalexams.examiners.showinstituteslist', compact('title', 'exam', 'institutes'));
    }
    */

    public function showinstituteslist($eid) {
        $exam = Exam::find($eid);
        $practicalexams = Practicalexam::where("exam_id", $exam->id)->orderBy("exam_date")->get();

        return view('nber.practicalexams.examiners.showinstituteslist', compact('exam', 'practicalexams'));
    }

    public function showcourseslist($eid, $iid) {
        $exam = Exam::find($eid);
        $institute = Institute::find($iid);

        $programmes = Application::join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join("approvedprogrammes", "approvedprogrammes.id", "=", "applications.approvedprogramme_id")
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->where('approvedprogrammes.institute_id', $institute->id)
            ->where('applications.exam_id', $exam->id)
            ->where('subjects.subjecttype_id', 2)
            ->groupBy("programmes.common_code")->get(["programmes.id", "programmes.common_name", "programmes.common_code"]);

        $practicalexams = Practicalexam::where("institute_id", $iid)->where("exam_id", $eid)->get();

        return view('nber.practicalexams.examiners.showcourseslist', compact('title', 'exam', 'institute', 'practicalexams', 'programmes'));
    }

    public function showdetails($eid, $pid) {
        $exam = Exam::find($eid);
        $practicalexam = Practicalexam::find($pid);
        $institute = Institute::find($practicalexam->institute_id);
        $common_name = Programme::where('common_code', $practicalexam->common_code)->first()->common_name;

        $internalexaminers = Practicalexaminer::where("practicalexam_id", $practicalexam->id)->where("practicalexaminertype_id", 1)->get();
        $externalexaminers = Practicalexaminer::where("practicalexam_id", $practicalexam->id)->where("practicalexaminertype_id", 2)->get();

        $approvedprogramme_ids = Approvedprogramme::join("applications", "applications.approvedprogramme_id", "=", "approvedprogrammes.id")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->where('approvedprogrammes.institute_id', $practicalexam->institute->id)
            ->where('applications.exam_id', $exam->id)
            ->where('subjects.subjecttype_id', 2)
            ->where('programmes.common_code', $practicalexam->common_code)
            ->groupBy("approvedprogrammes.id")->pluck("approvedprogrammes.id")->toArray();

        $approvedprogrammes = Approvedprogramme::with("academicyear")
            ->whereIn("id", $approvedprogramme_ids)->get()->sortBy('academicyear.year');

        return view('nber.practicalexams.examiners.showdetails', compact('title', 'exam', 'institute', 'practicalexam', 'common_name', 'internalexaminers', 'externalexaminers', 'approvedprogrammes'));
    }

    public function updatepracticalexam(Request $request) {
        $exam_date2 = null;
         if($request->has('exam_date2')) {
             $exam_date2 = $request->exam_date2;
        }

        Practicalexam::where("id", $request->practicalexam_id)->update([
            "exam_date" => $request->exam_date,
            "exam_date2" => $exam_date2,
            "coursecoordinator_name" => $request->coursecoordinator_name,
            "coursecoordinator_contactnumber" => $request->coursecoordinator_contactnumber,
            "coursecoordinator_whatsappnumber" => $request->coursecoordinator_whatsappnumber,
            "coursecoordinator_email" => trim(strtolower($request->coursecoordinator_email)),
        ]);

        unset($exam_date2);

        return redirect()->back();
    }

    public function updatexaminerdetails($eid, $pid) {
        $exam = Exam::find($eid);
        $practicalexaminer = Practicalexaminer::find($pid);
        $practicalexam = Practicalexam::where("id", $practicalexaminer->practicalexam_id)->first();
        $common_name = Programme::where("common_code", $practicalexam->common_code)->first()->common_name;
        $titles = Title::all();
        $genders = Gender::all();
        $cities = City::all();
        $states = State::orderBy('state_name')->get();

        return view('nber.practicalexams.examiners.updateexaminerdetails', compact('exam', 'practicalexaminer', 'practicalexam', 'common_name', 'titles', 'genders', 'cities', 'states'));
    }

    public function updatepracticalexaminer(Request $request) {
        Practicalexaminer::where("id", $request->practicalexaminer_id)->update([
            "practicalexaminertype_id" => $request->practicalexaminertype_id,
            "title_id" => $request->title_id,
            "name" => $request->name,
            "age" => $request->age,
            "gender_id" => $request->gender_id,
            "qualification" => $request->qualification,
            "crrnumber" => $request->crrnumber,
            "experience" => $request->experience,
            "address" => $request->address,
            "city_id" => $request->city_id,
            "pincode" => $request->pincode,
            "contactnumber" => trim($request->contactnumber),
            "whatsappnumber" => trim($request->whatsappnumber),
            "email" => trim(strtolower($request->email)),
            "select_status" => $request->select_status,
        ]);

        return redirect('/nber/practicalexams/examiners/showdetails/'.$request->exam_id.'/'.$request->practicalexam_id);

    }

    public function addexternalexaminerdetailsform($eid, $pid) {
        $exam = Exam::find($eid);
        $practicalexam = Practicalexam::where("id", $pid)->first();

        if(is_null($practicalexam)) {
            unset($exam);
            unset($practicalexam);
        }
        else {
            $common_name = Programme::where("common_code", $practicalexam->common_code)->first()->common_name;
            $practicalexaminers = Practicalexaminer::where("practicalexam_id", $practicalexam->id)->get();
            $titles = Title::all();
            $genders = Gender::all();
            $cities = City::orderby('name')->get();
            $states = State::orderBy('state_name')->get();

            return view('nber.practicalexams.examiners.addexaminerdetails', compact('exam', 'practicalexam', 'common_name', 'practicalexaminers', 'titles', 'genders', 'cities', 'states'));
        }
    }

    public function addexternalexaminerdetails(Request $request) {
        Practicalexaminer::create([
            "practicalexam_id" => $request->practicalexam_id,
            "practicalexaminertype_id" => 2,
            "title_id" => $request->title_id,
            "name" => $request->name,
            "age" => $request->age,
            "gender_id" => $request->gender_id,
            "qualification" => $request->qualification,
            "crrnumber" => $request->crrnumber,
            "experience" => $request->experience,
            "address" => $request->address,
            "city_id" => $request->city_id,
            "pincode" => $request->pincode,
            "contactnumber" => trim($request->contactnumber),
            "whatsappnumber" => trim($request->whatsappnumber),
            "email" => trim(strtolower($request->email)),
            "active_status" => 1,
        ]);

        return redirect('/nber/practicalexams/examiners/showdetails/'.$request->exam_id.'/'.$request->practicalexam_id);
    }

    public function sendemailtoexaminer(Request $request) {
        $data = "";
        try {
            /*
            November 2021 Examinations

            $practicalexaminer = Practicalexaminer::where("id", $request->practicalexaminer_id)->first();
            $practicalexam = Practicalexam::where('id', $practicalexaminer->practicalexam_id)->first();
            $practicalexamfeedetails = Practicalexamfeedetail::where('practicalexam_id', $practicalexam->id)->get();

            $files = [
                public_path('files/externalpracticalexaminers/Nov2021-ClaimForm.pdf'),
                public_path('files/externalpracticalexaminers/Nov2021-MarkEntryForm.pdf'),
                public_path('files/externalpracticalexaminers/Nov2021-PracticalExamSOP.pdf'),
            ];

            $pdf = PDF::loadView('nber.practicalexams.examiners.examinerattachment', compact('practicalexaminer', 'practicalexam', 'practicalexamfeedetails'))->setPaper('a4', 'portrait');
            $to_name = $practicalexaminer->name;
            $to_email = trim($practicalexaminer->email);
            $exam = $practicalexam->exam->name;

            Mail::send('nber.practicalexams.examiners.examineremail', ['practicalexaminer' => $practicalexaminer], function($message) use ($exam, $to_name, $to_email, $pdf, $files) {
                $message->to($to_email, $to_name)
                    ->subject('Appointment of External Practical Examiner - '.$exam.' Examinations')
                    ->attachData($pdf->output(), "Appointment Letter.pdf");;
                $message->from('niepmd.examinations@gmail.com','NIEPMD-NBER, Chennai');
                foreach ($files as $file){
                    $message->attach($file);
                }
            });
            */
            $practicalexaminer = Practicalexaminer::where("id", $request->practicalexaminer_id)->first();
            $practicalexam = Practicalexam::where('id', $practicalexaminer->practicalexam_id)->first();
            $practicalexamfeedetails = Practicalexamfeedetail::where('practicalexam_id', $practicalexam->id)->get();


            $pdf = PDF::loadView('nber.practicalexams.examiners.examinerattachment', compact('practicalexaminer', 'practicalexam', 'practicalexamfeedetails'))->setPaper('a4', 'portrait');
            $to_name = $practicalexaminer->name;
            $to_email = trim($practicalexaminer->email);
            $exam = $practicalexam->exam->name;

            $files = [
                public_path('files/externalpracticalexaminers/Jul2022-ClaimForm.pdf'),
                public_path('files/externalpracticalexaminers/Jul2022-MarkEntryForm.pdf'),
                public_path('files/externalpracticalexaminers/Jul2022-PracticalExamSOP.pdf'),
                public_path('files/externalpracticalexaminers/Jul2022-PracticalExamSOP(HI).pdf'),
            ];

            Mail::send('nber.practicalexams.examiners.examineremail', ['practicalexaminer' => $practicalexaminer], function($message) use ($exam, $practicalexam, $to_name, $to_email, $pdf, $files) {
                $message->to($to_email, $to_name)
                    ->subject('Appointment of External Practical Examiner - '.$exam.' Examinations for '.$practicalexam->institute->code)
                    ->attachData($pdf->output(), "Appointment Letter.pdf");;
                $message->from('nber.notifications@gmail.com','NIEPMD-NBER, Chennai');
                foreach ($files as $file){
                    $message->attach($file);
                }
            });

            $data = 1;
        }
        catch (\Exception $ex){
            //$data = 2;
            $data = $ex->getMessage();
        }

        return response()->json($data);
    }

    public function sendemailtoinstitute(Request $request) {
        $data = "";
        try {
            $practicalexaminer = Practicalexaminer::where("id", $request->practicalexaminer_id)->first();
            $practicalexam = Practicalexam::where('id', $practicalexaminer->practicalexam_id)->first();
            $practicalexamfeedetails = Practicalexamfeedetail::where('practicalexam_id', $practicalexam->id)->get();

            $pdf = PDF::loadView('nber.practicalexams.examiners.instituteattachment', compact('practicalexaminer', 'practicalexam', 'practicalexamfeedetails'))->setPaper('a4', 'portrait');
            $to_name = $practicalexam->institute->code.' - '.$practicalexam->institute->name;
            $to_email = $practicalexam->institute->email;
            $exam = $practicalexam->exam->name;

            Mail::send('nber.practicalexams.examiners.instituteemail', ['practicalexaminer' => $practicalexaminer], function($message) use ($exam, $practicalexam, $to_name, $to_email, $pdf) {
                $message->to($to_email, $to_name)
                    ->subject('Appointment of External Practical Examiner - '.$exam.' Examinations for '.$practicalexam->institute->code)
                    ->attachData($pdf->output(), "Appointment Letter.pdf");
                $message->from('nber.notifications@gmail.com','NIEPMD-NBER, Chennai');
            });

            $data = 1;
            $practicalexam->update(["to_instituteemail" => 1]);
        }catch (\Exception $ex){
            $data = 2;
        }

        return response()->json($data);
    }
}
