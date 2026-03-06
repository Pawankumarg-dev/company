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
                                                <li class="active">Exam Schedules</li>
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
                                                                @foreach($commonexamtimetables as $commonexamtimetable)
                                                                    <div class="panel panel-primary">
                                                                        <div class="panel-heading">
                                                                            <div class="panel-title">
                                                                                <span class="h5-text">Date of Examination : {{ $commonexamtimetable->startdate->format('d-m-Y') }}</span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="panel-body">
                                                                            <div class="table-responsive">
                                                                                <table class="table table-bordered table-hover">
                                                                                    <tr>
                                                                                        <th class="center-text h6-text orange-text" width="5%">S.No.</th>
                                                                                        <th class="center-text h6-text orange-text" width="6%">Start<br>Time</th>
                                                                                        <th class="center-text h6-text orange-text" width="6%">End<br>Time</th>
                                                                                        <th class="center-text h6-text orange-text" width="13%">Course Code</th>
                                                                                        <th class="center-text h6-text orange-text" width="10%">Subject Code</th>
                                                                                        <th class="center-text h6-text orange-text" width="50%">Subject Name</th>
                                                                                        <th class="center-text h6-text orange-text" width="15%">Mark Attendance Online</th>
                                                                                        <th class="center-text h6-text orange-text" width="10%">Attendance<br>Counts</th>
                                                                                    </tr>

                                                                                    @php $sno = '1'; @endphp
                                                                                    @foreach($examtimetables as $et)
                                                                                        @if($et->startdate == $commonexamtimetable->startdate)
                                                                                            <tr>
                                                                                                <td class="blue-text center-text">{{ $sno }}</td>
                                                                                                <td class="blue-text center-text">{{ $et->startdate->format('h:i A') }}</td>
                                                                                                <td class="blue-text center-text">{{ $et->enddate->format('h:i A') }}</td>
                                                                                                <td class="blue-text">{{ $et->subject->programme->common_code }}</td>
                                                                                                <td class="blue-text center-text">{{ $et->subject->scode }}</td>
                                                                                                <td class="blue-text">{{ $et->subject->sname }}</td>
                                                                                                <td class="center-text">
                                                                                                    @if($et->startdate->format('Y-m-d') <= \Carbon\Carbon::now()->format('Y-m-d'))
                                                                                                        @if($et->startdate->format('Y-m-d') == \Carbon\Carbon::now()->format('Y-m-d'))
                                                                                                            @if(($et->startdate->format('H') + 1) <= \Carbon\Carbon::now()->format('H'))
                                                                                                                <div class="bold-text blue-text">
                                                                                                                    <a href="{{ url('/nber/theoryexams/examattendances/print-attendance-sheet/'.$exam->id.'/'.$examcenter->id.'/'.$et->id) }}"
                                                                                                                       target="_blank"
                                                                                                                       class="btn btn-warning"
                                                                                                                    >
                                                                                                                        <i class="glyphicon glyphicon-link"></i> Click here
                                                                                                                    </a>
                                                                                                                </div>
                                                                                                            @else
                                                                                                                Opens at
                                                                                                                <span class="h7-text label label-danger">{{ $et->startdate->addHour(1)->format('d-m-Y H:i A') }} </span>
                                                                                                            @endif
                                                                                                        @else
                                                                                                            <a href="{{ url('/nber/theoryexams/examattendances/'.$exam->id.'/'.$examcenter->id.'/'.$et->id) }}"
                                                                                                               target="_blank"
                                                                                                               class="btn btn-warning"
                                                                                                            >
                                                                                                                <i class="glyphicon glyphicon-link"></i> Click here
                                                                                                            </a>
                                                                                                        @endif
                                                                                                    @endif
                                                                                                </td>
                                                                                                <td class="center-text">
                                                                                                    {{--
                                                                                                    @php
                                                                                                        $count = \App\Application::where('exam_id', $exam->id)->where('externalexamcenter_id', $examcenter->id)->where('examtimetable_id', $et->id)->where('payment_status', "Approved")->where('internalresult_id', 1)->count('id');
                                                                                                        $attendanceCount = \App\Markexamattendance::whereIn('application_id', \App\Application::where('exam_id', $exam->id)->where('externalexamcenter_id', $examcenter->id)->where('examtimetable_id', $et->id)->where('payment_status', "Approved")->where('internalresult_id', 1)->pluck('id')->toArray())->count('id');
                                                                                                    @endphp
                                                                                                    <span class="red-text">{{ $attendanceCount }}</span>  / <span class="blue-text">{{ $count }}</span>
                                                                                                    @php unset($count); unset($count); @endphp
                                                                                                    --}}

                                                                                                    <span class="red-text">{{ $attendanceCounts->where('examtimetable_id', $et->id)->count('examtimetable_id') }}</span>  / <span class="blue-text">{{ $applications->where('examtimetable_id', $et->id)->count('examtimetable_id') }}</span>
                                                                                                </td>
                                                                                            </tr>
                                                                                            @php $sno++ @endphp
                                                                                        @endif
                                                                                    @endforeach
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
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
