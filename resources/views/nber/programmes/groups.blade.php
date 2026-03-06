@extends('layouts.smalltable')
@section('fields')
	{!! Form::bsText('name','Name') !!}
	{!! Form::bsNumber('noofterms','Total Number of Terms') !!}
	{!! Form::bsText('minage','Minimum Age') !!}
	{!! Form::bsSelect('academicsystem_id',$academicsystems,'name','Academic System') !!}			
	{{ Form::bsSelect('tenth',$yesno,'value','10th Certificate') }}
	{{ Form::bsSelect('twelveth',$yesno,'value','12th Certificate') }}
@endsection
@section('table')
	<tr>
	<th>Name</th>
		<th>Total Number of Terms</th>
		<th>Academic System</th>
		<th>Minium Age</th>
		<th>10th Certificate</th>
		<th>12th Certificate</th>
		<th>Action</th>
	</tr>
	@foreach($collections as $c)
		<tr>
        	{!! Form::tbText('name',$c) !!}
        	{!! Form::tbText('noofterms',$c) !!}
        	{!! Form::tbSelect('academicsystem','name',$c) !!} 
        	{!! Form::tbText('minage',$c) !!}
			<td>@if($c->tenth == 1) Required @else Not Mandatory @endif 
                <input type="hidden" id="tenth_{{$c->id}}" value="{{$c->tenth}}">
            </td>
			<td>@if($c->twelveth == 1) Required @else Not Mandatory @endif 
                <input type="hidden" id="twelveth_{{$c->id}}" value="{{$c->twelveth}}">
            </td>
        	{!! Form::tbEdit($link,$c) !!}
		</tr>
    @endforeach
@endsection
@section('editscript')
	{!! Form::tbEditscript('name',$link,'input') !!}
	{!! Form::tbEditscript('noofterms',$link,'input') !!}
	{!! Form::tbEditscript('minage',$link,'input') !!}
	{!! Form::tbEditscript('academicsystem_id',$link,'select') !!}
	{!! Form::tbEditscript('twelveth',$link,'select') !!}
	{!! Form::tbEditscript('tenth',$link,'select') !!}
	
@endsection