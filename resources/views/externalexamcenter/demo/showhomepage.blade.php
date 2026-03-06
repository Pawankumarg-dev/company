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
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text blue-text">
                        {{ $title }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text blue-text">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <h3>
                                            <a href="{{ url('/demoexternalexamcenter/demoattendancesheet') }}">
                                                <i class="fa fa-arrow-circle-down"></i> Demo Attendance Sheet
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <h3>
                                            <a href="{{ url('/demoexternalexamcenter/demoquestionpaper') }}">
                                                <i class="fa fa-arrow-circle-down"></i> Demo Question Paper
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection