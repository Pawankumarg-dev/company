@extends('layouts.app');

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text blue-text">
                    Add New Entry - Correction Query
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
                            <td width="20%">
                                Institute Details
                            </td>
                            <td colspan="2" class="left-text">
                                {{ $candidate->approvedprogramme->institute->code }} - {{ $candidate->approvedprogramme->institute->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Course and Batch Details
                            </td>
                            <td colspan="2">
                                {{ $candidate->approvedprogramme->programme->course_name }} - {{ $candidate->approvedprogramme->academicyear->year }}
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="3">
                                Student Details
                            </td>
                            <td width="11%">Enrolment No.</td>
                            <td>{{ $candidate->enrolmentno }}</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>{{ $candidate->name }}</td>
                        </tr>
                        <tr>
                            <td>DoB</td>
                            <td>{{ $candidate->dob->format('d-m-Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-condensed">
                        <tr class="grey-background">
                            <th width="5%" class="center-text">S. No.</th>
                            <th class="center-text">Payment Concession</th>
                            <th class="center-text">Inward Type</th>
                            <th class="center-text">Inward No.</th>
                            <th class="center-text">Inward Date</th>
                            <th class="center-text">Payment Type</th>
                            <th class="center-text">Payment Bank</th>
                            <th class="center-text">Payment Number</th>
                            <th class="center-text">Amount Paid</th>
                            <th class="center-text">Payment Remark</th>
                            <th class="center-text">Links</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-condensed">
                        <tr class="grey-background">
                            <th width="5%" class="center-text">S. No.</th>
                            <th class="center-text">Inward Type</th>
                            <th class="center-text">Inward No.</th>
                            <th class="center-text">Inward Date</th>
                            <th class="center-text">Document Type</th>
                            <th class="center-text">Document Remark</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>

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
        function ValidateForm() {
            var name = document.getElementById('name');
            var dob = document.getElementById('dob');
            var fathername = document.getElementById('fathername');
            var yes_payment_required = document.getElementById('yes_payment_required');
            var no_payment_required = document.getElementById('no_payment_required');

            if(name.value == "") {
                alert('Please enter the Name of the Student');
                name.focus();
                return false;
            }

            if(dob.value == "") {
                alert('Please enter the Date of Birth of the Student');
                dob.focus();
                return false;
            }

            if(yes_payment_required.checked == false && no_payment_required.checked == false) {
                alert('Please choose the option - Payment Required or Not');
                return false;
            }
        }
    </script>
@endsection