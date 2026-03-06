@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="row">
                                <div class="col-sm-9">{{ $exam->name }} Examinations - Examination Fee Payment</div>
                                <div class="col-sm-3">
                                    <div class="text-right">
                                        <a href="{{ url('institute/examinationpayments/showcourses/'.$exam->id) }}" class="btn btn-primary">Add Examination Payment</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-bordered" role="table">
                                <tr>
                                    <th class="center-text" width="15%">Photo</th>
                                    <th class="center-text" width="20%">Name</th>
                                    <th class="center-text" width="10%">Enrolment No.</th>
                                    <th class="center-text" width="15%">Course</th>
                                    <th class="center-text" width="5%">Enrolled Year</th>
                                    <th class="center-text" width="10%">Total Subjects Applied</th>
                                    <th class="center-text" width="10%">Total Examination Fee</th>
                                </tr>
                                <tr>
                                    <td class="center-text">
                                        <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 100px;" class="img" />
                                    </td>
                                    <td class="blue-text">{{ strtoupper($candidate->name) }}</td>
                                    <td class="blue-text">{{ strtoupper($candidate->enrolmentno) }}</td>
                                    <td class="blue-text center-text">{{ $candidate->approvedprogramme->programme->course_name }}</td>
                                    <td class="blue-text center-text">{{ $candidate->approvedprogramme->academicyear->year }}</td>
                                    <td class="blue-text center-text">
                                        @php
                                            $subjectcount = \App\Http\Controllers\Institute\ExaminationpaymentController::calculatecandidatesubjectcount($exam->id, $candidate->id);
                                            $amount = 150 * $subjectcount;
                                        @endphp
                                        {{ $subjectcount }}
                                    </td>
                                    <td class="blue-text center-text">
                                        <b>Rs. {{ $amount }}.00 /-</b>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="center-text" width="10%">Reference No.</th>
                                    <th class="center-text">Payment Details</th>
                                    <th class="center-text">Subjects Selected</th>
                                    <th class="center-text">Actual Amount</th>
                                    <th class="center-text" width="10%">Amount Paid</th>
                                    <th class="center-text">Payment<br>Status</th>
                                    <th class="center-text">Verification<br>Remarks</th>
                                    <th class="center-text">Acknowledgement<br>Receipt</th>
                                </tr>

                                @foreach($examinationpayments as $exp)
                                    <tr>
                                        <td class="center-text blue-text">{{ $exp->reference_number }}</td>
                                        <td class="blue-text">
                                            Payment Date: <b><span class="blue-text">{{ $exp->payment_date->format('d-m-Y') }}</span></b><br>
                                            Payment Bank Name: <b><span class="blue-text">{{ $exp->paymentbank->bankname }}</span></b><br>
                                            Payment Type: <b><span class="blue-text">{{ $exp->paymenttype->course_name }}</span></b><br>
                                            UTR / Transaction No.: <b><span class="blue-text">{{ $exp->payment_number }}</span></b><br>
                                            Payment Remarks: <b><span class="blue-text">{{ $exp->payment_remark }}</span></b><br>
                                            Payment Slip: <b><a href="{{asset('/files/payments/examination/'.$exp->filename)}}" target="_blank">{{ $exp->filename }}</a></b>
                                        </td>
                                        <td class="center-text red-text">
                                            <b>{{ $exp->calculatecount($exp->id) }}</b>
                                        </td>
                                        <td class="center-text blue-text">
                                            <b>Rs. {{ $exp->calculateexamfee($exp->id) }}.00 /-</b>
                                        </td>
                                        <td class="center-text blue-text">
                                            <b>Rs. {{ $exp->amount_paid }}.00 /-</b>
                                        </td>
                                        <td class="center-text">
                                            <span class="label label-{{ $exp->status->class }}">{{ $exp->status->status }}</span>
                                        </td>
                                        <td>
                                            {{ $exp->verify_remarks }}
                                        </td>
                                        <td class="center-text">
                                            <a href="{{ url('/institute/examinationpayments/downloadstudentreceipt/'.$exp->id) }}"
                                               class="btn btn-info btn-xs" target="_blank">View & Print Receipt
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
@endsection