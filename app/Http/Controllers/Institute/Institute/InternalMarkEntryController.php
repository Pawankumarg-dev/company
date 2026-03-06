<?php

namespace App\Http\Controllers\Institute;

use App\Application;
use App\Currentapplication;
use App\Approvedprogramme;
use App\Candidate;
use App\Exam;
use App\Examtimetable;
use App\Incidentalpayment;
use App\Internalmark;
use App\Mark;
use App\Subject;
use App\User;
use Illuminate\Support\Facades\Auth;

use File;
use Input;
use Response;
use PDF;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MarkEntryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function index($e_id, $ap_id) {
        return '';
        $exam = Exam::where('id', $e_id)->first();
        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        if(!$exam || !$approvedprogramme || ($approvedprogramme->institute->user_id != Auth::user()->id)) {
            return redirect('/examinations');
        }
        else {
          /*   $candidate_ids = Candidate::where('approvedprogramme_id', $approvedprogramme->id)->pluck('id')->toArray();

            $applications = Currentapplication::where('exam_id', $exam->id)->whereIn('candidate_id', $candidate_ids)->get();
            $applied_candidateids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray(); */

           // $candidates = Candidate::whereIn('id', $applied_candidateids)->orderBy('enrolmentno')->get();
           $candidates = Candidates::where('approvedprogramme_id',$approvedprogramme->id)->whereNotNull('currentapplicant_id')->orderBy('enrolmentno')->get();

            return view('institute.exammarks.index', compact('exam', 'approvedprogramme', 'candidates', 'applications'));
        }
    }

    public function showform($e_id, $c_id) {
        return '';
        $exam = Exam::where('id', $e_id)->first();

        $candidate = Candidate::where('id', $c_id)->first();

        $applications = Currentapplication::select("currentapplications.*")
            ->join("subjects", "subjects.id", "=", "currentapplications.subject_id")
            ->join("candidates", "candidates.id", "=", "currentapplications.candidate_id")
            ->where('exam_id', $exam->id)->where('candidate_id', $candidate->id)
            ->orderBy('subjects.subjecttype_id')
            ->orderBy('subjects.syear')
            ->orderBy('subjects.sortorder')->get();

        $subjects = Subject::where('programme_id', $candidate->approvedprogramme->programme->id)
            ->orderBy('syear')->orderBy('subjecttype_id')->orderBy('sortorder')->get();

        $application_ids = $applications->pluck('id')->toArray();

        $marks = Mark::whereIn('application_id', $application_ids)->get();

        return view('institute.exammarks.form', compact('exam', 'candidate', 'applications', 'marks'));
    }

    public function updateform(Request $request) {
        return '';
        $sno=1; $int_sno=0; $ext_sno=0;
        foreach ($request->application_id as $i){
            $application = Currentapplication::where('id', $i)->first();
            $mark = Mark::where('application_id', $application->id)->first();

            if($request->int_mark[$int_sno] == "Abs" || $request->int_mark[$int_sno] < $application->subject->imin_marks) {
                $internalresult_id = '0';
                $internal_lock = '0';
            }
            else {
                $internalresult_id = '1';
                $internal_lock = '1';
            }

            if($request->ext_mark[$ext_sno] == "Abs" || $request->ext_mark[$ext_sno] < $application->subject->emin_marks) {
                $externalresult_id = '0';
                $external_lock = '0';
            }
            else {
                $externalresult_id = '1';
                $external_lock = '1';
            }

            if($application->subject->subjecttype_id == "2") {
                if($internalresult_id == '0' || $externalresult_id == '0') {
                    $result_id = '0';
                }
                else {
                    $result_id = '1';
                }
            }

            if(!is_null($mark)) {
                if($application->subject->subjecttype_id == "1") {
                    $mark->update([
                        "internal" => $request->int_mark[$int_sno],
                        "internalresult_id" => $internalresult_id,
                        "internal_lock" => $internal_lock,
                    ]);

                }
                else {
                    $mark->update([
                        "internal" => $request->int_mark[$int_sno],
                        "external" => $request->ext_mark[$ext_sno],
                        "internalresult_id" => $internalresult_id,
                        "internal_lock" => $internal_lock,
                        "externalresult_id" => $externalresult_id,
                        "external_lock" => $external_lock,
                        "result_id" => $result_id,
                    ]);
                    $ext_sno++;
                }
            }
            else {
                if($application->subject->subjecttype_id == "1") {
                    Mark::create([
                        "application_id" => $application->id,
                        "exam_id" => $request->exam_id,
                        "candidate_id" => $request->candidate_id,
                        "subject_id" => $application->subject->id,
                        "internal" => $request->int_mark[$int_sno],
                        "internalresult_id" => $internalresult_id,
                        "internal_lock" => $internal_lock,
                    ]);
                }
                else {
                    Mark::create([
                        "application_id" => $application->id,
                        "exam_id" => $request->exam_id,
                        "candidate_id" => $request->candidate_id,
                        "subject_id" => $application->subject->id,
                        "internal" => $request->int_mark[$int_sno],
                        "internalresult_id" => $internalresult_id,
                        "internal_lock" => $internal_lock,
                        "external" => $request->ext_mark[$ext_sno],
                        "externalresult_id" => $externalresult_id,
                        "external_lock" => $external_lock,
                        "result_id" => $result_id,
                    ]);
                    $ext_sno++;
                }
            }

            $int_sno++;
            $sno++;
        }

        $ap_id = Candidate::where('id', $request->candidate_id)->first()->approvedprogramme_id;

        return redirect('institute/exammarksentry/'.$request->exam_id.'/showlist/'.$ap_id)->with('message', 'You have successfully submitted the marks. Thank you');
    }

    public function downloadmarks($e_id, $ap_id) {
        return '';
        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Currentapplication::select("currentapplications.*")
            ->join("subjects", "subjects.id", "=", "currentapplications.subject_id")
            ->join("candidates", "candidates.id", "=", "currentapplications.candidate_id")
            ->where('currentapplications.exam_id', $exam->id)->where('currentapplications.approvedprogramme_id', $approvedprogramme->id)
            ->whereNotNull('candidates.enrolmentno')
            ->orderBy('candidates.enrolmentno')
            ->orderBy('subjects.subjecttype_id')
            ->orderBy('subjects.syear', 'desc')
            ->orderBy('subjects.sortorder')->get();

        $application_ids = $applications->pluck('id')->toArray();
        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();

        $subjects = Subject::whereIn('id', $subject_ids)->orderBy('syear')->orderBy('subjecttype_id')->orderBy('sortorder')->get();
        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        return view('institute.exammarks.downloadmarks', compact('exam', 'approvedprogramme', 'applications', 'candidates', 'subjects', 'marks'));
    }

    public function downloadinternaltheorymarks($e_id, $ap_id) {
        return '';
        $title = "Internal Theory";

        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Currentapplication::select("currentapplications.*")
            ->join("subjects", "subjects.id", "=", "currentapplications.subject_id")
            ->join("candidates", "candidates.id", "=", "currentapplications.candidate_id")
            ->where('currentapplications.exam_id', $exam->id)->where('currentapplications.approvedprogramme_id', $approvedprogramme->id)
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

        $html = '
                    <html>
                        <head>
                            <style>
                                .page-break {
                                    page-break-after: always;
                                }
                                body {
                                    background: #EEEEEE;
                                }
                                .equal-height-row {
                                    display: flex;
                                }
                        
                                .minus15px-margin-top {
                                    margin-top: -15px !important;
                                }
                        
                                .white-background {
                                    background-color: white;
                                    color: black;
                                }
                        
                                .black-background {
                                    background-color: black;
                                    color: white;
                                }
                        
                                .red-background {
                                    background-color: red;
                                    color: white;
                                }
                        
                                .ghostwhite-background {
                                    background-color: ghostwhite;
                                    color: deepskyblue;
                                }
                        
                                .darkblue-background {
                                    background-color: darkblue;
                                    color: white;
                                }
                        
                                .green-background {
                                    background: green !important;
                                    color: white !important;
                                }
                        
                                .grey-background {
                                    background: #EEEEEE;
                                }
                        
                                .bold-text {
                                    font-weight: bold;
                                }
                        
                                .center-text {
                                    text-align: center !important;
                                }
                        
                                .left-text {
                                    text-align: left !important;
                                }
                        
                                .right-text {
                                    text-align: right !important;
                                }
                        
                                .green-text {
                                    color: darkgreen;
                                }
                        
                                .red-text {
                                    color: red;
                                }
                        
                                .blue-text {
                                    color: blue;
                                }
                        
                                .brown-text {
                                    color: brown;
                                }
                        
                                .yellow-text {
                                    color: yellow;
                                }
                        
                                .icon-text {
                                    font-size: 30px;
                                }
                        
                                .footer {
                                    background: #3fc3ee;
                                    color: white;
                                }
                        
                                . {
                                    display: flex; /* equal height of the children */
                                }
                                
                            </style>
                        </head>
                        <body>  
                    ';

        $html .= '<div class="page-break">';

        for($i = '2'; $i > '0'; $i--) {
            $applicationcount = '0';
            foreach($applications as $app) {
                if($app->subject->syear == $i) {
                    $applicationcount++;
                }
            }

            if($applicationcount > '0') {
                $subjectcount = '0';
                foreach($subjects as $s) {
                    if($s->syear == $i)
                        $subjectcount++;

                    $html .= '<table role="table" border="0" cellpadding="3" cellspacing="0" style="text-align: center" align="center">';
                    $html .= '<tr>
                    <th colspan="3 + {{ $subjectcount }} * 2" class="center-text blue-text">
                                        <b>NATIONAL INSTITUTE FOR EMPOWERMENT OF PERSONS WITH MULTIPLE DISABILITIES (DIVYANGJAN)</b><br>
                                        (DEPT. OF EMPOWERMENT OF PERSONS WITH DISABILITIES (DIVYANGJAN) MSJ&E, GOVT OF INDIA)<br>
                                        <b>National Board of Examination in Rehabilitation (NBER)</b><br>
                                         $exam->name  Examination
                                    </th>';
                    $html .= '<tr>
                                    <th colspan="3 + {{ $subjectcount }} * 2" class="center-text blue-text">
                                        {{ $approvedprogramme->institute->code }} - {{ $approvedprogramme->institute->name }}
                                    </th>
                                </tr>';
                    $html .= '<tr>
                                    <th colspan="3 + {{ $subjectcount }} * 2" class="center-text blue-text">
                                        {{ $approvedprogramme->institute->code }} - {{ $approvedprogramme->institute->name }}
                                    </th>
                                </tr>';
                    $html .= '</tr>';
                    $html .= '</table>';
                }

            }
            $pdf = PDF::setOptions(['isRemoteEnabled' => true])->loadHtml($html);
            return $pdf->download('Mark_Details.pdf');

        }

        $html .= '</div>';

        //$pdf = PDF::loadView('institute.exammarks.downloadinternaltheorymarks', compact('exam', 'approvedprogramme', 'applications', 'marks', 'subjects', 'candidates', 'title'));
        //return $pdf->download('marks.pdf');

        //return view('institute.exammarks.downloadinternaltheorymarks', compact('exam', 'approvedprogramme', 'applications', 'marks', 'subjects', 'candidates', 'title'));
    }


    public function viewinternalpracticalmarks($e_id, $ap_id) {
        return '';
        $title = "Internal Practical";

        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Currentapplication::select("currentapplications.*")
            ->join("subjects", "subjects.id", "=", "currentapplications.subject_id")
            ->join("candidates", "candidates.id", "=", "currentapplications.candidate_id")
            ->where('currentapplications.exam_id', $exam->id)->where('currentapplications.approvedprogramme_id', $approvedprogramme->id)
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

        return view('institute.exammarks.viewinternalpracticalmarks', compact('exam', 'approvedprogramme', 'applications', 'marks', 'subjects', 'candidates', 'title'));
    }


    public function viewmarks($e_id, $c_id) {
        echo 'hi';
    }

    public function view_candidate_marks($e_id, $c_id) {
        return '';
        $exam = Exam::where('id', $e_id)->first();

        $candidate = Candidate::where('id', $c_id)->first();

        $applications = Currentapplication::select("currentapplications.*")
            ->join("subjects", "subjects.id", "=", "currentapplications.subject_id")
            ->join("candidates", "candidates.id", "=", "currentapplications.candidate_id")
            ->where('exam_id', $exam->id)->where('candidate_id', $candidate->id)
            ->orderBy('subjects.subjecttype_id')
            ->orderBy('subjects.syear')
            ->orderBy('subjects.sortorder')->get();

        $subjects = Subject::where('programme_id', $candidate->approvedprogramme->programme->id)
            ->orderBy('syear')->orderBy('subjecttype_id')->orderBy('sortorder')->get();

        $application_ids = $applications->pluck('id')->toArray();

        $marks = Mark::whereIn('application_id', $application_ids)->get();

        return view('institute.exammarks.viewcandidatemarks', compact('exam', 'candidate', 'applications', 'subjects', 'marks'));

    }

    public function showInternalTheoryMarksForm($e_id, $ap_id) {
        return '';
        $title = "Internal Theory";

        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Currentapplication::select("currentapplications.*")
            ->join("subjects", "subjects.id", "=", "currentapplications.subject_id")
            ->join("candidates", "candidates.id", "=", "currentapplications.candidate_id")
            ->where('currentapplications.exam_id', $exam->id)->where('currentapplications.approvedprogramme_id', $approvedprogramme->id)
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

        return view('institute.exammarks.internaltheory.form', compact('exam', 'approvedprogramme', 'applications', 'subjects', 'candidates', 'title', 'marks'));
    }

    public function updateInternalTheoryMarks(Request $request) {
        return '';
        $exam = Exam::find($request->exam_id);

        $fyear_file = 0;
        $syear_file = 0;

        $count = Mark::where('internal_file', 'like', "IT" . $exam->id . $exam->date->format('Y') . $request->institute_code . "C" . '%')->get();
        $filecount = $count->unique('internal_file')->count();
        $filecount++;
        for($i = 2, $j = 0; $i > 0, $j < count($request->internal_file); $i--) {
            if ($request->internal_fileterm[$j] == $i) {
                $file = $request->file('internal_file.' . $j);
                $reference_number = "IT" . $exam->id . $exam->date->format('Y') . $request->institute_code . "C" . str_pad($filecount, 3, '0', STR_PAD_LEFT);
                $filename = $reference_number . '.' . $file->getClientOriginalExtension();
                $destination = public_path() . "/files/markfiles/";

                $file->move($destination, $filename);

                if ($i == 2) {
                    $syear_file = $filename;
                } else {
                    $fyear_file = $filename;
                }
                $filecount++;
                $j++;
            }
        }

        $sno = 0;
        foreach ($request->application_id as $appid) {
            $application = Currentapplication::where('id', $appid)->select(["id", "candidate_id", "subject_id", "term", "internalresult_id"])->first();
          //  return $application;
            if(!is_null($application)) {
                $internalattendanceid = ($request->internal[$sno] == 'Abs') ? (int) 2 : (int) 1;

                $mark = Mark::create([
                    "application_id" => $application->id,
                    "exam_id" => $exam->id,
                    "candidate_id" => $application->candidate_id,
                    "subject_id" => $application->subject->id,
                    "internal" => $request->internal[$sno],
                    "internalresult_id" => ((int) $internalattendanceid == (int) 2) ? (int) 3 : (((int) $application->subject->imin_marks > (int) $request->internal[$sno]) ? (int) 2 : (int) 1),
                    "internalattendance_id" => ($request->internal[$sno] == 'Abs') ? (int) 2 : (int) 1,
                    "internal_file" => ((int) $application->term == (int) 2) ? $syear_file : $fyear_file,
                    "total_mark" => ((int) $internalattendanceid == (int) 2) ? (int) 0 : (int) $request->internal[$sno],
                    "active_status" => 1,
                ]);

                if($mark->internalresult_id == 1) {
                    $application->update([
                        "internalresult_id" => 1
                    ]);

                    Internalmark::create([
                        "exam_id" => $exam->id,
                        "application_id" => $application->id,
                        "candidate_id" => $application->candidate_id,
                        "subject_id" => $application->subject->id,
                        "internal" => $mark->internal,
                        "active_status" => 1,
                    ]);
                }

                unset($mark);
                unset($internalattendanceid);
            }

            unset($application);

            $sno++;
        }

        return redirect('/institute/exammarksentry/internal-theory/view/'.$request->exam_id.'/'.$request->approvedprogramme_id);
    }

    public function viewinternaltheorymarks($e_id, $ap_id) {
        return '';
        $title = "Internal Theory";

        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Currentapplication::select("currentapplications.*")
            ->join("subjects", "subjects.id", "=", "currentapplications.subject_id")
            ->join("candidates", "candidates.id", "=", "currentapplications.candidate_id")
            ->where('currentapplications.exam_id', $exam->id)->where('currentapplications.approvedprogramme_id', $approvedprogramme->id)
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

        return view('institute.exammarks.viewinternaltheorymarks', compact('exam', 'approvedprogramme', 'applications', 'marks', 'subjects', 'candidates', 'title'));
        //return view('institute.exammarks.internaltheory.viewmarks', compact('exam', 'approvedprogramme', 'applications', 'marks', 'subjects', 'candidates', 'title'));
    }

    /*
    public function viewInternalTheoryMarks($e_id, $ap_id) {
        $title = "Internal Theory";

        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Currentapplication::select("currentapplications.*")
            ->join("subjects", "subjects.id", "=", "currentapplications.subject_id")
            ->join("candidates", "candidates.id", "=", "currentapplications.candidate_id")
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

        //return view('institute.exammarks.internaltheory.showform', compact('exam', 'approvedprogramme', 'applications', 'subjects', 'candidates', 'title'));
        return view('institute.exammarks.internaltheory.form', compact('exam', 'approvedprogramme', 'applications', 'subjects', 'candidates', 'title', 'marks'));
    }
    */

    public function downloadInternalTheoryMarkEntryForm($e_id, $ap_id) {
        return '';
        $exam = Exam::where('id', $e_id)->first();
        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        if(!$exam || !$approvedprogramme || ($approvedprogramme->institute->user_id != Auth::user()->id)) {
            return redirect('/examinations');
        }
        else {
            /*
            $applications = Currentapplication::select("currentapplications.*")
                ->join("subjects", "subjects.id", "=", "currentapplications.subject_id")
                ->join("candidates", "candidates.id", "=", "currentapplications.candidate_id")
                ->where('applications.exam_id', $exam->id)->where('applications.approvedprogramme_id', $approvedprogramme->id)
                ->where('subjects.subjecttype_id', '=', '1')
                ->whereNotNull('candidates.enrolmentno')
                ->orderBy('candidates.enrolmentno')
                ->orderBy('subjects.subjecttype_id')
                ->orderBy('subjects.syear', 'desc')
                ->orderBy('subjects.sortorder')->get();
            */
            $applications = Currentapplication::where('exam_id', $exam->id)->where('approvedprogramme_id', $approvedprogramme->id)
                ->whereHas('subject', function($query){
                    $query->where('subjecttype_id', '1');
                })
                ->get();


            $subjects = $applications->map(function ($query) {
                return $query->subject;
            });

            $subjects = $subjects->unique('id')->sortBy('sortorder')->sortByDesc('syear');

            /*
            $candidates = $applications->map(function ($query) {
                return $query->candidate;
            });

            $candidates = $candidates->unique('id')->sortByDesc('enrolmentno');
            */

            //return view('institute.exammarks.internaltheory.downloadmarkentryform', compact('exam', 'approvedprogramme', 'applications', 'subjects'));
            //return view('institute.exammarks.internaltheory.download', compact('exam', 'approvedprogramme', 'applications', 'subjects'));
            return view('institute.exammarks.internaltheory.s2', compact('exam', 'approvedprogramme', 'applications', 'subjects'));

        }
    }
    public function showInternalPracticalMarksFormRestructure($e_id, $ap_id) {
        $ap = Approvedprogramme::with('subjects')->with('candidates')->find($ap_id);
        return view('institute.markentry.internal',compact('ap'));
    }
    public function showInternalPracticalMarksForm($e_id, $ap_id) {
        return '';
        $title = "Internal Practical";

        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::find($ap_id);

        $applications = Currentapplication::select("currentapplications.*")
            ->join("subjects", "subjects.id", "=", "currentapplications.subject_id")
            ->join("candidates", "candidates.id", "=", "currentapplications.candidate_id")
            ->where('currentapplications.exam_id', $exam->id)->where('currentapplications.approvedprogramme_id', $approvedprogramme->id)
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

        //return view('institute.exammarks.internaltheory.showform', compact('exam', 'approvedprogramme', 'applications', 'subjects', 'candidates', 'title', 'marks'));
        return view('institute.exammarks.internalpractical.form', compact('exam', 'approvedprogramme', 'applications', 'subjects', 'candidates', 'title', 'marks'));
    }

    public function updateInternalPracticalMarks(Request $request) {
        $exam = Exam::find($request->exam_id);

        $fyear_file = 0;
        $syear_file = 0;

        $count = Mark::where('internal_file', 'like', "IP" . $exam->id . $exam->date->format('Y') . $request->institute_code . "C" . '%')->get();
        $filecount = $count->unique('internal_file')->count();
        $filecount++;
        for($i = 2, $j = 0; $i > 0, $j < count($request->internal_file); $i--) {
            if ($request->internal_fileterm[$j] == $i) {
                $file = $request->file('internal_file.' . $j);
                $reference_number = "IT" . $exam->id . $exam->date->format('Y') . $request->institute_code . "C" . str_pad($filecount, 3, '0', STR_PAD_LEFT);
                $filename = $reference_number . '.' . $file->getClientOriginalExtension();
                $destination = public_path() . "/files/markfiles/";

                $file->move($destination, $filename);

                if ($i == 2) {
                    $syear_file = $filename;
                } else {
                    $fyear_file = $filename;
                }
                $filecount++;
                $j++;
            }
        }

        $sno = 0;
        foreach ($request->application_id as $appid) {

            $application = Application::where('id', $appid)->select(["id", "candidate_id", "subject_id", "term"])->first();

            if(!is_null($application)) {
                $internalattendanceid = ($request->internal[$sno] == 'Abs') ? (int) 2 : (int) 1;

                $mark = Mark::create([
                    "application_id" => $application->id,
                    "exam_id" => $exam->id,
                    "candidate_id" => $application->candidate_id,
                    "subject_id" => $application->subject->id,
                    "internal" => $request->internal[$sno],
                    "internalresult_id" => ((int) $internalattendanceid == (int) 2) ? (int) 3 : (((int) $application->subject->imin_marks > (int) $request->internal[$sno]) ? (int) 2 : (int) 1),
                    "internalattendance_id" => ($request->internal[$sno] == 'Abs') ? (int) 2 : (int) 1,
                    "internal_file" => ((int) $application->term == (int) 2) ? $syear_file : $fyear_file,
                    "total_mark" => ((int) $internalattendanceid == (int) 2) ? (int) 0 : (int) $request->internal[$sno],
                    "active_status" => 1,
                ]);

                if($mark->internalresult_id == 1) {
                    Internalmark::create([
                        "exam_id" => $exam->id,
                        "application_id" => $application->id,
                        "candidate_id" => $application->candidate_id,
                        "subject_id" => $application->subject->id,
                        "internal" => $mark->internal,
                        "active_status" => 1,
                    ]);
                }

                unset($mark);
                unset($internalattendanceid);
            }

            unset($application);

            $sno++;
        }
        return redirect('/institute/exammarksentry/internal-practical/view/'.$request->exam_id.'/'.$request->approvedprogramme_id);
    }

    public function showExternalPracticalMarksForm($e_id, $ap_id) {
        return '';
        $title = "External Practical";

        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();
        $candidates = \App\Candidate::where('approvedprogramme_id',$ap_id)->whereNotNull('enrolmentno')->pluck('id')->toArray();
        $applications = Currentapplication::select("currentapplications.*")
            ->join("subjects", "subjects.id", "=", "currentapplications.subject_id")
            ->join("candidates", "candidates.id", "=", "currentapplications.candidate_id")
            ->join("marks", "marks.application_id", "=", "currentapplications.id")
            ->where('currentapplications.exam_id', $exam->id)->where('currentapplications.approvedprogramme_id', $approvedprogramme->id)
            ->where('subjects.subjecttype_id', '=', '2')
            ->whereNotNull('candidates.enrolmentno')
            ->where("marks.internalresult_id", "1")
            ->orderBy('candidates.enrolmentno')
            ->orderBy('subjects.subjecttype_id')
            ->orderBy('subjects.syear', 'desc')
            ->orderBy('subjects.sortorder')->get(); 

        //$applications = Application::where('exam_id',$exam->id)->whereIn('candidate_id',$candidates)->get();

        $application_ids = $applications->pluck('id')->toArray();
        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();

       $subjects = Subject::whereIn('id', $subject_ids)->orderBy('syear')->orderBy('sortorder')->get();
     //  $subjects = Subject::where('programme_id', $approvedprogramme->programe_id)->orderBy('syear')->orderBy('sortorder')->get();
        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        //return view('institute.exammarks.internaltheory.showform', compact('exam', 'approvedprogramme', 'applications', 'subjects', 'candidates', 'title', 'marks'));
        return view('institute.exammarks.externalpractical.form', compact('exam', 'approvedprogramme', 'applications', 'subjects', 'candidates', 'title', 'marks'));
    }

    public function downloadInternalTheoryMarkEntryForms(){
        $file = public_path().'/files/documents/internaltheorymarkentryform.pdf';
        return Response::download($file);
    }

    public function downloadInternalPracticalMarkEntryForms(){
        $file = public_path().'/files/documents/internalpracticalmarkentryform.pdf';
        return Response::download($file);
    }

    public function downloadExternalPracticalMarkEntryForms(){
        $file = public_path().'/files/documents/externalpracticalmarkentryform.pdf';
        return Response::download($file);
    }

    public function updateExternalPracticalMarks(Request $request) {
        $exam = Exam::find($request->exam_id);

        $fyear_file = 0;
        $syear_file = 0;

        $count = Mark::where('external_file', 'like', "EP" . $exam->id . $exam->date->format('Y') . $request->institute_code . "C" . '%')->get();
        $filecount = $count->unique('external_file')->count();
        $filecount++;
        for($i = 2, $j = 0; $i > 0, $j < count($request->external_file); $i--) {
            if ($request->external_fileterm[$j] == $i) {
                $file = $request->file('external_file.' . $j);
                $reference_number = "EP" . $exam->id . $exam->date->format('Y') . $request->institute_code . "C" . str_pad($filecount, 3, '0', STR_PAD_LEFT);
                $filename = $reference_number . '.' . $file->getClientOriginalExtension();
                $destination = public_path() . "/files/markfiles/";

                $file->move($destination, $filename);

                if ($i == 2) {
                    $syear_file = $filename;
                } else {
                    $fyear_file = $filename;
                }
                $filecount++;
                $j++;
            }
        }

        $sno = 0;
        foreach ($request->application_id as $appid) {
            $application = Curreentapplication::where('id', $appid)->select(["id", "candidate_id", "subject_id", "term"])->first();

            if(!is_null($application)) {
                $externalattendanceid = ($request->external[$sno] == 'Abs') ? (int) 2 : (int) 1;

                $mark = Mark::where('application_id', $application->id)->first();

                $mark->update([
                    "application_id" => $application->id,
                    "exam_id" => $exam->id,
                    "candidate_id" => $application->candidate_id,
                    "subject_id" => $application->subject->id,
                    "external" => $request->external[$sno],
                    "externalresult_id" => ((int) $externalattendanceid == (int) 2) ? (int) 3 : (((int) $application->subject->emin_marks > (int) $request->external[$sno]) ? (int) 2 : (int) 1),
                    "externalattendance_id" => ($request->external[$sno] == 'Abs') ? (int) 2 : (int) 1,
                    "external_file" => ((int) $application->term == (int) 2) ? $syear_file : $fyear_file,
                    "active_status" => 1,
                ]);

                unset($mark);
                unset($externalattendanceid);
            }

            unset($application);

            $sno++;
        }
        return redirect('/institute/exammarksentry/external-practical/view/'.$request->exam_id.'/'.$request->approvedprogramme_id);

    }

    public function viewExternalPracticalMarks($e_id, $ap_id) {
        return '';
        $title = "External Practical";

        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Currentapplication::select("currentapplications.*")
            ->join("subjects", "subjects.id", "=", "currentapplications.subject_id")
            ->join("candidates", "candidates.id", "=", "currentapplications.candidate_id")
            ->join("marks", "marks.application_id", "=", "currentapplications.id")
            ->where('currentapplications.exam_id', $exam->id)->where('currentapplications.approvedprogramme_id', $approvedprogramme->id)
            ->where('subjects.subjecttype_id', '=', '2')
            ->whereNotNull('candidates.enrolmentno')
            ->where("marks.internalresult_id", "1")
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

        return view('institute.exammarks.viewexternalpracticalmarks', compact('exam', 'approvedprogramme', 'applications', 'marks', 'subjects', 'candidates', 'title'));
    }


}
