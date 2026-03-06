@extends('layouts.smalltable')
@section('fields')
	{!! Form::bsText('name','Exam Type') !!}
@endsection
@section('table')
	<tr>
		<td>Name</td>
		<td>Action</td>
	</tr>
	@foreach($collections as $c)
		<tr>
        	{!! Form::tbText('name',$c) !!}
        	{!! Form::tbEdit($link,$c) !!}
		</tr>
    @endforeach
@endsection
@section('editscript')
	{!! Form::tbEditscript('name',$link,'input') !!}
@endsection