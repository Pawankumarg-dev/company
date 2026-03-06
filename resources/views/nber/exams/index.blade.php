@extends('layouts.smalltable')
@section('fields')
	{!! Form::bsText('name','Exam (name)') !!}
	{!! Form::bsDate('date','Starting Date') !!}
	{!! Form::bsSelect('examtype_id',$examtypes,'name','Exam Type') !!}
	{!! Form::bsSelect('academicyear_id',$academicyears,'year','Academic Year') !!}
	<div class="form-group">
		<label>Programme Groups</label>
		<div>
			<select class="chosen-select" multiple="true" id="programmegroups" name='programmegroups[]' placeholder='Select Groups'>
				@foreach($programmegroups as $pg)
					<option value="{{$pg->id}}" >{{$pg->name}}</option>
				@endforeach
			</select>
		</div>
	</div>
@endsection
@section('table')
	<tr>
		<td>Name</td>
		{{--}}<td>Starting Date</td>--}}
		<td>Academic Year</td>
		<td>Exam Type</td>
		<td>Prograamme Groups</td>
		<td>Links</td>
		<td>Status/Action</td>
		<td>Edit</td>
	</tr>
	@foreach($collections as $c)
		<tr>
        	{!! Form::tbText('name',$c) !!}
			{{--}}{!! Form::tbText('date',$c) !!}--}}
        	{!! Form::tbSelect('academicyear','year',$c) !!} 
        	{!! Form::tbSelect('examtype','name',$c) !!} 
        	<td>
        		@foreach($c->programmegroups as $pg)
        			{{$pg->name}} <br /> 
        		@endforeach
        	</td>
        	<td> 
        		<a class="btn btn-xs btn-success" href="{{url('examtimetables')}}?exam={{$c->id}}">Time table</a>
                <a class="btn btn-xs btn-info" href="{{url('examcenters')}}?exam={{$c->id}}">Exam Centers</a>
        		<a class="btn btn-xs btn-danger" href="{{url('questionpapers')}}?exam={{$c->id}}">Question Papers</a>
        		<a class="btn btn-xs btn-warning" href="{{url('evaluation')}}/{{$c->id}}">Mark Entry</a>
				<a class="btn btn-xs btn-default" href="{{url('marksverify')}}/{{$c->id}}">Marks Verify</a>
        	</td>
        	<td>
        		
        			@if($c->status_id!='1')
        				<a class="btn btn-xs btn-success" href="{{url('publishexam')}}/{{$c->id}}">Activate</a>
        			@else
        				Active <a class="btn btn-xs btn-danger" href="{{url('publishexam')}}/{{$c->id}}">Inactivate</a>
        			@endif
        		
        	</td>
        	{!! Form::tbEdit($link,$c) !!}
		</tr>
    @endforeach
@endsection
@section('editscript')
	{!! Form::tbEditscript('name',$link,'input') !!}
	{!! Form::tbEditscript('date',$link,'input') !!}
	{!! Form::tbEditscript('examtype_id',$link,'select') !!}
	{!! Form::tbEditscript('academicyear_id',$link,'select') !!}

@endsection