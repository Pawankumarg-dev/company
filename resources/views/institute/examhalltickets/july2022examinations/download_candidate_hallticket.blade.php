<!DOCTYPE html>
<html>
<head>
    <title>NBER - {{ $title }} Examinations - Hallticket</title>
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
                <table border="0" cellpadding="3" cellspacing="0" width="100%">
                    <tr>
                        <td class="center-text" width="15%">
                            <img src="{{asset('/images/niepmd_logo.png')}}"  style="width: 50px; height: 60px" class="img" />
                        </td>
                        <td class="h8-text center-text" width="70%">
                            <div class="center-text blue-text">
                                <span class="h7-text bold-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan) (NIEPMD)</span><br>
                                <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                                <span class="h7-text bold-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                                <span class="h8-text">East Coast Road, Muttukadu, Kovalam, P.O, Chennai-603 112, Tamil Nadu.<br></span>
                            </div>
                        </td>
                        <td class="center-text" width="15%">
                            <img src="{{asset('/images/akam_logo.png')}}"  style="width: 50px; height: 100px" class="img" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="1" cellpadding="2" cellspacing="0" width="100%" class="h7-text">
                    <tr>
                        <td class="center-text blue-text" colspan="6"><span class="h6-text bold-text">{{ $title }} Examinations - Hall Ticket</span></td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="15%">Name</td>
                        <td class="left-text blue-text bold-text" width="25%">{{ $candidate->name }}</td>
                        <td class="left-text blue-text" width="15%">Registration No.</td>
                        <td class="left-text blue-text bold-text" width="25%">{{ $candidate->enrolmentno }}</td>
                        <td class="left-text blue-text center-text" width="14%" rowspan="4">
                            <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 60px;" class="img" />
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="15%">Father's Name</td>
                        <td class="left-text blue-text bold-text" width="25%">{{ $candidate->fathername }}</td>
                        <td class="left-text blue-text" width="15%">Date of Birth</td>
                        <td class="left-text blue-text bold-text" width="25%">{{ $candidate->dob->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="15%">Course</td>
                        <td class="left-text blue-text bold-text" width="25%">{{ $candidate->approvedprogramme->programme->course_name }}</td>
                        <td class="left-text blue-text" width="15%">Batch</td>
                        <td class="left-text blue-text bold-text" width="25%">
                            {{ $candidate->approvedprogramme->academicyear->year }}@if($candidate->approvedprogramme->programme->numberofterms == 2)-{{ array_sum(array($candidate->approvedprogramme->academicyear->year, 2)) }}@endif
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="15%">Study Center</td>
                        <td class="left-text blue-text bold-text" width="25%" colspan="3">
                            ( {{ $institute->code }} ) - {{ $institute->name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="left-text blue-text" width="15%"><i>Exam Center</i>
                            <div class="center-text bold-text">
                                {{ $externalexamcenter->code }}
                            </div>
                        </td>
                        <td class="left-text blue-text bold-text" width="25%" colspan="3" rowspan="2">
                            {{ $externalexamcenter->name }}
                            @if($externalexamcenter->address != '')<br>{{ $externalexamcenter->address }}@endif
                            @if($externalexamcenter->district != ''), {{ $externalexamcenter->district }}@endif
                            @if($externalexamcenter->state != ''), {{ $externalexamcenter->state }} - {{ $externalexamcenter->pincode }}@endif
                            @if($externalexamcenter->contactnumber1 != '')<br>Phone No.: {{ $externalexamcenter->contactnumber1 }}@endif @if($externalexamcenter->contactnumber2 != '')/{{ $externalexamcenter->contactnumber2 }}@endif
                            @if($externalexamcenter->email1 != '')<br>Email Id: {{ $externalexamcenter->email1 }}@endif @if($externalexamcenter->email2 != '')/{{ $externalexamcenter->email2 }}@endif
                        </td>
                        <td class="center-text blue-text bold-text" style="vertical-align: bottom">
                            <br><br><br>
                            Signature of the Candidate
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="1" cellpadding="3" cellspacing="0" width="100%" class="h7-text">
                    <tr>
                        <td class="center-text blue-text bold-text" width="5%">S.No.</td>
                        <td class="center-text blue-text bold-text" width="12%">Date</td>
                        <td class="center-text blue-text bold-text" width="10%">From</td>
                        <td class="center-text blue-text bold-text" width="10%">To</td>
                        <td class="center-text blue-text bold-text" width="5%">Paper</td>
                        <td class="center-text blue-text bold-text" width="5%">Subject Code</td>
                        <td class="center-text blue-text bold-text" width="45%">Subject Name</td>
                        <td class="center-text blue-text bold-text" width="14%">Signature of the Invigilator</td>
                    </tr>

                    @php $sno = '1'; @endphp
                    @foreach($applications->unique('subject_id') as $app)
                        <tr>
                            <td class="center-text blue-text">{{ $sno }}</td>
                            <td class="center-text blue-text bold-text">
                                {{ $app->examtimetable->startdate->format('d-m-Y') }}
                            </td>
                            <td class="center-text blue-text">
                                {{ $app->examtimetable->startdate->format('h:i A') }}
                            </td>
                            <td class="center-text blue-text">
                                {{ $app->examtimetable->enddate->format('h:i A') }}
                            </td>
                            <td class="center-text blue-text bold-text">{{ $sno }}</td>
                            <td class="center-text blue-text bold-text">{{ $app->subject->scode }}</td>
                            <td class="left-text blue-text bold-text">{{ $app->subject->sname }}</td>
                            <td><br><br></td>
                            @php $sno++; @endphp
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="1" cellpadding="3" cellspacing="0" width="100%" class="h7-text">
                    <tr>
                        <td>
                            <div class="center-text bold-text blue-text">
                                <u>General Instructions to the Candidate</u>
                            </div>
                            <div class="left-text blue-text">
                                <ol>
                                    <li class="bold-text">
                                        Personal details (Name / Father's Name / Date of Birth) given at the time of time of enrolment is reflected in this hall ticket and the same will be printed in your Statement of Marks &
                                        Certificates. If correction(s) needed, report immediately to NIEPMD-NBER through your study centre before the declaration of results.
                                    </li>
                                    <li>
                                        Candidates has to report at the Examination Centre 30 minutes before the commencement of the examination.
                                    </li>
                                    <li>
                                        Candidates has to bring their original Government Authorised Photo Identity Card (like Voter Id, Aadhaar Card, PAN Card) in proof of their identity.
                                    </li>
                                    <li>
                                        Candidates are advised not to bring mobile phone(s) or any kind of electronic gadgets inside the Examination Hall.
                                    </li>
                                </ol>
                            </div>
                            <div class="right-text blue-text bold-text">
                                <br>
                                Signature of the Centre Superintendent
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="1" cellpadding="3" cellspacing="0" width="100%" class="h7-text">
                    <tr>
                        <td width="40%">
                            <div class="center-text">
                                <img src="{{asset('/images/hallticket/covid19-nov2021.jpg')}}"  style="width:60%; height: 40%" class="img" />
                            </div>
                        </td>
                        <td width="30%" valign="bottom">
                            <div class="center-text bold-text blue-text">
                                Seal and Signature<br>
                                of the Study Centre
                            </div>
                        </td>
                        <td class="center-text bold-text blue-text" style="vertical-align: bottom" width="15%">
                            <img src="{{asset('/images/hallticket/Dr_Balabaskar.png')}}"  style="width: 80px;" class="img" />

                            <br>I/c NBER,<br>NIEPMD, Chennai
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
