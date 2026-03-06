@extends('layouts.smalltable')
@section('fields')
	{!! Form::bsText('issue','Issue') !!}
	{!! Form::bsText('description','Issue') !!}
	{!! Form::bsText('reported_by','Reported By') !!}
	{!! Form::bsText('solution','Solution') !!}
@endsection
@section('table')
	<tr>
        <th>Created At</th>
		<th>Issue</th>
        <th>description</th>
		<th>Reported By</th>
		<th>Solution</th>
		<th>Solved On</th>
        <th></th>
	</tr>
	@foreach($collections as $c)
		<tr>
        	{!! Form::tbText('created_at',$c) !!}
        	{!! Form::tbText('issue',$c) !!}
        	{!! Form::tbText('description',$c) !!}
        	{!! Form::tbText('reported_by',$c) !!}
        	{!! Form::tbText('solution',$c) !!}
            {!! Form::tbText('solved_at',$c) !!}
            {!! Form::tbEdit($link,$c) !!}
		</tr>
    @endforeach
@endsection
@section('createscript')
$('.showhidenber').removeClass('hidden');
@endsection

@section('editscript')
	{!! Form::tbEditscript('issue',$link,'input') !!}
	{!! Form::tbEditscript('description',$link,'input') !!}
	{!! Form::tbEditscript('reported_by',$link,'input') !!}
	{!! Form::tbEditscript('solution',$link,'input') !!}
	$('.showhidenber').addClass('hidden');
@endsection