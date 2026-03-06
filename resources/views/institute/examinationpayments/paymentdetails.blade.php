@extends('layouts.app')

@section('content')
    <script>
        $( document ).ready(function() {
            console.log( "ready!" );
           $('#payments_bottom').html($('#payments_top').html());
            $('#payments_top').addClass('hidden');
        });
    </script>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @include('common.errorandmsg')
                <div id="payments_top">
                <?php $totalamount = 0; $grandtotal =0; $firstyear = 0; $secondyear = 0; $nber1 =0; $nber2 =0 ; $nber3 =0; ?>
                @foreach($ins->approvedprogrammes as $ap)
                    <div class="div_{{$ap->id}} hidden">
                        @if($ap->academicyear_id != 11)
                            <h4>
                                        {{$ap->programme->course_name}}
                                        - Batch: {{$ap->academicyear->year}}
                            </h4>
                            <?php $totalamount = 0; $firstyear = 0; $secondyear = 0; $slno = 1;?>
                            <table class="table table-sm table-stripped table-bordered ">
                                <tr>
                                    <th rowspan="2">
                                        Sl.No.
                                    </th>
                                    <th rowspan="2">
                                        Candiate Name
                                    </th>
                                    <th rowspan="2">
                                        Enrolment Number
                                    </th>
                                    <th colspan="2">
                                        1st Year
                                    </th>
                                    <th colspan="2">
                                        2nd Year
                                    </th>
                                    <th rowspan="2">
                                        Total Papers
                                    </th>
                                    <th rowspan="2">
                                        Amount
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        Theory Papers
                                    </th>
                                    <th>
                                        Practical Papers
                                    </th>

                                    <th>
                                        Theory Papers
                                    </th>
                                    <th>
                                        Practical Papers
                                    </th>
                                </tr>
                            @foreach($ap->candidates as $c)
                                @if($c->subjects->count()>0)
                                <tr>
                                    <td>
                                        {{$slno}} <?php $slno++; ?>
                                    </td>
                                    <td>
                                        {{$c->name}}
                                    </td>
                                    <td>
                                        {{$c->enrolmentno}}
                                    </td>
                                    <td>
                                        <?php $count = $c->subjects->where('syear',1)->where('subjecttype_id',1)->count(); ?>
                                        @if($count>0)
                                            {{$count}}
                                        @endif
                                        <?php $firstyear += $count; ?>
                                    </td>
                                    <td>
                                        <?php $count = $c->subjects->where('syear',1)->where('subjecttype_id',2)->count(); ?>
                                        @if($count>0)
                                            {{$count}}
                                        @endif
                                        <?php $firstyear += $count; ?>
                                    </td>

                                    <td>
                                        <?php $count = $c->subjects->where('syear',2)->where('subjecttype_id',1)->count(); ?>
                                        @if($count>0)
                                            {{$count}}
                                        @endif
                                        <?php $secondyear += $count; ?>
                                    </td>
                                    <td>
                                        <?php $count = $c->subjects->where('syear',2)->where('subjecttype_id',2)->count(); ?>
                                        @if($count>0)
                                            {{$count}}
                                        @endif
                                        <?php $secondyear += $count; ?>
                                    </td>
                                    <td>
                                        <?php $count = $c->subjects->count(); ?>
                                        @if($count>0)
                                            {{$count}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($count>0)
                                            ₹ {{number_format($count * 100,2)}}
                                        @endif
                                        <?php $totalamount += 100 * $count; ?>
                                        <?php $grandtotal += 100 * $count; ?>
                                    </td>
                                </tr>
                            
                                @endif
                            @endforeach

                            @if($totalamount > 0)
                            <tr>

                            </tr>
                            <tr>
                                <th colspan="3" rowspan="2" style="text-align:right;">
                                    Total for 
                                    {{$ap->programme->course_name}}
                                </th>
                                <th  colspan="2" >First Year</th>
                                <th  colspan="2" >Second Year</th>
                                <th  colspan="2" >Total</th>
                            </tr>
                            <tr>
                                <th colspan="2">
                                        ₹ {{number_format($firstyear*100,2)}}
                                </th>
                                <th colspan="2">
                                        ₹ {{number_format($secondyear*100,2)}}
                                </th>
                                <th colspan="2">
                                    ₹ {{number_format($totalamount,2)}}
                                    @if($totalamount>0)
                                        <script>
                                            $(document).ready(function(){
                                                $('.div_{{$ap->id}}').removeClass('hidden');
                                            });
                                        </script>
                                    @endif
                                    @if($ap->programme->nber_id == 1)
                                        <?php $nber1 += $totalamount; ?>
                                    @endif
                                    @if($ap->programme->nber_id == 2)
                                        <?php $nber2 += $totalamount; ?>
                                    @endif
                                    @if($ap->programme->nber_id == 3)
                                        <?php $nber3 += $totalamount; ?>
                                    @endif
                                </th>
                            </tr>
                            @endif
                        </table>
                        @endif
                    </div>
                @endforeach
                <table class="table table-sm table-stripped table-bordered">
                    @if($nber1 > 0)
                    <tr>
                        <th colspan="9" style="text-align:right;">
                            NIEPMD, Chennai
                        </th>
                        <th>
                            ₹ {{number_format($nber1,2)}}
                        </th>
                    </tr>
                    @endif
                    @if($nber2 > 0)
                    <tr>
                        <th colspan="9" style="text-align:right;">
                            AYJNISHD, Mumbai
                        </th>
                        <th>
                            ₹ {{number_format($nber2,2)}}
                        </th>
                    </tr>
                    @endif

                    @if($nber3 > 0)
                    <tr>
                        <th colspan="9" style="text-align:right;">
                            NIEPVD, Dehradun
                        </th>
                        <th>
                            ₹ {{number_format($nber3,2)}}
                        </th>
                    </tr>
                    @endif
                    <tr>
                        <th colspan="9" style="text-align:right;">
                            Grand Total
                        </th>
                        <th>
                            ₹ {{number_format($grandtotal,2)}}
                        </th>
                    </tr>
                </table>
                </div>
                    <table  class="table table-sm table-stripped table-bordered">
                        <tr>
                            <th>NBER</th>
                            <th>Amount</th>
                            <th>Amount Paid</th>
                            <th>Method</th>
                            <th>Payment Details</th>
                            <th></th>
                        </tr>
                        @if($nber1 > 0)
                        <tr>
                            <td>
                                NIEPMD, Chennai
                            </td>
                            <td>
                                ₹ {{number_format($nber1,2)}}
                            </td>
                            <td>
                                        <?php $payment = $ins->exampayments->find(1); ?>
                                @if(!is_null($payment))
                                ₹ {{number_format($payment->pivot->amount,2)}}
                                @endif

                            </td>
                            <td>Online Payment</td>
                            <td>

                            </td>
                            <td>

                            </td>
                        </tr>
                        @endif
                        @if($nber2 > 0)
                        <form action="{{url('savepaymentdetails')}}" method="post">
                            {{csrf_field()}}

                        <tr>
                            <td>
                            AYJNISHD, Mumbai
                            </td>
                            <td>
                                ₹ {{number_format($nber2,2)}}
                            </td>
                            <td>
                                @if(!is_null($payment))
                                ₹ {{number_format($payment->pivot->amount,2)}}
                                @endif

                            </td>
                            <td>DD</td>
                            <td>
                                <small>Please enter the DD Details like bank name ,number, amount etc. If there is multiple DDs please include all.</small>
<br />  
                                           <b> <small>Total Amount</small> <br /></b>
                                            <input type="number" value="{{$nber2}}" name="amount" />
                                            <input type="text" name="nber_id" value="2" class="hidden">
                                            <input type="text" name="exam_id" value="22" class="hidden">
                                            <input type="text" name="payment_method" value="2" class="hidden">
                                            <br>
                                           <b> <small>Details</small> <br /></b>

                                <textarea name="details" id="nber2" cols="60" rows="10">@if(!is_null($payment)){{$payment->pivot->details}}@endif</textarea>
                            </td>
                            @if(!is_null($payment))
                                    <input type="text" name="id" value="{{$payment->pivot->id}}" class="hidden">
                                @else
                                        <input type="text" name="id" value="0" class="hidden">
                                @endif

                           {{-- <td>
                                @if(!is_null($payment) && $payment->nber_doc)
                                    <a href="{{url('/examdocs/')}}/{{$payment->nber_doc}}">Download</a>
                                @endif
                                
                                <input type="file" name="nber_doc">
                            </td> --}}
                            <td>
                                <button class="btn btn-primary" type="submit">@if(!is_null($payment)) Update @else Save @endif</button>
                            </td>
                        </tr>
                        </form>

                        @endif

                        @if($nber3 > 0)
                        <form action="{{url('savepaymentdetails')}}" method="post">
                        {{csrf_field()}}
                        <tr>
                            <td>
                            NIEPVD, Dehradun
                            </td>
                            <td>
                                ₹ {{number_format($nber3,2)}}
                            </td>
                            <td>
                                        <?php $payment = $ins->exampayments->find(3); ?>
                                @if(!is_null($payment))
                                ₹ {{number_format($payment->pivot->amount,2)}}
                                @endif

                            </td>
                            <td>NEFT</td>
                            <td>
                                <small>Please enter the NEFT Details like bank name ,transaction id, amount etc. If there is multiple transaction please include all.</small>
<br />
                                           <b> <small>Total Amount</small> <br /></b>
                                            <input type="number" value="{{$nber3}}" name="amount" /> <br />
                                            <input type="text" name="nber_id" value="3" class="hidden">
                                            <input type="text" name="exam_id" value="22" class="hidden">
                                            <input type="text" name="payment_method" value="3" class="hidden">
                                            <br>
                                           <b> <small>Details</small> <br /></b>

                                <textarea name="details" id="nber1" cols="60" rows="10">@if(!is_null($payment)){{$payment->pivot->details}}@endif</textarea>
                                @if(!is_null($payment))
                                    <input type="text" class="hidden" name="id" value="{{$payment->pivot->id}}">
                                @else
                                        <input type="text" class="hidden" name="id" value="0">
                                @endif

                            </td>
                          {{--  <td>

                                @if(!is_null($payment))
                                    <a href="{{url('/examdocs/')}}/{{$payment->nber_doc}}">Download</a>
                                @endif
                                
                                <input type="file" name="nber_doc">
                            </td> --}}
                            <td>
                                
                                <button class="btn btn-primary" type="submit">@if(!is_null($payment)) Update @else Save @endif</button>
                            </td>
                        </tr>
                          </form>
                        @endif
                    </table>
                <div id="payments_bottom">
                
                </div>
            </div>
        </div>
    </div>
@endsection