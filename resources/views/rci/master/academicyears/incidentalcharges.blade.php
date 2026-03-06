@extends('layouts.smalltable')
@section('fields')
	{!! Form::bsText('fee','Fee') !!}
@endsection
@section('style')
<style>
    #incidentalcharges {display:none;}
</style>
@endsection
@section('table')
	<tr>
		<th>Programme</th>
		<th>No of Terms</th>
		<th>Fee</th>
		<th>Edit</th>
	</tr>
	@foreach($collections as $c)
		@if($c->programme->active_status == 1)
			<tr>
				{!! Form::tbText('name',$c->programme) !!}
				{!! Form::tbText('term',$c) !!}
				{!! Form::tbText('fee',$c) !!}
				{!! Form::tbEdit($link,$c) !!}
			</tr>
		@endif
    @endforeach
@endsection
@section('editscript')
	{!! Form::tbEditscript('fee',$link,'input') !!}
@endsection