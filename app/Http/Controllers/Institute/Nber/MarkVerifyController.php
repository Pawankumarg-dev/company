<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;
use App\Application;
use App\Approvedprogramme;
use App\Exam;
use App\Institute;
use App\Mark;
use App\Programme;
use App\Subject;
use App\Candidate;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MarkVerifyController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
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

        return view('nber.exammarksverify.show_applied_list', compact('exam', 'approvedprogrammes'));
    }

    public function show_marks($e_id, $ap_id) {
        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Application::where('exam_id', $exam->id)->where('approvedprogramme_id', $approvedprogramme->id)
            ->get();

        $application_ids = $applications->pluck('id')->toArray();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();
        $subjects = Subject::whereIn('id', $subject_ids)->orderBy('syear')->orderBy('subjecttype_id')
            ->orderBy('sortorder')->get();

        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $candidates = Candidate::whereIn('id', $candidate_ids)->orderBy('enrolmentno')->whereNotNull('enrolmentno')->get();

        return view('nber.marksverify.verifymarks', compact('exam', 'approvedprogramme', 'applications', 'subjects', 'candidates', 'marks'));

    }

    public function view_internal_theory_marks($e_id, $ap_id) {
        $title = "Internal Theory";

        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join("candidates", "candidates.id", "=", "applications.candidate_id")
            ->where('applications.exam_id', $exam->id)->where('applications.approvedprogramme_id', $approvedprogramme->id)
            ->where('subjects.subjecttype_id', '=', '1')
            ->whereNotNull('candidates.enrolmentno')
            ->orderBy('candidates.enrolmentno')
            ->orderBy('subjects.subjecttype_id')
            ->orderBy('subjects.syear', 'desc')
            ->orderBy('subjects.sortorder')->get();

        $application_ids = $applications->pluck('id')->toArray();
        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();

        $subjects = Subject::whereIn('id', $subject_ids)->orderBy('syear')->orderBy('sortorder')->get();
        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        return view('nber.exammarksverify.viewinternaltheorymarks', compact('exam', 'approvedprogramme', 'applications', 'marks', 'subjects', 'candidates', 'title'));

    }

    public function view_external_theory_marks($e_id, $ap_id) {
        /*
        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $subjects = Subject::where('programme_id', $approvedprogramme->programme->id)->where('subjecttype_id', '1')
            ->orderBy('syear')->orderBy('sortorder')->get();
        $subject_ids = $subjects->pluck('id')->toArray();

        $applications = Application::where('approvedprogramme_id', $approvedprogramme->id)->whereIn('subject_id', $subject_ids)->get();

        $application_ids = $applications->pluck('id')->toArray();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $candidates = Candidate::whereIn('id', $candidate_ids)->orderBy('enrolmentno')->whereNotNull('enrolmentno')->get();

        return view('nber.exammarksverify.theory_marks', compact('exam', 'approvedprogramme', 'applications', 'subjects', 'candidates', 'marks'));
        */

        $title = "External Theory";

        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join("candidates", "candidates.id", "=", "applications.candidate_id")
            ->where('applications.exam_id', $exam->id)->where('applications.approvedprogramme_id', $approvedprogramme->id)
            ->where('subjects.subjecttype_id', '=', '1')
            ->whereNotNull('candidates.enrolmentno')
            ->orderBy('candidates.enrolmentno')
            ->orderBy('subjects.subjecttype_id')
            ->orderBy('subjects.syear', 'desc')
            ->orderBy('subjects.sortorder')->get();

        $application_ids = $applications->pluck('id')->toArray();
        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();

        $subjects = Subject::whereIn('id', $subject_ids)->orderBy('syear')->orderBy('sortorder')->get();
        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        return view('nber.exammarksverify.viewexternaltheorymarks', compact('exam', 'approvedprogramme', 'applications', 'marks', 'subjects', 'candidates', 'title'));

    }

    public function view_internal_practical_marks($e_id, $ap_id) {
        $title = "Internal Practical";

        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join("candidates", "candidates.id", "=", "applications.candidate_id")
            ->where('applications.exam_id', $exam->id)->where('applications.approvedprogramme_id', $approvedprogramme->id)
            ->where('subjects.subjecttype_id', '=', '2')
            ->whereNotNull('candidates.enrolmentno')
            ->orderBy('candidates.enrolmentno')
            ->orderBy('subjects.subjecttype_id')
            ->orderBy('subjects.syear', 'desc')
            ->orderBy('subjects.sortorder')->get();

        $application_ids = $applications->pluck('id')->toArray();
        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();

        $subjects = Subject::whereIn('id', $subject_ids)->orderBy('syear')->orderBy('sortorder')->get();
        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        return view('nber.exammarksverify.viewinternalpracticalmarks', compact('exam', 'approvedprogramme', 'applications', 'marks', 'subjects', 'candidates', 'title'));
    }

    public function view_external_practical_marks($e_id, $ap_id) {
        $title = "External Practical";

        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join("candidates", "candidates.id", "=", "applications.candidate_id")
            ->where('applications.exam_id', $exam->id)->where('applications.approvedprogramme_id', $approvedprogramme->id)
            ->where('subjects.subjecttype_id', '=', '2')
            ->whereNotNull('candidates.enrolmentno')
            ->orderBy('candidates.enrolmentno')
            ->orderBy('subjects.subjecttype_id')
            ->orderBy('subjects.syear', 'desc')
            ->orderBy('subjects.sortorder')->get();

        $application_ids = $applications->pluck('id')->toArray();
        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();

        $subjects = Subject::whereIn('id', $subject_ids)->orderBy('syear')->orderBy('sortorder')->get();
        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        return view('nber.exammarksverify.viewexternalpracticalmarks', compact('exam', 'approvedprogramme', 'applications', 'marks', 'subjects', 'candidates', 'title'));
    }

}
