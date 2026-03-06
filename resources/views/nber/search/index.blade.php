@extends('layouts.app')

@section('content')
<style>
.pagination{
	margin-top:-45px!important;
	float:right!important;
}
</style>
<ul class="breadcrumb" style="margin-top: -20px!important;">
	<li>
		<a href="{{url('/')}}"> Home</a>
	</li>
	<li>
		Search Result
	</li>
</ul>
 <div class="container">
                <div class="row">
                    <div class="col-md-12">
                    	@if($institutes->count()>0)
                    	<h2>Institutes</h2>
                    	{!! $institutes->appends(['enrolmentno'=>$key])->render() !!}
                    	<table class="table">

	@foreach($institutes as $c)
		<tr>
        	{!! Form::tbText('username',$c->user) !!}

      		{!! Form::tbText('name',$c) !!}
			  
      		<td>
      			<a href="{{url('institute')}}/{{$c->id}}" class="btn btn-xs btn-info"><i class="fa fa-btn fa-eye"></i> View</a>
      		</td>
		</tr>
    @endforeach
    
    
</table>
@endif
@if($candidates->count()>0)
    <h2>Candidates</h2>
    {!! $candidates->appends(['enrolmentno'=>$key])->render() !!}
    <table class="table">
		<tr>
			<th>Enrolment#</th>
			<th>Name</th>
			<th>Course</th>
			<th>Institute</th>
			<th>Link</th>
		</tr>
    @foreach($candidates as $c)
		<tr>
        	{!! Form::tbText('enrolmentno',$c) !!}

      		{!! Form::tbText('name',$c) !!}
			<td>
				{{$c->approvedprogramme->programme->course_name}} ( {{$c->approvedprogramme->academicyear->year}})

			</td>
			<td>
				{{$c->approvedprogramme->institute->rci_code}} - {{$c->approvedprogramme->institute->name}}
			</td>
      		<td>
      			<a href="{{url('candidate')}}/{{$c->id}}" class="btn btn-xs btn-info"><i class="fa fa-btn fa-eye"></i> View</a>
      		</td>
		</tr>
    @endforeach
    </table>
    @endif

@if($institutes->count()==0 and $candidates->count()==0)
  <div class="jumbotron">
                                <h2>Nothing found</h2> 
                                <p>Its Empty here!</p> 
                                <p><a href="javascript:history.back()"><i class="fa fa-arrow-left"></i> Back</a>
                              </div>
@endif
</div>
</div>
</div>
@endsection