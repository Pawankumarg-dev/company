@extends('layouts.app')
@section('content')
<style>
	.mb-2{
		margin-bottom: 10px;
	}
</style>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4>Exam Center</h4>
				@include('common.errorandmsg')
				<a href="{{url('nber/excenter/')}}/{{$examcenter->id}}/edit" style="position: absolute;right:15px;top:10px;" class="btn  mb-2 btn-primary btn-xs pull-right">Edit</a>
				<a href="{{url('nber/excenter/')}}" style="position: absolute;right:55px;top:10px;" class="btn btn-success btn-xs mb-2 pull-right">Back</a>
				
				<table class="table table-bordered table-condensed">
					<tr>
						<th>Code</th>
						<td>{{$examcenter->code}}</td>
					</tr>
					<tr>
						<th>Name</th>
						<td>{{$examcenter->name}}</td>
					</tr>
					<tr>
						<th>Address</th>
						<td>{{$examcenter->address}}</td>
					</tr>
					<tr>
						<th>State</th>
						<td>{{$examcenter->lgstate ? $examcenter->lgstate->state_name  : $examcenter->state }}</td>
					</tr>
					<tr>
						<th>District</th>
						<td>{{$examcenter->district ? $examcenter->lgdistrict->districtName  :'' }}</td>
					</tr>
					<tr>
						<th>PIN Code</th>
						<td>{{$examcenter->pincode}}</td>
					</tr>
					<tr>
						<th>Contact Number #1</th>
						<td>{{$examcenter->contactnumber1}}</td>
					</tr>
					<tr>
						<th>Contact Number #2</th>
						<td>{{$examcenter->contactnumber2}}</td>
					</tr>
					<tr>
						<th>Email #1</th>
						<td>{{$examcenter->email1}}</td>
					</tr>
					<tr>
						<th>Email #2</th>
						<td>{{$examcenter->email2}}</td>
					</tr>
					<tr>
						<th>Contact Person</th>
						<td>{{$examcenter->contactperson}}</td>
					</tr>
					<tr>
						<th>Seats Per Room</th>
						<td>{{$examcenter->seats_per_room}}</td>
					</tr>
					
				</table>
				<h5>Login Details</h5>
				<table class="table table-bordered table-condensed">
					<tr>
						<th>User Name</th>
						<td>{{$examcenter->user ? $examcenter->user->username : ''}}</td>
					</tr>
					<tr>
						<th>User Name</th>
						<td>
							<a href="{{url('nber/excenter/')}}/{{$examcenter->id}}/edit">
								<small class="badge badge-xs">Edit to change the passwod</small>
							</a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
@endsection