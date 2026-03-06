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
                                                <li>
                                                    <a href="{{ url('/nber/examinationpayments/showverificationstatus/'.$exam->id) }}">{{ $exam->name }}</a>
                                                </li>
                                                <li class="active">Approved Lists</li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <a href="{{ url('/nber/examinationpayments/showverificationpendinglist/'.$exam->id) }}" class="custom-link">
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
                                        <a href="{{ url('/nber/examinationpayments/showapprovedlist/'.$exam->id) }}" class="custom-link">
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
                                        <a href="{{ url('/nber/examinationpayments/showpendinglist/'.$exam->id) }}" class="custom-link">
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
                                        <a href="{{ url('/nber/examinationpayments/showrejectedlist/'.$exam->id) }}" class="custom-link">
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

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-success">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-condensed table-hover">
                                                        <tr>
                                                            <th class="center-text" width="3%">S.No.</th>
                                                            <th class="center-text" width="7%">Date of Entry</th>
                                                            <th class="center-text" width="5%">Institute Code</th>
                                                            <th class="center-text" width="25%">Institute Name</th>
                                                            <th class="center-text" width="5%">Enrolment No</th>
                                                            <th class="center-text" width="10%">Candidate Name</th>
                                                            <th class="center-text" width="10%">Payment Reference No.</th>
                                                            <th class="center-text" width="5%">Payment Mode</th>
                                                            <th class="center-text" width="5%">View</th>
                                                        </tr>

                                                        @php $sno = 1; @endphp
                                                        @foreach($examinationpayments as $examinationpayment)
                                                            <tr>
                                                                <td class="center-text blue-text">{{ $sno }} @php $sno++; @endphp</td>
                                                                <td class="center-text red-text bold-text">
                                                                    {{ $examinationpayment->created_at->format('d-m-Y') }}
                                                                </td>
                                                                <td class="center-text red-text bold-text">{{ $examinationpayment->institute->code }}</td>
                                                                <td class="blue-text">{{ $examinationpayment->institute->name }}</td>
                                                                <td class="center-text red-text bold-text">{{ $examinationpayment->candidate->enrolmentno }}</td>
                                                                <td class="blue-text">{{ $examinationpayment->candidate->name }}</td>
                                                                <td class="orange-text bold-text">{{ $examinationpayment->reference_number }}</td>
                                                                <td class="center-text orange-text bold-text">
                                                                    <span class="label label-danger">
                                                                        {{ $examinationpayment->payment_mode }}
                                                                    </span>
                                                                </td>
                                                                <td class="center-text">
                                                                    <a href="{{ url('/nber/examinationpayments/paymentdetails/'.$exam->id.'/'.$examinationpayment->id) }}" class="btn btn-info">
                                                                        <span class="glyphicon glyphicon-eye-open"></span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
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
