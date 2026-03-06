<?php

namespace App\Http\Controllers\Institute;

use App\Application;
use App\Approvedprogramme;
use App\Candidate;
use App\Exam;
use App\Subject;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PracticalexamController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function index($examid, $apid) {
        $exam = Exam::find($examid);
        $approvedprogramme = Approvedprogramme::find($apid);

        $applied_count = Application::select('subjects.*')
            ->where('approvedprogramme_id', $approvedprogramme->id)
            ->where('exam_id', $exam->id)
            ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
            ->where('subjects.subjecttype_id', '2')
            ->count();

        return view('institute.practicalexams.index', compact('exam','approvedprogramme', 'applied_count'));
    }

    public function showCandidates($examid, $apid) {
        $exam = Exam::find($examid);
        $approvedprogramme = Approvedprogramme::find($apid);

        $applications = Application::select('applications.*')
            ->where('applications.approvedprogramme_id', $approvedprogramme->id)
            ->where('applications.exam_id', $exam->id)
            ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
            ->join('marks', 'marks.application_id', '=', 'applications.id')
            ->where('subjects.subjecttype_id', '2')
            ->where('marks.internalresult_id', '1')
            ->groupBy('applications.candidate_id')
            ->get();

        $candidate_ids = $applications->pluck('candidate_id')->toArray();

        $candidates = Candidate::whereIn('id', $candidate_ids)->orderBy('enrolmentno')->get();

        return view('institute.practicalexams.showcandidates', compact('exam', 'approvedprogramme', 'candidates'));
    }

    public function downloadHallticket($examid, $cid) {
        $exam = Exam::find($examid);
        $candidate = Candidate::find($cid);

        $applications = Application::select('applications.*')
            ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
            ->join('marks', 'marks.application_id', '=', 'applications.id')
            ->where('applications.candidate_id', $candidate->id)
            ->where('applications.exam_id', $exam->id)
            ->where('subjects.subjecttype_id', '2')
            ->where('marks.internalresult_id', '1')
            ->orderBy('subjects.syear')->orderBy('subjects.sortorder')
            ->get();

        if($exam->id == '14') {
            return view('institute.practicalexams.febmar2021_downloadhallticket', compact('exam', 'candidate', 'applications'));
        }

        return view('institute.practicalexams.downloadhallticket', compact('exam', 'candidate', 'applications'));
    }

    public function showSubjects($examid, $apid) {
        $exam = Exam::find($examid);
        $approvedprogramme = Approvedprogramme::find($apid);

        $subjects = Application::select('subjects.*')
            ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
            ->where('applications.approvedprogramme_id', $approvedprogramme->id)
            ->where('applications.exam_id', $exam->id)
            ->where('subjects.subjecttype_id', '2')
            ->groupBy('subjects.scode')
            ->orderBy('subjects.syear')->orderBy('subjects.sortorder')
            ->get();

       return view('institute.practicalexams.showsubjects', compact('exam', 'approvedprogramme', 'subjects'));
    }

    public function downloadAttendanceSheet($examid, $apid, $sid) {
        $exam = Exam::find($examid);
        $approvedprogramme = Approvedprogramme::find($apid);
        $subject = Subject::find($sid);

        $applications = Application::select('applications.*')
            ->join('candidates', 'candidates.id', '=', 'applications.candidate_id')
            ->join('marks', 'marks.application_id', '=', 'applications.id')
            ->where('applications.approvedprogramme_id', $approvedprogramme->id)
            ->where('applications.exam_id', $exam->id)
            ->where('applications.subject_id', $subject->id)
            ->where('marks.internalresult_id', '1')
            ->orderBy('candidates.enrolmentno')
            ->get();

        return view('institute.practicalexams.downloadattendancesheet', compact('exam', 'approvedprogramme', 'subject', 'applications'));
    }
}
