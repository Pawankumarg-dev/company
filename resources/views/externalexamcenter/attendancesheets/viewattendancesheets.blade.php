<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">


    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('packages/bootstrap-3.3.7/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sweetalert/sweetalert.min.css')}}">
    <link rel="stylesheet"  href="{{asset('packages/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" />

{{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

<!-- JavaScripts -->
    <script src="{{asset('js/2.2.3/jquery.min.js')}}" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="{{ asset('packages/moment/moment.min.js') }}"></script>
    <script src="{{asset('packages/bootstrap-3.3.7/js/bootstrap.min.js')}}"></script>

    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="{{asset('js\chosen.jquery.min.js')}}"></script>
    {{-- <script src="{{asset('js/notify.min.js')}}"></script> --}}
    <script src="{{asset('packages/sweetalert/sweetalert.min.js')}}"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11 and Android browser -->
    <script src="{{asset('js/core.js')}}"></script>

    <!-- Datetimepicker Bootstrap -->
    <script src="{{ asset('packages/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- ./Datetimepicker Bootstrap -->

    <script src="{{ asset('packages/bootstrap-fileinput/bootstrap.file-input.js') }}"></script>
    <link rel="stylesheet"  href="{{asset('css/style.css')}}" />
    <link rel="stylesheet"  href="{{asset('packages/bootstrap-imageupload/dist/css/bootstrap-imageupload.css')}}" />

    <script src="{{ asset('packages/bootstrap-imageupload/dist/js/bootstrap-imageupload.js') }}"></script>

    <!-- Bootstrap Toggle -->
    <link href="{{asset('css/bootstrap-toggle.min.css') }}" rel="stylesheet">
    <script src="{{asset('js/bootstrap-toggle.min.js') }}"></script>
    <!-- ./Bootstrap Toggle -->
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
            #noprint {
                display: none;
            }
            thead {display: table-header-group;}
            tfoot {display: table-footer-group;}
        }
        .justified-text {
            text-align: justify;
            text-justify: inter-word;
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

@foreach($approvedprogrammes as $ap)
    @if($applications->where('approvedprogramme_id', $ap->id)->where('subject_id', $examtimetable->subject_id)->count() > 0)
        <div class="page-break">
            <div class="table-responsive">
                <table border="1" class="table table-bordered table-condensed">
                    <colgroup>
                        <col width="5%"><col width="5%">
                        <col width="5%"><col width="5%">
                        <col width="5%"><col width="5%">
                        <col width="5%"><col width="5%">
                        <col width="5%"><col width="5%">
                        <col width="5%"><col width="5%">
                        <col width="5%"><col width="5%">
                        <col width="5%"><col width="5%">
                        <col width="5%"><col width="5%">
                        <col width="5%"><col width="5%">
                    </colgroup>
                    <thead>
                    <tr>
                        <th colspan="20" class="center-text">
                            <div class="h7-text">
                                <strong>National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan) [NIEPMD]</strong><br>
                                (Dept. of Empowerment of Persons with Multiple Disabilities (Divyangjan), MSJ&E, Govt. of India)<br>
                                <strong><u>National Board of Examination in Rehabilitation (NBER)</u></strong><br>
                                <strong>{{ $exam->name }} Exam - Attendance Sheets</strong>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <td class="h7-text bold-text" colspan="2">Study Center</td>
                        <td class="h7-text bold-text" colspan="8">{{ $ap->institute->code }} - {{ $ap->institute->name }}</td>
                        <td class="h7-text bold-text" colspan="2">Exam Center</td>
                        <td class="h7-text bold-text" colspan="8">{{ $externalexamcenter->code }} - {{ $externalexamcenter->name }}, {{ $externalexamcenter->state }}</td>
                    </tr>
                    <tr>
                        <td class="h7-text bold-text" colspan="2">Course</td>
                        <td class="h7-text bold-text" colspan="8">{{ $ap->programme->course_name }}</td>
                        <td class="h7-text bold-text" colspan="2">Batch</td>
                        <td class="h7-text bold-text" colspan="8">{{ $ap->academicyear->year }}</td>
                    </tr>
                    <tr>
                        <td class="h7-text bold-text" colspan="2">Subject</td>
                        <td class="h7-text bold-text" colspan="8">{{ $examtimetable->subject->scode }} - {{ $examtimetable->subject->sname }}</td>
                        <td class="h7-text bold-text" colspan="2">Date & Time</td>
                        <td class="h7-text bold-text" colspan="8">{{ $examtimetable->startdate->format('d-m-Y h:i A') }} [{{ $examtimetable->startdate->format('l') }}]</td>
                    </tr>
                    <tr>
                        <th class="h7-text bold-text center-text" colspan="1">S.No.</th>
                        <th class="h7-text bold-text center-text" colspan="2">Photo</th>
                        <th class="h7-text bold-text center-text" colspan="2">Enrolment<br>No.</th>
                        <th class="h7-text bold-text center-text" colspan="3">Name</th>
                        <th class="h7-text bold-text center-text" colspan="2">Language<br>writing</th>
                        <th class="h7-text bold-text center-text" colspan="5">Answer Sheet<br>Sl.No.</th>
                        <th class="h7-text bold-text center-text" colspan="3">Candidate<br>Signature</th>
                        <th class="h7-text bold-text center-text" colspan="3">Invigilator<br>Signature</th>
                    </tr>
                    </thead>

                    <tbody>
                    @php $sno = 1; @endphp
                    @foreach($candidates->where('approvedprogramme_id', $ap->id) as $c)
                        @if($applications->where('candidate_id', $c->id)->where('subject_id', $examtimetable->subject_id)->count() > 0)
                            <tr>
                                <td class="h7-text bold-text center-text" colspan="1">{{ $sno }}</td>
                                <td class="h7-text bold-text center-text" colspan="2">
                                    <img src="{{asset('/files/enrolment/photos')}}/{{$c->photo}}"  style="width: 60px;" class="img" />
                                </td>
                                <td class="h7-text bold-text center-text" colspan="2">{{ $c->enrolmentno }}</td>
                                <td class="h7-text bold-text left-text" colspan="3">{{ $c->name }}</td>
                                <td class="h7-text bold-text center-text" colspan="2"></td>
                                <td class="h7-text bold-text center-text" colspan="5"></td>
                                <td class="h7-text bold-text center-text" colspan="3"></td>
                                <td class="h7-text bold-text center-text" colspan="3"></td>
                            </tr>
                            @php $sno++; @endphp
                        @endif
                    @endforeach
                    </tbody>

                    <tfoot>
                    <tr>
                        <td  colspan="20" class="h7-text">
                            <div class="center-text bold-text"><u>Declaration</u></div>
                            <div class="justified-text">
                                Certified that the attendance details of the Candidates appeared in the {{ $exam->name }} Examinations were verified and submitted by the <b>Invigilator</b>;
                                and the same details have been updated in the <b>Online Exam Attendance Mark Entry</b> by the <b>Technical Staff</b>.
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="h7-text bold-text left-text" colspan="10">
                            Name of the Invigilator :<br>
                            Contact Number :
                        </td>
                        <td class="h7-text bold-text left-text" colspan="10">
                            Name of the Technical Staff :<br>
                            Contact Number :
                        </td>
                    </tr>
                    <tr>
                        <td class="h7-text bold-text center-text" colspan="5">
                            <br><br>Signature of the CS
                        </td>
                        <td class="h7-text bold-text center-text" colspan="10">
                            <br><br>Seal
                        </td>
                        <td class="h7-text bold-text center-text" colspan="5">
                            <br><br>Signature of the CLO
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif
@endforeach
</body>