@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Enrolment Payment for {{ $approvedprogramme->academicyear->year }}
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
                                            <a href="{{ url('/institute/enrolmentpayments/'.$approvedprogramme->academicyear->id) }}">{{ $approvedprogramme->academicyear->year }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/institute/enrolmentpayments/showstudents/'.$approvedprogramme->id) }}">{{ $approvedprogramme->programme->course_name }}</a>
                                        </li>
                                        <li class="active">{{ $candidate->name }}</li>
                                    </ul>
                                </section>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <strong>{{ $candidate->name }} - Online Enrolment Payment Entry Form</strong>
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-12">
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
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">Online Payment Details</div>
                                                    </div>

                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <form class="form-horizontal" action="{{url('/institute/enrolmentpayments/ccavenuepaymentgatewayrequesthandler/')}}" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                                                                    {{csrf_field()}}
                                                                    <input type="hidden" name="enrolmentfee_id" value="{{ $enrolmentfee->id }}">
                                                                    <input type="hidden" name="institute_id" value="{{ $candidate->approvedprogramme->institute_id }}">
                                                                    <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                                                                    <input type="hidden" name="amount" value="{{ $amount }}">
                                                                    <input type="hidden" name="fee_exemption" value="No">
                                                                    <input type="hidden" name="latefee_remark" value="No">
                                                                    <input type="hidden" name="billing_notes" value="{{ $billing_notes }}">
                                                                    <input type="hidden" name="order_number" value="{{ $order_number }}">
                                                                    <input type="hidden" name="order_id" value="{{ $order_number }}" />

                                                                    <div class="form-group">
                                                                        <div class="col-sm-4 text-left blue-text">
                                                                            <label for="payment_date" class="control-label">
                                                                                Amount :
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-3">
                                                                            <div class = "form-control-static">
                                                                                Rs. {{ $amount }}.00 /-
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group {{ $errors->has('billing_name') ? 'has-error' : '' }}">
                                                                        <div class="col-sm-4 text-left blue-text">
                                                                            <label for="billing_name" class="control-label">
                                                                                Name of the Entering Person
                                                                                <span class="red-text">*</span>
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-4">
                                                                            <input type="text" class="form-control" name="billing_name" id="billing_name" placeholder="Enter Name">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group {{ $errors->has('billing_address') ? 'has-error' : '' }}">
                                                                        <div class="col-sm-4 text-left blue-text">
                                                                            <label for="billing_address" class="control-label">
                                                                                Designation of the Entering Person
                                                                                <span class="red-text">*</span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <input type="text" class="form-control" name="billing_address" id="billing_address" placeholder="Enter Designation">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group {{ $errors->has('billing_tel') ? 'has-error' : '' }}">
                                                                        <div class="col-sm-4 text-left blue-text">
                                                                            <label for="billing_tel" class="control-label">
                                                                                Mobile No. of the Entering Person
                                                                                <span class="red-text">*</span>
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-4">
                                                                            <input type="text" class="form-control" name="billing_tel" id="billing_tel" placeholder="Enter Mobile No." maxlength="10">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group {{ $errors->has('billing_email') ? 'has-error' : '' }}">
                                                                        <div class="col-sm-4 text-left blue-text">
                                                                            <label for="billing_email" class="control-label">
                                                                                Email ID of the Entering Person
                                                                                <span class="red-text">*</span>
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-sm-4">
                                                                            <input type="text" class="form-control" name="billing_email" id="billing_email" placeholder="Enter Email ID">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="col-sm-12">
                                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                                <span class="glyphicon glyphicon-circle-arrow-right"></span>
                                                                                Proceed for Online Payment
                                                                            </button>
                                                                            <button type="reset" class="btn btn-danger btn-sm">
                                                                                <span class="glyphicon glyphicon-remove-sign"></span>
                                                                                Cancel
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#billing_tel').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });
        });

        function validateForm() {
            if(!$('#billing_name').val()) {
                swal("Error Occurred!!!", "Enter the Entering Person\'s Name.", "error");
                return false;
            }

            if(!$('#billing_address').val()) {
                swal("Error Occurred!!!", "Enter the Entering Person\'s Designation.", "error");
                return false;
            }

            if(!$('#billing_tel').val()) {
                swal("Error Occurred!!!", "Enter the Entering Person\'s Mobile No.", "error");
                return false;
            }

            if(parseInt($('#billing_tel').val().length) != '10') {
                swal("Error Occurred!!!", "Enter the valid Person\'s Mobile No.", "error");
                return false;
            }

            //alert(parseInt($('#billing_tel').val().length));

            if(!$('#billing_email').val()) {
                swal("Error Occurred!!!", "Enter the Entering Person\'s Email.", "error");
                return false;
            }
            else {
                var email = $('#billing_email').val();
                var mailformat = "^[a-zA-Z0-9]+(\.[_a-zA-Z0-9]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,15})$";

                if (email.match(mailformat)) {
                    return true;
                }
                else {
                    swal("Error Occurred!!!", "Please enter a valid email address", "error");
                    return false;
                }
            }
        }
    </script>
@endsection
