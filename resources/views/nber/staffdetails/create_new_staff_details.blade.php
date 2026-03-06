@extends('layouts.app')

@section('content')
<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            NBER Staff Profile
        </div>
    </div>

    <div class="panel-body">
        <form class="form-horizontal" action="{{ url(route('create.staff.profile')) }}" method="POST" onsubmit="return validateForm()" role="form">
            {{ csrf_field() }}
            <input type="hidden" id="is-mobile-number-verified" value="No">
            <input type="hidden" id="mobile-number-verification-code" value="">

            {{-- Title --}}
            <div class="form-group">
                <div class="text-left blue-text col-sm-3">
                    <label for="title-id" class="control-label">
                        Title
                        <span class="red-text">*</span>
                    </label>
                </div>

                <div class="col-sm-3">
                    <select class="form-control blue-text" name="title_id" id="title-id">
                        <option value="0" selected>--- Select ---</option>
                        @foreach($titles as $title)
                            <option value="{{ $title->id }}">{{ $title->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Name --}}
            <div class="form-group">
                <div class="text-left blue-text col-sm-3">
                    <label for="name" class="control-label">
                        Name
                        <span class="red-text">*</span>
                    </label>
                </div>

                <div class="col-sm-6">
                    <input type="text" name="name" id="name" class="form-control blue-text upper-text" />
                </div>
            </div>

            {{-- Designation --}}
            <div class="form-group">
                <div class="text-left blue-text col-sm-3">
                    <label for="designation" class="control-label">
                        Designation
                        <span class="red-text">*</span>
                    </label>
                </div>

                <div class="col-sm-4">
                    <select class="form-control blue-text" name="designation" id="designation">
                        <option value="0">--- Select Option ---</option>
                        <option value="Consultant">ADCE</option>
                        <option value="Consultant">ACE</option>
                        <option value="Consultant">Consultant</option>
                        <option value="Consultant">Software Consultant</option>
                        <option value="Accountant Consultant">Accountant Consultant</option>
                        <option value="Junior Consultant">Junior Consultant</option>
                    </select>
                </div>
            </div>

            {{-- Gender --}}
            <div class="form-group">
                <div class="left-text blue-text col-sm-3">
                    <label for="gender" class="control-label">
                        Gender
                        <span class="red-text">*</span>
                    </label>
                </div>

                <div class="col-sm-6">
                    <label class="radio-inline">
                        <input type="radio" name="gender_id" id="gender-id1" value="1"><span id="gender-label1" class="blue-text">Male</span>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender_id" id="gender-id2" value="2"><span id="gender-label2" class="blue-text">Female</span>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender_id" id="gender-id3" value="3"><span id="gender-label3" class="blue-text">Third Gender</span>
                    </label>
                </div>
            </div>

            {{-- Date of Birth --}}
            <div class="form-group">
                <div class="text-left blue-text col-sm-3">
                    <label for="dob" class="control-label">
                        Date of Birth
                        <span class="red-text">*</span>
                    </label>
                </div>

                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class='input-group date' id='dob-datetimepicker'>
                                <input type='text' name="dob" id="dob" class="form-control blue-text" placeholder="Choose Date"/>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>

                                <script type="text/javascript">
                                    $(function () {
                                        $('#dob-datetimepicker').datetimepicker({
                                            format: 'DD-MM-YYYY',
                                            maxDate: 'now'
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mobile No. --}}
            <div class="form-group">
                <div class="text-left blue-text col-sm-3">
                    <label for="mobile-number" class="control-label">
                        Mobile No.
                        <span class="red-text">*</span>
                    </label>
                </div>

                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">+91</span>
                                <input type="text" name="mobile_number" id="mobile-number" class="form-control blue-text" maxlength="10" />
                            </div>
                        </div>

                        <div id="mobile-number-verify-button-div" class="col-sm-5">
                            <button id="mobile-number-verify-button" type="button" class="btn btn-sm btn-warning" onclick="displayMobileNoVerificationModal()">
                                <span class="glyphicon glyphicon-circle-arrow-right"></span>
                                Verify Mobile No.
                            </button>
                        </div>

                        <div id="mobile-number-show-verified-div" class="col-sm-5 content-hide text-success">
                            <strong>&check;&nbsp; Mobile Number Verified</strong>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Email --}}
            <div class="form-group">
                <div class="text-left blue-text col-sm-3">
                    <label for="email-address" class="control-label">
                        Email Address
                        <span class="red-text">*</span>
                    </label>
                </div>

                <div class="col-sm-6">
                    <input type="text" onpaste="return false;" autocomplete="off" name="email_address" id="email-address" class="form-control blue-text" />
                </div>
            </div>

            {{-- Password --}}
            <div class="form-group">
                <div class="text-left blue-text col-sm-3">
                    <label for="password" class="control-label">
                        Login Password
                        <span class="red-text">*</span>
                    </label>
                </div>

                <div class="col-sm-4">
                    <input type="password" name="password" id="password" onpaste="return false;" class="form-control blue-text" autocomplete="off"/>
                    <span class="red-text">(min 8 characters)</span>
                </div>
            </div>

            {{-- Confirm Password --}}
            <div class="form-group">
                <div class="text-left blue-text col-sm-3">
                    <label for="confirm-password" class="control-label">
                        Confirm Password
                        <span class="red-text">*</span>
                    </label>
                </div>

                <div class="col-sm-4">
                    <input type="text" id="confirm-password" class="form-control blue-text" />
                </div>
            </div>

            {{-- Button --}}
            <div class="form-group">
                <div class="col-sm-5 col-sm-offset-3">
                    <button type="submit" class="btn btn-success btn-sm">
                        <span class="glyphicon glyphicon-refresh"></span>&nbsp;
                        Update
                    </button>
                    <button type="reset" class="btn btn-danger btn-sm">
                        <span class="glyphicon glyphicon-remove"></span>&nbsp;
                        Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Mobile Number Verification Modal -->
