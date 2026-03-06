@extends('layouts.app')
@section('content')
<style>
    .text-right{
        text-align:right;
    }
</style>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2>
                    Enrolment Fee - {{Session::get('academicyear')}}
                </h2>
                @include('common.errorandmsg')

                @foreach($nbers as $n)
                    <?php $pcount = 0; ?>
                    @foreach($approvedprogrammes as $ap)
                        @if($ap->programme->nber_id == $n->id)
                            <?php $pcount += 1; ?>
                        @endif
                    @endforeach
                    @if($pcount>0)
                        <h3>
                            {{$n->name_code}}
                        </h3>
                        <?php $totalamount = 0; $slno = 1; ?>
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th rowspan="2">SlNo</th>
                                <th  rowspan="2">Course</th>
                                <th colspan="2">No of Students</th>
                                
                                <th rowspan="2" class="text-right">Amount</th>
                            </tr>
                            <tr>
                                <th>Uploaded</th>
                                <th>Verification Completed</th>
                            </tr>
                            @foreach($approvedprogrammes as $ap)
                                @if($ap->programme->nber_id == $n->id)
                                    <tr>
                                        <td>
                                            {{$slno}} <?php $slno += 1; ?>
                                        </td>
                                        <td>
                                            {{$ap->programme->course_name}}
                                        </td>
                                        <td>
                                            {{$ap->candidates->count()}}
                                        </td>
                                        <td>
                                            <?php $ccount = $ap->candidates->where('status_id',2)->count(); $amount = $ccount * 500; $totalamount += $amount; ?>
                                            {{$ccount}}
                                        </td>
                                        <td class="text-right">
                                        ₹ {{number_format($amount,2)}}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr>
                                <th colspan="4" class="text-right">Total</th>
                                <th class="text-right">₹ {{number_format($totalamount,2)}}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-right">Paid</th>
                                <th class="text-right">
                                    <?php 
                                        $order_ids = \App\Enrolmentfeepayment::where('institute_id',$institute_id)->where('academicyear_id',Session::get('academicyear_id'))->where('nber_id',$n->id)->pluck('order_id')->toArray(); 

                                        $paid = \App\Order::whereIn('id',$order_ids)->where('order_status','Success')->sum('actual_amount');
                                        if($paid == ''){$paid=0;}
                                        $pending = $totalamount - $paid;
                                    ?>
                                    ₹ {{number_format($paid,2)}}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-right">Pending</th>
                                <th class="text-right">₹ {{number_format($pending,2)}}
                                </th>
                            </tr>
                            @if(($pending)>0)
                                <tr>
                                    <td colspan="5">
                                        <a href="javascript:openmodal({{$n->id}},{{$pending}})" class="btn btn-primary btn-xs pull-right">Pay Online</a>
                                    </td>
                                </tr>
                            @endif
                        </table>

                        
                        @foreach($enrolmentfees as $enrolmentfee)
                            @if($enrolmentfee->nber_id == $n->id)
                                @if($enrolmentfee->orders->count() > 0)
                                    <div class="row">
                                        <div class="col-12" style="padding-left: 15px;padding-right: 15px;">
                                            <h4>Transaction Details</h4>
                                            <table class="table  table-bordered">
                                                <tr>
                                                    <th>Order Number</th>
                                                    <th>Reference Number</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                </tr>
                                                @foreach($enrolmentfee->orders as $order)
                                                    <tr>
                                                        <td>
                                                            {{$order->order_number}}
                                                        </td>
                                                        <td>
                                                            {{$order->ccavenue_referencenumber}}
                                                        </td>
                                                        <td>
                                                            {{$order->actual_amount}}
                                                        </td>
                                                        <td>
                                                            {{$order->payment_date}}
                                                        </td>
                                                        <td>
                                                            @if($order->order_status == "Success")
                                                            <span class="label label-xs label-success"> 
                                                                    {{$order->order_status}}
                                                                </span>
                                                            @else
                                                                @if($order->order_status == "Fail")
                                                                <span class="label label-xs label-danger"> 
                                                                        {{$order->order_status}}
                                                                    </span>
                                                                @else
                                                                <span class="label label-xs label-warning"> 
                                                                        {{$order->order_status}}
                                                                    </span>
                                                                @endif
                                                            @endif
                                                            @if($order->order_status != "Success")
                                                                    <a href="{{url('/institute/enrolmentfee/recheckpayment/')}}/{{$order->id}}/{{$enrolmentfee->id}}"> &nbsp;Refresh</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div id="paymentdetails" class="modal fade modal-xs" role="dialog">
        <div class="modal-dialog">
            <form class="form-horizontal"  onsubmit="return validateForm()" action="{{url('/institute/affiliationfee')}}" method='get' >
                {!! csrf_field() !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Payment Details</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="nber_id" name='nber_id'  />
                        <input type="hidden" id="amount" name='amount'  />
                        <input type="hidden" id="type" name='type' value="enrolment"  />
                        <div class="row" style="margin-left:0!important;margin-right:0!important;">
                            <div class="col-sm-12">
                                <div class="form-group {{ $errors->has('billing_name') ? 'has-error' : '' }}" style="padding-right:20px;">
                                    <label for="billing_name" class="control-label ">
                                        <div class="text-left blue-text">Name 
                                            <span class="red-text">*</span>
                                        </div>
                                    </label>
                                    <div class="">
                                        <input type="text" class="form-control" name="billing_name" id="billing_name" placeholder="Enter Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group {{ $errors->has('billing_designation') ? 'has-error' : '' }} "  style="padding-right:20px;">
                                    <label for="billing_designation" class="control-label">
                                        <div class="text-left blue-text">Designation 
                                            <span class="red-text">*</span>
                                        </div>
                                    </label>
                                    <div class="">
                                        <input type="text" class="form-control" name="billing_designation" id="billing_designation" placeholder="Enter Designation">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group {{ $errors->has('billing_tel') ? 'has-error' : '' }}  "  style="padding-right:20px;">
                                    <label for="billing_tel" class="control-label">
                                        <div class="text-left blue-text">Mobile No.
                                            <span class="red-text">*</span>
                                        </div>
                                    </label>
                                    <div class="">
                                        <input type="text" class="form-control" name="billing_tel" id="billing_tel" placeholder="Enter Mobile No." maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group {{ $errors->has('billing_email') ? 'has-error' : '' }}  "  style="padding-right:20px;">
                                    <label for="billing_email" class="control-label">
                                        <div class="text-left blue-text">Email ID
                                            <span class="red-text">*</span>
                                        </div>
                                    </label>
                                    <div class="">
                                        <input type="text" class="form-control" name="billing_email" id="billing_email" placeholder="Enter Email ID">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button  class="btn btn-primary">Pay Online</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openmodal(nber_id,amount){
            $('#nber_id').val(nber_id);
            $('#amount').val(amount);
            $('#paymentdetails').modal('show');
        }
    </script>
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