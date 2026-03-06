@extends('layouts.evaluationcenter')
@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <div class="center-text">
                                        <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                                        <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                                        <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                                        <span class="h8-text">(An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <h4 class="center-text alert alert-info">
                                    {{$title}}
                                </h4>

                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            Download Question Paper(s)
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        @foreach($examdates as $examdate)
                                            @foreach($examstarttimes as $examstarttime)
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-condensed">
                                                        <thead>
                                                        <tr class="bg-primary">
                                                            <th colspan="6">Exam Date & Timing: {{ date("d-m-Y", strtotime($examdate)) }} ({{ date("h:s A", strtotime($examstarttime)) }})</th>
                                                        </tr>
                                                        <tr class="bg-success">
                                                            <th class="center-text" width="3%">S.No</th>
                                                            <th class="center-text" width="12%">Course</th>
                                                            <th class="center-text" width="7%">Subject Code</th>
                                                            <th class="center-text" width="50%">Subject Name</th>
                                                            <th class="center-text" width="10%">Password</th>
                                                            <th class="center-text" width="5%">Question Paper</th>
                                                        </tr>
                                                        </thead>

                                                        @php $sno = 1; @endphp
                                                        <tbody>
                                                        @foreach($examtimetables as $examtimetable)
                                                            @if($examtimetable->examdate->format('Y-m-d') == date("Y-m-d", strtotime($examdate)) && $examtimetable->starttime == $examstarttime)
                                                            <tr>
                                                                <td class="center-text text-primary">{{ $sno }} @php $sno++; @endphp</td>
                                                                <td class="text-primary">{{ $examtimetable->subject->programme->course_name }}</td>
                                                                <td class="bold-text text-primary">{{ $examtimetable->subject->scode }}</td>
                                                                <td class="text-primary">{{ $examtimetable->subject->sname }}</td>
                                                                <td class="center-text red-text bold-text">{{ $examtimetable->password }}</td>
                                                                <td class="center-text">
                                                                    <a href="{{ url('/evaluationcenter/downloadquestionpaper/'.$examtimetable->id) }}" class="btn btn-sm btn-info" target="_blank">
                                                                        <span class="glyphicon glyphicon-download"></span>&nbsp;Download
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endforeach
                                        @endforeach
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
