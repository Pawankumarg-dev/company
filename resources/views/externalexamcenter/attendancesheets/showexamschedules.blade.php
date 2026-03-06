@extends('layouts.externalexamcenter')

@section('content')
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm darkblue-background">
                    <div class="center-text">
                        <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                        <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                        <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                        <span class="h8-text">(An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text blue-text">
                    {{ $externalexamcenter->code }} - {{ $externalexamcenter->name }},
                    @if($externalexamcenter->address != ''){{ $externalexamcenter->address }},@endif
                    @if($externalexamcenter->district != ''){{ $externalexamcenter->district }},@endif
                    @if($externalexamcenter->state != ''){{ $externalexamcenter->state }}@endif
                    @if($externalexamcenter->state != '') - {{ $externalexamcenter->pincode }}.@endif
                    @if($externalexamcenter->contactnumber1 != '')<br>Contact No(s): {{ $externalexamcenter->contactnumber1 }}@endif @if($externalexamcenter->contactnumber2 != ''), {{ $externalexamcenter->contactnumber2 }}@endif
                    @if($externalexamcenter->email1 != '')<br>Email(s): {{ $externalexamcenter->email1 }}@endif @if($externalexamcenter->email2 != ''), {{ $externalexamcenter->email2 }}@endif

                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text blue-text">
                        <a href="{{ url('externalexamcenter/showhomepage/'.$externalexamcenter->id) }}" class="btn btn-sm btn-success">Click to go for Home Page</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text blue-text h5-text">
                        {{ $title }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                @foreach($commonexamtimetables as $commonexamtimetable)
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                        <div class="blue-text">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <tr>
                                        <th class="bg-primary h5-text" colspan="6">Date of Examination : {{ $commonexamtimetable->startdate->format('d-m-Y') }}</th>
                                    </tr>
                                    <tr>
                                        <th class="center-text h6-text" width="5%">S.No.</th>
                                        <th class="center-text h6-text" width="13%">Course Code</th>
                                        <th class="center-text h6-text" width="10%">Subject Code</th>
                                        <th class="center-text h6-text" width="50%">Subject Name</th>
                                        <th class="center-text h6-text">Attendance Sheet</th>
                                        <th class="center-text h6-text" width="15%">Mark Attendance Online</th>
                                    </tr>

                                    @php $sno = '1'; @endphp
                                    @foreach($examtimetables as $et)
                                        @if($et->startdate == $commonexamtimetable->startdate)
                                            <tr>
                                                <td>{{ $sno }}</td>
                                                <td>{{ $et->subject->programme->common_code }}</td>
                                                <td>{{ $et->subject->scode }}</td>
                                                <td>{{ $et->subject->sname }}</td>
                                                <td class="center-text">
                                                    <a href="{{ url('/externalexamcenter/attendance/downloadsheet/'.$exam->id.'/'.$externalexamcenter->id.'/'.$et->id) }}"
                                                       target="_blank"
                                                       class="btn btn-success"
                                                    >
                                                        <i class="fa fa-arrow-circle-down"></i> Download
                                                    </a>
                                                </td>
                                                <td class="center-text">
                                                    @if($et->startdate->format('Y-m-d') <= \Carbon\Carbon::now()->format('Y-m-d'))
                                                        @if($et->startdate->format('Y-m-d') == \Carbon\Carbon::now()->format('Y-m-d'))
                                                            @if(($et->startdate->format('H') + 1) <= \Carbon\Carbon::now()->format('H'))
                                                                <div class="bold-text blue-text">
                                                                    <a href="{{ url('/externalexamcenter/attendance/markattendanceform/'.$exam->id.'/'.$externalexamcenter->id.'/'.$et->id) }}"
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
                                                            <a href="{{ url('/externalexamcenter/attendance/markattendanceform/'.$exam->id.'/'.$externalexamcenter->id.'/'.$et->id) }}"
                                                               target="_blank"
                                                               class="btn btn-warning"
                                                            >
                                                                <i class="glyphicon glyphicon-link"></i> Click here
                                                            </a>
                                                        @endif
                                                    @endif
                                                    {{--
                                                    @if($et->startdate == '2021-11-22 10:00:00' || $et->startdate == '2021-11-23 10:00:00' || $et->startdate == '2021-11-24 10:00:00' || $et->startdate == '2021-11-25 10:00:00' || $et->startdate == '2021-11-26 10:00:00' || $et->startdate == '2021-11-27 10:00:00' || $et->startdate == '2021-12-13 10:00:00' || $et->startdate == '2021-12-14 10:00:00')
                                                        <a href="{{ url('/externalexamcenter/attendance/markattendanceform/'.$exam->id.'/'.$externalexamcenter->id.'/'.$et->id) }}"
                                                           target="_blank"
                                                           class="btn btn-warning"
                                                        >
                                                            <i class="glyphicon glyphicon-link"></i> Click here
                                                        </a>
                                                    @endif
                                                    --}}
                                                </td>
                                            </tr>
                                            @php $sno++ @endphp
                                        @endif
                                    @endforeach
                                    {{--
                                    @foreach($examtimetables->where('startdate', $commonexamtimetable->startdate) as $et)
                                        <tr>
                                            <td>{{ $sno }}</td>
                                            <td>{{ $et->subject->programme->common_code }}</td>
                                            <td>{{ $et->subject->scode }}</td>
                                            <td>{{ $et->subject->sname }}</td>
                                            <td>
                                                <a href="{{ url('/externalexamcenter/attendance/downloadsheet/'.$exam->id.'/'.$externalexamcenter->id.'/'.$et->id) }}"
                                                   target="_blank"
                                                   class="btn btn-success"
                                                >
                                                    <i class="fa fa-arrow-circle-down"></i> Download
                                                </a>
                                            </td>
                                            <td>
                                                @if($et->startdate == '2020-12-08 10:00:00' || $et->startdate == '2020-12-07 10:00:00')
                                                    @php
                                                        $datafound = \App\Markexamattendance::where("exam_id", $exam->id)->where('externalexamcenter_id', $externalexamcenter->id)->where('examtimetable_id', $et->id)->exists();
                                                    @endphp

                                                    @if($datafound == 1)
                                                        <a href="{{ url('/externalexamcenter/attendance/show/'.$exam->id.'/'.$externalexamcenter->id.'/'.$et->id) }}"
                                                           target="_blank"
                                                           class="btn btn-success"
                                                        >
                                                            <i class="glyphicon glyphicon-eye"></i> View
                                                        </a>
                                                    @else
                                                        <a href="{{ url('/externalexamcenter/attendance/markattendanceform/'.$exam->id.'/'.$externalexamcenter->id.'/'.$et->id) }}"
                                                           target="_blank"
                                                           class="btn btn-primary"
                                                        >
                                                            <i class="glyphicon glyphicon-link"></i> Click here
                                                        </a>
                                                    @endif

                                                @endif
                                            </td>
                                        </tr>
                                        @php $sno++ @endphp
                                    @endforeach
                                    --}}
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection