@extends('layouts.result')

@section('content')

    <style>
        @media print {
            #printPageButton {
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
            font-weight: bold !important;
        }
        .h5-text {
            font-size: 15px !important;
            font-weight: bold !important;
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
    </style>

    <script>
        function printPage() {
            window.print();
        }
    </script>

    {{-- container --}}
    <div class="container">
        <br>

        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <div class="center-text">
                    <div class="text-primary">
                        <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                        <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                        <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                        <span class="h5-text">{{$exam->name}} Examination Result Page</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-primary btn-sm" onclick="window.print();return false;" id="printPageButton">
                    <span class="glyphicon glyphicon-print"></span> Print Result
                </button>
            </div>
        </div>
    </div>
    {{-- ./container --}}

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">

                    {{-- panel-body --}}
                    <div class="panel-body">
                        <table class="text-primary h7-text" border="1" cellpadding="3" cellspacing="0" width="100%">
                            <tr>
                                <td width="15%">Enrolment No</td>
                                <td>{{ $candidate->enrolmentno }}</td>
                                <td rowspan="5" width="10%">
                                    <center>
                                        <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 100px;" class="img" />
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>{{ $candidate->name }}</td>
                            </tr>
                            <tr>
                                <td>Date of Birth</td>
                                <td>{{ $candidate->dob->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <td>Institute</td>
                                <td>
                                    {{ $candidate->approvedprogramme->institute->code }} -
                                    {{ $candidate->approvedprogramme->institute->name }}
                                </td>
                            </tr>
                            <tr>
                                <td>Programme</td>
                                <td>{{ $candidate->approvedprogramme->programme->course_name }}</td>
                            </tr>
                        </table>

                        <br>
                        <p class="h7-text">
                            Result : <span class="red-text bold-text">Withheld @if(!is_null($candidateexamresultdate->withheld_status)){{ $candidateexamresultdate->withheld_remarks }}@endif</span>
                        </p>

                    </div>
                    {{-- ./panel-body
                    <p>
                        <h5>
                            <span>
                                Date of Result Published: <b>{{ $date }}</b>
                            </span>
                        </h5>
                        </p>

                    panel-footer --}}
                    <div class="panel-footer h7-text">
                        <ul>
                            <li>
                                Disclaimer: This is an electronically generated information does not have any legal validity.
                                Notwithstanding the result published / declared, any case of UFM (Unfair means) if found will
                                make such result null and void.
                            </li>
                        </ul>

                    </div>
                    {{-- ./panel-footer --}}

                </div>
            </div>
        </div>
    </div>
@endsection



