@extends('layouts.reevaluationapplication')
@section('content')

    <section class="container">
        <form id="reevaluationform" class="form-horizontal"
              action="{{ url('/reevaluationapplication/addapplication/') }}"
              method="post" onsubmit="return validateForm()" enctype="multipart/form-data">

            <input type="hidden" name="exam_id" value="{{ $exam->id }}">
            <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
            <input type="hidden" name="reevaluation_id" value="{{ $reevaluation->id }}">
            <input type="hidden" name="reevaluationapplicationfee_id" value="{{ $reevaluationapplicationfee->id }}">

            {{csrf_field()}}
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
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="panel-title">

                                        {{$title}}
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        Candidate Details
                                                    </div>
                                                </div>

                                                <div class="panel-body">
                                                    <div class="table-responsive col-sm-12">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td class="center-text" width="15%" rowspan="4">
                                                                    <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 100px; height: 100px !important" class="img" />
                                                                </td>
                                                                <td width="11%">Enrolment No</td>
                                                                <td width="74%">{{ $candidate->enrolmentno }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Name</td>
                                                                <td>{{ $candidate->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Course</td>
                                                                <td>{{ $candidate->approvedprogramme->programme->course_name }} - ({{ $candidate->approvedprogramme->academicyear->year }})</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Institute</td>
                                                                <td>{{ $candidate->approvedprogramme->institute->code }} - {{ $candidate->approvedprogramme->institute->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <h4 class="red-text">
                                                                    Verify your Mobile Number and Email Id
                                                                    </h4>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="red-text">Instructions</td>
                                                                <td colspan="2">
                                                                    <ul class="red-text">
                                                                        <li>
                                                                            OTP will be sent to the registered Mobile number and E-mail id of candidates.
                                                                            Candidates are requested to use the active mobile number and valid e-mail id.
                                                                        </li>
                                                                        <li>
                                                                            Reference Number for Re-Evaluation Application will be generated automatically and
                                                                            communicated to the registered mobile number and email id.
                                                                        </li>
                                                                        <li>
                                                                            All updates will be communicated only to the candidate’s registered mobile number
                                                                            and e-mail id.
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Mobile Number</td>
                                                                <td colspan="2">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <input type="text" class="form-control blue-text" id="applicant_mobilenumber" name="applicant_mobilenumber" maxlength="10" placeholder="Mobile No." autocomplete="off" />
                                                                            <span id="errorspan_applicant_mobilenumber" class="red-text help-block"></span>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="row">
                                                                                <div class="col-sm-6">
                                                                                    <div id="div_verifymobilenumberbutton" class="content-show">
                                                                                        <button id="verifymobilenumberbutton" type="button" class="btn btn-warning" onclick="displayMobileNoVerificationModal()">
                                                                                            <span class="glyphicon glyphicon-circle-arrow-right"></span>&nbsp; Click here to Verify Mobile No.
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <div class="form-group">
                                                                                        <span id="div_displaymobilenumberverifiedmessage" class="content-hide text-3">
                                                                                             <button type="button" class="btn btn-success disable-div">&check;&nbsp; Mobile Number Verified</button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <input type="hidden" id="is_mobilenumberverified" value="no">
                                                                            <input type="hidden" id="verificationcode1" value="">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Email Id</td>
                                                                <td colspan="2">
                                                                    <div class="row">
                                                                        <div class="col-sm-5">
                                                                            <input type="text" class="form-control blue-text" id="applicant_email" name="applicant_email" placeholder="Email Id" onblur="validate_email();" />
                                                                            <span id="errorspan_applicant_email" class="red-text help-block"></span>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="row">
                                                                                <div class="col-sm-6">
                                                                                    <div id="div_verifyemailbutton" class="content-show">
                                                                                        <button id="verifyemailbutton" type="button" class="btn btn-warning" onclick="displayEmailVerificationModal()">
                                                                                            <span class="glyphicon glyphicon-circle-arrow-right"></span>&nbsp; Click here to Verify Email Id
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <div class="form-group">
                                                                                        <span id="div_displayemailverifiedmessage" class="content-hide text-3">
                                                                                             <button type="button" class="btn btn-success disable-div">&check;&nbsp; Email ID Verified</button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" id="is_emailverified" value="No">
                                                                        <input type="hidden" id="emailverificationcode1" value="">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="div_applicationdetails" class="col-sm-12">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        Application Details
                                                    </div>
                                                </div>

                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td colspan="7">
                                                                    <p class="center-text red-text bold-text"><u>Instructions</u></p>
                                                                    <ul class="red-text">
                                                                        <li>
                                                                            No request shall be accepted for change of Papers after final submission. Candidates
                                                                            are advised to carefully check all the relevant details before final submission.
                                                                        </li>
                                                                        <li>
                                                                            The results of Re-Evaluation / Re-Totalling will be displayed in the NIEPMD-NBER
                                                                            web portal <a href="{{ url('http://www.niepmdexaminationsnber.com/') }}" target="_blank"> www.niepmdexaminationsnber.com</a>
                                                                        </li>
                                                                        <li>
                                                                            The photocopy of Answer Scripts applied will be sent to the registered email id.
                                                                        </li>
                                                                        <li>
                                                                            The result of Re-Evaluation / Re-Totalling, shall be binding on the candidate. Hence, no
                                                                            calls / representations will be entertained.
                                                                        </li>
                                                                        <li>
                                                                            If any discrepancy found in the photocopy of the Answer Scripts, it need to be
                                                                            communicated to the NIEPMD-NBER, Chennai, immediately.
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="center-text" rowspan="2" width="3%">#</th>
                                                                <th class="center-text" colspan="2">Paper</th>
                                                                <th class="center-text" rowspan="3" width="2%">Marks<br>Obtained</th>
                                                                <th class="center-text" colspan="3" width="15%">Re-Evaluation Options</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="center-text" width="5%">Code</th>
                                                                <th class="center-text"  width="25%">Name</th>
                                                                <th class="center-text">Re-Evaluation</th>
                                                                <th class="center-text">Re-Totalling</th>
                                                                <th class="center-text">Photo-Copying</th>
                                                            </tr>

                                                            <tbody>
                                                            @php $sno = 1; $count = 0; @endphp
                                                            @foreach($marks as $mark)
                                                                <tr>
                                                                    <td class="center-text">
                                                                        <input type="checkbox" name="mark_checkbox[]" id="mark_checkbox{{$count}}" value="{{$count}}" onclick="enabledisablefield({{$count}})">
                                                                        <input type="hidden" name="mark_id[]" id="mark_id{{$count}}" value="{{$mark->id}}">
                                                                    </td>
                                                                    <td>{{ $mark->application->subject->scode }}</td>
                                                                    <td>{{ $mark->application->subject->sname }}</td>
                                                                    <td class="center-text">{{ trim($mark->external + $mark->grace) }}</td>
                                                                    <td class="center-text">
                                                                        <input type="checkbox" name="reevaluation_checkbox[]" id="reevaluation_checkbox{{$count}}" value="0" onclick="updateremarks({{$count}})">
                                                                        <input type="hidden" name="reevaluation_applystatus[]" id="reevaluation_applystatus{{$count}}" value="0">
                                                                    </td>
                                                                    <td class="center-text">
                                                                        <input type="checkbox" name="retotalling_checkbox[]" id="retotalling_checkbox{{$count}}" value="0" onclick="updateremarks({{$count}})">
                                                                        <input type="hidden" name="retotalling_applystatus[]" id="retotalling_applystatus{{$count}}" value="0">
                                                                    </td>
                                                                    <td class="center-text">
                                                                        <input type="checkbox" name="photocopying_checkbox[]" id="photocopying_checkbox{{$count}}" value="0" onclick="updateremarks({{$count}})">
                                                                        <input type="hidden" name="photocopying_applystatus[]" id="photocopying_applystatus{{$count}}" value="0">
                                                                    </td>
                                                                </tr>
                                                                @php $sno++; $count++; @endphp
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                                    @if($pt->id != '1')
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

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        Declaration
                                                    </div>
                                                </div>

                                                <div class="panel-body">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" id="checkbox1">
                                                            <span class="red-text">
                                                                I hereby declare that
                                                                I have read all the instructions, which is uploaded in the web portal of NIEPMD-NBER regarding Online Application for Re-Evaluation / Re-Totalling / Copy of Answer Scripts.
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="center-block">
                                                <div class="form-group">
                                                    <div class="col-sm-5">
                                                        <button type="submit" class="btn btn-success">
                                                            <span class="glyphicon glyphicon-ok-sign"></span>
                                                            Submit Application
                                                        </button>
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

        </form>
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

        <!-- Mobile Number Verification Modal -->
        <div class="modal fade" id="MobileNumberVerificationModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Mobile Number Verification</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="formgroup_verifymobile" class="form-group">
                                    <label class="control-label left-text blue-text" for="verify_mobilenumber">Mobile No. :</label>
                                    <input type="text" class="form-control blue-text" id="verify_mobilenumber" name="verify_mobilenumber" maxlength="10" readonly />
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="button" id="sendVerifyButton" class="btn btn-success" onclick="sendMobileNumberVerificationCode()"><span class="glyphicon glyphicon-phone"></span>&nbsp; Send Verification Code</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="div_loader" class="col-sm-12">
                                <div class="form-group">
                                    <div id="loader2" class="loader"></div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div id="div_displayverificationcodeentryfield" class="content-hide">
                                    <div class="form-group">
                                        <p class="form-control-static alert alert-success">Please enter 4-digit Verification Code sent to your Mobile No</p>
                                    </div>
                                    <div id="formgroup_verificationcode2" class="form-group">
                                        <label class="control-label left-text blue-text" for="verificationcode2">Verification Code :</label>
                                        <input type="text" class="form-control blue-text" id="verificationcode2" name="verificationcode2" maxlength="4" placeholder="4-digit Verification Code" />
                                    </div>
                                    <button type="button" class="btn btn-success" onclick="verifyMobileNumberVerificationCode()"><span class="glyphicon glyphicon-phone"></span>&nbsp; Verify Code</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./Mobile Number Verification Modal -->

        <!-- Email ID Verification Modal -->
        <div class="modal fade" id="EmailVerificationModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Email Id Verification</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="formgroup_verifyemail" class="form-group">
                                    <label class="control-label left-text blue-text" for="verify_email">Email Id :</label>
                                    <input type="text" class="form-control blue-text" id="verify_email" name="verify_email" readonly />
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="button" id="sendEmailVerifyButton" class="btn btn-success" onclick="sendEmailVerificationCode()"><span class="glyphicon glyphicon-phone"></span>&nbsp; Send Verification Code</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="div_emailloader" class="col-sm-12">
                                <div class="form-group">
                                    <div id="emailloader" class="loader"></div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div id="div_displayemailverificationcodeentryfield" class="content-hide">
                                    <div class="form-group">
                                        <p class="form-control-static alert alert-success">Please enter 4-digit Verification Code sent to your Email Id</p>
                                    </div>
                                    <div id="formgroup_emailverificationcode2" class="form-group">
                                        <label class="control-label left-text blue-text" for="emailverificationcode2">Verification Code :</label>
                                        <input type="text" class="form-control blue-text" id="emailverificationcode2" name="emailverificationcode2" maxlength="6" placeholder="4-digit Verification Code" />
                                    </div>
                                    <button type="button" class="btn btn-success" onclick="verifyEmailVerificationCode()"><span class="glyphicon glyphicon-phone"></span>&nbsp; Verify Code</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./Email ID Verification Modal -->
    </section>

    <script>
        function getcandidatedetails() {
            var enrolmentnumber = $('#enrolmentnumber').val();
            var token = "{{ csrf_token() }}";
            var exam_id = $('#exam_id').val();

            if(enrolmentnumber == '') {
                alert('Please enter the enrolmentno');
            }
            else {
                $.ajax({
                    url: "{{ url('/reevaluationapplication/ajaxrequest/getcandidatedetails') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {_token: token, enrolmentnumber: enrolmentnumber, exam_id: exam_id},
                    beforeSend:function() {
                        $("#loadingStatusPanel").show();
                        $('#loadDataPanel').hide();
                    },
                    success:function(data) {
                        if(data != 0) {
                            $('#candidate_id').val(data.candidate_id);
                            $('#candidatenamedata').html(data.candidate_name);
                            $('#candidateenrolmentnodata').html(data.candidate_enrolmentno);
                            $('#candidatefathernamedata').html(data.candidate_fathername);
                            $('#candidatedobdata').html(data.candidate_dob);
                            $('#candidateemaildata').html(data.candidate_email);
                            $('#candidatecontactnumberdata').val(data.candidate_contactnumber);
                            $('#candidatecoursedata').html(data.candidate_course+" - ("+data.candidate_batch+")");
                            $('#candidateinstitutedata').html(data.candidate_institutecode+" - "+data.candidate_institutename);
                        }
                        else {
                            alert("Please enter the valid Enrolment No.");
                        }
                    },
                    complete:function() {
                        $("#loadingStatusPanel").hide();
                        $("#div_confirmenrolmentno").hide();
                        $('#div_newapplicationform').show();
                    }
                });
            }
        }
    </script>

    <script>
        $(document).ready(function () {

            $('input[name="reevaluation_checkbox[]"]').attr('disabled', true);
            $('input[name="retotalling_checkbox[]"]').attr('disabled', true);
            $('input[name="photocopying_checkbox[]"]').attr('disabled', true);


            $('#div_loader').hide();
            $('#div_emailloader').hide();

            $('#applicant_mobilenumber').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

            $('#verificationcode2').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

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

        function displayMobileNoVerificationModal() {
            if($('#applicant_mobilenumber').val() == "") {
                $('#applicant_mobilenumber').focus();
                $('#formgroup_applicant_mobilenumber').addClass("has-error");
                $('#errorspan_applicant_mobilenumber').text("Please enter your Mobile No.");
                swal("Error Occurred!!!", "Please enter your Mobile No.", "error");
            }
            else {
                if($('#applicant_mobilenumber').val().length == 10) {
                    $('#applicant_mobilenumber').val($.trim($('#applicant_mobilenumber').val()));
                    $('#verify_mobilenumber').val($('#applicant_mobilenumber').val());

                    $('#errorspan_applicant_mobilenumber').text("");
                    $('#MobileNumberVerificationModal').modal({backdrop: 'static', keyboard: false});
                }
                else {
                    $('#errorspan_applicant_mobilenumber').text("Please enter valid 10 digit Mobile No.");
                    swal("Error Occurred!!!", "Please enter valid 10 digit Mobile No.", "error");
                }
            }
            /*
            if($('#is_mobilenumberverified').val() == "Yes") {
                $('#is_mobilenumberverified').val("No");
            }

            $('#verify_mobilenumber').val($('#applicant_mobilenumber').val());
            $('#MobileNumberVerificationModal').modal({backdrop: 'static', keyboard: false});
            */
        }

        function sendMobileNumberVerificationCode() {
            var verificationcode = Math.floor(1000 + Math.random() * 9000);
            $('#verificationcode1').val(verificationcode);
            var token = "{{ csrf_token() }}";

            $.ajax({
                url: "{{ url('/reevaluationapplication/ajaxrequest/sendmobileverificationcode') }}",
                type: "POST",
                dataType: "JSON",
                data : {_token: token, mobilenumber: $('#verify_mobilenumber').val(), verificationcode : verificationcode},
                beforeSend:function() {
                    $('#sendVerifyButton').html('<span class="glyphicon glyphicon-phone"></span>&nbsp; Re-Send Verification Code');
                    if($('#div_displayverificationcodeentryfield').hasClass('content-show')) {
                        $('#div_displayverificationcodeentryfield').removeClass('content-show').addClass('content-hide');
                    }

                    $('#div_loader').show();
                },
                success:function(data) {
                    if(data) {
                        $('#div_loader').hide();

                        if($('#div_displayverificationcodeentryfield').hasClass('content-hide')) {
                            $('#div_displayverificationcodeentryfield').removeClass('content-hide').addClass('content-show');
                        }
                        swal("Congratulations!!!", "4-digit Verification code has been sent to your Mobile No.", "success");
                    }

                    if($('#div_displayverificationcodeentryfield').hasClass('content-hide')) {
                        $('#div_displayverificationcodeentryfield').removeClass('content-hide').addClass('content-show');
                    }
                    swal("Congratulations!!!", "4-digit Verification code has been sent to your Mobile No.", "success");
                    $('#errorspan_applicant_mobilenumber').text("");
                    /*


                    if(data) {

                        $('#div_loader').hide();

                        if(JSONObject[0]["DLR"] === "Delivered") {
                            if($('#div_displayverificationcodeentryfield').hasClass('content-hide')) {
                                $('#div_displayverificationcodeentryfield').removeClass('content-hide').addClass('content-show');
                            }
                            swal("Congratulations!!!", "4-digit Verification code has been sent to your Mobile No.", "success");
                        }
                        else{

                        }
                    }
        */
                    /*
                    alert(data);
                    if(data) {
                        var JSONObject = JSON.parse(data);

                        $('#div_loader').hide();

                        if(JSONObject[0]["DLR"] === "Delivered") {
                            if($('#div_displayverificationcodeentryfield').hasClass('content-hide')) {
                                $('#div_displayverificationcodeentryfield').removeClass('content-hide').addClass('content-show');
                            }
                            swal("Congratulations!!!", "4-digit Verification code has been sent to your Mobile No.", "success");
                        }
                        else{
                            alert(JSONObject[0]["DLR"]);
                        }
                    }
                    */
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                },
                complete:function() {

                }
            });
        }

        function verifyMobileNumberVerificationCode() {
            if($('#verificationcode1').val() == $('#verificationcode2').val()) {
                swal("Congratulations!!!", "Mobile Number verified successfully", "success");

                $("#applicant_mobilenumber").attr("readonly", true);
                $('#is_mobilenumberverified').val("Yes");

                if($('#div_displaymobilenumberverifiedmessage').hasClass("content-hide")) {
                    $('#div_verifymobilenumberbutton').removeClass("content-show").addClass("content-hide");
                    $('#div_displaymobilenumberverifiedmessage').removeClass("content-hide").addClass("content-show");
                }

                $('#MobileNumberVerificationModal').modal("hide");
            }
            else {
                swal("Error Occurred!!!", "Entered Verification code does not match. Please re-enter verification code or Click Re-Send Verification Code", "error");
            }
        }

        function displayEmailVerificationModal() {
            if($('#applicant_email').val() == "") {
                $('#applicant_email').focus();
                $('#formgroup_applicant_email').addClass("has-error");
                $('#errorspan_applicant_email').text("Please enter your Email Id");
                swal("Error Occurred!!!", "Please enter your Email Id", "error");
            }
            else {
                $('#verify_email').val($('#applicant_email').val());
                $('#EmailVerificationModal').modal({backdrop: 'static', keyboard: false});
            }
            /*
            if($('#is_mobilenumberverified').val() == "Yes") {
                $('#is_mobilenumberverified').val("No");
            }

            $('#verify_mobilenumber').val($('#applicant_mobilenumber').val());
            $('#MobileNumberVerificationModal').modal({backdrop: 'static', keyboard: false});
            */
        }

        function sendEmailVerificationCode() {
            var verificationcode = Math.floor(1000 + Math.random() * 9000);
            $('#emailverificationcode1').val(verificationcode);
            var token = "{{ csrf_token() }}";

            $.ajax({
                url: "{{ url('/reevaluationapplication/ajaxrequest/sendemailverificationcode') }}",
                type: "POST",
                dataType: "JSON",
                data : {_token: token, email: $('#verify_email').val(), verificationcode : verificationcode},
                beforeSend:function() {
                    $('#sendEmailVerifyButton').html('<span class="glyphicon glyphicon-phone"></span>&nbsp; Re-Send Verification Code');
                    if($('#div_displayemailverificationcodeentryfield').hasClass('content-show')) {
                        $('#div_displayemailverificationcodeentryfield').removeClass('content-show').addClass('content-hide');
                    }

                    $('#div_emailloader').show();
                },
                success:function(data) {
                    if(data) {
                        $('#div_emailloader').hide();

                        if($('#div_displayemailverificationcodeentryfield').hasClass('content-hide')) {
                            $('#div_displayemailverificationcodeentryfield').removeClass('content-hide').addClass('content-show');
                        }
                        swal("Congratulations!!!", "4-digit Verification code has been sent to your Email ID", "success");
                    }

                    if($('#div_displayemailverificationcodeentryfield').hasClass('content-hide')) {
                        $('#div_displayemailverificationcodeentryfield').removeClass('content-hide').addClass('content-show');
                    }

                    swal("Congratulations!!!", "4-digit Verification code has been sent to your Email ID", "success");
                    $('#errorspan_applicant_email').text("");
                    /*


                    if(data) {

                        $('#div_loader').hide();

                        if(JSONObject[0]["DLR"] === "Delivered") {
                            if($('#div_displayverificationcodeentryfield').hasClass('content-hide')) {
                                $('#div_displayverificationcodeentryfield').removeClass('content-hide').addClass('content-show');
                            }
                            swal("Congratulations!!!", "4-digit Verification code has been sent to your Mobile No.", "success");
                        }
                        else{

                        }
                    }
        */
                    /*
                    alert(data);
                    if(data) {
                        var JSONObject = JSON.parse(data);

                        $('#div_loader').hide();

                        if(JSONObject[0]["DLR"] === "Delivered") {
                            if($('#div_displayverificationcodeentryfield').hasClass('content-hide')) {
                                $('#div_displayverificationcodeentryfield').removeClass('content-hide').addClass('content-show');
                            }
                            swal("Congratulations!!!", "4-digit Verification code has been sent to your Mobile No.", "success");
                        }
                        else{
                            alert(JSONObject[0]["DLR"]);
                        }
                    }
                    */
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                },
                complete:function() {

                }
            });
        }

        function verifyEmailVerificationCode() {
            if($('#emailverificationcode1').val() == $('#emailverificationcode2').val()) {
                swal("Congratulations!!!", "Email ID verified successfully", "success");

                $("#applicant_email").attr("readonly", true);
                $('#is_emailverified').val("Yes");

                if($('#div_displayemailverifiedmessage').hasClass("content-hide")) {
                    $('#div_verifyemailbutton').removeClass("content-show").addClass("content-hide");
                    $('#div_displayemailverifiedmessage').removeClass("content-hide").addClass("content-show");
                }

                $('#EmailVerificationModal').modal("hide");
            }
            else {
                swal("Error Occurred!!!", "Entered Verification code does not match. Please re-enter verification code or Click Re-Send Verification Code", "error");
            }
        }

        function validate_email() {
            var email = $('#applicant_email').val();
            var mailformat = "^[a-zA-Z0-9]+(\.[_a-zA-Z0-9]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,15})$";

            if (email.match(mailformat)) {
                return true;
            }
            else {
                swal("Error Occurred!!!", "Please enter a valid email address", "error");
                return false;
            }
        }

        function enabledisablefield(count) {
            if($('#mark_checkbox'+count).prop("checked") == true) {
                $('#reevaluation_checkbox'+count).attr('disabled', false);
                $('#retotalling_checkbox'+count).attr('disabled', false);
                $('#photocopying_checkbox'+count).attr('disabled', false);
            }
            else {
                $('#reevaluation_checkbox'+count).prop("checked", false);
                $('#reevaluation_checkbox'+count).attr('disabled', true);
                $('#retotalling_checkbox'+count).prop("checked", false);
                $('#retotalling_checkbox'+count).attr('disabled', true);
                $('#photocopying_checkbox'+count).prop("checked", false);
                $('#photocopying_checkbox'+count).attr('disabled', true);
            }
        }

        function updateremarks(count) {
            var remarks = '';

            if($('#reevaluation_checkbox'+count).is(":checked")) {
                $('#reevaluation_applystatus'+count).val('1');
            }
            else {
                $('#reevaluation_applystatus'+count).val('0');
            }
            if($('#retotalling_checkbox'+count).is(":checked")) {
                $('#retotalling_applystatus'+count).val('1');
            }
            else {
                $('#retotalling_applystatus'+count).val('0');
            }
            if($('#photocopying_checkbox'+count).is(":checked")) {
                $('#photocopying_applystatus'+count).val('1');
            }
            else {
                $('#photocopying_applystatus'+count).val('0');
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

        function validateForm() {

            if($('#is_mobilenumberverified').val() == "Yes") {
                $('#applicant_mobilenumber').val($.trim($('#applicant_mobilenumber').val()));
            }
            else {
                $('#modal').modal('show');
                $('#alertmessage').text('Please verify Mobile Number');
                $('#applicant_mobilenumber').focus();
                $('#errorspan_applicant_mobilenumber').text("Please Verify your Mobile No.");

                return false;
            }

            if($('#is_emailverified').val() == "Yes") {
                $('#applicant_email').val($.trim($('#applicant_email').val()));
            }
            else {
                $('#modal').modal('show');
                $('#alertmessage').text('Please verify Email Id');
                $('#applicant_email').focus();
                $('#errorspan_applicant_email').text("Please Verify your Email Id");

                return false;
            }

            var count = 0;

            for(var i=0; i<"{{$count}}"; i++) {
                if($('#mark_checkbox'+i).prop("checked") == true){
                    if($('#reevaluation_checkbox'+i).prop("checked") == true || $('#retotalling_checkbox'+i).prop("checked") == true || $('#photocopying_checkbox'+i).prop("checked") == true) {
                        count++;
                    }
                    else {
                        swal("Error Occurred!!!", "Please select atleast any one RE-Evaluation Options", "error");
                        return false;
                    }
                }
            }

            if(count == 0) {
                swal("Error Occurred!!!", "Please select atleast any one Paper", "error");
                return false;
            }
            for(var i=0; i<"{{$sno}}"; i++) {
                if($('#mark_checkbox'+i).prop("checked") == true) {
                    var el = '<input type="hidden" name="markid_select[]" value="1">';
                    $('#reevaluationform').append(el);
                }
                else {
                    var el = '<input type="hidden" name="markid_select[]" value="0">';
                    $('#reevaluationform').append(el);
                }
            }

            if(!$('#payment_date').val()) {
                $('#modal').modal('show');
                $('#alertmessage').text('Please select the Date of Payment made');
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
                $('#alertmessage').text('Enter the Transaction ID Number / UTR Number.');
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

            if($('#checkbox1').prop("checked") == false) {
                $('#modal').modal('show');
                $('#alertmessage').text('Please complete the Declaration');
                return false;
            }
        }
    </script>
@endsection

