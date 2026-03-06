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
                                                <li class="active">{{ $examinationpayment->reference_number }}</li>
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

                                @if(Session::has('message'))
                                    <div class="row">
                                        {{--
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <div class="alert alert-{{ Session::get('status_class') }}  alert-dismissible fade in">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong>{{ Session::get('message') }}!!!</strong>
                                            </div>
                                        </div>
                                        --}}
                                        @php echo '<script> swal("Payment Verfication Remarks", "Updated Successfully!!!", "success") </script>'  @endphp
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-success">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-condensed">
                                                                <tr>
                                                                    <td class="center-text" rowspan="4" width="15%">
                                                                        <img src="{{ asset('/files/enrolment/photos/'.$examinationpayment->candidate->photo) }}" style="width: 100px;" class="img" />
                                                                    </td>
                                                                    <td width="10%">Enrolment No.</td>
                                                                    <td class="bold-text orange-text">{{ $examinationpayment->candidate->enrolmentno }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="10%">Name</td>
                                                                    <td class="bold-text orange-text">{{ $examinationpayment->candidate->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="10%">Institute</td>
                                                                    <td class="bold-text orange-text">{{ $examinationpayment->institute->code }} - {{ $examinationpayment->institute->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="10%">Course & Batch</td>
                                                                    <td class="bold-text orange-text">
                                                                        {{ $examinationpayment->candidate->approvedprogramme->programme->course_name }}
                                                                        ({{ $examinationpayment->candidate->approvedprogramme->academicyear->year }})
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-condensed table-bordered medium">
                                                                <tr>
                                                                    <th class="center-text" width="5%">#</th>
                                                                    <th class="center-text" width="5%">Year</th>
                                                                    <th width="10%">Paper Code</th>
                                                                    <th width="75%">Paper Name</th>
                                                                    <th class="center-text" width="10%">Paper Type</th>
                                                                    <th class="center-text" width="10%">Amount</th>
                                                                </tr>
                                                                @php
                                                                    $sno = 1; $amount = 0;
                                                                @endphp
                                                                @foreach($examinationpayment->candidateexaminationpayments as $candidateexaminationpayment)
                                                                    @if(!is_null($candidateexaminationpayment->application))
                                                                    <tr>
                                                                        <td class="center-text blue-text">
                                                                            {{ $sno }} @php $sno++; @endphp
                                                                        </td>
                                                                        <td class="center-text blue-text">{{ $candidateexaminationpayment->application->subject->syear }}</td>
                                                                        <td class="blue-text">{{ $candidateexaminationpayment->application->subject->scode }}</td>
                                                                        <td class="blue-text">{{ $candidateexaminationpayment->application->subject->sname }}</td>
                                                                        <td class="center-text blue-text">{{ $candidateexaminationpayment->application->subject->subjecttype->type }}</td>
                                                                        <td class="center-text blue-text">
                                                                            @php $amount += $candidateexaminationpayment->fee @endphp
                                                                            {{ $candidateexaminationpayment->fee }}
                                                                        </td>
                                                                    </tr>
                                                                    @endif
                                                                @endforeach
                                                                <tr>
                                                                    <th colspan="5" class="right-text">Total Amount</th>
                                                                    <th class="center-text blue-text">{{ $amount }}</th>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="panel panel-warning">
                                                            <div class="panel-body">
                                                                <p class="orange-text bold-text">
                                                                    <span class="glyphicon glyphicon-info-sign"></span> <u>Payment Information</u>
                                                                </p>

                                                                Payment Reference No.: <b><span class="red-text">{{ $examinationpayment->reference_number }}</span></b><br>
                                                                @if($examinationpayment->payment_mode === "Offline")
                                                                    Amount Paid by Institute: Rs. <b><span class="red-text">{{ $examinationpayment->amount_paid }}</span></b>.00 /-<br>
                                                                    Payment Date: <b><span class="blue-text">{{ $examinationpayment->payment_date->format('d-m-Y') }}</span></b><br>
                                                                    Payment Bank Name: <b><span class="blue-text">{{ $examinationpayment->paymentbank->bankname }}</span></b><br>
                                                                    Payment Type: <b><span class="blue-text">{{ $examinationpayment->paymenttype->course_name }}</span></b><br>
                                                                    Transaction ID / Number: <b><span class="blue-text">{{ $examinationpayment->payment_number }}</span></b><br>
                                                                    Payment Remarks: <b><span class="blue-text">{{ $examinationpayment->payment_remark }}</span></b><br>
                                                                    Payment Slip: <b><a href="{{asset('/files/payments/examination/'.$examinationpayment->filename)}}" target="_blank">{{ $examinationpayment->filename }}</a></b>
                                                                @else
                                                                    Amount Paid by Institute: Rs. <b><span class="red-text">{{ $examinationpayment->amount_paid }}</span></b>.00 /-<br>
                                                                    Payment Date: <b><span class="blue-text">{{ $examinationpayment->payment_date->format('d-m-Y') }}</span></b><br>
                                                                    Order Number: <b><span class="red-text">{{ $examinationpayment->order->order_number }}</span></b><br>
                                                                    CCAvenue Ref Number: <b><span class="red-text">{{ $examinationpayment->order->ccavenue_referencenumber }}</span></b><br>
                                                                    Bank Ref Number: <b><span class="red-text">{{ $examinationpayment->order->bank_referencenumber }}</span></b><br>
                                                                    Order Status: <b><span class="red-text">{{ $examinationpayment->order->order_status }}</span></b><br>
                                                                    Status Message: <b><span class="red-text">{{ $examinationpayment->order->status_message }}</span></b><br>
                                                                    Transaction Fee: Rs. <b><span class="red-text">{{ $examinationpayment->order->transaction_fee }}</span></b> /-<br>
                                                                    Service Fee: Rs. <b><span class="red-text">{{ $examinationpayment->order->service_fee }}</span></b> /-<br>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="panel panel-warning">
                                                            <div class="panel-body">
                                                                <p class="orange-text bold-text">
                                                                    <span class="glyphicon glyphicon-info-sign"></span> <u>Payment Entry Information</u>
                                                                </p>
                                                                Date of Entry: <b><span class="blue-text">{{ $examinationpayment->created_at->format('d-m-Y') }}</span></b><br>
                                                                Name: <b><span class="blue-text">{{ $examinationpayment->name }}</span></b><br>
                                                                Designation: <b><span class="blue-text">{{ $examinationpayment->designation }}</span></b><br>
                                                                Mobile No.: <b><span class="blue-text">{{ $examinationpayment->mobilenumber }}</span></b><br>
                                                                Email: <b><span class="blue-text">{{ $examinationpayment->email }}</span></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="panel panel-warning">
                                                            <div class="panel-body">
                                                                <p class="orange-text bold-text">
                                                                    <span class="glyphicon glyphicon-info-sign"></span> <u>Verification Information</u>
                                                                </p>

                                                                <form class="form-horizontal" action="{{url('/nber/examinationpayments/updateverificationremarks')}}" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                                                                    {{csrf_field()}}
                                                                    <input type="hidden" id="examinationpayment_id" name="examinationpayment_id" value="{{ $examinationpayment->id }}" />

                                                                    <div class="form-group">
                                                                        <label for="current_status" class="control-label col-sm-2">
                                                                            <div class="text-left blue-text">Current Status</div>
                                                                        </label>
                                                                        <div class="col-sm-2">
                                                                            <div class="form-control-static">
                                                                                <span class="label label-{{ $examinationpayment->status->class }}">{{ $examinationpayment->status->status }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="current_verification_remarks" class="control-label col-sm-2">
                                                                            <div class="text-left blue-text">Current Verification Remarks</div>
                                                                        </label>
                                                                        <div class="col-sm-2">
                                                                            <div class="form-control-static blue-text bold-text">
                                                                                {{ $examinationpayment->verify_remarks }}
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="last_verified_on" class="control-label col-sm-2">
                                                                            <div class="text-left blue-text">Last updated on</div>
                                                                        </label>
                                                                        <div class="col-sm-2">
                                                                            <div class="form-control-static blue-text bold-text">
                                                                                {{ $examinationpayment->updated_at->format('d-m-Y (h:i:s A)') }}
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group {{ $errors->has('verification_status') ? 'has-error' : '' }}">
                                                                        <label for="verification_status" class="control-label col-sm-2">
                                                                            <div class="text-left blue-text">Verification Status<span class="red-text"> *</span></div>
                                                                        </label>
                                                                        <div class="col-sm-6">
                                                                            <label class="radio-inline"><input type="radio" name="verification_status" id="verification_status1" value="2">Approved</label>
                                                                            <label class="radio-inline"><input type="radio" name="verification_status" id="verification_status2" value="1">Pending</label>
                                                                            <label class="radio-inline"><input type="radio" name="verification_status" id="verification_status3" value="3">Rejected</label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group {{ $errors->has('verfication_remarks_options') ? 'has-error' : '' }}">
                                                                        <label for="verfication_remarks_options" class="control-label col-sm-2">
                                                                            <div class="text-left blue-text">
                                                                                Verification Remarks
                                                                                <span class="red-text"> *</span>
                                                                            </div>
                                                                        </label>
                                                                        <div class="col-sm-10">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <select class="form-control blue-text medium-text" name="verfication_remarks_options" id="verfication_remarks_options">
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <input type="text" class="form-control" name="verification_remarks" id="verification_remarks" placeholder="Enter Verification Remarks">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="col-sm-5 col-sm-offset-2">
                                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                                <span class="glyphicon glyphicon-ok"></span>&nbsp;
                                                                                Update Status
                                                                            </button>
                                                                            <button type="reset" class="btn btn-danger btn-sm">
                                                                                <span class="glyphicon glyphicon-remove"></span>&nbsp;
                                                                                Cancel
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </form>
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
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('#verfication_remarks_options').prop('disabled', true);
            $('#verification_remarks').attr('readonly', true);

            $('input[name="verification_status"]').on('change', function () {
                if($(this).val() === "2") {
                    $('#verfication_remarks_options').prop('disabled', true);
                    $('#verfication_remarks_options').find('option').remove();
                    $('#verfication_remarks_options').append('<option selected="selected" value="2">Approved</option>');
                    $('#verification_remarks').attr('readonly', true);
                    $('#verification_remarks').val('Approved');
                }
                if($(this).val() === "1" || $(this).val() === "3") {
                    $('#verfication_remarks_options').prop('disabled', false);
                    $('#verfication_remarks_options').find('option').remove();
                    $('#verfication_remarks_options').append('<option value="0" selected>Select</option>');
                    $('#verfication_remarks_options').append('<option value="3">Partially Paid</option>');
                    $('#verfication_remarks_options').append('<option value="4">Payment Declined</option>');
                    $('#verfication_remarks_options').append('<option value="5">Payment Not Received</option>');
                    $('#verfication_remarks_options').append('<option value="6">Mismatch Payment Details</option>');
                    $('#verfication_remarks_options').append('<option value="7">Trasaction Failed</option>');
                    $('#verfication_remarks_options').append('<option value="8">Wrong Payment Details Entered</option>');
                    $('#verfication_remarks_options').append('<option value="9">Payment Details Entered Multiple times</option>');
                    $('#verfication_remarks_options').append('<option value="1">Other</option>');
                    $('#verification_remarks').val('');
                    $('#verification_remarks').attr('readonly', true);
                }
            });

            $('input[name="verification_status"]').on('change', function () {
                if($(this).val() === "2") {
                    $('#verfication_remarks_options').prop('disabled', true);
                    $('#verfication_remarks_options').find('option').remove();
                    $('#verfication_remarks_options').append('<option selected="selected" value="2">Approved</option>');
                    $('#verification_remarks').attr('readonly', true);
                    $('#verification_remarks').val('Approved');
                }
                if($(this).val() === "1" || $(this).val() === "3") {
                    $('#verfication_remarks_options').prop('disabled', false);
                    $('#verfication_remarks_options').find('option').remove();
                    $('#verfication_remarks_options').append('<option value="0" selected>Select</option>');
                    $('#verfication_remarks_options').append('<option value="3">Partially Paid</option>');
                    $('#verfication_remarks_options').append('<option value="4">Payment Declined</option>');
                    $('#verfication_remarks_options').append('<option value="5">Payment Not Received</option>');
                    $('#verfication_remarks_options').append('<option value="6">Mismatch Payment Details</option>');
                    $('#verfication_remarks_options').append('<option value="7">Trasaction Failed</option>');
                    $('#verfication_remarks_options').append('<option value="8">Wrong Payment Details Entered</option>');
                    $('#verfication_remarks_options').append('<option value="9">Payment Details Entered Multiple times</option>');
                    $('#verfication_remarks_options').append('<option value="1">Other</option>');
                    $('#verification_remarks').val('');
                    $('#verification_remarks').attr('readonly', true);
                }
            });

            $('#verfication_remarks_options').on('change', function(){
                if($(this).val() === '0') {
                    $('#verification_remarks').val('');
                    $('#verification_remarks').attr('readonly', true);
                }
                else if($(this).val() === '1') {
                    $('#verification_remarks').val('');
                    $('#verification_remarks').attr('readonly', false);
                }
                else {
                    $('#verification_remarks').attr('readonly', true);
                    $('#verification_remarks').val($(this).find("option:selected").text());
                }
            });
        });

        function validateForm() {
            if(!$('input[name="verification_status"]').is(':checked')) {
                swal("Error Occurred!!!", "Please select the Verification Status", "error");
                return false;
            }

            if($('#verification_remarks').val() === "") {
                swal("Error Occurred!!!", "Please enter the verification remarks", "error");
                return false;
            }
        }
    </script>
@endsection