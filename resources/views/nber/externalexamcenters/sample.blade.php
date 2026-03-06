<!DOCTYPE html>
<html>
<head>
    <title>{{ $externalexamcenter->code }} Students Count - {{ $exam->name }} Exam</title>
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
            <td class="h6-text center-text bold-text"><u>TIMETABLE, STUDENTS DETAILS, EXAM HALL AND INVILIGATOR - JUNE 2019 EXAM</u></td>
        </tr>
    </table>

    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
        <tr>
            <td class="h7-text left-text" colspan="2">Exam Center:</td>
            <td class="h7-text left-text" colspan="12">
                ({{ $externalexamcenter->code }}) - {{ $externalexamcenter->name }},
                {{ $externalexamcenter->address }}, {{ $externalexamcenter->district }},
                {{ $externalexamcenter->state }} - {{ $externalexamcenter->pincode }}.
                @if($externalexamcenter->contactnumber1 != '')<br>Contact Number(s) :{{ $externalexamcenter->contactnumber1 }}@endif @if($externalexamcenter->contactnumber2 != ''), {{ $externalexamcenter->contactnumber2 }}@endif
                @if($externalexamcenter->email1 != '') Email(s) :{{ $externalexamcenter->email1 }}@endif @if($externalexamcenter->email2 != ''), {{ $externalexamcenter->email2 }}@endif
            </td>
        </tr>
        <tr>
            <th class="h7-text center-text" rowspan="2">Date</th>
            <th class="h7-text center-text" rowspan="2">Day</th>
            <th class="h7-text center-text" rowspan="2">Batch</th>
            <th class="h7-text center-text" rowspan="2">Time</th>
            <th class="h7-text center-text" rowspan="2">Examination</th>
            <th class="h7-text center-text" rowspan="2">No. of Students</th>
            <th class="h7-text center-text" rowspan="2">No. of Rooms</th>
            <th class="h7-text center-text" rowspan="2">No. of Invigilators</th>
            <th class="h7-text center-text" colspan="6">Amount Details</th>
        </tr>
        <tr>
            <th class="h7-text center-text">Room Rent<br>per day</th>
            <th class="h7-text center-text">Invigilator</th>
            <th class="h7-text center-text">CS</th>
            <th class="h7-text center-text">Postal<br>(Actual)</th>
            <th class="h7-text center-text">Miscellaneous</th>
            <th class="h7-text center-text">Total Amount</th>
        </tr>
        </thead>

        <tbody>

        @foreach($examdates as $examdate)
            @foreach($examtimetables as $ext)
                @if($ext->examdate == $examdate->examdate)
                    {{ $ext->subject->scode }}
                @endif
            @endforeach
        @endforeach

        </tbody>

    </table>
</div>