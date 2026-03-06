@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title blue-text">
                            <div class="row">
                                <div class="col-sm-9">
                                    Payment for Examination {{ $exam->name }}
                                </div>

                                <div class="col-sm-3">
                                    <!--
                                    <div class="text-right">
                                        <a href="{{url('/institute/examinationpayments/selectstudents')}}" class="btn btn-info">Edit</a>
                                    </div>
                                    -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{url('/institute/examinationpayments/checkpayment')}}" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" id="exam_id" name="exam_id" value="{{ $exam->id }}" />

                            <div class="form-group">
                                <div class="col-sm-12">
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <table class="table table-hover table-condensed">
                                <tr>
                                    <th class="blue-text">Academic Year</th>
                                    <th class="blue-text">Programme</th>
                                    <th class="blue-text">Enrolment No</th>
                                    <th class="blue-text">Name</th>
                                    <th class="blue-text">DOB</th>
                                    <th class="blue-text">Total Subjects Applied</th>
                                    <th class="blue-text">Exam Fee</th>
                                </tr>

                                @php
                                    $sno = 1;
                                    $grand_applied_count = 0;
                                    $grand_total = 0;
                                @endphp

                                    <input type="hidden" name="candidate_id" id="candidate_id" value="{{ $candidate->id }}" />
                                    <input type="hidden" name="examinationfee_id" id="examinationfee_id" value="{{ $examinationfee->id }}" />
                                    <input type="hidden" id="examfee" value="0" />

                                    <tr>
                                        <td class="blue-text">{{ $candidate->approvedprogramme->academicyear->year }}</td>
                                        <td class="blue-text">{{ $candidate->approvedprogramme->programme->course_name }}</td>
                                        <td class="blue-text">
                                            @if($candidate->enrolmentno == '')
                                                NOT ASSIGNED
                                            @else
                                                {{ $candidate->enrolmentno }}
                                            @endif
                                        </td>
                                        <td class="blue-text">{{ $candidate->name }}</td>
                                        <td class="blue-text">{{ $candidate->dob->format('d-m-Y') }}</td>
                                        <td class="blue-text">
                                            @php
                                                $subjectcount = \App\Http\Controllers\Institute\ExaminationpaymentController::calculatecandidatesubjectcount($exam->id, $candidate->id);
                                                $amount = 150 * $subjectcount;
                                            @endphp
                                            {{ $subjectcount }}
                                        </td>
                                        <td class="blue-text">
                                            {{ $amount }}
                                        </td>
                                    </tr>

                                    @php $sno++; @endphp
                            </table>

                            <table class="table table-condensed table-bordered">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Subject Code</th>
                                    <th width="75%">Subject Name</th>
                                    <th width="10%">Subject Type</th>
                                </tr>
                                @php $count = 0; @endphp
                                @foreach($applications as $application)
                                    <tr>
                                        <td class="center-text">
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="application_ids[]" id="application_id{{ $count }}" value="{{ $application->id }}" onclick="selectSubject({{ $count }})"></label>
                                            </div>
                                        </td>
                                        <td>{{ $application->subject->scode }}</td>
                                        <td>{{ $application->subject->sname }}</td>
                                        <td>{{ $application->subject->subjecttype->type }}</td>
                                    </tr>
                                    @php $count++; @endphp
                                @endforeach
                            </table>

                            <div class="form-group {{ $errors->has('payment_date') ? 'has-error' : '' }}">
                                <label for="payment_date" class="control-label col-sm-4">
                                    <div class="text-left blue-text">
                                        Date of Payment made
                                        <span class="red-text">*</span>
                                    </div>
                                </label>
                                <div class="col-sm-3">
                                    <div class='input-group date' id='date'>
                                        <input type='text' class="form-control" placeholder="Select Date" id="payment_date" name="payment_date"/>
                                        <div class="input-group-addon" id='dob'>
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                        <script type="text/javascript">
                                            $(function () {
                                                $('#date').datetimepicker({
                                                    format: 'DD-MM-YYYY',
                                                    maxDate: 'now'
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('paymenttype_id') ? 'has-error' : '' }}">
                                <label for="paymenttype_id" class="control-label col-sm-4">
                                    <div class="text-left blue-text">Payment Mode<span class="red-text">*</span></div>
                                </label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="paymenttype_id" id="paymenttype_id">
                                        <option value="0">-- Select an option --</option>

                                        @foreach ($paymenttypes as $pt)
                                            <option value="{{ $pt->id }}">{{ $pt->course_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('paymentbank_id') ? 'has-error' : '' }}">
                                <label for="paymentbank_id" class="control-label col-sm-4">
                                    <div class="text-left blue-text">Payment Bank
                                        <span class="red-text">*</span></div>
                                </label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="paymentbank_id" id="paymentbank_id">
                                        <option value="0">-- Select an option --</option>

                                        @foreach ($paymentbanks as $pb)
                                            <option value="{{ $pb->id }}">{{ $pb->bankname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('payment_number') ? 'has-error' : '' }}">
                                <label for="payment_number" class="control-label col-sm-4">
                                    <div class="text-left blue-text">Transaction ID / Number<span class="red-text">*</span></div>
                                </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="payment_number" id="payment_number">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="actualamount" class="control-label col-sm-4">
                                    <div class="text-left blue-text">Actual Amount<span class="red-text">*</span></div>
                                </label>
                                <div class="col-sm-2">
                                    <div class="form-control-static" id="actualamount"></div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('amount_paid') ? 'has-error' : '' }}">
                                <label for="amount_paid" class="control-label col-sm-4">
                                    <div class="text-left blue-text">Amount Paid<span class="red-text">*</span></div>
                                </label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" name="amount_paid" id="amount_paid">
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('payment_remark') ? 'has-error' : '' }}">
                                <label for="payment_remark" class="control-label col-sm-4">
                                    <div class="text-left blue-text">
                                        Payment Remarks
                                        <span class="red-text">
                                            (optional)
                                        </span>
                                    </div>
                                </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="payment_remark" id="payment_remark">
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name" class="control-label col-sm-4">
                                    <div class="text-left blue-text">Name of the Entering Person
                                        <span class="red-text">*</span>
                                    </div>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('designation') ? 'has-error' : '' }}">
                                <label for="designation" class="control-label col-sm-4">
                                    <div class="text-left blue-text">Designation of the Entering Person
                                        <span class="red-text">*</span>
                                    </div>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="designation" id="designation" placeholder="Enter Designation">
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('mobilenumber') ? 'has-error' : '' }}">
                                <label for="mobilenumber" class="control-label col-sm-4">
                                    <div class="text-left blue-text">Mobile No. of the Entering Person
                                        <span class="red-text">*</span>
                                    </div>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="mobilenumber" id="mobilenumber" placeholder="Enter Mobile No.">
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                <label for="email" class="control-label col-sm-4">
                                    <div class="text-left blue-text">Email ID of the Entering Person
                                        <span class="red-text">*</span>
                                    </div>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email ID">
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('filename') ? 'has-error' : '' }}">
                                <label for="filename" class="control-label col-sm-4">
                                    <div  class="text-left">
                                        <span class="blue-text">
                                        Upload Scanned Copy of Payment Slip<br>
                                        </span>
                                        <span class="red-text">
                                            (Only .jpg and .pdf format files are allowed and filesize should be less than 1 MB)
                                        </span>
                                    </div>
                                </label>
                                <div class="col-sm-3">
                                    <input type="file" id="filename" name="filename" class="btn btn-default" onchange="validateFile()" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-5">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal" role="dialog">
        <div class="modal-dialog red-background">
            <div class="modal-content">
                <div class="modal-header red-background">
                    <h3><span class="glyphicon glyphicon-alert"></span>&nbsp; Alert Message</h3>
                </div>

                <div class="modal-body">
                    <h4>
                        <span class="red-text" id="alertmessage">

                        </span>
                    </h4>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remove"></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $('document').ready(function() {

        });

        function selectSubject(count) {
            var fee = parseInt($('#examfee').val());
            if($('#application_id'+count).prop("checked") == true) {
                fee += 150;
            }
            else {
                fee -=150;
            }
            $('#examfee').val(fee);
            $('#actualamount').html('Rs. '+fee+' /-');
        }

        function validateForm() {
            var checkPaymentMode = false;
            var checkSubjectSelected = 0;

            if(parseInt($('input[name="application_ids[]"]:checked').length)  == 0) {
                $('#modal').modal('show');
                $('#alertmessage').text('Select the Subject(s)');
                return false;
            }

            if(!$('#payment_date').val()) {
                $('#modal').modal('show');
                $('#alertmessage').text('Select the Date of Payment made from the Date option');
                return false;
            }

            if($( "#paymenttype_id option:selected" ).val() == 0) {
                $('#modal').modal('show');
                $('#alertmessage').text('Select the Payment Mode from the options given.');

                return false;
            }

            if($( "#paymentbank_id option:selected" ).val() == 0) {
                $('#modal').modal('show');
                $('#alertmessage').text('Select the Payment Bank from the options given.');

                return false;
            }

            if(!$('#payment_number').val()) {
                $('#modal').modal('show');
                $('#alertmessage').text('Enter the UTR / Transaction No.');
                return false;
            }

            if(!$('#amount_paid').val()) {
                $('#modal').modal('show');
                $('#alertmessage').text('Enter the Amount paid.');
                return false;
            }

            if(!$('#name').val()) {
                $('#modal').modal('show');
                $('#alertmessage').text('Enter the Entering Person\'s Name.');
                return false;
            }

            if(!$('#designation').val()) {
                $('#modal').modal('show');
                $('#alertmessage').text('Enter the Entering Person\'s Designation.');
                return false;
            }

            if(!$('#mobilenumber').val()) {
                $('#modal').modal('show');
                $('#alertmessage').text('Enter the Entering Person\'s Mobile No.');
                return false;
            }

            if(!$('#email').val()) {
                $('#modal').modal('show');
                $('#alertmessage').text('Enter the Entering Person\'s Email.');
                return false;
            }

            if($('#filename').get(0).files.length === 0) {
                $('#modal').modal('show');
                $('#alertmessage').text('Please upload the scanned copy file of payment slip.');
                return false;
            }


        }

        function validateFile() {
            var ext = $('#filename').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['pdf', 'jpg']) == -1){
                $('#modal').modal('show');
                $('#alertmessage').text('Please upload the scanned file in .jpg or .pdf format only.');
                $('#filename').val(null);
                return false;
            }
            else if ($('#filename')[0].files[0].size > 1048576) {
                $('#modal').modal('show');
                $('#alertmessage').text('Please upload the scanned file less than 1 MB file size.');
                $('#filename').val(null);
                return false;
            }
            else {
                //$('#filename_link').attr('href', $('#filename').val());
                //$('#filename_display').html($('#filename')[0].files[0].name); //->filename
            }

        }
    </script>

    <style>
        .blue-text {
            color: blue !important;
        }
        .red-text {
            color: red !important;
        }
    </style>
@endsection