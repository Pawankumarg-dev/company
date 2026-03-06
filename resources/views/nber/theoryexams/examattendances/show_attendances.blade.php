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
                                                <li class="active">Exam Attendance</li>
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
                                                                    {{ $externalexamcenter->code }} - {{ $externalexamcenter->name }}
                                                                </div>
                                                            </div>

                                                            <div class="panel-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-condensed">
                                                                        <tr>
                                                                            <th class="bg-info blue-text" width="15%">Examination Centre :</th>
                                                                            <th class="red-text">{{ $externalexamcenter->code }} - {{ $externalexamcenter->name }}</th>
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
                                                                        <tr>
                                                                            <th class="bg-info blue-text" width="15%">Uploaded File :</th>
                                                                            <th class="red-text">
                                                                                @if (!is_null($filename))
                                                                                    <a href="{{asset('files/examattendancefiles').'/'.$filename}}" target="_blank">
                                                                                        File &nbsp;&nbsp;<i class="fa fa-share-square-o"></i>
                                                                                    </a>
                                                                                @else
                                                                                    <span class="label label-danger">File Not Found</span>
                                                                                @endif
                                                                            </th>
                                                                        </tr>
                                                                    </table>
                                                                </div>

                                                                <p class="right-text">
                                                                    <a href="{{ url('/nber/theoryexams/examattendances/showupdateform/'.$exam->id.'/'.$externalexamcenter->id.'/'.$examtimetable->id.'/'.$approvedprogramme->id) }}" class="btn btn-sm btn-primary">
                                                                        <span class="glyphicon glyphicon-edit"></span>&nbsp;Update Attendance
                                                                    </a>
                                                                </p>

                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover blue-text">
                                                                        <tr>
                                                                            <th class="bg-info center-text" style="font-size: large" colspan="11">
                                                                                {{ $approvedprogramme->institute->code }} - {{ $approvedprogramme->institute->name }}
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th rowspan="2" class="center-text darkblue-background" width="5%">S.No.</th>
                                                                            <th rowspan="2" class="center-text darkblue-background" width="5%">Batch</th>
                                                                            <th colspan="3" class="center-text darkblue-background">Candidate Details</th>
                                                                            <th rowspan="2" class="center-text darkblue-background">Mark Attendance</th>
                                                                            <th rowspan="2" class="center-text darkblue-background" width="15%">Language written</th>
                                                                            <th rowspan="2" class="center-text darkblue-background" width="15%">Answer Booklet's<br>Serial No.</th>
                                                                            <th rowspan="2" class="center-text darkblue-background" width="15%">Reference<br>No.</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="center-text darkblue-background" width="10%">Photo</th>
                                                                            <th class="center-text darkblue-background" width="10%">Registration No.</th>
                                                                            <th class="center-text darkblue-background" width="20%">Name</th>
                                                                        </tr>

                                                                        @php $sno = 1; @endphp
                                                                        @foreach($markexamattendances as $markexamattendance)
                                                                            <tr>
                                                                                <td class="center-text">{{ $sno }}</td>
                                                                                <td class="center-text">{{ $markexamattendance->approvedprogramme->academicyear->year }}</td>
                                                                                <td class="center-text">
                                                                                    <img src="{{asset('/files/enrolment/photos')}}/{{$markexamattendance->application->candidate->photo}}"  style="width: 60px;" class="img" />
                                                                                </td>
                                                                                <td class="center-text">{{ $markexamattendance->application->candidate->enrolmentno }}</td>
                                                                                <td>{{ $markexamattendance->application->candidate->name }}</td>
                                                                                <td class="center-text">
                                                                                    @if($markexamattendance->externalattendance_id == 1)
                                                                                        <span class="label label-success">{{ strtoupper($markexamattendance->externalattendance->attendance) }}</span>
                                                                                    @else
                                                                                        <span class="label label-danger">{{ strtoupper($markexamattendance->externalattendance->attendance) }}</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td class="center-text">
                                                                                    @if($markexamattendance->language_id == 0)
                                                                                        <span class="label label-danger">NOT APPLICABLE</span>
                                                                                    @else
                                                                                        <span class="blue-text">{{ $markexamattendance->language->language }}</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td class="center-text">
                                                                                    @if($markexamattendance->externalattendance_id == 1)
                                                                                        <span class="blue-text">{{ $markexamattendance->answersheet_serialnumber }}</span>
                                                                                    @else
                                                                                        <span class="label label-danger">NOT APPLICABLE</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td class="center-text">
                                                                                    @if($markexamattendance->externalattendance_id == 1)
                                                                                        @if(!is_null($markexamattendance->dummy_number))
                                                                                            <span class="blue-text">{{ $markexamattendance->dummy_number }}</span>
                                                                                        @else
                                                                                            <span class="label label-danger">NOT AVAILABLE</span>
                                                                                        @endif
                                                                                    @else
                                                                                        <span class="label label-danger">NOT APPLICABLE</span>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            @php $sno++; @endphp
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
