@extends('layouts.smalltable')
@section('fields')
	{!! Form::bsText('rci_code','Institute Code (RCI)') !!}
	{!! Form::bsText('username','Institute Code(NI), Also the User Name for  TTI to Login to OEMS') !!}
	{!! Form::bsText('name','Name') !!}
	{!! Form::bsText('confirmation_code','Password') !!}
	{!! Form::bsText('enrolmentcode','Enrolment Code') !!}
	{!! Form::bsText('contactnumber1','Contact Number') !!}
	{!! Form::bsText('contactnumber2','Alternative Contact Number') !!}
	{!! Form::bsText('email','Email') !!}
	{!! Form::bsText('street_address','Address') !!}
	{!! Form::bsText('pincode','PIN Code') !!}
@endsection
@section('table')
	<tr>
	<th>Status</th>
		<th>Institue Code (Provided by RCI)</th>
		<th>Institue Code (Provided by NI)</th>
		<th>Name</th>
		<th>Enrolment Code</th>
		<th>Contact Number #1</th>
		<th>Contact Number #2</th>
		<th>Email</th>
		<th>Address</th>
		<th>PIN Code</th>
		<th>Edit</th>
	</tr>
	@foreach($collections as $c)
		<tr>
			<td>
				<input type="hidden" id="active_status_{{$c->id}}"  value="{{$c->user->confirmation_code}}" />
				@if($c->active_status == 1)
				<span class="btn btn-xs btn-primary">Active</span>
				@else
				<span class="btn btn-xs btn-warning">Not active</span>
				@endif
			</td>
        	{!! Form::tbText('usrname',$c->user) !!}
			<td>
				<input type="hidden" id="username_{{$c->id}}" value="{{$c->user->username}}" />
				{{$c->user->username}}
			</td>
        	{!! Form::tbText('name',$c) !!}
        	{!! Form::tbText('enrolmentcode',$c) !!}
        	{!! Form::tbText('contactnumber1',$c) !!}
        	{!! Form::tbText('contactnumber2',$c) !!}
        	{!! Form::tbText('email',$c) !!}
        	{!! Form::tbText('street_address',$c) !!}
        	{!! Form::tbText('pincode',$c) !!}
        	{!! Form::tbEdit($link,$c) !!}
		</tr>
    @endforeach
@endsection
@section('editscript')
	{!! Form::tbEditscript('name',$link,'input') !!}
	{!! Form::tbEditscript('username',$link,'input') !!}
	{!! Form::tbEditscript('enrolmentcode',$link,'input') !!}
	{!! Form::tbEditscript('contactnumber1',$link,'input') !!}
	{!! Form::tbEditscript('contactnumber2',$link,'input') !!}
	{!! Form::tbEditscript('email',$link,'input') !!}
	{!! Form::tbEditscript('street_address',$link,'input') !!}
	{!! Form::tbEditscript('confirmation_code',$link,'input') !!}
	{!! Form::tbEditscript('pincode',$link,'input') !!}
	{!! Form::tbEditscript('rci_code',$link,'input') !!}
	$('input[name="username"]').attr('disabled',true);
@endsection