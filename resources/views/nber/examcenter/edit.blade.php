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
                <h4>Edit Exam Center</h4>
				@include('common.errorandmsg')
				<form action="{{ url('nber/excenter/') }}/{{$examcenter->id}}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="_method" value="PUT"> 

                    <button class="btn  mb-2 btn-primary btn-xs pull-right" style="position: absolute;right:15px;top:10px;">Save</button> 
                	<a href="{{ url('nber/excenter/') }}/{{$examcenter->id}}" style="position: absolute;right:55px;top:10px;"
                    class="btn btn-success btn-xs mb-2 pull-right">Back</a>

					<table class="table table-bordered table-condensed">
						<tr>
							<th>Code</th>
							<td>
								<input type="text" name="code" class="edit-field" value="{{$examcenter->code}}">
							</td>
						</tr>
						<tr>
							<th>Name</th>
							<td><input type="text" name="name" class="edit-field" value="{{$examcenter->name }}"></td>
						</tr>
				
						<tr>
							<th>State</th>
							<td>
								<select name="lgstate_id" id="lgstate_id" class="edit-field">
									<option value="0" disabled>--Please Select--</option>
									@foreach($lgstates as $state)
										<option value="{{$state->id}}"
										data-id="{{ $state->state_code }}"
											
											@if($state->id == $examcenter->lgstate_id) selected @endif>{{$state->state_name}}</option>
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
										@if($district->id == $examcenter->district) selected @endif
										
										value="{{$district->id}}" >{{$district->districtName}}</option>
									@endforeach
								</select>
							</td>
						</tr>
						<tr>
							<th>Address</th>
							<td><input type="text" name="address" class="edit-field" value="{{$examcenter->address }}"></td>
						</tr>
						<tr>
							<th>PIN Code</th>
							<td><input type="text" name="pincode" class="edit-field" value="{{$examcenter->pincode }}"></td>
						</tr>
						<tr>
							<th>Contact Persson #1 (Principal)</th>
							<td><input type="text" name="principal_name" class="edit-field" value="{{$examcenter->principal_name }}"></td>
						</tr>
				
						<tr>
							<th>Mobile Number #1</th>
							<td><input type="text" name="principal_mobile" class="edit-field" value="{{$examcenter->principal_mobile }}"></td>
						</tr>
						<tr>
							<th>WhatsApp Number #1</th>
							<td><input type="text" name="principal_whatsapp" class="edit-field" value="{{$examcenter->principal_whatsapp }}"></td>
						</tr>
						<tr>
							<th>Email #1</th>
							<td><input type="text" name="email1" class="edit-field" value="{{$examcenter->email1 }}"></td>
						</tr>
						<tr>
							<th>Alternative Contact </th>
							<td><input type="text" name="contactperson" class="edit-field" value="{{$examcenter->contactperson }}"></td>
						</tr>
						<tr>
							<th>Alternative Contact Designation</th>
							<td><input type="text" name="alternative_designation" class="edit-field" value="{{$examcenter->alternative_designation }}"></td>
						</tr>
					
						<tr>
							<th>Mobile Number #2</th>
							<td><input type="text" name="contactnumber1" class="edit-field" value="{{$examcenter->contactnumber1 }}"></td>
						</tr>
						<tr>
							<th>WhatsApp Number #2</th>
							<td><input type="text" name="contactnumber2" class="edit-field" value="{{$examcenter->contactnumber2 }}"></td>
						</tr>
						<tr>
							<th>Email #2</th>
							<td><input type="text" name="email2" class="edit-field" value="{{$examcenter->email2 }}"></td>
						</tr>
						<tr>
							<th>Seats Per Room</th>
							<td>
								<input type="number" name="seats_per_room" class="edit-field" value="{{$examcenter->seats_per_room}}">
							</td>
						</tr>
						<tr>
							
						</tr>
						<tr>
							<th>Class room count</th>
							<td>
								<input type="number" name="classroom_count" class="edit-field" value="{{$examcenter->classroom_count}}">
							</td>
						</tr>
					</table>
					<h5>Login Details</h5>
					<table class="table table-bordered table-condensed">
						<tr>
							<th>User Name</th>
							<td><input type="text" autocomplete="off" name="username" class="edit-field" value="{{$examcenter->user ?  $examcenter->user->username : ''}}"></td>
						</tr>
						<tr>
							<th>
								Password <br>
								<small style="font-weight: 100;">Key in the password to create new password. Leave blank otherwise</small>
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
