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
                <h4>Add Evaluation Center</h4>
				@include('common.errorandmsg')

				<form action="{{ url('nber/evaluationcenter/') }}" method="POST">
					{{ csrf_field() }}

                    <button class="btn  mb-2 btn-primary btn-xs pull-right" style="position: absolute;right:15px;top:10px;">Save</button> 
                	<a href="{{ url('nber/evaluationcenter/') }}" style="position: absolute;right:55px;top:10px;"
                    class="btn btn-success btn-xs mb-2 pull-right">Back</a>

					<table class="table table-bordered table-condensed">
						<tr>
							<th>Code</th>
							<td>
								<input type="text" name="code" class="edit-field"  value="{{old('code')}}">
							</td>
						</tr>
						<tr>
							<th>Name</th>
							<td><input type="text" name="name" class="edit-field" value="{{old('name')}}"></td>
						</tr>
						<tr>
							<th>Address</th>
							<td><input type="text" name="address" class="edit-field"  value="{{old('address')}}" ></td>
						</tr>
						<tr>
							<th>State</th>
							<td>
								<select name="lgstate_id" id="lgstate_id" class="edit-field">
									<option value="0" disabled>--Please Select--</option>
									@foreach($lgstates as $state)
										<option value="{{$state->id}}" @if(old('lgstate_id') == $state->id) selected @endif) >{{$state->state_name}}</option>
									@endforeach
								</select>
							</td>
						</tr>
						<tr>
							<th>PIN Code</th>
							<td><input type="text" name="pincode" class="edit-field"  value="{{old('pincode')}}" ></td>
						</tr>
						<tr>
							<th>Contact Number #1</th>
							<td><input type="text" name="contactnumber1" class="edit-field"  value="{{old('contactnumber1')}}"></td>
						</tr>
						<tr>
							<th>Contact Number #2</th>
							<td><input type="text" name="contactnumber2" class="edit-field"  value="{{old('contactnumber2')}}"></td>
						</tr>
						<tr>
							<th>Email #1</th>
							<td><input type="text" name="email1" class="edit-field"  value="{{old('email1')}}" ></td>
						</tr>
						<tr>
							<th>Email #2</th>
							<td><input type="text" name="email2" class="edit-field"  value="{{old('email2')}}"></td>
						</tr>
						<tr>
							<th>Contact Person</th>
							<td><input type="text" name="contactperson" class="edit-field"  value="{{old('contactperson')}}" ></td>
						</tr>
					</table>
					<h5>Login Details</h5>
					<table class="table table-bordered table-condensed">
						<tr>
							<th>User Name (Incharge)</th>
							<td><input type="text" autocomplete="off" name="username" class="edit-field"  value="{{old('username')}}"></td>
						</tr>
						<tr>
							<th>
								Password 
							</th>
							<td>
								<input type="text" autocomplete="off" name="password" class="edit-field"  value="{{old('password')}}">
							</td>
						</tr>
						<tr>
							<th>User Name (Data Entry Operator)</th>
							<td><input type="text" name="deusername" class="edit-field"  value="{{old('deusername')}}"></td>
						</tr>
						<tr>
							<th>
								Password 
							</th>
							<td>
								<input type="text" name="depassword" class="edit-field"  value="{{old('depassword')}}">
							</td>
						</tr>
					</table>
				</form>
            </div>
        </div>
    </div>
@endsection
