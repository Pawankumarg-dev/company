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
                                    {{ $exam->name }} Examinations - Question Papers
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
                                                <li class="active">Question Papers</li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                @foreach($examstartdates as $est)
                                    @php
                                        $showdatetime = \Carbon\Carbon::now()->subMinutes(15);
                                    @endphp

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="panel panel-info">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="panel panel-info">
                                                                <div class="panel-heading">
                                                                    <div class="panel-title">
                                                                        <div class="center-text red-text bold-text">
                                                                            {{ $est->startdate->format('d-m-Y h:i A') }} (Question Paper Details)
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="panel-body">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-hover table-bordered table-condensed">
                                                                            <tr>
                                                                                <th class="center-text brown-text bold-text" width="5%">S. No</th>
                                                                                <th class="left-text brown-text bold-text" width="10%">Course</th>
                                                                                <th class="center-text brown-text bold-text" width="5%">Start Time</th>
                                                                                <th class="center-text brown-text bold-text" width="5%">End Time</th>
                                                                                <th class="center-text brown-text bold-text" width="5%">Exam Duration</th>
                                                                                <th class="center-text brown-text bold-text" width="5%">Subject Code</th>
                                                                                <th class="left-text brown-text bold-text" width="25%">Subject Name</th>
                                                                                <th class="center-text brown-text bold-text" width="10%">Password</th>
                                                                                <th class="center-text brown-text bold-text" width="10%">Question Paper</th>
                                                                                <th class="center-text brown-text bold-text" width="10%">Link</th>
                                                                            </tr>

                                                                            @php $sno = 1; @endphp
                                                                            @foreach($examtimetables as $ett)
                                                                                @if($ett->startdate == $est->startdate)
                                                                                    <tr>
                                                                                        <td class="center-text blue-text bold-text">{{ $sno }}</td>
                                                                                        <td class="left-text blue-text bold-text">{{ $ett->programmeCode }}</td>
                                                                                        <td class="center-text blue-text bold-text">{{ $ett->startdate->format('h:i A') }}</td>
                                                                                        <td class="center-text blue-text bold-text">{{ $ett->enddate->format('h:i A') }}</td>
                                                                                        <td class="center-text blue-text bold-text">
                                                                                            @php
                                                                                                $startdatetime = new DateTime(($ett->startdate));
                                                                                                $enddatetime = new DateTime(($ett->enddate));
                                                                                            @endphp

                                                                                            @if (!is_null($startdatetime) && !is_null($enddatetime))
                                                                                                @php $interval = $startdatetime->diff($enddatetime); @endphp

                                                                                                {{ ($interval->format('%i') == 0) ?
                                                                                                    $interval->format('%h hour(s)') :
                                                                                                    $interval->format('%h hour(s) %i minute(s)') }}
                                                                                            @endif
                                                                                        </td>
                                                                                        <td class="center-text red-text bold-text">{{ $ett->subjectCode }}</td>
                                                                                        <td class="left-text red-text bold-text">{{ $ett->subjectName }}</td>
                                                                                        <td class="center-text text-danger bold-text">
                                                                                            @if(empty($ett->password) || is_null($ett->password))
                                                                                                <span class="label label-danger">Not Available</span>
                                                                                            @else
                                                                                                {{ $est->startdate < $showdatetime ?
                                                                                                    $ett->password :
                                                                                                    base64_encode($ett->password) }}
                                                                                            @endif
                                                                                        </td>
                                                                                        <td class="center-text red-text bold-text">
                                                                                            @if(empty($ett->questionpaper) || is_null($ett->questionpaper))
                                                                                                <span class="label label-danger">Not Available</span>
                                                                                            @else
                                                                                                <a href="{{ asset('/files/questionpapers/'.$ett->questionpaper) }}" class="btn btn-primary btn-sm" target="_blank">
                                                                                                    <span class="glyphicon glyphicon-download-alt"></span>
                                                                                                    &nbsp; Download
                                                                                                </a>
                                                                                            @endif
                                                                                        </td>
                                                                                        <td class="center-text red-text bold-text">
                                                                                            <a href="{{ url('/nber/examquestionpapers/'.$exam->id.'/'.$ett->id) }}" class="btn btn-primary btn-sm">
                                                                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;
                                                                                                Update
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>

                                                                                    @php $sno++; @endphp
                                                                                @endif

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
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection