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
                                    <input type="text" class="form-control blue-text" id="mobile-number-verification-code-2" name="mobile-number-verification-code-2" maxlength="4" placeholder="4-digit Verification Code" />
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