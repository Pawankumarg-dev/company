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

                                <div class="row">
                                    <div class="col-sm-3">
                                        <a href="{{ url('/nber/examinationpayments/showverificationpending/institutelists/'.$exam->id) }}" class="custom-link">
                                            <div class="panel panel-info">
                                                <div class="panel-body" style="background-color: rgb(192,192,192)">
                                                    <div class="center-text">
                                                        <img src="{{asset('images/icon_verificationpending.png')}}" width="40px" height="40px" class="glyphicon glyphicon-picture"/>
                                                        <span class="black-text bold-text">Verification Pending</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="{{ url('/nber/examinationpayments/showpending/institutelists/'.$exam->id) }}" class="custom-link">
                                            <div class="panel panel-info">
                                                <div class="panel-body bg-warning">
                                                    <div class="center-text">
                                                        <img src="{{asset('images/icon_pending.png')}}" width="40px" height="40px" class="glyphicon glyphicon-picture"/>
                                                        <span class="bold-text" style="color: rgb(255,140,0)">Pending</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="{{ url('/nber/examinationpayments/showapproved/institutelists/'.$exam->id) }}" class="custom-link">
                                            <div class="panel panel-info">
                                                <div class="panel-body bg-success">
                                                    <div class="center-text">
                                                        <img src="{{asset('images/icon_approved.png')}}" width="40px" height="40px" class="glyphicon glyphicon-picture"/>
                                                        <span class="green-text bold-text">Approved</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="{{ url('/nber/examinationpayments/showrejected/institutelists/'.$exam->id) }}" class="custom-link">
                                            <div class="panel panel-info">
                                                <div class="panel-body bg-danger">
                                                    <div class="center-text">
                                                        <img src="{{asset('images/icon_rejected.png')}}" width="40px" height="40px" class="glyphicon glyphicon-picture"/>
                                                        <span class="red-text bold-text">Rejected</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            Institutes - Pending ({{ $institutes->count() }})
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table class="table table-condensed table-hover" role="table">
                                                        <thead>
                                                        <tr>
                                                            <th class="center-text">S.No.</th>
                                                            <th class="center-text">Institute Code</th>
                                                            <th class="center-text">Institute Name</th>
                                                            <th class="center-text">Link</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        @if($institutes->count() == 0)
                                                        @else
                                                            @php $sno = 1; @endphp

                                                            @foreach($institutes as $institute)
                                                                <tr>
                                                                    <td class="center-text">{{ $sno }}@php $sno++; @endphp</td>
                                                                    <td class="center-text">{{ $institute->code }}</td>
                                                                    <td>{{ $institute->name }}</td>
                                                                    <td class="center-text">
                                                                        <a href="{{ url('/nber/examinationpayments/showpending/institute/'.$exam->id.'/'.$institute->id) }}" class="btn btn-primary btn-sm">
                                                                            <span class="glyphicon glyphicon-eye-open"></span>
                                                                            &nbsp; View
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        </tbody>
                                                    </table>
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