<?php

namespace App\Http\Controllers\Nber;

use App\Academicyear;
use App\Application;
use App\Approvedprogramme;
use App\Candidate;
use App\Exam;
use App\Exambatch;
use App\Examresultdate;
use App\Institute;
use App\Mark;
use App\User;
use App\Programme;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use File;
use Input;
use Response;
use PDF;

class DownloadController extends Controller
{
    //
    public function index() {
        $exambatches = Exambatch::select("exambatches.*")
            ->join('exams', 'exams.id', '=', 'exambatches.exam_id')
            ->join('programmes', 'programmes.id', '=', 'exambatches.programme_id')
            ->join('academicyears', 'academicyears.id', '=', 'exambatches.academicyear_id')
            ->orderBy('exams.sortorder')->orderBy('programmes.sortorder')->orderBy('academicyears.year')
            ->groupBy('exambatches.exam_id')->groupBy('exambatches.programme_id')->groupBy('exambatches.academicyear_id')
            ->get();

        $exam_ids = $exambatches->pluck('exam_id')->unique()->toArray();

        $exams = Exam::whereIn('id', $exam_ids)->orderBy('date', 'desc')->get();

        //return view('nber.downloads.index', compact('exams', 'examresultdate'));
        return view('nber.downloads.index', compact('exams', 'exambatches'));
    }

    public function exportmarks($e_id, $ap_id) {
        $exam = Exam::find($e_id);
        $approvedprogramme = Approvedprogramme::find($ap_id);

        $applications = Application::where('exam_id', $e_id)->where('approvedprogramme_id', $ap_id)->get();
        $application_ids = $applications->pluck('id')->toArray();

        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $candidates = Candidate::whereIn('id', $candidate_ids)->orderBy('enrolmentno')->whereNotNull('enrolmentno')->get();

        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();
        $subjects = Subject::whereIn('id', $subject_ids)->orderBy('syear', 'desc')->orderBy('subjecttype_id')
            ->orderBy('sortorder')->get();

        $marks = Mark::whereIn('application_id', $application_ids)->get();


        $filename = $approvedprogramme->institute->user->username.' - '.$approvedprogramme->academicyear->year.' Batch'.' - '.
            $approvedprogramme->programme->course_name.' - '.$exam->name;
        $sheetname = $approvedprogramme->academicyear->year;

        Excel::create($filename, function ($excel) use($exam, $applications, $subjects, $candidates, $marks, $approvedprogramme, $sheetname){
            $excel->sheet($sheetname, function ($sheet) use($exam, $applications, $subjects, $candidates, $marks, $approvedprogramme){
                $sheet->loadview('nber.downloads.marks', compact('marks', 'applications', 'candidates', 'subjects',
                    'approvedprogramme'));
            });
        })->export('xlsx');


        //return view('nber.downloads.marks', compact('marks', 'applications', 'candidates', 'subjects', 'approvedprogramme'));
    }

