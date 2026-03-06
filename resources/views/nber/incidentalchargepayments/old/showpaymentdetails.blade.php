@extends('layouts.app')

@section('content')
    <style>
    </style>

    <section class="container hidethis">
        <ul class="breadcrumb">
            <li>
                <a href="{{ url('/nber/payments/') }}">Payments</a>
            </li>
            <li>
                <a href="{{ url('/nber/payments/incidentalcharge/') }}">Incidental Charge</a>
            </li>
            <li>
                <a href="{{ url('/nber/payments/incidentalcharge/'.$incidentalfee->academicyear_id) }}">{{ $incidentalfee->academicyear->year }}</a>
            </li>
            <li>
                {{ $approvedprogramme->programme->course_name }} ({{ $incidentalfee->term }})
            </li>
        </ul>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="panel-group">
                        {{-- Display of Institute's Details--}}
                        <div class="panel panel-info">
                            <div class="panel-heading"><div class="blue-text center-text large-text">Institute's Details</div></div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" role="table">
                                        <tr>
                                            <th width="5%">Code</th>
                                            <td class="blue-text">
                                                {{ $approvedprogramme->institute->code }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th width="5%">Name</th>
                                            <td class="blue-text">
                                                {{ $approvedprogramme->institute->name }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- ./Display of Institute's Details--}}

                        {{-- Display of Incidental Charge Payment Details--}}
                        <div class="panel panel-info">
                            <div class="panel-heading"><div class="blue-text center-text large-text">Incidental Charge Payment's Details</div></div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" role="table">
                                        <tr>
                                            <th class="center-text bg-success" width="5%">Batch</th>
                                            <th class="center-text bg-success" width="5%">Programme Code</th>
                                            <th class="center-text bg-success" width="15%">Programme Name</th>
                                            <th class="center-text bg-success" width="5%">Enrolment Count</th>
                                            <th class="center-text bg-success" width="5%">Term</th>
                                            <th class="center-text bg-success" width="5%">Amount</th>
                                        </tr>

                                        @php $enrolment_count = 0; @endphp
                                        <tr>
                                            <td class="center-text">{{ $approvedprogramme->academicyear->year }}</td>
                                            <td class="center-text">{{ $approvedprogramme->programme->common_code }}</td>
                                            <td class="center-text">{{ $approvedprogramme->programme->common_name }}</td>
                                            <td class="center-text">{{ $approvedprogramme->enrolment_count }}</td>
                                            <td class="center-text">{{ $incidentalfee->term }}</td>
                                            <td class="center-text">{{ $incidentalfee->fee }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- ./Display of of Incidental Charge Payment etails--}}

                        {{-- Display of Incidental Charge Payment Details--}}
                        <div class="panel panel-info">
                            <div class="panel-heading"><div class="blue-text center-text large-text">Incidental Charge's Details</div></div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" role="table">
                                        <tr>
                                            <th class="center-text bg-success" width="3%">S.No.</th>
                                            <th class="center-text bg-success" width="15%">Payment Details</th>
                                            <th class="center-text bg-success" width="5%">Amount Paid</th>
                                            <th class="center-text bg-success" width="5%">Payment Slip</th>
                                            <th class="center-text bg-success" width="5%">Payment Status</th>
                                            <th class="center-text bg-success" width="5%">Payment Receipt</th>
                                            <th class="center-text bg-success" width="5%">Action</th>
                                            <th class="center-text bg-success" width="10%">Verify Remarks</th>
                                            <th class="center-text bg-success" width="5%">Verified On</th>
                                        </tr>

                                        @php $sno = 1; $count = 0; @endphp

                                        @foreach($incidentalpayments as $data)
                                            <tr>
                                                <td class="center-text">{{ $sno }}</td>
                                                <td class="left-text">
                                                    <input type="hidden" id="incidentalpayment_id{{ $count }}" value="{{ $data->id }}" />

                                                    @include('nber.incidentalchargepayments.showmodal')

                                                    Payment Ref. No.: <b>{{ $data->reference_number }}</b><br>
                                                    Payment Date: <b>{{ $data->payment_date->format('d-m-Y') }}</b><br>
                                                    Payment Bank Name: <b>{{ $data->paymentbank->bankname }}</b><br>
                                                    Payment Type: <b>{{ $data->paymenttype->course_name }}</b><br>
                                                    Transaction ID / Number: <b>{{ $data->payment_number }}</b><br>
                                                    Payment Remarks: <b>{{ $data->payment_remark }}</b>
                                                </td>
                                                <td class="center-text">{{ $data->amount_paid }}</td>
                                                <td class="center-text">
                                                    <a href="{{asset('/files/payments/incidentalcharge/'.$data->filename)}}" target="_blank">
                                                        {{ $data->filename }}
                                                    </a>
                                                </td>
                                                <td class="center-text">
                                                    <div id="loadingStatus_{{ $count }}" style="display: none">
                                                        <img src="{{ asset('/images/processing.gif') }}" width="120" height="120"/>
                                                    </div>

                                                    <span class="label label-{{$data->status->class}}" id="displayStatus_{{ $count }}">{{ $data->status->status }}</span>
                                                </td>
                                                <td class="center-text">
                                                    <a href="{{ url('/nber/payments/incidentalcharge/receipt/'.$data->reference_number) }}"
                                                       class="btn btn-info btn-xs" target="_blank">View</a>
                                                    <br>
                                                </td>
                                                <td class="center-text">
                                                    <table class="table table-borderless">
                                                        <tr>
                                                            <td>
                                                                <button class="btn btn-success btn-sm" onclick="updateStatus('{{ $count }}', 2)">Approve</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <button class="btn btn-warning btn-sm" onclick="updateStatus('{{ $count }}', 1)">Pending</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <button class="btn btn-danger btn-sm" onclick="updateStatus('{{ $count }}', 3)">Reject</button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td>
                                                    <span id="displayVerifyRemarks_{{$count}}">
                                                        {{ $data->verify_remarks }}
                                                    </span>

                                                </td>
                                                <td class="center-text">
                                                    <span id="displayVerifiedOn_{{$count}}">
                                                        @if(!is_null($data->verified_on))
                                                            {{ $data->verified_on->format('d-m-Y') }}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>

                                            @php
                                                $sno++; $count++;
                                            @endphp
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- ./Display of of Incidental Charge Payment Details--}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {

        });

        function updateStatus(count, status_id) {
            var verify_remarks = '';
            var incidentalpayment_id = $('#incidentalpayment_id'+count).val();
            var token = "{{ csrf_token() }}";
            var verified_on = moment().format('DD-MM-YYYY');

            if(status_id == 2) {
                verify_remarks = 'Approved';
                ajaxCall();
            }
            else {
                $('#showModal_'+count).modal('show');

                $('#updateButton_'+count).click(function (e) {
                    e.preventDefault();
                    if(!$('#remarks_'+count).val()) {
                        alert('Please enter remarks');
                    }
                    else {
                        verify_remarks = $('#remarks_'+count).val();
                        $('#showModal_'+count).modal('hide');
                        ajaxCall();
                    }
                });
            }

            function ajaxCall() {
                $.ajax({
                    url: "{{ url('/nber/payments/incidentalcharge/updatestatus/') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {_token: token, incidentalpayment_id: incidentalpayment_id, status_id: status_id, verify_remarks: verify_remarks, verified_on: verified_on},
                    beforeSend:function() {
                        $('#displayStatus_'+count).hide();
                        $('#loadingStatus_'+count).show();
                        $('#displayStatus_'+count).empty();
                        $('#displayStatus_'+count).removeClass();
                        $('#displayVerifyRemarks_'+count).html();

                        if(status_id == 1) {
                            $('#displayStatus_'+count).addClass('label label-warning');
                        }
                        else if(status_id == 2) {
                            $('#displayStatus_'+count).addClass('label label-success');
                        }
                        else {
                            $('#displayStatus_'+count).addClass('label label-danger');
                        }
                    },
                    success:function(data) {
                        if(data) {
                            $('#displayVerifiedOn_'+count).html(verified_on);
                            $('#displayVerifyRemarks_'+count).html(verify_remarks);
                            $('#displayStatus_'+count).html(data);
                        }
                    },
                    complete:function() {
                        $('#displayStatus_'+count).show();
                        $('#loadingStatus_'+count).hide();
                    }
                });

            }
        }
    </script>
@endsection