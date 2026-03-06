<!DOCTYPE html>
<html>
<head>
    <title>NBER - {{$exam->name}} Exam Hallticket</title>
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
        }

        .page-break {
            page-break-after: always;
        }
        .bold-text {
            font-weight: bold;
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
            font-size: 20px;
            font-weight: bold;
        }
        .h6-text {
            font-size: 15px;
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
    </style>
</head>
<body>
<div class="right-text">
    <p>
        <button type="button" onclick="window.print();return false;" id="printPageButton">Print</button>
    </p>
</div>

<div class="page-break">
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <tr>
            <td>
                <div class="center-text blue-text">
                    <span class="h6-text bold-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan) (NIEPMD)</span><br>
                    <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                    <span class="h6-text bold-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                    <span class="h8-text">East Coast Road, Muttukadu, Kovalam, P.O, Chennai-603 112, Tamil Nadu.<br></span>
                    <span class="h6-text bold-text">{{ $exam->name }} Examinations - Hall Ticket</span><br>
                </div>

                <table border="1" cellpadding="3" cellspacing="0" width="100%" class="h7-text">
                    <tr>
                        <td class="left-text blue-text">
                            Enrolment No.
                        </td>
                        <td class="left-text blue-text">
                            <b> {{$candidate->enrolmentno  }}</b>
                        </td>
                        <td class="left-text blue-text">
                            Name
                        </td>
                        <td class="left-text blue-text">
                            <b> {{$candidate->name  }}</b>
                        </td>
                        <td class="center-text blue-text" rowspan="4">
                            <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 60px;" class="img" />
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text">
                            Father's Name
                        </td>
                        <td class="left-text blue-text">
                            <b> {{ $candidate->fathername  }}</b>
                        </td>
                        <td class="left-text blue-text">
                            Date of Birth
                        </td>
                        <td class="left-text blue-text">
                            <b> {{ $candidate->dob->format('d-m-Y') }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text">
                            Course
                        </td>
                        <td class="left-text blue-text">
                            <b> {{ $candidate->approvedprogramme->programme->course_name }}</b>
                        </td>
                        <td class="left-text blue-text">
                            Batch
                        </td>
                        <td class="left-text blue-text">
                            <b> {{ $candidate->approvedprogramme->academicyear->year }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text">Study Center</td>
                        <td class="left-text blue-text bold-text" colspan="3">
                            ( {{ $institute->code }} ) - {{ $institute->name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text">Exam Center</td>
                        <td class="left-text blue-text bold-text" colspan="3">
                            ( {{ $externalexamcenterdetail->externalexamcenter->code }} ) - {{ $externalexamcenterdetail->externalexamcenter->name }}
                            @if($externalexamcenterdetail->externalexamcenter->address != '')<br>{{ $externalexamcenterdetail->externalexamcenter->address }}@endif
                            @if($externalexamcenterdetail->externalexamcenter->district != ''), {{ $externalexamcenterdetail->externalexamcenter->district }}@endif
                            @if($externalexamcenterdetail->externalexamcenter->state != ''), {{ $externalexamcenterdetail->externalexamcenter->state }}@endif
                            @if($externalexamcenterdetail->externalexamcenter->state != '') - {{ $externalexamcenterdetail->externalexamcenter->pincode }}@endif
                            @if($externalexamcenterdetail->externalexamcenter->contactnumber1 != '')<br>{{ $externalexamcenterdetail->externalexamcenter->contactnumber1 }}@endif @if($externalexamcenterdetail->externalexamcenter->contactnumber2 != ''),{{ $externalexamcenterdetail->externalexamcenter->contactnumber2 }}@endif
                            @if($externalexamcenterdetail->externalexamcenter->email1 != '')<br>{{ $externalexamcenterdetail->externalexamcenter->email1 }}@endif @if($externalexamcenterdetail->externalexamcenter->email2 != ''),{{ $externalexamcenterdetail->externalexamcenter->email2 }}@endif
                        </td>
                        <td class="center-text blue-text">
                            <br><br>
                            Signature of the Candidate</td>
                    </tr>
                </table>
                <hr/>

                <table border="1" cellpadding="3" cellspacing="0" width="100%" class="h7-text">
                    <tr>
                        <td class="center-text blue-text bold-text" width="5%">S.No.</td>
                        <td class="center-text blue-text bold-text" width="5%">Year / Term</td>
                        <td class="center-text blue-text bold-text" width="5%">Subject Code</td>
                        <td class="center-text blue-text bold-text" width="50%">Subject Name</td>
                        <td class="center-text blue-text bold-text">Date</td>
                        <td class="center-text blue-text bold-text">From</td>
                        <td class="center-text blue-text bold-text">To</td>
                    </tr>

                    @php $sno = '1'; @endphp
                    @foreach($applications as $app)
                        @php
                            $mark = $marks->where('application_id', $app->id)->first();
                        @endphp

                        @if(!is_null($mark))
                            @php
                                $internal  = $mark->internal;
                            @endphp

                            @if(!is_null($internal))
                                @if($internal != "Abs")
                                @if($internal >= $app->subject->imin_marks)
                                        <tr>
                                            <td class="center-text blue-text bold-text">{{ $sno }}</td>
                                            <td class="center-text blue-text bold-text">{{ $app->subject->syear }}</td>
                                            <td class="center-text blue-text bold-text">{{ $app->subject->scode }}</td>
                                            <td class="left-text blue-text bold-text">{{ $app->subject->sname }}</td>
                                            @foreach($examtimetables->where('subject_id', $app->subject_id) as $et)
                                                <td class="center-text blue-text bold-text">
                                                    {{ $et->startdate->format('d-m-Y') }}
                                                </td>
                                                <td class="center-text blue-text bold-text">
                                                    {{ $et->startdate->format('h:i A') }}
                                                </td>
                                                <td class="center-text blue-text bold-text">
                                                    {{ $et->enddate->format('h:i A') }}
                                                </td>
                                            @endforeach
                                        </tr>
                                        @php $sno++; @endphp
                                    @endif
                                @endif
                            @endif
                        @endif


                    @endforeach
                    <tr>
                        <td class="left-text red-text bold-text h7-text" rowspan="3">
                            Note:
                        </td>
                        <td class="left-text red-text bold-text h7-text" colspan="4">
                            Candidates must bring their original valid Photo Identity Card like Elector’s Photo Identity Card,
                            Aadhar Card, PAN Card, Driving License or any Photo Identity Card issued by a Competent Government Authority to enter the Exam hall.
                        </td>
                        <td class="right-text bold-text blue-text h7-text" rowspan="3" colspan="2">
                            <img src="{{asset('/images/hallticket/adce_sign.png')}}"  style="width: 50px;" class="img" />
                            <br>ADCE, NIEPMD-NBER
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text red-text bold-text h7-text" colspan="4" width="10%">
                            Candidates will be permitted to occupy their seats 20 minutes before the scheduled start of the examination.
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text red-text bold-text h7-text" colspan="4" width="10%">
                            No candidate will be allowed to bring mobile phone or any kind of electronic gadgets inside the examination premises.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
</div>
</body>