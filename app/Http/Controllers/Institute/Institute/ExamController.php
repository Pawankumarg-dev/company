<?php

namespace App\Http\Controllers\Institute;

use App\Academicyear;
use App\Exambatch;
use App\Examresultdate;
use App\Incidentalfee;
use App\Incidentalpayment;
use App\Internalmark;
use App\Mark;
use App\Withheld;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Approvedprogramme;
use Illuminate\Support\Facades\App;
use Validator;
use App\Http\Controllers\Controller;
use Auth;
use App\Candidate;
use App\City;
use App\Community;
use App\Disability;
use App\Gender;
use App\Salutation;
use App\Subject;
use App\Application;
use App\Language;
use App\Programme;
use App\Institute;
use App\Exam;
use App\Examtimetable;
use App\Examcenter;
use App\Examattendancefile;

use Session;
use File;
use Input;
use Response;
use PDF;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function index(){
        $programmes = Programme::all();
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        $approvedprogrammes = Approvedprogramme::select('approvedprogrammes.*')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->where('institute_id', $institute->id)
            ->orderBy('programmes.sortorder')
            ->orderBy('academicyears.year')
            ->get();
        //$approvedprogrammes = $institute->approvedprogrammes;
        $exams=Exam::orderBy('date','desc')->get();
        $exambatches = Exambatch::all();
        //$examattendancefiles = Examattendancefile::where('exam_id','2')->get();

        $completedexams = Examtimetable::where('exam_id','2')->where('enddate','<',\Carbon\Carbon::now())->get();
        $programme_ids = Approvedprogramme::where('institute_id',$institute->id)->where('academicyear_id','1')->orderBy('programme_id')->lists('programme_id')->toArray();

        //$timetable = Examtimetable::where('exam_id','2')->get(); //June 2018 Exam over
        $timetable = Examtimetable::all(); //August 2018 Exam

        $erds = Examresultdate::all();

        if('2' == '2') {
            $ap_ids = Approvedprogramme::where('institute_id', $institute->id)->pluck('id')->toArray();

            $collections = Application::select('applications.*')
                ->join('candidates', 'candidates.id', '=', 'applications.candidate_id')
                ->where('applications.exam_id', '2')->whereIn('applications.approvedprogramme_id', $ap_ids)
                ->whereNotNull('candidates.enrolmentno')
                ->orderBy('candidates.enrolmentno')->get();
        }

        //June 2018 Examination
        $withhelds = Withheld::where('exam_id','2')->get();


        return view('institute.exams', compact('approvedprogrammes', 'exams', 'exambatches', 'examresultdate', 'erds'));
    }

    public function register($id,$exam_id){
        $ap = Approvedprogramme::find($id);
        if($ap) {
            if($ap->id == Institute::where('user_id',Auth::user()->id)->first()->id) {
                echo $ap;
            }
            else {
                return $this->index();
            }
        }
        else {
            return $this->index();
        }
    }

    public function oldregister($id,$exam_id){
        $ap = Approvedprogramme::find($id);
        if($ap){
            $withheld_candidateid = Withheld::where('status', '1')->distinct('candidate_id')->pluck('candidate_id')->toArray();
            $candidates = Candidate::where('approvedprogramme_id',$ap->id)->whereNotNull('enrolmentno')
                ->where('enrolmentno', '!=', '')->orderBy('enrolmentno')
                ->whereNotIn('id', $withheld_candidateid)
                ->with('applications')->get();
            $languages = Language::all();
            $exam = Exam::find($exam_id);
            $exambatch = Exambatch::where('exam_id', $exam->id)->where('programme_id', $ap->programme_id)
                ->where('academicyear_id', $ap->academicyear_id)->get();

            $linkopen_number = '1';
            $penalty = 'No';

            $allowapplication = 1;
            $errormessage = "";
            if($exam_id = "17") {
                $ayid = Academicyear::where("year", "2019")->first()->id;

                $ap2019 = Approvedprogramme::where("institute_id", $ap->institute_id)->where("academicyear_id", $ayid)
                    ->where("programme_id", $ap->programme_id)
                    ->where("status_id", "2")->first();

                if(is_null($ap2019)) {
                    $allowapplication = 0;
                }
                else {
                    $candidatecount = Candidate::where("approvedprogramme_id", $ap2019->id)->whereNotNull("enrolmentno")->count();

                    if($candidatecount == 0) {
                        $allowapplication = 0;
                    }
                    else {
                        $errormessage = 3;
                        $incidentalfee = Incidentalfee::where("academicyear_id", $ayid)->where("programme_id", $ap->programme_id)->get();
                        $incidentalfee_ids = $incidentalfee->pluck("id")->toArray();

                        $incidentalcharges = Incidentalpayment::whereIn("incidentalfee_id", $incidentalfee_ids)->where("institute_id", $ap->institute_id)->get();

                        if(!is_null($incidentalcharges)) {
                            $firstterm = 0;
                            $secondterm = 0;

                            foreach ($incidentalcharges as $incidentalcharge) {
                                if($incidentalcharge->incidentalfee->term == 1) {
                                    if($incidentalcharge->status_id == 2) {
                                        $firstterm++;
                                    }
                                }
                                if($incidentalcharge->incidentalfee->term == 2) {
                                    if($incidentalcharge->status_id == 2) {
                                        $secondterm++;
                                    }
                                }
                            }

                            if($firstterm == 1 && $secondterm == 1) {
                                $allowapplication = 0;
                            }
                            else {
                                $errormessage = "Affiliation fee Payment Not Approved";
                            }
                        }
                        else {
                            $errormessage = "Affiliation Charges Not Entered";
                        }
                    }
                }
            }

            return view('institute.exam.index',compact('candidates','ap','languages','exam', 'linkopen_number', 'penalty', 'exambatch', 'allowapplication', 'errormessage'));
        }else{
            return redirect('/');
        }
    }

    public function newapply(Request $request) {
        $ap = Approvedprogramme::find($request->application_id);

        if(is_null($ap)) {

        }
        else {
            foreach ($ap->programme->subjects as $subject) {

            }
        }
    }

    public function apply(Request $request){
        $ap = Approvedprogramme::find($request->application_id);

        foreach($ap->programme->subjects as $sub){
            //Application::where('candidate_id',$request->candidate_id)->where('subject_id',$sub->id)->delete();

            if($request->has($sub->id)){
                $applicationfound = Application::where('exam_id', $request->exam_id)->where('candidate_id', $request->candidate_id)
                    ->where('subject_id', $sub->id)->exists();

                if(!$applicationfound) {
                    Application::create([
                        'approvedprogramme_id'=>$ap->id,
                        'candidate_id'=>$request->candidate_id,
                        'subject_id'=>$sub->id,
                        'status_id' => 1,
                        'term'=>$request->term,
                        'language_id'=>$request->language,
                        'exam_id' => $request->exam_id,
                        'linkopen_number' => $request->linkopen_number,
                        'penalty' => $request->penalty
                    ]);

                    $application = Application::where('exam_id', $request->exam_id)->where('candidate_id', $request->candidate_id)
                        ->where('subject_id', $sub->id)->first();

                    if($application->subject->imin_marks == 0) {
                        $mark = Mark::create([
                            "application_id" => $application->id,
                            "exam_id" => $request->exam_id,
                            "candidate_id" => $application->candidate_id,
                            "subject_id" => $application->subject_id,
                            "internal" => "0",
                            "internalresult_id" => 1,
                            "internal_lock" => 1,
                            "internalattendance_id" => 1,
                            "active_status" => 1
                        ]);
                        $mark->increment('total_mark', '0');
                    }
                    else {
                        $internalmark = Internalmark::where('candidate_id', $application->candidate_id)->where('subject_id', $application->subject_id)->first();

                        if(!is_null($internalmark)) {
                            $mark = Mark::create([
                                "application_id" => $application->id,
                                "exam_id" => $request->exam_id,
                                "candidate_id" => $application->candidate_id,
                                "subject_id" => $application->subject_id,
                                "internal" => $internalmark->internal,
                                "internalresult_id" => 1,
                                "internal_lock" => 1,
                                "internalattendance_id" => 1,
                                "active_status" => 1
                            ]);
                            $mark->increment('total_mark', $internalmark->internal);
                        }
                    }
                }
            }
        }

        /*
		foreach($ap->programme->subjects->where('syear',$request->term) as $sub){


			//Application::where('candidate_id',$request->candidate_id)->where('subject_id',$sub->id)->delete();

			if($request->has($sub->id)){
				Application::create([
					'approvedprogramme_id'=>$ap->id,
					'candidate_id'=>$request->candidate_id,
					'subject_id'=>$sub->id,
					'status_id' => 1,
					'term'=>$request->term,
					'language_id'=>$request->language,

                    //edited: 04-06-2018
					//'exam_id' => 2, //->uncommented
                    //->added
                    'exam_id' => $request->exam_id,
                    'linkopen_number' => $request->linkopen_number,
                    'penalty' => $request->penalty
                    //end->edited: 04-06-2018
				]);
			}


		}
		*/

        return back();
    }
    public function qpdownloads($exam_id){
        $questionpapers = Examtimetable::where('exam_id',$exam_id)->where('enddate','>',\Carbon\Carbon::now())->where('enddate','<',\Carbon\Carbon::now()->addHour(4))->get();
        $today = Examtimetable::where('exam_id',$exam_id)->whereDate("startdate",'=',\Carbon\Carbon::today())->get();
        return view('institute.questionpapers.download',compact('questionpapers','today','exam_id')) ;
    }

    public function qpdownload($et_id){
        $et = Examtimetable::find($et_id);

        //$status = $et->exam->
        $institute_id = Institute::where('user_id',Auth::user()->id)->first()->id;
        $exam_center = Examcenter::where('institute_id',$institute_id)->where('exam_id',$et->exam->id);

        $center = 1;
        if($exam_center->count() > 0){
            if($exam_center->first()->examcenter_id != $institute_id){
                $center = 0;
            }
        }
        elseif ($exam_center->count() == 0) {
            $center = 0;
        }
        else {
            $center = 1;
        }

        $institutes_for = Examcenter::where('examcenter_id',$institute_id)->where('exam_id',$et->exam->id)->orderBy('institute_id')->lists('institute_id')->toArray();
        //$institute_ids =
        if($center==1){
            array_push($institutes_for,$institute_id);
        }
        //Session::put('error',json_encode($institutes_for));
        //return back();
        $programme_ids = array_unique(Approvedprogramme::whereIn('institute_id',$institutes_for)->orderBy('programme_id')->lists('programme_id')->toArray());
        //Session::put('error',json_encode($programme_ids));
        //return back();
        $programme_id = $et->subject->programme->id;
        if(in_array($programme_id, $programme_ids)){
            if($et->questionpaper){
                if($et->enddate > \Carbon\Carbon::now()){
                    if($et->startdate < \Carbon\Carbon::now()->addMinutes(35) ){
                        $file = public_path().'/files/questionpapers/'.$et->questionpaper;
                        return Response::download($file);
                    }
                }
            }else{
                Session::put('error','Could not find the question paper to download');
                return back();
            }
        }else{

            Session::put('error','You are not authorized to download as your institute is not conducting this programme or your institute may not applied for this exam or the exam center is different');
            return back();
        }
        Session::put('error','Could not download');
        return back();
    }

    public function exampdf($apid, $examid){
        $ap = Approvedprogramme::find($apid);

        if ($ap->institute->user_id == Auth::user()->id) {
            $exam = Exam::find($examid);

            $collections = Application::select("candidates.enrolmentno as ceno", "candidates.name as cname", "subjects.syear as term",
                "subjecttypes.type as type", "applications.penalty as penalty")
                ->selectRaw("Group_Concat(subjects.scode Separator ', ') as scodes")
                ->selectRaw("count(subjects.scode) as scount")
                ->join("exams", "exams.id", "=", "applications.exam_id")
                ->join("approvedprogrammes", "approvedprogrammes.id", "=", "applications.approvedprogramme_id")
                ->join("candidates", function ($join){
                    $join->on("candidates.approvedprogramme_id", "=", "approvedprogrammes.id");
                    $join->on("candidates.id", "=", "applications.candidate_id");
                })
                ->join("subjects", "subjects.id", "=", "applications.subject_id")
                ->join("subjecttypes", "subjecttypes.id", "=", "subjects.subjecttype_id")
                ->where("exams.id", "=", $exam->id)->where("approvedprogrammes.id", "=", $ap->id)
                ->groupBy("candidates.enrolmentno")
                ->get();


            $html = '
                    <html>
                        <head>
                            <style>
                                .page-break {
                                    page-break-after: always;
                                }
                                .blue-text {
                                    color: blue;
                                }
                                .red-text {
                                    color: red;
                                }
                                .green-text {
                                    color: green;
                                }
                                .h4-text {
                                    font-size: 20px;
                                    font-weight: bold;
                                }
                                .left-text{
                                    float: left;
                                }
                                .center-text{
                                    text-align: center !important;
                                }
                                
                            </style>
                        </head>
                        <body>  
                    ';
            $html .= '<table role="table" border="0" cellpadding="3" cellspacing="0" style="text-align: center" align="center">';
            $html .= '<tr>';
            $html .= '<td></td>';
            $html .= '<td>
                        <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                        <span>(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                        <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span>
                        </td>';
            $html .= '</tr>';
            $html .= '</table>';


            $html .= '<p style="text-align: center" class="blue-text h3-text"><b>Online Exam Applications Details for - '.$exam->name.
                ' Examination</b></p>';
            $html .= '<table role="table" border="1" cellpadding="3" cellspacing="0" style="text-align: center" align="center">';
            $html .= '<tbody>';
            $html .= '<tr>';
            $html .= '<td>Institute<br>Name</td>';
            $html .= '<td><span><b>'.$ap->institute->name.'</b></span></td>';
            $html .= '<td>Center<br>Code</td>';
            $html .= '<td><span><b>'.$ap->institute->user->username.'</b></span></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td>Programme</td>';
            $html .= '<td><span><b>'.$ap->programme->name.'</b></span></td>';
            $html .= '<td>Code</td>';
            $html .= '<td><span><b>'.$ap->programme->course_name.'</b></span></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td>Batch</td>';
            $html .= '<td colspan="3">'.$ap->academicyear->year.'</td>';
            $html .= '</tr>';
            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '<hr /><br />';

            $html .= '<table role="table" border="1" cellpadding="3" cellspacing="0" align="center">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th><div class="center-text">Enrolment No</div></th>';
            $html .= '<th><div class="center-text">Name</th></div>';
            $html .= '<th><div class="center-text">Applied Subject Codes</div></th>';
            $html .= '<th><div class="center-text">Total Subjects<br>Applied</div></th>';
            $html .= '</thead>';

            $html .= '<tbody>';
            foreach ($collections as $c) {
                $html .= '<tr>';
                $html .= '<td><div class="blue-text"><b>'.$c->ceno.'</b></div></td>';
                $html .= '<td><div class="blue-text"><b>'.$c->cname.'</b></div></td>';
                $html .= '<td><div class="green-text"><b>'.$c->scodes.'</b></div></td>';
                $html .= '<td>
                            <div class="center-text green-text"><b>'.$c->scount.'</b></div></td>';
                $html .= '</tr>';
            }
            $html .= '</tbody>';
            $html .= '</table>';
            //echo $html;

            $pdf = PDF::setOptions(['isRemoteEnabled' => true])->loadHtml($html);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download($ap->institute->user->username . '-' . $ap->programme->course_name . '-' . $ap->academicyear->year . '-Exam_Application.pdf');

        }
        else{
            return redirect('/');
        }
    }

    public function paymentpdf($apid, $examid){
        $ap = Approvedprogramme::find($apid);

        if ($ap->institute->user_id == Auth::user()->id) {
            $exam = Exam::find($examid);

            $collections = Application::select("candidates.enrolmentno as ceno", "candidates.name as cname", "subjects.syear as term",
                "subjecttypes.type as type", "subjects.scode as scode", "subjects.sname as sname", "applications.penalty as penalty")
                ->join("exams", "exams.id", "=", "applications.exam_id")
                ->join("approvedprogrammes", "approvedprogrammes.id", "=", "applications.approvedprogramme_id")
                ->join("candidates", function ($join){
                    $join->on("candidates.approvedprogramme_id", "=", "approvedprogrammes.id");
                    $join->on("candidates.id", "=", "applications.candidate_id");
                })
                ->join("subjects", "subjects.id", "=", "applications.subject_id")
                ->join("subjecttypes", "subjecttypes.id", "=", "subjects.subjecttype_id")
                ->where("exams.id", "=", $exam->id)->where("approvedprogrammes.id", "=", $ap->id)
                ->orderBy("candidates.enrolmentno")->orderBy("subjects.syear")->orderBy("subjects.subjecttype_id")
                ->orderBy("subjects.sortorder")->get();


            $html = '
                    <html>
                        <head>
                            <style>
                                .page-break {
                                    page-break-after: always;
                                }
                                .blue-text {
                                    color: blue;
                                }
                                .red-text {
                                    color: red;
                                }
                                .green-text {
                                    color: green;
                                }
                                .h4-text {
                                    font-size: 20px;
                                    font-weight: bold;
                                }
                                .left-text{
                                    float: left;
                                }
                                .center-text{
                                    text-align: center !important;
                                }
                                
                            </style>
                        </head>
                        <body>  
                    ';
            $html .= '<table role="table" border="0" cellpadding="3" cellspacing="0" style="text-align: center" align="center">';
            $html .= '<tr>';
            $html .= '<td></td>';
            $html .= '<td>
                        <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                        <span>(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                        <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span>
                        </td>';
            $html .= '</tr>';
            $html .= '</table>';


            $html .= '<p style="text-align: center" class="blue-text h3-text"><b>Online Exam Applications Fee Pay Details for - '.$exam->name.
                ' Examination</b></p>';
            $html .= '<table role="table" border="1" cellpadding="3" cellspacing="0" style="text-align: center" align="center">';
            $html .= '<tbody>';
            $html .= '<tr>';
            $html .= '<td>Institute<br>Name</td>';
            $html .= '<td><span><b>'.$ap->institute->name.'</b></span></td>';
            $html .= '<td>Center<br>Code</td>';
            $html .= '<td><span><b>'.$ap->institute->user->username.'</b></span></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td>Programme</td>';
            $html .= '<td><span><b>'.$ap->programme->name.'</b></span></td>';
            $html .= '<td>Code</td>';
            $html .= '<td><span><b>'.$ap->programme->course_name.'</b></span></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td>Batch</td>';
            $html .= '<td colspan="3">'.$ap->academicyear->year.'</td>';
            $html .= '</tr>';
            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '<hr /><br />';

            $html .= '<table role="table" border="1" cellpadding="3" cellspacing="0" align="center">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th rowspan="2"><div class="center-text">Enrolment No</div></th>';
            $html .= '<th rowspan="2"><div class="center-text">Name</div></th>';
            $html .= '<th rowspan="2"><div class="center-text">Term</div></th>';
            $html .= '<th rowspan="2"><div class="center-text">Type</div></th>';
            $html .= '<th rowspan="2"><div class="center-text">Subject Code</div></th>';
            //$html .= '<th rowspan="2"><div class="center-text">Subject Name</div></th>';
            $html .= '<th colspan="3"><div class="center-text">Exam Fee per Subject</div></th>';
            $html .= '<th rowspan="2"><div class="center-text">Fine Remarks</div></th>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<th><div class="center-text">Fee</div></th>';
            $html .= '<th><div class="center-text">Fine</div></th>';
            $html .= '<th><div class="center-text">Total<br>(Fee + Fine)</div></th>';
            $html .= '</tr>';
            $html .= '</thead>';

            $html .= '<tbody>';
            foreach ($collections as $c) {
                $amount = 150;
                $html .= '<tr>';
                $html .= '<td><div class="blue-text"><b>'.$c->ceno.'</b></div></td>';
                $html .= '<td><div class="blue-text"><b>'.$c->cname.'</b></div></td>';
                $html .= '<td><div class="center-text blue-text"><b>'.$c->term.'</b></div></td>';
                $html .= '<td><div class="blue-text"><b>'.$c->type.'</b></div></td>';
                $html .= '<td><div class="blue-text"><b>'.$c->scode.'</b></div></td>';
                //$html .= '<td><div class="blue-text"><b>'.$c->sname.'</b></div></td>';
                $html .= '<td><div class="blue-text"><b>'.$amount.'</b></div></td>';
                if($c->penalty == 'Yes') {
                    $fine = 50;
                    $total = $amount + $fine;
                    $html .= '<td><div class="center-text red-text"><b>'.$fine.'</b></div></td>';
                    $html .= '<td><div class="center-text red-text"><b>'.$total.'</b></div></td>';
                    $html .= '<td><div class="center-text red-text"><b>Applied Later</b></div></td>';
                }
                else {
                    $fine = 0;
                    $total = $amount + $fine;
                    $html .= '<td><div class="center-text green-text"><b>'.$fine.'</b></div></td>';
                    $html .= '<td><div class="center-text green-text"><b>'.$total.'</b></div></td>';
                    $html .= '<td><div class="center-text green-text"><b>NIL</b></div></td>';
                }
                $html .= '</tr>';
            }
            $html .= '</tbody>';
            $html .= '</table>';
            //echo $html;

            $pdf = PDF::setOptions(['isRemoteEnabled' => true])->loadHtml($html);
            //$pdf->setPaper('A4', 'landscape');
            return $pdf->download($ap->institute->user->username . '-' . $ap->programme->course_name . '-' . $ap->academicyear->year . '-Exam_Application_Feepay_Details.pdf');

        }
        else{
            return redirect('/');
        }
    }
}

