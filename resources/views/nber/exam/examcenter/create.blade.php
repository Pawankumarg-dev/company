@extends('layouts.app')
@section('content')
    <style>
        .mb-2 {
            margin-bottom: 10px;
        }
		.edit-field{
			width:500px;
			border:1px solid #ccc;
		}
    </style>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4>Add Exam Center</h4>
				@include('common.errorandmsg')
				<form action="{{ url('nber/exam/examcenter/') }}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="type" value="institute">
                    <button class="btn  mb-2 btn-primary btn-xs pull-right" style="position: absolute;right:15px;top:10px;">Save</button> 
                	<a href="{{ url('nber/exam/examcenter/') }}" style="position: absolute;right:55px;top:10px;"
                    class="btn btn-success btn-xs mb-2 pull-right">Back</a>
					<input type="hidden" name="exam_id" value={{Session::get('exam_id')}}>
					<table class="table table-bordered table-condensed">
						<tr>
							<th>Institute</th>
							<td>
								<select name="institute_id" id="institute_id" class="edit-field"  data-live-search="true">
									<option value="0" disabled>--Please Select--</option>
									@foreach($maxstudents->sortBy('institute.rci_code') as $max)
										@if(is_null($max->institute->examcenters()->onlyExam(Session::get('exam_id'))->first()))
											<option value="{{$max->institute->id}}">{{$max->institute->rci_code}} - {{$max->institute->name}}</option>
										@endif
									@endforeach
								</select>
							</td>
						</tr> 
						<tr>
							<th>Exam Center</th>
							<td>
								<select name="externalexamcenter_id" id="externalexamcenter_id" class="edit-field"  data-live-search="true">
									<option value="0" disabled>--Please Select--</option>
									@foreach($externalexamcenters as $ec)
										<option value="{{$ec->id}}" > {{$ec->code}} - {{$ec->name}}</option>
									@endforeach
								</select>
							</td>
						</tr>
					</table>
				</form>

				
				<form action="{{ url('nber/exam/examcenter/') }}" method="POST">
					{{ csrf_field() }}
					<h4>Add Exam Centers for District

						<button class="btn  mb-2 btn-primary btn-xs pull-right">Save</button> 
					</h4>
					<input type="hidden" name="type" value="district">
                    
					<input type="hidden" name="exam_id" value={{Session::get('exam_id')}}>
					<table class="table table-bordered table-condensed">
						<tr>
							<th>State</th>
							<td>
								<select name="lgstate_id" id="lgstate_id" class="edit-field"  data-live-search="true">
									<option value="0" disabled>--Please Select--</option>
									@foreach($lgstates as $state)
										<option 
										data-id="{{ $state->state_code }}"
										value="{{$state->id}}">{{$state->state_name}}</option>
									@endforeach
								</select>
							</td>
						</tr> 
						<tr>
							<th>District</th>
							<td>
								<select name="district_id" id="district_id" class="edit-field"  data-live-search="true">
									<option value="0" disabled>--Please Select--</option>
									@foreach($districts as $district)
										<option
										class="{{ $district->state_code }} districts"
										value="{{$district->id}}">{{$district->districtName}}</option>
									@endforeach
								</select>
							</td>
						</tr> 
						<tr>
							<th>Exam Center</th>
							<td>
								<select name="externalexamcenter_id" id="externalexamcenter_id" class="edit-field" data-live-search="true">
									<option value="0" disabled>--Please Select--</option>
									@foreach($externalexamcenters as $ec)
										<option value="{{$ec->id}}" > {{$ec->code}} - {{$ec->name}}</option>
									@endforeach
								</select>
							</td>
						</tr>
					</table>
				</form>



				<form action="{{ url('nber/exam/examcenter/') }}" method="POST">
					{{ csrf_field() }}
					<h4>Add Exam Centers for State

						<button class="btn  mb-2 btn-primary btn-xs pull-right">Save</button> 
					</h4>
					<input type="hidden" name="type" value="state">
                    
					<input type="hidden" name="exam_id" value={{Session::get('exam_id')}}>
					<table class="table table-bordered table-condensed">
						<tr>
							<th>State</th>
							<td>
								<select name="state_id" id="state_id" class="edit-field"  data-live-search="true">
									<option value="0" disabled>--Please Select--</option>
									@foreach($lgstates as $state)
										<option 
										data-id="{{ $state->state_code }}"
										value="{{$state->id}}">{{$state->state_name}}</option>
									@endforeach
								</select>
							</td>
						</tr> 
						<tr>
							<th>Exam Center</th>
							<td>
								<select name="externalexamcenter_id" id="externalexamcenter_id" class="edit-field"  data-live-search="true">
									<option value="0" disabled>--Please Select--</option>
									@foreach($externalexamcenters as $ec)
										<option value="{{$ec->id}}" > {{$ec->code}} - {{$ec->name}}</option>
									@endforeach
								</select>
							</td>
						</tr>
					</table>
				</form>


            </div>
        </div>
    </div>

	<link rel="stylesheet" href="{{url('/css')}}/bootstrap-select.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="{{url('/js')}}/bootstrap-select.min.js"></script>
	<script>
		$(document).ready(function(){
			$('select').selectpicker();
			showhidedistricts();
			$('#lgstate_id').on('change',function(){
				showhidedistricts();
			});
		});
		function showhidedistricts(){
			var className = $('#lgstate_id').find(':selected').data('id');
			$('.districts').addClass('hidden');
			$('.'+className).removeClass('hidden');
		}
		 
	</script>
@endsection
