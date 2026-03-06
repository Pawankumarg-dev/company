@extends('layouts.app')
@section('script')
    <script>
        $('#declare').on('click',function(){
        if($('#declare')[0].checked){
            $('#pay').prop('disabled',false);
        }else{
            $('#pay').prop('disabled',true);
        }
    });
    $('#showpayment').on('click',function(){
        var reevaluation =  $('.reevaluation:checked').length;
        var retotal =  $('.retotal:checked').length;
        var photocopy =  $('.photocopy:checked').length;
        $('#reevaluation_count').html(reevaluation);
        $('#retotalling_count').html(retotal);
        $('#photocopy_count').html(photocopy);
        var reevaluationfee = reevaluation * {{$reevaluationfee->reevaluation_fee}};
        var retotalfee = retotal * {{$reevaluationfee->retotalling_fee}};
        var photocopyfee = photocopy * {{$reevaluationfee->photocopying_fee}};
        let INR = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'INR',
        });
        $('#reevaluation_fee').html(INR.format(reevaluationfee));
        $('#retotalling_fee').html(INR.format(retotalfee));
        $('#photocopy_fee').html(INR.format(photocopyfee));
        var totalfee = reevaluationfee+retotalfee+photocopyfee;
        $('#total_fee').html(INR.format(totalfee));
        $('#amount').val(totalfee);
        if(totalfee>0){
            $('#declare').prop('checked', false);
            $('#pay').prop('disabled',true);
            $('#myModal').modal('show');
        }else{
            swal({
                type: 'warning',
                title: 'Please choose the papers',
                showConfirmButton: false,
                timer: 1500
            });
        }
        return false;
    });
    </script>
    <script>
        function cancelApplication(id){
            swal({
                    title: 'Are you sure?',
                    text: "This action cannot be undone",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.value) {
                        window.location.replace("{{url('student/delete/reevaluation')}}/"+id);
                    }
                });
        }
        function updateEmail(){
            swal({
                title: 'Update your Email Address'  ,
                text: "Enter the Email Address",
                input: 'text',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Update',
                inputValidator: (value) => {
                    if (value == '') 
                    {
                        return 'Email Cannot be empty'
                    }
                    else {
                        
                        window.location.replace("{{url('generateemailotp')}}?email="+value);
                  /*      var token = $('input[name=_token]');
                        var formData = new FormData();
						formData.append('email', value);
                        $.ajax({
                            //url: 'https://rciregistration.nic.in/rehabcouncil/api/findbycrrno.jsp?id='+value,
                            url: "{{url('generateemailotp')}}",
                            method: 'GET',
                            dataType: 'json',
                            contentType: false,
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': token.val()
                            },
							data: formData,
                            success: function (data) {
                                console.log(data);
                                if(data!=0){
                                    swal({
                                        type: 'success',
                                        title: 'Email Updated',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                  //  savefaculty();
                                    setTimeout(function(){
                                        location.reload();
                                    }, 3000); 
                                }else{
                                    $('#alert').removeClass('hidden');
                                }
                            },
                            error: function (data) {
                                $('#alert').removeClass('hidden');
                            }
                        }); */
                    }
                },
            }).then((result) => {
                
            });
        }
    </script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Re-evaluation Application - June 2025 Examination</h3>
                @include('common.errorandmsg')
               {{--  @if($candidate->is_email_address_confirmed == 'No')  --}}
               @if(false)
                    &nbsp; <span class="text-muted">Please confirm your email address to continue.. </span>
                    <br /> <br />
                    <table class="table table-bordered "> 
                        <tr>
                            <td>
                            Email Address
                            </td>
                            <td>
                            {{$candidate->email}}
                            </td>
                        </tr>
                    </table>
                    <a href="{{url('generateemailotp')}}" class="btn btn-xs btn-success pull-right" style="margin-left:10px;">Confirm</a>
                    <a href="javascript:updateEmail();" class="btn btn-xs btn-primary pull-right" >Edit</a>
                @else
                    <ul>
                    <li>
                    No request shall be accepted for change of Papers after final submission. Candidates are advised to carefully check all the relevant details before final submission.
                    </li>
                    <li>
                    The results of Re-Evaluation / Re-Totalling can be tracked in student login area with the application number.
                    </li>
                    <li class="hidden">
                        The photocopy of Answer Scripts applied will be sent to the registered email id.
                    </li>
                    <li>
                    The result of Re-Evaluation / Re-Totalling, shall be binding on the candidate. Hence, no calls / representations will be entertained.
                    </li>
                    <li class="hidden">
                    If any discrepancy found in the photocopy of the Answer Scripts, it need to be  communicated to the respective NBER, immediately.
                    </li>
                    </ul>

                    <table class="table table-bordered table-stripped"> 
                        <tr>
                            <td></td>
                            
                            <td>Re-Evaluation</td>
                            <td>Re-Totalling</td>
                            <td class="hidden">Photo-Copying</td>
                        </tr>
                        <tr>
                            <td>Fee per Subject</td>
                            <td>
                                ₹ {{number_format($reevaluationfee->reevaluation_fee,0)}}
                            </td>
                            <td>
                                ₹ {{number_format($reevaluationfee->retotalling_fee,0)}}
                            </td>
                            <td class="hidden">
                                ₹ {{number_format($reevaluationfee->photocopying_fee,0)}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                            Last Date
                            </td>
                            <td colspan="2" class="center-text">
                                24/NOV/2025
                            </td>
                        </tr>
                    </table>




                    @if(!is_null($reevaluationapplication))
                        <h4>Reevaluation Application</h4>
                        @if($reevaluationapplication->orderstatus_id == 1)
                            <a target="_blank" style="margin-bottom:5px;" href="{{url('student/reevaluation/receipt')}}/{{$reevaluationapplication->id}}" class="btn btn-sm btn-primary pull-right">Print Receipt</a>
                        @endif
                        <table class="table table-bordered table-stripped"> 
                            <tr>
                            <th>Application Number</th>
                            <th>Date</th>
                            <th>Subject Code</th>
                            <th>Subject</th>
                            <th class="center-text">Re-Evaluation</th>
                            <th class="center-text">Re-Totalling</th>
                            <th class="center-text hidden">Photo-Copying</th>
                            <th> Amount</th>

                            <th>Status</th>
                            {{-- <th>Re-evaluation Marks</th> --}}

                            </tr>
                            <?php $scount = $reevaluationapplication->reevaluationapplicationsubjects->count() + 1; ?>
                            <tr>
                            <td rowspan="{{$scount}}">
                                {{$reevaluationapplication->application_number}}
                            </td>
                            <td rowspan="{{$scount}}">
                                {{$reevaluationapplication->created_at->format('d/M/Y')}}
                            </td>
                            </tr>
                            <?php $refund = 0; ?>
                            @foreach($reevaluationapplication->reevaluationapplicationsubjects as $subject)
                                <tr>
                                <td>
                                    {{$subject->subject->scode}}
                                </td>
                                <td>
                                    {{$subject->subject->sname}}
                                </td>
                              
                                <td class="center-text">
                                    @if($subject->reevaluation_applystatus == 1)
                                        <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                                        <?php $refund = $refund + 1; ?>
                                    @endif
                                </td>
                                <td class="center-text">
                                    @if($subject->retotalling_applystatus == 1)
                                        <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                                    @endif
                                </td>
                                <td class="center-text" hidden>
                                    @if($subject->photocopying_applystatus == 1)
                                        <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                                    @endif
                                </td>
                              


                                <td>
                                <?php 
                                    $fee = ($subject->reevaluation_applystatus * $reevaluationfee->reevaluation_fee ) + ($subject->retotalling_applystatus * $reevaluationfee->retotalling_fee) + ($subject->photocopying_applystatus * $reevaluationfee->photocopying_fee)
                                ?>
                                ₹ {{number_format($fee,0)}}
                                </td>
                                <td>
                                    @if($reevaluationapplication->orderstatus_id == 1)
                                        @if($subject->active_status == 1)
                                        Processing
                                        @else
                                        Completed
                                        @endif
                                    @endif
                                </td>
                                {{-- <td >
                                    @if($reevaluationapplication->orderstatus_id == 1)
                                    @if($subject->no_change==1)
                                    {{ $subject->actual_marks === null || $subject->actual_marks === '' ? 0 : $subject->actual_marks }}
                                    @else
                                    {{ $subject->reevaluated_marks === null || $subject->reevaluated_marks === '' ? 0 : $subject->reevaluated_marks }}
                                    @endif
                                    @endif
                                </td> --}}
                                </tr>
                            @endforeach
                            <tr>
                            <td colspan="6">Total</td>
                            <td>₹ {{number_format($reevaluationapplication->amount,0)}}</td>
                            <td>
                                @if($reevaluationapplication->orderstatus_id == 1)
                                    Paid
                                @else
                    closed
                                    {{-- <form class="form-horizontal"   action="{{url('/institute/affiliationfee/')}}" method='get' >
                                        {!! csrf_field() !!}
                                        <input type="hidden" id="nber_id" name='nber_id' value="{{$candidate->approvedprogramme->programme->nber_id}}" />
                                        <input type="hidden" id="amount" name='{{$reevaluationapplication->amount}}'  />
                                        <input type="hidden" id="type" name='type' value="reevaluation"  />
                                        <input type="hidden" name="billing_name" id="billing_name" value="{{$candidate->name}}">
                                        <input type="hidden" name="billing_designation" id="billing_designation" value="Student">
                                        <input type="hidden" name="billing_tel" id="billing_tel" value="{{$candidate->contactnumber}}" >
                                        <input type="hidden" name="billing_email" id="billing_email" value="{{$candidate->email}}" >
                                        <input type="hidden" id="type" name='type' value="reevaluation"  />
                                        <input type="hidden" name="reevaluationapplication_id" value="{{$reevaluationapplication->id}}">
                                        <button class="btn btn-sm btn-primary" type="submit">Pay Online</button> --}}
                                        {{-- <a href="javascript:cancelApplication({{$reevaluationapplication->id}})" class="btn btn-sm btn-warning" style="margin-top:3px;">Cancel Application</button> --}}
                                    {{-- </form> --}}
                                    {{-- <a href="{{url('student/recheckStatusall')}}/{{$reevaluationapplication->id}}" class="btn btn-sm btn-primary hidden"  style="margin-top:3px;">Refresh Payment Status</a> --}}
                                @endif 
                            </td>
                            </tr>
                        </table>
                        <?php $successorders = 0; ?>
                        @if($reevaluationapplication->orders->count() > 0)
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
                                            <th></th>
                                        </tr>
                                        @foreach($reevaluationapplication->orders as $order)
                                            <tr>
                                                <td>
                                                    {{$order->order_number}}
                                                </td>
                                                <td>
                                                    {{$order->ccavenue_referencenumber}}
                                                </td>
                                                <td>
                                                    
                                                    ₹ {{number_format($order->actual_amount,0)}}
                                                </td>
                                                <td>
                                                    {{$order->payment_date}}
                                                </td>
                                                <td>
                                                    @if($order->order_status == "Success")
                                                    <span class="label label-xs label-success"> 
                                                            {{$order->order_status}}
                                                            <?php $successorders += 1; ?>
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
                                                </td>
                                                <td>
                                                {{-- @if($order->order_status != "Success")
                                                    <a class="hidden" href="{{url('student/recheckStatus')}}/{{$candidate->approvedprogramme->programme->nber_id}}/{{$order->id}}">Refresh</a>
                                                @endif --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        @endif

                        <?php $refundamount = 0; ?>                  
                        @if(($reevaluationapplication->orderstatus_id == 1 && $reevaluationapplication->id < 4045))
                            <?php $refundamount = $reevaluationapplication->amount; $additional = 0; ?>
                            @if($reevaluationapplication->orderstatus_id == 1 && $refund > 0 && $reevaluationapplication->id < 1569 )
                            <?php   
                                $refundamount = $refundamount -  ($refund*1000); $additional = $refund * 1000; ?>
                            @endif
                            <?php $refundamount = ($refundamount /2 ) +$additional ; ?>
                        @endif
                        @if($successorders > 1)
                            <?php $refundamount += ($successorders - 1) * $reevaluationapplication->amount; ?>
                        @endif
                        @if($refundamount > 0)
                            <div style="margin-bottom:50px;" class="hidden" >
                                <h5>Bank detils for Refund of ₹ {{number_format($refundamount,0)}} for Reevaluation Application. </h5>
                                <form action="{{url('student/reevaluation/bankdetails')}}" method="post">
                                    {!! csrf_field() !!}
                                    <table class="table table-bordered table-stripped">
                                        <tr>
                                            <th>
                                            Name 
                                            </th>
                                            <th>
                                                Bank & Branch
                                            </th>
                                            <th>
                                                IFSC Code
                                            </th>
                                            <th>
                                                Account Number
                                            </th>
                                            <th>Status</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="reevaluationapplication_id" value="{{$reevaluationapplication->id}}" />
                                                <input type="text" name="cname" @if(!is_null($reevaluationapplication->refund) && !is_null($reevaluationapplication->refund->refunddate)) disabled @endif value="@if(!is_null($reevaluationapplication->refund)) {{$reevaluationapplication->refund->cname}} @endif" />
                                            </td>
                                            <td>
                                                <input type="text" name="bank"  @if(!is_null($reevaluationapplication->refund) && !is_null($reevaluationapplication->refund->refunddate)) disabled @endif  value="@if(!is_null($reevaluationapplication->refund)) {{$reevaluationapplication->refund->bank}} @endif" />
                                            </td>
                                            <td>
                                                <input type="text" name="ifsccode"  @if(!is_null($reevaluationapplication->refund) && !is_null($reevaluationapplication->refund->refunddate)) disabled @endif   value="@if(!is_null($reevaluationapplication->refund)) {{$reevaluationapplication->refund->ifsccode}} @endif" />
                                            </td>
                                            <td>
                                                <input type="text" name="accountno"  @if(!is_null($reevaluationapplication->refund) && !is_null($reevaluationapplication->refund->refunddate)) disabled @endif   value="@if(!is_null($reevaluationapplication->refund)) {{$reevaluationapplication->refund->accountno}} @endif" />
                                            </td>
                                            <td>
                                                @if(!is_null($reevaluationapplication->refund) && !is_null($reevaluationapplication->refund->refunddate))
                                                    Ref No {{$reevaluationapplication->refund->refno}} Dated {{\Carbon\Carbon::parse($reevaluationapplication->refund->refunddate)->format('d/m/Y')}}
                                                @else
                                                    Processing
                                                @endif 
                                            </td>
                                        </tr>
                                    </table>
                                    <button class="btn btn-sm btn-primary pull-right"  @if(!is_null($reevaluationapplication->refund) && !is_null($reevaluationapplication->refund->refunddate)) disabled @endif >Save</button>
                                </form>
                            </div>
                        @endif
                    @else

                    {{-- payment --}}
                        {{-- <form class="form-horizontal"  onsubmit="return validateForm()" action="{{url('/institute/affiliationfee/')}}" method='get' >
                            {!! csrf_field() !!}
                            <table class="table table-bordered table-stripped"> 
                                <tr>
                                    <th rowspan="2" >Sl.No.</th>
                                    <th rowspan="2" >Term</th>
                                    <th rowspan="2">Subject Code</th>
                                    <th rowspan="2">Subject</th>
                                    <th colspan="3" class="center-text">Marks</th>
                                    <th colspan="3" class="center-text">Re-evaluation Options</th>
                                </tr>
                                <tr>
                                    <th  class="center-text">
                                        Minimum
                                    </th>
                                    <th  class="center-text">
                                        Maximum
                                    </th>
                                    <th  class="center-text">
                                        Obtained
                                    </th>
                                    <th class="center-text">Re-Evaluation</th>
                                    <th class="center-text">Re-Totalling</th>
                                    <th class="center-text hidden">Photo-Copying</th>
                                </tr>
                                
                         
                                $slno =1; 
                                
                                
                                
                            
                                @foreach($newapplicant->applications as $application)
                                    @if(!is_null($application->subject)  && $application->subject->subjecttype_id == 1)
                                        <tr>
                                            <td>{{ $slno++ }}</td>
                                                                                         
                                            <td>
                                            {{$application->subject->syear}}
                                            </td>
                                            <td>
                                            {{$application->subject->scode}}
                                            </td>
                                            <td>
                                            {{$application->subject->sname}}
                                            </td>
                                            <td class="center-text">
                                            {{$application->subject->emin_marks}}
                                            </td>
                                            <td class="center-text">
                                            {{$application->subject->emax_marks}}
                                            </td>
                                            <td class="center-text @if($application->mark_ex < $application->subject->emin_marks) red-text @endif">
                                            {{$application->mark_ex}}
                                            </td>
                                            <td class="center-text">
                                            <input type="checkbox" class="reevaluation" name="reevaluation_{{$application->subject_id}}">
                                            </td>
                                            <td class="center-text">
                                            <input type="checkbox" class="retotal" name="retotal_{{$application->subject_id}}">
                                            </td>
                                            <td class="center-text hidden">
                                            <input type="checkbox" disabled class="photocopy" name="photocopy_{{$application->subject_id}}">
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                            <table style="border:0;width:100%;">
                                <tr>
                                    <td  style="text-align:right;">
                                    <button class="btn btn-primary btn-sm" id="showpayment" >Next</button>
                                    </td>
                                </tr>
                            </table>
                            <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        Payment 
                                    </div>
                                    <div class="modal-body">
                                    
                                        <input type="hidden" id="nber_id" name='nber_id' value="{{$candidate->approvedprogramme->programme->nber_id}}" />
                                        <input type="hidden" id="amount" name='amount'  />
                                        <input type="hidden" id="type" name='type' value="reevaluation"  />
                                        <input type="hidden" name="billing_name" id="billing_name" value="{{$candidate->name}}">
                                        <input type="hidden" name="billing_designation" id="billing_designation" value="Student">
                                        <input type="hidden" name="billing_tel" id="billing_tel" value="{{$candidate->contactnumber}}" >
                                        <input type="hidden" name="billing_email" id="billing_email" value="{{$candidate->email}}" >
                                        <table class="table table-bordered table-stripped"> 
                                        <tr>
                                            <th>Item</th>
                                            <th class="center-text">Number of Papers</th>
                                            <th class="center-text">Amount</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                Re-evaluation
                                            </td>
                                            <td id="reevaluation_count" class="center-text">

                                            </td>
                                            <td id="reevaluation_fee" class="center-text">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Re-totalling
                                            </td>
                                            <td id="retotalling_count" class="center-text">

                                            </td>
                                            <td id="retotalling_fee" class="center-text">

                                            </td>
                                        </tr>
                                        <tr class="hidden">
                                            <td>
                                                Photo Copying
                                            </td>
                                            <td id="photocopy_count" class="center-text">

                                            </td>
                                            <td id="photocopy_fee" class="center-text">
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <th></th>
                                            <th id="total_fee" class="center-text"></th>
                                        </tr>
                                        </table>
                                        <p>
                                        <input type="checkbox" id="declare" /> &nbsp; 
                                        I hereby declare that I have read all the instructions, which is in the web portal of RCI NBER regarding Online Application for Re-Evaluation / Re-Totalling.
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit"  id="pay" class="btn btn-primary pull-right" disabled >Pay Online</button>
                                        <button type="button" class="btn btn-default pull-left"  data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form> --}}
                    @endif 
                @endif
            </div>
        </div>
    </div>
@endsection