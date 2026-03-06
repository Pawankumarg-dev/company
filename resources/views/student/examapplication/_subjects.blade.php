
@foreach($na->applications as $subject)

@if($subject->additional_application == $additional)
<tr>
    <td>{{$slno}} <?php $slno++; ?></td>
<td>
    <?php 
    if(!is_null($subject->alternative_paper)){
        $alternative = \App\Subject::find($subject->alternative_paper);
    }else{
        $alternative = null;
    }
    ?>
    
    {{$subject->subject->scode}}
</td>
<td>
    @if(is_null($alternative))
    {{$subject->subject->sname}}
    @else
    {{$alternative->sname}}
    @endif
</td>
<td>
    {{$subject->subject->syear}}
    @if($subject->subject->syear==1)
        <?php $cfy++ ; ?>
    @endif
    @if($subject->subject->syear==2)
        <?php $csy++ ; ?>
    @endif
</td>
<td>
    @if($subject->subject->is_external==1)
    ₹ {{number_format(100,0)}}
    @endif
</td>
@if($applicant->payment_status == 1 && $applicant->block != 1  && $applicant->malpractice != 1 && $applicant->attendance == 1)
<td class="text-center">{{$subject->internal_mark}}</td>
<td class="text-center">{{$subject->external_mark}}</td>
<td class="text-center">{{$subject->grace}}
</td>
<td class="text-center">
    @if($subject->result_id == 1)
        <span style="color:green;">Pass</span>
    @endif
    @if(!is_null($subject->result_id) && $subject->result_id == 0)
        <span style="color:red;">Fail</span>
    @endif
</td>

@endif
</tr>
@endif
@endforeach

<tr>
    <td colspan="4">Total</td>
    <td>₹ {{number_format($total ,0)}}</td>
    </tr><tr>
    <td colspan="4">
    </td>
    <td colspan="1">
        @if($payment_status == 1)
            Paid
        @else
            <form class="form-horizontal"   action="{{url('/institute/affiliationfee/')}}" method='get' >
                {!! csrf_field() !!}
                <input type="hidden" id="nber_id" name='nber_id' value="{{$candidate->approvedprogramme->programme->nber_id}}" />
                <input type="hidden" id="amount" name='{{$total}}'  />
                @if($additional == 0)
                    <input type="hidden" id="type" name='type' value="examapplication"  />
                @else
                    <input type="hidden" id="type" name='type' value="add_examapplication"  />
                @endif
                <input type="hidden" name="billing_name" id="billing_name" value="{{$candidate->name}}">
                <input type="hidden" name="billing_designation" id="billing_designation" value="Student">
                <input type="hidden" name="billing_tel" id="billing_tel" value="{{$candidate->contactnumber}}" >
                <input type="hidden" name="billing_email" id="billing_email" value="{{$candidate->email}}" >
                <input type="hidden" name="newapplicant_id" value="{{$na->id}}">
                <button class="btn btn-sm btn-primary" type="submit">Pay Online</button> <br />
                {{--<a href="javascript:cancelApplication({{$na->id}})" class="btn btn-sm btn-warning" style="margin-top:3px;">Cancel Application</button>--}}
            </form>
            {{--<a href="{{url('student/exam/recheckStatusall')}}/{{$na->id}}" class="btn btn-sm btn-primary"  style="margin-top:3px;">Refresh Payment Status</a>  --}}
        @endif
    </td>
    </tr>