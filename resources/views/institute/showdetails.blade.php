@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/payment')}}">Payments</a></li>
                    <li><a href="{{url('/institute/incidentalpayments')}}">Affiliation fee Payments</a></li>
                    <li>{{ $academicyear->year }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                        Affiliation fee Payments {{ $academicyear->year }}
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-bordered">
                                {{--
                                <tr>
                                    <th class="grey-background" colspan="2">
                                        Institute
                                    </th>
                                    <th colspan="6">
                                        {{ $institute->code }} - {{ $institute->name }}
                                    </th>
                                </tr>
                                <tr>
                                    <td class="right-text" colspan="8">
                                        <a href="{{ url('/institute/incidentalpayments/'.$academicyear->id.'/addform') }}" class="btn btn-primary btn-sm">
                                            <span class="glyphicon glyphicon-plus"></span>&nbsp;
                                            Add Payment Details
                                        </a>
                                    </td>
                                </tr>
                                <tr class="grey-background">
                                    <th class="center-text">S.No.</th>
                                    <th class="center-text">Courses</th>
                                    <th class="center-text">Reference No.</th>
                                    <th class="center-text">Payment Details</th>
                                    <th class="center-text" width="10%">Amount Paid</th>
                                    <th class="center-text">Payment Slip</th>
                                    <th class="center-text">Payment Status</th>
                                    <th class="center-text">Acknowledgement Receipt</th>
                                </tr>
                                --}}

                                @php $sno = '1'; @endphp
                                {{--
                                @foreach ($incidentalpayments as $ip)
                                    <tr>
                                        <td class="center-text">{{ $sno }}</td>
                                        <td class="left-text">
                                            @php
                                                $courseterms = \App\Incidentalpayment::where('reference_number', $ip->reference_number)->get();
                                            @endphp

                                            <ul>
                                                @foreach($courseterms as $c)
                                                    <li>
                                                        <span class="blue-text">
                                                        {{ $c->incidentalfee->programme->course_name }} -
                                                        {{ $c->incidentalfee->term }} year(s)
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="center-text">
                                            <span class="red-text bold-text">
                                                 {{ $ip->reference_number }}
                                            </span>
                                        </td>
                                        <td>
                                            Payment Date: <b><span class="blue-text">{{ $ip->payment_date->format('d-m-Y') }}</span></b><br>
                                            Payment Bank Name: <b><span class="blue-text">{{ $ip->paymentbank->bankname }}</span></b><br>
                                            Payment Type: <b><span class="blue-text">{{ $ip->paymenttype->course_name }}</span></b><br>
                                            Transaction ID / Number: <b><span class="blue-text">{{ $ip->payment_number }}</span></b><br>
                                            Payment Remarks: <b><span class="blue-text">{{ $ip->payment_remark }}</span></b>
                                        </td>
                                        <td class="center-text">
                                            <span class="red-text bold-text">
                                                Rs. {{ $ip->amount_paid }} /-
                                            </span>
                                        </td>
                                        <td class="center-text">
                                            <a href="{{asset('/files/payments/incidentalcharge/'.$ip->filename)}}" target="_blank">
                                                {{ $ip->filename }}
                                            </a>
                                        </td>
                                        <td class="center-text">
                                            <span class="label label-{{ $ip->status->class }}">
                                                {{ $ip->status->status }}
                                            </span>
                                        </td>
                                        <td class="center-text">
                                            <a href="{{ url('/institute/incidentalpayments/download/'.$ip->reference_number) }}"
                                               class="btn btn-info btn-xs" target="_blank">View & Print Receipt</a>
                                            <br>

                                        </td>
                                    </tr>
                                    @php $sno++; @endphp
                                @endforeach
                                --}}
                            </table>
                        </div>

                        @foreach($approvedprogrammes as $approvedprogramme)
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <div class="row">
                                            <div class="col-sm-6">{{ $approvedprogramme->programme->course_name }}</div>
                                            <div class="col-sm-6 right-text">
                                                {{--
                                                @if($approvedprogramme->status_id == 2)
                                                <a href="{{ url('/institute/incidentalpayments/'.$academicyear->id.'/addform') }}" class="btn btn-primary btn-sm">
                                                    <span class="glyphicon glyphicon-plus"></span>&nbsp;
                                                    Add Payment Details
                                                </a>
                                                @endif
                                                --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th class="center-text grey-background">S.No.</th>
                                                <th class="center-text grey-background">Academic Year</th>
                                                <th class="center-text grey-background">Course Code</th>
                                                <th class="center-text grey-background">Course Name</th>
                                                <th class="center-text grey-background">Year</th>
                                                <th class="center-text grey-background">Amount</th>
                                                <th class="center-text grey-background">Offline Payment</th>
                                                <th class="center-text grey-background">Online Payment</th>
                                            </tr>

                                            @php $sno = 1; $total = 0; @endphp
                                            @foreach($incidentalfees->where('academicyear_id', $approvedprogramme->academicyear_id)->where('programme_id', $approvedprogramme->programme_id) as $inf)
                                                <tr>
                                                    <td class="center-text" width="5%">{{ $sno }} @php $sno++; @endphp</td>
                                                    <td class="center-text" width="5%">{{ $inf->academicyear->year }}</td>
                                                    <td width="15%">{{ $inf->programme->course_name }}</td>
                                                    <td width="40%">{{ $inf->programme->name }}</td>
                                                    <td class="center-text" width="5%">{{ $inf->term }}<sup>@if($inf->term == 1)st @else nd @endif</sup></td>
                                                    <td class="center-text" width="10%">Rs. {{ $inf->fee }} @php $total += (int) $inf->fee @endphp</td>
                                                    <td class="center-text">
                                                        {{--
                                                        @if($approvedprogramme->status_id == 2)
                                                            <span class="label label-danger">
                                                                Link under maintenance
                                                            </span>
                                                        @else

                                                        @endif
                                                        --}}


                                                        {{-- Link for Offline Payment --}}
                                                        @if($approvedprogramme->status_id == 2)
                                                            @if($incidentalpayments->where('incidentalfee_id', $inf->id)->where('approvedprogramme_id', $approvedprogramme->id)->count() == 0)
                                                                <p>
                                                                    <a href="{{ url('/institute/incidentalpayments/addform/'.$academicyear->id.'/'.$approvedprogramme->id.'/'.$inf->id) }}" class="btn btn-primary btn-sm">
                                                                        <span class="glyphicon glyphicon-plus"></span>&nbsp;
                                                                        NEFT Details
                                                                    </a>
                                                                </p>
                                                            @else
                                                                @if($incidentalpayments->where('incidentalfee_id', $inf->id)->where('approvedprogramme_id', $approvedprogramme->id)->where('status_id', 2)->count() == 0)
                                                                    @if($incidentalpayments->where('incidentalfee_id', $inf->id)->where('approvedprogramme_id', $approvedprogramme->id)->where('status_id', 6)->count() == 0)
                                                                        <p>
                                                                            <a href="{{ url('/institute/incidentalpayments/addform/'.$academicyear->id.'/'.$approvedprogramme->id.'/'.$inf->id) }}" class="btn btn-primary btn-sm">
                                                                                <span class="glyphicon glyphicon-plus"></span>&nbsp;
                                                                                NEFT Details
                                                                            </a>
                                                                        </p>
                                                                    @endif
                                                                @else

                                                                @endif
                                                            @endif
                                                        @endif

                                                    </td>
                                                    <td class="center-text">
                                                        {{--
                                                        @if($approvedprogramme->status_id == 2)
                                                            <span class="label label-danger">
                                                                Link under maintenance
                                                            </span>
                                                        @else

                                                        @endif
                                                        --}}

                                                        {{-- Link for Online Payment  --}}
                                                        @if($approvedprogramme->status_id == 2)
                                                            @if($incidentalpayments->where('incidentalfee_id', $inf->id)->where('approvedprogramme_id', $approvedprogramme->id)->count() == 0)
                                                                <p>
                                                                    <a href="{{ url('/institute/incidentalpayments/showonlinepaymentform/'.$academicyear->id.'/'.$approvedprogramme->id.'/'.$inf->id) }}" class="btn btn-primary btn-sm">
                                                                        <span class="glyphicon glyphicon-hand-right"></span>&nbsp;
                                                                        Online Payment
                                                                    </a>
                                                                </p>
                                                            @else
                                                                @if($incidentalpayments->where('incidentalfee_id', $inf->id)->where('approvedprogramme_id', $approvedprogramme->id)->where('status_id', 2)->count() == 0)
                                                                    @if($incidentalpayments->where('incidentalfee_id', $inf->id)->where('approvedprogramme_id', $approvedprogramme->id)->where('status_id', 6)->count() == 0)
                                                                        <p>
                                                                            <a href="{{ url('/institute/incidentalpayments/showonlinepaymentform/'.$academicyear->id.'/'.$approvedprogramme->id.'/'.$inf->id) }}" class="btn btn-primary btn-sm">
                                                                                <span class="glyphicon glyphicon-hand-right"></span>&nbsp;
                                                                                Online Payment
                                                                            </a>
                                                                        </p>
                                                                    @endif
                                                                @else

                                                                @endif
                                                            @endif
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach

                                            <tr>
                                                <th class="right-text red-text" colspan="6">Total</th>
                                                <th class="center-text red-text">Rs. {{ $total }}</th>
                                            </tr>
                                        </table>
                                    </div>

                                    @if($approvedprogramme->status_id == 2)
                                        @php $sno = '1'; @endphp
                                        @foreach($incidentalpayments->where('incidentalfee_id', \App\Incidentalfee::where('academicyear_id', $approvedprogramme->academicyear_id)->where('programme_id', $approvedprogramme->programme_id)) as $inp)

                                        @endforeach

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th class="center-text" width="5%">Year</th>
                                                    <th class="center-text" width="10%">Reference No.</th>
                                                    <th class="center-text">Payment Details</th>
                                                    <th class="center-text">Actual Amount</th>
                                                    <th class="center-text" width="10%">Amount Paid</th>
                                                    <th class="center-text">Payment<br>Status</th>
                                                    <th class="center-text">Verification<br>Remarks</th>
                                                    <th class="center-text">Acknowledgement<br>Receipt</th>
                                                </tr>

                                                @foreach($incidentalfees->where('academicyear_id', $approvedprogramme->academicyear_id)->where('programme_id', $approvedprogramme->programme_id) as $inf)
                                                    @foreach($incidentalpayments->where('incidentalfee_id', $inf->id) as $inp)
                                                        <tr>
                                                            <td class="center-text blue-text">{{ $inp->incidentalfee->term }}<sup>@if($inp->incidentalfee->term == 1)st @else nd @endif</sup></td>
                                                            <td class="center-text blue-text">{{ $inp->reference_number }}</td>
                                                            <td class="blue-text">

                                                                @if($inp->payment_mode === "Offline")
                                                                    Payment Mode: <b><span class="red-text">{{ $inp->payment_mode }}</span></b><br>
                                                                    Payment Date: <b><span class="red-text">{{ $inp->payment_date->format('d-m-Y') }}</span></b><br>
                                                                    Payment Bank Name: <b><span class="red-text">{{ $inp->paymentbank->bankname }}</span></b><br>
                                                                    Payment Type: <b><span class="red-text">{{ $inp->paymenttype->course_name }}</span></b><br>
                                                                    Transaction ID / Number: <b><span class="red-text">{{ $inp->payment_number }}</span></b><br>
                                                                    Payment Remarks: <b><span class="red-text">{{ $inp->payment_remark }}</span></b><br>
                                                                    Payment Slip: <b><a href="{{asset('/files/payments/incidentalcharge/'.$inp->filename)}}" target="_blank">{{ $inp->filename }}</a></b>
                                                                @else
                                                                    Payment Mode: <b><span class="red-text">{{ $inp->payment_mode }}</span></b><br>
                                                                    Payment Date: <b><span class="red-text">{{ $inp->order->payment_date->format('d-m-Y') }} ({{ $inp->order->payment_date->format('h:i:s') }})</span></b><br>
                                                                    Order Number: <b><span class="red-text">{{ $inp->order->order_number }}</span></b><br>
                                                                @endif
                                                            </td>
                                                            <td class="center-text blue-text">
                                                                <b>Rs. {{ $inp->incidentalfee->fee }} /-</b>
                                                            </td>
                                                            <td class="center-text blue-text">
                                                                <b>Rs. {{ $inp->amount_paid }} /-</b>
                                                            </td>
                                                            <td class="center-text">
                                                            <span class="label label-{{ $inp->status->class }}">
                                                            {{ $inp->status->status }}
                                                            </span>
                                                            </td>
                                                            <td>
                                                                {{ $inp->verify_remarks }}
                                                            </td>
                                                            <td class="center-text">
                                                                {{--
                                                                <a href="{{ url('/institute/incidentalpayments/download/'.$inp->id) }}"
                                                                   class="btn btn-info btn-xs" target="_blank">View & Print Receipt
                                                                </a>
                                                                --}}
                                                                @if($inp->payment_mode === "Offline")
                                                                    <a href="{{ url('/institute/incidentalpayments/download/'.$inp->id) }}"
                                                                       class="btn btn-info btn-xs" target="_blank">View & Print Receipt
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
