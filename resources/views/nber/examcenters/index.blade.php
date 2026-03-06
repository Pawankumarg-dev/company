@extends('layouts.smalltable')
@section('fields')


	<div class="form-group">
	
	 {{ Form::label('Exam Center', null, ['class' => 'control-label']) }}
	 
    <div>
   				<select  id="examcenter_id" name="examcenter_id" class="ls">
						<option value="0" disabled selected> Choose   Exam Center </option>
						
						@foreach($institutes->sortBy('user.username') as $l)
							
							<option value="{{$l->id}}" >{{$l->user->username}} - <i style="font-size: 8px!important;"> {{$l->name}} </i></option>
							
							
						@endforeach
					</select>
				</div>	
</div>
	
				

	
@endsection
@section('style')
<link rel="stylesheet" href="{{asset('css/chosen.min.css')}}">
@endsection
@section('hidden')
<input type="hidden" name="exam" value="{{$exam->id}}" />
@endsection
@section('table')
	<tr>
		<td>Name</td>
		<td>Code</td>
		
		<td>Exam Center Code</td>	
		<td>CLO(s) | Email ID | Password</td>	
		<td>Links</td>
	</tr>
	@foreach($collections as $c)
		<tr>
			{!! Form::tbText('name',$c) !!}
        	{!! Form::tbText('username',$c->user) !!}
        	
        	@if($c->examcenters()->onlyExam($exam->id)->count()>0)
        	
        	{!! Form::tbText('username',$c->examcenters()->onlyExam($exam->id)->first()->examcenter->user)
        	 !!}
        	@else
        	{!! Form::tbText('username',$c->user) !!}
        	@endif
        	<td>

        		@if($c->examcenters()->onlyExam($exam->id)->count()>0)
        			<?php $excenter = $c->examcenters()->onlyExam($exam->id)->first()->examcenter ; ?>	        	
	        	@else
	        		<?php $excenter = $c ; ?>
	        	@endif

	        	@if($excenter->clo)
		        	@foreach($excenter->clo as $clo)
		        		{{$clo->name}} | 
		        		{{$clo->user->username}} | 
		        		{{$clo->user->confirmation_code}} 
		        	@endforeach
		        @endif


        	</td>

        	{!! Form::tbEdit($link,$c) !!}
		</tr>
    @endforeach
@endsection
@section('script')
<script>
	$(document).ready(function() {
		$(".ls").chosen();
	});
</script>
@endsection


