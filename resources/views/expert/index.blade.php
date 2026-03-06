@extends('layouts.expertpool')

@section('content')
    <!--header-->
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text">
                        Experts
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ./header-->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 well well-sm white-background minus15px-margin-top">
                    <div class="row">
                        <div class="col-sm-8">Click here to apply for new application</div>
                        <div class="col-sm-4">
                            <a href="{{ url('/expert/application/new/') }}" class="btn btn-primary btn-block">
                                <span class="glyphicon glyphicon-plus"></span>&nbsp; New Application
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>

            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 well well-sm white-background minus15px-margin-top">
                    <div class="row">
                        <div class="col-sm-8">Click here to edit the application</div>
                        <div class="col-sm-4">
                            <a href="{{ url('/expert/application/edit') }}" class="btn btn-primary btn-block">
                                <span class="glyphicon glyphicon-pencil"></span>&nbsp; Edit Application
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>

            {{--
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 well well-sm white-background minus15px-margin-top">
                    <div class="row">
                        <div class="col-sm-8">Click here to print the application</div>
                        <div class="col-sm-4">
                            <a href="{{ url('/expert/application/print') }}" class="btn btn-primary btn-block" target="_blank">
                                <span class="glyphicon glyphicon-print"></span>&nbsp; Print Application
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>


            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 well well-sm white-background minus15px-margin-top">
                    <div class="row">
                        <div class="col-sm-8">Click here to print the application</div>
                        <div class="col-sm-4">
                            <a href="{{ url('/expert/application/print') }}" class="btn btn-primary btn-block" target="_blank">
                                <span class="glyphicon glyphicon-print"></span>&nbsp; Print Application
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>

            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 well well-sm white-background minus15px-margin-top">
                    <div class="row">
                        <div class="col-sm-8">Click here to edit the application</div>
                        <div class="col-sm-4">
                            <a href="#" class="btn btn-primary btn-block">
                                <span class="glyphicon glyphicon-pencil"></span>&nbsp; Edit Application
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>

            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 well well-sm white-background minus15px-margin-top">
                    <div class="row">
                        <div class="col-sm-8">Click here to check the status of the application</div>
                        <div class="col-sm-4">
                            <a href="#" class="btn btn-primary btn-block">
                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp; Application Status
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>



            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 well well-sm white-background minus15px-margin-top">
                    <div class="row">
                        <div class="col-sm-8">Click here to login into the application</div>
                        <div class="col-sm-4">
                            <a href="#" class="btn btn-success btn-block">
                                <span class="glyphicon glyphicon-log-in"></span>&nbsp; Login Application
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
            --}}
        </div>
    </section>
@endsection