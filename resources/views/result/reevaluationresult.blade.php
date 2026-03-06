@extends('layouts.result')

@section('content')

    <style>
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
            font-size: 16px;
            font-weight: bold;
        }
        .h5-text {
            font-size: 15px;
            font-weight: bold;
        }
        .h6-text {
            font-size: 13px;
        }
        .h7-text {
            font-size: 12px;
        }
        .h8-text {
            font-size: 10px;
        }

        table tr td {
            padding: 3px !important;
        }

        .left-custom-text {
            padding-left: 5px !important;
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
                        <span class="h5-text">{{$reevaluation->exam->name}} Re-evaluation Result Page</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-default btn-sm" onclick="printPage()">
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
                        <table class="text-primary" border="1" cellpadding="3" cellspacing="0" width="100%">
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
                                <td>Institute Code</td>
                                <td class="text-primary">{{ $candidate->approvedprogramme->institute->user->username }}</td>
                            </tr>

                            <tr>
                                <td>Institute Name</td>
                                <td>{{ $candidate->approvedprogramme->institute->name }}</td>
                            </tr>

                            <tr>
                                <td>Programme</td>
                                <td>{{ $candidate->approvedprogramme->programme->course_name }}</td>
                            </tr>
                        </table>

                        <br>
                        @php $sno = 0; @endphp
                        <table class="text-primary" border="1" cellpadding="5" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="left-custom-text">S. No</th>
                                    <th class="left-custom-text">Subject Code</th>
                                    <th class="left-custom-text">Subject Name</th>
                                    <th class="left-custom-text">Actual Marks</th>
                                    <th class="left-custom-text">Re-evaluated Marks</th>
                                    <th class="left-custom-text">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach($reevaluationresult as $ree)
                                @php $sno++; @endphp

                                <tr>
                                    <td class="left-custom-text">{{ $sno }}</td>
                                    <td class="left-custom-text">{{ $ree->subject->scode }}</td>
                                    <td class="left-custom-text">{{ $ree->subject->sname }}</td>
                                    <td class="left-custom-text">{{ $ree->actual_external_mark }}</td>
                                    <td class="left-custom-text">{{ $ree->reevaluated_external_mark }}</td>
                                    <td class="left-custom-text">{{ $ree->reevaluation_remarks }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="7" class="center-text">-- End of Statement --</td>
                            </tr>
                            </tbody>
                        </table>
                        <p>

                        </p>

                        <p>
                        <h5>
                            <span>
                                Date of Re-evaluation Result Published: <b>{{\Carbon\Carbon::parse($reevaluation->resultdate)->format('d-m-Y')}}</b>
                            </span>
                        </h5>
                        </p>
                    </div>
                    {{-- ./panel-body --}}

                    {{-- panel-footer --}}
                    <div class="panel-footer">


                    </div>
                    {{-- ./panel-footer --}}

                </div>
            </div>
        </div>
    </div>
@endsection



