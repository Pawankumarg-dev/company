@extends('layouts.app')
@section('content')
    {{--
    <!--Main layout-->
    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/centerinformation/'.$institute->id) }}"
                                                   target="_blank">
                                                    <span class="glyphicon glyphicon-home icon-text"></span><br>
                                                    Center Information
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                    <span class="glyphicon glyphicon-th-large icon-text"></span><br>
                                                    Course Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                    <span class="glyphicon glyphicon-th icon-text"></span><br>
                                                    Enrolment
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                    <span class="glyphicon glyphicon-user icon-text"></span><br>
                                                    Candidate Information
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                    <span class="glyphicon glyphicon-th-list icon-text"></span><br>
                                                    Exam Application
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                    <span class="glyphicon glyphicon-list-alt icon-text"></span><br>
                                                    Online Mark Entry
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                    <span class="glyphicon glyphicon-user icon-text"></span><br>
                                                    Class Attendance
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                    <span class="glyphicon glyphicon-calendar icon-text"></span><br>
                                                    Exam Timetable
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                    <span class="glyphicon glyphicon-user icon-text"></span><br>
                                                    Hall Ticket
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                    <span class="glyphicon glyphicon-user icon-text"></span><br>
                                                    Result
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/centerinformation/'.$institute->id) }}" style="color: deeppink">
                                                    <span class="glyphicon glyphicon-user icon-text"></span><br>
                                                    Re-evaluation
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                    <i class='fas fa-rupee-sign icon-text'></i><br>
                                                    Payment
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                    <span class="glyphicon glyphicon-earphone icon-text"></span><br>
                                                    Contact NBER
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/centerinformation/'.$institute->id) }}"  style="color: red">
                                                    <span class="glyphicon glyphicon-log-out icon-text"></span><br>
                                                    Logout
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
    <!--Main layout-->
    --}}

    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/center-information/') }}"
                                                   target="_blank">
                                                    <span class="glyphicon glyphicon-home icon-text"></span><br>
                                                    Center Information
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/enrolment') }}">
                                                    <span class="glyphicon glyphicon-th icon-text"></span><br>
                                                    Enrolments
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="center-text">
                                                <a href="{{ url('/institute/examinations/') }}">
                                                    <span class="glyphicon glyphicon-th-list icon-text"></span><br>
                                                    Examinations
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
