@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    New Application for Expert Pool
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="center-text">
                                Stage : 01<br>
                                Basic Details
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        Please fill the basic details of the applicant
                    </div>

                    <div class="panel-footer">
                        <a href="{{ url('/expert/application/new/applystage/1') }}" class="btn btn-primary btn-block" target="_blank">
                            <span class="glyphicon glyphicon-link"></span>&nbsp; Click here
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="center-text">
                                Stage : 02<br>
                                Communication Details
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        Please fill the communication details of the applicant
                    </div>

                    <div class="panel-footer">
                        <a href="{{ url('/expert/application/new/applystage/2') }}" class="btn btn-primary btn-block" target="_blank">
                            <span class="glyphicon glyphicon-link"></span>&nbsp; Click here
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="center-text">
                                Stage : 03<br>
                                Educational Qualifications
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        Please fill the educational qualifications other than RCI qualifications
                    </div>

                    <div class="panel-footer">
                        <a href="{{ url('/expert/application/new/applystage/3') }}" class="btn btn-primary btn-block" target="_blank">
                            <span class="glyphicon glyphicon-link"></span>&nbsp; Click here
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="center-text">
                                Stage : 04<br>
                                RCI Professional Qualifications
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        Please fill the only RCI Educational Qualifications
                    </div>

                    <div class="panel-footer">
                        <a href="{{ url('/expert/application/new/applystage/4') }}" class="btn btn-primary btn-block" target="_blank">
                            <span class="glyphicon glyphicon-link"></span>&nbsp; Click here
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="center-text">
                                Stage : 05<br>
                                RCI CCR Number Details
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        Please fill the RCI Central Rehabilitation Register (CRR) Number
                    </div>

                    <div class="panel-footer">
                        <a href="{{ url('/expert/application/new/applystage/5') }}" class="btn btn-primary btn-block" target="_blank">
                            <span class="glyphicon glyphicon-link"></span>&nbsp; Click here
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="center-text">
                                Stage : 06<br>
                                Teaching Experience
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        Please fill the teaching experience of the applicant
                    </div>

                    <div class="panel-footer">
                        <a href="{{ url('/expert/application/new/applystage/6') }}" class="btn btn-primary btn-block" target="_blank">
                            <span class="glyphicon glyphicon-link"></span>&nbsp; Click here
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="center-text">
                                Stage : 07<br>
                                Non-Teaching Experience
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        Please fill the non-teaching experience of the applicant
                    </div>

                    <div class="panel-footer">
                        <a href="{{ url('/expert/application/new/applystage/7') }}" class="btn btn-primary btn-block" target="_blank">
                            <span class="glyphicon glyphicon-link"></span>&nbsp; Click here
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="center-text">
                                Stage : 08<br>
                                Languages known
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        Please select the languages known by the applicant
                    </div>

                    <div class="panel-footer">
                        <a href="{{ url('/expert/application/new/applystage/8') }}" class="btn btn-primary btn-block" target="_blank">
                            <span class="glyphicon glyphicon-link"></span>&nbsp; Click here
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="center-text">
                                Stage : 09<br>
                                Bank Account Details
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        Please fill the bank details of the applicant
                    </div>

                    <div class="panel-footer">
                        <a href="{{ url('/expert/application/new/applystage/9') }}" class="btn btn-primary btn-block" target="_blank">
                            <span class="glyphicon glyphicon-link"></span>&nbsp; Click here
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="center-text">
                                Stage : 10<br>
                                Photo Upload
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        Please upload the scanned photo of the applicant
                    </div>

                    <div class="panel-footer">
                        <a href="{{ url('/expert/application/new/applystage/10') }}" class="btn btn-primary btn-block" target="_blank">
                            <span class="glyphicon glyphicon-link"></span>&nbsp; Click here
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{--
    <section class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="panel panel-success">
                    <div class="panel-heading green-background">
                        <div class="panel-title">
                            <div class="center-text">
                                Apply for<br>
                                Center Level Observer (CLO)
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        Please read the guidelines of CLO before applying
                    </div>

                    <div class="panel-footer">
                        <a href="{{ url('/expert/application/new/apply/1') }}" class="btn btn-block green-background" target="_blank">
                            <span class="glyphicon glyphicon-link"></span>&nbsp; Apply here
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-success">
                    <div class="panel-heading green-background">
                        <div class="panel-title">
                            <div class="center-text">
                                Apply for<br>
                                External Examiner (EXE)
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        Please read the guidelines of EXE before applying
                    </div>

                    <div class="panel-footer">
                        <a href="{{ url('/expert/application/new/apply/2') }}" class="btn btn-block green-background" target="_blank">
                            <span class="glyphicon glyphicon-link"></span>&nbsp; Apply here
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-success">
                    <div class="panel-heading green-background">
                        <div class="panel-title">
                            <div class="center-text">
                                Apply for<br>
                                Evaluators (EVA)
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        Please read the guidelines of EVA before applying
                    </div>

                    <div class="panel-footer">
                        <a href="{{ url('/expert/application/new/apply/3') }}" class="btn btn-block green-background" target="_blank">
                            <span class="glyphicon glyphicon-link"></span>&nbsp; Apply here
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-success">
                    <div class="panel-heading green-background">
                        <div class="panel-title">
                            <div class="center-text">
                                Apply for<br>
                                Question Paper Setter (QPS)
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        Please read the guidelines of QPS before applying
                    </div>

                    <div class="panel-footer">
                        <a href="{{ url('/expert/application/new/apply/4') }}" class="btn btn-block green-background" target="_blank">
                            <span class="glyphicon glyphicon-link"></span>&nbsp; Apply here
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>
    --}}
@endsection