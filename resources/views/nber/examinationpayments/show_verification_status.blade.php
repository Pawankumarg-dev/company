@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{ $exam->name }} - Examination Payments
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li>
                                                    <a href="{{ url('/nber/payments') }}">Payments</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/nber/examinationpayments') }}">Exams List</a>
                                                </li>
                                                <li class="active">{{ $exam->name }}</li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            Verification Status (Total: <b>{{ $totalCount }}</b>)
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-3 col-sm-4">
                                                <div class="wrimagecard wrimagecard-topimage">
                                                    <a href="{{ url('/nber/examinationpayments/showverificationpending/institutelists/'.$exam->id) }}">
                                                        <div class="wrimagecard-topimage_header" style="background-color: rgba(213, 15, 37, 0.1)">
                                                            <center>
                                                                <img src="{{ asset('/images/icon_verificationpending.png') }}" class="img-responsive" width="35%">
                                                            </center>
                                                        </div>
                                                        <div class="wrimagecard-topimage_title">
                                                            <h4>
                                                                Verification Pending
                                                                <div class="pull-right badge">
                                                                    {{ $verificationPendingCount }}
                                                                </div>
                                                            </h4>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-4">
                                                <div class="wrimagecard wrimagecard-topimage">
                                                    <a href="{{ url('/nber/examinationpayments/showpending/institutelists/'.$exam->id) }}">
                                                        <div class="wrimagecard-topimage_header" style="background-color: rgba(213, 15, 37, 0.1)">
                                                            <center>
                                                                <img src="{{ asset('/images/icon_pending.png') }}" class="img-responsive" width="35%">
                                                            </center>
                                                        </div>
                                                        <div class="wrimagecard-topimage_title">
                                                            <h4>
                                                                Pending
                                                                <div class="pull-right badge">
                                                                    {{ $pendingCount }}
                                                                </div>
                                                            </h4>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            {{--
                                            <div class="col-md-3 col-sm-4">
                                                <div class="wrimagecard wrimagecard-topimage">
                                                    <a href="{{ url('/nber/examinationpayments/showverificationpendinglist/'.$exam->id) }}">
                                                        <div class="wrimagecard-topimage_header" style="background-color: rgba(213, 15, 37, 0.1)">
                                                            <center>
                                                                <img src="{{ asset('/images/icon_verificationpending.png') }}" class="img-responsive" width="35%">
                                                            </center>
                                                        </div>
                                                        <div class="wrimagecard-topimage_title">
                                                            <h4>
                                                                Verification Pending
                                                                <div class="pull-right badge">
                                                                    {{ $verificationPendingCount }}
                                                                </div>
                                                            </h4>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            --}}
                                            <div class="col-md-3 col-sm-4">
                                                <div class="wrimagecard wrimagecard-topimage">
                                                    <a href="{{ url('/nber/examinationpayments/showapproved/institutelists/'.$exam->id) }}">
                                                        <div class="wrimagecard-topimage_header" style="background-color: rgba(213, 15, 37, 0.1)">
                                                            <center>
                                                                <img src="{{ asset('/images/icon_approved.png') }}" class="img-responsive" width="35%">
                                                            </center>
                                                        </div>
                                                        <div class="wrimagecard-topimage_title">
                                                            <h4>
                                                                Approved
                                                                <div class="pull-right badge">
                                                                    {{ $approvedCount }}
                                                                </div>
                                                            </h4>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-4">
                                                <div class="wrimagecard wrimagecard-topimage">
                                                    <a href="{{ url('/nber/examinationpayments/showrejected/institutelists/'.$exam->id) }}">
                                                        <div class="wrimagecard-topimage_header" style="background-color: rgba(213, 15, 37, 0.1)">
                                                            <center>
                                                                <img src="{{ asset('/images/icon_rejected.png') }}" class="img-responsive" width="35%">
                                                            </center>
                                                        </div>
                                                        <div class="wrimagecard-topimage_title">
                                                            <h4>
                                                                Rejected
                                                                <div class="pull-right badge">
                                                                    {{ $rejectedCount }}
                                                                </div>
                                                            </h4>
                                                        </div>
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
        </div>
    </div>
@endsection
