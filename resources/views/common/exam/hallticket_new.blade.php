<!DOCTYPE html>
<html>
<head>
    <title>NBER - 2025 January Supplementary Examinations - Hallticket</title>
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
            @page { margin: 0; }
            body { margin: 1.6cm; }
        }

        .page-break {
        }
        .bold-text {
        }
        .blue-text {
            color: black;
        }
        .h6-text {
            font-size: 14px;
        }
        .h7-text {
            font-size: 10px;
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
        .courier_new_font{
            font-family: "Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace;
        }
        .verdana{
            font-family: "Verdana", sans-serif;
        }
        .custom-li-style {
            margin-left: -25px !important;
        }
        .border-table {
            border-left: 1px solid #aaa;
            border-right: 0;
            border-top: 1px solid #aaa;
            border-bottom: 0;
            border-collapse: collapse;
        }
        .border-table td,
        .border-table th {
            border-left: 0;
            border-right: 1px solid #aaa;
            border-top: 0;
            border-bottom: 1px solid #aaa;
            height: 20px;
            padding:0 5px;
        }
        .bt{
            font-weight: 200;
        }
        .signaturetd td{
            height: 32px!important;
        }
        .signaturetd1 td{
            height: 32px!important;
        }
    </style>
    @if ($format=='html')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
    }); 
