<script>
    $(document).ready(function(){
    //stop typing anything other than numbers for mobile number1
    $('#mobile-number').keypress(function (e) {
        //if the letter is not digit, then stop type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
    
    $('#mobile-number-verification-code-2').keypress(function (e) {
        //if the letter is not digit, then stop type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    $('#email-address-verification-code-2').keypress(function (e) {
        //if the letter is not digit, then stop type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
});

function displayMobileNoVerificationModal() {
    if($('#mobile-number').val() === "") {
        swal("Error Occurred!!!", "Please enter Mobile No.", "error");
    }
    else if($('#mobile-number').val().length != "10" || $('#mobile-number').val() < "600000000") {
        swal("Error Occurred!!!", "Please enter valid 10-digit Mobile No.", "error");
        $('#mobile-number').val('');
    }
    else {
        $.ajax({
            url: "{{ url('/institute/examinations/ajaxrequest/checkmobilenumberexist') }}",
            type: "POST",
            dataType: "JSON",
            data: {_token: "{{ csrf_token() }}", mobileNumber: $.trim($('#mobile-number').val()), candidateId: $('#candidate-id').val()},
            success:function(data) {
                if(data == "Not Exist" || data == "Self-Exist") {
                    $('#mobile-number-verification-modal').modal({backdrop: 'static', keyboard: false});
                    $('#verify-mobile-number').val($('#mobile-number').val());
                }
                else {
                    swal("Error Occurred!!!", "Mobile No. already exist", "error");
                }
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
                //console.log(xhr.responseText);
            }
        })
    }
}



function sendMobileNumberVerificationCode() {
    var mobileNoVerificationCode = Math.floor(1000 + Math.random() * 9000);
    $('#mobile-number-verification-code').val(mobileNoVerificationCode);
    alert(mobileNoVerificationCode);

    $.ajax({
        url: "{{ url('/institute/examinations/ajaxrequest/sendmobilenumberverificationcode') }}",
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
        if($('#verifying').val()!='enrolment'){
            swal("Congratulations!!!", "Mobile Number verified successfully", "success");
        }

        $('#mobile-number').prop('readonly', true);
        $('#is-mobile-number-verified').val('Yes');

        $('#mobile-number-verify-button-div').removeClass('content-show').addClass('content-hide');
        $('#mobile-number-show-verified-div').removeClass('content-hide').addClass('content-show');

        $('#mobile-number-verification-modal').modal("hide");
        if($('#verifying').val()=='enrolment'){
            $.ajax({
                url: "{{ url('/institute/enrolment/ajaxrequest/updateverificationstatus') }}",
                type: "POST",
                dataType: "JSON",
                data: {_token: "{{ csrf_token() }}", candidateId: $('#candidate-id').val()}, update:'email',
                success:function(data) {
                    if(data=='Updated'){
                        console.log($('#candidate-id').val());
                        swal("Congratulations!!!", "Mobile Number verified successfully", "success");
                        location.reload();
                    }else{
                        swal("Not Updated!!!", "Please try again later", "error");

                    }

                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                    console.log(xhr.responseText);
                }
            });
        }
    }
    else {
        swal("Error Occurred!!!", "Entered Verification code does not match. Please re-enter verification code or Click Re-Send Verification Code", "error");
    }
}

function displayEmailAddressVerificationModal() {
    if($('#email-address').val() === "") {
        swal("Error Occurred!!!", "Please enter Email Address", "error");
    }
    else {
        var mailformat = "^[a-zA-Z0-9]+(\.[_a-zA-Z0-9]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,15})$";

        if (!$('#email-address').val().match(mailformat)) {
            swal("Error Occurred!!!", "Please enter a valid email address", "error");
        }
        else {
            $.ajax({
                url: "{{ url('/institute/examinations/ajaxrequest/checkemailaddressexist') }}",
                type: "POST",
                dataType: "JSON",
                data: {_token: "{{ csrf_token() }}", emailAddress: $.trim($('#email-address').val()), candidateId: $('#candidate-id').val()},
                success:function(data) {
                    if(data == "Not Exist" || data == "Self-Exist") {
                        $('#email-address-verification-modal').modal({backdrop: 'static', keyboard: false});
                        $('#verify-email-address').val($('#email-address').val());
                    }
                    else {
                        swal("Error Occurred!!!", "Email Address already exist", "error");
                    }
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            })
        }
    }
}

function sendEmailAddressVerificationCode() {
    var emailAddressVerificationCode = Math.floor(1000 + Math.random() * 9000);
    $('#email-address-verification-code').val(emailAddressVerificationCode);
    alert(emailAddressVerificationCode);

    $.ajax({
        url: "{{ url('/institute/examinations/ajaxrequest/sendemailaddressverificationcode') }}",
        type: "POST",
        dataType: "JSON",
        data : {_token: "{{ csrf_token() }}", emailAddress: $.trim($('#email-address').val()), verificationCode : emailAddressVerificationCode, examId: $('#exam-id').val()},
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
        },
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        },
        complete:function() {

        }
    });
}

function verifyEmailAddressVerificationCode() {
    if($('#email-address-verification-code').val() == $('#email-address-verification-code-2').val()) {
        if($('#verifying').val()!='enrolment'){
            swal("Congratulations!!!", "Email Address verified successfully", "success");
        }

        $('#email-address').prop('readonly', true);
        $('#is-email-address-verified').val('Yes');

        $('#email-address-verify-button-div').removeClass('content-show').addClass('content-hide');
        $('#email-address-show-verified-div').removeClass('content-hide').addClass('content-show');

        $('#email-address-verification-modal').modal("hide");
        if($('#verifying').val()=='enrolment'){
            $.ajax({
                url: "{{ url('/institute/enrolment/ajaxrequest/updateverificationstatus') }}",
                type: "POST",
                dataType: "JSON",
                data: {_token: "{{ csrf_token() }}", candidateId: $('#candidate-id').val()}, update:'email',
                success:function(data) {
                    if(data=='Updated'){
                        console.log($('#candidate-id').val());
                        swal("Congratulations!!!", "Email Address verified successfully", "success");
                        location.reload();
                    }else{
                        swal("Not Updated!!!", "Please try again later", "error");
                    }

                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                    console.log(xhr.responseText);
                }
            });
        }
    }
    else {
        swal("Error Occurred!!!", "Entered Verification code does not match. Please re-enter verification code or Click Re-Send Verification Code", "error");
    }
}
</script>