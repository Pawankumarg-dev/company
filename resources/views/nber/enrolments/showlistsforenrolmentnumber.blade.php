@php set_time_limit(0); @endphp

@extends('layouts.app');

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Enrolment Number Status - Academic Year {{ $academicyear->year }}
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="pull-right">
                                    <a href="{{ url('/enrolments/download-enrolment-verification-details/'.$academicyear->id) }}" class="btn btn-danger">
                                        <span class="glyphicon glyphicon-download"></span>
                                        Excel Download
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover table-condensed table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="bg-info center-text">S.No.</th>
                                            <th class="bg-info center-text">Institute Code</th>
                                            <th class="bg-info center-text" width="25%">Institute Name</th>
                                            <th class="bg-info center-text" width="13%">Programme</th>
                                            <th class="bg-info center-text">Registered Count</th>
                                            <th class="bg-info center-text">Verification Pending Count</th>
                                            <th class="bg-info center-text">Approved Count</th>
                                            <th class="bg-info center-text">Pending Count</th>
                                            <th class="bg-info center-text">Rejected Count</th>
                                            <th class="bg-info center-text">Enrolment Given Count</th>
                                            <th class="bg-info center-text">Enrolment Not Given Count</th>
                                        </tr>
                                        </thead>

                                        @php
                                            $sno = 1;
                                            $grandRegisteredCount = 0;
                                            $grandVerificationPendingCount = 0;
                                            $grandApprovedCount = 0;
                                            $grandPendingCount = 0;
                                            $grandRejectedCount = 0;
                                            $grandEnrolmentCount = 0;
                                            $grandDifferenceCount = 0;
                                        @endphp
                                        <tbody>
                                        @foreach($approvedprogrammes as $approvedprogramme)
                                            @php
                                                $registeredCount = $approvedprogramme->registered_count;
                                                $verificationPendingCount = $approvedprogramme->verificationpending_count;
                                                $approvedCount = $approvedprogramme->approved_count;
                                                $pendingCount = $approvedprogramme->pending_count;
                                                $rejectedCount = $approvedprogramme->rejected_count;
                                                $enrolmentCount = $approvedprogramme->enrolment_count;
                                                $differenceCount = (int) $approvedCount - (int) $enrolmentCount;

                                                $grandRegisteredCount += (int) $registeredCount;
                                                $grandVerificationPendingCount += (int) $verificationPendingCount;
                                                $grandApprovedCount += (int) $approvedCount;
                                                $grandPendingCount += (int) $pendingCount;
                                                $grandRejectedCount += (int) $rejectedCount;
                                                $grandEnrolmentCount += (int) $enrolmentCount;
                                                $grandDifferenceCount += (int) $differenceCount;
                                            @endphp
                                            <tr>
                                                <td class="center-text">{{ $sno }} @php $sno++; @endphp</td>
                                                <td class="center-text">{{ $approvedprogramme->institute->code }}</td>
                                                <td>{{ $approvedprogramme->institute->name }}</td>
                                                <td>{{ $approvedprogramme->programme->course_name }}</td>
                                                <td class="center-text">
                                            <span class="label label-default">
                                            {{ $registeredCount }}
                                            </span>
                                                </td>
                                                <td class="center-text">
                                            <span class="label label-default">
                                            {{ $verificationPendingCount }}
                                            </span>
                                                </td>
                                                <td class="center-text">
                                            <span class="label label-success">
                                            {{ $approvedCount }}
                                            </span>
                                                </td>
                                                <td class="center-text">
                                            <span class="label label-warning">
                                            {{ $pendingCount }}
                                            </span>
                                                </td>
                                                <td class="center-text">
                                            <span class="label label-danger">
                                            {{ $rejectedCount }}
                                            </span>
                                                </td>
                                                <td class="center-text">
                                            <span class="label label-info">
                                            {{ $enrolmentCount }}
                                            </span>
                                                </td>
                                                <td class="center-text">
                                            <span class="label label-danger">
                                            {{ $differenceCount }}
                                            </span>
                                                </td>
                                            </tr>
                                            @php
                                                unset($approvedprogramme);
                                                unset($verificationPendingCount);
                                                unset($approvedCount);
                                                unset($pendingCount);
                                                unset($rejectedCount);
                                                unset($enrolmentCount);
                                                unset($differenceCount);
                                            @endphp
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th class="right-text" colspan="4">Total</th>
                                            <th class="center-text">
                                        <span class="label label-default">
                                            {{ $grandRegisteredCount }}
                                        </span>
                                            </th>
                                            <th class="center-text">
                                        <span class="label label-default">
                                            {{ $grandVerificationPendingCount }}
                                        </span>
                                            </th>
                                            <th class="center-text">
                                        <span class="label label-success">
                                            {{ $grandApprovedCount }}
                                        </span>
                                            </th>
                                            <th class="center-text">
                                        <span class="label label-warning">
                                            {{ $grandPendingCount }}
                                        </span>
                                            </th>
                                            <th class="center-text">
                                        <span class="label label-danger">
                                            {{ $grandRejectedCount }}
                                        </span>
                                            </th>
                                            <th class="center-text">
                                        <span class="label label-info">
                                            {{ $grandEnrolmentCount }}
                                        </span>
                                            </th>
                                            <th class="center-text">
                                        <span class="label label-danger">
                                            {{ $grandDifferenceCount }}
                                        </span>
                                            </th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $( document ).ready(function() {
            $(".dataExport").click(function() {
                var exportType = $(this).data('type');
                $('#dataTable').tableExport({
                    type : exportType,
                    escape : 'false',
                    ignoreColumn: []
                });
            });

            $('#csv').on('click',function(){
                $("#dataTable").tableHTMLExport({

                    // csv, txt, json, pdf
                    type:'csv',

                    // default file name
                    filename: 'tableHTMLExport.csv',

                    // for csv
                    separator: ',',
                    newline: '\r\n',
                    trimContent: true,
                    quoteFields: true,

                    // CSS selector(s)
                    ignoreColumns: '',
                    ignoreRows: '',

                    // your html table has html content?
                    htmlContent: false,

                    // debug
                    consoleLog: false,

                });
            })
        });
    </script>
@endsection
