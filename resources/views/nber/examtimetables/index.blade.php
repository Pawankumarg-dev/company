@extends('layouts.smalltable')
@section('fields')
	{!! Form::bsSelect('exam_id',$exams,'name','Exam') !!}
	{!! Form::bsSelect('programme_id',$programmes,'coursename','Programme') !!}
	{!! Form::bsSelect('subject_id',$subjects,'scode','Subject') !!}
	{!! Form::bsDateTime('startdate','Start Date Time (24Hr Format)') !!}
	{!! Form::bsDateTime('enddate','End Date Time (24Hr Format)') !!}
@endsection
@section('table')
	<tr>
		<td>Exam</td>
		<td>Exam Academic Yr</td>
		<td>Exam Type</td>
		<td>Programme</td>
		<td>Subject Code</td>
		<td>Subject</td>
		<td>Starting  Date Time</td>
		<td>Ending Date Time</td>
		<td>Action</td>
	</tr>
	@foreach($collections as $c)
		<tr>
			{!! Form::tbSelect('exam','name',$c) !!}
        	{!! Form::tbSelect('academicyear','year',$c->exam) !!} 
        	{!! Form::tbSelect('examtype','name',$c->exam) !!} 

        	{!! Form::tbSelect('programme','coursename',$c->subject) !!} 
        	{!! Form::tbSelect('subject','scode',$c) !!} 
        	{!! Form::tbSelect('subject','sname',$c) !!} 
        	{!! Form::tbText('startdate',$c) !!}
        	{!! Form::tbText('enddate',$c) !!}
        	{!! Form::tbEdit($link,$c) !!}
		</tr>
    @endforeach
@endsection
@section('editscript')
	{!! Form::tbEditscript('startdate',$link,'input') !!}
	{!! Form::tbEditscript('enddate',$link,'input') !!}
	{!! Form::tbEditscript('subject_id',$link,'input') !!}
	{!! Form::tbEditscript('exam_id',$link,'input') !!}
@endsection
@section('script')
<script>
	$(document).ready(function() {
		$(".ls").chosen();
	});
</script>
@endsection
@section('style')
<link rel="stylesheet" href="{{asset('css/chosen.min.css')}}">
@endsection