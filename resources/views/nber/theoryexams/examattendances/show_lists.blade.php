@extends('layouts.app')
@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{ $exam->name }} Examinations - Exam Attendance
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
                                                <li class="active">Exam Attendance Lists</li>
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
                                                                    {{ $examcenter->code }} - {{ $examcenter->name }}
                                                                </div>
                                                            </div>

                                                            <div class="panel-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-condensed">
                                                                        <tr>
                                                                            <th class="bg-info blue-text" width="15%">Examination Centre :</th>
                                                                            <th class="red-text">{{ $examcenter->code }} - {{ $examcenter->name }}</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="bg-info blue-text" width="15%">Date of Examination :</th>
                                                                            <th class="red-text">{{ $examtimetable->startdate->format('d-m-Y') }} ({{ $examtimetable->startdate->format('H:i A') }} - {{ $examtimetable->enddate->format('H:i A') }})</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="bg-info blue-text" width="15%">Course Code :</th>
                                                                            <th class="red-text">{{ $examtimetable->subject->programme->course_name }}</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="bg-info blue-text" width="15%">Subject :</th>
                                                                            <th class="red-text">{{ $examtimetable->subject->scode }} - {{ $examtimetable->subject->sname }}</th>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover">
                                                                        <tr>
                                                                            <th class="bg-info center-text h6-text" width="5%">S.No.</th>
                                                                            <th class="bg-info center-text h6-text" width="7%">Study Centre Code</th>
                                                                            <th class="bg-info center-text h6-text" width="60%">Study Centre Name</th>
                                                                            <th class="bg-info center-text h6-text" >Batch</th>
                                                                            <th class="bg-info center-text h6-text" >Mark Attendance</th>
                                                                            <th class="bg-info center-text h6-text" >Update Attendance File</th>
                                                                            <th class="bg-info center-text h6-text" >View Attendance</th>
                                                                        </tr>

                                                                        @php $sno = '1'; @endphp
                                                                        @foreach($approvedprogrammes as $approvedprogramme)
                                                                            <tr>
                                                                                <td class="center-text blue-text">{{ $sno }}</td>
                                                                                <td class="center-text bold-text blue-text">{{ $approvedprogramme->institute->code }}</td>
                                                                                <td class="left-text blue-text">{{ $approvedprogramme->institute->name }}</td>
                                                                                <td class="center-text blue-text" width="5%">{{ $approvedprogramme->academicyear->year }}</td>
                                                                                @if($attendanceapprovedprogrammeIds->contains('approvedprogramme_id', $approvedprogramme->id))
                                                                                    <td class="center-text" width="10%">
                                                                                        <a href="{{ url('/nber/theoryexams/examattendances/showupdateform/'.$exam->id.'/'.$examcenter->id.'/'.$examtimetable->id.'/'.$approvedprogramme->id) }}"
                                                                                           target="_blank"
                                                                                           class="btn btn-success btn-sm"
                                                                                        >
                                                                                            <i class="glyphicon glyphicon glyphicon-edit"></i> Edit Attendance
                                                                                        </a>
                                                                                    </td>
                                                                                    <td class="center-text" width="10%">
                                                                                        <a href="{{ url('/examcenter/attendance/updateattendancesheetform/'.$exam->id.'/'.$examcenter->id.'/'.$examtimetable->id.'/'.$approvedprogramme->id) }}"
                                                                                           target="_blank"
                                                                                           class="btn btn-success btn-sm"
                                                                                        >
                                                                                            <i class="glyphicon glyphicon glyphicon-edit"></i> Update
                                                                                        </a>
                                                                                    </td>
                                                                                    <td class="center-text" width="10%">
                                                                                        <a href="{{ url('/nber/theoryexams/examattendances/showattendances/'.$exam->id.'/'.$examcenter->id.'/'.$examtimetable->id.'/'.$approvedprogramme->id) }}"
                                                                                           target="_blank"
                                                                                           class="btn btn-success btn-sm"
                                                                                        >
                                                                                            <i class="glyphicon glyphicon glyphicon-eye-open"></i> View
                                                                                        </a>
                                                                                    </td>
                                                                                @else
                                                                                    <td class="center-text" width="10%">
                                                                                        <a href="{{ url() }}"
                                                                                           target="_blank"
                                                                                           class="btn btn-primary btn-sm"
                                                                                        >
                                                                                            <i class="glyphicon glyphicon-plus"></i> Add Attendance
                                                                                        </a>
                                                                                    </td>
                                                                                    <td class="center-text" width="10%">
                                                                                        <div class="label label-danger">
                                                                                            <span class="glyphicon glyphicon-warning-sign"></span> NOT APPLICABLE
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="center-text" width="10%">
                                                                                        <div class="label label-danger">
                                                                                            <span class="glyphicon glyphicon-warning-sign"></span> Not Available
                                                                                        </div>
                                                                                    </td>
                                                                            @endif
                                                                            {{--
                                                                            <td class="center-text" width="10%">
                                                                                @php
                                                                                    $datafound = \App\Markexamattendance::where("exam_id", $exam->id)->where('examcenter_id', $examcenter->id)->where('examtimetable_id', $examtimetable->id)->where('approvedprogramme_id', $approvedprogramme->id)->first();
                                                                                @endphp

                                                                                @if($datafound)
                                                                                    <a href="{{ url('/examcenter/attendance/updatemarkedattendanceform/'.$exam->id.'/'.$examcenter->id.'/'.$examtimetable->id.'/'.$approvedprogramme->id) }}"
                                                                                       target="_blank"
                                                                                       class="btn btn-success btn-sm"
                                                                                    >
                                                                                        <i class="glyphicon glyphicon glyphicon-edit"></i> Edit Attendance
                                                                                    </a>
                                                                                @else
                                                                                    <a href="{{ url('/examcenter/attendance/markattendanceform/'.$exam->id.'/'.$examcenter->id.'/'.$examtimetable->id.'/'.$approvedprogramme->id) }}"
                                                                                       target="_blank"
                                                                                       class="btn btn-primary btn-sm"
                                                                                    >
                                                                                        <i class="glyphicon glyphicon-plus"></i> Add Attendance
                                                                                    </a>
                                                                                @endif
                                                                            </td>
                                                                            <td class="center-text" width="10%">
                                                                                @if($datafound == 1)
                                                                                    <a href="{{ url('/examcenter/attendance/showenteredmarks/'.$exam->id.'/'.$examcenter->id.'/'.$examtimetable->id.'/'.$approvedprogramme->id) }}"
                                                                                       target="_blank"
                                                                                       class="btn btn-success btn-sm"
                                                                                    >
                                                                                        <i class="glyphicon glyphicon glyphicon-eye-open"></i> View
                                                                                    </a>
                                                                                @endif
                                                                            </td>
                                                                            --}}
                                                                            @php $sno++ @endphp
                                                                        @endforeach
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
