@extends('layouts.smalltable')
@section('fields')
	
@endsection
@section('table')
	<tr>
	<th>Institute Code</th>
	<th>Institute</th>
		<th>Type</th>
		<th>Issue</th>
		<th>Contact Perons</th>
		<th>Contact Number</th>
	</tr>
	@foreach($collections as $c)
		<tr>
        	{!! Form::tbText('username',$c->institute->user) !!}
        	{!! Form::tbText('name',$c->institute) !!}
        	{!! Form::tbText('issuetype',$c) !!}
        	{!! Form::tbText('comment',$c) !!}
        	{!! Form::tbText('contactperson',$c) !!}
        	{!! Form::tbText('contactnumber',$c) !!}
        	{!! Form::tbEdit($link,$c) !!}
		</tr>
    @endforeach
@endsection
@section('createscript')
$('.showhidenber').removeClass('hidden');
@endsection

@section('editscript')
@endsection