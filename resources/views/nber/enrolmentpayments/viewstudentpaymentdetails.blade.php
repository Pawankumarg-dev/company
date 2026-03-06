@extends('layouts.app')

@section('content')
    <div class="container-fluid">
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
                                            <a href="{{ url('/nber/payments/enrolment/') }}">Enrolment Payments</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/nber/payments/enrolment/'.$candidate->approvedprogramme->academicyear->id) }}">{{ $candidate->approvedprogramme->academicyear->year }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('nber/payments/enrolment/showcourselists/'.$candidate->approvedprogramme->academicyear->id.'/'.$candidate->approvedprogramme->institute->id) }}">{{ $candidate->approvedprogramme->institute->code }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('nber/payments/enrolment/showstudentlists/'.$candidate->approvedprogramme->academicyear->id.'/'.$candidate->approvedprogramme->id) }}">{{ $candidate->approvedprogramme->programme->course_name }} - Students List</a>
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
                                                    <th class="center-text" width="20%">Enrolment</th>
                                                    <th class="center-text" width="20%">Name</th>
                                                    <th class="center-text" width="15%">Course</th>
                                                    <th class="center-text" width="5%">Enrolled Year</th>
                                                    <th class="center-text" width="10%">Candidate<br>Approval<br>Status</th>
                                                </tr>
                                                <tr>
                                                    <td class="center-text">
                                                        <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 100px;" class="img" />
                                                    </td>
                                                    <td class="center-text" id="displayEnrolmentNo">
                                                        @if(is_null($candidate->enrolmentno))
                                                            <p class="label label-danger">
                                                                <span class="glyphicon glyphicon-remove-circle"></span>
                                                                NOT GENERATED
                                                            </p>
                                                        @else
                                                            <span class="blue-text">{{ $candidate->enrolmentno }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="blue-text">{{ strtoupper($candidate->name) }}</td>
                                                    <td class="blue-text center-text">{{ $candidate->approvedprogramme->programme->course_name }}</td>
                                                    <td class="blue-text center-text">{{ $candidate->approvedprogramme->academicyear->year }}</td>
                                                    <td class="blue-text center-text"><span class="label label-success">Approved</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-condensed">
                                                <tr>
                                                    <th class="center-text bg-success" width="3%">S.No.</th>
                                                    <th class="center-text bg-success" width="15%">Payment Details</th>
                                                    <th class="center-text bg-success" width="5%">Actual Amount</th>
                                                    <th class="center-text bg-success" width="5%">Amount Paid</th>
                                                    <th class="center-text bg-success" width="5%">Payment Slip</th>
                                                    <th class="center-text bg-success" width="5%">Payment Status</th>
                                                    <th class="center-text bg-success" width="5%">Payment Receipt</th>
                                                    <th class="center-text bg-success" width="5%">Action</th>
                                                    <th class="center-text bg-success" width="10%">Verify Remarks</th>
                                                    <th class="center-text bg-success" width="5%">Verified On</th>
                                                </tr>
                                                @php $sno = 1; $count = 0; @endphp
                                                @foreach($enrolmentpayments as $enp)
                                                    <input type="hidden" id="reference_number_{{ $count }}" value="{{ $enp->reference_number }}" />

                                                    @include('nber.enrolmentpayments.showModal')
                                                    <tr>
                                                        <td class="center-text blue-text">{{ $sno }}</td>
                                                        <td class="blue-text">
                                                            Reference Number: <b><span class="blue-text">{{ $enp->reference_number }}</span></b><br>
                                                            Payment Date: <b><span class="blue-text">{{ $enp->payment_date->format('d-m-Y') }}</span></b><br>
                                                            Payment Bank Name: <b><span class="blue-text">{{ $enp->paymentbank->bankname }}</span></b><br>
                                                            Payment Type: <b><span class="blue-text">{{ $enp->paymenttype->course_name }}</span></b><br>
                                                            UTR / Transaction No.: <b><span class="blue-text">{{ $enp->payment_number }}</span></b><br>
                                                            Payment Remarks: <b><span class="blue-text">{{ $enp->payment_remark }}</span></b>
                                                        </td>
                                                        <td class="center-text blue-text">
                                                            <b>Rs. {{ $enp->enrolmentfee->enrolment_fee }} /-</b>
                                                        </td>
                                                        <td class="center-text blue-text">
                                                            <b>Rs. {{ $enp->amount_paid }} /-</b>
                                                        </td>
                                                        <td class="center-text">
                                                            <a href="{{asset('/files/payments/enrolment/'.$enp->filename)}}" target="_blank">
                                                                {{ $enp->filename }}
                                                            </a>
                                                        </td>
                                                        <td class="center-text">
                                                            <div id="loadingStatus_{{ $count }}" style="display: none">
                                                                <img src="{{ asset('/images/processing.gif') }}" width="120" height="120"/>
                                                            </div>

                                                            <span class="label label-{{$enp->status->class}}" id="displayStatus_{{ $count }}">{{ $enp->status->status }}</span>
                                                        </td>
                                                        <td class="center-text">
                                                            <a href="{{ url('/nber/payments/enrolment-receipt/'.$enp->id) }}"
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
                                                        {{ $enp->verify_remarks }}
                                                    </span>

                                                        </td>
                                                        <td class="center-text">
                                                    <span id="displayVerifiedOn_{{$count}}">
                                                        @if(!is_null($enp->verified_on))
                                                            {{ $enp->verified_on->format('d-m-Y') }}
                                                        @endif
                                                    </span>
                                                        </td>
                                                    </tr>
                                                    @php $sno++; $count++; @endphp
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
                            $('#displayStatus_'+count).html(data.status);

                            if(data.enrolmentno === 'NULL') {

                            }
                            else {
                                $('#displayEnrolmentNo').text(data.enrolmentno);
                                $('#displayEnrolmentNo').addClass("blue-text");
                            }
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

