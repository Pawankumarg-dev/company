<!DOCTYPE html>
<html>
<head>
    <title>{{ $externalexamcenterdetail->institute->code }} Exam Attendance Sheet - {{ $exam->name }} Exam</title>
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

@foreach($examtimetables as $et)
    @foreach($approvedprogrammes as $ap)
        @if($applications->where('approvedprogramme_id', $ap->id)->where('subject_id', $et->subject_id)->count() > 0)
            <div class="page-break">
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td class="right-text" width="5%">
                            <img src="{{asset('/images/niepmd.png')}}"  style="width: 60px;" class="img" />
                        </td>
                        <td>
                            <span class="h7-text bold-text">NATIONAL INSTITUTE FOR EMPOWERMENT OF PERSONS WITH MULITPLE DISABILITIES (DIVYANGJAN) [NIEPMD]</span><br>
                            <span class="h8-text">(DEPT. OF EMPOWERMENT OF PERSONS WITH DISABILIITIES (DIVYANGJAN), MSJ&E, GOVT. OF INDIA)</span><br>
                            <span class="h7-text bold-text">NATIONAL BOARD OF EXAMINATION IN REHABILITATION (NBER)</span><br>
                            <span class="h8-text">(An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)</span><br>
                            <span class="h8-text">ECR, Muttukadu, Kovalam Post, Chennai-603112, Tamil Nadu.</span><br>
                            <span class="h8-text">Email: niepmd.examinations@gmail.com</span>
                        </td>
                    </tr>
                </table>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td class="h6-text center-text bold-text"><u>Attendance Sheet for Theory Examination - {{ $exam->name }} Exam</u></td>
                    </tr>
                </table>
                <table border="1" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td class="h7-text bold-text" width="20%">Study Center</td>
                        <td class="h7-text bold-text" width="30%">{{ $externalexamcenterdetail->institute->code }} - {{ $externalexamcenterdetail->institute->name }}</td>
                        <td class="h7-text bold-text" width="20%">Study Center</td>
                        <td class="h7-text bold-text" width="30%">{{ $externalexamcenterdetail->externalexamcenter->code }} - {{ $externalexamcenterdetail->externalexamcenter->name }}, {{ $externalexamcenterdetail->externalexamcenter->state }}</td>
                    </tr>
                    <tr>
                        <td class="h7-text bold-text">Course</td>
                        <td class="h7-text bold-text">{{ $ap->programme->course_name }}</td>
                        <td class="h7-text bold-text">Batch</td>
                        <td class="h7-text bold-text">{{ $ap->academicyear->year }}</td>
                    </tr>
                    <tr>
                        <td class="h7-text bold-text">Subject</td>
                        <td class="h7-text bold-text">{{ $et->subject->scode }} - {{ $et->subject->sname }}</td>
                        <td class="h7-text bold-text">Date & Time</td>
                        <td class="h7-text bold-text">{{ $et->startdate->format('d-m-Y h:i A') }} [{{ $et->startdate->format('l') }}]</td>
                    </tr>
                </table>
                <table border="1" cellpadding="5" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="h7-text bold-text center-text" width="3%">S.No.</th>
                        <th class="h7-text bold-text center-text">Photo</th>
                        <th class="h7-text bold-text center-text">Name</th>
                        <th class="h7-text bold-text center-text">Enrolment No.</th>
                        <th class="h7-text bold-text center-text">DoB</th>
                        <th class="h7-text bold-text center-text">Answer Sheet<br>Sl.No.</th>
                        <th class="h7-text bold-text center-text" width="20%">Signature</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $sno = 1; @endphp
                    @foreach($candidates->where('approvedprogramme_id', $ap->id) as $c)
                        @if($applications->where('candidate_id', $c->id)->where('subject_id', $et->subject_id)->count() > 0)
                            <tr>
                                <td class="h7-text bold-text center-text">{{ $sno }}</td>
                                <td class="h7-text bold-text left-text">{{ $c->name }}</td>
                                <td class="h7-text bold-text center-text">{{ $c->enrolmentno }}</td>
                                <td class="h7-text bold-text center-text">{{ $c->dob->format('d-m-Y') }}</td>
                                <td class="h7-text bold-text center-tex"></td>
                                <td class="h7-text bold-text center-tex"></td>
                                <td class="h7-text bold-text center-tex"></td>
                            </tr>
                            @php $sno++; @endphp
                        @endif
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td class="h7-text bold-text right-text" colspan="7"><br/><br/>Signature of the Invigilator</td>
                    </tr>
                    <tr>
                        <td class="h7-text bold-text right-text" colspan="5">Name of the Invigilator</td>
                        <td class="h7-text bold-text right-text" colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="h7-text bold-text right-text" colspan="5">Contact Number</td>
                        <td class="h7-text bold-text right-text" colspan="2"></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    @endforeach
@endforeach

</body>