@extends('layouts.reevaluationapplication')
@section('content')
<section class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <div class="center-text">
                            <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                            <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                            <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                            <span class="h8-text">(An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)</span>
                        </div>
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
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        Payment Details
                                                    </div>
                                                </div>

                                                <div class="panel-body">
                                                    <form id="reevaluationform" class="form-horizontal"
                                                          action="{{ url('/reevaluationapplication/login/addpaymentdetail/') }}"
                                                          method="post" onsubmit="return validateForm()" enctype="multipart/form-data">

                                                        {{csrf_field()}}

                                                        <input type="hidden" name="exam_id" value="{{ $reevaluationapplication->exam->id }}">
                                                        <input type="hidden" name="candidate_id" value="{{ $reevaluationapplication->candidate->id }}">
                                                        <input type="hidden" name="reevaluationapplication_id" value="{{ $reevaluationapplication->id }}">
                                                        <input type="hidden" name="reevaluation_id" value="{{ $reevaluation->id }}">
                                                        <input type="hidden" name="reevaluationapplicationfee_id" value="{{ $reevaluationapplicationfee->id }}">

                                                        <p class="center-text red-text bold-text"><u>Instructions</u></p>
                                                        <ul class="red-text">
                                                            <li>
                                                                Fee should be remitted only through NEFT / RTGS, and cannot claim for refund under
                                                                any circumstances.
                                                            </li>
                                                        </ul>

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
                                                                                format: 'DD-MM-YYYY'
                                                                            });
                                                                        });
                                                                    </script>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group {{ $errors->has('paymenttype_id') ? 'has-error' : '' }}">
                                                            <label for="paymenttype_id" class="control-label col-sm-4">
                                                                <div class="text-left blue-text">2. Payment Mode
                                                                    <span class="red-text">
                                    *
                                </span>
                                                                </div>
                                                            </label>
                                                            <div class="col-sm-3">
                                                                <select class="form-control" name="paymenttype_id" id="paymenttype_id">
                                                                    <option value="0" selected>-- Select an option --</option>

                                                                    @foreach ($paymenttypes as $pt)
                                                                    @if($pt->id != '4')
                                                                    <option value="{{ $pt->id }}">{{ $pt->course_name }}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group {{ $errors->has('paymentbank_id') ? 'has-error' : '' }}">
                                                            <label for="paymentbank_id" class="control-label col-sm-4">
                                                                <div class="text-left blue-text">3. Payment Bank
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
                                                                <div class="text-left blue-text">4. Transaction ID / Number
                                                                    <span class="red-text">
                                    *
                                </span>
                                                                </div>
                                                            </label>
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control" name="payment_number" id="payment_number" placeholder="Enter Transaction ID / UTR No.">
                                                            </div>
                                                        </div>

                                                        <div class="form-group {{ $errors->has('amount_paid') ? 'has-error' : '' }}">
                                                            <label for="amount_paid" class="control-label col-sm-4">
                                                                <div class="text-left blue-text">5. Amount Paid
                                                                    <span class="red-text">*</span>
                                                                </div>
                                                            </label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" name="amount_paid" id="amount_paid" placeholder="Enter Amount Paid">
                                                            </div>
                                                        </div>

                                                        <div class="form-group {{ $errors->has('payment_remark') ? 'has-error' : '' }}">
                                                            <label for="payment_remark" class="control-label col-sm-4">
                                                                <div class="text-left blue-text">
                                                                    6. Payment Remarks
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
                                                                <div class="text-left blue-text">7. Name of the Entering Person
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
                                                                <div class="text-left blue-text">8. Designation of the Entering Person
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
                                                                <div class="text-left blue-text">9. Mobile No. of the Entering Person
                                                                    <span class="red-text">
                                    *
                                </span>
                                                                </div>
                                                            </label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" name="mobilenumber" id="mobilenumber" placeholder="Enter Mobile No." maxlength="10">
                                                            </div>
                                                        </div>

                                                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                                            <label for="email" class="control-label col-sm-4">
                                                                <div class="text-left blue-text">10. Email ID of the Entering Person
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
                                11. Upload Scanned Copy of Payment Slip
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
                                                                <div class="col-sm-6">
                                                                    <input type="file" id="filename" name="filename" onchange="validateFile()">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <a id="filename_link" href="" target="_blank">
                                                                        <span id="filename_display"></span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-5">
                                                                <button type="submit" class="btn btn-success">
                                                                    <span class="glyphicon glyphicon-ok-sign"></span>
                                                                    Submit Application
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

                <div class="panel-footer">
                    Please contact NIEPMD-NBER in case of any queries
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <!-- Error Alert Modal -->
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
    <!-- ./Error Alert Modal -->
</section>

<script>
    $(document).ready(function () {
        $('#amount_paid').keypress(function (e) {
            //if the letter is not digit, then stop type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

        $('#mobilenumber').keypress(function (e) {
            //if the letter is not digit, then stop type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    });

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
    function validateForm() {
        if (!$('#payment_date').val()) {
            $('#modal').modal('show');
            $('#alertmessage').text('Please select the Date of Payment made');
            return false;
        }

        if ($("#paymenttype_id option:selected").val() == 0) {
            $('#modal').modal('show');
            $('#alertmessage').text('Select the Payment Mode from the options given.');

            return false;
        }

        if ($("#paymentbank_id option:selected").val() == 0) {
            $('#modal').modal('show');
            $('#alertmessage').text('Select the Payment Bank from the options given.');

            return false;
        }

        if (!$('#payment_number').val()) {
            $('#modal').modal('show');
            $('#alertmessage').text('Enter the Transaction ID Number / UTR Number.');
            return false;
        }

        if (!$('#amount_paid').val()) {
            $('#modal').modal('show');
            $('#alertmessage').text('Enter the Amount paid.');
            return false;
        }

        if (!$('#name').val()) {
            $('#modal').modal('show');
            $('#alertmessage').text('Enter the Entering Person\'s Name.');
            return false;
        }

        if (!$('#designation').val()) {
            $('#modal').modal('show');
            $('#alertmessage').text('Enter the Entering Person\'s Designation.');
            return false;
        }

        if (!$('#mobilenumber').val()) {
            $('#modal').modal('show');
            $('#alertmessage').text('Enter the Entering Person\'s Mobile No.');
            return false;
        }

        if (!$('#email').val()) {
            $('#modal').modal('show');
            $('#alertmessage').text('Enter the Entering Person\'s Email.');
            return false;
        }

        if ($('#filename').get(0).files.length === 0) {
            $('#modal').modal('show');
            $('#alertmessage').text('Please upload the scanned copy file of payment slip.');
            return false;
        }
    }
</script>
@endsection

