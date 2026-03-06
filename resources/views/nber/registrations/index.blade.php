@extends('layouts.app')

@section('content')

<section class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">
                    Nber Registration
                </div>
            </div>

            <div class="panel-body">
                <div class="row">

                    <div class="container">
                        <div class="row">

                            {{-- Course Information --}}
                            <div class="col-sm-4">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="center-text">
                                            <a href="{{ url('') }}">
                                                <span style="font-size: 25px">
                                                    Course Information
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ./Course Information --}}

                            {{-- Subject Information --}}
                            <div class="col-sm-4">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="center-text">
                                            <a href="{{ url('') }}">
                                                <span style="font-size: 25px">
                                                    Subject Information
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ./Subject Information --}}

                            {{-- Institute Information --}}
                            <div class="col-sm-4">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="center-text">
                                            <a href="{{ url('/nber/institute-information/') }}">
                                                <span style="font-size: 25px">
                                                    Institute Information
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ./Institute Information --}}

                            {{-- Candidate Information --}}
                            <div class="col-sm-4">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="center-text">
                                            <a href="{{ url('') }}">
                                                <span style="font-size: 25px">
                                                    Candidate Information
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ./Candidate Information --}}

                            {{-- Enrolment Information --}}
                            <div class="col-sm-4">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="center-text">
                                            <a href="{{ url('/nber/enrolments/') }}">
                                                <span style="font-size: 25px">
                                                    Enrolment Information
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ./Enrolment Information --}}

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>
@endsection