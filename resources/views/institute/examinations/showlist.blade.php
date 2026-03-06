@extends('layouts.app')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title">
                                {{ $exam->name }} Examinations
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="hidethis">
                                        <ul class="breadcrumb">
                                            <li class="heading">Quick Links: </li>
                                            <li>
                                                <a href="{{ url('/institute/dashboard/home') }}">Home</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations') }}">Examinations</a>
                                            </li>
                                            <li class="active">{{ $exam->name }} Examinations</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/examinations/applications/'.$exam->id) }}">
                                                    <span class="glyphicon glyphicon-th-list icon-text"></span><br>
                                                    Exam<br>Applications
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

{{--                                <div class="col-sm-2">--}}
{{--                                    <div class="panel panel-default">--}}
{{--                                        <div class="panel-body bg-default">--}}
{{--                                            <div class="center-text">--}}
{{--                                                @if($exam->status_id == 1)--}}
{{--                                                    <a href="{{ url('/institute/examinations/practicalexaminers/'.$exam->id) }}">--}}
{{--                                                        <span class="glyphicon glyphicon-user icon-text"></span><br>--}}
{{--                                                        Practical<br>Examiners--}}
{{--                                                    </a>--}}
{{--                                                @else--}}
{{--                                                    <span class="glyphicon glyphicon-user icon-text"></span><br>--}}
{{--                                                    Practical<br>Examiners--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                {{--
                                                <a
                                                   target="_blank">
                                                    <span class="glyphicon glyphicon-calendar icon-text"></span><br>
                                                    Exam Timetables
                                                </a>
                                                 --}}
                                                <span class="glyphicon glyphicon-calendar icon-text"></span><br>
                                                Exam<br>Timetables
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/consolidatedclassattendance/'.$exam->id) }}">
                                                    <span class="glyphicon glyphicon-align-justify icon-text"></span><br>
                                                    Class<br>Attendances
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                @if($exam->status_id == 0 || $exam->status_id == 3)
                                                    <a href="{{ url('/institute/examinations/results/'.$exam->id) }}">
                                                        <i class="fa fa-trophy icon-text"></i><br>
                                                        Exam<br>Results
                                                    </a>
                                                @else
                                                    <i class="fa fa-trophy icon-text"></i><br>
                                                    Exam<br>Results
                                                @endif
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
    </main>

@endsection
