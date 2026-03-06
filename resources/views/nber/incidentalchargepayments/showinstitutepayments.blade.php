@extends('layouts.app')

@section('content')
    <input type="hidden" id="user_id" value="{{ $user->id }}">
    <input type="hidden" id="username" value="{{ $user->username }}">

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading hidethis">
                        <div class="panel-title">
                            Incidental Charge Payment - {{ $academicyear->year }}
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="hidethis">
                                    <ul class="breadcrumb">
                                        <li>
                                            <a href="{{ url('/nber/payments/') }}">Payments</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/nber/payments/incidentalcharge/') }}">Incidental Charge</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/nber/payments/incidentalcharge/'.$academicyear->id) }}">{{ $academicyear->year }}</a>
                                        </li>
                                        <li>
                                            <b>{{ $institute->code }}</b>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            {{ $institute->code }} - {{ $institute->name }}
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        @php $sno = 1; @endphp
                                        @foreach($approvedprogrammes as $approvedprogramme)
                                            <div class="panel panel-danger">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        {{ $approvedprogramme->programme->course_name }}
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
                                                                </tr>
                                                            @endforeach

                                                            <tr>
                                                                <th class="right-text red-text" colspan="5">Total</th>
                                                                <th class="center-text red-text">Rs. {{ $total }}</th>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    @foreach($incidentalpayments->where('approvedprogramme_id', $approvedprogramme->id) as $inp)
                                                        @include('nber.incidentalchargepayments.showmodal')

                                                        <div class="panel panel-success">
                                                            <div class="panel-heading">
                                                                <div class="panel-title">
                                                                    <b>{{ $inp->approvedprogramme->programme->course_name }} {{ $inp->incidentalfee->term }}<sup>@if($inp->incidentalfee->term == 1)st @else nd @endif</sup> year</b>
                                                                    &nbsp; (Incidental Payments ID: #{{$inp->id}})
                                                                </div>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="well well-sm white-background blue-text">
                                                                            <span class="glyphicon glyphicon-info-sign"></span>&nbsp; Payment Information <b>(<span class="red-text bold-text">{{ $inp->payment_mode }}</span>)</b><hr>
                                                                            @if($inp->payment_mode === "Offline")
                                                                            Amount Paid by Institute: Rs. <b><span class="red-text">{{ $inp->amount_paid }}</span></b>.00 /-<br>
                                                                            Payment Date: <b><span class="blue-text">{{ $inp->payment_date->format('d-m-Y') }}</span></b><br>
                                                                            Payment Bank Name: <b><span class="blue-text">{{ $inp->paymentbank->bankname }}</span></b><br>
                                                                            Payment Type: <b><span class="blue-text">{{ $inp->paymenttype->course_name }}</span></b><br>
                                                                            Transaction ID / Number: <b><span class="blue-text">{{ $inp->payment_number }}</span></b><br>
                                                                            Payment Remarks: <b><span class="blue-text">{{ $inp->payment_remark }}</span></b><br>
                                                                            Payment Slip: <b><a href="{{asset('/files/payments/incidentalcharge/'.$inp->filename)}}" target="_blank">{{ $inp->filename }}</a></b>
                                                                            @else
                                                                                Amount Paid by Institute: Rs. <b><span class="red-text">{{ $inp->amount_paid }}</span></b>.00 /-<br>
                                                                                Payment Date: <b><span class="blue-text">{{ $inp->payment_date->format('d-m-Y') }}</span></b><br>
                                                                                Order Number: <b><span class="red-text">{{ $inp->order->order_number }}</span></b><br>
                                                                                CCAvenue Ref Number: <b><span class="red-text">{{ $inp->order->ccavenue_referencenumber }}</span></b><br>
                                                                                Bank Ref Number: <b><span class="red-text">{{ $inp->order->bank_referencenumber }}</span></b><br>
                                                                                Order Status: <b><span class="red-text">{{ $inp->order->order_status }}</span></b><br>
                                                                                Status Message: <b><span class="red-text">{{ $inp->order->status_message }}</span></b><br>
                                                                                Transaction Fee: Rs. <b><span class="red-text">{{ $inp->order->transaction_fee }}</span></b> /-<br>
                                                                                Service Fee: Rs. <b><span class="red-text">{{ $inp->order->service_fee }}</span></b> /-<br>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="well well-sm white-background blue-text">
                                                                            <span class="glyphicon glyphicon-info-sign"></span>&nbsp; Payment Entry Information<hr>
                                                                            Date of Entry: <b><span class="blue-text">{{ $inp->created_at->format('d-m-Y') }}</span></b><br>
                                                                            Name: <b><span class="blue-text">{{ $inp->name }}</span></b><br>
                                                                            Designation: <b><span class="blue-text">{{ $inp->designation }}</span></b><br>
                                                                            Mobile No.: <b><span class="blue-text">{{ $inp->mobilenumber }}</span></b><br>
                                                                            Email: <b><span class="blue-text">{{ $inp->email }}</span></b>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <div class="well well-sm white-background blue-text">
                                                                            <span class="glyphicon glyphicon-info-sign"></span>&nbsp; Payment Verification<hr>
                                                                            Payment Status: <span class="label label-{{$inp->status->class}}" id="displayStatus_{{ $inp->id }}">{{ $inp->status->status }}</span><br>
                                                                            Verification Remarks: <span id="displayVerifyRemarks_{{$inp->id}}">{{ $inp->verify_remarks }} </span><br>
                                                                            Verified by: <span id="displayVerifiedBy_{{ $inp->id }}">@if($inp->user_id != 0) {{ $inp->user->username }} @endif </span><br>
                                                                            Verified on: <span id="displayVerifiedOn_{{$inp->id}}">@if(!is_null($inp->verified_on)) {{ $inp->verified_on->format('d-m-Y') }} @endif </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div id="loadingStatus_{{ $inp->id }}" style="display: none">
                                                                            <img src="{{ asset('/images/processing.gif') }}" width="120" height="120"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-footer">
                                                                <button class="btn btn-success" onclick="updateStatus({{ $inp->id }}, 2)">Approve</button>
                                                                <button class="btn btn-warning" onclick="updateStatus({{ $inp->id }}, 1)">Pending</button>
                                                                <button class="btn btn-danger" onclick="updateStatus({{ $inp->id }}, 3)">Reject</button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
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
        function updateStatus(incidentalpayment_id, status_id) {
            var verify_remarks = '';
            var token = "{{ csrf_token() }}";
            var verified_on = moment().format('DD-MM-YYYY');
            var user_id = $('#user_id').val();
            var username = $('#username').val();

            if(status_id === 2) {
                verify_remarks = 'Approved';
                ajaxCall();
            }
            else {
                $('#showModal_'+incidentalpayment_id).modal('show');

                $('#updateButton_'+incidentalpayment_id).click(function (e) {
                    e.preventDefault();
                    if(!$('#remarks_'+incidentalpayment_id).val()) {
                        alert('Please enter remarks');
                    }
                    else {
                        verify_remarks = $('#remarks_'+incidentalpayment_id).val();
                        $('#showModal_'+incidentalpayment_id).modal('hide');
                        ajaxCall();
                    }
                });
            }

            function ajaxCall() {
                $.ajax({
                    url: "{{ url('/nber/payments/incidentalcharge/updatestatus/') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {_token: token, incidentalpayment_id: incidentalpayment_id, status_id: status_id, verify_remarks: verify_remarks, verified_on: verified_on, user_id: user_id},
                    beforeSend:function() {
                        $('#displayStatus_'+incidentalpayment_id).hide();
                        $('#loadingStatus_'+incidentalpayment_id).show();
                        $('#displayStatus_'+incidentalpayment_id).empty();
                        $('#displayStatus_'+incidentalpayment_id).removeClass();
                        $('#displayVerifyRemarks_'+incidentalpayment_id).html();

                        if(status_id == 1) {
                            $('#displayStatus_'+incidentalpayment_id).addClass('label label-warning');
                        }
                        else if(status_id == 2) {
                            $('#displayStatus_'+incidentalpayment_id).addClass('label label-success');
                        }
                        else {
                            $('#displayStatus_'+incidentalpayment_id).addClass('label label-danger');
                        }
                    },
                    success:function(data) {
                        if(data) {
                            $('#displayVerifiedOn_'+incidentalpayment_id).html(verified_on);
                            $('#displayVerifiedBy_'+incidentalpayment_id).html(username);
                            $('#displayVerifyRemarks_'+incidentalpayment_id).html(verify_remarks);
                            $('#displayStatus_'+incidentalpayment_id).html(data);
                        }
                    },
                    complete:function() {
                        $('#displayStatus_'+incidentalpayment_id).show();
                        $('#loadingStatus_'+incidentalpayment_id).hide();
                    }
                });
            }
        }
    </script>
@endsection