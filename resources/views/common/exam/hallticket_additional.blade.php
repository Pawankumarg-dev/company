<!DOCTYPE html>
<html>
<head>
    <title>NBER - 2024 July Examinations - Hallticket</title>
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
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
                                <span class="h6-text bold-text bt">National Board of Examination in Rehabilitation (NBER)</span><br>
                                
                                <span class="h8-text">
                                (An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)    
                                </span><br>

                                <span class="h7-text bold-text bt">{{$applicant->candidate->approvedprogramme->programme->nber->name}}</span><br>
                                
                                <span class="h8-text">
                                (Dept of Empowerment of persons with disabilities, (DIVYANGJAN) MSJ & E Govt Of India)

                                </span>
                            </div>
                        </td>
                        <td  width="15%" style="text-align:right;">
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
                        <td class="h7-text center-text blue-text" colspan="5" style="border-left:1px solid #aaa;border-top:1px solid #aaa;"><span class="h7-text bold-text bt">HALL TICKET  - JUNE 2024</span></td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="15%">Name</td>
                        <td class="left-text blue-text bold-text" width="25%">{{ $applicant->candidate->name }}</td>
                        <td class="left-text blue-text" width="15%">Registration No.</td>
                        <td class="left-text blue-text bold-text" width="25%">{{ $applicant->candidate->enrolmentno }}</td>
                        <td class="left-text blue-text center-text" width="14%" rowspan="7">
                            <img src="{{asset('/files/enrolment/photos')}}/{{$applicant->candidate->photo}}"  style="width: 90px;" class="img" />
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
                        <td class="left-text blue-text" width="15%">Batch</td>
                        <td class="left-text blue-text bold-text" width="25%">
                            {{ $applicant->candidate->approvedprogramme->academicyear->year }}
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="15%">Study Center Code</td>
                        <td class="left-text blue-text bold-text" width="25%" colspan="3">
                            
                             {{ $institute->user->username }}
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
                            EXCUP27
                        </td>
                        <td class="center-text blue-text bold-text" rowspan="2" style="vertical-align: bottom">
                            <br><br><br>
                            Signature of the Candidate
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="15%">Exam Center
                        </td>
                        <td class="left-text blue-text bold-text" width="25%" colspan="2" >
                            KENDRIYA VIDYALAYA.AZAMGARH
                            <br>
                            KENDRIYA VIDYALAYA, POST- HEERAPATTI, DISTT.-AZAMGARH (U.P.)-276001
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        
            <td>
                <br>
                <table border="1" cellpadding="1" cellspacing="0" width="100%" class="h8-text border-table">
                    <tr>
                        <td class="center-text blue-text bold-text" width="5%">S.No.</td>
                        <td class="center-text blue-text bold-text" width="12%">Date</td>
                        <td class="center-text blue-text bold-text" width="10%">From</td>
                        <td class="center-text blue-text bold-text" width="10%">To</td>
                        <td class="center-text blue-text bold-text" width="5%">Year</td>
                        <td class="center-text blue-text bold-text" width="5%">Subject Code</td>
                        <td class="center-text blue-text bold-text" width="38%">Subject</td>
                        <td class="center-text blue-text bold-text" width="20%">Signature of Invigilator</td>
                    </tr>

                    @php $sno = '1'; @endphp
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
                        
                        @if($subject->subjecttype_id==1 && $show == 1 && $application->mark_as_deleted != 1 && $subject->id == 640)
                        <tr>
                            <td class="center-text blue-text">{{ $sno }}</td>
                            <td class="center-text blue-text bold-text">
                               @if($table->count() > 0)
                                    {{\Carbon\Carbon::parse($table->first()->examschedule->examdate)->format('d-m-Y')}}
                                    
                                @endif
                            </td>
                            <td class="center-text blue-text">
                                @if($table->count() > 0)
                                    {{ \Carbon\Carbon::parse($table->first()->examschedule->starttime)->format('h:i A')}}
                                @endif
                            </td>
                            <td class="center-text blue-text">
                                @if($table->count() > 0)
                                    {{\Carbon\Carbon::parse($table->first()->examschedule->endtime)->format('h:i A')}}
                                @endif
                            </td>
                            <td class="center-text blue-text bold-text">{{ $subject->syear }}</td>

                            <td class="center-text blue-text bold-text">{{ $subject->scode }}</td>
                            <td class="left-text blue-text bold-text">{{ $subject->sname }}</td>
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
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="h7-text">
                    <tr>
                        <td>
                            <img src="{{url('files/ht_instructions.png')}}" width="100%">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
