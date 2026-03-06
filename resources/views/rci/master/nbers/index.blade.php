@extends('layouts.smalltable')
@section('fields')
	{!! Form::bsText('code','Code') !!}
	{!! Form::bsText('name','Name') !!}
	{!! Form::bsText('name_code','Short Name') !!}
	{!! Form::bsText('address','Address') !!}
	
@endsection
@section('table')
	<tr>
		<th>Code</th>
		<th>Name</th>
		<th>Short Name</th>
		<th>Address</th>
		<th>Action</th>
	</tr>
	@foreach($collections as $c)
		<tr>
        	{!! Form::tbText('code',$c) !!}
        	{!! Form::tbText('name',$c) !!}
        	{!! Form::tbText('name_code',$c) !!}
        	{!! Form::tbText('address',$c) !!}
        	{!! Form::tbEdit($link,$c) !!}
		</tr>
    @endforeach
@endsection
@section('editscript')
	{!! Form::tbEditscript('name',$link,'input') !!}
	{!! Form::tbEditscript('code',$link,'input') !!}
	{!! Form::tbEditscript('name_code',$link,'input') !!}
	{!! Form::tbEditscript('address',$link,'input') !!}
@endsection