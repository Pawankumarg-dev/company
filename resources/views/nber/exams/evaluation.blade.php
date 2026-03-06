@extends('layouts.smalltable')

@section('table')
	<tr>
		<td>Programme </td>
		<td>Name</td>
		<td>Action</td>
	</tr>
	@foreach($collections as $c)
		<tr>
        	{!! Form::tbText('coursename',$c) !!}
        	{!! Form::tbText('name',$c) !!}
        	<td> 
        		<a class="btn btn-xs btn-info" href="{{url('evaluation')}}/{{$id}}/{{$c->id}}">Select</a>
        	</td>

		</tr>
    @endforeach
@endsection

