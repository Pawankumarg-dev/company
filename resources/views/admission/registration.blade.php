@extends('layouts.app')

@section('content')
    <style>
        body {
            background: #f4f6f9;
        }

        .register-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
            border: none;
            overflow: hidden;
        }

        .register-header {

            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .register-header h2 {
            margin: 0;
            font-weight: 600;
        }

        .register-header p {
            margin-top: 8px;
            opacity: .9;
        }

        .register-body {
            padding: 35px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: 600;
            color: #555;
        }

        .form-control {
            height: 46px;
            border-radius: 6px;
            border: 1px solid #ddd;
            box-shadow: none;
            transition: .3s;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, .15);
        }

        .btn-register {
            height: 46px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 6px;
        }

        .required {
            color: red;
        }

        .field-error {
            color: #d9534f;
            font-size: 13px;
            margin-top: 6px;
            display: block;
        }

        .info-text {
            color: #777;
            font-size: 13px;
            margin-bottom: 25px;
        }

        /* ---- Confirmation Modal styling ---- */
        #confirmDetailsModal .modal-content {
            border-radius: 8px;
            overflow: hidden;
            border: none;
        }

        #confirmDetailsModal .modal-header {
            border-bottom: none;
            padding: 18px 20px;
        }

        #confirmDetailsModal .modal-header-primary {
            background-color: #337ab7 !important;
            color: #fff;
        }

        #confirmDetailsModal .modal-header-primary .modal-title {
            font-weight: 600;
            color: #fff;
        }

        #confirmDetailsModal .modal-header-primary .close {
            color: #fff;
            opacity: .8;
            text-shadow: none;
        }

        #confirmDetailsModal .table td {
            vertical-align: middle;
            font-size: 14px;
        }

        #confirmDetailsModal .table td:first-child {
            background: #f9fafb;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="register-card">

                    <div class="register-header bg-primary">
                        <h2>
                            <i class="glyphicon glyphicon-user"></i>
                            Student Registration
                        </h2>

                        <p>Please ensure that all information matches the details on your Aadhaar card.</p>
                    </div>

                    <div class="register-body">

                        <form method="POST" action="{{ url('/registration-save') }}" id="registerForm">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>
                                        Full name 
                                            <span class="required">*</span>
                                        </label>
                                        <small class="info-text">As per your Aadhaar card</small>
                                        <input type="text" name="first_name" class="form-control"
                                            placeholder="Enter Full Name" value="{{ old('first_name') }}">
                                        <span class="field-error" id="error-first_name"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>
                                    Aadhaar Number
                                    <span class="required">*</span>
                                </label>
                                <input type="text" name="aadhar_number" maxlength="12" class="form-control"
                                    placeholder="Enter 12 Digit Aadhaar Number" value="{{ old('aadhar_number') }}">
                                <span class="field-error" id="error-aadhar_number"></span>
                            </div>

                            <div class="form-group">
                                <label>
                                    Email Address
                                    <span class="required">*</span>
                                </label>

                                <input type="email" name="email" class="form-control" placeholder="Enter Email Address"
                                    value="{{ old('email') }}">
                                <span class="field-error" id="error-email">  {{ $errors->first('email') }}</span>
                            </div>

                            <div class="form-group">
                                <label>
                                    Mobile Number
                                    <span class="required">*</span>
                                </label>
                                <input type="text" name="mobile" maxlength="10" class="form-control" placeholder="Enter Mobile Number"
                                    value="{{ old('mobile') }}">
                                <span class="field-error" id="error-mobile">  {{ $errors->first('mobile') }}</span>
                            </div>
                            <div class="form-group">
                                <label>
                                    State
                                    <span class="required">*</span>
                                </label>
                                <select name="state_id" class="form-control select2">
                                    <option value="">Select State</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}"
                                            {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                            {{ $state->state_name }}
                                        </option>
                                    @endforeach

                                </select>
                                <span class="field-error" id="error-state_id"></span>
                            </div>



                            <button type="button" id="btnRegisterNow" class="btn btn-primary btn-block btn-register">
                                <i class="glyphicon glyphicon-ok-circle"></i>
                                Register Now
                            </button>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmDetailsModal" tabindex="-1" role="dialog" aria-labelledby="confirmDetailsLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="confirmDetailsLabel">
                        <i class="glyphicon glyphicon-check"></i>
                        Confirm Your Details
                    </h4>
                </div>
                <div class="modal-body " style="padding:25px;">
                    <div class="alert alert-warning" style="font-size:13px;">
                        <i class="glyphicon glyphicon-info-sign"></i>
                        Please verify that the below details exactly match your <strong>Aadhaar card</strong> before proceeding. Incorrect details may lead to rejection of your application.
                    </div>

                    <table class="table table-bordered" style="margin-bottom:15px;">
                        <tbody>
                            <tr>
                                <td style="width:40%; font-weight:600; color:#555;">Full Name</td>
                                <td id="confirm_first_name">-</td>
                            </tr>
                            <tr>
                                <td style="font-weight:600; color:#555;">Aadhaar Number</td>
                                <td id="confirm_aadhar_number">-</td>
                            </tr>
                            <tr>
                                <td style="font-weight:600; color:#555;">Email Address</td>
                                <td id="confirm_email">-</td>
                            </tr>
                            <tr>
                                <td style="font-weight:600; color:#555;">Mobile Number</td>
                                <td id="confirm_mobile">-</td>
                            </tr>
                            <tr>
                                <td style="font-weight:600; color:#555;">State</td>
                                <td id="confirm_state">-</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="checkbox" style="margin-top:0;">
                        <label style="font-weight:normal; font-size:13px; color:#555;">
                            <input type="checkbox" id="confirmCheckbox">
                            I confirm that the above details are correct and match my Aadhaar card.
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="glyphicon glyphicon-remove"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="btnConfirmSubmit" disabled>
                        <i class="glyphicon glyphicon-ok"></i> Confirm &amp; Register
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function clearFieldError(fieldName) {
            $('#error-' + fieldName).text('');
        }

        function setFieldError(fieldName, message) {
            $('#error-' + fieldName).text(message);
        }

        function validateAadhaar(value) {
            var digits = value.replace(/\D+/g, '');
            if (!/^[0-9]{12}$/.test(digits)) {
                return false;
            }
            var d = [
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                [1, 2, 3, 4, 0, 6, 7, 8, 9, 5],
                [2, 3, 4, 0, 1, 7, 8, 9, 5, 6],
                [3, 4, 0, 1, 2, 8, 9, 5, 6, 7],
                [4, 0, 1, 2, 3, 9, 5, 6, 7, 8],
                [5, 9, 8, 7, 6, 0, 4, 3, 2, 1],
                [6, 5, 9, 8, 7, 1, 0, 4, 3, 2],
                [7, 6, 5, 9, 8, 2, 1, 0, 4, 3],
                [8, 7, 6, 5, 9, 3, 2, 1, 0, 4],
                [9, 8, 7, 6, 5, 4, 3, 2, 1, 0]
            ];
            var p = [
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                [1, 5, 7, 6, 2, 8, 3, 0, 9, 4],
                [5, 8, 0, 3, 7, 9, 6, 1, 4, 2],
                [8, 9, 1, 6, 0, 4, 3, 5, 2, 7],
                [9, 4, 5, 3, 1, 2, 6, 8, 7, 0],
                [4, 2, 8, 6, 5, 7, 3, 9, 0, 1],
                [2, 7, 9, 3, 8, 0, 6, 4, 1, 5],
                [7, 0, 4, 6, 9, 1, 3, 2, 5, 8]
            ];
            var c = 0;
            digits.split('').reverse().join('').replace(/[\d]/g, function(u, i) {
                c = d[c][p[i % 8][parseInt(u, 10)]];
            });
            return c === 0;
        }

        function validateRegistrationForm() {
            var valid = true;
            var firstName = $.trim($('[name="first_name"]').val());
            var aadhar = $.trim($('[name="aadhar_number"]').val());
            var email = $.trim($('[name="email"]').val());
            var mobile = $.trim($('[name="mobile"]').val());
            var stateId = $('[name="state_id"]').val();
            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            var mobilePattern = /^[6-9]\d{9}$/;

            $('.field-error').text('');

            if (!firstName) {
                setFieldError('first_name', 'First name is required.');
                valid = false;
            }

            if (!aadhar) {
                setFieldError('aadhar_number', 'Aadhaar number is required.');
                valid = false;
            } else if (!validateAadhaar(aadhar)) {
                setFieldError('aadhar_number', 'Please enter a valid Aadhaar number.');
                valid = false;
            }

            if (!email) {
                setFieldError('email', 'Email address is required.');
                valid = false;
            } else if (!emailPattern.test(email)) {
                setFieldError('email', 'Please enter a valid email address.');
                valid = false;
            }

            if (!mobile) {
                setFieldError('mobile', 'Mobile number is required.');
                valid = false;
            } else if (!mobilePattern.test(mobile)) {
                setFieldError('mobile', 'Mobile number must be 10 digits .');
                valid = false;
            }

            if (!stateId) {
                setFieldError('state_id', 'Please select a state.');
                valid = false;
            }

            return valid;
        }

        $(document).ready(function() {
            if ($.fn.select2) {
                $('.select2').select2({
                    placeholder: 'Select State',
                    allowClear: true,
                    width: '100%'
                });
            }

            $('[name="first_name"]').on('input', function() {
                clearFieldError('first_name');
            });

            $('[name="aadhar_number"]').on('input', function() {
                clearFieldError('aadhar_number');
            });

            $('[name="email"]').on('input', function() {
                clearFieldError('email');
            });

            $('[name="mobile"]').on('input', function() {
                clearFieldError('mobile');
            });

            $('[name="state_id"]').on('change', function() {
                clearFieldError('state_id');
            });

            // Register Now -> validate -> populate modal -> show modal
            $('#btnRegisterNow').on('click', function() {
                if (!validateRegistrationForm()) {
                    return false;
                }

                $('#confirm_first_name').text($.trim($('[name="first_name"]').val()));
                $('#confirm_aadhar_number').text($.trim($('[name="aadhar_number"]').val()));
                $('#confirm_email').text($.trim($('[name="email"]').val()));
                $('#confirm_mobile').text($.trim($('[name="mobile"]').val()));
                $('#confirm_state').text($('[name="state_id"] option:selected').text());

                // Reset checkbox + confirm button state every time modal opens
                $('#confirmCheckbox').prop('checked', false);
                $('#btnConfirmSubmit').prop('disabled', true);

                $('#confirmDetailsModal').modal('show');
            });

            // Enable Confirm button only when checkbox is ticked
            $('#confirmCheckbox').on('change', function() {
                $('#btnConfirmSubmit').prop('disabled', !this.checked);
            });

            // Final submit
            $('#btnConfirmSubmit').on('click', function() {
                document.getElementById('registerForm').submit();
            });
        });
    </script>
@endsection