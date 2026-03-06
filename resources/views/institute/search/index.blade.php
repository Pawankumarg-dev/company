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
 <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                 
@if($candidates->count()>0)
    <h2>Candidates</h2>
    {!! $candidates->appends(['key'=>$key])->render() !!}
    <table class="table">

    @foreach($candidates as $c)
		<tr>
        	{!! Form::tbText('enrolmentno',$c) !!}

      		{!! Form::tbText('name',$c) !!}
      		<td>
      			<a href="{{url('student')}}/{{$c->id}}" class="btn btn-xs btn-info"><i class="fa fa-btn fa-eye"></i> View</a>
      		</td>
		</tr>
    @endforeach
    </table>
    @endif

@if($candidates->count()==0)
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