@extends('layouts.app')
@section('content')
    <section class="container">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb well white-background">
                    <li><a href="{{ url('/nber/payments/') }}">Payments</a></li>
                    <li><a href="{{ url('/nber/payments/enrolment') }}">Enrolment Payments</a></li>
                    <li><a href="{{ url('/nber/payments/enrolment/'.$academicyear->id) }}">{{ $academicyear->year }} Enrolment Payments</a></li>
                    <li class="active">{{ $institute->code }} - {{ $institute->name }}</li>
                </ol>
            </nav>
        </div>
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
                                                {{ $institute->code }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th width="5%">Name</th>
                                            <td class="blue-text">
                                                {{ $institute->name }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- ./Display of Institute's Details--}}

                        {{-- Display of Enrolment Details--}}
                        <div class="panel panel-info">
                            <div class="panel-heading"><div class="blue-text center-text large-text">Enrolment's Details</div></div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" role="table">
                                        <tr>
                                            <th class="center-text bg-success" width="5%">S.No.</th>
                                            <th class="center-text bg-success" width="5%">Batch</th>
                                            <th class="center-text bg-success" width="10%">Programme Code</th>
                                            <th class="center-text bg-success" width="10%">Programme Name</th>
                                            <th class="center-text bg-success" width="10%">Registered Candidate Count</th>
                                            <th class="center-text bg-success" width="10%">Enrolment Candidate Count</th>
                                        </tr>

                                        @php $sno = 1; $registered_count = 0; $enrolment_count = 0; @endphp

                                        @foreach($approvedprogrammes as $approvedprogramme)
                                            <tr>
                                                <td class="center-text">{{ $sno }}</td>
                                                <td class="center-text">{{ $approvedprogramme->academicyear->year }}</td>
                                                <td class="center-text">{{ $approvedprogramme->programme->common_code }}</td>
                                                <td class="center-text">{{ $approvedprogramme->programme->common_name }}</td>
                                                <td class="center-text">{{ $approvedprogramme->registered_count }}</td>
                                                <td class="center-text">{{ $approvedprogramme->enrolment_count }}</td>
                                            </tr>

                                            @php
                                                $sno++;
                                                $registered_count += (int) $approvedprogramme->registered_count;
                                                $enrolment_count += (int) $approvedprogramme->enrolment_count;
                                            @endphp
                                        @endforeach

                                        <tr>
                                            <td colspan="4">
                                                Total
                                            </td>
                                            <td class="center-text bold-text">{{ $registered_count }}</td>
                                            <td class="center-text bold-text">{{ $enrolment_count }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- ./Display of of Examination Application Details--}}

                        {{-- Display of Enrolment Payment Details--}}
                        <div class="panel panel-info">
                            <div class="panel-heading"><div class="blue-text center-text large-text">Enrolment Payment's Details</div></div>
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

                                        @foreach($enrolmentpayments as $data)
                                            <tr>
                                                <td class="center-text">{{ $sno }}</td>
                                                <td class="left-text">
                                                    <input type="hidden" id="reference_number_{{ $count }}" value="{{ $data->reference_number }}" />

                                                    @include('nber.enrolmentpayments.showModal')

                                                    Payment Ref. No.: <b>{{ $data->reference_number }}</b><br>
                                                    Payment Date: <b>{{ $data->payment_date->format('d-m-Y') }}</b><br>
                                                    Payment Bank Name: <b>{{ $data->paymentbank->bankname }}</b><br>
                                                    Payment Type: <b>{{ $data->paymenttype->course_name }}</b><br>
                                                    Transaction ID / Number: <b>{{ $data->payment_number }}</b><br>
                                                    Payment Remarks: <b>{{ $data->payment_remark }}</b>
                                                </td>
                                                <td class="center-text">{{ $data->amount_paid }}</td>
                                                <td class="center-text">
                                                    <a href="{{asset('/files/payments/enrolment/'.$data->filename)}}" target="_blank">
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
                                                    <a href="{{ url('/nber/payments/enrolment-receipt/'.$data->reference_number) }}"
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
                        {{-- ./Display of of Enrolment Payment Details--}}
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
            var reference_number = $('#reference_number_'+count).val();
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
                    url: "{{ url('/nber/payments/enrolment/update-status/') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {_token: token, reference_number: reference_number, status_id: status_id, verify_remarks: verify_remarks, verified_on: verified_on},
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