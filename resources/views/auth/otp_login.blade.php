@extends('layouts.app')

@section('content')
<style>
    .otp-login-page {
        font-family: 'Segoe UI', sans-serif;
    }

    .otp-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 30px rgba(15, 40, 80, 0.10);
        overflow: hidden;
        border: 1px solid #e3ebf5;
    }

    .otp-card-header {
        background: linear-gradient(135deg, #1f4e79 0%, #2c6ba3 100%);
        color: #fff;
        padding: 34px 30px 26px;
        text-align: center;
    }

    .otp-icon {
        width: 52px;
        height: 52px;
        margin: 0 auto 14px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .otp-card-header h2 {
        margin: 0 0 6px;
        font-size: 21px;
        font-weight: 700;
        letter-spacing: 0.2px;
    }

    .otp-card-header p {
        margin: 0;
        font-size: 13.5px;
        color: rgba(255, 255, 255, 0.85);
    }

    .otp-card-body {
        padding: 30px 30px 26px;
    }

    /* ---------- Method toggle (segmented control) ---------- */
    .method-toggle {
        position: relative;
        display: flex;
        background: #eef2f9;
        border-radius: 30px;
        padding: 4px;
        margin-bottom: 24px;
    }

    .method-toggle input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .method-toggle label {
        flex: 1;
        text-align: center;
        margin: 0;
        padding: 9px 0;
        font-size: 13.5px;
        font-weight: 600;
        color: #6b7a8f;
        border-radius: 26px;
        cursor: pointer;
        position: relative;
        z-index: 2;
        transition: color 0.25s ease;
    }

    .method-toggle-glider {
        position: absolute;
        top: 4px;
        left: 4px;
        width: calc(50% - 4px);
        height: calc(100% - 8px);
        background: #1f4e79;
        border-radius: 26px;
        transition: transform 0.28s ease;
        z-index: 1;
    }

    #method-email:checked ~ .method-toggle-glider {
        transform: translateX(100%);
    }

    #method-mobile:checked + label,
    #method-email:checked + label {
        color: #fff;
    }

    /* ---------- Form elements ---------- */
    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #33455c;
        margin-bottom: 6px;
    }

    .input-with-icon {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 13.5px;
        font-weight: 600;
        color: #8a96a3;
    }

    .input-with-icon .form-control {
        padding-left: 42px;
    }

    .form-control {
        width: 100%;
        height: 46px;
        border: 1px solid #d3ddea;
        border-radius: 6px;
        padding: 0 14px;
        font-size: 14.5px;
        color: #1c2b3a;
        background: #fbfcfe;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #1f4e79;
        box-shadow: 0 0 0 3px rgba(31, 78, 121, 0.12);
        background: #fff;
    }

    .field-hint {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        color: #a94442;
        min-height: 14px;
    }

    /* ---------- Buttons ---------- */
    .btn-otp-primary {
        width: 100%;
        height: 48px;
        border: none;
        border-radius: 6px;
        background: #1f4e79;
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        letter-spacing: 0.2px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: background 0.2s ease, transform 0.05s ease;
        margin-top: 6px;
    }

    .btn-otp-primary:hover {
        background: #173d61;
    }

    .btn-otp-primary:active {
        transform: translateY(1px);
    }

    .btn-otp-primary:disabled {
        background: #9fb4c8;
        cursor: not-allowed;
    }

    .btn-spinner {
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.4);
        border-top-color: #fff;
        border-radius: 50%;
        display: inline-block;
        animation: otp-spin 0.7s linear infinite;
    }

    @keyframes otp-spin {
        to {
            transform: rotate(360deg);
        }
    }

    .form-alert {
        margin-top: 14px;
        padding: 10px 14px;
        border-radius: 6px;
        font-size: 13px;
        line-height: 1.4;
    }

    .form-alert.success {
        background: #e7f5ec;
        color: #1e6b3a;
        border: 1px solid #c3e6cd;
    }

    .form-alert.error {
        background: #fbeaea;
        color: #a94442;
        border: 1px solid #f0c9c9;
    }

    /* ---------- Step 2: verify ---------- */
    .otp-sent-to {
        font-size: 13.5px;
        color: #4a5a6d;
        margin-bottom: 20px;
        text-align: center;
    }

    .otp-sent-to a {
        color: #1f4e79;
        font-weight: 600;
        text-decoration: none;
    }

    .otp-sent-to a:hover {
        text-decoration: underline;
    }

    .otp-input-group {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 4px;
    }

    .otp-box {
        width: 100%;
        height: 52px;
        text-align: center;
        font-size: 20px;
        font-weight: 700;
        color: #1c2b3a;
        border: 1px solid #d3ddea;
        border-radius: 8px;
        background: #fbfcfe;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .otp-box:focus {
        outline: none;
        border-color: #1f4e79;
        box-shadow: 0 0 0 3px rgba(31, 78, 121, 0.12);
        background: #fff;
    }

    .resend-row {
        margin-top: 18px;
        text-align: center;
        font-size: 13px;
        color: #6b7a8f;
    }

    .resend-row strong {
        color: #1f4e79;
    }

    .btn-resend {
        border: none;
        background: none;
        color: #1f4e79;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        padding: 0;
    }

    .btn-resend:hover {
        text-decoration: underline;
    }

    .btn-resend:disabled {
        color: #9fb4c8;
        cursor: not-allowed;
        text-decoration: none;
    }

    @media (max-width: 420px) {
        .otp-card-body {
            padding: 24px 20px 22px;
        }

        .otp-box {
            height: 46px;
            font-size: 18px;
        }
    }
