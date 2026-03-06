<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Marks - {{$exam->name}} Examination</title>

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
        .brown-text {
            color: #be2626;
        }
        .deeppink-text {
            color: deeppink;
        }
        .lightgrey-background {
            background-color: lightgrey !important;
        }
        .h4-text {
            font-size: 20px;
            font-weight: bold;
        }
        .h3-text {
            font-size: 12px;
        }
        .left-text{
            float: left;
        }
        .bold-text{
            font-weight: bold;
        }
        .center-text{
            text-align: center !important;
        }
        .right-text{
            float: right;
            margin-right: 100px;
        }
        .circle-text{
            background: #ff0000;
            color: #fff;
            padding: 5px 5px;
            border-radius: 50%;
            font-size: 10px;
        }
        .underline-text{
            text-decoration: underline;
        }
        .blink-text {
            animation: blinker .5s linear infinite;
            color: red;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }

        .btn-circle {
            width: 20px;
            height: 20px;
            text-align: center;
            padding: 5px 0;
            font-size: 10px;
            line-height: .5;
            border-radius: 15px;
        }
        .fail-text {
            font-weight: bold;
            font-size: 20px;
        }
        thead{
            display: table-header-group;
        }

        .number-circle {
            background: #fff;
            border: 2px solid red;
            border-radius: 0.8em;
            -moz-border-radius: 0.8em;
            -webkit-border-radius: 0.8em;
            color: red;
            display: inline-block;
            font-weight: bold;
            line-height: 1.6em;
            text-align: center;
            width: 1.6em;
        }

    </style>

    <script>
        function printPage() {
            window.print();
        }
    </script>
</head>
<body>
<p><button onclick="printPage()">Print Marks</button> </p>

