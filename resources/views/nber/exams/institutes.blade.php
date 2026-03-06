@extends('layouts.smalltable')

@section('table')
	<tr>
		<td>Institute </td>
		<td>Name</td>
		<td>Action</td>
	</tr>
	@foreach($collections as $c)
		<tr>
        	{!! Form::tbText('username',$c->user) !!}
        	{!! Form::tbText('name',$c) !!}
        	<td> 
        		<a class="btn btn-xs btn-info" href="{{url('evaluation')}}/{{$exam_id}}/{{$programme_id}}/{{$c->id}}">Marks Entry</a>
        	</td>

		</tr>
    @endforeach
@endsection

