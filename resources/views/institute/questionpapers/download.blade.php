@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">

				@include('common.errorandmsg')

				<h3><i class="fa fa-download"> </i> Question Paper Downloads </h3>
				<hr /><br />

				<h4>Available Downloads at {{\Carbon\Carbon::now()}}</h4>

				@if($questionpapers->count()>0)
					<table class="table" style="width:500px;">
						<tr>
							<td>Course Code</td>
							<td>Subject Code</td>
							<td>Question Paper</td>
						</tr>
						@foreach($questionpapers as $qp)
							<tr>
								<td>
									{{$qp->subject->programme->course_name}}
								</td>
								<td>
									{{$qp->subject->scode}}
								</td>
								<td>
									<a  class="btn btn-xs btn-info" href="{{url('downloadfile/questionpaper/'.$qp->id)}}"><i class="fa fa-download"></i>&nbsp;Download</a>
								</td>
							</tr>
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
						@endforeach
					</table>
				@else
					<label class="label label-primary">None</label>
			@endif
			<!--
                              <div class="jumbotron">

                              	Institute Login cannot download question papers. Please contact CLO.

                              </div>-->
			</div>
		</div>
	</div>

@endsection