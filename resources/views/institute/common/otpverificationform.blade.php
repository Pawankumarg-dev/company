<div class="form-group">
    <div class="text-left blue-text col-sm-2">
        <label for="mobile-number" class="control-label">
            Student's Mobile No.
            <span class="red-text">*</span>
        </label>
    </div>

    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-4">
                <div class="input-group">
                    <span class="input-group-addon">+91</span>
                    <input type="text" name="mobileNumber" id="mobile-number" class="form-control blue-text" maxlength="10" readonly />
                </div>
            </div>

            <div id="mobile-number-verify-button-div" class="col-sm-5 col-sm-offset-2">
                <button id="mobile-number-verify-button" type="button" class="btn btn-sm btn-warning" onclick="displayMobileNoVerificationModal()" disabled>
                    <span class="glyphicon glyphicon-circle-arrow-right"></span>
                    Click here to Verify Mobile No.
                </button>
            </div>

            <div id="mobile-number-show-verified-div" class="col-sm-5 col-sm-offset-2 content-hide text-success">
                <strong>&check;&nbsp; Mobile Number Verified</strong>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="text-left blue-text col-sm-2">
        <label for="email-address" class="control-label">
            Student's Email Address
            <span class="red-text">*</span>
        </label>
    </div>

    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-4">
                <input type="text" name="emailAddress" id="email-address" class="form-control blue-text" readonly />
            </div>

            <div id="email-address-verify-button-div" class="col-sm-5 col-sm-offset-2">
                <button id="email-address-verify-button" type="button" class="btn btn-sm btn-warning" onclick="displayEmailAddressVerificationModal()" disabled>
                    <span class="glyphicon glyphicon-circle-arrow-right"></span>
                    Click here to Verify Email Address
                </button>
            </div>

            <div id="email-address-show-verified-div" class="col-sm-4 col-sm-offset-2 content-hide text-success">
                <strong>&check;&nbsp; Email Address Verified</strong>
            </div>
        </div>
    </div>
</div>