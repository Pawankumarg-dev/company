@extends('layouts.app')

@section('content')

    <section class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Candidate Data Verification Status - {{ $academicyear->year }} Academic year
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <ul class="breadcrumb col-sm-12">
                                        <li><a href="{{url('/')}}">Home</a></li>
                                        <li><a href="{{url('/nber/enrolments')}}">Enrolments</a></li>
                                        <li><a href="{{url('/nber/enrolments/candidate-data/verification-status/'.$academicyear->id)}}">Candidate Data Verification Status - <b>{{ $academicyear->year }}</b></a></li>
                                        <li><b>{{ $status_remarks }} (Total: {{ $approvedprogrammesCount }})</b></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <p>Verification Status: <b>{{ $status_remarks }} (Total: {{ $approvedprogrammesCount }})</b></p>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-inline right-text">
                                        <label for="sel1">Change:</label>
                                        <select class="form-control" id="changeOptions">
                                            <option @if($status_remarks == 'Verification Pending') selected @endif value="{{ url('/nber/enrolments/candidate-data/approvedprogramme-list/'.$academicyear->id.'/6') }}">Verification Pending</option>
                                            <option @if($status_remarks == 'Pending') selected @endif value="{{ url('/nber/enrolments/candidate-data/approvedprogramme-list/'.$academicyear->id.'/1') }}">
                                                Pending
                                            </option>
                                            <option @if($status_remarks == 'Approved') selected @endif value="{{ url('/nber/enrolments/candidate-data/approvedprogramme-list/'.$academicyear->id.'/2') }}">Approved</option>
                                            <option @if($status_remarks == 'Rejected') selected @endif value="{{ url('/nber/enrolments/candidate-data/approvedprogramme-list/'.$academicyear->id.'/3') }}">Rejected</option>
                                            <option @if($status_remarks == 'Full') selected @endif value="{{ url('/nber/enrolments/candidate-data/approvedprogramme-list/'.$academicyear->id.'/4') }}">Full</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-condensed table-bordered blue-text" role="table">
                                            <thead>
                                            <tr>
                                                <th class="center-text" rowspan="2">S.No</th>
                                                <th class="center-text" colspan="2">Institute</th>
                                                <th class="center-text" rowspan="2">Course</th>
                                                @if($status_remarks != "Full")
                                                    <th class="center-text" rowspan="2">Status</th>
                                                @endif
                                                <th class="center-text" rowspan="2">Actions</th>
                                            </tr>
                                            <tr>
                                                <th class="center-text">Code</th>
                                                <th class="center-text" width="20%">Name</th>
                                            </tr>
                                            </thead>

                                            @php $sno = 1; @endphp
                                            <tbody>
                                            @foreach($approvedprogrammes as $approvedprogramme)
                                                <tr>
                                                    <td class="center-text" width="5%">
                                                        {{ $sno }} @php $sno++; @endphp
                                                    </td>
                                                    <td class="center-text" width="5%">
                                                        {{ $approvedprogramme->instituteCode }}
                                                    </td>
                                                    <td width="55%">
                                                        {{ strtoupper($approvedprogramme->instituteName) }}
                                                    </td>
                                                    <td width="15%">
                                                        {{ $approvedprogramme->courseCode }}
                                                    </td>
                                                    @if($status_remarks != "Full")
                                                        <td class="center-text" width="10%">
                                                        <span class="label label-{{ $status_class }}">
                                                        {{ $status_remarks }}
                                                        </span>
                                                        </td>
                                                    @endif
                                                    <td class="center-text" width="10%">
                                                        <a href="{{ url( $view_url.$approvedprogramme->id) }}" class="btn btn-primary btn-sm" target="_blank">
                                                            <span class="glyphicon glyphicon-eye-open"></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
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
    </section>

    <script>
        $(function(){
            $('#changeOptions').on('change', function () {
                var url = $(this).val(); // get selected value
                if (url) { // require a URL
                    window.location = url; // redirect
                }
                return false;
            });
        });
    </script>
@endsection