    public function downloads($e_id, $p_id, $ay_id)
    {
        $exam = Exam::find($e_id);

        $programme = Programme::find($p_id);

        $academicyear = Academicyear::find($ay_id);

        $approvedprogramme_ids = Approvedprogramme::where('programme_id', $programme->id)->where('academicyear_id', $academicyear->id)
            ->pluck('id')->toArray();

        $applications = Application::where('exam_id', $exam->id)->whereIn('approvedprogramme_id', $approvedprogramme_ids)->get();
        $application_ids = $applications->pluck('id')->toArray();

        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();
        $subjects = Subject::whereIn('id', $subject_ids)->orderBy('syear')->orderBy('subjecttype_id')
            ->orderBy('sortorder')->get();

        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $candidates = Candidate::whereIn('id', $candidate_ids)->orderBy('enrolmentno')->whereNotNull('enrolmentno')->get();

        $ap_ids = $applications->unique('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();
        $institute_ids = Approvedprogramme::whereIn('id', $ap_ids)->pluck('institute_id')->toArray();


        $institutes = Institute::with('user')
            ->get()
            ->sortBy('user.username');


        $app = Application::where('exam_id', $exam->id)->whereIn('approvedprogramme_id', $approvedprogramme_ids)->cursor();


        $marks = Mark::whereIn('application_id', $application_ids)->get();


        $filename = $exam->name.' - '.$programme->course_name.' - '.$academicyear->year;
        Excel::create($filename, function ($excel) use($exam, $institutes, $applications, $subjects, $candidates, $marks){
            $excel->sheet('clients', function ($sheet) use($exam, $institutes, $applications, $subjects, $candidates, $marks){
                $sheet->loadview('nber.downloads.marks', compact('exam', 'institutes', 'applications', 'subjects', 'candidates', 'marks'));
            });
        })->export('xlsx');


        return view('nber.downloads.marks', compact('exam', 'institutes', 'candidates', 'subjects', 'applications'));

        /*
        $collections = Mark::select('users.username as uname', 'institutes.name as iname',
            'programmes.abbreviation as course',  'candidates.enrolmentno as ceno', 'candidates.name as cname',
            'candidates.fathername as cfname', 'academicyears.year as batch', 'candidates.dob as cdob',
            'subjecttypes.type as stype', 'subjects.sortorder as sorder', 'subjects.scode as scode',
            'subjects.sname as sname', 'subjects.imin_marks as imin', 'subjects.imax_marks as imax',
            'marks.internal as int', 'subjects.emin_marks as emin', 'subjects.emax_marks as emax',
            'marks.external as ext', 'marks.grace as grace', 'marks.result_id as result')
            ->join('applications', 'applications.id', '=', 'marks.application_id')
            ->join('approvedprogrammes', 'approvedprogrammes.id', '=', 'applications.approvedprogramme_id')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->join("exams", "exams.id", "=", "applications.exam_id")
            ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
            ->join('users', 'users.id', '=', 'institutes.user_id')
            ->join("candidates", function ($join){
                $join->on("candidates.approvedprogramme_id", "=", "approvedprogrammes.id");
                $join->on("candidates.id", "=", "applications.candidate_id");
            })
            ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
            ->join('subjecttypes', 'subjecttypes.id', '=', 'subjects.subjecttype_id')
            ->where('applications.exam_id', $e_id)
            ->where('programmes.id', $p_id)
            ->where('academicyears.id', $ay_id)
            ->whereNotNull('candidates.enrolmentno')
            ->orderBy('users.username')
            ->orderBy('candidates.enrolmentno')
            ->orderBy('subjects.syear')->orderBy('subjects.subjecttype_id')->orderBy('subjects.sortorder')
            ->get();

        return view('nber.downloads.marks', compact('exam', 'collections'));
        */
    }

    //function - to list the Institutes ordered by Institute Code
    public function showInstitutes($e_id, $p_id, $ay_id) {
        //finding exam
        $exam = Exam::find($e_id);

        $programme = Programme::find($p_id);
        $academicyear = Academicyear::find($ay_id);

        $ap_ids = Approvedprogramme::where('programme_id', $p_id)->where('academicyear_id', $ay_id)->pluck('id')->toArray();

        $approvedprogramme_ids = Application::where('exam_id', $exam->id)->whereIn('approvedprogramme_id', $ap_ids)
            ->groupBy('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();

        $approvedprogrammes = Approvedprogramme::whereIn('id', $approvedprogramme_ids)->get();

        //sorting Institutes based on user's username
        $institutes = Institute::with('user')->get()->sortBy('user.username');

        return view('nber.downloads.institutes', compact('exam', 'institutes', 'approvedprogrammes', 'programme', 'academicyear'));
    }

    //function - to download the candidate's photo
    public function showCandidates($e_id, $ap_id) {
        $exam = Exam::find($e_id);

        $approvedprogramme = Approvedprogramme::find($ap_id);

        $candidate_ids = Application::where('exam_id', $e_id)->where('approvedprogramme_id', $approvedprogramme->id)
            ->groupBy('candidate_id')->pluck('candidate_id')->toArray();

        $candidates = Candidate::whereIn('id', $candidate_ids)->orderBy('enrolmentno')
            ->whereNotNull('enrolmentno')->get();

        return view('nber.downloads.photos.index', compact('exam', 'approvedprogramme', 'candidates'));
    }

    public function downloadphotos($c_id) {
        $candidate = Candidate::find($c_id);

        $file = public_path()."/files/enrolment/photos/".$candidate->photo;

        $header = array(
            'Content-Type : application/jpg',
        );

        $info = pathinfo($file);

        $filename = 'photo_'.$candidate->enrolmentno.'.'.$info['extension'];
        $destinationpath = public_path()."/files/enrolment/photos/".$filename;

        $candidate->update(['photo'=>$filename]);
        rename($file, $destinationpath);

        return Response::download($destinationpath, $filename, $header);
    }

    public function downloadFullMarks($examid, $pid, $ayid) {
        $exam = Exam::find($examid);
        $programme = Programme::find($pid);
        $academicyear = Academicyear::find($ayid);


    }

    public function downloadmarks($exam_id) {
        $exam = Exam::find($exam_id);

        $applications = Application::select('applications.*')
            ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
            ->join('subjecttypes', 'subjecttypes.id', '=', 'subjects.subjecttype_id')
            ->join('candidates', 'candidates.id', '=', 'applications.candidate_id')
            ->join('approvedprogrammes', 'approvedprogrammes.id', '=', 'candidates.approvedprogramme_id')
            ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->where('applications.exam_id', $exam->id)
            ->orderBy('institutes.code')
            ->orderBy('academicyears.year')
            ->orderBy('programmes.sortorder')
            ->orderBy('candidates.enrolmentno')
            ->orderBy('subjects.syear')
            ->orderBy('subjecttypes.id')
            ->orderBy('subjects.sortorder')
            ->get();

        $marks = Mark::whereIn('application_id', $applications->pluck('id')->toArray())->get();

        $filename = $exam->name.' - Full Marks';
        $sheetname = 'Export Data';

        Excel::create($filename, function ($excel) use($exam, $applications, $marks, $sheetname){
            $excel->sheet($sheetname, function ($sheet) use($exam, $applications, $marks, $sheetname){
                $sheet->loadview('nber.downloads.fullmarks', compact('marks', 'applications', 'exam'));
            });
        })->export('xlsx');

    }

    public function downloadCourseMarks($e_id, $p_id, $ay_id) {
        $exam = Exam::find($e_id);
        $programme = Programme::find($p_id);
        $academicyear = Academicyear::find($ay_id);

        $applications = Application::select('applications.*')
            ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
            ->join('subjecttypes', 'subjecttypes.id', '=', 'subjects.subjecttype_id')
            ->join('candidates', 'candidates.id', '=', 'applications.candidate_id')
            ->join('approvedprogrammes', 'approvedprogrammes.id', '=', 'candidates.approvedprogramme_id')
            ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->where('applications.exam_id', $exam->id)
            ->where('programmes.id', $p_id)
            ->where('academicyears.id', $ay_id)
            ->orderBy('institutes.code')
            ->orderBy('academicyears.year')
            ->orderBy('programmes.sortorder')
            ->orderBy('candidates.enrolmentno')
            ->orderBy('subjects.syear')
            ->orderBy('subjecttypes.id')
            ->orderBy('subjects.sortorder')
            ->get();

        $marks = Mark::whereIn('application_id', $applications->pluck('id')->toArray())->get();

        $filename = $exam->name.' - '.$programme->course_name.' - '.$academicyear->year;
        $sheetname = 'Export Data';

        Excel::create($filename, function ($excel) use($exam, $applications, $marks, $sheetname){
            $excel->sheet($sheetname, function ($sheet) use($exam, $applications, $marks, $sheetname){
                $sheet->loadview('nber.downloads.coursemarks', compact('marks', 'applications', 'exam'));
            });
        })->export('xlsx');
    }

    public function downloadCourseBatchMarks($e_id, $ap_id) {
        $exam = Exam::find($e_id);

        $approvedprogramme = Approvedprogramme::find($ap_id);

        $applications = Application::select('applications.*')
            ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
            ->join('subjecttypes', 'subjecttypes.id', '=', 'subjects.subjecttype_id')
            ->join('candidates', 'candidates.id', '=', 'applications.candidate_id')
            ->join('approvedprogrammes', 'approvedprogrammes.id', '=', 'candidates.approvedprogramme_id')
            ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->where('applications.exam_id', $exam->id)
            ->where('approvedprogrammes.id', $ap_id)
            ->orderBy('institutes.code')
            ->orderBy('academicyears.year')
            ->orderBy('programmes.sortorder')
            ->orderBy('candidates.enrolmentno')
            ->orderBy('subjects.syear')
            ->orderBy('subjecttypes.id')
            ->orderBy('subjects.sortorder')
            ->get();

        $marks = Mark::whereIn('application_id', $applications->pluck('id')->toArray())->get();

        $filename = $exam->name.' - '.$approvedprogramme->programme->course_name.' - '.$approvedprogramme->academicyear->year;
        $sheetname = 'Export Data';

        Excel::create($filename, function ($excel) use($exam, $applications, $marks, $sheetname){
            $excel->sheet($sheetname, function ($sheet) use($exam, $applications, $marks, $sheetname){
                $sheet->loadview('nber.downloads.marks', compact('marks', 'applications', 'exam'));
            });
        })->export('xlsx');
    }
}
