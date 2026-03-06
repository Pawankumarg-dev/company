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

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm darkblue-background minus15px-margin-top">
                    <div class="center-text bold-text">

                        {{$title}}

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th class="bg-info blue-text" width="15%">Examination Centre :</th>
                                <th class="red-text">{{ $externalexamcenter->code }} - {{ $externalexamcenter->name }}</th>
                            </tr>
                            <tr>
                                <th class="bg-info blue-text" width="15%">Date of Examination :</th>
                                <th class="red-text">{{ $examtimetable->startdate->format('d-m-Y') }}</th>
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
                                    <td class="center-text">{{ $sno }}</td>
                                    <td class="center-text bold-text">{{ $approvedprogramme->institute->code }}</td>
                                    <td class="left-text">{{ $approvedprogramme->institute->name }}</td>
                                    <td class="center-text" width="5%">{{ $approvedprogramme->academicyear->year }}</td>
                                    @if($attendanceapprovedprogramme_ids->contains('approvedprogramme_id', $approvedprogramme->id))
                                        <td class="center-text" width="10%">
                                            <a href="{{ url('/externalexamcenter/attendance/updatemarkedattendanceform/'.$exam->id.'/'.$externalexamcenter->id.'/'.$examtimetable->id.'/'.$approvedprogramme->id) }}"
                                               target="_blank"
                                               class="btn btn-success btn-sm"
                                            >
                                                <i class="glyphicon glyphicon glyphicon-edit"></i> Edit Attendance
                                            </a>
                                        </td>
                                        <td class="center-text" width="10%">
                                            <a href="{{ url('/externalexamcenter/attendance/updateattendancesheetform/'.$exam->id.'/'.$externalexamcenter->id.'/'.$examtimetable->id.'/'.$approvedprogramme->id) }}"
                                               target="_blank"
                                               class="btn btn-success btn-sm"
                                            >
                                                <i class="glyphicon glyphicon glyphicon-edit"></i> Update
                                            </a>
                                        </td>
                                        <td class="center-text" width="10%">
                                            <a href="{{ url('/externalexamcenter/attendance/showenteredmarks/'.$exam->id.'/'.$externalexamcenter->id.'/'.$examtimetable->id.'/'.$approvedprogramme->id) }}"
                                               target="_blank"
                                               class="btn btn-success btn-sm"
                                            >
                                                <i class="glyphicon glyphicon glyphicon-eye-open"></i> View
                                            </a>
                                        </td>
                                    @else
                                        <td class="center-text" width="10%">
                                            <a href="{{ url('/externalexamcenter/attendance/markattendanceform/'.$exam->id.'/'.$externalexamcenter->id.'/'.$examtimetable->id.'/'.$approvedprogramme->id) }}"
                                               target="_blank"
                                               class="btn btn-primary btn-sm"
                                            >
                                                <i class="glyphicon glyphicon-plus"></i> Add Attendance
                                            </a>
                                        </td>
                                        <td class="center-text" width="10%">
                                            <span class="label label-danger">
                                                <span class="glyphicon glyphicon-warning-sign"></span> NOT APPLICABLE
                                            </span>
                                        </td>
                                        <td class="center-text" width="10%">
                                            <span class="label label-danger">
                                                <span class="glyphicon glyphicon-warning-sign"></span> Not Available
                                            </span>
                                        </td>
                                @endif
                                {{--
                                <td class="center-text" width="10%">
                                    @php
                                        $datafound = \App\Markexamattendance::where("exam_id", $exam->id)->where('externalexamcenter_id', $externalexamcenter->id)->where('examtimetable_id', $examtimetable->id)->where('approvedprogramme_id', $approvedprogramme->id)->first();
                                    @endphp

                                    @if($datafound)
                                        <a href="{{ url('/externalexamcenter/attendance/updatemarkedattendanceform/'.$exam->id.'/'.$externalexamcenter->id.'/'.$examtimetable->id.'/'.$approvedprogramme->id) }}"
                                           target="_blank"
                                           class="btn btn-success btn-sm"
                                        >
                                            <i class="glyphicon glyphicon glyphicon-edit"></i> Edit Attendance
                                        </a>
                                    @else
                                        <a href="{{ url('/externalexamcenter/attendance/markattendanceform/'.$exam->id.'/'.$externalexamcenter->id.'/'.$examtimetable->id.'/'.$approvedprogramme->id) }}"
                                           target="_blank"
                                           class="btn btn-primary btn-sm"
                                        >
                                            <i class="glyphicon glyphicon-plus"></i> Add Attendance
                                        </a>
                                    @endif
                                </td>
                                <td class="center-text" width="10%">
                                    @if($datafound == 1)
                                        <a href="{{ url('/externalexamcenter/attendance/showenteredmarks/'.$exam->id.'/'.$externalexamcenter->id.'/'.$examtimetable->id.'/'.$approvedprogramme->id) }}"
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
    </section>
@endsection
