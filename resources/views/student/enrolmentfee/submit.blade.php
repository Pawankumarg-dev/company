Redirecting to Payment Gateway.. Please do not close the window.
<form style="display:none" name="redirect" class="form-horizontal"
                    action="{{ url('/institute/enrolmentpayments/ccavenuepaymentgatewayrequesthandler/') }}"
                    method="post"  enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{ $row->id }}">
                <input type="hidden" id="order_number" name="order_number" value="{{ Session::get('order_number') }}" />
                <input type="hidden" id="ref_num" name="ref_num" value="" />
                <input type="hidden" id="order_id" name="order_id" value="{{ Session::get('order_number') }}" />
                <input type="hidden" name="amount" value="{{ Session::get('total') }}" />
                <input type="hidden" name="billing_notes" value="{{ $billing_notes }}"/>
                <input type="hidden" name="cy" value="INR" />
                <input type="hidden" name="tid" id="tid">
                <input type="hidden" name="language" value="EN"/>
                <input type="hidden" name="nber_id" value="{{$nber_id}}">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-12">
                        <div style="padding-left:15px;padding-bottom:20px;">
                            <small>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-left:0px;margin-right:5px;">
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('billing_name') ? 'has-error' : '' }}" style="padding-right:20px;">
                            <label for="billing_name" class="control-label ">
                                <div class="text-left blue-text">Name 
                                    <span class="red-text">*</span>
                                </div>
                            </label>
                            <div class="">
                                <input type="text" class="form-control" name="billing_name" id="billing_name" placeholder="Enter Name" value="{{$billing_name}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('billing_designation') ? 'has-error' : '' }} ">
                            <label for="billing_designation" class="control-label">
                                <div class="text-left blue-text">Designation 
                                    <span class="red-text">*</span>
                                </div>
                            </label>
                            <div class="">
                                <input type="text" class="form-control" name="billing_designation" id="billing_designation" value="{{$billing_designation}}" placeholder="Enter Designation">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('billing_tel') ? 'has-error' : '' }}  "  style="padding-right:20px;">
                            <label for="billing_tel" class="control-label">
                                <div class="text-left blue-text">Mobile No.
                                    <span class="red-text">*</span>
                                </div>
                            </label>
                            <div class="">
                                <input type="text" class="form-control" name="billing_tel" id="billing_tel" placeholder="Enter Mobile No." maxlength="10" value="{{$billing_tel}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('billing_email') ? 'has-error' : '' }}  ">
                            <label for="billing_email" class="control-label">
                                <div class="text-left blue-text">Email ID
                                    <span class="red-text">*</span>
                                </div>
                            </label>
                            <div class="">
                                <input type="text" class="form-control" name="billing_email" value="{{$billing_email}}" id="billing_email" placeholder="Enter Email ID">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button style="margin-top:10px;margin-right:0;" class="btn btn-primary pull-right">Pay Online</button>
                    </div>
                </div>
            </form>
            <script language='javascript'>document.redirect.submit();</script>