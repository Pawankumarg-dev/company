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
                                                <a href="{{ url('/nber/exams') }}">Exams</a>
                                            </li>
                                            <li class="active">{{ $exam->name }} Theory</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/nber/theoryexams/examcenters/'.$exam->id) }}">
                                                    <i class="fa fa-university fa-3x"></i><br>
                                                    Exam Center
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/nber/theoryexams/examcentermapping/'.$exam->id) }}">
                                                    <i class="fa fa-university fa-3x"></i><br>
                                                    Exam Center Mapping
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/nber/theoryexams/nodalofficer/'.$exam->id) }}">
                                                    <i class="fa fa-user fa-3x"></i><br>
                                                    Nodal Officers
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/nber/theoryexams/cs/'.$exam->id) }}">
                                                    <i class="fa fa-user fa-3x"></i><br>
                                                    Centre Superintendent
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/nber/theoryexams/clo/'.$exam->id) }}">
                                                    <i class="fa fa-user fa-3x"></i><br>
                                                    Centre Level Observer
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/nber/theoryexams/examattendances/'.$exam->id) }}">
                                                    <i class="fa fa-user fa-3x"></i><br>
                                                    Online Exam Attendances
                                                </a>
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
