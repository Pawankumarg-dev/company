@extends('layouts.app')
<style>
    .upper-text {
        text-transform:uppercase;
    }
</style>

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Add New Course Coordinator
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li class="active">Course Coordinator(s)</li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-warning">
                                            <div class="panel-body">
                                                <form class="form-horizontal" action="{{ url('/institute/coursecoordinators/adddetails') }}" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                                                    {{csrf_field()}}

                                                    <input type="hidden" name="institute_id" id="institute-id" value="{{ $institute->id }}" />
                                                    <input type="hidden" id="is-mobile-number-verified" value="No">
                                                    <input type="hidden" id="mobile-number-verification-code" value="">
                                                    <input type="hidden" id="is-email-address-verified" value="No">
                                                    <input type="hidden" id="email-address-verification-code" value="">

                                                    <div class="form-group">
                                                        <div class="text-left blue-text col-sm-4">
                                                            <label for="title-id" class="control-label">
                                                                Title
                                                                <span class="red-text">*</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-2">
                                                            <select class="form-control blue-text" name="title" id="title-id">
                                                                <option value="0" selected>--- Select ---</option>
                                                                @foreach($titles as $title)
                                                                    <option value="{{ $title->id }}">{{ $title->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="text-left blue-text col-sm-4">
                                                            <label for="name" class="control-label">
                                                                Course Coordinator Name
                                                                <span class="red-text">*</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <input type="text" name="name" id="name" class="form-control blue-text upper-text" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="text-left blue-text col-sm-4">
                                                            <label for="dob" class="control-label">
                                                                Date of Birth
                                                                <span class="red-text">*</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-8">
                                                            <div class="row">
                                                                <div class="col-sm-3">
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

                                                    <div class="form-group">
                                                        <div class="text-left blue-text col-sm-4">
                                                            <label for="gender" class="control-label">
                                                                Gender
                                                                <span class="red-text">*</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <label class="radio-inline">
                                                                <input type="radio" name="gender" id="gender-id1" value="1"><span id="gender-label1" class="blue-text">Male</span>
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="gender" id="gender-id2" value="2"><span id="gender-label2" class="blue-text">Female</span>
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="gender" id="gender-id3" value="3"><span id="gender-label3" class="blue-text">Third Gender</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="text-left blue-text col-sm-4">
                                                            <label for="disability-status" class="control-label">
                                                                Person with Benchmark Disability?
                                                                <span class="red-text">*</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <label class="radio-inline">
                                                                <input type="radio" name="disability_status" id="disability-status1" value="Yes"><span id="disability-label1" class="blue-text">Yes</span>
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="disability_status" id="disability-status2" value="No"><span id="disability-label2" class="blue-text">No</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="text-left blue-text col-sm-4">
                                                            <label for="mobile-number" class="control-label">
                                                                Mobile No.
                                                                <span class="red-text">*</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-8">
                                                            <div class="row">
                                                                <div class="col-sm-5">
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

                                                    <div class="form-group">
                                                        <div class="text-left blue-text col-sm-4">
                                                            <label for="whatsapp-number" class="control-label">
                                                                WhatsApp No.
                                                                <span class="red-text">*</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-8">
                                                            <div class="row">
                                                                <div class="col-sm-5">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">+91</span>
                                                                        <input type="text" name="whatsapp_number" id="whatsapp-number" class="form-control blue-text" maxlength="10" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="text-left blue-text col-sm-4">
                                                            <label for="email-address" class="control-label">
                                                                Email Address
                                                                <span class="red-text">*</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-8">
                                                            <div class="row">
                                                                <div class="col-sm-5">
                                                                    <input type="text" name="email_address" id="email-address" class="form-control blue-text" />
                                                                </div>

                                                                <div id="email-address-verify-button-div" class="col-sm-5">
                                                                    <button id="email-address-verify-button" type="button" class="btn btn-sm btn-warning" onclick="displayEmailAddressVerificationModal()">
                                                                        <span class="glyphicon glyphicon-circle-arrow-right"></span>
                                                                        Verify Email Address
                                                                    </button>
                                                                </div>

                                                                <div id="email-address-show-verified-div" class="col-sm-5 content-hide text-success">
                                                                    <strong>&check;&nbsp; Email Address Verified</strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="text-left blue-text col-sm-4">
                                                            <label for="registration-number" class="control-label">
                                                                CRR No.
                                                                <span class="red-text">*</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-2">
                                                            <input type="text" name="registration_number" id="registration-number" class="form-control blue-text" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="text-left blue-text col-sm-4">
                                                            <label for="rci-qualifications" class="control-label">
                                                                RCI Educational Qualifications
                                                                <span class="red-text">*</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-7">
                                                            <input type="text" name="rci_qualifications" id="rci-qualifications" class="form-control blue-text" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="left-text blue-text col-sm-4">
                                                            <label for="other-qualifications" class="control-label">
                                                                Other Educational Qualifications
                                                                <span class="red-text small">(optional)</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-7">
                                                            <input type="text" name="other_qualifications" id="other-qualifications" class="form-control blue-text" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="text-left blue-text col-sm-4">
                                                            <label for="courses-handling" class="control-label">
                                                                Course(s) Handling
                                                                <span class="red-text">*</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-8">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    @php $count = 0; @endphp
                                                                    @foreach($courses_handling as $course)
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" name="coursesHandlingCheckbox[]" id="courses-handling-checkbox-{{ $count }}" value="{{ $course }}"><span id="courses-handling-label-{{ $count }}" class="blue-text">{{ $course }}</span>
                                                                                <input type="hidden" name="coursesHandlingAppliedStatus[]" id="courses-handling-applied-status-{{$count}}" value="0">
                                                                                <input type="hidden" name="courses_handling[]" value="{{ $course }}">
                                                                                @php $count++; @endphp
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="text-left blue-text col-sm-4">
                                                            <label for="teaching-experience" class="control-label">
                                                                Teaching Experience
                                                                <span class="red-text">*</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <input type="text" name="teaching_experience" id="teaching-experience" class="form-control blue-text upper-text" />
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    Years
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="text-left blue-text col-sm-4">
                                                            <label for="address" class="control-label">
                                                                Address (without State/District/Pincode)
                                                                <span class="red-text">*</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-7">
                                                            <input type="text" name="address" id="address" class="form-control blue-text" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="text-left blue-text col-sm-4">
                                                            <label for="address" class="control-label">
                                                                State
                                                                <span class="red-text">*</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <select class="form-control blue-text medium-text" name="state_id" id="state-id">
                                                                <option value="0" selected>Select</option>
                                                                @foreach($states as $state)
                                                                    <option value="{{ $state->id }}">{{ strtoupper($state->state_name) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="text-left blue-text col-sm-4">
                                                            <label for="address" class="control-label">
                                                                District
                                                                <span class="red-text">*</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <select class="form-control blue-text medium-text" name="city_id" id="city-id">
                                                                <option value="0" selected>Select</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="text-left blue-text col-sm-4">
                                                            <label for="pincode" class="control-label">
                                                                Pincode
                                                                <span class="red-text">*</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-8">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <input type="text" name="pincode" id="pincode" class="form-control blue-text upper-text medium-text" maxlength="6" />
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label class="control-label red-text medium-text">(6 digits)</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-5 col-sm-offset-4">
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                <span class="glyphicon glyphicon-ok"></span>&nbsp;
                                                                Save Details
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

    <!-- Email Address Verification Modal -->
    <div class="modal fade" id="email-address-verification-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Email Address Verification</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label left-text blue-text" for="verify-email-address">Mobile No. :</label>
                                <input type="text" class="form-control blue-text" id="verify-email-address" name="verify-email-address" maxlength="10" readonly />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button type="button" id="send-email-address-verification-code-button" class="btn btn-success" onclick="sendEmailAddressVerificationCode()"><span class="glyphicon glyphicon-phone"></span>&nbsp; Send Verification Code</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="email-address-loader-div" class="col-sm-12 content-hide">
                            <div class="form-group">
                                <div id="email-address-loader" class="loader"></div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div id="display-email-address-verification-code-entry-field-div" class="content-hide">
                                <div class="form-group">
                                    <p class="form-control-static alert alert-success">Please enter 4-digit Verification Code sent to your Mobile No</p>
                                </div>
                                <div class="form-group">
                                    <label class="control-label left-text blue-text" for="email-address-verification-code-2">Verification Code :</label>
                                    <input type="text" class="form-control blue-text" id="email-address-verification-code-2" name="email-address-verification-code-2" maxlength="4" placeholder="4-digit Verification Code" />
                                </div>
                                <button type="button" class="btn btn-success" onclick="verifyEmailAddressVerificationCode()"><span class="glyphicon glyphicon-phone"></span>&nbsp; Verify Code</button>
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
        $(document).ready(function(){
            $('input[name="coursesHandlingCheckbox[]"]').change(function(){
                checkCoursesHandlingCheckboxSelected();
            });

            //stop typing anything other than numbers for mobile number
            $('#mobile-number').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

            //stop typing anything other than numbers for whatsapp number
            $('#whatsapp-number').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

            //stop typing anything other than numbers for teaching experience
            $('#teaching-experience').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

            //to get CityId by selecting States
            $('#state-id').on('change',function(){
                if($(this).val() != '0'){
                    $.ajax({
                        async: false,
                        type:"GET",
                        url:"{{url('/institute/coursecoordinators/ajaxrequest/getcityid')}}?state_id="+$(this).val(),
                        success:function(data){
                            if(data){
                                $("#city-id").empty();
                                $("#city-id").attr('disabled', false);
                                $("#city-id").append('<option value="0">-- Select District --</option>');

                                $.each(data, function () {
                                    $("#city-id").append('<option value="'+this.id+'">'+this.name+'</option>');
                                })

                            }
                            else{
                                $("#city-id").empty();
                            }
                        }
                    });
                }
                else{
                    $("#city-id").attr('disabled', true);
                    $("#city-id").empty();
                }
            });

            //stop typing anything other than numbers for pincode
            $('#pincode').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });
        });

        function validateForm() {
            if($('#title-id').val() == 0) {
                swal("Error Occurred!!!", "Please select the Title", "error");
                return false;
            }

            if($('#name').val() == "") {
                swal("Error Occurred!!!", "Please enter the Name", "error");
                return false;
            }

            if($('#dob').val() == "") {
                swal("Error Occurred!!!", "Please enter the Date of Birth", "error");
                return false;
            }

            if(!$('input[name="disability_status"]').is(':checked')) {
                swal("Error Occurred!!!", "Please select the Disability Status", "error");
                return false;
            }
            
            if(!$('input[name="gender"]').is(':checked')) {
                swal("Error Occurred!!!", "Please select the Gender", "error");
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

            if($('#whatsapp-number').val() == "") {
                swal("Error Occurred!!!", "Please enter the WhatsApp No.", "error");
                return false;
            }

            if($('#email-address').val() == "") {
                swal("Error Occurred!!!", "Please enter the Email Address", "error");
                return false;
            }

            if($('#is-email-address-verified').val() != "Yes") {
                swal("Error Occurred!!!", "Please verify the Email Address", "error");
                return false;
            }

            if($('#registration-number').val() == "") {
                swal("Error Occurred!!!", "Please enter the CRR No.", "error");
                return false;
            }

            if($('#rci-qualifications').val() == "") {
                swal("Error Occurred!!!", "Please enter the RCI Qualifications", "error");
                return false;
            }

            if($('#other-qualifications').val() == "") {
                $('#other-qualifications').val(null);
            }

            if($('input[name="coursesHandlingCheckbox[]"]:checkbox:checked').length == 0) {
                swal("Error Occurred!!!", "Please select the Course(s) Handling", "error");
                return false;
            }

            if($('#teaching-experience').val() == "") {
                swal("Error Occurred!!!", "Please enter the Teaching Experience", "error");
                return false;
            }

            if($('#address').val() == "") {
                swal("Error Occurred!!!", "Please enter the Address", "error");
                return false;
            }

            if($('#state-id').val() == "") {
                swal("Error Occurred!!!", "Please select the State", "error");
                return false;
            }

            if($('#city-id').val() == "") {
                swal("Error Occurred!!!", "Please select the City", "error");
                return false;
            }


            if(!$('#pincode').val() || $('#pincode').val().length != '6') {
                swal("Error Occurred!!!", "Please enter the 6 digits valid Pin code", "error");
                return false;
            }
        }

        function checkCoursesHandlingCheckboxSelected() {
            var selectedCount = 0;
            var count = 0;

            $('input[name="coursesHandlingCheckbox[]"]').each(function() {

                if($(this).is(':checked') == true) {
                    selectedCount++;

                    $('#courses-handling-checkbox-'+count).val('1');
                    $('#courses-handling-applied-status-'+count).val('1');
                }
                else {
                    $('#courses-handling-checkbox-'+count).val('0');
                    $('#courses-handling-applied-status-'+count).val('0');
                }

                count++;
            });
        }

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
                url: "{{ url('/institute/coursecoordinators/ajaxrequest/sendmobilenumberverificationcode') }}",
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

        function displayEmailAddressVerificationModal() {
            if($.trim($('#email-address').val()) === "") {
                swal("Error Occurred!!!", "Please enter Mobile No.", "error");
            }
            else {
                var mailformat = "^[a-zA-Z0-9]+(\.[_a-zA-Z0-9]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,15})$";

                if (!$.trim($('#email-address').val()).match(mailformat)) {
                    swal("Error Occurred!!!", "Please enter a valid email address", "error");
                }
                else {
                    $('#email-address-verification-modal').modal({backdrop: 'static', keyboard: false});
                    $('#verify-email-address').val($.trim($('#email-address').val()));
                }
            }
        }

        function sendEmailAddressVerificationCode() {
            var emailAddressVerificationCode = Math.floor(1000 + Math.random() * 9000);
            $('#email-address-verification-code').val(emailAddressVerificationCode);

            $.ajax({
                url: "{{ url('/institute/coursecoordinators/ajaxrequest/sendemailaddressverificationcode') }}",
                type: "POST",
                dataType: "JSON",
                data : {_token: "{{ csrf_token() }}", emailAddress: $.trim($('#email-address').val()), verificationCode : emailAddressVerificationCode},
                beforeSend:function() {
                    $('#send-email-address-verification-code-button').html('<span class="glyphicon glyphicon-phone"></span>&nbsp; Re-Send Verification Code');
                    if($('#display-email-address-verification-code-entry-field-div').hasClass('content-show')) {
                        $('#display-email-address-verification-code-entry-field-div').removeClass('content-show').addClass('content-hide');
                    }

                    if($('#email-address-loader-div').hasClass('content-hide')) {
                        $('#email-address-loader-div').removeClass('content-hide').addClass('content-show');
                    }
                },
                success:function(data) {
                    if(data) {
                        $('#email-address-loader-div').removeClass('content-show').addClass('content-hide');

                        if($('#display-email-address-verification-code-entry-field-div').hasClass('content-hide')) {
                            $('#display-email-address-verification-code-entry-field-div').removeClass('content-hide').addClass('content-show');
                        }
                        swal("Congratulations!!!", "4-digit Verification code has been sent to your Email Address.", "success");
                    }

                    if($('#display-email-address-verification-code-entry-field-div').hasClass('content-hide')) {
                        $('#display-email-address-verification-code-entry-field-div').removeClass('content-hide').addClass('content-show');
                    }
                    swal("Congratulations!!!", "4-digit Verification code has been sent to your Email Address.", "success");
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                },
                complete:function() {

                }
            });
        }

        function verifyEmailAddressVerificationCode() {
            if($('#email-address-verification-code').val() == $.trim($('#email-address-verification-code-2').val())) {
                swal("Congratulations!!!", "Email Address verified successfully", "success");

                $('#email-address').prop('readonly', true);
                $('#is-email-address-verified').val('Yes');

                $('#email-address-verify-button-div').removeClass('content-show').addClass('content-hide');
                $('#email-address-show-verified-div').removeClass('content-hide').addClass('content-show');

                $('#email-address-verification-modal').modal("hide");
            }
            else {
                swal("Error Occurred!!!", "Entered Verification code does not match. Please re-enter verification code or Click Re-Send Verification Code", "error");
            }
        }

    </script>

@endsection
