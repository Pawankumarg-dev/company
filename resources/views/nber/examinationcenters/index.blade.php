@extends('layouts.smalltable')
@section('fields')
{{--{!! Form::bsText('code','Exam Center Code') !!}
{!! Form::bsText('address','Exam Center') !!}
{!! Form::bsText('state','State') !!}
{!! Form::bsText('contactperson','Contact Person') !!}
{!! Form::bsText('contactnumber1','Contact Number') !!}
{!! Form::bsText('email1','Email ID') !!}
{!! Form::bsText('cloname','CLO Name') !!}
{!! Form::bsText('clocontact','CLO Contact Number') !!}
{!! Form::bsText('cloemail','CLO Email Address') !!} --}}
@endsection
@section('table')
	<tr>
		<th>Slno</th>
	    <th>Exam Center Code</th>
	    <th>Exam Center</th>
		<th>State</th>
		{{--<th>Contact Person</th>
		<th>Contact Number</th>
		<th>Email</th>
		<th>CLO Name</th>
		<th>CLO Contact Number</th>
		<th>CLO Email</th> --}}
        <th>Evaluation Center</th>
		<th></th>
	</tr>
	<?php $slno = 1; ?>
	@foreach($collections->sortBy('code') as $c)
		<tr>
			<td>{{$slno}}
				<?php $slno++ ; ?>
			</td>
        	{!! Form::tbText('code',$c) !!}
        	{!! Form::tbText('address',$c) !!}
        	{!! Form::tbText('state',$c) !!}
        	{{--{!! Form::tbText('contactperson',$c) !!}
        	{!! Form::tbText('contactnumber1',$c) !!}
        	{!! Form::tbText('email1',$c) !!}
        	{!! Form::tbText('cloname',$c) !!}
        	{!! Form::tbText('clocontact',$c) !!}
        	{!! Form::tbText('cloemail',$c) !!} --}}
			<td>
				@if($c->evaluationcenter->count()>0)
					{{$c->evaluationcenter->first()->code}} - {{$c->evaluationcenter->first()->name}} 
				@endif
				<form action="{{url('nber/examcenter/changeevaluationcenter')}}" method="post">
                {{csrf_field()}}

					<input type="hidden" name="externalexamcenter_id" value="{{$c->id}}">
					<select name="evaluationcenter_id">
						<option value="0">Please choose to add or change</option>
						@foreach($evaluationcenters as $ec)
							<option value="{{$ec->id}}">{{$ec->code}} - {{$ec->name}}</option>
						@endforeach
					</select>
					<button type="submit" class="btn btn-primary btn-xs" > Update</button>
				</form>
			</td>
        	{!! Form::tbEdit($link,$c) !!}
		</tr>
    @endforeach
@endsection

@section('editscript')
{!! Form::tbEditscript('code',$link,'input') !!}
{!! Form::tbEditscript('address',$link,'input') !!}
{!! Form::tbEditscript('state',$link,'input') !!}
{!! Form::tbEditscript('contactperson',$link,'input') !!}
{!! Form::tbEditscript('contactnumber1',$link,'input') !!}
{!! Form::tbEditscript('email1',$link,'input') !!}
{!! Form::tbEditscript('cloname',$link,'input') !!}
{!! Form::tbEditscript('clocontact',$link,'input') !!}
{!! Form::tbEditscript('cloemail',$link,'input') !!}

@endsection