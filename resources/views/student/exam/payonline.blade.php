

    <h1>
        @if($payment=="Fresh")
            Please wait.. Redirecting to Payment Gateway.
        @else
            Please wait.. Checking the payment status...
        @endif
    </h1>
<form name="redirect" style="display: none;" class="form-horizontal"   action="{{url('/institute/affiliationfee/')}}" method='get'  class="hidden">
    {!! csrf_field() !!}
    <input type="hidden" id="nber_id" name='nber_id' value="{{$candidate->approvedprogramme->programme->nber_id}}" />
    <input type="hidden" id="type" name='type' value="examfee"  />
    <input type="hidden" name="billing_name" id="billing_name" value="{{$candidate->name}}">
    <input type="hidden" name="billing_designation" id="billing_designation" value="Student">
    <input type="hidden" name="billing_tel" id="billing_tel" value="{{$candidate->contactnumber}}" >
    <input type="hidden" name="billing_email" id="billing_email" value="{{$candidate->email}}" >
    <input type="hidden" name="applicant_id" value="{{$applicant->id}}">
    <input type="hidden" name="payment" value="{{$payment}}">
    <input type="hidden" name="exam_id" value="28">
    <button class="btn btn-sm btn-primary hidden" style="display: none;" type="submit">Pay Online</button> <br />
</form>
</div>
  
<script language='javascript'>document.redirect.submit();</script>
