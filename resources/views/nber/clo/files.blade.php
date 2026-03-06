@extends('layouts.smalltable')
@section('fields')
	{!! Form::bsText('description','Description') !!}
	{!! Form::bsSelect('exam_id',$exams,'name','Exam') !!}			
	
@endsection
@section('table')
	<tr>
		
		<td>Description</td>
		<td>Exam</td>
		
		<td>Action</td>
	</tr>
	@foreach($collections as $c)
		<tr>
        	{!! Form::tbText('description',$c) !!}
        	
        	{!! Form::tbText('name',$c->exam) !!} 
        	
        	
        	{!! Form::tbEdit($link,$c) !!}
		</tr>
    @endforeach
@endsection
@section('editscript')
	{!! Form::tbEditscript('description',$link,'input') !!}
	{!! Form::tbEditscript('exam_id',$link,'select') !!}
	
@endsection