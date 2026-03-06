@extends('layouts.app')

@section('content')
<style>
	.table-bordered>tbody>tr>td{
		font-weight:100!important;
	}
</style>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h4>
				Attendance  for <b>{{$ap->programme->course_name}}  ( {{$ap->academicyear->year}} )
					<div class="pull-right">
						<span class="label label-primary" style="padding: 5px;" > Attendance Scan Copy: </span> &nbsp;
						<?php $candidates = $ap->candidates ; ?>
						<?php $display = false; ?>
						@if($candidates->count()>0 && !is_null($candidates->first()))
							@if(!is_null($candidates->first()->attendances) && $candidates->first()->attendances->where('exam_id',$exam_id)->count() > 0 && !is_null($candidates->first()->attendances()->where('exam_id',$exam_id)->first()))
								@if($candidates->first()->attendances()->first()->document_t != null)
									<?php $display = true; ?>
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
					</div>
				</h4>







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
								      <div class="modal-body"  style="min-height:100px;">

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
				@if($display)
				<table class="table  table-bordered">
					<tr>
						<th rowspan="2">Name</th>
						<th rowspan="2">Enrolment Number</th>
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
									@if($c->attendances->where('exam_id',$exam_id)->count()>0)
										<?php $a = $c->attendances->where('exam_id',$exam_id)->first(); ?>
										@if($a->attendance_t != null)
											<td>{{$a->attendance_t}}%</td>
											<td>{{$a->attendance_p}}%</td>
											<td><button type="button" class="btn btn-link btn-xs" data-toggle="modal" data-target="#ht_{{$c->id}}">Edit</button></td>
										@else
											<td colspan="3" class="text-center"><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ht_{{$c->id}}">Attendance</button></td>
										@endif
									@else
										<td colspan="3" class="text-center"><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ht_{{$c->id}}">Attendance</button></td>
									@endif
							
								</tr>


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
								      <div class="modal-body" style="min-height:100px;">
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


								      </div>
								      <div class="modal-footer">
								      	<button type="submit" class="btn btn-primary">Save</button>
								        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								      </div>
								    </div>
								</form>

							  </div>
							</div>
				@endforeach
			</table>
				@else
					
				<div class="alert alert-danger">
					Please click on upload button to upload the scan copy of the attendance sheet.
				</div>

				@endif

		</div>
	</div>
</div>



@endsection