@for($i = $approvedprogramme->programme->numberofterms; $i>0; $i--)
    @if($applications->where('term', $i)->count() > '0')
        <br />
        <div class="page-break">
            {{-- table-1: Institute and Programme details --}}
            <table role="table" border="1" cellpadding="3" cellspacing="0" class="h3-text">
                <tr>
                    <td><span class="h3-text green-text">Institute Code :</span></td>
                    <td><span class="h3-text blue-text">{{$approvedprogramme->institute->user->username}}</span></td>
                </tr>

                <tr>
                    <td><span class="h3-text green-text">Institute Name :</span></td>
                    <td><span class="h3-text blue-text">{{$approvedprogramme->institute->name}}</span></td>
                </tr>

                <tr>
                    <td><span class="h3-text green-text">Programme Name :</span></td>
                    <td><span class="h3-text blue-text">{{$approvedprogramme->programme->course_name}}</span></td>
                </tr>
            </table>
            {{-- ./table-1: Institute and Programme details --}}
            <br />
            {{-- table-2: Candidates Marks --}}
            <table role="table" border="1" cellpadding="3" cellspacing="0" class="h3-text">
                {{-- table-2 Heading: --}}
                <thead>
                <tr>
                    <td rowspan="2" class="center-text bold-text green-text">Enrolment No</td>
                    <td rowspan="2" class="center-text bold-text green-text">Name</td>

                    @foreach($subjects as $s)
                        @if($s->syear == $i)
                            <td colspan="5">
                                <span class="center-text bold-text blue-text">{{$s->scode}}</span> <br />
                                <span class="center-text bold-text blue-text">({{$s->subjecttype->type}})</span> <br />
                                IN_MIN: <span class="bold-text blue-text">{{$s->imin_marks}}</span> <br />
                                IN_MAX: <span class="bold-text blue-text">{{$s->imax_marks}}</span> <br />
                                EX_MIN: <span class="bold-text blue-text">{{$s->emin_marks}}</span> <br />
                                EX_MAX: <span class="bold-text blue-text">{{$s->emax_marks}}</span> <br />
                            </td>
                        @endif
                    @endforeach

                    <td rowspan="2" class="center-text bold-text brown-text">Grand<br />Total</td>
                    <td rowspan="2" class="center-text bold-text brown-text">Result</td>
                </tr>
                @foreach($subjects as $s)
                    @if($s->syear == $i)
                        <td class="center-text"><span class="bold-text">IN</span></td>
                        <td class="center-text"><span class="bold-text">EX</span></td>
                        <td class="center-text"><span class="bold-text">GR</span></td>
                        <td class="center-text"><span class="bold-text">TO</span></td>
                        <td class="center-text"><span class="bold-text">P/F</span></td>
                    @endif
                @endforeach
                <tr>

                </tr>
                </thead>
                {{-- ./table-2 Heading: --}}

                {{-- table-2 Body: --}}
                <tbody>

                @foreach($candidates as $c)
                    @if($applications->where('candidate_id', $c->id)->where('term', $i)->count() > 0)
                        @php
                            $grand_total = '0';
                            $fail_count = '0';
                        @endphp
                        <tr>
                            <td class="center-text">
                                <span class="bold-text blue-text">{{$c->enrolmentno}}</span>
                            </td>
                            <td>
                                <span class="bold-text blue-text">{{$c->name}}</span>
                            </td>

                            @foreach($subjects as $s)
                                @if($s->syear == $i)
                                    @if($applications->where('candidate_id', $c->id)->where('subject_id', $s->id)->count() > 0)
                                        @php
                                            $app = $applications->where('candidate_id', $c->id)->where('subject_id', $s->id)->first();
                                            $m = $marks->where('application_id', $app->id)->first();

                                            $total = '0';
                                            $fail = '0';
                                        @endphp

                                        @if(is_null($m))
                                            <td class="center-text">&#9673;</td>
                                            <td class="center-text">&#9673;</td>
                                            <td class="center-text">&#9673;</td>
                                            <td class="center-text">&#9673;</td>
                                            <td class="center-text">&#9673;</td>

                                            @php
                                                $fail++;
                                                $fail_count++;
                                            @endphp
                                        @else
                                            @php
                                                $internal = $m->internal;
                                                $external = $m->external;
                                                $grace = $m->grace;
                                            @endphp

                                            {{-- Internal --}}
                                            <td class="center-text">
                                                @if(is_null($internal) || $internal == '')
                                                    <span style="font-size: 15px;">&#8853;</span>
                                                @elseif($internal == 'Abs')
                                                    <span class="bold-text underline-text red-text">
                                                        Abs
                                                    </span>
                                                @elseif((int) $internal < $s->imin_marks)
                                                    <span class="bold-text red-text number-circle">
                                                        {{$internal}}
                                                    </span>
                                                @else
                                                    <span class="bold-text blue-text">
                                                        {{$internal}}
                                                    </span>
                                                @endif
                                            </td>
                                            {{-- ./Internal --}}

                                            {{-- External --}}
                                            <td class="center-text">
                                                @if(is_null($external) || $external == '')
                                                    <span style="font-size: 15px;">&#8864;</span>
                                                @elseif($external == 'Abs')
                                                    <span class="bold-text red-text underline-text">
                                                        Abs
                                                    </span>
                                                @else
                                                    @if($s->subjecttype->type == 'Practical')
                                                        @if($s->emin_marks > (int) $external)
                                                            <span class="bold-text number-circle">
                                                                {{$external}}
                                                            </span>
                                                        @else
                                                            <span class="bold-text blue-text">
                                                                {{$external}}
                                                            </span>
                                                        @endif
                                                    @else
                                                        @if($s->emin_marks > (int) $external)
                                                            @if($s->emin_marks - (int) $external <= '3')
                                                                <span class="bold-text underline-text red-text">
                                                                    {{$external}}
                                                                </span>
                                                            @else
                                                                <span class="bold-text red-text number-circle">
                                                                    {{$external}}
                                                                </span>
                                                            @endif
                                                        @else
                                                            <span class="bold-text blue-text">
                                                                    {{$external}}
                                                            </span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                            {{-- ./External --}}

                                            {{-- Grace Marks --}}
                                            <td class="center-text">
                                                <span class="bold-text deeppink-text">
                                                    {{$m->grace}}
                                                </span>
                                            </td>
                                            {{-- ./Grace Marks --}}

                                            {{-- Total --}}
                                            <td class="center-text">
                                                @if(is_null($internal) || is_null($external))
                                                    @if(is_null($internal) && is_null($external))
                                                        @php
                                                            $total = '0';
                                                        @endphp
                                                    @elseif(!is_null($internal) && is_null($external))
                                                        @php
                                                            $total = (int) $internal;
                                                        @endphp
                                                    @else
                                                        @php
                                                            $total = (int) $external + (int) $grace;
                                                        @endphp
                                                    @endif

                                                    @php
                                                        $fail++;
                                                        $fail_count++;
                                                    @endphp
                                                @elseif($internal == 'Abs' || $external == 'Abs')
                                                    @if($internal == 'Abs' && $external == 'Abs')
                                                        @php
                                                            $total = '0';
                                                        @endphp
                                                    @elseif($internal != 'Abs' && $external == 'Abs')
                                                        @php
                                                            $total = (int) $internal;
                                                        @endphp
                                                    @else
                                                        @php
                                                            $total = (int) $external + (int) $grace;
                                                        @endphp
                                                    @endif

                                                    @php
                                                        $fail++;
                                                        $fail_count++;
                                                    @endphp
                                                @else
                                                    @php
                                                        $total = (int) $internal + (int) $external + (int) $grace;
                                                    @endphp
                                                @endif

                                                @php
                                                    $grand_total += $total;
                                                @endphp

                                                @if($internal < $s->imin_marks || (int) $external + $grace < $s->emin_marks)
                                                    @php
                                                        $fail++;
                                                        $fail_count++;
                                                    @endphp
                                                @endif

                                                @if($fail > 0)
                                                    <span class="bold-text red-text">{{$total}}</span>
                                                @else
                                                    <span class="bold-text blue-text">{{$total}}</span>
                                                @endif

                                            </td>
                                            {{-- ./Total --}}

                                            {{-- Subject Pass/Fail Remarks --}}
                                            <td class="center-text">
                                                {{--<button type="button" class="btn btn-default btn-circle" disabled>F</button>
                                                <span class="circle-text">F</span>--}}

                                                @if($fail > 0)
                                                    <span class="fail-text red-text">Ⓕ</span>
                                                @else
                                                    <span class="bold-text blue-text">P</span>
                                                @endif

                                            </td>
                                            {{-- ./Subject Pass/Fail Remarks --}}
                                        @endif
                                    @else
                                        <td class="center-text red-text">&#9587;</td>
                                        <td class="center-text red-text">&#9587;</td>
                                        <td class="center-text red-text">&#9587;</td>
                                        <td class="center-text red-text">&#9587;</td>
                                        <td class="center-text red-text">&#9587;</td>

                                    @endif
                                @endif
                            @endforeach

                            {{-- Grand Total --}}
                            <td class="center-text bold-text">
                                @if($fail_count > 0)
                                    <span class="red-text">{{$grand_total}}</span>
                                @else
                                    <span class="blue-text">{{$grand_total}}</span>
                                @endif


                            </td>
                            {{-- ./Grand Total --}}

                            {{-- Overall Result --}}
                            <td class="center-text bold-text">
                                @if($fail_count > 0)
                                    <span class="fail-text red-text">Ⓕ</span>
                                @else
                                    <span class="bold-text blue-text">P</span>
                                @endif
                            </td>
                            {{-- ./Overall Result --}}
                        </tr>
                    @endif
                @endforeach

                </tbody>
                {{-- ./table-2 Body: --}}
            </table>
            {{-- ./table-2: Candidates Marks --}}
        </div>
    @endif
@endfor


{{--
@foreach($applications as $app)
                        @if($app->subject->id == $s->id)
                            @if($app->candidate->id == $c->id)
                                <td>{{$s->scode}}</td>
                            @endif
                        @endif
                    @endforeach
--}}


</body>
</html>