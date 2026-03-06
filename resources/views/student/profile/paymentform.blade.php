<form class="form-horizontal"  onsubmit="return validateForm()" action="{{url('/institute/affiliationfee')}}" method='get' >
    {!! csrf_field() !!}
    <input type="hidden" id="nber_id" name='nber_id' value="{{ $c->approvedprogramme->programme->nber_id }}"  />
    <input type="hidden" name="id" value={{ $c->id }}>
    <input type="hidden" id="amount" name='amount' value="500" />
    <input type="hidden" id="type" name='type' value="enrolment_student"  />
    <input type="hidden" class="form-control" name="billing_name" id="billing_name"  value={{ $c->name }}>
    <input type="hidden" class="form-control" name="billing_designation" id="billing_designation" value="Student" >
    <input type="hidden" class="form-control" name="billing_tel" id="billing_tel" value={{ $c->contactnumber }}>
    <input type="hidden" class="form-control" name="billing_email" id="billing_email" value="{{ $c->email }}">
    <button type="submit"    id="submit" class="btn btn-primary pull-right btn-xs" >Pay Online</button>
</form>