@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="pane-title">
                            Enrolment Payment for {{ $year }}
                        </div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-hover table-condensed">
                            <tr>
                                <th>S.No</th>
                                <th>Institute Code</th>
                                <th>Reference No.</th>
                                <th>Payment Details</th>
                                <th>Students Count</th>
                                <th>Payment Amount</th>
                                <th>Amount Paid</th>
                                <th>Payment Slip</th>
                                <th>Payment Status</th>
                                <th>Link</th>
                            </tr>

                            @php $sno = 1; @endphp

                            @foreach($enrolmentpayments as $ep)
                                <tr>
                                    <td>{{ $sno }}</td>
                                    <td>{{ $ep->candidate->approvedprogramme->institute->code }}</td>
                                    <td>{{ $ep->reference_number }}</td>
                                    <td>
                                        Payment Date: <b>{{ $ep->payment_date->format('d-m-Y') }}</b><br>
                                        Payment Bank Name: <b>{{ $ep->paymentbank->bankname }}</b><br>
                                        Payment Type: <b>{{ $ep->paymenttype->course_name }}</b><br>
                                        Transaction ID / Number: <b>{{ $ep->payment_number }}</b><br>
                                        Payment Remarks: <b>{{ $ep->payment_remark }}</b>
                                    </td>
                                    <td>
                                        {{ \App\Enrolmentpayment::where('payment_number', $ep->payment_number)->count() }}
                                    </td>
                                    <td>
                                        @php
                                        echo \App\Http\Controllers\Nber\EnrolmentPaymentController::totalamount($ep->reference_number);
                                        @endphp
                                    </td>
                                    <td> Rs. {{ $ep->amount_paid }}/-</td>
                                    <td>
                                        <a href="{{asset('/files/payments/enrolment/'.$ep->filename)}}" target="_blank">
                                            {{ $ep->filename }}
                                        </a>
                                    </td>
                                    <td>{{ $ep->status->status }}</td>
                                    <td>
                                        <button type="button" id="{{ $ep->reference_number }}" name="verify"
                                                class="btn btn-xs btn-info verify_data" data-toggle="modal" data-target="#paymentdetails">
                                            <i class="fa fa-eye"></i> Details
                                        </button>
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

    <!-- Modal - paymentdetails --->
    <div id="paymentdetails" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Payment Details</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- ./Modal - paymentdetails --->

    <script>
        $(document).ready(function () {
            $(document).on('click', '.verify_data', function () {
              var reference_number = $(this).attr("id");

              $.ajax({
                  url:"{{ url('/newpayments/enrolment/view/') }}",
                  method: "POST",
                  data: {reference_number:reference_number},
                  dataType: "json",
                  success:function(data) {

                  }
              })
            })
        });
    </script>
@endsection