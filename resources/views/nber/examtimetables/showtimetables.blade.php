@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $exam->name }} - Exam Timetable
                </div>
            </div>
        </div>
    </section>

    @foreach($examstartdates as $est)

        <section class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-condensed">
                            <tr class="grey-background">
                                <th class="center-text red-text bold-text h5-text" colspan="7">{{ $est->startdate->format('d-m-Y h:i A') }}</th>
                            </tr>

                            <tr class="grey-background">
                                <th class="center-text brown-text bold-text" width="5%">S. No</th>
                                <th class="left-text brown-text bold-text" width="20%">Course</th>
                                <th class="center-text brown-text bold-text" width="10%">Start Time</th>
                                <th class="center-text brown-text bold-text" width="10%">End Time</th>
                                <th class="center-text brown-text bold-text" width="10%">Exam Duration</th>
                                <th class="center-text brown-text bold-text" width="10%">Subject Code</th>
                                <th class="left-text brown-text bold-text" width="30%">Subject Name</th>
                            </tr>

                            @php $sno = 1; @endphp
                            @foreach($examtimetables as $ett)
                                @if($ett->startdate == $est->startdate)

                                    <tr>
                                        <td class="center-text blue-text bold-text">{{ $sno }}</td>
                                        <td class="left-text blue-text bold-text">{{ $ett->subject->programme->course_name }}</td>
                                        <td class="center-text blue-text bold-text">{{ $ett->startdate->format('h:i A') }}</td>
                                        <td class="center-text blue-text bold-text">{{ $ett->enddate->format('h:i A') }}</td>
                                        <td class="center-text blue-text bold-text">
                                            @php
                                                $datetime1 = new DateTime(($ett->startdate));
                                                $datetime2 = new DateTime(($ett->enddate));
                                                $interval = $datetime1->diff($datetime2);
                                                if($interval->format('%i') == 0)
                                                    echo $interval->format('%h hour(s)');
                                                else
                                                    echo $interval->format('%h hour(s) %i minute(s)');
                                            @endphp
                                        </td>
                                        <td class="center-text red-text bold-text">{{ $ett->subject->scode }}</td>
                                        <td class="left-text red-text bold-text">{{ $ett->subject->sname }}</td>
                                    </tr>

                                    @php $sno++; @endphp
                                @endif

                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </section>

    @endforeach
@endsection