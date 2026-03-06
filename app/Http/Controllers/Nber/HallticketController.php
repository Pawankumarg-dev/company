<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Candidate;
use App\Application;
use App\Institute;
use App\Attendance;
use App\Status;
use PDF;


class HallticketController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }
    public function approveattendances(Request $request){
        $collections = Attendance::whereNotNull('document_exemption')->where('exam_id','2');//
        $text = 'Attendance Exemptions';
        if($request->has('s')){
            $collections = $collections->where('exemption',$request->s);
            $text .= ' - '.  Status::find($request->s)->status;
        }
        $collections = $collections->paginate(20);
        $link = 'attendanceapplications';
        return view('nber.halltickets.attendance',compact('collections','link','text'));
    }

    public function changeexemption($e,Request $request){
        $attendance = Attendance::find($request->id);
        $attendance->update(['exemption'=>$e]);
        return back();
    }

    public function index($application_id){
        $ap = Approvedprogramme::find($application_id);
        $exam_id = 22;
        if($ap){
            $candidates = Candidate::where('approvedprogramme_id',$ap->id)->get();
            return view('institute.halltickets.index',compact('candidates','ap','exam_id'));
        }else{
            return redirect('/');
        }
        
    }
    public function newhallticket($cid){
        $candidate = Candidate::find($cid);
        if($candidate->enrolmentno =='' || $candidate->enrolmentno == null ){
            return 'Enrolment number not found, Please contact NBER.';
        }else{
            if(file_exists(public_path().'/files/enrolment/photos/'.$candidate->photo)){
                if($candidate->applications->count()>0){
                    $institute_id = $candidate->approvedprogramme->institute_id;
                    $institute = Institute::where('id',$institute_id)->first();
                    return view('institute.examhalltickets.newhallticket',compact('candidate','institute'));
                }else{
                    return 'No exam applications found, Please click on Exam applications link on the previous page to apply for the examination.';
                }
            }else{
                return 'Please upload the photo by clicking on "Change File" button from the candidate list to download the hallticket. ';
            }
        }

    }
    public function download(Request $request){
        $candidate = Candidate::find($request->id);
        if(Auth::user()->id==$candidate->approvedprogramme->institute->user_id){
            $application = Application::find($request->application_id);

            $date = \Carbon\Carbon::parse($candidate->dob);
            $dob =  $date->toFormattedDateString();

            $applications = Application::where('candidate_id',$candidate->id)->where('exam_id',$application->exam_id)->whereHas('subject', function($query) use ($application){
                    $query->whereHas('examtimetables', function($r) use($application){
                        $r->where('exam_id',$application->exam_id);
                    });
            })->with('subject')->get();
            $count = 1;
            $table  = '';

            $applications->map(function ($appn) use($application){
                $startdate = $appn->subject->startdate($application->exam_id);
                $appn['startdate'] = $startdate;
                return $appn;
            });
            
            foreach($applications->sortBy('startdate') as $a){
                $startdate = $a->subject->startdate($application->exam_id);
                if($startdate!=''){
                    $startdatetime = \Carbon\Carbon::parse($startdate)->toFormattedDateString() . '<br />'.  \Carbon\Carbon::parse($startdate)->format('h:i A') . ' to ';
                }else{
                    $startdatetime = '';
                }
                $enddate  = $a->subject->enddate($application->exam_id);
                if($enddate!=''){
                    $endtime = \Carbon\Carbon::parse($enddate)->format('h:i A');
                }else{
                    $endtime ='';
                }
                $table .= '<tr><td>'.$count.'</td><td align="left">'.$a->subject->scode.'</td><td width="300px" align="left">'. $a->subject->sname.'</td><td align="left">'. $startdatetime . $endtime .'</td><td></td></tr>';
        $count +=1;
            }


            $html = '<style> {margin:25px;} </style>
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
                                    <b><font size="4">National Board of Examination in Rehabilitation</font></b><br>
                                    (An Adjunct Body of RCI, under MSJE, DEPwD,GoI)<br/>
                                    Examination Conducted by:<br>
                                    <b><font size="2">National Institute for Empowerment of Persons with Multiple Disabilities (NIEPMD)</font></b><br>
                                    (DEPwD, MSJE, GoI)<br>
                                    East Coast Road, Muttukadu, Kovalam, P.O, Chennai-603 112, Tamil Nadu.<br>
                                    NBER-RCI, Fax: 044-27472389 Tel: 044-27472104, 27472113, 27472046 / Extn: 492<br>
                                    Website: www.niepmd.tn.nic.in &nbsp;&nbsp;&nbsp;Email: niepmd.examinations@gmail.com                       
                                </td>
                                <td width="110" align="center">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td valign="top">
                                                <b><u><font face="Calibri" size="2">CANDIDATE\'S COPY</font></u></b>
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
                                    <b><font size="3">EXAMINATION '. $application->exam->name .'</font></b><br>
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
                                                        <td colspan="2">&nbsp;'. $candidate->approvedprogramme->institute->name . '<br />'. $candidate->approvedprogramme->institute->examcenter($application->exam_id)->address .' '. $candidate->approvedprogramme->institute->examcenter($application->exam_id)->pincode .'</td>
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
                                                <img src="'. public_path() . '/images/hallticket/sign.png"  height="38" alt="DCE Signature"><br>
                                                <b>DCE, NBER-NIEPMD</b>
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
                            <b><font size="4">National Board of Examination in Rehabilitation</font></b><br>
                            (An Adjunct Body of RCI, under MSJE, DEPwD,GoI)<br/>
                            Examination Conducted by:<br>
                            <b><font size="2">National Institute for Empowerment of Persons with Multiple Disabilities (NIEPMD)</font></b><br>
                            (DEPwD, MSJE, GoI)<br>
                            East Coast Road, Muttukadu, Kovalam, P.O, Chennai-603 112, Tamil Nadu.<br>
                            NBER-RCI, Fax: 044-27472389 Tel: 044-27472104, 27472113, 27472046 / Extn: 492<br>
                            Website: www.niepmd.tn.nic.in &nbsp;&nbsp;&nbsp;Email: niepmd.examinations@gmail.com                       
                        </td>
                        <td width="110" align="center">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td valign="top">
                                        <b><u><font face="Calibri" size="2">EXAMINATION CENTRE COPY</font></u></b>
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
                            <b><font size="3">EXAMINATION '. $application->exam->name .'</font></b><br>
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
                                                        <td colspan="2">&nbsp;'. $candidate->approvedprogramme->institute->name . '<br />'. $candidate->approvedprogramme->institute->examcenter($application->exam_id)->address .' '. $candidate->approvedprogramme->institute->examcenter($application->exam_id)->pincode .'</td>
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
                                        <img src="'. public_path() . '/images/hallticket/sign.png"  height="38" alt="DCE Signature"><br>
                                        <b>DCE, NBER-NIEPMD</b>
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
                $pdf = PDF::setOptions(['isRemoteEnabled' => true])->loadHtml($html);
                //return $pdf->stream();
                return $pdf->stream($candidate->enrolmentno.'.pdf');
            }
    }
}

