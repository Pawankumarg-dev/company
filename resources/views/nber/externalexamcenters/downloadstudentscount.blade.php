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
        @php $grand_total_count = 0; @endphp
        @foreach($examdates as $date)
            @php $day_count = 0;@endphp
            @foreach($examtimetables as $et)
                @if($et->examdate == $date->examdate)
                    @php $day_count++; @endphp
                @endif
            @endforeach

            @if($day_count == '2')
                @php
                    $room_count = 0;
                    $room_count1 = 0;
                    $room_count2 = 0;
                    $room_count3 = 1;
                @endphp

                @foreach($examtimetables as $et)
                    @if($et->examdate == $date->examdate)
                        @php $app_count = $applications->where('subject_id', $et->subject_id)->count(); @endphp
                        @if($room_count3 == 1)
                            @php $room_count1 = 0; @endphp
                            @if($app_count > 33)
                                @php $room_count1 = ceil(( $app_count / 30 )); @endphp
                            @else
                                @php $room_count1 = 1; @endphp
                            @endif
                        @else
                            @php $room_count2 = 0; @endphp
                            @if($app_count > 33)
                                @php $room_count2 = ceil(( $app_count / 30 )); @endphp
                            @else
                                @php $room_count2 = 1; @endphp
                            @endif

                        @endif
                    @endif
                    @php $room_count3++; @endphp
                @endforeach
                @php
                    $room_count = max($room_count1, $room_count2);

                    $count = 2; $invigilator_count = 0;
                @endphp

                @foreach($examtimetables as $et)
                    @if($et->examdate == $date->examdate)
                        <tr>
                            <td class="h7-text center-text">{{ $et->startdate->format("d.m.Y") }}</td>
                            <td class="h7-text center-text">{{ $et->startdate->format("l") }}</td>
                            <td class="h7-text center-text">
                                B - {{ $et->subject->syear }}
                            </td>
                            <td class="h7-text center-text">{{ $et->startdate->format("h:i A") }} - {{ $et->enddate->format("h:i A") }}</td>
                            <td class="h7-text center-text">
                                @if($et->subject->syear == "1")
                                    I
                                @else
                                    II
                                @endif
                                year
                            </td>
                            @php
                                $app_count = $applications->where('subject_id', $et->subject_id)->count();
                                $invigilator_count = 0;
                            @endphp
                            @if($app_count > 33)
                                @php $invigilator_count = ceil(($app_count / 30 )); @endphp
                            @else
                                @php $invigilator_count = 1; @endphp
                            @endif

                            <td class="h7-text bold-text center-text">
                                {{ $app_count }}
                            </td>
                            @if($count == '2')
                                <td class="h7-text bold-text center-text" rowspan="2">
                                    {{ $room_count }}
                                </td>
                            @endif
                            <td class="h7-text bold-text center-text">
                                {{ $invigilator_count }}
                            </td>
                            <td class="h7-text bold-text center-text">
                                {{ $room_count * 1000}}
                            </td>
                            <td class="h7-text bold-text center-text">
                                {{ $invigilator_count * 1000 }}
                            </td>
                            <td class="h7-text bold-text center-text">
                                1250
                            </td>
                            <td class="h7-text bold-text center-text">
                                250
                            </td>
                            <td class="h7-text bold-text center-text">
                                300
                            </td>
                            <td class="h7-text bold-text center-text">
                                @php
                                    $total_count = ($room_count * 1000) + ($invigilator_count * 1000) + 1250 + 250 + 300;
                                    $grand_total_count += $total_count;
                                @endphp

                                {{ $total_count }}
                            </td>
                        </tr>
                        @php $count--; @endphp
                    @endif
                @endforeach
            @else
                @php $count = 0; @endphp
                @foreach($examtimetables as $et)
                    @if($et->examdate == $date->examdate)
                        <tr>
                            <td class="h7-text center-text">{{ $et->startdate->format("d.m.Y") }}</td>
                            <td class="h7-text center-text">{{ $et->startdate->format("l") }}</td>
                            <td class="h7-text center-text">
                                B - {{ $et->subject->syear }}
                            </td>
                            <td class="h7-text center-text">{{ $et->startdate->format("h:i A") }} - {{ $et->enddate->format("h:i A") }}</td>
                            <td class="h7-text center-text">
                                @if($et->subject->syear == "1")
                                    I
                                @else
                                    II
                                @endif
                                year
                            </td>
                            @php

                                $app_count = $applications->where('subject_id', $et->subject_id)->count();
                                $invigilator_count = 0;
                            @endphp
                            {{ $ap }}
                            @if($app_count > 33)
                                @php $invigilator_count = ceil(($app_count / 30 )); @endphp
                            @else
                                @php $invigilator_count = 1; @endphp
                            @endif

                            <td class="h7-text bold-text center-text">
                                {{ $app_count }}
                            </td>
                            <td class="h7-text bold-text center-text">
                                {{ $invigilator_count }}
                            </td>
                            <td class="h7-text bold-text center-text">
                                {{ $invigilator_count }}
                            </td>
                            <td class="h7-text bold-text center-text">
                                {{ $invigilator_count * 2000}}
                            </td>
                            <td class="h7-text bold-text center-text">
                                {{ $invigilator_count * 1000 }}
                            </td>
                            <td class="h7-text bold-text center-text">
                                1250
                            </td>
                            <td class="h7-text bold-text center-text">
                                250
                            </td>
                            <td class="h7-text bold-text center-text">
                                300
                            </td>
                            <td class="h7-text bold-text center-text">
                                @php
                                    $total_count = ($invigilator_count * 1000) + ($invigilator_count * 1000) + 1250 + 250 + 300;
                                    $grand_total_count += $total_count;
                                @endphp

                                {{ $total_count }}
                            </td>
                        </tr>
                        @php $count--; @endphp
                    @endif
                @endforeach
            @endif

        @endforeach

        </tbody>

        {{--
        @foreach($examdates as $date)
            @foreach($examtimetables->where('startdate', $date) as $et)
                <tr>
                    <td class="h7-text center-text">{{ $et->startdate->format("d.m.Y") }}</td>
                    <td class="h7-text center-text">{{ $et->startdate->format("l") }}</td>
                    <td class="h7-text center-text">
                        B - {{ $et->subject->syear }}
                    </td>
                    <td class="h7-text center-text">{{ $et->startdate->format("h:i A") }} - {{ $et->enddate->format("h:i A") }}</td>
                    <td class="h7-text center-text">
                        @if($et->subject->syear == "1")
                            I
                        @else
                            II
                        @endif
                        year
                    </td>
                    <td class="h7-text bold-text center-text">
                        @php $application_count = $applications->where('subject_id', $et->subject_id)->count(); @endphp

                        {{ $application_count }}
                    </td>
                    @if($application_count == 0)
                        @php $count = '0'; @endphp
                        <td class="h7-text bold-text center-text">{{ $count }}</td>
                        <td class="h7-text bold-text center-text">{{ $count }}</td>
                        <td class="h7-text bold-text center-text">{{ $count }}</td>
                        <td class="h7-text bold-text center-text">{{ $count }}</td>
                        <td class="h7-text bold-text center-text">{{ $count }}</td>
                        <td class="h7-text bold-text center-text">{{ $count }}</td>
                        <td class="h7-text bold-text center-text">{{ $count }}</td>
                        <td class="h7-text bold-text center-text">{{ $count }}</td>
                    @else
                        @if($application_count < 30)
                            @php $count = '1'; @endphp
                        @else
                            @php $count = (round( $application_count / 30 )); @endphp
                            @if($application_count % 30 != 0)
                                @php $count++; @endphp
                            @endif
                        @endif

                        <td class="h7-text bold-text center-text">
                            {{ $count }}
                        </td>
                        <td class="h7-text bold-text center-text">
                            {{ $count }}
                        </td>
                        <td class="h7-text bold-text center-text">
                            {{ $count * 2000 }}
                        </td>
                        <td class="h7-text bold-text center-text">
                            {{ $count * 1000 }}
                        </td>
                        <td class="h7-text bold-text center-text">
                            1250
                        </td>
                        <td class="h7-text bold-text center-text">
                            250
                        </td>
                        <td class="h7-text bold-text center-text">
                            300
                        </td>
                        @php
                            $total_count = (integer) (( $count * 3000) + 1800);
                            $grand_total_count += (integer) $total_count;
                        @endphp
                        <td class="h7-text bold-text center-text">
                            Rs. {{ $total_count }}
                        </td>
                    @endif
                </tr>
            @endforeach
        @endforeach
        --}}

        <tr>
            <td class="h7-text bold-text right-text" colspan="13">
                Grand Total
            </td>
            <td class="h7-text bold-text center-text">
                Rs. {{ $grand_total_count }}
            </td>
        </tr>

        <tr>
            <td class="h8-text bold-text right-text" colspan="14">
                Director, <br>NIEPMD
            </td>
        </tr>
    </table>
</div>


