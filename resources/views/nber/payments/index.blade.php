@extends('layouts.app')

@section('content')
<form action="{{url('payments')}}" method="get" style="padding: 0!important;margin:0!important;">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
		<ul class="breadcrumb col-md-12">
				  <li><a href="{{url('/')}}">Home</a></li>
				  <li><a href="{{url('institutes')}}">Institutes</a></li>
				  <?php $pass = '' ?>
				   @if(app('request')->has('i'))
				  	<li><a href="{{url('institute')}}/{{app('request')->input('i')}}">{{$institute}}</a></li>
				  	<?php $pass = '&i='.app('request')->input('i'); ?>
				  @else
				  	<li>All</li>
				  @endif
				  
				  <li> <a href= "{{url('payments')}}">Payments</a> </li>
				  @if(app('request')->has('transactionid'))
				  	<li>Search Result: {{app('request')->input('transactionid')}}</li>
				  @else
				  <li>
				  @if(app('request')->input('e'))
				  	@if(app('request')->input('e')=='enrolment')
				  		 <a href="{{url('payments')}}"><span class=" label label-default">All</span></a>
				  		 <span class=" label label-success">Enrolment</span>
				  		 <a href="{{url('payments')}}?e=exam{{$pass}}"><span class=" label label-default">Exam</span></a>
				  	@endif
				  	@if(app('request')->input('e')=='exam')
				  		<a href="{{url('payments')}}"><span class=" label label-default">All</span></a>
				  		 <a href="{{url('payments')}}?e=enrolment{{$pass}}"><span class=" label label-default">Enrolment</span></a>
				  		 <span class=" label label-success">Exam</span>
				  		 
				  	@endif
				  	<?php $pass .= '&e='.app('request')->input('e'); ?>
				  @else
				  	<span class=" label label-success">All</span>
				  	<a href="{{url('payments')}}?e=enrolment{{$pass}}"><span class=" label label-default">Enrolment</span></a>
				  	<a href="{{url('payments')}}?e=exam{{$pass}}"><span class=" label label-default">Exam</span></a>
				  @endif
				  </li>
				   @if(app('request')->input('s'))
					  <li>
					  
					  	 <a href="{{url('payments')}}?{{$pass}}"><span class=" label label-default">All</span></a> &nbsp;
					  	@if(app('request')->input('s')=='1')
				  			  <span class=" label label-success">Pending</span>&nbsp;
				  			  <a href="{{url('payments')}}?s=2{{$pass}}"><span class=" label label-default">Approved</span></a>&nbsp;
				  			  <a href="{{url('payments')}}?s=3{{$pass}}"><span class=" label label-default">Rejected</span></a>
				  		@endif
				  		@if(app('request')->input('s')=='2')
				  			  <a href="{{url('payments')}}?s=1{{$pass}}"><span class=" label label-default">Pending</span></a>&nbsp;
				  			  <span class=" label label-success">Approved</span>&nbsp;
				  			  <a href="{{url('payments')}}?s=3{{$pass}}"><span class=" label label-default">Rejected</span></a>
				  		@endif
				  		@if(app('request')->input('s')=='3')
				  			  <a href="{{url('payments')}}?s=1{{$pass}}"><span class=" label label-default">Pending</span></a>&nbsp;
				  			  <a href="{{url('payments')}}?s=2{{$pass}}"><span class=" label label-default">Approved</span></a>&nbsp;
				  			  <span class=" label label-success">Rejected</span>
				  		@endif
					  	</li>
					  	<li>
					  		<span class="label label-success " style="border-radius: 10px!important;">{{$payments->total()}}</span>
					  	</li>
					  	@else
				  	<li>
				  		  <span class=" label label-success">All</span> &nbsp;
				  		<a href="{{url('payments')}}?s=1{{$pass}}"><span class=" label label-default">Pending</span></a>&nbsp;
				  		<a href="{{url('payments')}}?s=2{{$pass}}"><span class=" label label-default">Approved</span></a>&nbsp;
				  		<a href="{{url('payments')}}?s=3{{$pass}}"><span class=" label label-default">Rejected</span></a>
				  		
				  	</li>
				  		<li>
					  		<span class="label label-success " style="border-radius: 10px!important;">{{$payments->total()}}</span>
					  	</li>
				  	
					  @endif
					  @endif
				 <button type="submit" class="btn btn-primary pull-right" style="margin-top: -4px;">Search</button>
				 <input class="form-control pull-right" style="width:300px;margin-top: -4px;" id="transcationid" name='transactionid' type="search" placeholder="Transcation ID">
				  
				  
				
				 
		</ul>
		
		</div>
	</div>
