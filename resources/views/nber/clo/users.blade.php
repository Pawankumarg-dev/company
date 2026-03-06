@extends('layouts.smalltable')

@section('table')
	<tr>
		<td>Sl No</td>
		<td>Name</td>
		<td>Email Id</td>
		
		<td>Password</td>
		<td>Exam Center(s)</td>
	</tr>
    <?php $count = 1; ?>
	@foreach($collections as $c)
		<tr>
            <td>
                {{$count}}
                <?php $count += 1; ?>
            </td>
        	{!! Form::tbText('name',$c) !!}
        	@if($c->user)
        	{!! Form::tbText('email',$c->user) !!} 
        	
        	{!! Form::tbText('confirmation_code',$c->user) !!} 
        	@endif
        	<td>
        	@foreach($c->institute as $institute)
             {{$institute->user->username}}, 
            @endforeach
        	</td>
		</tr>
    @endforeach
@endsection