<div class="modal fade" id="mobile-number-verification-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Mobile Number Verification</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label left-text blue-text" for="verify-mobile-number">Mobile No. :</label>
                            <input type="text" class="form-control blue-text" id="verify-mobile-number" name="verify-mobile-number" maxlength="10" readonly />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <button type="button" id="send-mobile-number-verification-code-button" class="btn btn-success" onclick="sendMobileNumberVerificationCode()"><span class="glyphicon glyphicon-phone"></span>&nbsp; Send Verification Code</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="mobile-number-loader-div" class="col-sm-12 content-hide">
                        <div class="form-group">
                            <div id="mobile-number-loader" class="loader"></div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div id="display-mobile-number-verification-code-entry-field-div" class="content-hide">
                            <div class="form-group">
                                <p class="form-control-static alert alert-success">Please enter 4-digit Verification Code sent to your Mobile No</p>
                            </div>
                            <div class="form-group">
                                <label class="control-label left-text blue-text" for="mobile-number-verification-code-2">Verification Code :</label>
                                <input type="text" class="form-control blue-text" id="mobile-number-verification-code-2" maxlength="4" placeholder="4-digit Verification Code" />
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

<script>
    $(document).ready(function () {
            $('#mobile-number').keypress(function (e) {
                if(e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            })
        }
    );

    function displayMobileNoVerificationModal() {
        if($.trim($('#mobile-number').val()) === "") {
            swal("Error Occurred!!!", "Please enter Mobile No.", "error");
        }
        else if($.trim($('#mobile-number').val().length) != "10" || $.trim($('#mobile-number').val()) < "600000000") {
            swal("Error Occurred!!!", "Please enter valid 10-digit Mobile No.", "error");
            $('#mobile-number').val('');
        }
        else {
            $('#mobile-number-verification-modal').modal({backdrop: 'static', keyboard: false});
            $('#verify-mobile-number').val($.trim($('#mobile-number').val()));
        }
    }

    function sendMobileNumberVerificationCode() {
        var mobileNoVerificationCode = Math.floor(1000 + Math.random() * 9000);
        $('#mobile-number-verification-code').val(mobileNoVerificationCode);

        $.ajax({
            url: "{{ url('/nber/staff/ajaxrequest/sendmobilenumberverificationcode') }}",
            type: "POST",
            dataType: "JSON",
            data : {_token: "{{ csrf_token() }}", mobileNumber: $.trim($('#mobile-number').val()), verificationCode : mobileNoVerificationCode},
            beforeSend:function() {
                $('#send-mobile-number-verification-code-button').html('<span class="glyphicon glyphicon-phone"></span>&nbsp; Re-Send Verification Code');
                if($('#display-mobile-number-verification-code-entry-field-div').hasClass('content-show')) {
                    $('#display-mobile-number-verification-code-entry-field-div').removeClass('content-show').addClass('content-hide');
                }

                if($('#mobile-number-loader-div').hasClass('content-hide')) {
                    $('#mobile-number-loader-div').removeClass('content-hide').addClass('content-show');
                }
            },
            success:function(data) {
                if(data) {
                    $('#mobile-number-loader-div').removeClass('content-show').addClass('content-hide');

                    if($('#display-mobile-number-verification-code-entry-field-div').hasClass('content-hide')) {
                        $('#display-mobile-number-verification-code-entry-field-div').removeClass('content-hide').addClass('content-show');
                    }
                    swal("Congratulations!!!", "4-digit Verification code has been sent to your Mobile No.", "success");
                }

                if($('#display-mobile-number-verification-code-entry-field-div').hasClass('content-hide')) {
                    $('#display-mobile-number-verification-code-entry-field-div').removeClass('content-hide').addClass('content-show');
                }
                swal("Congratulations!!!", "4-digit Verification code has been sent to your Mobile No.", "success");
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            },
            complete:function() {

            }
        });
    }

    function verifyMobileNumberVerificationCode() {
        if($('#mobile-number-verification-code').val() == $('#mobile-number-verification-code-2').val()) {
            swal("Congratulations!!!", "Mobile Number verified successfully", "success");

            $('#mobile-number').prop('readonly', true);
            $('#is-mobile-number-verified').val('Yes');

            $('#mobile-number-verify-button-div').removeClass('content-show').addClass('content-hide');
            $('#mobile-number-show-verified-div').removeClass('content-hide').addClass('content-show');

            $('#mobile-number-verification-modal').modal("hide");
        }
        else {
            swal("Error Occurred!!!", "Entered Verification code does not match. Please re-enter verification code or Click Re-Send Verification Code", "error");
        }
    }

    function validateForm() {
        if($('#title-id').val() == 0) {
            swal("Error Occurred!!!", "Please select the Title", "error");
            return false;
        }

        if($('#name').val() == "") {
            swal("Error Occurred!!!", "Please enter the Name", "error");
            return false;
        }

        if($('#designation').val() == 0) {
            swal("Error Occurred!!!", "Please enter the Designation", "error");
            return false;
        }

        if(!$('input[name="gender_id"]').is(':checked')) {
            swal("Error Occurred!!!", "Please choose the Gender", "error");
            return false;
        }

        if($('#dob').val() == "") {
            swal("Error Occurred!!!", "Please enter the Date of Birth", "error");
            return false;
        }

        if($('#mobile-number').val() == "") {
            swal("Error Occurred!!!", "Please enter the Mobile No.", "error");
            return false;
        }

        if($('#is-mobile-number-verified').val() != "Yes") {
            swal("Error Occurred!!!", "Please verify the Mobile No.", "error");
            return false;
        }

        if($('#email-address').val() == "") {
            swal("Error Occurred!!!", "Please enter the Email Address", "error");
            return false;
        }
        else {
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if(!regex.test($('#email-address').val())) {
                swal("Error Occurred!!!", "Please enter the valid email", "error");
                return false;
            }
        }

        if($('#password').val() == "") {
            swal("Error Occurred!!!", "Please enter the Login Password", "error");
            return false;
        }
        else {
            if($('#password').val().length < 8) {
                swal("Error Occurred!!!", "Password should have minimum 8 characters", "error");
                return false;
            }
        }

        if($('#confirm-password').val() == "") {
            swal("Error Occurred!!!", "Please enter the Confirm Password", "error");
            return false;
        }
        else {
            if($('#confirm-password').val().length < 8) {
                swal("Error Occurred!!!", "Confirm Password should have minimum 8 characters", "error");
                return false;
            }
        }

        if($('#password').val() != $('#confirm-password').val()) {
            swal("Error Occurred!!!", "Password and Confirm Password does not match. Please re-enter", "error");
            return false;
        }
    }
</script>
@endsection