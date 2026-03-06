@extends('layouts.app')
@section('content')

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text blue-text">
                    {{ $approvedprogramme->programme->course_name }} - {{ $term_no }} <sup>@if($term_no == '1') st @else nd @endif</sup> &nbsp; (Year / Term) - Class Attendance Upload
                </div>
            </div>
        </div>
    </section>

    <form class="form-horizontal" role="form" method="POST"
          action="{{url('/institute/class-attendance/add-attendance/')}}" autocomplete="off" accept-charset="UTF-8"
          enctype="multipart/form-data" onsubmit="return ValidateForm()">
        {{ csrf_field() }}


        <input type="hidden" name="term_no" value="{{ $term_no }}" />
        <input type="hidden" name="approvedprogramme_id" value="{{ $approvedprogramme->id }}">

        <section class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    @if (Session::has('messages') )
                        @include('common.errorandmsg')
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-hover">
                            <tr class="grey-background">
                                <th class="center-text" rowspan="2">S. No.</th>
                                <th class="center-text" colspan="2">Students</th>
                                <th class="center-text" colspan="2">Attendance</th>
                                <th class="center-text" colspan="3">5% Attendance Percentage Exception</th>
                            </tr>
                            <tr class="grey-background">
                                <th class="center-text">Photo</th>
                                <th class="center-text">Details</th>
                                <th class="center-text">Theory</th>
                                <th class="center-text">Practical</th>
                                <th class="center-text">Need 5%<br>Exception?</th>
                                <th class="center-text">Exception File Upload</th>
                                <th class="center-text">Remarks of File Upload</th>
                            </tr>

                            @php $sno = '1'; @endphp
                            @foreach($candidates as $c)
                                @php
                                    $attendance = $classattendances->where('candidate_id', $c->id)->where('active_status', '1')->first();
                                    if(!is_null($attendance)) {
                                        $theory_percentage = $attendance->theory_percentage;
                                        $practical_percentage = $attendance->practical_percentage;
                                        $attendance_percentage = $attendance->attendance_percentage;
                                    }
                                @endphp

                                <tr>
                                    <td class="center-text blue-text">{{ $sno }}</td>
                                    <td class="center-text">
                                        <img src="{{asset('/files/enrolment/photos')}}/{{$c->photo}}"  style="width: 100px;" class="img" />
                                    </td>
                                    <td class="left-text blue-text">
                                        <p>Enrolment: <b>{{ $c->enrolmentno }}</b></p>
                                        <p>Name: <b>{{ $c->name }}</b></p>
                                        <p>DOB: <b> {{ $c->dob->format('m-d-Y') }}</b></p>
                                    </td>
                                    <td class="center-text">
                                        <input type="text" size="1" id="theory_attendance {{ $c->id }}" name="theory_attendance {{ $c->id }}" class="center-text"
                                               @if($classattendancepercentage->minimum_theory_percentage == '0')
                                                       readOnly
                                               value="{{ $classattendancepercentage->minimum_theory_percentage }}"
                                               @else
                                               @if(!is_null($attendance))
                                               @if(!is_null($theory_attendance))
                                               @if($attendance->classattendancepercentage->active_status == '0')
                                               readonly
                                               @endif
                                               value="{{ $theory_percentage }}"
                                                @endif
                                                @endif
                                               @endif
                                        /> &nbsp;%
                                    </td>
                                    <td class="center-text">
                                        <input type="text" size="1" id="practical_attendance" name="practical_attendance" class="center-text"
                                               @if($classattendancepercentage->minimum_practical_percentage == '0')
                                               readOnly
                                               value="{{ $classattendancepercentage->minimum_practical_percentage }}"
                                               @else
                                               @if(!is_null($attendance))
                                               @if(!is_null($practical_attendance))
                                               @if($attendance->classattendancepercentage->active_status == '0')
                                               readonly
                                               @endif
                                               value="{{ $practical_percentage }}"
                                                @endif
                                                @endif
                                                @endif
                                        /> &nbsp;%
                                    </td>
                                    <td class="center-text blue-text">
                                        <input type="radio" id="yes_exception_percentage {{ $c->id }}" name="exception_percentage {{ $c->id }}" onclick="EnableField({{ $c->id }})"> Yes
                                        <input type="radio" id="no_exception_percentage {{ $c->id }}" name="exception_percentage {{ $c->id }}"> No
                                    </td>
                                    <td>
                                        <input type="file" class="btn btn-file btn-info" disabled>
                                    </td>
                                    <td>
                                        <input type="text" name="exception_percentage_remarks_">
                                    </td>
                                </tr>
                                @php $sno++; @endphp
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <script>
        function tell(cid) {
            var th_attendance = document.getElementById('theory_attendance '+cid);
            alert(cid);
            th_attendance.value = '75';
        }
    </script>
@endsection