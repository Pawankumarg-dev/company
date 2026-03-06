@extends('layouts.smalltable')
@section('fields')
	{!! Form::bsText('year','Academic Year') !!}
    {!! Form::bsSelect('current',$yesno,'value','Current Academic year?') !!}	
	{!! Form::bsDate('accademicsession','Academic Session Begins on') !!}
    {!! Form::bsSelect('incidentalpayment',$yesno,'value','Open Incidental Payments') !!}			
@endsection
@section('table')
	<tr>
		<th>Academic Year</th>
		<th>Current?</th>
		<th>Academic Session Begins on</th>
		<th>Edit Name</th>
		<th style="display:none;">Defined Incidental Payments?</th>
		<th>Affiliation Fee</th>
		<th>Configure</th>
	</tr>
	@foreach($collections as $c)
		<tr>
        	{!! Form::tbText('year',$c) !!}
			<td>@if($c->current == 1) <span class="btn btn-xs btn-primary">  Yes </span> @endif 
                <input type="hidden" id="current_{{$c->id}}" value="{{$c->current}}">
            </td>
        	{!! Form::tbText('accademicsession',$c) !!}
        	{!! Form::tbEdit($link,$c) !!}
			<td style="display:none;">@if($c->incidentalpayment == 1) <span class="btn btn-xs btn-primary"> Yes</span> @else  <span class="btn btn-xs btn-danger"> No</span> @endif 
                <input type="hidden" id="current_{{$c->id}}" value="{{$c->current}}">
            </td>
			<td>
				<a href="{{url('defineincidentalpayments')}}?academicyear={{$c->id}}" class="btn btn-xs btn-primary">Affiliation Fee</a>
			</td>

			<td>
				@if(\App\Academicyear::where('current',1)->first()->id == $c->id)
				<a href="{{url('examcontrols')}}?academicyear={{$c->id}}" class="btn btn-xs btn-primary">Configure Batches</a>
				@endif
			</td>
		</tr>
    @endforeach
@endsection
@section('editscript')
	{!! Form::tbEditscript('accademicsession',$link,'input') !!}
	{!! Form::tbEditscript('year',$link,'input') !!}
	{!! Form::tbEditscript('current',$link,'select') !!}
@endsection