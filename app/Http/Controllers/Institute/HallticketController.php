<?php

namespace App\Http\Controllers\Institute;

use App\Externalexamcenter;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Externalexamcenterdetail;
use App\Candidate;
use App\Mark;
use App\Institute;
use App\Examtimetable;
use Auth;
use App\Application;
use App\Approvedprogramme;
use App\Exam;
use App\Attendance;
use Session;
use PDF;
use File;

class HallticketController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function practical($apid,$cid){
        $candidate = \App\Candidate::find($cid);
        $institute = \App\Institute::where('user_id',Auth::user()->id)->first();
        if($candidate->approvedprogramme->institute_id == $institute->id){
            $term = 0;
            if($candidate->approvedprogramme->academicyear_id == 9){
                $term=2;
            }
            if($candidate->approvedprogramme->academicyear_id == 10){
                $term = 1;
            }
            $subjects = \App\Subject::where('programme_id',$candidate->approvedprogramme->programme_id)->where('subjecttype_id',2)->where('syear',$term)->get();
            $nber = \App\Nber::find($candidate->approvedprogramme->programme->nber_id);
            return view('institute.practicalhallticket',compact('candidate','subjects','nber','institute'));
        }else{
            return back();
        }
    }

    public function index($id,$exam_id,$term){
        //return 'Closed';
        $ap = Approvedprogramme::with('candidates')->find($id);

        if($ap){
            if($ap->institute->user_id==Auth::user()->id){




    $candidates = Candidate::where('approvedprogramme_id', $ap->id)
    ->leftJoin('attendances', function ($join) use ($exam_id, $term) {
        $join->on('candidates.id', '=', 'attendances.candidate_id')
             ->where('attendances.exam_id', '=', $exam_id)
             ->where('attendances.term', '=', $term);
    })
    ->where('candidates.status_id', '!=', 9)
    ->whereNotNull('candidates.enrolmentno')
    ->select('candidates.*', 'attendances.*')
    ->get();


    // print_r($candidates[0]);
    // die();
    //$exam = Exam::find($exam_id);
                return view('institute.halltickets.index',compact('ap','exam_id','id','term','candidates'));
            }else{
                return redirect('/');
            }
        }
        else{
            return redirect('/');
        }
    }

    public function uploadattendance(Request $request){
        //return 'Closed';
        $ap = Approvedprogramme::find($request->approvedprogramme_id);
        $exam_id = $request->exam_id;
        $rules = [
            'document_t' => 'required',
            'document_p' => 'required',
            'term' => 'required',
        ];
        $this->validate($request, $rules);
        $file_t = $request->document_t;
        $file_p = $request->document_p;

                
        if(!($file_t->isValid()) or !($file_p->isValid()) ){
            Session::put('error','Failed to Upload');
            return back();
        }else{
            $ex = explode('.', $path = $request->document_t->getClientOriginalName());
            $extn = end($ex);
            $filename_t = $ap->id.'_exam_'.$exam_id.'_theory'.$request->term.'.' . $extn ;
            move_uploaded_file($file_t,'files/attendance/'.$filename_t);
            $ex = explode('.', $path = $request->document_p->getClientOriginalName());
            $extn = end($ex);
            $filename_p = $ap->id.'_exam_'.$exam_id.'_practical'.$request->term.'.'.$extn ;
            move_uploaded_file($file_p,'files/attendance/'.$filename_p);
        }
        foreach($ap->candidates as $c){

            $attendance = Attendance::where('candidate_id',$c->id)->where('exam_id',$exam_id)->where('term',$request->term);
            if($attendance->count()>0){
                $attendance = $attendance->first();
              //  if($attendance->id > 267362 || $attendance->enable_edit == 1){
                    $attendance->update([
                        // 'attendance_t'=>$request->attendance_t,
                        // 'attendance_p'=>$request->attendance_p,
                        //  'exemption'=>'1',
                        'document_t'=>$filename_t,
                        'document_p'=>$filename_p,
                        'term'=>$request->term,
                        
                        //   'document_exemption'=>$de
                    ]);
               // }else{
               //     Session::put('messages','Already uploaded, could not modify');
               //     return back();
               // }
            }else{

                Attendance::create([
                    'candidate_id'=>$c->id,
                    'exam_id'=>$exam_id,
                    //'attendance_t'=>$request->attendance_t,
                    //'attendance_p'=>$request->attendance_p,
                    'exemption'=>'0',
                    'document_t'=>$filename_t,
                    'document_p'=>$filename_p,
                    'term'=>$request->term,

                    //  'document_exemption'=>$de
                ]);
            }
        }
        Session::put('messages','Uploaded');
        return back();
    }

    public function attendance(Request $request){
        //return 'Closed';
        $rules = [
            'attendance_t' => 'required',
            'attendance_p' => 'required',
        ];
        $this->validate($request, $rules);
        if($request->attendance_t=='' or $request->attendance_p=='' ){
            Session::put('error','Attendance required');
            return back();
        }

      //  $docex  = $request->document_exemption;
        //if($docex){
          //  if($docex->isValid()){
            //    $ex = explode('.', $path = $request->document_exemption->getClientOriginalName());
              //  $extn = end($ex);
               // $de = 'exam_'.$request->exam_id.'_exemption_candidate_'. $request->candidate_id. "." . $extn ;
               // move_uploaded_file($docex,'files/attendance/'.$de);
           // }else{
             //   $de = null;
           // }
        //}else{
            $de = null;
        //}
        $exam_id = $request->exam_id;
        /*
        $file_t = $request->document_t;
        $file_p = $request->document_p;
        if(!($file_t->isValid()) or !($file_p->isValid()) ){
            Session::put('error','Failed to Upload');
            return back();
        }else{
            $ex = explode('.', $path = $request->document_t->getClientOriginalName());
            $extn = end($ex);
            $filename_t = 'exam_2_candidate_'. $request->candidate_id. "_theory." . $extn ;
            move_uploaded_file($file_t,'files/attendance/'.$filename_t);

            $ex = explode('.', $path = $request->document_p->getClientOriginalName());
            $extn = end($ex);
            $filename_p = 'exam_2_candidate_'. $request->candidate_id. "_practical." . $extn ;
            move_uploaded_file($file_p,'files/attendance/'.$filename_p);


            //if($request->has('document_exemption')){

            //}else{
            //    $de = null;
            //}
        }*/
        $attendance = Attendance::where('candidate_id',$request->candidate_id)->where('exam_id',$exam_id)->where('term',$request->term);
        if($attendance->count()>0){
            $attendance = $attendance->first();
            // if($attendance->id > 267362 || $attendance->enable_edit == 1){
                $attendance->update([
                    'attendance_t'=>$request->attendance_t,
                    'attendance_p'=>$request->attendance_p,
                    'exemption'=>'0',
                    //        'document_t'=>$filename_t,
                    //      'document_p'=>$filename_p,
                    'document_exemption'=>$de
                ]);
            // }
        }else{
            Attendance::create([
                'candidate_id'=>$request->candidate_id,
                'exam_id'=>$exam_id,
                'attendance_t'=>$request->attendance_t,
                'attendance_p'=>$request->attendance_p,
                'exemption'=>'0',
                //    'document_t'=>$filename_t,
                //  'document_p'=>$filename_p,
                'document_exemption'=>$de
            ]);
        }
        Session::put('messages','Uploaded');
        return back();
    }
    public function download1(Request $request){
        return 'Closed';
        $candidate = Candidate::find($request->id);
        $exam_id = $request->exam_id;
        //return $candidate->attendances->where('exam_id','2')->count();
        if(Auth::user()->id==$candidate->approvedprogramme->institute->user_id){
            //$application = Application::find($request->application_id);
            if($candidate->attendances){
                if($candidate->attendances->where('exam_id',$exam_id)->count()<1){
                    return 'invalid url';
                }else{
                    if($candidate->attendances->where('exam_id',$exam_id)->first()->attendance_t < 75){
                        if($candidate->attendances->where('exam_id',$exam_id)->first()->exemption != 2){
                            return 'invalid url';
                        }
                    }
                }
            }else{
                return 'invalid url';

            }

            $exam = Exam::find($exam_id);
            $date = \Carbon\Carbon::parse($candidate->dob);
            $dob =  $date->toFormattedDateString();

            $applications = Application::where('exam_id',$exam_id)->whereHas('subject', function($query) use ($exam_id){
                $query->whereHas('examtimetables', function($r) use($exam_id){
                    $r->where('exam_id',$exam_id);
                });
            })->where('candidate_id',$candidate->id)->with('subject')->get();
            $count = 1;
            $table  = '';

            $applications->map(function ($appn) use($exam_id){
                $startdate = $appn->subject->startdate($exam_id);
                $appn['startdate'] = $startdate;
                return $appn;
            });

            foreach($applications->sortBy('startdate') as $a){
                $startdate = $a->subject->startdate($exam_id);
                if($startdate!=''){
                    $startdatetime = \Carbon\Carbon::parse($startdate)->toFormattedDateString() . '<br />'.  \Carbon\Carbon::parse($startdate)->format('h:i A') . ' to ';
                }else{
                    $startdatetime = '';
                }
                $enddate  = $a->subject->enddate($exam_id);
                if($enddate!=''){
                    $endtime = \Carbon\Carbon::parse($enddate)->format('h:i A');
                }else{
                    $endtime ='';
                }
                $table .= '<tr><td>'.$count.'</td><td align="left">'.$a->subject->scode.'</td><td width="300px" align="left">'. $a->subject->sname.'</td><td align="left">'. $startdatetime . $endtime .'</td><td></td></tr>';
                $count +=1;
            }


            $html = '<style> html{margin:25px;} </style>
            <body style="margin:0px;">
            <table border="1" style="border-collapse:collapse; font-size:14px;" cellpadding="0" cellspacing="0" width="100%" bordercolor="#000000">
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="center" width="110">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td><br><img src="'. public_path() . '/images/hallticket/niepmd.png" width="70"  style ="padding-left:5px;" height="90"></td>
                                        </tr>
                                    </table>
                                </td>
                                <td align="center">
                                    <b><font size="2">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</font></b><br>
                                    <font size="1">(DEPwD, MSJE, GoI)</font><br>
									<b><font size="2">National Board of Examination in Rehabilitation</font></b><br>
									<font size="1">                                    
                                    East Coast Road, Muttukadu, Kovalam, P.O, Chennai-603 112, Tamil Nadu.<br>
                                    NBER-RCI, Fax: 044-27472389 Tel: 044-27472104, 27472113, 27472046 / Extn: 492<br>
                                    Website: www.niepmd.tn.nic.in &nbsp;&nbsp;&nbsp;Email: niepmd.examinations@gmail.com
									</font>                         
                                </td>
                                <td width="110" align="center">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td valign="top">
                                                <b><u><font face="Calibri" size="2">CANDIDATE\'S < br>COPY </font ></u ></b >
                                            </td >
                                        </tr>
                                        <tr>
                                            <td><br><img src="'. public_path() . '/images/hallticket/rci.png" width="72" height="90"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr height="8">
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center" style="line-height:1.2em;">
                                    <b><font size="3">EXAMINATION '. $exam->name .'</font></b><br>
                                    <b><font size="2">HALL - TICKET</font></b>
                                </td>
                            </tr>
                            <tr height="8">
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table border="0" cellpadding="10" cellspacing="0" width="96%" style="font-size:12px;">
                                        <tr>
                                            <td width="80%">
                                                <!-- <b>S.No. 17</b> --><br>
                                                <table border="0" cellpadding="1" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#000000">
                                                    <tr style="height:40px;">
                                                        <td width="33%">&nbsp;<b>Enrollment Number</b></td>
                                                        <td width="33%">&nbsp;<b>'. $candidate->enrolmentno .'</b></td>
                                                        <td>&nbsp;<b>Programme: '. $candidate->approvedprogramme->programme->course_name .'</b></td>
                                                    </tr>
                                                    <tr style="height:40px;">
                                                        <td>&nbsp;<b>Name of the Candidate</b></td>
                                                        
                                                        <td colspan="2">&nbsp;'. $candidate->name .'</td>
                                                    </tr>
                                                    <tr style="height:40px;">
                                                        <td>&nbsp;<b>Fathers Name</b></td>
                                                        
                                                        <td>&nbsp;'. $candidate->fathername .'</td><td>
                                                        DOB: '. $dob .'
                                                        </td>
                                                    </tr>
                                                    <tr style="height:40px;">
                                                        <td>&nbsp;<b>Name of the Institute</b></td>
                                                        <td colspan="2">&nbsp;'. $candidate->approvedprogramme->institute->name .'</td>
                                                    </tr>
                                                    <tr style="height:100px;">
                                                        <td style="vertical-align:top;">&nbsp;<b>Examination Center</b></td>
                                                        <td colspan="2">&nbsp;'. $candidate->approvedprogramme->institute->examcenter($exam_id)->name. '<br />'. $candidate->approvedprogramme->institute->examcenter($exam_id)->address .' '. $candidate->approvedprogramme->institute->examcenter($exam_id)->pincode .'</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td align="center">
                                                <br>
                                                <table border="0" cellpadding="0" cellspacing="0" width="110" height="120" style="border-collapse:collapse;" bordercolor="#000000">
                                                    <tr>
                                                        <td align="center"><img src="'. public_path() . '/files/enrolment/photos/' . $candidate->photo .'" width="110" height="120"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <table border="1" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#000000">
                                                    <tr>
                                                        <td style="height:60px;">&nbsp;Signature of the Candidate</td>
                                                        <td width="180px;">&nbsp;</td>
                                                        <td style="padding:5px;">Counter Signature of the Centre Co-ordinator With Institute Seal</td>
                                                        <td width="180px">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="right">
                                        <img src="'. public_path() . '/images/hallticket/adce_sign.png"  height="38" alt="DCE Signature"><br>
                                        <b>ADCE, NBER-NIEPMD</b>
                                    </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>    
                    </td>
                </tr>
            </table>
    <br>
    <br>
    <br>
    <!-- ==================================================== Examination Centre Copy ==================================================== -->
    <table border="1" style="border-collapse:collapse; font-size:14px;" cellpadding="0" cellspacing="0" width="100%" bordercolor="#000000">
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center" width="110">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><br><img src="'. public_path() . '/images/hallticket/niepmd.png" width="70" height="90" style="padding-left:5px;"></td>
                                </tr>
                            </table>
                        </td>
                        <td align="center">
                            <b><font size="2">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</font></b><br>
                                    <font size="1">(DEPwD, MSJE, GoI)</font><br>
									<b><font size="2">National Board of Examination in Rehabilitation</font></b><br>
									<font size="1">
                                    Examination Conducted by:<br>
                                    East Coast Road, Muttukadu, Kovalam, P.O, Chennai-603 112, Tamil Nadu.<br>
                                    NBER-RCI, Fax: 044-27472389 Tel: 044-27472104, 27472113, 27472046 / Extn: 492<br>
                                    Website: www.niepmd.tn.nic.in &nbsp;&nbsp;&nbsp;Email: niepmd.examinations@gmail.com
									</font>                      
                        </td>
                        <td width="110" align="center">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td valign="top">
                                        <b><u><font face="Calibri" size="2">EXAMINATION<br>CENTRE COPY</font></u></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td><br><img src="'. public_path() . '/images/hallticket/rci.png" width="72" height="90"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr height="8">
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center" style="line-height:1.2em;">
                            <b><font size="3">EXAMINATION '. $exam->name .'</font></b><br>
                            <b><font size="2">HALL - TICKET</font></b>
                        </td>
                    </tr>
                    <tr height="8">
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table border="0" cellpadding="10" cellspacing="0" width="96%" style="font-size:12px;">
                                <tr>
                                    <td width="80%">
                                        <!-- <b>S.No. 17</b> --><br>
                                        <table border="0" cellpadding="1" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#000000">
                                            <tr style="height:40px;">
                                                <td width="33%">&nbsp;<b>Enrollment Number</b></td>
                                                <td width="33%">&nbsp;<b>'. $candidate->enrolmentno .'</b></td>
                                                <td>&nbsp;<b>Programme: '. $candidate->approvedprogramme->programme->course_name .'</b></td>
                                            </tr>
                                            <tr style="height:40px;">
                                                <td>&nbsp;<b>Name of the Candidate</b></td>
                                                <td colspan="2">&nbsp;'. $candidate->name .'</td>
                                            </tr>
                                            <tr style="height:40px;">
                                                        <td>&nbsp;<b>Fathers Name</b></td>
                                                        
                                                        <td>&nbsp;'. $candidate->fathername .'</td><td>
                                                        DOB: '. $dob .'
                                                        </td>
                                                    </tr>
                                                    <tr style="height:40px;">
                                                        <td>&nbsp;<b>Name of the Institute</b></td>
                                                        <td colspan="2">&nbsp;'. $candidate->approvedprogramme->institute->name .'</td>
                                                    </tr>
                                                    <tr style="height:100px;">
                                                        <td style="vertical-align:top;">&nbsp;<b>Examination Center</b></td>
                                                        <td colspan="2">&nbsp;'. $candidate->approvedprogramme->institute->examcenter($exam_id)->name . '<br />'. $candidate->approvedprogramme->institute->examcenter($exam_id)->address .' '. $candidate->approvedprogramme->institute->examcenter($exam_id)->pincode .'</td>
                                                    </tr>

                                        </table>
                                    </td>
                                    <td align="center">
                                                <br>
                                                <table border="0" cellpadding="0" cellspacing="0" width="110" height="120" style="border-collapse:collapse;" bordercolor="#000000">
                                                    <tr>
                                                        <td align="center"><img src="'. public_path() . '/files/enrolment/photos/' . $candidate->photo .'" width="110" height="120"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table border="1" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#000000">
                                            <tr>
                                                        <td style="height:60px;">&nbsp;Signature of the Candidate</td>
                                                        <td width="180px;">&nbsp;</td>
                                                        <td style="padding:5px;">Counter Signature of the Centre Co-ordinator With Institute Seal</td>
                                                        <td width="180px">&nbsp;</td>
                                                    </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right">
                                        <img src="'. public_path() . '/images/hallticket/adce_sign.png"  height="38" alt="DCE Signature"><br>
                                        <b>ADCE, NBER-NIEPMD</b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>    
            </td>
        </tr>
    </table>
    <table border="0" style="border-collapse:collapse;" cellpadding="0" cellspacing="0" width="90%" height="100%" bordercolor="#000000">
                    <tr style="align:center;">
                        <td colspan="2" width="100" style="font-size:16px;">
                            <br>
                            <center>THEORY</center>
                            </br>
                            <table border="1" cellpadding="8" cellspacing="0" width="90%" style="border-collapse:collapse;" bordercolor="#000000">
                                <tr height="40px">
                                    <th width="20px">Sl. No.</th>
                                    <th width="50px">Course Code</th>
                                    <th width="300px">Course Name</th>
                                    <th width="150px">Exam Date and time</th>
                                    <th width="170px">Signature of the Candidate with date<br>(to be signed at the time of appearing for each examination)
                                </tr>
                                '.$table.'
                            </table>
                <p><center>..2</center></p>
            </td>
        </tr>
    </table>
            
            </body>';
            //$html = '<img src="'. public_path() . '/images/hallticket/niepmd.png" width="70" height="90"> </img>';
            //return $html;

            //return $pdf->stream();
            $pdf = PDF::setOptions(['isRemoteEnabled' => true])->loadHtml($html);

            return $pdf->download($candidate->enrolmentno.'.pdf');
            //echo $html;
        }
    }

    public function download(Request $request){
        return 'Closed';
        $candidate = Candidate::find($request->id);
        $exam_id = $request->exam_id;
        //return $candidate->attendances->where('exam_id','2')->count();
        if(Auth::user()->id==$candidate->approvedprogramme->institute->user_id) {
            //$application = Application::find($request->application_id);
            if ($candidate->attendances) {
                if ($candidate->attendances->where('exam_id', $exam_id)->count() < 1) {
                    return 'invalid url';
                } else {
                    if ($candidate->attendances->where('exam_id', $exam_id)->first()->attendance_t < 75) {
                        if ($candidate->attendances->where('exam_id', $exam_id)->first()->exemption != 2) {
                            return 'invalid url';
                        }
                    }
                }
            } else {
                return 'invalid url';

            }

            $exam = Exam::find($exam_id);
            $date = \Carbon\Carbon::parse($candidate->dob);
            $dob = $date->toFormattedDateString();

            $applications = Application::where('exam_id', $exam_id)->whereHas('subject', function ($query) use ($exam_id) {
                $query->whereHas('examtimetables', function ($r) use ($exam_id) {
                    $r->where('exam_id', $exam_id);
                });
            })->where('candidate_id', $candidate->id)->with('subject')->get();
            $count = 1;
            $table = '';

            $applications->map(function ($appn) use ($exam_id) {
                $startdate = $appn->subject->startdate($exam_id);
                $appn['startdate'] = $startdate;
                return $appn;
            });

            foreach ($applications->sortBy('startdate') as $a) {
                $startdate = $a->subject->startdate($exam_id);
                if ($startdate != '') {
                    $startdatetime = \Carbon\Carbon::parse($startdate)->toFormattedDateString() . '<br />' . \Carbon\Carbon::parse($startdate)->format('h:i A') . ' to ';
                } else {
                    $startdatetime = '';
                }
                $enddate = $a->subject->enddate($exam_id);
                if ($enddate != '') {
                    $endtime = \Carbon\Carbon::parse($enddate)->format('h:i A');
                } else {
                    $endtime = '';
                }
                $table .= '<tr><td>' . $count . '</td><td align="left">' . $a->subject->scode . '</td><td width="300px" align="left">' . $a->subject->sname . '</td><td align="left">' . $startdatetime . $endtime . '</td><td></td></tr>';
                $count += 1;
            }

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
                                .h5-text {
                                    font-size: 15px;
                                    font-weight: bold;
                                }
                                .h6-text {
                                    font-size: 13px;                                    
                                }
                                .h7-text {
                                    font-size: 12px;                                    
                                }
                                .h8-text {
                                    font-size: 10px;
                                }
                                .left-text{
                                    text-align: left !important;
                                }
                                .right-text{
                                    text-align: right !important;
                                }
                                .center-text{
                                    text-align: center !important;
                                }
                                
                            </style>
                        </head>
                        <body>  
                    ';

            //Page-1
            //Candidates' Copy
            $html .= '<div class="page-break">';
            $html .= '<table role="table" border="1" cellpadding="3" cellspacing="0" align="center">';
            $html .= '<tbody>';
            $html .= '<tr>';
            $html .= '<td>';

            $html .= '<table role="table" border="0" cellpadding="3" cellspacing="0" align="center">';
            $html .= '<tbody>';
            $html .= '<tr>';
            $html .= '<td colspan="3">
                        <div class="right-text h6-text">
                            <b><u>CANDIDATE\'S COPY</u></b>
                        </div>
                      </td>';
            $html .= '</tr>';
            $html .= '</tbody>';
            $html .= '</table>';

            $html .= '<table role="table" border="0" cellpadding="3" cellspacing="0" align="center">';
            $html .= '<tbody>';
            $html .= '<tr>';
            $html .= '<td>
                        <img src="'. public_path() . '/images/hallticket/niepmd.png" width="60" height="60">
                      </td>';
            $html .= '<td>
                        <div class="center-text">
                        <span class="h5-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                        <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                        <span class="h5-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                        <span class="h8-text">
                            East Coast Road, Muttukadu, Kovalam, P.O, Chennai-603 112, Tamil Nadu.<br>
                        </span>
                        </div>
                       </td>';
            $html .= '<td align="right">
                        <img src="'. public_path() . '/images/hallticket/rci.png" width="50" height="50">
                      </td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td colspan="3">
                        <div class="center-text"><b>HALL  TICKET - '.$exam->name.' Examination</b></div>
                      </td>';
            $html .= '</tr>';
            $html .= '</tbody>';
            $html .= '</table>';

            $html .= '<div class="h7-text">';
            $html .= '<table role="table" border="0" cellpadding="3" cellspacing="0" align="center">';
            $html .= '<tbody>';
            $html .= '<tr>';
            $html .= '<td width="25%">Enrolment Number : <b>'.$candidate->enrolmentno.'</b></td>';
            $html .= '<td>Candidate Name : <b>'.$candidate->name.'</b></td>';
            $html .= '<td width="20%" rowspan="5"> 
                        <img src="'. public_path() . '/files/enrolment/photos/' . $candidate->photo .'" width="110" height="120">
                      </td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td width="25%">Programme : <b>'.$candidate->approvedprogramme->programme->course_name.'</b></td>';
            $html .= '<td>DOB : <b>'.$dob.'</b></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td width="25%">Father\'s Name : <b>'.$candidate->fathername.'</b></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td width="20%">Name of the Institute :</td>';
            $html .= '<td>'.$candidate->approvedprogramme->institute->name.'</td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td width="20%">Examination Center :</td>';
            $html .= '<td>'.$candidate->approvedprogramme->institute->examcenter($exam_id)->name.', '.
                $candidate->approvedprogramme->institute->examcenter($exam_id)->address .' - '.
                $candidate->approvedprogramme->institute->examcenter($exam_id)->pincode .' Phone No.: '.
                $candidate->approvedprogramme->institute->examcenter($exam_id)->contactnumber1.'</td>';
            $html .= '</tr>';
            $html .= '</tbody>';
            $html .= '</table>';

            $html .= '<br>';

            $html .= '<table role="table" border="1" cellpadding="3" cellspacing="0" align="center" width="95%">';
            $html .= '<tbody>
                        <tr>
                        <td width="50%" height="3%">Signature of the Candidate</td>
                        <td width="50%" height="3%"></td>
                        <td width="50%" height="3%">Counter Signature of the Centre Coordinator With Institute Seal</td>
                        <td width="50%" height="3%"></td>
                        </tr>
                      </tbody>';
            $html .= '</table>';

            $html .= '<table role="table" border="0" cellpadding="3" cellspacing="0" align="center" width="100%">';
            $html .= '<tbody>
                        <tr>
                        <td>
                            <div class="right-text">
                               <img src="'. public_path() . '/images/hallticket/adce_sign.png" width="40" 
                                    height="40" alt="ADCE Signature" style="margin-right: 30px"><br>
                               <b>ADCE, NIEPMD-NBER</b> 
                            </div>
                        </td>                        
                        </tr>
                      </tbody>';
            $html .= '</table>';
            $html .= '</div>';

            $html .= '</td>';
            $html .= '</tr>';
            $html .= '</tbody>';
            $html .= '</table>';

            $html .= '<br>';

            $html .= '<table role="table" border="1" cellpadding="3" cellspacing="0" align="center">';
            $html .= '<tbody>';
            $html .= '<tr>';
            $html .= '<td>';

            $html .= '<table role="table" border="0" cellpadding="3" cellspacing="0" align="center">';
            $html .= '<tbody>';
            $html .= '<tr>';
            $html .= '<td colspan="3">
                        <div class="right-text h6-text">
                            <b><u>EXAMINATION CENTER\'S COPY</u></b>
                        </div>
                      </td>';
            $html .= '</tr>';
            $html .= '</tbody>';
            $html .= '</table>';

            $html .= '<table role="table" border="0" cellpadding="3" cellspacing="0" align="center">';
            $html .= '<tbody>';
            $html .= '<tr>';
            $html .= '<td>
                        <img src="'. public_path() . '/images/hallticket/niepmd.png" width="60" height="60">
                      </td>';
            $html .= '<td>
                        <div class="center-text">
                        <span class="h5-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                        <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                        <span class="h5-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                        <span class="h8-text">
                            East Coast Road, Muttukadu, Kovalam, P.O, Chennai-603 112, Tamil Nadu.<br>
                        </span>
                        </div>
                       </td>';
            $html .= '<td align="right">
                        <img src="'. public_path() . '/images/hallticket/rci.png" width="50" height="50">
                      </td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td colspan="3">
                        <div class="center-text"><b>HALL  TICKET - '.$exam->name.' Examination</b></div>
                      </td>';
            $html .= '</tr>';
            $html .= '</tbody>';
            $html .= '</table>';

            $html .= '<div class="h7-text">';
            $html .= '<table role="table" border="0" cellpadding="3" cellspacing="0" align="center">';
            $html .= '<tbody>';
            $html .= '<tr>';
            $html .= '<td width="25%">Enrolment Number : <b>'.$candidate->enrolmentno.'</b></td>';
            $html .= '<td>Candidate Name : <b>'.$candidate->name.'</b></td>';
            $html .= '<td width="20%" rowspan="5"> 
                        <img src="'. public_path() . '/files/enrolment/photos/' . $candidate->photo .'" width="110" height="120">
                      </td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td width="25%">Programme : <b>'.$candidate->approvedprogramme->programme->course_name.'</b></td>';
            $html .= '<td>DOB : <b>'.$dob.'</b></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td width="25%">Father\'s Name : <b>'.$candidate->fathername.'</b></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td width="20%">Name of the Institute :</td>';
            $html .= '<td>'.$candidate->approvedprogramme->institute->name.'</td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td width="20%">Examination Center :</td>';
            $html .= '<td>'.$candidate->approvedprogramme->institute->examcenter($exam_id)->name.', '.
                $candidate->approvedprogramme->institute->examcenter($exam_id)->address .' - '.
                $candidate->approvedprogramme->institute->examcenter($exam_id)->pincode .' Phone No.: '.
                $candidate->approvedprogramme->institute->examcenter($exam_id)->contactnumber1.'</td>';
            $html .= '</tr>';
            $html .= '</tbody>';
            $html .= '</table>';

            $html .= '<br>';

            $html .= '<table role="table" border="1" cellpadding="3" cellspacing="0" align="center" width="95%">';
            $html .= '<tbody>
                        <tr>
                        <td width="50%" height="3%">Signature of the Candidate</td>
                        <td width="50%" height="3%"></td>
                        <td width="50%" height="3%">Counter Signature of the Centre Coordinator With Institute Seal</td>
                        <td width="50%" height="3%"></td>
                        </tr>
                      </tbody>';
            $html .= '</table>';

            $html .= '<table role="table" border="0" cellpadding="3" cellspacing="0" align="center" width="100%">';
            $html .= '<tbody>
                        <tr>
                        <td>
                            <div class="right-text">
                               <img src="'. public_path() . '/images/hallticket/adce_sign.png" width="40" 
                                    height="40" alt="ADCE Signature" style="margin-right: 30px"><br>
                               <b>ADCE, NIEPMD-NBER</b> 
                            </div>
                        </td>                        
                        </tr>
                      </tbody>';
            $html .= '</table>';
            $html .= '</div>';

            $html .= '</td>';
            $html .= '</tr>';
            $html .= '</tbody>';
            $html .= '</table>';

            $html .= '</td>';
            $html .= '</tr>';
            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '</div>';

            //Page-2
            $html .= '<div class="page-break">';
            $html .= '<table role="table" border="1" cellpadding="3" cellspacing="0" align="center">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th width="20px">Sl. No.</th>';
            $html .= '<th width="50px">Course Code</th>';
            $html .= '<th width="300px">Course Name</th>';
            $html .= '<th width="150px">Exam Date and time</th>';
            $html .= '<th width="170px">Signature of the Candidate with date<br>(to be signed at the time of appearing for each examination)</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            $html .= $table;
            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '</div>';

            //echo $html;

            $pdf = PDF::setOptions(['isRemoteEnabled' => true])->loadHtml($html);
            //$pdf->setPaper('A4', 'landscape');
            return $pdf->download($candidate->enrolmentno . '-Hallticket.pdf');

        }
    }

    public function showCandidatesList($e_id, $ap_id) {
        $exam = Exam::find($e_id);

        if(!is_null($exam)) {
            $title = $exam->name.' Examinations';

            $approvedprogramme = Approvedprogramme::find($ap_id);

            if(!is_null($approvedprogramme)) {
                if($approvedprogramme->institute->user_id==Auth::user()->id){
                    $applications = Application::where('approvedprogramme_id', $approvedprogramme->id)
                        ->where('exam_id', $exam->id)
                        ->groupBy('candidate_id')
                        ->whereHas('subject', function ($query){
                            $query->where('subjecttype_id', '1');
                        })
                        ->get(['id', 'candidate_id', 'externalexamcenter_id', 'internalresult_id', 'payment_status']);
                    
                    $applicationIds = $applications->unique('id')->pluck('id')->toArray();

                    $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();

                    $candidates = Candidate::whereIn('id', $candidate_ids)->orderBy('enrolmentno')->get(['id', 'name', 'enrolmentno', 'approvedprogramme_id', 'photo']);
                    unset($candidate_ids);

                    if($exam->id == '20' || $exam->id == '21') {
                        return view('institute.examhalltickets.january2023examinations.show_candidate_lists', compact('exam', 'title', 'approvedprogramme', 'applications', 'candidates', 'externalexamcenters'));
                    }

                    if($exam->id == "18" || $exam->id == "19") {
                        return view('institute.examhalltickets.july2022examinations.show_candidate_lists', compact('exam', 'title', 'approvedprogramme', 'applications', 'candidates', 'externalexamcenters'));
                    }

                    if($exam->id == "17") {
                        return view('institute.examhalltickets.november2021examinations.sample', compact('exam', 'title', 'approvedprogramme', 'applications', 'candidates', 'externalexamcenters'));
                    }

                    if($exam->id == "16") {
                        return view('institute.examhalltickets.august1styear2021examinations.sample', compact('exam', 'title', 'approvedprogramme', 'applications', 'candidates', 'externalexamcenters'));
                    }
                    if($exam->id == "15") {
                        return view('institute.examhalltickets.august2021examinations.sample', compact('exam', 'title', 'approvedprogramme', 'applications', 'candidates', 'externalexamcenters'));
                    }
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
                return redirect('/institute/examinations');
            }
        }
        else {
            unset($exam);
            return redirect('/institute/examinations');
        }

        /*
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

        $examcenter = Externalexamcenterdetail::where('exam_id', $exam->id)->where('institute_id', $approvedprogramme->institute->id)->first();

        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')->orderBy('enrolmentno')->get();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        echo $examcenter;
        return view('institute.examhalltickets.viewcandidateslist', compact('exam', 'approvedprogramme', 'applications', 'candidates', 'marks', 'examcenter'));
        */
    }

    public function dlnewhallticket($cid){
        return 'Closed';
        
        $candidate = Candidate::find($cid);
        if($candidate->enrolmentno =='' || $candidate->enrolmentno == null ){
            return 'Enrolment number not found, Please contact NBER.';
        }else{
            if(file_exists(public_path().'/files/enrolment/photos/'.$candidate->photo)){
                if($candidate->applications->count()>0){
                    $institute = Institute::where('user_id',Auth::user()->id)->first();
                    return view('institute.examhalltickets.dlnewhallticket',compact('candidate','institute'));
                }else{
                    return 'No exam applications found, Please click on Exam applications link on the previous page to apply for the examination.';
                }
            }else{
                return 'Please upload the photo by clicking on "Change File" button from the candidate list to download the hallticket. ';
            }
        }
    }
    public function newhallticket($cid){

        return 'Closed';
        $candidate = Candidate::find($cid);
        if($candidate->enrolmentno =='' || $candidate->enrolmentno == null ){
            return 'Enrolment number not found, Please contact NBER.';
        }else{
            if(file_exists(public_path().'/files/enrolment/photos/'.$candidate->photo)){
                if($candidate->applications->count()>0){
                    $institute = Institute::where('user_id',Auth::user()->id)->first();
                    return view('institute.examhalltickets.newhallticket',compact('candidate','institute'));
                }else{
                    return 'No exam applications found, Please click on Exam applications link on the previous page to apply for the examination.';
                }
            }else{
                return 'Please upload the photo by clicking on "Change File" button from the candidate list to download the hallticket. ';
            }
        }
    }
    public function downloadCandidateHallticket($eid, $candid) {
        return 'Closed';
        $exam = Exam::find($eid);

        if(!is_null($exam)) {
            $candidate = Candidate::find($candid);

            if(!is_null($candidate)) {
                $title = $exam->name.' Examinations';

                $applications = Application::select('applications.*')
                    ->join("subjects", "subjects.id", "=", "applications.subject_id")
                    ->join("candidates", "candidates.id", "=", "applications.candidate_id")
                    ->join("examtimetables", "examtimetables.subject_id", "=", "applications.subject_id")
                    ->join("marks", "marks.application_id", "=", "applications.id")
                    ->where('applications.exam_id', $exam->id)->where('applications.candidate_id', $candidate->id)
                    ->where('examtimetables.exam_id', $exam->id)
                    ->where('subjects.subjecttype_id', '=', 1)
                    ->where('applications.hallticket_status', 1)
                    ->where('applications.payment_status', 'Approved')
                    ->where('applications.internalresult_id', 1)
                    ->whereNotNull('candidates.enrolmentno')
                    ->orderBy('examtimetables.startdate')->get();

                $externalexamcenter = $applications->unique('externalexamcenter_id')->map(function ($query) {
                    return $query->externalexamcenter;
                })->first();



                /*
                $applications = Application::where('candidate_id', $candidate->id)
                    ->where('exam_id', $exam->id)
                    ->where('hallticket_status', '1')
                    ->whereHas('subject', function ($query){
                        $query->where('subjecttype_id', '1');
                    })
                    ->get(['candidate_id', 'externalexamcenter_id', 'subject_id', 'examtimetable_id']);

                $externalexamcenter = $applications->unique('externalexamcenter_id')->map(function ($query) {
                    return $query->externalexamcenter;
                })->first();
                */

                $institute = Institute::where('id', $candidate->approvedprogramme->institute->id)->first();

                if($exam->id == '20' || $exam->id == '21') {
                    $title = $exam->name." (Theory) ";

                    return view('institute.examhalltickets.january2023examinations.download_candidate_hallticket', compact('exam', 'title', 'externalexamcenter', 'candidate', 'applications', 'institute'));
                }

                if($exam->id == '18' || $exam->id == '19') {
                    $title = $exam->name." (Theory) ";

                    return view('institute.examhalltickets.july2022examinations.download_candidate_hallticket', compact('exam', 'title', 'externalexamcenter', 'candidate', 'applications', 'institute'));
                }

                if($exam->id == '17' ) {
                    return view('institute.examhalltickets.november2021examinations.downloadhallticket', compact('exam', 'title', 'externalexamcenter', 'candidate', 'applications', 'institute'));
                }

                if($exam->id == "16") {
                    return view('institute.examhalltickets.august1styear2021examinations.downloadhallticket', compact('exam', 'title', 'externalexamcenter', 'candidate', 'applications', 'institute'));
                }
                if($exam->id == "15") {
                    return view('institute.examhalltickets.august2021examinations.downloadhallticket', compact('exam', 'title', 'externalexamcenter', 'candidate', 'applications', 'institute', 'externalexamcenterdetail', 'examtimetables', 'marks'));
                }
            }
            else {
                return redirect('/institute/examinations/applications/'.$exam->id);
            }
        }
        else {
            return redirect('/institute/examinations');
        }



        /*
        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join("candidates", "candidates.id", "=", "applications.candidate_id")
            ->join("examtimetables", "examtimetables.subject_id", "=", "applications.subject_id")
            ->join("marks", "marks.application_id", "=", "applications.id")
            ->where('applications.exam_id', $exam->id)->where('applications.candidate_id', $candidate->id)
            ->where('examtimetables.exam_id', $exam->id)
            ->where('subjects.subjecttype_id', '=', '1')
            ->where('hallticket_status', '1')
            ->where("marks.internalresult_id", "1")
            ->whereNotNull('candidates.enrolmentno')
            ->orderBy('examtimetables.startdate')->get();

        $externalexamcenter = $applications->unique('externalexamcenter_id')->map(function ($query) {
            return $query->externalexamcenter;
        })->first();

        $institute = Institute::where('id', $candidate->approvedprogramme->institute->id)->first();

        if($exam->id == '18' || $exam->id == '19') {
            $title = $exam->name." (Theory) ";

            //return view('institute.examhalltickets.july2022examinations.download_candidate_hallticket', compact('exam', 'title', 'externalexamcenter', 'candidate', 'applications', 'institute'));
        }

        if($exam->id == '17' ) {
            return view('institute.examhalltickets.november2021examinations.downloadhallticket', compact('exam', 'title', 'externalexamcenter', 'candidate', 'applications', 'institute'));
        }

        if($exam->id == "16") {
            return view('institute.examhalltickets.august1styear2021examinations.downloadhallticket', compact('exam', 'title', 'externalexamcenter', 'candidate', 'applications', 'institute'));
        }
        if($exam->id == "15") {
            return view('institute.examhalltickets.august2021examinations.downloadhallticket', compact('exam', 'title', 'externalexamcenter', 'candidate', 'applications', 'institute', 'externalexamcenterdetail', 'examtimetables', 'marks'));
        }
        */

        /*
        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join("candidates", "candidates.id", "=", "applications.candidate_id")
            ->join("examtimetables", "examtimetables.subject_id", "=", "applications.subject_id")
            ->where('applications.exam_id', $exam->id)->where('applications.candidate_id', $candidate->id)
            ->where('examtimetables.exam_id', $exam->id)
            ->where('subjects.subjecttype_id', '=', '1')
            ->whereNotNull('candidates.enrolmentno')
            ->orderBy('examtimetables.startdate')->get();

        $application_ids = $applications->pluck('id')->toArray();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        $subject_ids = $applications->pluck('subject_id')->toArray();

        $examtimetables = Examtimetable::where('exam_id', $exam->id)->whereIn('subject_id', $subject_ids)->get();

        $institute = Institute::where('id', $candidate->approvedprogramme->institute->id)->first();
        $externalexamcenterdetail = Externalexamcenterdetail::where('exam_id', $exam->id)->where('institute_id', $institute->id)->first();


        return view('institute.examhalltickets.downloadhallticket', compact('exam', 'candidate', 'applications', 'institute', 'externalexamcenterdetail', 'examtimetables', 'marks'));
        */

    }

    public function old_download_candidate_hallticket($e_id, $c_id) {
        return 'Closed';
        $exam = Exam::where('id', $e_id)->first();
        $title = $exam->name.' Examinations';

        $candidate = Candidate::where('id', $c_id)->first();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join("candidates", "candidates.id", "=", "applications.candidate_id")
            ->join("examtimetables", "examtimetables.subject_id", "=", "applications.subject_id")
            ->join("marks", "marks.application_id", "=", "applications.id")
            ->where('applications.exam_id', $exam->id)->where('applications.candidate_id', $candidate->id)
            ->where('examtimetables.exam_id', $exam->id)
            ->where('subjects.subjecttype_id', '=', '1')
            ->where('hallticket_status', '1')
            ->where("marks.internalresult_id", "1")
            ->whereNotNull('candidates.enrolmentno')
            ->orderBy('examtimetables.startdate')->get();

        $externalexamcenter = $applications->unique('externalexamcenter_id')->map(function ($query) {
            return $query->externalexamcenter;
        })->first();

        $institute = Institute::where('id', $candidate->approvedprogramme->institute->id)->first();

        if($exam->id == '18' || $exam->id == '19') {
            $title = $exam->name." (Theory) ";

            //return view('institute.examhalltickets.july2022examinations.download_candidate_hallticket', compact('exam', 'title', 'externalexamcenter', 'candidate', 'applications', 'institute'));
        }

        if($exam->id == '17' ) {
            return view('institute.examhalltickets.november2021examinations.downloadhallticket', compact('exam', 'title', 'externalexamcenter', 'candidate', 'applications', 'institute'));
        }

        if($exam->id == "16") {
            return view('institute.examhalltickets.august1styear2021examinations.downloadhallticket', compact('exam', 'title', 'externalexamcenter', 'candidate', 'applications', 'institute'));
        }
        if($exam->id == "15") {
            return view('institute.examhalltickets.august2021examinations.downloadhallticket', compact('exam', 'title', 'externalexamcenter', 'candidate', 'applications', 'institute', 'externalexamcenterdetail', 'examtimetables', 'marks'));
        }

        /*
        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join("candidates", "candidates.id", "=", "applications.candidate_id")
            ->join("examtimetables", "examtimetables.subject_id", "=", "applications.subject_id")
            ->where('applications.exam_id', $exam->id)->where('applications.candidate_id', $candidate->id)
            ->where('examtimetables.exam_id', $exam->id)
            ->where('subjects.subjecttype_id', '=', '1')
            ->whereNotNull('candidates.enrolmentno')
            ->orderBy('examtimetables.startdate')->get();

        $application_ids = $applications->pluck('id')->toArray();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        $subject_ids = $applications->pluck('subject_id')->toArray();

        $examtimetables = Examtimetable::where('exam_id', $exam->id)->whereIn('subject_id', $subject_ids)->get();

        $institute = Institute::where('id', $candidate->approvedprogramme->institute->id)->first();
        $externalexamcenterdetail = Externalexamcenterdetail::where('exam_id', $exam->id)->where('institute_id', $institute->id)->first();


        return view('institute.examhalltickets.downloadhallticket', compact('exam', 'candidate', 'applications', 'institute', 'externalexamcenterdetail', 'examtimetables', 'marks'));
        */

    }


    public function downloadHalltickets($eid, $cid) {
        return 'Closed';
        $exam = Exam::where('id', $eid)->first();


    }

}

