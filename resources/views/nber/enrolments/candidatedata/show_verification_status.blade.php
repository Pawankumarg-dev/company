@extends('layouts.app');

@section('content')
    @php
        $verificationPendingPercentage = round(($verificationPendingCount / $totalCount)*100);
        $pendingPercentage = round(($pendingCount / $totalCount)*100);
        $approvedPercentage = round(($approvedCount / $totalCount)*100);
        $rejectedPercentage = round(($rejectedCount / $totalCount)*100);
    @endphp

    <input type="hidden" id="verificationPendingCount" value="{{ $verificationPendingPercentage }}">
    <input type="hidden" id="pendingCount" value="{{ $pendingPercentage }}">
    <input type="hidden" id="approvedCount" value="{{ $approvedPercentage }}">
    <input type="hidden" id="rejectedCount" value="{{ $rejectedPercentage }}">

    <section class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Candidate Data Verification Status - <b>{{ $academicyear->year }}</b> Academic year (Total: <b>{{ $totalCount }}</b>)
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="breadcrumb col-sm-12">
                                            <li><a href="{{url('/')}}">Home</a></li>
                                            <li><a href="{{url('/nber/enrolments')}}">Enrolments</a></li>
                                            <li>Candidate Data Verification Status - <b>{{ $academicyear->year }}</b> Academic year</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">
                                                            <div class="text-center bold-text">
                                                                Verification Pending
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="center-text h4-text">
                                                                {{ $verificationPendingCount }} / {{ $totalCount }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="center-text">
                                                                <a href="{{ url('/nber/enrolments/candidate-data/approvedprogramme-list/'.$academicyear->id.'/6') }}" class="btn btn-sm btn-info">
                                                                    view details
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="panel panel-warning">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">
                                                            <div class="text-center bold-text">
                                                                Pending
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="center-text h4-text">
                                                                {{ $pendingCount }} / {{ $totalCount }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="center-text">
                                                                <a href="{{ url('/nber/enrolments/candidate-data/approvedprogramme-list/'.$academicyear->id.'/1') }}" class="btn btn-sm btn-info">
                                                                    view details
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="panel panel-success">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">
                                                            <div class="text-center bold-text">
                                                                Approved
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="center-text h4-text">
                                                                {{ $approvedCount }} / {{ $totalCount }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="center-text">
                                                                <a href="{{ url('/nber/enrolments/candidate-data/approvedprogramme-list/'.$academicyear->id.'/2') }}" class="btn btn-sm btn-info">
                                                                    view details
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="panel panel-danger">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">
                                                            <div class="text-center bold-text">
                                                                Rejected
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="center-text h4-text">
                                                                {{ $rejectedCount }} / {{ $totalCount }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="center-text">
                                                                <a href="{{ url('/nber/enrolments/candidate-data/approvedprogramme-list/'.$academicyear->id.'/3') }}" class="btn btn-sm btn-info">
                                                                    view details
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-condensed table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="center-text" width="5%">S.No.</th>
                                                    <th class="center-text" width="20%">Verification Status</th>
                                                    <th class="center-text" width="5%">%</th>
                                                    <th class="center-text" width="35%">Progress</th>
                                                    <th class="center-text" width="10%">Count</th>
                                                    <th class="center-text" width="10%">View</th>
                                                    <th class="center-text" width="10%">Download</th>
                                                </tr>
                                                </thead>

                                                @php $sno = 1; @endphp
                                                <tbody>
                                                <tr>
                                                    <td class="center-text">{{ $sno }} @php $sno++; @endphp</td>
                                                    <td>Verification Pending</td>
                                                    <td class="center-text">{{ $verificationPendingPercentage }} %</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div id="verificationPendingProgressBar" class="progress-bar progress-bar-default progress-bar-striped active" role="progressbar">

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="center-text">{{ $verificationPendingCount }}</td>
                                                    <td class="center-text">
                                                        <a href="{{ url('/nber/enrolments/candidate-data/approvedprogramme-list/'.$academicyear->id.'/6') }}" class="btn btn-xs btn-info">
                                                            <span class="glyphicon glyphicon-eye-open"></span>
                                                        </a>
                                                    </td>
                                                    <td class="center-text">
                                                        <a href="" class="btn btn-xs btn-info disabled">
                                                            <span class="glyphicon glyphicon-download-alt"></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="center-text">{{ $sno }} @php $sno++; @endphp</td>
                                                    <td>Pending</td>
                                                    <td class="center-text">{{ $pendingPercentage }} %</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div id="pendingProgressBar" class="progress-bar progress-bar-default progress-bar-striped active" role="progressbar">

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="center-text">{{ $pendingCount }}</td>
                                                    <td class="center-text">
                                                        <a href="{{ url('/nber/enrolments/candidate-data/approvedprogramme-list/'.$academicyear->id.'/1') }}" class="btn btn-xs btn-info">
                                                            <span class="glyphicon glyphicon-eye-open"></span>
                                                        </a>
                                                    </td>
                                                    <td class="center-text">
                                                        <a href="" class="btn btn-xs btn-info disabled">
                                                            <span class="glyphicon glyphicon-download-alt"></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="center-text">{{ $sno }} @php $sno++; @endphp</td>
                                                    <td>Approved</td>
                                                    <td class="center-text">{{ $approvedPercentage }} %</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div id="approvedProgressBar" class="progress-bar progress-bar-default progress-bar-striped active" role="progressbar">

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="center-text">{{ $approvedCount }}</td>
                                                    <td class="center-text">
                                                        <a href="{{ url('/nber/enrolments/candidate-data/approvedprogramme-list/'.$academicyear->id.'/2') }}" class="btn btn-xs btn-info">
                                                            <span class="glyphicon glyphicon-eye-open"></span>
                                                        </a>
                                                    </td>
                                                    <td class="center-text">
                                                        <a href="" class="btn btn-xs btn-info disabled">
                                                            <span class="glyphicon glyphicon-download-alt"></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="center-text">{{ $sno }} @php $sno++; @endphp</td>
                                                    <td>Rejected</td>
                                                    <td class="center-text">{{ $rejectedPercentage }} %</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div id="rejectedProgressBar" class="progress-bar progress-bar-default progress-bar-striped active" role="progressbar">

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="center-text">{{ $rejectedCount }}</td>
                                                    <td class="center-text">
                                                        <a href="{{ url('/nber/enrolments/candidate-data/approvedprogramme-list/'.$academicyear->id.'/3') }}" class="btn btn-xs btn-info">
                                                            <span class="glyphicon glyphicon-eye-open"></span>
                                                        </a>
                                                    </td>
                                                    <td class="center-text">
                                                        <a href="" class="btn btn-xs btn-info disabled">
                                                            <span class="glyphicon glyphicon-download-alt"></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="bold-text center-text">Total</td>
                                                    <td class="bold-text red-text center-text">{{ $totalCount }}</td>
                                                    <td class="center-text">
                                                        <a href="{{ url('/nber/enrolments/candidate-data/approvedprogramme-list/'.$academicyear->id.'/4') }}" class="btn btn-xs btn-info">
                                                            <span class="glyphicon glyphicon-eye-open"></span>
                                                        </a>
                                                    </td>
                                                    <td class="center-text">
                                                        <a href="" class="btn btn-xs btn-info disabled">
                                                            <span class="glyphicon glyphicon-download-alt"></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
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
        $(document).ready(function(){
            $('#verificationPendingProgressBar').css("width", $('#verificationPendingCount').val()+"%");
            $('#pendingProgressBar').css("width", $('#pendingCount').val()+"%");
            $('#approvedProgressBar').css("width", $('#approvedCount').val()+"%");
            $('#rejectedProgressBar').css("width", $('#rejectedCount').val()+"%");
        });
    </script>
@endsection