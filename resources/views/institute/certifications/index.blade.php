@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>Certifications</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="center-text">
                            <a href="{{ url('/institute/certifications/provisionals/') }}">
                                <img src="{{ asset('/images/provisiona_certificate_icon.png') }}"
                                     class="img-responsive"
                                     width="45%"
                                     style="display: block;
                                              margin-left: auto;
                                              margin-right: auto;
                                              width: 50%;"
                                /><br>
                                <span style="font-size: 25px">
                               Provisional Certificates
                                    </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{--
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="center-text">
                            <a href="{{ url('/institute/certifications/marksheets/') }}">
                                <img src="{{ asset('/images/statement_of_marks_icon.png') }}"
                                     class="img-responsive"
                                     width="45%"
                                     style="display: block;
                                              margin-left: auto;
                                              margin-right: auto;
                                              width: 50%;"
                                /><br>
                                <span style="font-size: 25px">
                               Statement of Marks
                                    </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="center-text">
                            <a href="">
                                <img src="{{ asset('/images/diplomas_or_certificates_icon.png') }}"
                                     class="img-responsive"
                                     width="45%"
                                     style="display: block;
                                              margin-left: auto;
                                              margin-right: auto;
                                              width: 50%;"
                                /><br>
                                <span style="font-size: 25px">
                               Diplomas / Certificates
                                    </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            --}}
        </div>
    </div>
@endsection