@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            {{ $candidate->approvedprogramme->institute->code }} - {{ $candidate->approvedprogramme->institute->name }}
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{ $exam->name }} Examinations - Payment Online Form
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-condensed">
                                                <tr>
                                                    <th class="center-text blue-text">Academic Year</th>
                                                    <th class="center-text blue-text">Programme</th>
                                                    <th class="center-text blue-text">Enrolment No</th>
                                                    <th class="center-text blue-text">Name</th>
                                                    <th class="center-text blue-text">DOB</th>
                                                    <th class="center-text blue-text">Total Subjects Applied</th>
                                                    <th class="center-text blue-text">Exam Fee</th>
                                                </tr>

                                                @php
                                                    $sno = 1;
                                                    $grand_applied_count = 0;
                                                    $grand_total = 0;
                                                @endphp
                                                <tr>
                                                    <td class="center-text red-text">{{ $candidate->approvedprogramme->academicyear->year }}</td>
                                                    <td class="center-text red-text">{{ $candidate->approvedprogramme->programme->course_name }}</td>
                                                    <td class="center-text red-text">
                                                        @if($candidate->enrolmentno == '')
                                                            NOT ASSIGNED
                                                        @else
                                                            {{ $candidate->enrolmentno }}
                                                        @endif
                                                    </td>
                                                    <td class="center-text red-text">{{ $candidate->name }}</td>
                                                    <td class="center-text red-text">{{ $candidate->dob->format('d-m-Y') }}</td>
                                                    <td class="center-text red-text">
                                                        @php
                                                            $subjectcount = \App\Http\Controllers\Institute\ExaminationpaymentController::calculatecandidatesubjectcount($exam->id, $candidate->id);
                                                            $amount = 100 * $subjectcount;
                                                        @endphp
                                                        {{ $subjectcount }}
                                                    </td>
                                                    <td class="center-text red-text">
                                                        Rs. {{ $amount }}.00 /-
                                                    </td>
                                                </tr>

                                                @php $sno++; @endphp
                                            </table>
                                        </div>

                                        <form class="form-horizontal" action="{{url('/institute/examinationpayments/ccavenuepaymentgatewayrequesthandler/')}}" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            <input type="hidden" id="exam_id" name="exam_id" value="{{ $exam->id }}" />
                                            <input type="hidden" id="examinationfee_id" name="examinationfee_id" value="{{ $examinationfee_id }}" />
                                            <input type="hidden" id="institute_id" name="institute_id" value="{{ $candidate->approvedprogramme->institute_id }}" />
                                            <input type="hidden" id="candidate_id" name="candidate_id" value="{{ $candidate->id }}" />
                                            <input type="hidden" id="billing_notes" name="billing_notes" value="{{ $billing_notes }}" />
                                            <input type="hidden" id="order_number" name="order_number" value="{{ $order_number }}" />
                                            <input type="hidden" id="order_id" name="order_id" value="{{ $order_number }}" />
                                            <input type="hidden" id="amount" name="amount" value="{{ $amount }}" />

                                            <div class="table-responsive">
                                                <table class="table table-condensed table-bordered">
                                                    <tr>
                                                        <th class="center-text" width="5%">#</th>
                                                        <th width="10%">Paper Code</th>
                                                        <th width="75%">Paper Name</th>
                                                        <th class="center-text" width="10%">Paper Type</th>
                                                    </tr>
                                                    @php $sno = 1; $count = 0; @endphp
                                                    @foreach($applications as $application)
                                                        <input type="hidden"  name="application_ids[]" id="application_id{{ $count }}" value="{{ $application->id }}" />
                                                        <tr>
                                                            <td class="center-text blue-text">
                                                                {{ $sno }} @php $sno++; @endphp
                                                            </td>
                                                            <td class="blue-text">{{ $application->subject->scode }}</td>
                                                            <td class="blue-text">{{ $application->subject->sname }}</td>
                                                            <td class="center-text blue-text">{{ $application->subject->subjecttype->type }}</td>
                                                        </tr>
                                                        @php $count++; @endphp
                                                    @endforeach
                                                </table>
                                            </div>

                                            <div class="form-group">
                                                <label for="payment_date" class="control-label col-sm-4">
                                                    <div class="text-left blue-text">
                                                        Amount :
                                                    </div>
                                                </label>
                                                <div class="col-sm-3">
                                                    <div class = "form-control-static">
                                                        Rs. {{ $amount }}.00 /-
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group {{ $errors->has('billing_name') ? 'has-error' : '' }}">
                                                <label for="billing_name" class="control-label col-sm-4">
                                                    <div class="text-left blue-text">Name of the Entering Person
                                                        <span class="red-text">*</span>
                                                    </div>
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="billing_name" id="billing_name" placeholder="Enter Name">
                                                </div>
                                            </div>

                                            <div class="form-group {{ $errors->has('billing_address') ? 'has-error' : '' }}">
                                                <label for="billing_address" class="control-label col-sm-4">
                                                    <div class="text-left blue-text">Designation of the Entering Person
                                                        <span class="red-text">*</span>
                                                    </div>
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="billing_address" id="billing_address" placeholder="Enter Designation">
                                                </div>
                                            </div>

                                            <div class="form-group {{ $errors->has('billing_tel') ? 'has-error' : '' }}">
                                                <label for="billing_tel" class="control-label col-sm-4">
                                                    <div class="text-left blue-text">Mobile No. of the Entering Person
                                                        <span class="red-text">*</span>
                                                    </div>
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="billing_tel" id="billing_tel" placeholder="Enter Mobile No." maxlength="10">
                                                </div>
                                            </div>

                                            <div class="form-group {{ $errors->has('billing_email') ? 'has-error' : '' }}">
                                                <label for="billing_email" class="control-label col-sm-4">
                                                    <div class="text-left blue-text">Email ID of the Entering Person
                                                        <span class="red-text">*</span>
                                                    </div>
                                                </label>
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
    </section>

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