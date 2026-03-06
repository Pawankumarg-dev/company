@extends('layouts.smalltable')
@section('fields')
	{!! Form::bsText('name','Name') !!}
	<input type="hidden" name="academicyear_id" value="{{$academicyear_id}}">
@endsection
@section('table')
	<tr>
		<td>Name</td>
		<td>Edit</td>
		<td>Settings</td>
	</tr>
	@foreach($collections as $c)
		<tr>
        	{!! Form::tbText('name',$c) !!}
        	{!! Form::tbEdit($link,$c) !!}
			<td>
				<a class="btn btn-primary btn-xs" href="batch/settings/{{$c->id}}">Settings</a>
			</td>
		</tr>
    @endforeach
@endsection
@section('editscript')
	{!! Form::tbEditscript('name',$link,'input') !!}
	
@endsection