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
                        <span class="h7-text"><b>National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</b></span><br>
                        <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                        <span class="h7-text"><b>National Board of Examination in Rehabilitation (NBER)</b></span><br>
                        <span class="h7-text"><b>{{$exam->name}} Examination - Student Result Page</b></span>
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
                        <table class="text-primary h7-text" border="1" cellpadding="5" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th colspan="3" class="center-text">Subject</th>
                                <th colspan="7" class="center-text">Marks</th>
                                <th rowspan="2" class="center-text" width="5%">Result</th>
                            </tr>

                            <tr>
                                <th class="center-text" width="7%">Code</th>
                                <th class="center-text" width="40%">Name</th>
                                <th class="center-text" width="5%">Type</th>
                                <th class="center-text" width="5%">Int<br>Min</th>
                                <th class="center-text" width="5%">Int<br>Max</th>
                                <th class="center-text" width="5%">Int Mark<br>Obtained</th>
                                <th class="center-text" width="5%">Ext<br>Min</th>
                                <th class="center-text" width="5%">Ext<br>Max</th>
                                <th class="center-text" width="5%">Ext Mark<br>Obtained</th>
                                <th class="center-text" width="5%">Total</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php
                                $grand_total = 0;
                                $grand_fail_count = 0;
                                $results = 0;
                                $totals = 0;
                            @endphp

                            @foreach($applications as $a)
                                @php
                                    $external = 0;
                                    $internal = 0;
                                    $total = 0;
                                    $fail_count = 0;
                                    $result = 0;

                                    $mark = $marks->where('application_id', $a->id)->first();
                                @endphp

                                <tr>
                                    <td>{{ $a->subject->scode }}</td>
                                    <td>{{ $a->subject->sname }}</td>
                                    <td class="center-text">{{ $a->subject->subjecttype->type }}</td>
                                    <td class="center-text">{{ $a->subject->imin_marks }}</td>
                                    <td class="center-text">{{ $a->subject->imax_marks }}</td>

                                    {{--  Internal --}}
                                    <td class="center-text bold-text">
                                        @php $fail_count++; @endphp
                                        @if(!is_null($mark))
                                            @if(!is_null($mark->internal))
                                                @php
                                                    $internal = $mark->internal;
                                                @endphp

                                                @if(is_numeric($internal))
                                                    @if($internal >= $a->subject->imin_marks)
                                                        @php $fail_count--; $result = 1; @endphp
                                                    @endif

                                                    @php $total += $internal; @endphp
                                                @endif

                                                <span @if($result == 1) class="green-text" @else class="red-text" @endif>{{ $internal }}</span>
                                            @endif
                                        @endif

                                    </td>
                                    {{--  ./Internal --}}

                                    <td class="center-text">{{ $a->subject->emin_marks }}</td>
                                    <td class="center-text">{{ $a->subject->emax_marks }}</td>

                                    {{--  External --}}
                                    <td class="center-text bold-text">
                                        @php $fail_count++; $result = 0; @endphp
                                        @if($a->withheld_status == 1)
                                            <span class="red-text bold-text">WH</span>
                                        @else
                                            @if(!is_null($mark))
                                                @if(!is_null($mark->external))
                                                    @php
                                                        $external = $mark->external;
                                                    @endphp

                                                    @if(is_numeric($external))
                                                        @php $external += (int) $mark->grace; @endphp

                                                        @if($external >= $a->subject->emin_marks)
                                                            @php $fail_count--; $result = 1; @endphp
                                                        @endif

                                                        @php $total += $external; @endphp
                                                    @endif

                                                    <span @if($result == 1) class="green-text" @else class="red-text" @endif>{{ $external }}</span>
                                                @endif
                                            @endif
                                        @endif


                                    </td>
                                    {{--  ./External --}}

                                    {{--  Total --}}
                                    <td class="center-text bold-text">
                                        @php $grand_total += $total; @endphp

                                        <span @if($fail_count == 0) class="green-text" @else class="red-text" @endif>{{ $total }}</span>

                                    </td>
                                    {{--  ./Total --}}

                                    {{--  Result --}}
                                    <td class="center-text bold-text">
                                        @if(!is_null($mark))
                                            @if($fail_count == 0)
                                                @php $mark->update(['result_id' => 1]); @endphp
                                            @else
                                                @php $mark->update(['result_id' => 0]); $grand_fail_count++; @endphp
                                            @endif

                                            <span @if($mark->result_id == 1) class="green-text" @else class="red-text" @endif>{{ $mark->result->result }}</span>
                                        @endif
                                    </td>
                                    {{--  ./Result --}}
                                </tr>
                            @endforeach

                            <tr>
                                <th colspan="9" class="right-text">Grand Total</th>
                                <td class="center-text bold-text">
                                    <span @if($grand_fail_count > 0) class="red-text" @else class="green-text" @endif>{{ $grand_total }}</span>
                                </td>
                                <td class="center-text bold-text">
                                    @if($grand_total != 0)
                                        <span @if($grand_fail_count > 0) class="red-text" @else class="green-text" @endif>
                                            @if($grand_fail_count == 0) Pass @else Fail @endif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="11" class="center-text">-- End of Statement --</td>
                            </tr>
                            </tbody>
                        </table>

                        <span class="h7-text">
                            Date of Result Published: <b>{{ $candidateexamresultdate->publish_date->format('d-m-Y') }}</b>
                            @if($withheldStatusCount != 0)
                                <span class="red-text bold-text">(WH - WITHHELD)</span>
                            @endif
                        </span>

                    </div>
                    {{-- ./panel-body --}}

                    {{-- panel-footer --}}
                    <div class="panel-footer h7-text">
                        <ul>
                            <li>
                                Disclaimer: This is an electronically generated information does not have any legal validity.
                                Notwithstanding the result published / declared, any case of UFM (Unfair means) if found will
                                make such result null and void.
                            </li>

                            <li>This will be valid for 3 months or issuance
                                of original mark statement, whichever is earlier.
                            </li>
                            {{--
                            <li>
                                <a href="{{asset('/files/documents/2018-re_evaluation_form.pdf')}}" target="_blank">Click here</a> to download Re-evaluation Form
                            </li>
                            --}}
                        </ul>

                    </div>
                    {{-- ./panel-footer --}}

                </div>
            </div>
        </div>
    </div>
@endsection