</style>
<div class="otp-login-page" style="background:#f5f8ff; min-height:100vh; padding:60px 15px;">
    <div class="container" style="max-width:460px;">

        <div class="otp-card">

            <div class="otp-card-header">
                <div class="otp-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L3 6v6c0 5.25 3.75 9.75 9 11 5.25-1.25 9-5.75 9-11V6l-9-4z" stroke="#fff" stroke-width="1.6" stroke-linejoin="round"/>
                        <path d="M9 12.2l2 2 4-4.4" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h2>Secure Login</h2>
                <p>Verify your identity with a one-time password</p>
            </div>

            <div class="otp-card-body">

                <!-- ===================== STEP 1: SEND OTP ===================== -->
                <div class="otp-step" id="step-send">

                    <div class="method-toggle" role="tablist">
                        <input type="radio" name="otp_method" id="method-mobile" value="mobile" checked>
                        <label for="method-mobile">Mobile</label>
                        <input type="radio" name="otp_method" id="method-email" value="email">
                        <label for="method-email">Email</label>
                        <span class="method-toggle-glider"></span>
                    </div>

                    <form id="send-otp-form" method="POST" action="{{ url('/otp-send') }}" novalidate>
                        {{ csrf_field() }}
                        <input type="hidden" name="login_via" id="otp-target" value="mobile">

                        <div class="form-group" id="mobile-field">
                            <label>Mobile Number</label>
                            <div class="input-with-icon">
                                <span class="input-icon">+91</span>
                                <input type="tel" name="mobile" class="form-control" maxlength="10"
                                    inputmode="numeric" placeholder="Enter 10 digit mobile number"
                                    value="{{ old('mobile') }}">
                            </div>
                            <span class="field-hint" id="mobile-hint"></span>
                        </div>

                        <div class="form-group" id="email-field" style="display:none;">
                            <label>Email Address</label>
                            <div class="input-with-icon">
                                <span class="input-icon">@</span>
                                <input type="email" name="email" class="form-control"
                                    placeholder="Enter your email address" value="{{ old('email') }}">
                            </div>
                            <span class="field-hint" id="email-hint"></span>
                        </div>

                        <button type="submit" class="btn-otp-primary" id="send-otp-btn">
                            <span class="btn-label">Send OTP</span>
                            <span class="btn-spinner" style="display:none;"></span>
                        </button>

                        <div class="form-alert" id="send-alert" style="display:none;"></div>
                    </form>
                </div>
                <!-- ========================= END STEP 1 ========================= -->

                <!-- ===================== STEP 2: VERIFY OTP ===================== -->
                <div class="otp-step" id="step-verify" style="display:none;">

                    <p class="otp-sent-to">
                        Enter the 6-digit code sent to <strong id="sent-to-value"></strong>
                        &nbsp;<a href="#" id="change-target-link">Change</a>
                    </p>

                    <form id="verify-otp-form" method="POST" action="{{ url('/otp-verify') }}" novalidate>
                        {{ csrf_field() }}
                        <input type="hidden" name="login_via" id="verify-target">
                        <input type="hidden" name="destination" id="verify-destination">

                        <div class="otp-input-group" id="otp-boxes">
                            <input type="text" maxlength="1" class="otp-box" inputmode="numeric" autocomplete="one-time-code">
                            <input type="text" maxlength="1" class="otp-box" inputmode="numeric">
                            <input type="text" maxlength="1" class="otp-box" inputmode="numeric">
                            <input type="text" maxlength="1" class="otp-box" inputmode="numeric">
                            <input type="text" maxlength="1" class="otp-box" inputmode="numeric">
                            <input type="text" maxlength="1" class="otp-box" inputmode="numeric">
                        </div>
                        <input type="hidden" name="otp" id="otp-hidden-value">

                        <span class="field-hint" id="otp-hint"></span>

                        <button type="submit" class="btn-otp-primary" id="verify-otp-btn">
                            <span class="btn-label">Verify &amp; Login</span>
                            <span class="btn-spinner" style="display:none;"></span>
                        </button>

                        <div class="form-alert" id="verify-alert" style="display:none;"></div>

                        <div class="resend-row">
                            <span id="resend-timer-text">Resend OTP in <strong id="resend-seconds">60</strong>s</span>
                            <button type="button" class="btn-resend" id="resend-otp-btn" style="display:none;">
                                Resend OTP
                            </button>
                        </div>
                    </form>
                </div>
                <!-- ========================= END STEP 2 ========================= -->

            </div>
        </div>

    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {

        var target = document.getElementById('otp-target');
        var mobileField = document.getElementById('mobile-field');
        var emailField = document.getElementById('email-field');
        var mobileRadio = document.getElementById('method-mobile');
        var emailRadio = document.getElementById('method-email');
        var mobileInput = document.querySelector('input[name="mobile"]');
        var emailInput = document.querySelector('input[name="email"]');

        var sendForm = document.getElementById('send-otp-form');
        var sendBtn = document.getElementById('send-otp-btn');
        var sendAlert = document.getElementById('send-alert');

        var stepSend = document.getElementById('step-send');
        var stepVerify = document.getElementById('step-verify');
        var sentToValue = document.getElementById('sent-to-value');
        var changeTargetLink = document.getElementById('change-target-link');

        var verifyForm = document.getElementById('verify-otp-form');
        var verifyBtn = document.getElementById('verify-otp-btn');
        var verifyAlert = document.getElementById('verify-alert');
        var verifyTargetHidden = document.getElementById('verify-target');
        var verifyDestinationHidden = document.getElementById('verify-destination');
        var otpHiddenValue = document.getElementById('otp-hidden-value');
        var otpBoxes = document.querySelectorAll('.otp-box');

        var resendBtn = document.getElementById('resend-otp-btn');
        var resendTimerText = document.getElementById('resend-timer-text');
        var resendSeconds = document.getElementById('resend-seconds');

        var RESEND_WAIT = 100;
        var resendInterval = null;

        function toggleFields() {
            if (target.value === 'email') {
                mobileField.style.display = 'none';
                emailField.style.display = 'block';
            } else {
                mobileField.style.display = 'block';
                emailField.style.display = 'none';
            }
        }

        mobileRadio.addEventListener('change', function () {
            target.value = 'mobile';
            toggleFields();
        });
        emailRadio.addEventListener('change', function () {
            target.value = 'email';
            toggleFields();
        });
        toggleFields();

        function currentDestination() {
            return target.value === 'email' ? (emailInput.value || '').trim() : (mobileInput.value || '').trim();
        }

        function showAlert(el, message, type) {
            el.textContent = message;
            el.className = 'form-alert ' + type;
            el.style.display = 'block';
        }

        function setSending(isSending) {
            sendBtn.disabled = isSending;
            sendBtn.querySelector('.btn-label').style.visibility = isSending ? 'hidden' : 'visible';
            sendBtn.querySelector('.btn-spinner').style.display = isSending ? 'inline-block' : 'none';
        }

        function startResendTimer() {
            var remaining = RESEND_WAIT;
            resendBtn.style.display = 'none';
            resendTimerText.style.display = 'inline';
            resendSeconds.textContent = remaining;

            clearInterval(resendInterval);
            resendInterval = setInterval(function () {
                remaining--;
                resendSeconds.textContent = remaining;
                if (remaining <= 0) {
                    clearInterval(resendInterval);
                    resendTimerText.style.display = 'none';
                    resendBtn.style.display = 'inline-block';
                }
            }, 1000);
        }

        function sendOtpRequest(destination, method) {
            var formData = new FormData();
            formData.append('_token', sendForm.querySelector('input[name="_token"]').value);
            formData.append('login_via', method);
            formData.append(method === 'email' ? 'email' : 'mobile', destination);

            return fetch(sendForm.action, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            });
        }

        sendForm.addEventListener('submit', function (e) {
            e.preventDefault();
            sendAlert.style.display = 'none';

            var method = target.value;
            var destination = currentDestination();

            if (method === 'mobile' && !/^[6-9]\d{9}$/.test(destination)) {
                showAlert(sendAlert, 'Please enter a valid 10-digit mobile number.', 'error');
                return;
            }
            if (method === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(destination)) {
                showAlert(sendAlert, 'Please enter a valid email address.', 'error');
                return;
            }

            setSending(true);

            sendOtpRequest(destination, method)
                .then(function (response) {
                    setSending(false);
                    if (!response.ok) {
                        throw new Error('send_failed');
                    }
                    // Move to verify step
                    verifyTargetHidden.value = method;
                    verifyDestinationHidden.value = destination;
                    sentToValue.textContent = method === 'email'
                        ? destination
                        : destination.replace(/^(\d{2})\d{6}(\d{2})$/, '$1XXXXXX$2');

                    stepSend.style.display = 'none';
                    stepVerify.style.display = 'block';
                    otpBoxes[0].focus();
                    startResendTimer();
                })
                .catch(function () {
                    setSending(false);
                    showAlert(sendAlert, 'Could not send OTP right now. Please try again.', 'error');
                });
        });

        changeTargetLink.addEventListener('click', function (e) {
            e.preventDefault();
            clearInterval(resendInterval);
            stepVerify.style.display = 'none';
            stepSend.style.display = 'block';
            verifyAlert.style.display = 'none';
            otpBoxes.forEach(function (box) { box.value = ''; });
        });

        resendBtn.addEventListener('click', function () {
            var method = verifyTargetHidden.value;
            var destination = verifyDestinationHidden.value;

            resendBtn.disabled = true;
            sendOtpRequest(destination, method)
                .then(function (response) {
                    resendBtn.disabled = false;
                    if (!response.ok) {
                        throw new Error('resend_failed');
                    }
                    showAlert(verifyAlert, 'A new OTP has been sent.', 'success');
                    startResendTimer();
                })
                .catch(function () {
                    resendBtn.disabled = false;
                    showAlert(verifyAlert, 'Could not resend OTP. Please try again.', 'error');
                });
        });

        // OTP box auto-advance / backspace / paste handling
        otpBoxes.forEach(function (box, index) {
            box.addEventListener('input', function () {
                box.value = box.value.replace(/\D/g, '').slice(0, 1);
                if (box.value && index < otpBoxes.length - 1) {
                    otpBoxes[index + 1].focus();
                }
                syncOtpValue();
            });

            box.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace' && !box.value && index > 0) {
                    otpBoxes[index - 1].focus();
                }
            });

            box.addEventListener('paste', function (e) {
                var pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
                if (pasted.length) {
                    e.preventDefault();
                    for (var i = 0; i < otpBoxes.length; i++) {
                        otpBoxes[i].value = pasted[i] || '';
                    }
                    syncOtpValue();
                    otpBoxes[Math.min(pasted.length, otpBoxes.length) - 1].focus();
                }
            });
        });

        function syncOtpValue() {
            var value = '';
            otpBoxes.forEach(function (box) { value += box.value; });
            otpHiddenValue.value = value;
        }

        verifyForm.addEventListener('submit', function (e) {
            verifyAlert.style.display = 'none';
            if (otpHiddenValue.value.length !== 6) {
                e.preventDefault();
                showAlert(verifyAlert, 'Please enter the complete 6-digit OTP.', 'error');
                otpBoxes[0].focus();
            }
            // otherwise let it submit normally to /otp-verify for the backend to handle login
        });
    });
</script>
@endsection