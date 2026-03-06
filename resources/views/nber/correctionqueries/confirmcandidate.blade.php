@extends('layouts.app');

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text blue-text">
                    {{ $title }}
                </div>
            </div>
        </div>
    </section>

    {{--
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <form class="form-horizontal" role="form" method="POST"
                      autocomplete="off" accept-charset="UTF-8"
                      action="{{url('/nber/')}}"
                      onsubmit="return ValidateForm()">
                    {{ csrf_field() }}

                    <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">

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

                    <div class="form-group">
                        <label for="studycenter" class="control-label col-sm-3">
                            <div class="text-left blue-text">Study Center Code and Name</div>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control blue-text" id="studycenter" name="studycenter"
                                   value="{{ $candidate->approvedprogramme->institute->code }} : {{ $candidate->approvedprogramme->institute->name }}" readOnly/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="course_and_batch" class="control-label col-sm-3">
                            <div class="text-left blue-text">Course and Batch</div>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control blue-text" id="course_and_batch" name="course_and_batch"
                                   value="{{ $candidate->approvedprogramme->programme->course_name }} : {{ $candidate->approvedprogramme->academicyear->year }}" readOnly/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="enrolmentno" class="control-label col-sm-3">
                            <div class="text-left blue-text">Enrolment Number</div>
                        </label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control blue-text" id="enrolmentno" name="enrolmentno"
                                   value="{{ $candidate->enrolmentno }}" readOnly/>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : 'name' }}">
                        <label for="name" class="control-label col-sm-3">
                            <div class="text-left blue-text">Name</div>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control blue-text" id="name" name="name"
                                   value="{{ $candidate->name }}"/>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('dob') ? 'has-error' : 'dob' }}">
                        <label for="dob" class="control-label col-sm-3">
                            <div class="text-left blue-text">Date of Birth</div>
                        </label>
                        <div class="col-sm-2">
                            <div class='input-group date' id='dob_datetimepicker'>
                                <input type='text' class="form-control blue-text" placeholder="Choose Date of Birth" id="dob" name="dob"  value="{{ $candidate->dob->format('d-m-Y') }}"/>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>

                                <script type="text/javascript">
                                    $(function () {
                                        $('#dob_datetimepicker').datetimepicker({
                                            viewMode: 'years',
                                            format: 'DD-MM-YYYY'
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('fathername') ? 'has-error' : 'fathername' }}">
                        <label for="fathername" class="control-label col-sm-3">
                            <div class="text-left blue-text">Father Name</div>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control blue-text" id="fathername" name="fathername"
                                   value="{{ $candidate->fathername }}"/>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('is_payment_required') ? 'has-error' : 'is_payment_required' }}">
                        <label for="is_payment_required" class="control-label col-sm-3">
                            <div class="text-left blue-text">Is payment required ?</div>
                        </label>
                        <div class="col-sm-8">
                            <label class="radio-inline">
                                <input type="radio" name="is_payment_required" id="yes_payment_required" value="Yes">
                                <span class="blue-text">Yes</span>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="is_payment_required" id="no_payment_required" value="No">
                                <span class="blue-text">No</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('payment_date') ? 'has-error' : '' }}">
                        <label for="payment_date" class="control-label col-sm-3">
                            <div class="text-left blue-text">
                                Date of Payment made
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <div class='input-group date' id='payment_date_datetimepicker'>
                                <input type='text' class="form-control blue-text" placeholder="Choose Payment Date"
                                       id="payment_date" name="payment_date"  value=""/>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>

                                <script type="text/javascript">
                                    $(function () {
                                        $('#payment_date_datetimepicker').datetimepicker({
                                            viewMode: 'years',
                                            format: 'DD-MM-YYYY'
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('paymenttype_id') ? 'has-error' : '' }}">
                        <label for="paymenttype_id" class="control-label col-sm-3">
                            <div class="text-left blue-text">Payment Mode</div>
                        </label>
                        <div class="col-sm-2">
                            <select class="form-control blue-text" name="paymenttype_id" id="paymenttype_id">
                                <option value="0">-- Select an option --</option>

                                @foreach ($paymenttypes as $pt)
                                    <option value="{{ $pt->id }}">{{ $pt->course_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('paymentbank_id') ? 'has-error' : '' }}">
                        <label for="paymentbank_id" class="control-label col-sm-3">
                            <div class="text-left blue-text">Payment Bank</div>
                        </label>
                        <div class="col-sm-5">
                            <select class="form-control blue-text" name="paymentbank_id" id="paymentbank_id">
                                <option value="0">-- Select an option --</option>

                                @foreach ($paymentbanks as $pb)
                                    <option value="{{ $pb->id }}">{{ $pb->bankname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('payment_number') ? 'has-error' : '' }}">
                        <label for="payment_number" class="control-label col-sm-3">
                            <div class="text-left blue-text">DD / Transaction Number</div>
                        </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="payment_number" id="payment_number"
                                   placeholder="Enter the DD / Transaction Number">
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('amount_paid') ? 'has-error' : '' }}">
                        <label for="amount_paid" class="control-label col-sm-3">
                            <div class="text-left blue-text">Amount Paid </div>
                        </label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="amount_paid" id="amount_paid"
                                   placeholder="Enter the Amount paid">
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('payment_remark') ? 'has-error' : '' }}">
                        <label for="payment_remark" class="control-label col-sm-3">
                            <div class="text-left blue-text">
                                Payment Remarks
                                <span class="red-text">
                                            (optional)
                                        </span>
                            </div>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="payment_remark" id="payment_remark"
                                   placeholder="Enter the Payment's remarks">
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('received_marksheet') ? 'has-error' : '' }}">
                        <label for="received_marksheet" class="control-label col-sm-3">
                            <div class="text-left blue-text">No. of received original Marksheet</div>
                        </label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control blue-text" name="received_marksheet" id="received_marksheet">
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('received_certificate') ? 'has-error' : '' }}">
                        <label for="received_certificate" class="control-label col-sm-3">
                            <div class="text-left blue-text">No. of received original Certificate</div>
                        </label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control blue-text" name="received_certificate" id="received_certificate">
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="reset" class="btn btn-danger">Reset Values</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    --}}

    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <td width="20%" rowspan="4">

                            </td>
                            <td width="11%">Institute</td>
                            <td colspan="2" class="left-text">
                                {{ $candidate->approvedprogramme->institute->code }} - {{ $candidate->approvedprogramme->institute->name }}
                            </td>
                        </tr>
                        <tr>
                            <td width="11%">Course</td>
                            <td colspan="2">
                                {{ $candidate->approvedprogramme->programme->course_name }}
                            </td>
                        </tr>
                        <tr>
                            <td width="11%">Batch</td>
                            <td colspan="2">
                                {{ $candidate->approvedprogramme->academicyear->year }}
                            </td>
                        </tr>
                        <tr>
                            <td width="11%">Enrolment No.</td>
                            <td>{{ $candidate->enrolmentno }}</td>
                        </tr>
                    </table>
                </div>

                <form class="form-horizontal" role="form" method="POST"
                      autocomplete="off" accept-charset="UTF-8"
                      action="{{url('/nber/correction-query/check-confirm-candidate/')}}" onsubmit="return validateform()">
                    {{ csrf_field() }}

                    <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                    <input type="hidden" name="correctionquery_type" value="{{ $correctionquery_type }}">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <th width="7%">Select</th>
                            <th width="13%">Correction Field</th>
                            <th width="40%">Present Value</th>
                            <th width="40%">Correction Value</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox center-text">
                                    <label><input type="checkbox" name="namecorrection_status" id="sno_1" onclick="enabledisablefield(1)"></label>
                                </div>
                            </td>
                            <th>Name</th>
                            <td>{{ $candidate->name }}</td>
                            <td>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" id="namecorrection_value" name="namecorrection_value"
                                           placeholder="Candidate Name" style="display: none"/>
                                    <script>
                                        $(document).ready(function () {
                                            $('#namecorrection_value').keyup(function () {
                                                $(this).val($(this).val().toUpperCase());
                                            });
                                        });
                                    </script>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox center-text">
                                    <label><input type="checkbox" name="fathernamecorrection_status" id="sno_2" onclick="enabledisablefield(2)"></label>
                                </div>
                            </td>
                            <th>Father Name</th>
                            <td>{{ $candidate->fathername }}</td>
                            <td>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" id="fathernamecorrection_value" name="fathernamecorrection_value"
                                           placeholder="Candidate Fathername" style="display: none"/>
                                    <script>
                                        $(document).ready(function () {
                                            $('#fathernamecorrection_value').keyup(function () {
                                                $(this).val($(this).val().toUpperCase());
                                            });
                                        });
                                    </script>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox center-text">
                                    <label><input type="checkbox" name="dobcorrection_status" id="sno_3" onclick="enabledisablefield(3)"></label>
                                </div>
                            </td>
                            <th>Date of Birth</th>
                            <td>{{ $candidate->dob->format('d-m-Y') }}</td>
                            <td>
                                <div id="dobfield" style="display: none">
                                    <div class="col-sm-6">
                                        <div class='input-group date' id='dob'>
                                            <input type='text' class="form-control" placeholder="Select DoB" id="dobcorrection_value" name="dobcorrection_value"/>
                                            <div class="input-group-addon" id='dob'>
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </div>
                                            <script type="text/javascript">
                                                $(function () {
                                                    $('#dob').datetimepicker({
                                                        format: 'DD-MM-YYYY'
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    </table>

                    <div class="form-group">
                        <label for="payment_required" class="control-label col-sm-3">
                            <div class="left-text">
                                Mobile No.
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="contactnumber" name="contactnumber"
                                           placeholder="Candidate Mob. No." maxlength="10" value="{{ $candidate->contactnumber }}" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="payment_required" class="control-label col-sm-3">
                            <div class="left-text">
                                Email Address
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="email" name="email"
                                           placeholder="Candidate Email" value="{{ $candidate->email }}" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="payment_required" class="control-label col-sm-3">
                            <div class="left-text">
                                Received Original Documents
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <input type="checkbox"> Statement of Marks
                                        <input type="text" size="3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="payment_required" class="control-label col-sm-3">
                            <div class="left-text">
                                Is Payment required?
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="radio-inline"><input type="radio" id="payment_required1" name="payment_required" value="Yes">Yes</label>
                                    <label class="radio-inline"><input type="radio" id="payment_required2" name="payment_required" value="No">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="proofdocument_required" class="control-label col-sm-3">
                            <div class="left-text">
                                Is Proof of Document(s) required?
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="radio-inline"><input type="radio" id="proofdocument_required1" name="proofdocument_required" value="Yes">Yes</label>
                                    <label class="radio-inline"><input type="radio" id="proofdocument_required2" name="proofdocument_required" value="No">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="originaldocument_required" class="control-label col-sm-3">
                            <div class="left-text">
                                Is Original Document(s) required?
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="radio-inline"><input type="radio" id="originaldocument_required1" name="originaldocument_required" value="Yes">Yes</label>
                                    <label class="radio-inline"><input type="radio" id="originaldocument_required2" name="originaldocument_required" value="No">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-5 left-text">
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-ok"></span>
                                Submit
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove"></span>
                                Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal" role="dialog">
        <div class="modal-dialog red-background">
            <div class="modal-content">
                <div class="modal-header red-background">
                    <h3><span class="glyphicon glyphicon-alert"></span>&nbsp; Alert Message</h3>
                </div>

                <div class="modal-body">
                    <span class="red-text" id="alertmessage">

                    </span>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remove"></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{--
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="row">
                    <div class="col-sm-12">
                        <a href="#" class="pull-right btn btn-sm btn-primary">Add Payment Details</a>
                    </div>
                    <div class="col-sm-12">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <th width="5%">S.No.</th>
                            <th>Has payment required</th>
                            <th>Inward Type</th>
                            <th>Inward No.</th>
                            <th>Inward Date</th>
                            <th>Payment Type</th>
                            <th>Payment Bank</th>
                            <th>Payment Number</th>
                            <th>Amount Paid</th>
                            <th>Payment Remark</th>
                        </tr>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    --}}

    <script>
        function validateform() {
            var count = '0';
            for (i = '1'; i <= '3'; i++) {
                var checkbox = document.getElementById('sno_'+i);

                if(i == '1') {
                    var field = document.getElementById('namecorrection_value');

                    if(checkbox.checked == true) {
                        if(field.value == '') {
                            //alert('Candidate Name cannot be left blank.');
                            $('#modal').modal('show');
                            $('#alertmessage').text('Name of the Candidate cannot be left blank!!!');
                            return false;
                        }
                        else {
                            count++;
                        }
                    }
                }
                else if(i == '2') {
                    var field = document.getElementById('fathernamecorrection_value');

                    if(checkbox.checked == true) {
                        if(field.value == '') {
                            //alert('Candidate Fathername cannot be left blank.');
                            $('#modal').modal('show');
                            $('#alertmessage').text('Father Name of the Candidate cannot be left blank!!!');
                            return false;
                        }
                        else {
                            count++;
                        }
                    }
                }
                else {
                    var field = document.getElementById('dobcorrection_value');

                    if(checkbox.checked == true) {
                        if(field.value == '') {
                            //alert('Candidate Date of Birth cannot be left blank.');
                            $('#modal').modal('show');
                            $('#alertmessage').text('Date of Birth (DoB) of the Candidate cannot be left blank!!!');
                        }
                        else {
                            count++;
                        }
                    }
                }
            }

            if ((count == '0')) {
                //alert('Please select a correction field');
                $('#modal').modal('show');
                $('#alertmessage').text('Please select any correction field option!!!');
                return false;
            }

            if(!$('input:radio[name="payment_required"]').is(":checked")) {
                $('#modal').modal('show');
                $('#alertmessage').text('Please select Payment Required option!!!');
                return false;
            }

            if(!$('input:radio[name="proofdocument_required"]').is(":checked")) {
                $('#modal').modal('show');
                $('#alertmessage').text('Please select Proof of Document(s) Required option!!!');
                return false;
            }

            if(!$('input:radio[name="originaldocument_required"]').is(":checked")) {
                $('#modal').modal('show');
                $('#alertmessage').text('Please select Original Document(s) Required option!!!');
                return false;
            }
        }

        function enabledisablefield(sno) {
            var checkbox = document.getElementById('sno_'+sno);

            if(sno == '1') {
                var field = document.getElementById('namecorrection_value');

                if(checkbox.checked == true) {
                    field.style.display = 'inline';
                    field.value = '';
                }
                else {
                    field.style.display = 'none';
                    field.value = '';
                }
            }
            else if(sno == '2') {
                var field = document.getElementById('fathernamecorrection_value');

                if(checkbox.checked == true) {
                    field.style.display = 'inline';
                    field.value = '';
                }
                else {
                    field.style.display = 'none';
                    field.value = '';
                }
            }
            else {
                var dob = document.getElementById('dobcorrection_value');
                var field = document.getElementById('dobfield');

                if(checkbox.checked == true) {
                    field.style.display = 'inline';
                    dob.value = '';
                }
                else {
                    field.style.display = 'none';
                    dob.value = '';
                }
            }
        }
    </script>
@endsection