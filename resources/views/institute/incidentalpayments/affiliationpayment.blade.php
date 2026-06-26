@extends('layouts.app')

@section('content')
    <style>
        body {min-height:1000px;}
    </style>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
<h3>
    Affiliation Fee Payment -
    {{ $affiliationfee->approvedprogramme->programme->abbreviation }},
    Academic Year:

    @if($affiliationfee->term == 1)
        {{ $affiliationfee->academicyear->year }} - {{ $affiliationfee->academicyear->year + 1 }},
    @else
        {{ $affiliationfee->academicyear->year + 1 }} - {{ $affiliationfee->academicyear->year + $affiliationfee->term }},
    @endif

    Term: {{ $affiliationfee->term }}
</h3>               
            </div>


            <div class="alert alert-success">
               <ul>
    <li>No special characters are allowed in the name.</li>
    <li>Please ensure your mobile number is correct.</li>
    <li>Please ensure your email address is correct.</li>
    <li>If redirecting back, please use the short name of the institute and remove multiple contact numbers or emails.</li>
    <li>If payment is deducted from your account, please wait 3 working days. If it is still not updated after 3 days, please contact RCI.</li>
</ul>
             </div>
        </div>
    </div> 

    <div class="container">
            <form class="form-horizontal"
                    action="{{ url('/institute/incidentalpayments/ccavenuepaymentgatewayrequesthandler/') }}"
                    method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                <input type="hidden" name="affiliationfee_id" value="{{ $affiliationfee->id }}">
                <input type="hidden" name="approveprogramme_id" value="{{ $ap->id }}">
                <input type="hidden" name="institute_id" value="{{ $institute->id }}">
                <input type="hidden" name="academicyear_id" value="{{ $academicyear->id }}">
                <input type="hidden" id="order_number" name="order_number" value="{{ Session::get('ref_num') }}" />
                <input type="hidden" id="ref_num" name="ref_num" value="" />
                <input type="hidden" id="order_id" name="order_id" value="{{ Session::get('order_number') }}" />
                <input type="hidden" name="amount" value="{{ Session::get('total') }}" />
                <input type="hidden" name="billing_notes" value="Affiliation fee payment for the year -  {{  $academicyear->year }}" />
                <input type="hidden" name="cy" value="INR" />
                <input type="hidden" name="tid" id="tid">
                <input type="hidden" name="language" value="EN"/>
                {{csrf_field()}}
                <div class="row">
                    <div class="col-12">
                        <div style="padding-left:15px;padding-bottom:20px;">
                            <small>
                            Please enter the details of the person filling the form.
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-left:0px;margin-right:5px;">
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('billing_name') ? 'has-error' : '' }}" value="{{$institute->name}}" style="padding-right:20px;">
                            <label for="billing_name" class="control-label ">
                                <div class="text-left blue-text">Name 
                                    <span class="red-text">*</span>
                                </div>
                            </label>
                            <div class="">
                                <input type="text" class="form-control" name="billing_name" value="{{$institute->name}}"id="billing_name" placeholder="Enter Name">
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
                                <input type="text" class="form-control" name="billing_designation" value="institute" id="billing_designation" placeholder="Enter Designation">
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
                                <input type="text" class="form-control" name="billing_tel" value="{{$institute->contactnumber1}}" id="billing_tel" placeholder="Enter Mobile No." maxlength="10">
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
                                <input type="text" class="form-control" name="billing_email" value="{{$institute->email}}" id="billing_email" placeholder="Enter Email ID">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button style="margin-top:10px;margin-right:0;" class="btn btn-primary pull-right">Pay Online</button>
                    </div>
                </div>
            </form>
      
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
                swal("Error Occurred!!!", "Enter your name.", "error");
                return false;
            }

            if(!$('#billing_designation').val()) {
                swal("Error Occurred!!!", "Enter your Designation.", "error");
                return false;
            }

            if(!$('#billing_tel').val()) {
                swal("Error Occurred!!!", "Enter your  Mobile No.", "error");
                return false;
            }

            if(parseInt($('#billing_tel').val().length) != '10') {
                swal("Error Occurred!!!", "Enter a valid mobile number.", "error");
                return false;
            }

            //alert(parseInt($('#billing_tel').val().length));

            if(!$('#billing_email').val()) {
                swal("Error Occurred!!!", "Enter your Email address.", "error");
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
