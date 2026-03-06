@extends('layouts.app')

@section('content')
<script>
	window.onload = function() {
		var d = new Date().getTime();
		document.getElementById("tid").value = d;
	};
</script>
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 well well-sm white-background minus15px-margin-top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="breadcrumb col-md-12">
                                Affiliation Fee - 
                                {{ $academicyear->year }}
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr class="grey-background">
                            <th class="center-text" colspan="2">Instructions</th>
                        </tr>
                        @php $sno = 1; @endphp
                        <tr class="blue-text bold-text">
                            <td class="center-text" width="5%">{{ str_pad($sno ,2,"0",STR_PAD_LEFT) }} @php $sno++; @endphp</td>
                            <td>
                                The fields that are marked as <span class="red-text"> *</span>, are mandatory to enter/select.
                            </td>
                        </tr>
                        <tr class="blue-text bold-text">
                            <td class="center-text" width="5%">{{ str_pad($sno ,2,"0",STR_PAD_LEFT) }} @php $sno++; @endphp</td>
                            <td>
                                It is informed that some of th online payment options may have Convenvience fee and Tax fee in addition
                                with the actual payable amount. the Convenience fee and Tax fee may differ frome one to another. The UPI
                                payment like BHIM, GPay, Phone-Pe doesn't have Convenience fee and Tax fee. Hence, you are advised to choose
                                the online payment options carefully before proceeding for making online payment.
                            </td>
                        </tr>
                        <tr class="blue-text bold-text">
                            <td class="center-text" width="5%">{{ str_pad($sno ,2,"0",STR_PAD_LEFT) }} @php $sno++; @endphp</td>
                            <td>
                                It is informed that only the actual payable amount will be mentioned in the acknowledgment receipt.
                                Convenience fee and Tax fee need not to be mentioned in the acknowledgment receipt. There shall be no
                                claim for it in future.
                            </td>
                        </tr>
                        <tr class="blue-text bold-text">
                            <td class="center-text" width="5%">{{ str_pad($sno ,2,"0",STR_PAD_LEFT) }} @php $sno++; @endphp</td>
                            <td>
                                No claim / request for refund payment made shall be accepted / entertained after the final payments made / submit.
                            </td>
                        </tr>
                        <tr class="blue-text bold-text">
                            <td class="center-text" width="5%">{{ str_pad($sno ,2,"0",STR_PAD_LEFT) }} @php $sno++; @endphp</td>
                            <td>
                                In case of the amount is debited from your account but the transaction was not successful,
                                you are requested to contact the respective banks for making any claim.
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Incidental Charges Payment Form
                        </div>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal"
                              action="{{ url('/institute/incidentalpayments/ccavenuepaymentgatewayrequesthandler/') }}"
                              method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                            <input type="hidden" name="incidentalfee_id" value="{{ $incidentalfee->id }}">
                            <input type="hidden" name="institute_id" value="{{ $approvedprogramme->institute->id }}">
                            <input type="hidden" name="approvedprogramme_id" value="{{ $approvedprogramme->id }}">
                            <input type="hidden" name="academicyear_id" value="{{ $approvedprogramme->academicyear->id }}">
                            <input type="hidden" id="order_number" name="order_number" value="{{ $order_number }}" />
                            <input type="hidden" id="ref_num" name="ref_num" value="{{ $ref_num }}" />
                            <input type="hidden" id="order_id" name="order_id" value="{{ $order_number }}" />
                            <input type="hidden" name="amount" value="{{ $incidentalfee->fee }}" />
                            <input type="hidden" name="billing_notes" value="{{ $billing_notes }}"/>
                            <input type="hidden" name="cy" value="INR" />
                            <input type="hidden" name="tid" id="tid">
                            <input type="hidden" name="language" value="EN"/>

                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="payment_date" class="control-label col-sm-4">
                                    <div class="text-left blue-text">
                                        Course & Batch :
                                    </div>
                                </label>
                                <div class="col-sm-3">
                                    <div class = "form-control-static">
                                        {{ $approvedprogramme->programme->course_name }} - {{ $approvedprogramme->academicyear->year }} ({{ $incidentalfee->term }} year)
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="payment_date" class="control-label col-sm-4">
                                    <div class="text-left blue-text">
                                        Amount :
                                    </div>
                                </label>
                                <div class="col-sm-3">
                                    <div class = "form-control-static">
                                        Rs. {{ $incidentalfee->fee }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('billing_name') ? 'has-error' : '' }}">
                                <label for="billing_name" class="control-label col-sm-4">
                                    <div class="text-left blue-text">Name of the Entering Person
                                        <span class="red-text">
                                    *
                                </span>
                                    </div>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="billing_name" id="billing_name" placeholder="Enter Name">
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('billing_address') ? 'has-error' : '' }}">
                                <label for="billing_address" class="control-label col-sm-4">
                                    <div class="text-left blue-text">Designation of the Entering Person
                                        <span class="red-text">
                                    *
                                </span>
                                    </div>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="billing_address" id="billing_address" placeholder="Enter Designation">
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('billing_tel') ? 'has-error' : '' }}">
                                <label for="billing_tel" class="control-label col-sm-4">
                                    <div class="text-left blue-text">Mobile No. of the Entering Person
                                        <span class="red-text">
                                    *
                                </span>
                                    </div>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="billing_tel" id="billing_tel" placeholder="Enter Mobile No." maxlength="10">
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('billing_email') ? 'has-error' : '' }}">
                                <label for="billing_email" class="control-label col-sm-4">
                                    <div class="text-left blue-text">Email ID of the Entering Person
                                        <span class="red-text">
                                    *
                                </span>
                                    </div>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="billing_email" id="billing_email" placeholder="Enter Email ID">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <span class="glyphicon glyphicon-circle-arrow-right"></span>
                                        Proceed for Online Payment
                                    </button>
                                    <button type="reset" class="btn btn-danger btn-sm">
                                        <span class="glyphicon glyphicon-remove-sign"></span>
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
                swal("Error Occurred!!!", "Enter the Entering Person\'s Name.", "error");
                return false;
            }

            if(!$('#billing_address').val()) {
                swal("Error Occurred!!!", "Enter the Entering Person\'s Designation.", "error");
                return false;
            }

            if(!$('#billing_tel').val()) {
                swal("Error Occurred!!!", "Enter the Entering Person\'s Mobile No.", "error");
                return false;
            }

            if(parseInt($('#billing_tel').val().length) != '10') {
                swal("Error Occurred!!!", "Enter the valid Person\'s Mobile No.", "error");
                return false;
            }

            //alert(parseInt($('#billing_tel').val().length));

            if(!$('#billing_email').val()) {
                swal("Error Occurred!!!", "Enter the Entering Person\'s Email.", "error");
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