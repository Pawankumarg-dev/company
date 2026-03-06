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

                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Slno</th>
                        <th>RCI Code</th>
                        <th>
                            Institute
                        </th>
                        <th>
                            Programmes
                        </th>
                        <th>
                            Students (Registered)
                        </th>
                        <th>
                            Students (Verified)
                        </th>
                        <th>
                            Amount Received
                        </th>
                        <th>
                            Amount Received For (No of Students)
                        </th>
                        <th>Payment Details</th>
                        <th>Enrolment No</th>
                    </tr>
                    <?php $slno = 1; ?>
                    @foreach($institutes as $i)
                        <tr>
                            <td>{{$slno}} <?php $slno++ ; ?></td>
                            <td>
                               {{$i->rci_code}}
                            </td>
                            <td>{{$i->name}}</td>
                            <td>
                                <?php 
                                    $programmes= '';
                                    $students = 0;
                                    $verified_students = 0;
                                    $enrolmentnopending =0 ; 
                                    $amount = 0;
                                    foreach($i->approvedprogrammes as $ap){
                                        if($ap->programme->nber_id == $nber_id && $ap->academicyear_id == 11){
                                            $programmes .= $ap->programme->course_name . ' ';
                                            $students += $ap->candidates->whereIn('status_id',[1,2,4,5,6,7,8])->count();
                                            $verified_students += $ap->candidates->where('status_id',2)->count();
                                            $enrolmentnopending += $ap->candidates->where('status_id',2)->where('enrolmentno',null)->count();
                                        }
                                    }
                                    foreach($i->enrolmentfeepayments as $ef){
                                        if($ef->nber_id == $nber_id && $ef->orderstatus_id == 1){
                                            foreach($ef->orders as $o){
                                                if($o->order_status=='Success'){
                                                    $amount += $o->total_amount;
                                                }
                                            }
                                        }
                                    }
                                    echo $programmes;
                                ?>
                            </td>
                            <td class="center-text" >{{$students}}</td>
                            <td  class="center-text">{{$verified_students}}</td>
                            <td>
                                ₹ {{number_format($amount,2)}}
                            </td>
                            <td class="center-text">
                                {{number_format($amount/500,0)}}
                            </td>
                            <td>
                            <a href="{{url('institute/enrolmentfee')}}/{{$i->id}}">Payment Details</a>

                            </td>
                            <td>
                                @if($verified_students <= ($amount/500) && $enrolmentnopending > 0)
                                    <a href="{{url('generateenrolmentno')}}/{{$i->id}}">Generate Enrolment No</a>
                                @endif
                                @if($enrolmentnopending == 0)
                                    Generated
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection