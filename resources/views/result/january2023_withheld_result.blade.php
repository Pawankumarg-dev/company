@extends('layouts.result')

@section('content')

    <style>
        @media print {
            .hide-on-print {
                display: none;
            }
        }

        .h3-text {
            font-size: 30px;
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
        .bold-text {
            font-weight: bold;
        }
        .red-text {
            color: red;
        }
        .green-text {
            color: green;
        }
        .blue-text {
            color: blue;
        }
        .h4-text {
            font-size: 16px !important;
        }
        .h5-text {
            font-size: 15px !important;
        }
        .h6-text {
            font-size: 13px !important;
        }
        .h7-text {
            font-size: 12px !important;
        }
        .h8-text {
            font-size: 10px !important;
        }

        table tr td {
            padding: 3px !important;
        }

        .br-small {
            display: block;
            margin-bottom: -.4em;
        }

        .br-medium {
            display: block;
            margin-bottom: .7em;
        }
    </style>

    <script>
        function printPage() {
            window.print();
        }
    </script>

    {{-- Print Button - should be hide on printing --}}
    <div class="container-fluid hide-on-print">
        <div class="row">
            <div class="col-sm-12">
                <br>
                <div class="pull-right">
                    <button class="btn btn-primary btn-sm" onclick="window.print();return false;">
                        <span class="glyphicon glyphicon-print"></span> Print Result
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Header Part --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <table class="text-primary h7-text center-text" border="0" cellpadding="3" cellspacing="0" width="100%">
                    <tr>
                        <td>
                            <img src="{{asset('/images/rci_logo.png')}}"  style="width: 80px; height: 70px" class="img" />
                        </td>
                        <td>
                            <p>
                                <span class="h7-text"><b>REHABILITATION COUNCIL OF INDIA</b></span>
                                <span class="br-small"></span>
                                <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span>
                                <span class="br-small"></span>
                                <span class="h7-text"><b>National Board of Examination in Rehabilitation (NBER)</b></span>
                                <span class="br-small"></span>
                                <span class="h8-text">Examination body</span>
                                <span class="br-small"></span>
                                <span class="h7-text"><b>National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</b></span>
                                <span class="br-small"></span>
                                <span class="h7-text"><b>{{$exam->name}} Examination - Student Result Page</b></span>
                            </p>
                        </td>
                        <td>
                            <img src="{{asset('/images/niepmd_logo.png')}}"  style="width: 60px; height: 70px !important" class="img" />
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    {{-- panel-body --}}
                    <div class="panel-body">
                        <table class="text-primary h7-text" border="1" cellpadding="3" cellspacing="0" width="100%">
                            <tr>
                                <td width="15%"><b>Enrolment No</b></td>
                                <td>{{ $candidate->enrolmentno }}</td>
                                <td width="15%"><b>Name</b></td>
                                <td>{{ $candidate->name }}</td>
                                <td rowspan="3" width="10%">
                                    <div class="center-text">
                                        <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 100px;" class="img" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Date of Birth</b></td>
                                <td>{{ $candidate->dob->format('d-m-Y') }}</td>
                                <td><b>Programme</b></td>
                                <td>{{ $candidate->approvedprogramme->programme->course_name }}</td>
                            </tr>
                            <tr>
                                <td><b>Institute</b></td>
                                <td colspan="3">
                                    {{ $candidate->approvedprogramme->institute->code }} -
                                    {{ $candidate->approvedprogramme->institute->name }}
                                </td>
                            </tr>
                        </table>
                        <span class="br-medium"></span>
                        <table class="text-primary h6-text center-text" border="0" cellpadding="3" cellspacing="0" width="100%">
                            <tr>
                                <td>
                                    <span class="text-primary pull-right">
                                        <b>Director, NIEPMD</b>
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <p class="h7-text">
                            Result : <span class="red-text bold-text">Withheld @if(!is_null($candidateexamresultdate->withheld_status)){{ $candidateexamresultdate->withheld_remarks }}@endif</span>
                        </p>
                    </div>
                    {{-- ./panel-body --}}

                    {{-- panel-footer --}}
                    <div class="panel-footer h7-text">
                        <ul>
                            <li>
                                <b>Note</b>: The above details shall be printed in Statement of Marks and Diploma Certificate.
                                If there is any discrepancy, send Email (niepmd.examinations@gmail.com) within a duration of
                                fifteen days (15) (from 17<sup>th</sup> to 31<sup>st</sup> April, 2023).
                            </li>

                            <li>
                                <b>Disclaimer</b>: This is an electronically generated information does not have any legal validity.
                                Notwithstanding the result published / declared, any case of UFM (Unfair means) if found will
                                make such result null and void.
                            </li>

                            <li>This will be valid for 3 months or issuance
                                of original mark statement, whichever is earlier.
                            </li>
                        </ul>

                    </div>
                    {{-- ./panel-footer --}}
                </div>
            </div>
        </div>
    </div>
@endsection



