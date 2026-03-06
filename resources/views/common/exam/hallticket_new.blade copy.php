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
                        <td class="left-text blue-text" width="15%">Name</td>
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
                        <td class="left-text blue-text" width="15%">Father's Name</td>
                        <td class="left-text blue-text bold-text" width="25%">{{ $applicant->candidate->fathername }}</td>
                        <td class="left-text blue-text" width="15%">Date of Birth</td>
                        <td class="left-text blue-text bold-text" width="25%">{{ \Carbon\Carbon::parse($applicant->candidate->dob)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="15%">Course</td>
                        <td class="left-text blue-text bold-text" width="25%">{{ $applicant->candidate->approvedprogramme->programme->display_code }}</td>
                        <td class="left-text blue-text" width="15%" style="font-size:10px;font-weight: 700!important;">Course Code</td>
                        <td class="left-text blue-text bold-text" width="25%" style="font-size:10px;font-weight: 700!important;">
                            {{ $applicant->candidate->approvedprogramme->programme->course->code }}
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="15%">Study Center Code</td>
                        <td class="left-text blue-text bold-text" width="25%">
                            
                             {{ $institute->user->username }}
                        </td>
                        <td class="left-text blue-text" width="15%">Batch</td>
                        <td class="left-text blue-text bold-text" width="25%">
                            {{ $applicant->candidate->approvedprogramme->academicyear->year }}
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="15%">Name of the Study Center</td>
                        <td class="left-text blue-text bold-text" width="25%" colspan="3">
                            {{ $institute->name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="15%">Exam Center Code
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
                <div class="right-text blue-text bold-text" style="padding: 0;width:100%;">
                    To be signed at the examination hall, on the day of examination.
                </div>
                <table border="1" cellpadding="1" cellspacing="0" width="100%" class="h8-text border-table">
                    <tr>
                        <td class="center-text blue-text bold-text" width="3%">Sl#</td>
                        <td class="center-text blue-text bold-text" width="10%">Date</td>
                        <td class="center-text blue-text bold-text" width="10%">From</td>
                        <td class="center-text blue-text bold-text" width="10%">To</td>
                        <td class="center-text blue-text bold-text" width="3%">Term</td>
                        <td class="center-text blue-text bold-text" width="5%">Subject Code</td>
                        <td class="center-text blue-text bold-text" width="10%" style="font-weight: 700">Subject Code (For OMR)</td>
                        <td class="center-text blue-text bold-text" width="38%">Subject</td>
                        <td class="center-text blue-text bold-text" width="20%">Signature of Invigilator</td>
                    </tr>

                    @php $sno = '1'; @endphp
                    @foreach($applicant->applications as $application)
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
                            if($subject->syear!=$term){
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
                               @if($table->count() > 0)
                                    {{\Carbon\Carbon::parse($table->first()->examschedule->examdate)->format('d-m-Y')}}
                                    
                                @endif
                            </td>
                            <td class="center-text blue-text">
                                @if($table->count() > 0)
                                    <?php $starttime = \Carbon\Carbon::parse($table->first()->examschedule->starttime); ?>
                                    {{ $starttime->format('h:i A')}}
                                @endif
                            </td>
                            <td class="center-text blue-text">
                                @if($table->count() > 0)
                                    {{\Carbon\Carbon::parse($table->first()->examschedule->endtime)->format('h:i A')}}
                                @endif
                            </td>
                            <td class="center-text blue-text bold-text">{{ $subject->syear }}</td>

                            <td class="center-text blue-text bold-text" style="min-width: 60px;">
                                @if($alternative == 1)
                                    {{ $alt->scode }}
                                @else
                                    {{ $subject->scode }}
                                @endif
                            
                            </td>
                            <td class="center-text blue-text bold-text" style="min-width: 60px;font-weight:700" >
                            
                            {{ str_pad($subject->omr_code,5,'0',STR_PAD_LEFT) }}

                            </td>
                            <td class="left-text blue-text bold-text">
                                @if($alternative == 1)
                                {{ $alt->sname }}
                            @else
                                {{ $subject->sname }}
                            @endif
                            </td>
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
                <table border="1" cellpadding="1" cellspacing="0" width="100%" class="h8-text border-table">
                    <tr>
                        <td class="blue-text bold-text" width="35%">Reporting time at examination center</td>
                        <td class="center-text blue-text bold-text" width="15%">{{ $starttime->subMinutes(90)->format('h:i A')}} </td>
                        <td class="center-text blue-text bold-text" width="35%">Gate closing time of examination Center</td>
                        <td class=" blue-text bold-text" width="15%">{{ $starttime->addMinutes(30)->format('h:i A')}} </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <span style="font-size: 18px;font-weight:500;">
                                Candidate should reach the examination center before reporting time. Gates will be closed 1 hour before the scheduled exam time. <br />
                                अभ्यर्थी को रिपोर्टिंग समय से पहले परीक्षा केंद्र पर पहुंचना होगा। निर्धारित  किये गए परीक्षा समय से 1 घंटे पहले गेट बंद कर दिए जाएंगे।
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <table border="1" cellpadding="0" cellspacing="0" width="100%" class="h8-text border-table">
                    <tr style="min-height:300px;">
                        <td width="40%" valign="bottom" colspan="2">
                            <div class="center-text bold-text blue-text" >
                                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                Candidate's Photo<br/>
                                (Same as uploaded on the portal, to be affixed before reaching the exam center)
                            </div>
                        </td>

                        <td width="60%"  valign="top" colspan="2">
                            <div class="center-text bold-text blue-text" >
                                Candidate's Signature
                                <br/>
                                (To be signed at the examination hall, infront of the Invigilator)
                                <table border="1" cellpadding="1" cellspacing="0" width="100%" class="h8-text border-table">
                                    <tr><td>Date</td><td>Subject Code</td><td>Subject OMR Code</td><td style="width:200px;">Signature</td></tr>
                                    @foreach($applicant->applications as $application)
                        @php 
                            $subject = $application->subject;
                            if($application->alternative_paper > 1){
                                $subject = \App\Subject::find($application->alternative_paper);
                            }
                        @endphp
                        <?php 
                            $show = 1; 
                            if($subject->syear!=$term){
                                $show =0;
                            }
                        ?>
                        <?php 
                            $table = \App\Examtimetable::where('subject_id',$subject->id)->where('exam_id',$exam->id); 
                        ?>
                        
                        @if($subject->subjecttype_id==1 && $show == 1 && $application->mark_as_deleted != 1)
                        <tr class="signaturetd1">
                            <td class="center-text blue-text bold-text">
                               @if($table->count() > 0)
                                    {{\Carbon\Carbon::parse($table->first()->examschedule->examdate)->format('d-m-Y')}}
                                    
                                @endif
                            </td>

                            <td class="center-text blue-text bold-text">

                                @if($alternative == 1)
                                    {{ $alt->scode }}
                                @else
                                    {{ $subject->scode }}
                                @endif
                            </td>
                            <td class="center-text blue-text bold-text">
                                {{ str_pad($subject->omr_code,5,'0',STR_PAD_LEFT) }}

                            </td>

                            <td style="width:100px;"></td>
                            @php $sno++; @endphp
                        </tr>
                        @endif
                    @endforeach 
                        </table>
                                
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <br>
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
        <tr>
            <td>
                <br>
                <table border="0" cellpadding="0" cellspacing="0" width="100%"  class="h6-text border-table">
                    <tr>
                        <td style="padding:10px;font-size:12px;">
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
