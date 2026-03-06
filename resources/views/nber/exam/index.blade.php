@extends('layouts.approvaltable')
@section('fields')
	
@endsection
@section('table')
@if(Session::get('academicyear_id')==1)
	<tr>
		<th rowspan="2"  style="vertical-align: middle;" >Programme</th>
		<th colspan="3">Candidate</th>

		<th rowspan="2"  style="vertical-align: middle;">Institute</th>
		<th rowspan="2"  style="vertical-align: middle;">Term</th>
		<th rowspan="2"  style="vertical-align: middle;">Subjects</th>	
		<th rowspan="2"  style="vertical-align: middle;">Count</th>
		<th rowspan="2"  style="vertical-align: middle;">Status</th>
		<th rowspan="2"  style="vertical-align: middle;">Action</th>
	</tr>
	<tr>
		<td>Name</td>
		<td>Enrolment#</td>
		<td>Status</td>
	</tr>
	@foreach($collections as $c)
		<tr>
        	
        	<td> 
        		
        			{{$c->approvedprogramme->programme->course_name}} 
        		
        	</td>
        	<td> {{$c->candidate->name}} </td>
        	<td> {{$c->candidate->enrolmentno}} </td>

        	<td> {!! $c->candidate->statushtml() !!} </td>
        	<td> {{$c->approvedprogramme->institute->user->username }} </td>

        	
        	{!! Form::tbText('term',$c) !!}
        	<td> 
        		<font style="font-size: 9px!important;">
        		<?php
        		$subs = explode(',', $c->subjects) ;
        		foreach($subs as $sub){
        			echo $subjects->find($sub)->scode . ', ';
        		}

        		?>
        	</font>
        	   </td>
        	

        	<td>
        		<?php echo count($subs) ?>
        	</td>
        	<td>
        		{!! $c->status->statushtml() !!}
       		</td>
        	<td>
        			@if($c->status_id != '2')
									<a href="{{url('/exappstatus/2/')}}?apid={{$c->approvedprogramme->id}}&cid={{$c->candidate->id}}&term={{$c->term}}" class="btn btn-success btn-xs">Approve</a>
									@endif
									@if($c->status_id != '3')
									<a href="{{url('/exappstatus/3/')}}?apid={{$c->approvedprogramme->id}}&cid={{$c->candidate->id}}&term={{$c->term}}" class="btn btn-danger btn-xs">Reject</a>
									@endif
									@if($c->status_id != '1')
									<a href="{{url('/exappstatus/1/')}}?apid={{$c->approvedprogramme->id}}&cid={{$c->candidate->id}}&term={{$c->term}}" class="btn btn-warning btn-xs">Hold</a>
									@endif
        	</td>
		</tr>
    @endforeach
   @else
    No Match found
   @endif
@endsection
