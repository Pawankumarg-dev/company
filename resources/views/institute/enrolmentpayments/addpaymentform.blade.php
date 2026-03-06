@extends('layouts.app')

@section('content')
    <div class="container">
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
                                            <a href="{{ url('/institute/dashboard/home') }}">Home</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/institute/enrolmentpayments/') }}">Enrolment Payments</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/institute/enrolmentpayments/'.$candidate->approvedprogramme->academicyear->id) }}">{{ $candidate->approvedprogramme->academicyear->year }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('institute/enrolmentpayments/showstudents/'.$candidate->approvedprogramme_id) }}">{{ $candidate->approvedprogramme->programme->course_name }}</a>
                                        </li>
                                        <li class="active">
                                            {{ strtoupper($candidate->name) }}
                                        </li>
                                    </ul>
                                </section>
                            </div>
                        </div>
                        <form class="form-horizontal" action="{{url('/institute/enrolmentpayments/addpaymentdetails/')}}" method="post" autocomplete="off" onsubmit="return validateForm()" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="enrolmentfee_id" value="{{ $enrolmentfee->id }}">
                            <input type="hidden" name="institute_id" value="{{ $candidate->approvedprogramme->institute_id }}">
                            <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                            <input type="hidden" name="fee_exemption" value="No">
                            <input type="hidden" name="latefee_remark" value="No">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <strong>{{ strtoupper($candidate->name) }} - Offline Enrolment Payment Entry Form</strong>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-condensed table-bordered" role="table">
                                                    <tr>
                                                        <th class="center-text" width="15%">Photo</th>
                                                        <th class="center-text" width="20%">Name</th>
                                                        <th class="center-text" width="15%">Course</th>
                                                        <th class="center-text" width="5%">Enrolled Year</th>
                                                        <th class="center-text" width="10%">Candidate<br>Approval<br>Status</th>
                                                        <th class="center-text" width="10%">Enrolment<br>Fee</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="center-text">
                                                            <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 100px;" class="img" />
                                                        </td>
                                                        <td class="blue-text">{{ strtoupper($candidate->name) }}</td>
                                                        <td class="blue-text center-text">{{ $candidate->approvedprogramme->programme->course_name }}</td>
                                                        <td class="blue-text center-text">{{ $candidate->approvedprogramme->academicyear->year }}</td>
                                                        <td class="blue-text center-text"><span class="label label-success">Approved</span></td>
                                                        <td class="blue-text center-text">500</td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <div class="panel-title">Offline Payment Details</div>
                                                </div>

                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-sm-12 medium-text">
                                                            <div class="form-group {{ $errors->has('payment_date') ? 'has-error' : '' }}">
                                                                <label for="payment_date" class="control-label col-sm-4">
                                                                    <div class="text-left blue-text">
                                                                        1. Date of Payment made
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
                                                                    <div class="text-left blue-text">3. Payment Mode
                                                                        <span class="red-text">
                                    *
                                </span>
                                                                    </div>
                                                                </label>
                                                                <div class="col-sm-3">
                                                                    <select class="form-control" name="paymenttype_id" id="paymenttype_id">
                                                                        <option value="0" selected>-- Select an option --</option>

                                                                        @foreach ($paymenttypes as $pt)
                                                                            @if($pt->id != '1')
                                                                                <option value="{{ $pt->id }}">{{ $pt->course_name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group {{ $errors->has('paymentbank_id') ? 'has-error' : '' }}">
                                                                <label for="paymentbank_id" class="control-label col-sm-4">
                                                                    <div class="text-left blue-text">4. Payment Bank
                                                                        <span class="red-text">
                                    *
                                </span>
                                                                    </div>
                                                                </label>
                                                                <div class="col-sm-5">
                                                                    <select class="form-control" name="paymentbank_id" id="paymentbank_id">
                                                                        <option value="0" selected>-- Select an option --</option>

                                                                        @foreach ($paymentbanks as $pb)
                                                                            <option value="{{ $pb->id }}">{{ $pb->bankname }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group {{ $errors->has('payment_number') ? 'has-error' : '' }}">
                                                                <label for="payment_number" class="control-label col-sm-4">
                                                                    <div class="text-left blue-text">5. UTR / Transaction No.
                                                                        <span class="red-text">
                                    *
                                </span>
                                                                    </div>
                                                                </label>
                                                                <div class="col-sm-5">
                                                                    <input type="text" class="form-control" name="payment_number" id="payment_number" placeholder="Enter UTR / Transaction No.">
                                                                </div>
                                                            </div>

                                                            <div class="form-group {{ $errors->has('amount_paid') ? 'has-error' : '' }}">
                                                                <label for="amount_paid" class="control-label col-sm-4">
                                                                    <div class="text-left blue-text">6. Amount Paid
                                                                        <span class="red-text">
                                    *
                                </span>
                                                                    </div>
                                                                </label>
                                                                <div class="col-sm-3">
                                                                    <input type="number" class="form-control" name="amount_paid" id="amount_paid" placeholder="Enter Amount Paid">
                                                                </div>
                                                            </div>

                                                            <div class="form-group {{ $errors->has('payment_remark') ? 'has-error' : '' }}">
                                                                <label for="payment_remark" class="control-label col-sm-4">
                                                                    <div class="text-left blue-text">
                                                                        7. Payment Remarks
                                                                        <span class="red-text">
                                            (optional)
                                        </span>
                                                                    </div>
                                                                </label>
                                                                <div class="col-sm-7">
                                                                    <input type="text" class="form-control" name="payment_remark" placeholder="Enter Payment Remarks (optional)">
                                                                </div>
                                                            </div>

                                                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                                                <label for="name" class="control-label col-sm-4">
                                                                    <div class="text-left blue-text">8. Name of the Entering Person
                                                                        <span class="red-text">
                                    *
                                </span>
                                                                    </div>
                                                                </label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                                                                </div>
                                                            </div>

                                                            <div class="form-group {{ $errors->has('designation') ? 'has-error' : '' }}">
                                                                <label for="designation" class="control-label col-sm-4">
                                                                    <div class="text-left blue-text">9. Designation of the Entering Person
                                                                        <span class="red-text">
                                    *
                                </span>
                                                                    </div>
                                                                </label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control" name="designation" id="designation" placeholder="Enter Designation">
                                                                </div>
                                                            </div>

                                                            <div class="form-group {{ $errors->has('mobilenumber') ? 'has-error' : '' }}">
                                                                <label for="mobilenumber" class="control-label col-sm-4">
                                                                    <div class="text-left blue-text">10. Mobile No. of the Entering Person
                                                                        <span class="red-text">
                                    *
                                </span>
                                                                    </div>
                                                                </label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control" name="mobilenumber" id="mobilenumber" placeholder="Enter Mobile No.">
                                                                </div>
                                                            </div>

                                                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                                                <label for="email" class="control-label col-sm-4">
                                                                    <div class="text-left blue-text">11. Email ID of the Entering Person
                                                                        <span class="red-text">
                                    *
                                </span>
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
                                12. Upload Scanned Copy of Payment Slip
                                    <span class="red-text">
                                    *
                                </span><br>
                                </span>
                                                                        <span class="red-text">
                                    (Only .jpg and .pdf format files are allowed and filesize should be less than 1 MB)
                                </span>
                                                                    </div>
                                                                </label>
                                                                <div class="col-sm-7">
                                                                    <input type="file" id="filename" name="filename" class="btn btn-default" onchange="validateFile()" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-footer">
                                                    <div class="container">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary" name="submit"><span class="glyphicon glyphicon-ok-sign"></span>&nbsp; Submit Payment Details</button>
                                                            <button type="reset" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span>&nbsp; Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                    <div class="container">
                        <button type="submit" class="btn btn-danger" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remove"></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('document').ready(function() {

        });

        function validateForm() {
            var checkPaymentMode = false;

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

@endsection

