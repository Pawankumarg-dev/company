@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Re-Evaluation Payments
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb well white-background">
                                        <li><a href="{{ url('nber/payments/') }}">Payments</a></li>
                                        <li><a href="{{ url('nber/payments/reevaluation') }}">Re-Evaluation</a></li>
                                        <li><a href="{{ url('nber/payments/reevaluation/'.$reevaluation->exam_id) }}">{{ $reevaluation->exam->name }}</a></li>
                                        <li class="active">{{ $reevaluationapplication->application_number }}</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">
                                                            Online Re-Evaluation Application Details - {{ $reevaluationapplication->application_number }}
                                                        </div>
                                                    </div>

                                                    <div class="panel-body">
                                                        <div class="table-responsive col-sm-12">
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                    <td>Application No.</td>
                                                                    <td class="red-text bold-text" colspan="2">{{ $reevaluationapplication->application_number }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="center-text" width="15%" rowspan="4">
                                                                        <img src="{{asset('/files/enrolment/photos')}}/{{$reevaluationapplication->candidate->photo}}"  style="width: 100px; height: 100px !important" class="img" />
                                                                    </td>
                                                                    <td width="11%">Enrolment No</td>
                                                                    <td class="red-text bold-text" width="74%">{{ $reevaluationapplication->candidate->enrolmentno }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td class="red-text bold-text">{{ $reevaluationapplication->candidate->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Course</td>
                                                                    <td class="red-text bold-text">{{ $reevaluationapplication->candidate->approvedprogramme->programme->course_name }} - ({{ $reevaluationapplication->candidate->approvedprogramme->academicyear->year }})</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Institute</td>
                                                                    <td class="red-text bold-text">{{ $reevaluationapplication->candidate->approvedprogramme->institute->code }} - {{ $reevaluationapplication->candidate->approvedprogramme->institute->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Mobile Number</td>
                                                                    <td class="red-text bold-text" colspan="2">
                                                                        {{ $reevaluationapplication->contactnumber }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Email Id</td>
                                                                    <td class="red-text bold-text" colspan="2">
                                                                        {{ $reevaluationapplication->email }}
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>

                                                        @if($reevaluationapplication->reevaluationapplicationsubjects->count() > 0)
                                                            <div class="table-responsive col-sm-12">
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <th class="center-text" colspan="7">Re-Evaluation Options</th>
                                                                    <tr>
                                                                    <tr>
                                                                        <th class="center-text" rowspan="2" width="3%">S.No.</th>
                                                                        <th class="center-text" colspan="2">Paper</th>
                                                                        <th class="center-text" rowspan="3" width="2%">Marks<br>Obtained</th>
                                                                        <th class="center-text" colspan="3" width="15%">Re-Evaluation Options</th>
                                                                        <th class="center-text" rowspan="2" width="5%">Amount</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="center-text" width="5%">Code</th>
                                                                        <th class="center-text"  width="25%">Name</th>
                                                                        <th class="center-text">Re-Evaluation</th>
                                                                        <th class="center-text">Re-Totalling</th>
                                                                        <th class="center-text">Photo-Copying</th>
                                                                    </tr>

                                                                    <tbody>
                                                                    @php $sno = 1; $total_amount = 0; @endphp
                                                                    @foreach($reevaluationapplication->reevaluationapplicationsubjects as $reevaluationapplicationsubject)
                                                                        @php $amount = 0; @endphp
                                                                        <tr>
                                                                            <td class="center-text">{{ $sno }}@php $sno++; @endphp</td>
                                                                            <td>{{ $reevaluationapplicationsubject->subject->scode }}</td>
                                                                            <td>{{ $reevaluationapplicationsubject->subject->sname }}</td>
                                                                            <td class="center-text">{{ $reevaluationapplicationsubject->actual_marks }}</td>
                                                                            <td class="center-text">
                                                                                @if($reevaluationapplicationsubject->reevaluation_applystatus == 1)
                                                                                    @php $amount += $reevaluationapplicationfee->reevaluation_fee; @endphp
                                                                                    <span class="blue-text glyphicon glyphicon-ok"></span>
                                                                                @else
                                                                                    <span class="red-text glyphicon glyphicon-remove"></span>
                                                                                @endif
                                                                            </td>
                                                                            <td class="center-text">
                                                                                @if($reevaluationapplicationsubject->retotalling_applystatus == 1)
                                                                                    @php $amount += $reevaluationapplicationfee->retotalling_fee; @endphp
                                                                                    <span class="blue-text glyphicon glyphicon-ok"></span>
                                                                                @else
                                                                                    <span class="red-text glyphicon glyphicon-remove"></span>
                                                                                @endif
                                                                            </td>
                                                                            <td class="center-text">
                                                                                @if($reevaluationapplicationsubject->photocopying_applystatus == 1)
                                                                                    @php $amount += $reevaluationapplicationfee->photocopying_fee; @endphp
                                                                                    <span class="blue-text glyphicon glyphicon-ok"></span>
                                                                                @else
                                                                                    <span class="red-text glyphicon glyphicon-remove"></span>
                                                                                @endif
                                                                            </td>
                                                                            <td class="right-text">
                                                                                {{ $amount }}.00
                                                                                @php $total_amount += $amount; @endphp
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach

                                                                    <tr>
                                                                        <th colspan="7" class="right-text">Grand Total</th>
                                                                        <th class="right-text">{{ $total_amount }}.00</th>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @else
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="pull-right">
                                                                        <a href="{{ url('/reevaluationapplication/login/showsubjectdetailform/'.$reevaluationapplication->exam_id.'/'.$reevaluationapplication->application_number) }}" class="btn btn-primary">
                                                                            Add Reevaluation Subject Details
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div class="row">
                                                            <div class="col-sm-12">
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

                                                                        @foreach($reevaluationapplication->reevaluationapplicationpayments as $data)
                                                                            @include('nber.reevaluationpayments.show_modal')
                                                                            <tr>
                                                                                <td class="center-text">{{ $sno }}</td>
                                                                                <td class="left-text">
                                                                                    <input type="hidden" id="reevaluationpayment_id{{ $count }}" value="{{ $data->id }}" />

                                                                                    Payment Ref. No.: <b>{{ $data->reference_number }}</b><br>
                                                                                    Payment Date: <b>{{ $data->payment_date->format('d-m-Y') }}</b><br>
                                                                                    Payment Bank Name: <b>{{ $data->paymentbank->bankname }}</b><br>
                                                                                    Payment Type: <b>{{ $data->paymenttype->course_name }}</b><br>
                                                                                    Transaction ID / Number: <b>{{ $data->payment_number }}</b><br>
                                                                                    Payment Remarks: <b>{{ $data->payment_remark }}</b>
                                                                                </td>
                                                                                <td class="center-text">{{ $data->amount_paid }}</td>
                                                                                <td class="center-text">
                                                                                    <a href="{{asset('/files/payments/reevaluation/'.$data->filename)}}" target="_blank">
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
                                                                                    <a href="{{ url('/nber/payments/reevaluation/receipt/'.$data->reference_number) }}"
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
        $(document).ready(function() {

        });

        function updateStatus(count, status_id) {
            var verify_remarks = '';
            var reevaluationpayment_id = $('#reevaluationpayment_id'+count).val();
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
                    url: "{{ url('/nber/payments/reevaluation/updatestatus/') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {_token: token, reevaluationpayment_id: reevaluationpayment_id, status_id: status_id, verify_remarks: verify_remarks, verified_on: verified_on},
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
