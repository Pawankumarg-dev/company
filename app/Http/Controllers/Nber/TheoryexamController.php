<?php

namespace App\Http\Controllers\Nber;

use App\Application;
use App\Approvedprogramme;
use App\Candidate;
use App\Coursecoordinator;
use App\Exam;
use App\Externalexamcenter;
use App\State;
use App\Subject;
use App\Zone;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TheoryexamController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index($eid) {
        $exam = Exam::find($eid);
        unset($eid);

        return view('nber.theoryexams.index', compact('exam'));
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
            ->where('subjects.subjecttype_id', '1')
            ->groupBy('applications.approvedprogramme_id')
            ->orderBy('institutes.code')->orderBy('programmes.sortorder')->orderBy('academicyears.year')
            ->get();

        return view('nber.theoryexams.showlists', compact('exam', 'approvedprogrammes'));
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
            ->where('subjects.subjecttype_id', '1')
            ->groupBy('applications.approvedprogramme_id')
            ->orderBy('institutes.code')->orderBy('programmes.sortorder')->orderBy('academicyears.year')
            ->get();

        $filename = $exam->name.' Examinations - Consolidated Theory Exam Applications Count Details dtd '.date('d-m-Y');
        $sheetname = $exam->name;

        Excel::create($filename, function ($excel) use($sheetname, $exam, $approvedprogrammes){
            $excel->sheet($sheetname, function ($sheet) use($exam, $approvedprogrammes){
                $sheet->loadview('nber.theoryexams.showlistsexcel', compact('exam', 'approvedprogrammes'));
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
            ->where('subjects.subjecttype_id', '1')
            ->groupBy('subjects.scode')
            ->orderBy('subjects.syear')->orderBy('subjects.sortorder')
            ->get();

        return view('nber.theoryexams.showsubjects', compact('exam', 'approvedprogramme', 'subjects'));
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

        return view('nber.theoryexams.downloadattendancesheet', compact('exam', 'approvedprogramme', 'subject', 'applications'));
    }

    public function theorycandidatecount() {

    }

    public function showExamCenters($eid) {
        $exam = Exam::find($eid);
        unset($eid);

        $states = Externalexamcenter::groupBy('state')->orderBy('state')->get(['state']);

        $externalexamcenters = Externalexamcenter::orderBy('state')->orderBy('active_status')->orderBy('code')->get();

        return view('nber.theoryexams.examcenters.index', compact('exam', 'externalexamcenters', 'states'));
    }

    public function addExamCenter($eid) {
        $exam = Exam::find($eid);
        unset($eid);
        $states = State::orderBy("state_name")->get();
        $zones = Zone::all();
        return view('nber.theoryexams.examcenters.add_exam_center_details', compact('exam', 'states', 'zones'));
    }

    public function addExamCenterDetails(Request $request){
        Externalexamcenter::create([
            "code" => $request->code,
            "password" => $request->password,
            "name" => $request->name,
            "address" => $request->address,
            "district" => $request->district,
            "state" => $request->state,
            "pincode" => $request->pincode,
            "zone_id" => $request->zone_id,
            "contactnumber1" => $request->contactnumber1,
            "contactnumber2" => $request->contactnumber2,
            "email1" => $request->email1,
            "email2" => $request->email2,
            "active_status" => 1,
        ]);

        return redirect('/nber/theoryexams/examcenters/'.$request->exam_id);
    }

    public function editExamCenter($eid, $excid) {
        $exam = Exam::find($eid);

        if(!is_null($exam)) {
            $examcenter = Externalexamcenter::find($excid);

            if(!is_null($examcenter)) {
                $states = State::orderBy("state_name")->get();
                $zones = Zone::all();
                return view('nber.theoryexams.examcenters.edit_exam_center_details', compact('exam', 'examcenter', 'states', 'zones'));
            }
            else {
                unset($eid);
                unset($exam);
                unset($excid);
                unset($examcenter);
            }
        }
        else {
            unset($eid);
            unset($exam);

            return redirect('/nber/exams');
        }
    }

    public function editExamCenterDetails(Request $request){
        $examcenter = Externalexamcenter::find($request->examcenter_id);

        if(!is_null($examcenter)) {
            $examcenter->update([
                "code" => $request->code,
                "password" => $request->password,
                "name" => $request->name,
                "address" => $request->address,
                "district" => $request->district,
                "state" => $request->state,
                "pincode" => $request->pincode,
                "zone_id" => $request->zone_id,
                "contactnumber1" => $request->contactnumber1,
                "contactnumber2" => $request->contactnumber2,
                "email1" => $request->email1,
                "email2" => $request->email2,
                "active_status" => $request->active_status,
            ]);
        }

        return redirect('/nber/theoryexams/examcenters/'.$request->exam_id);
    }

    public function checkexamcentercode(Request $request) {
        $datafound = Externalexamcenter::where('code', $request->code)->exists();

        return response()->json($datafound);
    }
}
