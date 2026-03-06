@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Enrolment Payment for {{ $candidate->approvedprogramme->academicyear->year }}
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <section class="hidethis">
                                    <ul class="breadcrumb">
                                        <li class="heading">Quick Links: </li>
                                        <li>
                                            <a href="{{ url('/institute/dashboard/home') }}">Home</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/institute/enrolmentpayments/') }}">Enrolment Payments</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/institute/enrolmentpayments/'.$candidate->approvedprogramme->academicyear->id) }}">{{ $candidate->approvedprogramme->academicyear->year }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('institute/enrolmentpayments/showstudents/'.$candidate->approvedprogramme_id) }}">{{ $candidate->approvedprogramme->programme->course_name }}</a>
                                        </li>
                                        <li class="active">
                                            {{ strtoupper($candidate->name) }}
                                        </li>
                                    </ul>
                                </section>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <div class="panel-title">Enrolment Payment Details</div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-condensed table-bordered" role="table">
                                                <tr>
                                                    <th class="center-text" width="15%">Photo</th>
                                                    <th class="center-text" width="20%">Name</th>
                                                    <th class="center-text" width="15%">Course</th>
                                                    <th class="center-text" width="5%">Enrolled Year</th>
                                                    <th class="center-text" width="10%">Candidate<br>Approval<br>Status</th>
                                                    <th class="center-text" width="10%">Enrolment<br>Fee</th>
                                                </tr>
                                                <tr>
                                                    <td class="center-text">
                                                        <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 100px;" class="img" />
                                                    </td>
                                                    <td class="blue-text">{{ strtoupper($candidate->name) }}</td>
                                                    <td class="blue-text center-text">{{ $candidate->approvedprogramme->programme->course_name }}</td>
                                                    <td class="blue-text center-text">{{ $candidate->approvedprogramme->academicyear->year }}</td>
                                                    <td class="blue-text center-text"><span class="label label-success">Approved</span></td>
                                                    <td class="blue-text center-text">500</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th class="center-text" width="10%">Reference No.</th>
                                                    <th class="center-text">Payment Details</th>
                                                    <th class="center-text">Actual Amount</th>
                                                    <th class="center-text" width="10%">Amount Paid</th>
                                                    <th class="center-text">Payment<br>Status</th>
                                                    <th class="center-text">Verification<br>Remarks</th>
                                                    <th class="center-text">Acknowledgement<br>Receipt</th>
                                                </tr>

                                                @foreach($enrolmentpayments as $enp)
                                                    <tr>
                                                        <td class="center-text blue-text">{{ $enp->reference_number }}</td>
                                                        <td class="blue-text">
                                                            Payment Date: <b><span class="blue-text">{{ $enp->payment_date->format('d-m-Y') }}</span></b><br>
                                                            Payment Bank Name: <b><span class="blue-text">{{ $enp->paymentbank->bankname }}</span></b><br>
                                                            Payment Type: <b><span class="blue-text">{{ $enp->paymenttype->course_name }}</span></b><br>
                                                            UTR / Transaction No.: <b><span class="blue-text">{{ $enp->payment_number }}</span></b><br>
                                                            Payment Remarks: <b><span class="blue-text">{{ $enp->payment_remark }}</span></b><br>
                                                            Payment Slip: <b><a href="{{asset('/files/payments/enrolment/'.$enp->filename)}}" target="_blank">{{ $enp->filename }}</a></b>
                                                        </td>
                                                        <td class="center-text blue-text">
                                                            <b>Rs. {{ $enp->enrolmentfee->enrolment_fee }} /-</b>
                                                        </td>
                                                        <td class="center-text blue-text">
                                                            <b>Rs. {{ $enp->amount_paid }} /-</b>
                                                        </td>
                                                        <td class="center-text">
                                                            <span class="label label-{{ $enp->status->class }}">
                                                            {{ $enp->status->status }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            {{ $enp->verify_remarks }}
                                                        </td>
                                                        <td class="center-text">
                                                            {{--
                                                                Payment Status = 2 (Approved)
                                                                If payment is approved,
                                                                then show acknowledgement receipt
                                                            --}}
                                                            @if($enp->status_id == 2)
                                                                <a href="{{ url('/institute/enrolmentpayments/downloadreceipt/'.$enp->id) }}"
                                                                   class="btn btn-info btn-xs" target="_blank">View & Print Receipt
                                                                </a>
                                                            @endif
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
@endsection

