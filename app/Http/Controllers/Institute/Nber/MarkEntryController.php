<?php

namespace App\Http\Controllers\Nber;

use App\Application;
use App\Approvedprogramme;
use App\Exam;
use App\Institute;
use App\Mark;
use App\Programme;
use App\Subject;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MarkEntryController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index() {
        $exams = Exam::orderBy('date', 'desc')->get();

        return view('nber.exammarks.index', compact('exams'));
    }

    public function show_exams_list() {
        $exams = Exam::orderBy('date', 'desc')->get();

        return view('nber.exammarksentry.show_exams_list', compact('exams'));
    }

    public function show_applied_list($e_id) {
        $exam = Exam::where('id', $e_id)->first();

        $ap_ids = Application::where('exam_id', $exam->id)->groupBy('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();

        $approvedprogrammes = Approvedprogramme::select('approvedprogrammes.id', 'approvedprogrammes.institute_id', 'approvedprogrammes.programme_id', 'approvedprogrammes.academicyear_id')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->whereIn('approvedprogrammes.id', $ap_ids)->orderBy('institutes.code')->orderBy('programmes.sortorder')
            ->orderBy('academicyears.year', 'desc')
            ->get();

        $institute_ids = $approvedprogrammes->pluck('institute_id')->toArray();

        $institutes = Institute::select('id', 'code')->whereIn('id', $institute_ids)->orderBy('code')->get();

        return view('nber.exammarksentry.show_applied_list', compact('exam', 'approvedprogrammes', 'institutes'));
    }

    public function show_subjects($e_id, $ap_id) {
        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $subject_ids = Application::where('exam_id', $exam->id)->where('approvedprogramme_id', $approvedprogramme->id)
            ->groupBy('subject_id')->pluck('subject_id')->toArray();

        $subjects = Subject::select('id', 'scode', 'sname', 'syear', 'subjecttype_id')->whereIn('id', $subject_ids)->orderBy('syear')->orderBy('subjecttype_id')->orderBy('sortorder')->get();

        return view('nber.exammarksentry.show_subjects', compact('exam', 'approvedprogramme', 'subjects'));
    }

    public function show_form($e_id, $ap_id, $s_id) {
        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $subject = Subject::where('id', $s_id)->first();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join("candidates", "candidates.id", "=", "applications.candidate_id")
            ->where('applications.exam_id', $exam->id)
            ->where('applications.approvedprogramme_id', $approvedprogramme->id)
            ->where('applications.subject_id', $subject->id)
            ->orderBy('candidates.enrolmentno')->get();

        $application_ids = $applications->pluck('id')->toArray();

        $marks = Mark::whereIn('application_id', $application_ids)->get();

        return view('nber.exammarksentry.update_marks', compact('exam', 'approvedprogramme', 'subject', 'applications', 'marks'));
    }

    public function update_marks(Request $request) {
        $sno = 0;
        foreach ($request->application_id as $appid) {
            $application = Application::where('id', $appid)->first();
            $mark = Mark::where('application_id', $application->id)->first();

            if(!is_null($mark)) {
                $mark->update([
                    "internal" => $request->int_mark[$sno],
                    "external" => $request->ext_mark[$sno],
                    "grace" => $request->grace_mark[$sno],
                    "candidate_id" => $application->candidate_id,
                ]);
            }
            else {
                Mark::create([
                    "application_id" => $application->id,
                    "exam_id" => $request->exam_id,
                    "candidate_id" => $application->candidate_id,
                    "subject_id" => $application->subject->id,
                    "internal" => $request->int_mark[$sno],
                    "external" => $request->ext_mark[$sno],
                    "grace" => 0
                ]);
            }
            $sno++;
        }

        return redirect('/nber/exams/marks-entry/'.$request->exam_id.'/show-marks/'.$request->approvedprogramme_id.'/subject/'.$request->subject_id);

    }

    public function show_marks($e_id, $ap_id, $s_id) {
        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $subject = Subject::where('id', $s_id)->first();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join("candidates", "candidates.id", "=", "applications.candidate_id")
            ->where('applications.exam_id', $exam->id)
            ->where('applications.approvedprogramme_id', $approvedprogramme->id)
            ->where('applications.subject_id', $subject->id)
            ->orderBy('candidates.enrolmentno')->get();

        $application_ids = $applications->pluck('id')->toArray();

        $marks = Mark::whereIn('application_id', $application_ids)->get();

        return view('nber.exammarksentry.show_marks', compact('exam', 'approvedprogramme', 'subject', 'applications', 'marks'));
    }
}
