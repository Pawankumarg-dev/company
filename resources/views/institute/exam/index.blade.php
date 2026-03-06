@extends('layouts.app')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">

				<ul class="breadcrumb">
					<li><a href="{{url('/')}}">Home</a></li>
					<li> Exam Applications for <b>{{$ap->programme->course_name}}  ( {{$ap->academicyear->year}} ) </b>
					</li>
					<div class="pull-right">
						{{-- <a href="{{url('/applications/pdf/payment')}}/{{$ap->id}}/{{$exam->id}}" class="btn btn-default btn-bc" target="_blank"><i class="fa fa-print"></i> Exam Application Fee Pay Details</a>--}}

						<a href="{{url('/applications/pdf/exam')}}/{{$ap->id}}/{{$exam->id}}" class="btn btn-primary btn-bc" target="_blank"><i class="fa fa-print"></i> Exam Application Details</a>

					</div>
				</ul>
			</div>
		</div>
		@include('common.errorandmsg')

		<div class="row">
			<div class="col-md-12">

				<table class="table table-striped">
					<tr>
						<td>S.No.</td>
						<td>Name</td>
						<td>Enrolment Number</td>


						<td>Contact Number</td>

						<td>Exam Application</td>
						<td>Status</td>
						<td>Remarks</td>
					</tr>
					@php $sno = 1; @endphp
					@foreach($candidates as $c)
						<tr>
							<td>{{$sno}}</td>
							<td>{{$c->name}}</td>
							<td>{{$c->enrolmentno}}</td>
							<td>{{$c->contactnumber}}</td>
							<td>
								@for($i=1;$i<=$ap->programme->programmegroup->noofterms;$i++)
									@foreach($exambatch as $eb)
										@if($eb->term == $i)
											<button type="button" class="btn btn-default btn-xs" data-toggle="modal"
													@if($allowapplication == 1) disabled @endif
													data-target="#myModal{{$c->id}}-{{$i}}">{{$i }} Year
											</button>
										@endif
									@endforeach
								@endfor
							</td>
							<td>
								@if($c->applications->count()>0)
									<?php 	$count = 0; ?>
									@foreach($c->applications as $appl)

										<?php
										if($appl->exam_id==$exam->id){
											$count +=1;
										}
										?>
									@endforeach
									@if($count!=0)
										Applied:{{$count}} Subjects
									@endif
								@endif
							</td>
							<td>
								@if($allowapplication == 1)
									<span class="label label-danger">{{ $errormessage }}</span>
								@endif
							</td>
						</tr>
						@php $sno++; @endphp
					@endforeach
				</table>

			</div>
		</div>
	</div>
	<script>
		function confirm(id,name){
			swal({
				title: 'Are you sure?',
				text: "Delete candidate " + name ,
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				confirmButtonText: 'Yes, delete!'
			}).then((result) => {
				if (result.value) {
					window.location.replace("{{url('candidate/delete')}}/"+id);

				}
			})
		}
	</script>

	@foreach($candidates as $c)
		@for($i=1;$i<=$ap->programme->programmegroup->noofterms;$i++)
			@include('institute.exam.subjects')
		@endfor
	@endforeach
@endsection
