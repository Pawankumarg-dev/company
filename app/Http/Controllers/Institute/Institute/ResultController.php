<?php

namespace App\Http\Controllers\Institute;

use App\Approvedprogramme;
use App\Candidate;
use App\Exam;
use App\Examresultdate;
use App\Programme;
use App\Subject;
use App\Institute;
use App\Application;
use App\Mark;
use App\Withheld;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function index($exam_id, $ap_id){
        $exam = Exam::find($exam_id);

        $approvedprogramme = Approvedprogramme::find($ap_id);

        $candidate_ids = Application::where('exam_id', $exam->id)->where('approvedprogramme_id', $approvedprogramme->id)
            ->groupBy('candidate_id')->pluck('candidate_id')->toArray();

        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')->orderBy('enrolmentno')->get();

        if($candidates->count() == 0) {
            return view('institute.result.empty', compact('exam', 'approvedprogramme'));
        }
        else {
            return view('institute.result.index', compact('exam', 'approvedprogramme', 'candidates'));
        }
    }

    public function showlist($e_id) {
        $exam = Exam::find($e_id);

        $institute = Institute::where('user_id',Auth::user()->id)->first();

        $collections = Application::whereHas('approvedprogramme', function ($query) use($institute){
            $query->where('institute_id', $institute->id);
        })->where('exam_id', $exam->id)->groupBy('approvedprogramme_id')->get(['approvedprogramme_id']);

        return view('institute.examinations.examresults', compact('exam', 'institute', 'collections'));
    }

    public function showstudentslist($e_id, $ay_id) {
        $exam = Exam::find($e_id);

        $approvedprogramme = Approvedprogramme::find($ay_id);

        if(!is_null($approvedprogramme)) {
            if($approvedprogramme->institute_id == Institute::where('user_id',Auth::user()->id)->first()->id) {
                $candidate_ids = Application::where('exam_id', $exam->id)->where('approvedprogramme_id', $approvedprogramme->id)
                    ->groupBy('candidate_id')->pluck('candidate_id')->toArray();

                $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')->orderBy('enrolmentno')->get();
                unset($candidate_ids);

                return view('institute.result.showstudentlist', compact('exam', 'approvedprogramme', 'candidates'));
            }
            else {
                unset($exam);
                unset($approvedprogramme);
                return redirect('/');
            }
        }
        else {
            unset($exam);
            unset($approvedprogramme);
            return redirect('/');
        }
    }
}
