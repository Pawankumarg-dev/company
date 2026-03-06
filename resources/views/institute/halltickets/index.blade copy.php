@extends('layouts.app')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">

				<ul class="breadcrumb">
					<li><a href="{{url('/')}}">Home</a></li>
					<li> Attendance  for <b>{{$ap->programme->course_name}}  ( {{$ap->academicyear->year}} ) </b></li>
					<li class="pull-right">
					<span class="label label-primary" style="padding: 5px;" > Attendance Scan Copy: </span> &nbsp;

							@if($candidates->count()>0)
								@if($candidates->first()->attendances->where('exam_id',$exam_id)->count() > 0)
									@if($candidates->first()->attendances()->where('exam_id',$exam_id)->first()->document_t != null)
										<a target="_blank" href="{{asset('/files/attendance/')}}/{{$candidates->first()->attendances->where('exam_id',$exam_id)->first()->document_t}}" class="btn btn-xs btn-link"><i class="fa fa-download"></i> Theory </a>

										<a target="_blank" href="{{asset('/files/attendance/')}}/{{$candidates->first()->attendances->where('exam_id',$exam_id)->first()->document_p}}" class="btn btn-xs btn-link"><i class="fa fa-download"></i> Practical </a>


									<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#uploadattendance">Re-upload </button>
									@else
										<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#uploadattendance">Upload </button>
									@endif
								@else
									<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#uploadattendance">Upload </button>
								@endif
							@endif 



					</li>

				</ul>




							<div id="uploadattendance" class="modal fade modal-xs" role="dialog">
							  <div class="modal-dialog">

							    <!-- Modal content-->
							    <form class="form-horizontal" action="{{url('uploadattendance')}}" enctype="multipart/form-data" method='post' >
							    	                      {!! csrf_field() !!}

								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal">&times;</button>
								        <h4 class="modal-title">Upload Attendance</h4>
								        <input type="hidden" name='approvedprogramme_id' value="{{$id}}" />
								        <input type="hidden" name='exam_id' value="{{$exam_id}}" />
								      </div>
								      <div class="modal-body">

										  <div class="form-group">
										    <label class="control-label col-sm-6" for="document">Attendance Scan Copy - Theory:</label>
										    <div class="col-sm-6">
												<input type="file" class="form-control" name="document_t" />
										    </div>
										  </div>


										  <div class="form-group">
										    <label class="control-label col-sm-6" for="document">Attendance Scan Copy - Practical:</label>
										    <div class="col-sm-6">
												<input type="file" class="form-control" name="document_p" />
										    </div>
										  </div>






								      </div>
								      <div class="modal-footer">
								      	<button type="submit" class="btn btn-primary">Upload</button>
								        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								      </div>
								    </div>
								</form>

							  </div>
							</div>


			</div>



		</div>
		@include('common.errorandmsg')

		<div class="row">
			<div class="col-md-12">

				<table class="table table-striped">
					<tr>
						<th rowspan="2">Name</th>
						<th rowspan="2">Enrolment Number</th>


						<th rowspan="2">Contact Number</th>

						<th colspan="3">Attendance</th>

					</tr>
					<tr>
						<th>Theory</th>
						<th>Practical</th>
					</tr>
					@foreach($candidates->sortBy('enrolmentno') as $c)
						<tr>
							<td>{{$c->name}}</td>
							<td>{{$c->enrolmentno}}</td>


							<td>{{$c->contactnumber}}</td>


								@if($c->applications->count()>0)
									@if($c->attendances->where('exam_id',$exam_id)->count()>0)
										<?php $a = $c->attendances->where('exam_id',$exam_id)->first(); ?>
										@if($a->attendance_t != null)
											<td>{{$a->attendance_t}}%</td>
											<td>{{$a->attendance_p}}%</td>
											<td><button type="button" class="btn btn-link btn-xs" data-toggle="modal" data-target="#ht_{{$c->id}}">Edit</button></td>
										@else
											<td colspan="3"><center><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ht_{{$c->id}}">Attendance</button></center></td>
										@endif
									@else
										<td colspan="3"><center><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ht_{{$c->id}}">Attendance</button></center></td>
									@endif
								@else
									<td colspan="3"><i class="fa fa-info-circle"></i> &nbsp;No Examination Application Found.</td>
								@endif
						<td>
							&nbsp;&nbsp;


							<div id="ht_{{$c->id}}" class="modal fade modal-xs" role="dialog">
							  <div class="modal-dialog">

							    <!-- Modal content-->
							    <form class="form-horizontal" action="{{url('attendance')}}" enctype="multipart/form-data" method='post' >
							    	                      {!! csrf_field() !!}

								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal">&times;</button>
								        <h4 class="modal-title">{{$c->name}}</h4>
								        <input type="hidden" name='candidate_id' value="{{$c->id}}" />
								        <input type="hidden" name='exam_id' value="{{$exam_id}}" />
								      </div>
								      <div class="modal-body">
								          <div class="form-group">
										    <label class="control-label col-sm-6" for="attendance">Attendance Percentage - Theory:</label>
										    <div class="col-sm-6">
										      <input type="number" class="form-control" name="attendance_t" placeholder="Attendance Percentage" min='0' max='100' step="any">
										    </div>
										  </div>


										   <div class="form-group">
										    <label class="control-label col-sm-6" for="attendance">Attendance Percentage - Practical:</label>
										    <div class="col-sm-6">
										      <input type="number" class="form-control" name="attendance_p" placeholder="Attendance Percentage" min='0' max='100' step="any">
										    </div>
										  </div>


										 {{-- <div class="form-group">

										    <label class="control-label col-sm-6" for="document">Exemption document if less than 75%:</label>
										    <div class="col-sm-6">
												<input type="file" class="form-control" name="document_exemption" />
										    </div>
										  </div> --}}





								      </div>
								      <div class="modal-footer">
								      	<button type="submit" class="btn btn-primary">Save</button>
								        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								      </div>
								    </div>
								</form>

							  </div>
							</div>

							
						</td>

					</tr>
				@endforeach
			</table>

		</div>
	</div>
</div>



@endsection