</div>
</form>
<div class="container-fluid">
    <div class="row">
    	@if($payments->count()>0)
	    	<div class="col-md-12">	
					<div class="pull-right">
						{{$payments->appends(request()->input())->links()}}
					</div>
			</div>
			<div class="col-md-12">
				
			<table class="table table-striped table-condensed">
				@foreach($payments as $p)
				
					<tr>
						<td>Institute</td>
						<td>Type</td>
						<td>Year</td>
						<td>Amount</td>
						<td>Date</td>
						<td>Bank</td>
						<td>Transaction ID</td>
						<td>Status</td>
						<td>Remarks</td>
						<td>Action</td>
					</tr>
				
					<tr>
						<td><a href="{{url('programmeapplications')}}?i={{$p->institute->id}}">{{$p->institute->user->username}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a></td>
						<td>{{$p->type}}</td>
						<td>2017</td>
						<td><span class="label label-info">{{$p->totalamount}}</span></td>
						<td>{{$p->date}}</td>
						<td>{{$p->bank}}</td>
						<td>{{$p->transactionid}}</td>
						<td>{!!$p->status->statushtml()!!}</td>
						<td>{{$p->remark}}</td>
						<td>
							
							@if($p->status_id != '2')
									<a href="{{url('/payments/2/'.$p->id)}}" class="btn btn-success btn-xs">Approve</a>
									@endif
									@if($p->status_id != '3')
									<a href="{{url('/payments/3/'.$p->id)}}" class="btn btn-danger btn-xs">Reject</a>
									@endif
									@if($p->status_id != '1')
									<a href="{{url('/payments/1/'.$p->id)}}" class="btn btn-warning btn-xs">Hold</a>
							@endif
						</td>
					</tr>
					@if($p->institute->approvedprogrammes()->count() >0)
					<tr><td colspan="10">
						<table class="table table-bordered table-condensed">
						<tr>
							
							<td>Course </td>
							<td>Status</td>
							@if($p->type=='enrolment')
							<td>Max Intake</td>
							
							<td>Applied</td>
							<td>Approved</td>
							<td>Rejected</td>
							<td>Pending</td>
							@else
							<td>Enrolled Year</td>
							<td>Exam Applications(Papers)</td>
							@endif
						</tr>
						<?php $tmax = 0; $tapplied = 0; $tapproved = 0; $trejected = 0 ; $tpending = 0; $tpapers = 0;?>
						@foreach($p->institute->approvedprogrammes as $ap)
						
						
							
							@if($p->type=='enrolment')

							<tr>

							@if($ap->academicyear_id == Session::get('academicyear_id'))
							<?php
								$max = $ap->maxintake; $tmax += $max;
								$applied = $ap->candidates->count(); $tapplied += $applied;
								$approved = $ap->candidates()->statuscount($ap->id,2)->count(); $tapproved += $approved;
								$rejected = $ap->candidates()->statuscount($ap->id,3)->count(); $trejected += $rejected;
								$pending = $ap->candidates()->statuscount($ap->id,1)->count(); $tpending += $pending;
							?>
							<td>{{$ap->programme->course_name}}</td>
							<td>{!!$ap->status->statushtml()!!}</td>
					
							
							<td>{{$max}}</td>
							
							<td>
								<a href="{{url('candidateapplications')}}?p={{$ap->id}}">
									{{$applied}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i>
								</a>
							</td>
							
							<td>
								<a href="{{url('candidateapplications')}}?s=2&p={{$ap->id}}">
									{{$approved}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i>
								</a>
								
							</td>
							<td>
								<a href="{{url('candidateapplications')}}?s=3&p={{$ap->id}}">
									{{$rejected}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i>
								</a>
							</td>
							<td>
								<a href="{{url('candidateapplications')}}?s=1&p={{$ap->id}}">
									{{$pending}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i>
								</a>
							</td>
							
						</tr>
							@endif
							@else
							<tr>
							<td>{{$ap->programme->course_name}}</td>
							<td>{!!$ap->status->statushtml()!!}</td>
							<td>{{$ap->academicyear->year}}</td>
							<td>
									<?php
									$paperno = $ap->applications->count();
									$tpapers += $paperno;
									echo $paperno;
									?>
							</td>
						</tr>
							@endif
						@endforeach
						<tr>
					
							<td colspan="2">Total</td>
							@if($p->type=='enrolment')
							
								<td>{{$tmax}}</td>
								<td>
									<span class="label label-info">{{$tapplied}} </span> <small> &nbsp;x 500 = {{$tapplied * 500}}</small>
								</td>
								<td>{{$tapproved}}</td>
								<td>{{$trejected}}</td>
								<td>{{$tpending}} </td>
							
							@else
							<td></td>
								<td> <span class="label label-info">{{$tpapers}}  </span> <small> &nbsp;x 150 = {{$tpapers * 150}}</small></td>
							@endif
						</tr>
						</table>
						<font  style="float:right;font-size: 9px!important">Created At:  {{$p->created_at}} </font>
					</td></tr>
					@endif
					<tr><td colspan="9"></td></tr>
				@endforeach
			</table>
			</div>
			<div class="col-md-12">	
					<div class="pull-right">
						{{$payments->appends(request()->input())->links()}}
					</div>
			</div>
			@else
			<div class="col-md-12">	
				Nothing to display.
					
			</div>
				
			@endif
			
		
	</div>
</div>
@endsection