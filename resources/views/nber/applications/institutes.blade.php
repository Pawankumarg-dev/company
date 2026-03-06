@extends('layouts.app')

@section('content')
<div class="container-fluid" >
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb" >
				  <li><a href="{{url('/dashboard')}}">Home</a></li>
				  <li><a href="{{url('/institutes')}}">Institute </a>   :  
				  <?php $pass = '' ?>
				  @if(app('request')->input('i'))
					  <a href="{{url('institute')}}/{{app('request')->input('i')}}">{{$institute}}</a> </li>
					  <?php $pass = '&i='.app('request')->input('i'); ?>
				  @else
				  	  All</li>
				  @endif
				  <li> <a href="{{url('programmes')}}">Programme</a> :
				  @if(app('request')->input('p'))
					  {{$programme}} </li>
					  <?php $pass .= '&p='.app('request')->input('p'); ?>
				  @else
				  	  All </li>
				  @endif
				  @if(app('request')->input('s'))
					  <li>
					  	Programmes Applied : 
					  	 <a href="{{url('programmeapplications')}}?{{$pass}}"><span class=" label label-default">All</span></a> &nbsp;
					  	@if(app('request')->input('s')=='1')
				  			  <span class=" label label-success">Pending</span>&nbsp;
				  			  <a href="{{url('programmeapplications')}}?s=2{{$pass}}"><span class=" label label-default">Approved</span></a>&nbsp;
				  			  <a href="{{url('programmeapplications')}}?s=3{{$pass}}"><span class=" label label-default">Rejected</span></a>
				  		@endif
				  		@if(app('request')->input('s')=='2')
				  			  <a href="{{url('programmeapplications')}}?s=1{{$pass}}"><span class=" label label-default">Pending</span></a>&nbsp;
				  			  <span class=" label label-success">Approved</span>&nbsp;
				  			  <a href="{{url('programmeapplications')}}?s=3{{$pass}}"><span class=" label label-default">Rejected</span></a>
				  		@endif
				  		@if(app('request')->input('s')=='3')
				  			  <a href="{{url('programmeapplications')}}?s=1{{$pass}}"><span class=" label label-default">Pending</span></a>&nbsp;
				  			  <a href="{{url('programmeapplications')}}?s=2{{$pass}}"><span class=" label label-default">Approved</span></a>&nbsp;
				  			  <span class=" label label-success">Rejected</span>
				  		@endif
					  	</li>
					  	<li>
					  		<span class="label label-success " style="border-radius: 10px!important;">{{$programmes->total()}}</span>
					  	</li>
					  
				  @else
				  	<li>
				  		Programmes Applied :    <span class=" label label-success">All</span> &nbsp;
				  		<a href="{{url('programmeapplications')}}?s=1{{$pass}}"><span class=" label label-default">Pending</span></a>&nbsp;
				  		<a href="{{url('programmeapplications')}}?s=2{{$pass}}"><span class=" label label-default">Approved</span></a>&nbsp;
				  		<a href="{{url('programmeapplications')}}?s=3{{$pass}}"><span class=" label label-default">Rejected</span></a>
				  		
				  	</li>
				  		<li>
					  		<span class="label label-success " style="border-radius: 10px!important;">{{$programmes->total()}}</span>
					  	</li>
				  	
				  @endif
				  <input class="form-control pull-right" style="width:300px;margin-top: -4px;" id="myInput" type="text" placeholder="Search..">
				</ul>
			</div>
			<div class="col-md-12">
				<div class="pull-right">
					{{$programmes->appends(request()->input())->links()}}
				</div>
			</div>
			<div class="col-md-12">
				<table class="table table-bordered table-striped">
				    <thead>
				      <tr>
				      	<th>Date</th>
				      	<th>Institute Code</th>
				        <th>Institute</th>
				        <th>Programme</th>
				        <th>Max Intake</th>
				        <th>Applied</th>
				        <th>Payments for</th>
				        <th>Letter</th>
				        <th>Status</th>
				        <th>Action</th>
				        <th>Enrolment Number</th>
				        <th>Links</th>
				      </tr>
				    </thead>

				    <tbody id="myTable">
						@foreach($programmes as $p)
							<tr>
								<td>{{$p->created_at}}</td>
								<td>
									<a target="_blank" href="{{url('institute')}}/{{$p->institute->id}}">{{$p->institute->user->username}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a>
								</td>
								<td>
									{{$p->institute->name}}, Contact#{{$p->institute->contactnumber1}}, Email:{{$p->institute->email}}
								</td>
								<td>
									{{$p->programme->course_name}}
								</td>
								<td>
									{{$p->maxintake}}
								</td>
								<td>
									{{$p->candidates->count()}}
								</td>
								<td>
									<a href="{{url('payments')}}?i={{$p->institute->id}}">{{$p->paid_for}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a>
								</td>
								<td>
									@foreach($p->programmeapprovalfiles as $f)
						        		<a href="{{url('files/rciapproval/'.$f->filename)}}" target="_blank" >{{$f->filename}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a>&nbsp;&nbsp;
						     		@endforeach
								</td>
								<td>
									<span class="label label-{{$p->status->class}}">{{$p->status->status}}</span>
								</td>
								<td style="width:160px;">
									
									@if($p->status_id != '2')
									<a href="{{url('/programme/2/'.$p->id)}}" class="btn btn-success btn-xs">Approve</a>
									@endif
									@if($p->status_id != '3')
									<a href="{{url('/programme/3/'.$p->id)}}" class="btn btn-danger btn-xs">Reject</a>
									@endif
									@if($p->status_id != '1')
									<a href="{{url('/programme/1/'.$p->id)}}" class="btn btn-warning btn-xs">Hold</a>
									@endif
								</td>
								<td>
									@if($p->status_id == '2')
										<a href="{{url('/generateenrolment/'.$p->id)}}" class="btn  btn-success btn-xs">Generate</a>
									@endif
								</td>
								<td>
									<a href="{{url('candidateapplications')}}?p={{$p->id}}" class="btn btn-xs btn-info" style="margin-bottom: 5px;">Candidates</a>
									<a href="{{url('examapplications')}}?i={{$p->institute->id}}&p={{$p->programme->id}}" class="btn btn-xs btn-info">Exam Applications</a>
								</td>
							</tr>
						@endforeach
					</tbody>

				</table>

				{{ $programme }}
			</div>
			<div class="col-md-12">	
				<div class="pull-right">
					{{$programmes->appends(request()->input())->links()}}
				</div>
			</div>
		</div>
</div>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
@endsection