@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="row">
                                <div class="col-sm-9">Payment for Examination</div>
                                <div class="col-sm-3">
                                    <div class="text-right">
                                        <a href="{{ url('/institute/examinationpayments/showexams') }}" class="btn btn-primary">Add Examination Payment</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-hover table-condensed">
                            <tr>
                                <th>S.No</th>
                                <th>Exam</th>
                                <th>Reference No.</th>
                                <th>Payment Details</th>
                                <th>Amount Paid</th>
                                <th>Payment Slip</th>
                                <th>Payment Status</th>
                                <th>Payment Receipt</th>
                            </tr>

                            @php $sno = 1; @endphp

                            @foreach($examinationpayments->sortByDesc('reference_number') as $ep)
                                <tr>
                                    <td>{{ $sno }}</td>
                                    <td>{{ $ep->examinationfee->exam->name }}</td>
                                    <td>{{ $ep->reference_number }}</td>
                                    <td>
                                        Payment Date: <b>{{ $ep->payment_date->format('d-m-Y') }}</b><br>
                                        Payment Bank Name: <b>{{ $ep->paymentbank->bankname }}</b><br>
                                        Payment Type: <b>{{ $ep->paymenttype->course_name }}</b><br>
                                        Transaction ID / Number: <b>{{ $ep->payment_number }}</b><br>
                                        Payment Remarks: <b>{{ $ep->payment_remark }}</b>
                                    </td>
                                    <td>{{ $ep->amount_paid }}</td>
                                    <td>
                                        <a href="{{asset('/files/payments/examination/'.$ep->filename)}}" target="_blank">
                                            {{ $ep->filename }}
                                        </a>
                                    </td>
                                    <td>{{ $ep->status->status }}</td>
                                    <td>
                                        <a href="{{ url('/institute/examinationpayments/download/'.$ep->examinationfee->exam->id.'/'.$ep->reference_number) }}"
                                           class="btn btn-info btn-xs" target="_blank">View & Print Receipt</a>
                                        <br>
                                    </td>
                                </tr>

                                @php $sno++; @endphp
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection