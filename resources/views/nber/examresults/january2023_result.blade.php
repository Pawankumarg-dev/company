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
            color: red !important;
        }
        .green-text {
            color: green !important;
        }
        .blue-text {
            color: blue !important;
        }
        .orange-text {
            color: darkorange !important;
        }
        .pink-text {
            color: deeppink !important;
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
                                <span class="h7-text"><b>{{$exam->name}} Examination - NBER Result Page</b></span>
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
                        <table class="text-primary h6-text" border="1" cellpadding="3" cellspacing="0" width="100%">
                            <tr>
                                <td width="10%">Result Status:</td>
                                <td>
                                    @if($candidateexamresultdate)
                                        @if($candidateexamresultdate->publish_status == 0)
                                            <span class="red-text bold-text">NOT PUBLISHED</span>
                                        @else
                                            @if($candidateexamresultdate->underreview_status == 1)
                                                <span class="orange-text bold-text">
                                                    {{ $candidateexamresultdate->underreview_remarks }}
                                                </span>
                                            @elseif($candidateexamresultdate->withheld_status == 1)
                                                <span class="red-text bold-text">WITHHELD {{ $candidateexamresultdate->withheld_remarks }}</span>
                                            @elseif($candidateexamresultdate->specialcase_status == 1)
                                                <span class="pink-text bold-text">
                                                    Published
                                                    (SPECIAL CASE - REF: {{$candidateexamresultdate->specialcase_remarks}})
                                                </span>
                                            @else
                                                <span class="green-text bold-text">Published</span>
                                            @endif
                                        @endif
                                    @else
                                        <span class="red-text bold-text">NOT AVAILABLE</span>
                                    @endif
                                </td>
                                <td width="11%">Result Date:</td>
                                <td width="15%">
                                    @if($candidateexamresultdate)
                                        @if($candidateexamresultdate->publish_status == 0)
                                            <span class="red-text bold-text">NOT APPLICABLE</span>
                                        @else
                                            @if($candidateexamresultdate->underreview_status == 1)
                                                <span class="orange-text bold-text">
                                                    NOT APPLICABLE
                                                </span>
                                            @elseif($candidateexamresultdate->withheld_status == 1)
                                                <span class="red-text bold-text">
                                                    NOT APPLICABLE
                                                </span>
                                            @elseif($candidateexamresultdate->specialcase_status == 1)
                                                @if(!is_null($candidateexamresultdate->publish_date))
                                                    <span class="pink-text bold-text">
                                                    {{ $candidateexamresultdate->publish_date->format('d-m-Y') }}
                                                    </span>
                                                @else
                                                    <span class="red-text bold-text">NOT AVAILABLE</span>
                                                @endif
                                            @else
                                                @if(!is_null($candidateexamresultdate->publish_date))
                                                    <span class="pink-text bold-text">
                                                        {{ $candidateexamresultdate->publish_date->format('d-m-Y') }}
                                                        </span>
                                                @else
                                                    <span class="red-text bold-text">NOT AVAILABLE</span>
                                                @endif
                                            @endif
                                        @endif
                                    @else
                                        <span class="red-text bold-text">NOT AVAILABLE</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <table class="text-primary h7-text" border="1" cellpadding="5" cellspacing="0" width="100%">
                            <thead>
                            @if($withheld > 0)
                                <tr>
                                    <td class="center-text bold-text" colspan="11">
                                        <span class="red-text" style="font-size: large">Result Withheld</span>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th class="center-text" width="5%">Subject<br>Code</th>
                                <th class="center-text" width="40%">Subject Name</th>
                                <th class="center-text" width="5%">Subject<br>Type</th>
                                <th class="center-text" width="5%">Int<br>Min</th>
                                <th class="center-text" width="5%">Int<br>Max</th>
                                <th class="center-text" width="5%">Int Mark<br>Obtained</th>
                                <th class="center-text" width="5%">Ext<br>Min</th>
                                <th class="center-text" width="5%">Ext<br>Max</th>
                                <th class="center-text" width="5%">Ext Mark<br>Obtained</th>
                                <th class="center-text" width="5%">Total</th>
                                <th class="center-text" width="5%">Result</th>
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
                            </tbody>
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

                            <li>
                                This will be valid for 3 months or issuance
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
