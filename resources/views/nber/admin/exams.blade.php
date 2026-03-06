@extends('layouts.smalltable')
@section('fields')
	{!! Form::bsText('name','Name') !!}
	
@endsection
@section('table')
	<tr>
		<td>Name</td>
		<td>Total Number of Terms</td>
		<td>Academic System</td>
		
		<td>Action</td>
	</tr>
	@foreach($collections as $c)
		<tr>
        	{!! Form::tbText('name',$c) !!}
        	{!! Form::tbText('noofterms',$c) !!}
        	{!! Form::tbSelect('academicsystem','name',$c) !!} 
        	
        	{!! Form::tbEdit($link,$c) !!}
		</tr>
    @endforeach
@endsection
@section('editscript')
	{!! Form::tbEditscript('name',$link,'input') !!}
	{!! Form::tbEditscript('noofterms',$link,'input') !!}
	{!! Form::tbEditscript('academicsystem_id',$link,'select') !!}
	
@endsection