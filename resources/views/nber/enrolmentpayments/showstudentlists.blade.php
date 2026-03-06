@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Enrolment Payment for {{ $academicyear->year }}
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li>
                                                    <a href="{{ url('/nber/payments/enrolment/') }}">Enrolment Payments</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/nber/payments/enrolment/'.$academicyear->id) }}">{{ $academicyear->year }}</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('nber/payments/enrolment/showcourselists/'.$academicyear->id.'/'.$approvedprogramme->institute->id) }}">{{ $approvedprogramme->institute->code }}</a>
                                                </li>
                                                <li class="active">{{ $approvedprogramme->programme->course_name }} - Students List</li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-danger">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    Enrolment Payment Fee - {{ $approvedprogramme->programme->course_name }} ({{ $academicyear->year }}) - Students List
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-condensed table-bordered" role="table">
                                                        <tr>
                                                            <th class="center-text" width="5%">S. No.</th>
                                                            <th class="center-text" width="15%">Photo</th>
                                                            <th class="center-text" width="10%">Enrolment No</th>
                                                            <th class="center-text" width="25%">Name</th>
                                                            <th class="center-text" width="10%">Payment Entered Status</th>
                                                            <th class="center-text" width="10%">Verification Pending Status</th>
                                                            <th class="center-text" width="10%">Payment Details</th>
                                                        </tr>
                                                        @php $sno = 1; @endphp
                                                        @foreach($approvedprogramme->approvedcandidatelist($approvedprogramme->id) as $candidate)
                                                            <tr>
                                                                <td class="center-text">{{ $sno }}@php $sno++; @endphp</td>
                                                                <td class="center-text">
                                                                    <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 100px;" class="img" />
                                                                </td>
                                                                <td class="center-text">
                                                                    @if(is_null($candidate->enrolmentno))
                                                                        <p class="label label-danger">
                                                                            <span class="glyphicon glyphicon-remove-circle"></span>
                                                                            NOT GENERATED
                                                                        </p>
                                                                    @else
                                                                        <span class="blue-text">{{ $candidate->enrolmentno }}</span>
                                                                    @endif
                                                                </td>
                                                                <td class="blue-text">{{ strtoupper($candidate->name) }}</td>

                                                                @if($candidate->paymentdetailentered_status = 1)
                                                                    <td class="center-text">
                                                                        <p class="label label-success">
                                                                            <span class="glyphicon glyphicon-ok-circle"></span>
                                                                            ENTERED
                                                                        </p>
                                                                    </td>
                                                                    <td class="center-text">
                                                                        <p class="label label-danger">
                                                                            {{ $candidate->pendingverificationcount($candidate->id) }}
                                                                        </p>
                                                                    </td>
                                                                    <td class="center-text">
                                                                        <a href="{{ url('/nber/payments/enrolment/viewstudentpaymentdetails/'.$candidate->id) }}" class="btn btn-primary btn-sm">
                                                                            <span class="glyphicon glyphicon-eye-open"></span>&nbsp; view
                                                                        </a>
                                                                    </td>
                                                                @else
                                                                    <td class="center-text">
                                                                        <p class="label label-danger">
                                                                            <span class="glyphicon glyphicon-remove-circle"></span>
                                                                            NOT ENTERED
                                                                        </p>
                                                                    </td>
                                                                @endif
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