</script>
@endif
</head>
<body>
<div class="page-break verdana">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>

                        <td width="15%">
                            <img src="{{asset('/images')}}/nber_logo.png"  style="width: 70px; height: 70px !important" class="img" />
                        </td>
                      
                        <td class="h8-text center-text" width="70%">
                            <div class="center-text blue-text">
                                <span class="h6-text bold-text bt" style="font-size: 14px;font-weight:500"><b>National Board of Examination in Rehabilitation (NBER)</b></span><br>
                                
                                <span class="h8-text">
                                (An Adjunct Body of Rehabilitation Council of India, under MSJ&E, Govt. Of India)    
                                </span><br>

                                <span class="h7-text bold-text bt">{{$applicant->candidate->approvedprogramme->programme->nber->name}}</span><br>
                                
                                <span class="h8-text">
                                (Dept. of Empowerment of Persons with Disabilities (DIVYANGJAN) MSJ&E, Govt. Of India)

                                </span>
                            </div>
                        </td>
                        <td  width="15%" style="text-align:right;padding:3px;">
                            <img src="{{asset('/images/')}}/{{$applicant->candidate->approvedprogramme->programme->nber->logo}}"  style="height: 70px;max-width:100px;" class="img" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="1" cellpadding="2" cellspacing="0" width="100%" class="h8-text border-table" style="margin-top:15px;">
                    <tr>
                        <td class="h7-text blue-text" colspan="5" style="border-left:1px solid #aaa;border-top:1px solid #aaa;">
                            <span class="h7-text bold-text bt" style="font-weight: 500;"><b>HALL TICKET  - JUNE 2025</b></span>
                            <span class="h7-text bold-text bt" style="font-weight: 500;float: right;"><b>HALL TICKET NUMBER - {{ $applicant->hallticket_no }}</b></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="18%">Name</td>
                        <td class="left-text blue-text bold-text" width="25%">{{ $applicant->candidate->name }}</td>
                        <td class="left-text blue-text" width="15%" style="font-weight: 500">Registration No.</td>
                        <td class="left-text blue-text bold-text" width="25%" style="font-weight: 500">{{ $applicant->candidate->enrolmentno }}</td>
                        
                            <td class="left-text blue-text center-text" width="14%" rowspan="7">
                                <img src="{{asset('/files/enrolment/photos')}}/{{$applicant->candidate->photo}}"  style="width: 120px;" class="img" />
                                @if($applicant->candidate->isdisabled == 1)
                                Category: PwD
                                @endif
                            </td>

                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="18%">Father's Name</td>
                        <td class="left-text blue-text bold-text" width="25%">{{ $applicant->candidate->fathername }}</td>
                        <td class="left-text blue-text" width="15%">Date of Birth</td>
                        <td class="left-text blue-text bold-text" width="25%">{{ \Carbon\Carbon::parse($applicant->candidate->dob)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="18%">Course</td>
                        <td class="left-text blue-text bold-text" width="25%">{{ $applicant->candidate->approvedprogramme->programme->display_code }}</td>
                        <td class="left-text blue-text" width="15%" style="font-size:10px;font-weight: 700!important;">Course Code</td>
                        <td class="left-text blue-text bold-text" width="25%" style="font-size:10px;font-weight: 700!important;">
                            {{ $applicant->candidate->approvedprogramme->programme->course->code }}
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="18%">Study Center Code</td>
                        <td class="left-text blue-text bold-text" width="25%">
                            
                             {{ $institute->user->username }}
                        </td>
                        <td class="left-text blue-text" width="15%">Batch</td>
                        <td class="left-text blue-text bold-text" width="25%">
                            {{ $applicant->candidate->approvedprogramme->academicyear->year }} -  Term : {{ $term }}
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="18%">Name of the Study Center</td>
                        <td class="left-text blue-text bold-text" width="25%" colspan="3">
                            {{ $institute->name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="18%">Exam Center Code
                        </td>
                        <td class="left-text blue-text bold-text" width="25%" colspan="2" >
                            @if(!is_null($exam_center) && !is_null($exam_center->externalexamcenter))
                                {{$exam_center->externalexamcenter->code}}
                            @endif
                        </td>
                        <td class="center-text blue-text bold-text" rowspan="2" style="vertical-align: bottom">
                            <img src="{{asset('/files/enrolment/signature')}}/{{$applicant->candidate->signature}}"  style="width: 90px;" class="img" /> <br />
                            Signature of the Candidate
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="15%">Exam Center
                        </td>
                        <td class="left-text blue-text bold-text" width="25%" colspan="2" >
                            @if(!is_null($exam_center) && !is_null($exam_center->externalexamcenter))
                            {{$exam_center->externalexamcenter->name}}
                            <br>
                            {{$exam_center->externalexamcenter->address}} <br>
                            {{$exam_center->externalexamcenter->lgstate->state_name}} - {{$exam_center->externalexamcenter->pincode}} 
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        
            <td>
                <br>
                <div class="right-text blue-text bold-text" style="font-size: 12px;width:100%;padding:0;">
                    To be signed at the examination hall, only on the day of subject. <br /> परीक्षा हॉल में, केवल विषय के दिन ही हस्ताक्षर किए जाने चाहिए
                </div>
                <table border="1" cellpadding="1" cellspacing="0" width="100%" class="h8-text border-table">
                    <tr>
                        <td class="center-text blue-text bold-text" width="1%">Sl#</td>
                        <td class="center-text blue-text bold-text" width="20%">Date & Time</td>
                        <td class="center-text blue-text bold-text" width="14%" style="font-weight: 700">Subject Code <br /> (For OMR)</td>
                        <td class="center-text blue-text bold-text" width="35%">Subject</td>
                        <td class="center-text blue-text bold-text" width="15%">Signature of Invigilator</td>
                        <td class="center-text blue-text bold-text" width="15%">Signature of Candidate</td>
                    </tr>

                    @php $sno = 1; @endphp
                    <?php $reportingtime = \Carbon\Carbon::now();
                        $time = '00:00 A';        $multiple =0 ;            
                    ?>
                    <?php
                        $applicant->applications->sortBy('subject.sortorder');
                        $applications = \App\Allapplication::where('candidate_id',$applicant->candidate_id)->where('exam_id',27)->get();
                    ?>
                    @foreach($applications->sortBy('subject.sortorder') as $application)
                        @php 
                            $subject = $application->subject;
                            $alternative = 0;
                            if(!is_null($application->alternativesubject_id)){
                                //$subject = \App\Subject::find($application->alternative_paper);
                                $alternative = 1;
                                $alt = \App\Alternativesubject::find($application->alternativesubject_id);
                            }
                        @endphp
                        <?php 
                            $show = 1; 
                            if($subject->syear!=$term || $subject->is_external == 0){
                                $show =0;
                            }
                        ?>
                        <?php 
                            $table = \App\Examtimetable::where('subject_id',$subject->id)->where('exam_id',$exam->id); 
                        ?>
                        
                        @if($subject->subjecttype_id==1 && $show == 1 && $application->mark_as_deleted != 1)
                        <tr class="signaturetd">
                            <td class="center-text blue-text">{{ $sno }}</td>
                            <td class="center-text blue-text bold-text">
                                <div style="display: none;">
                                    {{ $exam->id }}, {{ $subject->id }}, {{ $alternative }}, {{ $applicant->candidate->approvedprogramme->programme_id }}
                               </div>
                                <?php 
                                if($alternative == 1 && $applicant->candidate->approvedprogramme->programme_id == 70 ){
                                        $examschedule = \App\Examschedule::find($alt->examtimetable_id);
                                }else{
                                    $examschedule = $table->first()->examschedule;
                                } 
                               ?>
                               <div style="display: none;">
                                    {{ $examschedule }}
                               </div>
                               @if(!is_null($examschedule))

                                    {{\Carbon\Carbon::parse($examschedule->examdate)->format('d-m-Y')}}
                                    
                                    <br />
                                    <?php $starttime = \Carbon\Carbon::parse($examschedule->starttime); ?>
                                    {{ $starttime->format('h:i A')}}
                                    To 
                                    {{\Carbon\Carbon::parse($examschedule->endtime)->format('h:i A')}}
                                    <?php 
                                        if($sno == 1){
                                            $reportingtime = \Carbon\Carbon::parse($examschedule->starttime);
                                            $time = $reportingtime->format('h:i A');
                                        }else{
                                            $tochecktime = $starttime->format('h:i A');
                                            if($time != $tochecktime){
                                                $multiple = 1;
                                            }
                                        }   
                                    ?> 
                                @endif
                            </td>

                             
                            <td class="center-text blue-text bold-text" style="min-width: 60px;font-weight:700" >
                            
                            @if($alternative == 1)
                                {{ str_pad($alt->omr_code,5,'0',STR_PAD_LEFT) }}
                            @else
                                {{ str_pad($subject->omr_code,5,'0',STR_PAD_LEFT) }}
                            @endif
                            </td>
                            <td class="left-text blue-text bold-text">
                            @if($alternative == 1)
                                {{ $alt->scode }}
                            @else
                                {{ $subject->scode }}
                            @endif
                                    - 
                                @if($alternative == 1)
                                {{ $alt->sname }}
                            @else
                                {{ $subject->sname }}
                            @endif
                            </td>
                            <td></td>
                            <td></td>
                            @php $sno++; @endphp
                        </tr>
                        @endif
                    @endforeach 
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <table border="1" cellpadding="0" cellspacing="0" width="100%" class="h8-text border-table">
                    <tr style="min-height:300px;">
                        <td width="20%" valign="middle" colspan="2">
                            <div class="center-text bold-text blue-text" >
                        
                                Candidate's Photo<br/>
                                (Same as uploaded on the portal, to be affixed before reaching the exam center)
                            </div>
                        </td>

                        <td width="80%"  valign="top" colspan="2">
                            @if($multiple == 0)
                            <table border="1" cellpadding="1" cellspacing="0" width="100%" class="h8-text border-table">
                                <tr>
                                    <td class="blue-text bold-text" width="35%" style="font-weight: 700">Reporting time at examination center</td>
                                    <td class="center-text blue-text bold-text" width="15%"  style="font-weight: 700">{{ $reportingtime->subMinutes(90)->format('h:i A')}}</td>
                                    <td class="blue-text blue-text bold-text" width="35%"  style="font-weight: 700">Gate closing time of examination Center</td>
                                    <td class="center-text bold-text" width="15%"  style="font-weight: 700">{{ $reportingtime->addMinutes(30)->format('h:i A')}} </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <span style="font-size: 13px;font-weight:500;">
                                            Candidate should reach the examination center before reporting time. Gates will be closed 1 hour before the scheduled exam time. <br />
                                            अभ्यर्थी को रिपोर्टिंग समय से पहले परीक्षा केंद्र पर पहुंचना होगा। निर्धारित  किये गए परीक्षा समय से 1 घंटे पहले गेट बंद कर दिए जाएंगे।
                                        </span>
                                    </td>
                                </tr>
                            </table>
                            @else
                            <table border="1" cellpadding="1" cellspacing="0" width="100%" class="h8-text border-table">
                                <tr>
                                    <td class="blue-text bold-text" width="35%" style="font-weight: 700" rowspan="2">Reporting time at examination center</td>
                                    <td class="center-text blue-text bold-text" width="15%"  style="font-weight: 700">
                                        Morning : 8:30 AM
                                    </td>
                                    <td class="blue-text blue-text bold-text" width="35%"  rowspan="2" style="font-weight: 700">Gate closing time of examination Center</td>
                                    <td class="center-text bold-text" width="15%"  style="font-weight: 700">
                                        Morning : 9:00 AM
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center-text blue-text bold-text" width="15%"  style="font-weight: 700">
                                        Afternoon : 1:00 PM
                                    </td>
                                    <td class="center-text bold-text" width="15%"  style="font-weight: 700">
                                        Afternoon : 1:30 PM
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <span style="font-size: 13px;font-weight:500;">
                                            Candidate should reach the examination center before reporting time. Gates will be closed 1 hour before the scheduled exam time. <br />
                                            अभ्यर्थी को रिपोर्टिंग समय से पहले परीक्षा केंद्र पर पहुंचना होगा। निर्धारित  किये गए परीक्षा समय से 1 घंटे पहले गेट बंद कर दिए जाएंगे।
                                        </span>
                                    </td>
                                </tr>
                            </table>
                            @endif
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="h7-text">
                                <tr style="min-height:300px;">
                                    <td width="50%" valign="bottom" colspan="2">
                                        <div class="center-text bold-text blue-text" >
                                            <br><br><br><br>
                                            Seal and Signature of the Study Centre
                                        </div>
                                    </td>
            
                                    <td width="50%"  valign="bottom" colspan="2">
                                        <div class="center-text bold-text blue-text" >
                                            <img src="{{url('images')}}/{{$applicant->candidate->approvedprogramme->programme->nber->signature}}" style="height:40px;" alt="">
                                            <br />
                                            I/c  NBER - {{$applicant->candidate->approvedprogramme->programme->nber->name_code}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <table border="0" cellpadding="0" cellspacing="0" width="100%"  class="h6-text border-table">
                    <tr>
                        <td style="padding:10px;font-size:11px;">
                            Candidate must bring following, failing which the candidate will not be allowed to enter in the examination center. <br />
                            अभ्यर्थी को निम्नलिखित दस्तावेज़ के बिना  परीक्षा केंद्र में प्रवेश करने की अनुमति नहीं दी जाएगी-
                            <ul>
                                <li>
                                    Legibly printed hall ticket with photographs as submitted on the NBER RCI portal during enrolment,  and one photograph pasted on the hall ticket. <br />
                                    सुस्पष्ट हॉल टिकट, जिस पर नामांकन के दौरान NBER RCI पोर्टल पर प्रस्तुत की गई तस्वीर लगी हो, तथा हॉल टिकट पर भी एक तस्वीर चिपकाई गई हो।
                                </li>
                                <li>
                                    One identity proof in original with photo like Institute's ID Card / Aadhar Card / E-Aadhar / Voter Card / PAN Card / Driving Licence /  Passport. <br />
                                    संस्थान का पहचान पत्र/आधार कार्ड/ई-आधार/वोटर कार्ड/पैन कार्ड/ड्राइविंग लाइसेंस/पासपोर्ट में से कोई एक, फोटो सहित मूल पहचान प्रमाण।
                                </li>
                            </ul>
                            All other ID/Photocopies of IDs even if attested / scanned photo of IDs in the mobile phone will NOT be considered as a valid ID proof. <br  />
                            अन्य सभी पहचान पत्र/पहचान पत्रों की फोटोकॉपी, भले ही वे सत्यापित/मोबाइल फोन में स्कैन की गई  हों, उन्हें वैध पहचान प्रमाण नहीं माना जाएगा।
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>


</body>
</html>
