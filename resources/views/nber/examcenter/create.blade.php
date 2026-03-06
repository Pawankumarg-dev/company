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

				<form action="{{ url('nber/excenter/') }}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="exam_id" value="26">
                    <button class="btn  mb-2 btn-primary btn-xs pull-right" style="position: absolute;right:15px;top:10px;">Save</button> 
                	<a href="{{ url('nber/excenter/') }}" style="position: absolute;right:55px;top:10px;"
                    class="btn btn-success btn-xs mb-2 pull-right">Back</a>

					<table class="table table-bordered table-condensed">
						<tr>
							<th>Code</th>
							<td>
								<input type="text" name="code" class="edit-field" >
							</td>
						</tr>
						<tr>
							<th>Name</th>
							<td><input type="text" name="name" class="edit-field"></td>
						</tr>
						<tr>
							<th>Address</th>
							<td><input type="text" name="address" class="edit-field" ></td>
						</tr>
						<tr>
							<th>State</th>
							<td>
								<select name="lgstate_id" id="lgstate_id" class="edit-field">
									<option value="0" disabled>--Please Select--</option>
									@foreach($lgstates as $state)
										<option 
										data-id="{{ $state->state_code }}"
										value="{{$state->id}}" >{{$state->state_name}}</option>
									@endforeach
								</select>
							</td>
						</tr>
						<tr>
							<th>District</th>
							<td>
								<select name="district" id="district" class="edit-field">
									<option value="0" disabled>--Please Select--</option>
									@foreach($districts as $district)
										<option 
										class="{{ $district->state_code }} districts"
										value="{{$district->id}}" >{{$district->districtName}}</option>
									@endforeach
								</select>
							</td>
						</tr>
						<tr>
							<th>PIN Code</th>
							<td><input type="text" name="pincode" class="edit-field" ></td>
						</tr>
						<tr>
							<th>Contact Number #1</th>
							<td><input type="text" name="contactnumber1" class="edit-field"></td>
						</tr>
						<tr>
							<th>Contact Number #2</th>
							<td><input type="text" name="contactnumber2" class="edit-field"></td>
						</tr>
						<tr>
							<th>Email #1</th>
							<td><input type="text" name="email1" class="edit-field" ></td>
						</tr>
						<tr>
							<th>Email #2</th>
							<td><input type="text" name="email2" class="edit-field" ></td>
						</tr>
						<tr>
							<th>Contact Persson</th>
							<td><input type="text" name="contactperson" class="edit-field" ></td>
						</tr>
					</table>
					<h5>Login Details</h5>
					<table class="table table-bordered table-condensed">
						<tr>
							<th>User Name</th>
							<td><input type="text" autocomplete="off" name="username" class="edit-field"></td>
						</tr>
						<tr>
							<th>
								Password 
							</th>
							<td>
								<input type="text" autocomplete="off" name="password" class="edit-field">
							</td>
						</tr>
					</table>
				</form>
            </div>
        </div>
    </div>
	<script>
		$(document).ready(function(){
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
