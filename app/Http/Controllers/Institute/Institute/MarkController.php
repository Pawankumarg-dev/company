<?php

namespace App\Http\Controllers\Institute;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


use App\Http\Requests;

use Auth;
use App\Mark;
use App\Approvedprogramme;
use App\Application;
use App\Candidate;
use App\Subject;
use App\Exam;
use App\Subjecttype;
use phpDocumentor\Reflection\Types\Null_;
use PDF;

class MarkController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }
    public function markabsent($mid,$inex){
        $mark = Mark::where('application_id',$mid);
        if($mark->count()>0){
            if($inex=='EX'){
                $mark->update(['external'=>'Abs']) ;
            }else{
                $mark->update(['internal'=>'Abs']) ;
            }
        }else{
            if($inex=='EX'){
                Mark::create(['application_id'=>$mid,'external'=>'Abs']);
            }else{
                Mark::create(['application_id'=>$mid,'internal'=>'Abs']);
            }
        }
        return back();
    }

    public function index($approvedprogramme_id, $exam_id, Request $request){
        $userid = Auth::user()->id;
        //$exam_id = 2;
        $instituteid   = Approvedprogramme::find($approvedprogramme_id)->institute->user->id;
        if($userid==$instituteid){
            $collections = Application::select("applications.*")
                ->join("subjects", "subjects.id", "=", "applications.subject_id")
                ->join("candidates", "candidates.id", "=", "applications.candidate_id")
                ->orderBy("candidates.enrolmentno")
                ->orderBy('subjects.subjecttype_id')->orderBy('subjects.syear')
                ->orderBy('subjects.sortorder');

            $collections = $collections->where('exam_id', $exam_id);

            $collections =  $collections->whereHas('candidate',function($r) use($approvedprogramme_id){
                $r->where('approvedprogramme_id',$approvedprogramme_id);
            });

            $ap = Approvedprogramme::find($approvedprogramme_id);

            $text = 'Mark Entry (' .  $ap->programme->course_name . ' , ' . $ap->academicyear->year. ')';
            $printbutton = 'savemark';

            $enrolmentnumbers = Candidate::where('approvedprogramme_id',$approvedprogramme_id)->whereNotNull('enrolmentno')->get();
            $programme_id = Approvedprogramme::find($approvedprogramme_id)->programme_id;
            $syty = 'New';
            $ayid  = Approvedprogramme::find($approvedprogramme_id)->academicyear_id;
            if($ayid>3 && $ayid<6){
                $syty = 'Old';
            }
            $subjects  = Subject::where('programme_id',$programme_id)->where('syllabus_type',$syty)->orderBy('sortorder')->get();
            //$subject_ids = $collections->groupBy('subject_id')->pluck('subject_id')->toArray();
            //return $collections->count();
            //$subjects = Subject::whereIn('id',$subject_ids)->get();
            $types = Subjecttype::all();

            if($request->has('cid')){
                $collections = $collections->where('candidate_id',$request->cid);

            }

            if($request->has('sid')){
                $collections =  $collections->where('subject_id',$request->sid);
            }
            if($request->has('stid')){
                $collections =  $collections->whereHas('subject',function($r) use($request){
                    $r->where('subjecttype_id',$request->stid);
                });
            }
            $collections = $collections->paginate(20);
            $exam  = Exam::find($exam_id);

            return view('institute.exam.marks',compact('collections','text','enrolmentnumbers','subjects','types','exam', 'printbutton', 'ap'));

        }
    }
    public function update(Request $r){
        $mark = Mark::where('application_id',$r->aid);
        $application = Application::find($r->aid);
        if($mark->count()>0){
            if($r->inex=='EX'){
                $mark->update(['external'=>$r->mark]) ;
            }else{
                $mark->update(['internal'=>$r->mark]) ;
            }
        }else{
            if($r->inex=='EX'){
                /*
              Mark::create(['application_id'=>$r->aid,'external'=>$r->mark, 'candidate_id'=>$r->aid->candidate->id,
                  'subject_id'=>$r->aid->subject->id, 'exam_id'=>$r->aid->exam->id]);
                */
                Mark::create(['application_id'=>$r->aid,'external'=>$r->mark, 'exam_id'=>$application->exam->id,
                    'candidate_id'=>$application->candidate->id, 'subject_id'=>$application->subject->id]);
            }else{
                /*
              Mark::create(['application_id'=>$r->aid,'internal'=>$r->mark, 'candidate_id'=>$r->aid->candidate->id,
                    'subject_id'=>$r->aid->subject->id, 'exam_id'=>$r->aid->exam->id]);
                */
                Mark::create(['application_id'=>$r->aid,'internal'=>$r->mark, 'exam_id'=>$application->exam->id,
                    'candidate_id'=>$application->candidate->id, 'subject_id'=>$application->subject->id]);
            }
        }
        return $r->inex.'_'.$r->cid."_".$r->sid;
    }

    public function markpdf($apid, $examid)
    {
        $ap = Approvedprogramme::find($apid);

        if ($ap->institute->user_id == Auth::user()->id) {
            $exam = Exam::find($examid);

            $collections = Mark::select("candidates.enrolmentno as ceno", "candidates.name as cname", "subjects.scode as subcode",
                "subjects.sname as subname", "subjects.syear as term", "subjecttypes.type as subtype",
                "subjects.imin_marks as imin", "subjects.imax_marks as imax", "subjects.emin_marks as emin",
                "subjects.emax_marks as emax", "marks.internal as imark", "marks.external as emark")
                ->join("applications", "applications.id", "=", "marks.application_id")
                ->join("approvedprogrammes", "approvedprogrammes.id", "=", "applications.approvedprogramme_id")
                ->join("programmes", "programmes.id", "=", "approvedprogrammes.programme_id")
                ->join("candidates", function ($join){
                    $join->on("candidates.approvedprogramme_id", "=", "approvedprogrammes.id");
                    $join->on("candidates.id", "=", "applications.candidate_id");
                })
                ->join("subjects", "subjects.id", "=", "applications.subject_id")
                ->join("subjecttypes", "subjecttypes.id", "=", "subjects.subjecttype_id")
                ->join("exams", "exams.id", "=", "applications.exam_id")
                ->where("exams.id", "=", $exam->id)
                ->where('approvedprogrammes.id', "=", $ap->id)->orderBy('enrolmentno')
                ->orderBy('subjects.subjecttype_id')->orderBy('subjects.syear')->orderBy('subjects.sortorder')->get();



            /*
            echo '<table role="table" border="2" cellpadding="3" cellspacing="0" style="text-align: center" align="center">';
            echo '<tr>';
            echo '<th rowspan="2">Enrolment<br>No</th>';
            echo '<th rowspan="2">Candidate Name</th>';
            echo '<th rowspan="2">Subject<br>Code</th>';
            echo '<th rowspan="2">Subject Name</th>';
            echo '<th rowspan="2">Term</th>';
            echo '<th rowspan="2">Type</th>';
            echo '<th colspan="3">Internal Mark</th>';
            echo '<th colspan="3">Practical Mark</th>';
            echo '</tr>';
            echo '<tr>';
            echo '<th>Min</th>';
            echo '<th>Max</th>';
            echo '<th>Entered</th>';
            echo '<th>Min</th>';
            echo '<th>Max</th>';
            echo '<th>Entered</th>';
            echo '</tr>';

            foreach ($collections as $c)
            {
                echo '<tr>';
                echo '<td>'.$c->ceno.'</td>';
                echo '<td>'.$c->cname.'</td>';
                echo '<td>'.$c->subcode.'</td>';
                echo '<td>'.$c->subname.'</td>';
                echo '<td>'.$c->term.'</td>';
                echo '<td>'.$c->subtype.'</td>';
                echo '<td>'.$c->imin.'</td>';
                echo '<td>'.$c->imax.'</td>';
                if(empty($c->imark))
                    echo '<td  style="color: red"><b>'.'0'.'</b></td>';
                else
                    echo '<td style="color: blue"><b>'.$c->imark.'</b></td>';
                echo '</td>';
                if($c->subtype == 'Theory')
                {
                    echo '<td colspan="3" style="color: red"><b>'.'Not Applicable'.'</b></td>';
                }
                else
                {
                    echo '<td>'.$c->emin.'</td>';
                    echo '<td>'.$c->emax.'</td>';
                    if(empty($c->emark))
                        echo '<td  style="color: red"><b>'.'0'.'</b></td>';
                    else
                        if($c->emark == 'Abs')
                            echo '<td  style="color: red"><b>'.'Absent'.'</b></td>';
                        else
                            echo '<td style="color: blue"><b>'.$c->emark.'</b></b></td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        }
        */

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


            $html .= '<div class="page-break">';
            $html .= '<table role="table" border="0" cellpadding="3" cellspacing="0" style="text-align: center" align="center">';
            $html .= '<tr>';
            $html .= '<td></td>';
            $html .= '<td>
                        <div class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</div><br>
                        (Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)<br>
                        <div class="h4-text">National Board of Examination in Rehabilitation (NBER)</div>
                        </td>';
            $html .= '</tr>';
            $html .= '</table>';

            $html .= '<p class="center-text blue-text h3-text">
                        <b>Online Theory Mark Entry Details for - '.$exam->name.' Examination</b>
                      </p>';
            $html .= '<hr /><br />';

            $html .= '<table role="table" border="1" cellpadding="3" cellspacing="0" align="center">';
            $html .= '<tbody>';
            $html .= '<tr>';
            $html .= '<td><div class="center-text">Institute Code<br>& Name</div></td>';
            $html .= '<td><div class="left-text"><b>'.$ap->institute->user->username.' - '.$ap->institute->name.'</b></div></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td><div class="center-text">Programme Code<br>& Name</div></td>';
            $html .= '<td><div><b>'.$ap->programme->course_name.' - '.$ap->programme->name.'</b></div></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td><div class="center-text">Batch</div></td>';
            $html .= '<td colspan="3">'.$ap->academicyear->year.'</td>';
            $html .= '</tr>';
            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '<br />';


            $html .= '<table role="table" border="2" cellpadding="3" cellspacing="0" align="center">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th rowspan="2"><div class="center-text">Sl. No.</div></th>';
            $html .= '<th rowspan="2"><div class="center-text">Enrolment<br>No</div></th>';
            $html .= '<th rowspan="2"><div class="center-text">Candidate Name</div></th>';
            $html .= '<th rowspan="2"><div class="center-text">Term</div></th>';
            //$html .= '<th rowspan="2">Type</th>';
            $html .= '<th rowspan="2"><div class="center-text">Subject<br>Code</div></th>';
            //$html .= '<th rowspan="2">Subject Name</th>';
            $html .= '<th colspan="3"><div class="center-text">Internal Mark</div></th>';
            //$html .= '<th colspan="3">External Mark</th>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<th><div class="center-text">Min</div></th>';
            $html .= '<th><div class="center-text">Max</div></th>';
            $html .= '<th><div class="center-text">Entered</div></th>';

            //$html .= '<th>Min</th>';
            //$html .= '<th>Max</th>';
            //$html .= '<th>Entered</th>';
            $html .= '</tr>';
            $html .= '</thead>';

            //Theory Marks
            $html .= '<tbody>';
            $slno = '1';
            foreach ($collections as $c)
            {
                //Display Theory Marks
                if($c->subtype == 'Theory') {
                    $html .= '<tr>';
                    $html .= '<td><div class="center-text blue-text">'.$slno.'</div></td>';
                    $html .= '<td><div class="blue-text">'.$c->ceno.'</div></td>';
                    $html .= '<td><div class="blue-text">'.$c->cname.'</div></td>';
                    $html .= '<td><div class="center-text blue-text">'.$c->term.'</div></td>';
                    //$html .= '<td><div class="center-text blue-text">'.$c->subtype.'</div></td>';
                    $html .= '<td><div class="center-text blue-text">'.$c->subcode.'</div></td>';
                    //$html .= '<td><span class="blue-text">'.$c->subname.'</span></td>';
                    $html .= '<td><div class="center-text blue-text">'.$c->imin.'</div></td>';
                    $html .= '<td><div class="center-text blue-text">'.$c->imax.'</div></td>';
                    if(empty($c->imark))
                        $html .= '<td><div class="center-text red-text"><b>'.'0'.'</b></div></td>';
                    else
                        if($c->imark == 'Abs')
                            $html .= '<td><div class="center-text red-text"><b>'.'Absent'.'</b></div></td>';
                        else
                            if($c->imin <= $c->imark && $c->imax >= $c->imark)
                                $html .= '<td><div class="center-text green-text"><b>'.$c->imark.'</b></div></td>';
                            else
                                $html .= '<td><div class="center-text red-text"><b>'.$c->imark.'</b></div></td>';
                    $html .= '</td>';
                    $slno++;

                    /*
                    if($c->subtype == 'Theory')
                    {
                        $html .= '<td colspan="3"><div class="center-text red-text"><b>'.'Not Applicable'.'</b></div></td>';
                    }
                    else
                    {
                        $html .= '<td><div class="center-text blue-text">'.$c->emin.'</div></td>';
                        $html .= '<td><div class="center-text blue-text">'.$c->emax.'</div></td>';
                        if(empty($c->emark))
                            $html .= '<td><div class="center-text red-text"><b>'.'0'.'</b></div></td>';
                        else
                            if($c->emark == 'Abs')
                                $html .= '<td><div class="center-text red-text"><b>'.'Absent'.'</b></div></td>';
                            else
                                if($c->emin <= $c->emark && $c->emax >= $c->emark)
                                    $html .= '<td><div class="center-text green-text"><b>'.$c->emark.'</b></div></td>';
                                else
                                    $html .= '<td><div class="center-text red-text"><b>'.$c->emark.'</b></div></td>';
                    }
                    */

                    $html .= '</tr>';
                }
                $html .= '</tbody>';
            }
            $html .= '</table>';
            $html .= '</div>';

            $html .= '<div class="page-break">';
            $html .= '<table role="table" border="0" cellpadding="3" cellspacing="0" style="text-align: center" align="center">';
            $html .= '<tr>';
            $html .= '<td></td>';
            $html .= '<td>
                        <div class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</div><br>
                        (Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)<br>
                        <div class="h4-text">National Board of Examination in Rehabilitation (NBER)</div>
                        </td>';
            $html .= '</tr>';
            $html .= '</table>';

            $html .= '<p class="center-text blue-text h3-text">
                        <b>Online Practical Mark Entry Details for - '.$exam->name.' Examination</b>
                      </p>';
            $html .= '<hr /><br />';

            $html .= '<table role="table" border="1" cellpadding="3" cellspacing="0" align="center">';
            $html .= '<tbody>';
            $html .= '<tr>';
            $html .= '<td><div class="center-text">Institute Code<br>& Name</div></td>';
            $html .= '<td><div class="left-text"><b>'.$ap->institute->user->username.' - '.$ap->institute->name.'</b></div></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td><div class="center-text">Programme Code<br>& Name</div></td>';
            $html .= '<td><div><b>'.$ap->programme->course_name.' - '.$ap->programme->name.'</b></div></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td><div class="center-text">Batch</div></td>';
            $html .= '<td colspan="3">'.$ap->academicyear->year.'</td>';
            $html .= '</tr>';
            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '<br />';

            /*
            $html .= '<div class="page-break">';
            $html .= '<table role="table" border="2" cellpadding="3" cellspacing="0" align="center">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th><div class="center-text">External Theory<div class="center-text"></th>';

            $html .= '<th>Sub Code:</th>';

            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<th>Min</th>';
            $html .= '<th>Max</th>';
            $html .= '<th>Entered</th>';
            $html .= '<th>Min</th>';
            $html .= '<th>Max</th>';
            $html .= '<th>Entered</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '</table>';
            $html .= '</div>';
            $html .= '<br>';
            */

            $html .= '<table role="table" border="2" cellpadding="3" cellspacing="0" align="center">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th rowspan="2"><div class="center-text">Sl. No.</div></th>';
            $html .= '<th rowspan="2"><div class="center-text">Enrolment<br>No</div></th>';
            $html .= '<th rowspan="2"><div class="center-text">Candidate Name</div></th>';
            $html .= '<th rowspan="2"><div class="center-text">Term</div></th>';
            //$html .= '<th rowspan="2">Type</th>';
            $html .= '<th rowspan="2"><div class="center-text">Subject<br>Code</div></th>';
            //$html .= '<th rowspan="2">Subject Name</th>';
            $html .= '<th colspan="3"><div class="center-text">Internal Mark</div></th>';
            $html .= '<th colspan="3"><div class="center-text">External Mark</div></th>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<th><div class="center-text">Min</div></th>';
            $html .= '<th><div class="center-text">Max</div></th>';
            $html .= '<th><div class="center-text">Entered</div></th>';
            $html .= '<th><div class="center-text">Min</div></th>';
            $html .= '<th><div class="center-text">Max</div></th>';
            $html .= '<th><div class="center-text">Entered</div></th>';
            $html .= '</tr>';
            $html .= '</thead>';

            //Practical Marks
            $html .= '<tbody>';
            $slno = '1';
            foreach ($collections as $c)
            {
                //Display Practical Marks
                if($c->subtype == 'Practical') {

                    $html .= '<tr>';
                    $html .= '<td><div class="center-text blue-text">'.$slno.'</div></td>';
                    $html .= '<td><div class="center-text blue-text">'.$c->ceno.'</div></td>';
                    $html .= '<td><div class="blue-text">'.$c->cname.'</div></td>';
                    $html .= '<td><div class="center-text blue-text">'.$c->term.'</div></td>';
                    //$html .= '<td><div class="center-text blue-text">'.$c->subtype.'</div></td>';
                    $html .= '<td><div class="center-text blue-text">'.$c->subcode.'</div></td>';
                    //$html .= '<td><span class="blue-text">'.$c->subname.'</span></td>';
                    $html .= '<td><div class="center-text blue-text">'.$c->imin.'</div></td>';
                    $html .= '<td><div class="center-text blue-text">'.$c->imax.'</div></td>';
                    if(empty($c->imark))
                        $html .= '<td><div class="center-text red-text"><b>'.'0'.'</b></div></td>';
                    else
                        if($c->imark == 'Abs')
                            $html .= '<td><div class="center-text red-text"><b>'.'Absent'.'</b></div></td>';
                        else
                            if($c->imin <= $c->imark && $c->imax >= $c->imark)
                                $html .= '<td><div class="center-text green-text"><b>'.$c->imark.'</b></div></td>';
                            else
                                $html .= '<td><div class="center-text red-text"><b>'.$c->imark.'</b></div></td>';
                    $html .= '</td>';
                    $html .= '<td><div class="center-text blue-text">'.$c->emin.'</div></td>';
                    $html .= '<td><div class="center-text blue-text">'.$c->emax.'</div></td>';
                    if(empty($c->emark))
                        $html .= '<td><div class="center-text red-text"><b>'.'0'.'</b></div></td>';
                    else
                        if($c->emark == 'Abs')
                            $html .= '<td><div class="center-text red-text"><b>'.'Absent'.'</b></div></td>';
                        else
                            if($c->emin <= $c->emark && $c->emax >= $c->emark)
                                $html .= '<td><div class="center-text green-text"><b>'.$c->emark.'</b></div></td>';
                            else
                                $html .= '<td><div class="center-text red-text"><b>'.$c->emark.'</b></div></td>';
                    $slno++;
                }

                $html .= '</tr>';
            }
            $html .= '</tbody>';
        }
        $html .= '</table>';
        $html .= '</div>';

        $html .= '</body>';
        $html .= '</html>';

        $pdf = PDF::setOptions(['isRemoteEnabled' => true])->loadHtml($html);
        //$pdf->setPaper('A4', 'landscape');
        return $pdf->download($ap->institute->user->username . '-' . $ap->programme->course_name . '-' . $ap->academicyear->year . '-Mark_Details.pdf');


    }
}