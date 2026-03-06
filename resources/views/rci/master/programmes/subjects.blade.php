@extends('layouts.smalltable')
@section('fields')
	<input type='hidden' name='programme_id' value='{{$pid}}' /> 
	
	<input type='hidden' name='syllabus_type' value='New' /> 
	{!! Form::bsText('sortorder','Sort Order') !!}
	{!! Form::bsText('scode','Code') !!}
	{!! Form::bsText('sname','Name') !!}	
	{!! Form::bsSelect('subjecttype_id',$subjecttypes,'type','Type') !!}
	{!! Form::bsText('syear','Term') !!}	
	{!! Form::bsText('imin_marks','Internal Minimum Marks') !!}	
	{!! Form::bsText('imax_marks','Internal Maximum Marks') !!}	
	{!! Form::bsText('emin_marks','External Mimimum Marks') !!}	
	{!! Form::bsText('emax_marks','External Maximum Marks') !!}	
@endsection
@section('table')
	<tr>
		<th>Sort Order</th>
		<th>Code</th>
		<th>Name</th>	
		<th>Type</th>
		<th>Term</th>
		<th>In Min Marks</th>
		<th>In Max Marks</th>
		<th>Ex Min Marks</th>
		<th>Ex Max Marks</th>	
		<th>Action</th>
	</tr>
	@foreach($collections as $c)
		<tr>
			{!! Form::tbText('sortorder',$c) !!}
        	{!! Form::tbText('scode',$c) !!}
        	{!! Form::tbText('sname',$c) !!}
        	{!! Form::tbSelect('subjecttype','type',$c) !!}         	
        	{!! Form::tbText('syear',$c) !!}
        	{!! Form::tbText('imin_marks',$c) !!}
        	{!! Form::tbText('imax_marks',$c) !!}
        	{!! Form::tbText('emin_marks',$c) !!}
        	{!! Form::tbText('emax_marks',$c) !!}
        	{!! Form::tbEdit($link,$c) !!}
		</tr>
    @endforeach
@endsection
@section('editscript')
	{!! Form::tbEditscript('sortorder',$link,'input') !!}
	{!! Form::tbEditscript('scode',$link,'input') !!}
	{!! Form::tbEditscript('sname',$link,'input') !!}	
	{!! Form::tbEditscript('subjecttype_id',$link,'select') !!}
	{!! Form::tbEditscript('syear',$link,'input') !!}	
	{!! Form::tbEditscript('imin_marks',$link,'input') !!}	
	{!! Form::tbEditscript('imax_marks',$link,'input') !!}	
	{!! Form::tbEditscript('emin_marks',$link,'input') !!}	
	{!! Form::tbEditscript('emax_marks',$link,'input') !!}	
@endsection