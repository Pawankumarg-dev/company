<?php

namespace App\Http\Controllers\Institute;

use App\Application;
use App\Approvedprogramme;
use App\Candidate;
use App\Exam;
use App\Institute;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AttendancePercentageController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function index() {

    }

    public function home($eid) {
        $exam = Exam::find($eid);
        $institute_id = Institute::where('user_id', Auth::user()->id)->first()->id;

        if(!is_null($exam)) {
            $applications = Application::where('exam_id', $exam->id)
                ->whereHas('approvedprogramme', function ($query) use ($institute_id) {
                $query->where('institute_id', $institute_id);
            })->exists('id');

           if(empty($applications))
               return redirect('/institute/examinations/'.$exam->id);
           else {
               unset($applications);
                $collections = Application::join('subjects', 'subjects.id', '=', 'applications.subject_id')
                    ->join('subjecttypes', 'subjecttypes.id', '=', 'subjects.subjecttype_id')
                    ->join('approvedprogrammes', 'approvedprogrammes.id', '=', 'applications.approvedprogramme_id')
                    ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
                    ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
                    ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
                    ->where('institutes.id', $institute_id)
                    ->where('applications.exam_id', $exam->id)
                    ->groupBy('approvedprogrammes.id')
                    ->groupBy('subjects.syear')
                    ->groupBy('subjects.subjecttype_id')
                    ->orderBy('programmes.abbreviation')
                    ->orderBy('academicyears.year')
                    ->orderBy('subjects.subjecttype_id')
                    ->orderBy('subjects.syear')
                    ->get(['approvedprogrammes.id as approvedprogrammeId', 'programmes.abbreviation as courseCode', 'academicyears.year as year', 'subjects.syear as term', 'subjecttypes.type as type']);

               return view('institute.classattendances.home', compact('exam', 'collections'));
           }
        }
        else {
            return redirect('/institute/examinations');
        }
    }

    public function updateTheoryAttendancePercentageForm($eid, $apid, $term) {
        $exam = Exam::find($eid);

        if(!is_null($exam)) {
            $approvedprogramme = Approvedprogramme::find($apid);

            if(!is_null($approvedprogramme)) {
                $candidates = Candidate::where('approvedprogramme_id', $approvedprogramme->id)
                    ->whereNotNull('enrolmentno')->orderBy('enrolmentno')->get(['id', 'enrolmentno', 'name']);
            }
            else {
                return redirect('/institute/consolidatedclassattendance/'.$exam->id);
            }
        }
        else {
            return redirect('/institute/examinations');
        }
    }
}
