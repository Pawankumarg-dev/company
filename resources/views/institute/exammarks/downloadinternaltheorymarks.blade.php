<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>NIEPMD NBER Examination Cell</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">


    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/3.3.6/bootstrap.min.css')}}" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset("packages/sweetalert/sweetalert.min.css")}}">

{{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

<!-- JavaScripts -->
    <script src="{{asset('js/2.2.3/jquery.min.js')}}" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="{{asset('js/bootstrap.min.js')}}" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="{{asset('js\chosen.jquery.min.js')}}"></script>
    {{-- <script src="{{asset('js/notify.min.js')}}"></script> --}}
    <script src="{{asset('packages/sweetalert/sweetalert.min.js')}}"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11 and Android browser -->
    <script src="{{asset('js/core.js')}}"></script>
    <link rel="stylesheet"  href="{{asset("css/style.css")}}" />
    @yield('style')
    <style>
        body {
            /*margin-top: -40px;*/
            background: #EEEEEE;
        }

        .equal-height-row {
            display: flex;
        }

        .minus15px-margin-top {
            margin-top: -15px !important;
        }

        .white-background {
            background-color: white;
            color: black;
        }

        .black-background {
            background-color: black;
            color: white;
        }

        .red-background {
            background-color: red;
            color: white;
        }

        .ghostwhite-background {
            background-color: ghostwhite;
            color: deepskyblue;
        }

        .darkblue-background {
            background-color: darkblue;
            color: white;
        }

        .green-background {
            background: green !important;
            color: white !important;
        }

        .grey-background {
            background: #EEEEEE;
        }

        .bold-text {
            font-weight: bold;
        }

        .center-text {
            text-align: center !important;
        }

        .left-text {
            text-align: left !important;
        }

        .right-text {
            text-align: right !important;
        }

        .green-text {
            color: darkgreen;
        }

        .red-text {
            color: red;
        }

        .blue-text {
            color: blue;
        }

        .brown-text {
            color: brown;
        }

        .yellow-text {
            color: yellow;
        }

        .icon-text {
            font-size: 30px;
        }

        .footer {
            background: #3fc3ee;
            color: white;
        }

        . {
            display: flex; /* equal height of the children */
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
<br>
@for($i = '2'; $i > '0'; $i--)
    @php $applicationcount = '0'; @endphp
    @foreach($applications as $app)
        @if($app->subject->syear == $i)
            @php $applicationcount++ @endphp
        @endif
    @endforeach

    @if($applicationcount > '0')
        @php $subjectcount = '0'; @endphp
        @foreach($subjects as $s)
            @if($s->syear == $i)
                @php $subjectcount++; @endphp
            @endif
        @endforeach

        <section class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-condensed">
                            <tr>
                                <th colspan="{{ (3 + $subjectcount * 2) }}" class="center-text blue-text">
                                    <b>NATIONAL INSTITUTE FOR EMPOWERMENT OF PERSONS WITH MULTIPLE DISABILITIES (DIVYANGJAN)</b><br>
                                    (DEPT. OF EMPOWERMENT OF PERSONS WITH DISABILITIES (DIVYANGJAN) MSJ&E, GOVT OF INDIA)<br>
                                    <b>National Board of Examination in Rehabilitation (NBER)</b><br>
                                    {{ $exam->name }} Examination
                                </th>
                            </tr>
                            <tr>
                                <th colspan="{{ (3 + $subjectcount * 2) }}" class="center-text blue-text">
                                    {{ $approvedprogramme->institute->code }} - {{ $approvedprogramme->institute->name }}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="{{ (3 + $subjectcount * 2) }}" class="center-text blue-text">
                                    {{ $i }}<sup>@if($i == '2') nd @else st @endif</sup> &nbsp;year - {{ $title }} - Online Mark Entry
                                </th>
                            </tr>
                            <tr>
                                <th rowspan="2" class="center-text blue-text">S. No.</th>
                                <th rowspan="2" class="center-text blue-text">Enrolment Numbers</th>

                                @foreach($subjects as $s)
                                    @if($s->syear == $i)
                                        <th colspan="2" class="center-text blue-text">{{ $s->scode }}</th>
                                    @endif
                                @endforeach

                                <th rowspan="2" class="center-text blue-text">Total</th>
                            </tr>
                            <tr>
                                @foreach($subjects as $s)
                                    @if($s->syear == $i)
                                        <td class="center-text">
                                            <u>Min</u><br> <span class="center-text"> {{ $s->imin_marks }} </span>
                                        </td>
                                        <td class="center-text">
                                            <u>Max</u><br> {{ $s->imax_marks }}
                                        </td>
                                    @endif
                                @endforeach

                            </tr>

                            @php $sno = '1'; @endphp
                            @foreach($candidates as $c)
                                @php $candidatecount = '0'; @endphp
                                @foreach($applications->where('candidate_id', $c->id) as $app)
                                    @if($app->subject->syear == $i)
                                        @php $candidatecount++ @endphp
                                    @endif
                                @endforeach

                                @if($candidatecount > '0')
                                    @php $count = '0'; $failcount = '0'; @endphp
                                    <tr>
                                        <td class="center-text blue-text">{{ $sno }}</td>
                                        <td class="center-text blue-text">{{ $c->enrolmentno }}</td>
                                        @foreach($subjects as $s)
                                            @if($s->syear == $i)
                                                <td colspan="2" class="center-text">
                                                    @php
                                                        $app = $applications->where('candidate_id', $c->id)->where('subject_id', $s->id)->first();
                                                    @endphp
                                                    @if(!is_null($app))
                                                        @php
                                                            $mark = $marks->where('application_id', $app->id)->first();
                                                        @endphp

                                                        @if(!is_null($mark))
                                                            @if(!is_null($mark->internal))
                                                                <span @if($mark->internal < $s->imin_marks || $mark->internal == 'Abs') class="red-text" @php $failcount++ @endphp @else class="green-text" @endif>
                                                                        {{ $mark->internal }}
                                                                    </span>

                                                                @if($mark->internal != 'Abs')
                                                                    @php $count += $mark->internal  @endphp
                                                                @endif
                                                            @endif
                                                        @else
                                                            <span class="red-text">
                                                                No Marks Entered
                                                                </span>
                                                        @endif
                                                    @else
                                                        Not Applied
                                                    @endif
                                                </td>
                                            @endif
                                        @endforeach
                                        <td class="center-text bold-text">
                                            @if($count > '0')
                                                <span @if($failcount > '0') class="red-text" @else class="green-text" @endif>
                                                    {{ $count }}
                                                    </span>
                                            @else
                                                <span class="red-text">
                                                        ---
                                                    </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @php $sno++; @endphp
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endfor
</body>
</html>


