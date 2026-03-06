@extends('layouts.app')

@section('content')


<ul class="breadcrumb col-md-12">
      <li><a href="{{url('/')}}">Home</a></li>
      <li class="bctext"> <i class="fa fa-download"> </i> &nbsp; Question Paper Downloads</li>
</ul>

<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

            	@include('common.errorandmsg')
            	
               
                <h4>Available Downloads at {{\Carbon\Carbon::now()}}</h4> 
                <?php $programme_ids = Session::get('programme_ids'); ?>     

                @if($questionpapers->count()>0)
                	<table class="table" style="width:250px;">
                		<tr>
                			<td>Subject Code</td>
							<td>Question Paper</td>
						</tr>
						@foreach($questionpapers as $qp)
							@if(in_array($qp->subject->programme->id, $programme_ids))
								<tr>
									<td>
										{{$qp->subject->scode}}

									</td>
									<td>
										<a  class="btn btn-xs btn-info" href="{{url('clo/downloadfile/questionpaper/'.$qp->id)}}"><i class="fa fa-download"></i>&nbsp;Download</a>
									</td>
								</tr>
							@endif
						@endforeach
					</table>
                @else
                	<label class="label label-primary">None</label><br />
                @endif




                <br />
                <h4>Today's Exams</h4> 
                
                @if($today->count()>0)
                	<table class="table">
                		<tr>
                			<td>Exam</td>
							<td>Exam Type</td>
							<td>Programme Code</td>
							<td>Programme</td>
							<td>Subject Code</td>
							<td>Subject</td>
							<td>Starting  Date Time</td>
							<td>Ending Date Time</td>
							
						</tr>
						@foreach($today as $qp)
							@if(in_array($qp->subject->programme->id, $programme_ids))
								<tr>
									<td>
										{{$qp->exam->name}}
									</td>
									<td>
										{{$qp->exam->examtype->name}}
									</td>
									<td>
										{{$qp->subject->programme->course_name}}
									</td>
									<td>
										{{$qp->subject->programme->name}}
									</td>
									<td>
										{{$qp->subject->scode}}
									</td>
									<td>
										{{$qp->subject->sname}}
									</td>
									<td>
										{{$qp->startdate}}
									</td>
									<td>
										{{$qp->enddate}}
									</td>
									
								</tr>
							@endif
						@endforeach
					</table>
                @else
                	<label class="label label-primary">None</label>
                @endif
                
            </div>
        </div>

@endsection