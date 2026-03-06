@extends('layouts.app')
@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Class Attendance Upload
                </div>
            </div>
        </div>
    </section>

    @if($exams->count() > 0)
        @foreach($exams as $e)
            @if($e->attendance_upload == '1')
                <section class="container">
                    <div class="row">
                        <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                            <div class="center-text">
                                @php $count = '0'; @endphp
                                @foreach($classattendancepercentages as $p)
                                    @foreach($approvedprogrammes->where('programme_id', $p->programme_id)->where('academicyear_id', $p->academicyear_id) as $ap)
                                        @php $count++; @endphp
                                    @endforeach
                                @endforeach

                                @if($count > '0')
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-condensed table-hover">
                                            <tr class="grey-background">
                                                <th colspan="5" class="center-text">{{ $e->name }} Examinations</th>
                                            </tr>
                                            <tr class="grey-background">
                                                <th class="center-text">S. No.</th>
                                                <th class="center-text">Academic Year</th>
                                                <th class="center-text">Programme</th>
                                                <th class="center-text">Year / Term</th>
                                                <th class="center-text">Options</th>
                                            </tr>
                                            @php $sno = '0'; @endphp
                                            @foreach($classattendancepercentages as $p)
                                                @foreach($approvedprogrammes->where('programme_id', $p->programme_id)->where('academicyear_id', $p->academicyear_id) as $ap)
                                                    <tr>
                                                        <td class="center-text blue-text">{{ $sno+1 }}</td>
                                                        <td class="center-text blue-text">{{ $ap->academicyear->year }}</td>
                                                        <td class="center-text blue-text">{{ $ap->programme->course_name }}</td>
                                                        <td class="center-text blue-text">
                                                            {{ $p->term }}<sup>@if($p->term == '1') st @else nd @endif</sup> &nbsp; (Year / Term)
                                                        </td>
                                                        <td class="center-text">
                                                            <a href="{{ url('/institute/class-attendance/add-attendance/'.$ap->id.'/term/'.$p->term) }}" class="btn btn-primary btn-sm">
                                                                Mark Attendance
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @php $sno++; @endphp
                                                @endforeach
                                            @endforeach
                                        </table>
                                    </div>
                                @else
                                    No records found
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endforeach
    @endif
@endsection