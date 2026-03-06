@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{ $exam->name }} Examinations
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li>
                                                    <a href="{{ url('/payment') }}">Payments</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/institute/examinationpayments') }}">Exams List</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/institute/examinationpayments/showcourses/'.$exam->id) }}">{{ $exam->name }} Exams</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/institute/examinationpayments/showstudents/'.$exam->id.'/'.$candidate->approvedprogramme_id) }}">{{ $candidate->approvedprogramme->programme->course_name }} ( {{ $candidate->approvedprogramme->academicyear->year }})</a>
                                                </li>
                                                <li class="active">{{ $candidate->name }} ({{ $candidate->enrolmentno }})</li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-condensed table-hover h7-text">
                                                <thead>
                                                <tr>
                                                    <th class="center-text">S.No.</th>
                                                    <th class="center-text">Payment Ref. No.</th>
                                                    <th width="10%" class="center-text">Subjects Applied</th>
                                                    <th width="5%" class="center-text">Payment Mode</th>
                                                    <th class="center-text">Payment Details</th>
                                                    <th class="center-text">Payment Status</th>
                                                    <th class="center-text">Verification Remarks</th>
                                                </tr>
                                                </thead>

                                                @php $sno = 1; @endphp
                                                <tbody>
                                                @foreach($examinationpayments as $examinationpayment)
                                                    <tr>
                                                        <td>{{ $sno }} @php $sno++; @endphp</td>
                                                        <td>{{ $examinationpayment->reference_number }}</td>
                                                        <td>
                                                            @php $candidateexaminationpayments = $examinationpayment->candidateexaminationpayments;
                                                            $count = 1; $length = $candidateexaminationpayments->count();
                                                            @endphp
                                                            @foreach($candidateexaminationpayments as $candidateexaminationpayment)
                                                                {{ $candidateexaminationpayment->application->subject->scode }}@if($count != $length),@endif
                                                                @php $count++; @endphp
                                                            @endforeach
                                                        </td>
                                                        <td class="center-text">
                                                            {{ $examinationpayment->payment_mode }}
                                                        </td>
                                                        <td>
                                                            @if($examinationpayment->payment_mode == "Online")
                                                                Order No.: <span class="red-text bold-text">{{ $examinationpayment->order->order_number }}</span><br>
                                                                Amount Paid: Rs. <span class="red-text bold-text">{{ $examinationpayment->amount_paid }}</span>
                                                            @else
                                                                Payment Date: <b><span class="red-text bold-text">{{ $examinationpayment->payment_date->format('d-m-Y') }}</span></b><br>
                                                                Payment Bank Name: <b><span class="red-text bold-text">{{ $examinationpayment->paymentbank->bankname }}</span></b><br>
                                                                Payment Type: <b><span class="red-text bold-text">{{ $examinationpayment->paymenttype->course_name }}</span></b><br>
                                                                UTR / Transaction No.: <b><span class="red-text bold-text">{{ $examinationpayment->payment_number }}</span></b><br>
                                                                Payment Remarks: <b><span class="red-text bold-text">{{ $examinationpayment->payment_remark }}</span></b><br>
                                                                Payment Slip: <b><a href="{{asset('/files/payments/examination/'.$examinationpayment->filename)}}" target="_blank">{{ $examinationpayment->filename }}</a></b>
                                                            @endif
                                                        </td>
                                                        <td class="center-text">
                                                            <span class="label label-{{ $examinationpayment->status->class }}">{{ $examinationpayment->status->status }}</span>
                                                        </td>
                                                        <td>
                                                            {{ $examinationpayment->verify_remarks }}
                                                        </td>
                                                    </tr>
                                                @endforeach
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
@endsection
