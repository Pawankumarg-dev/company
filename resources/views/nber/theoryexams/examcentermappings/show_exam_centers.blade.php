@extends('layouts.app')
@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{ $exam->name }} Examinations - Exam Center Mappings
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li>
                                                    <a href="{{ url('/nber/exams') }}">Exams</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/nber/theoryexams/'.$exam->id) }}">{{ $exam->name }} Theory</a>
                                                </li>
                                                <li class="active">Exam Centre Mappings</li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-info">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <p class="center-text">
                                                            <a href="{{ url('/nber/theoryexams/examcentermapping/updateinstitutemappingform/'.$exam->id) }}" class="btn btn-sm btn-primary">
                                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;Institute Mapping
                                                            </a>
                                                            <a href="" class="btn btn-sm btn-primary">
                                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;Candidate Mapping
                                                            </a>
                                                            <a href="{{ url('/nber/theoryexams/examcentermapping/showmappedinstitutes/'.$exam->id) }}" class="btn btn-sm btn-success">
                                                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Mapped Institutes
                                                            </a>
                                                            <a href="{{ url('/nber/theoryexams/examcentermapping/showmappedcandidates/'.$exam->id) }}" class="btn btn-sm btn-success">
                                                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Mapped Candidates
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="panel panel-info">
                                                            <div class="panel-heading">
                                                                <div class="panel-title">
                                                                    Exam Center & Institute Mapping Details
                                                                </div>
                                                            </div>

                                                            <div class="panel-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover table-condensed" role="table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th width="5%">S.No.</th>
                                                                            <th width="5%">Exam Center Code</th>
                                                                            <th width="5%">Password</th>
                                                                            <th>Exam Center Name</th>
                                                                            <th>State</th>
                                                                            <th width="5%">Link</th>
                                                                            <th width="5%">Attendance</th>
                                                                        </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                        @if($examcenters->count() == 0)
                                                                            <tr>
                                                                                <td colspan="5" class="center-text red-text">No Records Found</td>
                                                                            </tr>
                                                                        @else
                                                                            @php $sno = 1; @endphp

                                                                            @foreach($examcenters as $examcenter)
                                                                                <tr>
                                                                                    <td>{{ $sno }} @php $sno++; @endphp</td>
                                                                                    <td>{{ $examcenter->code }}</td>
                                                                                    <td>{{ $examcenter->password }}</td>
                                                                                    <td>{{ $examcenter->name }}</td>
                                                                                    <td>{{ $examcenter->state }}</td>
                                                                                    <td class="center-text">
                                                                                        <a href="{{ url('/nber/theoryexams/examcentermapping/examcenterdetails/'.$exam->id.'/'.$examcenter->id) }}" class="btn btn-sm btn-info" target="_blank">
                                                                                            <span class="glyphicon glyphicon-hand-right"></span>&nbsp;
                                                                                            Go
                                                                                        </a>
                                                                                    </td>
                                                                                    <td class="center-text">
                                                                                        <a href="{{ url('/nber/theoryexams/examattendances/'.$exam->id.'/'.$examcenter->id) }}" class="btn btn-sm btn-success" target="_blank">
                                                                                            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;
                                                                                            View
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @endif
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
