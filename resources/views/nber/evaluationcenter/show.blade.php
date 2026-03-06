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
				<h4>Evaluation Center</h4>
				@include('common.errorandmsg')
				<a href="{{url('nber/evaluationcenter/')}}/{{$evaluationcenter->id}}/edit" style="position: absolute;right:15px;top:10px;" class="btn  mb-2 btn-primary btn-xs pull-right">Edit</a>
				<a href="{{url('nber/evaluationcenter/')}}" style="position: absolute;right:55px;top:10px;" class="btn btn-success btn-xs mb-2 pull-right">Back</a>
				
				<table class="table table-bordered table-condensed">
					<tr>
						<th>Code</th>
						<td>{{$evaluationcenter->code}}</td>
					</tr>
					<tr>
						<th>Name</th>
						<td>{{$evaluationcenter->name}}</td>
					</tr>
					<tr>
						<th>Address</th>
						<td>{{$evaluationcenter->address}}</td>
					</tr>
					<tr>
						<th>State</th>
						<td>{{$evaluationcenter->lgstate ? $evaluationcenter->lgstate->state_name  : $evaluationcenter->state }}</td>
					</tr>
					<tr>
						<th>PIN Code</th>
						<td>{{$evaluationcenter->pincode}}</td>
					</tr>
					<tr>
						<th>Contact Number #1</th>
						<td>{{$evaluationcenter->contactnumber1}}</td>
					</tr>
					<tr>
						<th>Contact Number #2</th>
						<td>{{$evaluationcenter->contactnumber2}}</td>
					</tr>
					<tr>
						<th>Email #1</th>
						<td>{{$evaluationcenter->email1}}</td>
					</tr>
					<tr>
						<th>Email #2</th>
						<td>{{$evaluationcenter->email2}}</td>
					</tr>
					<tr>
						<th>Contact Person</th>
						<td>{{$evaluationcenter->contactperson}}</td>
					</tr>
					
					
				</table>
				@if($isRCI)
					<h5>Login Details</h5>
					<table class="table table-bordered table-condensed">
						<tr>
							<th>User Name (Incharge)</th>
							<td>{{$evaluationcenter->user ? $evaluationcenter->user->username : ''}}</td>
						</tr>
						<tr>
							<th>User Name</th>
							<td>
								<a href="{{url('nber/evaluationcenter/')}}/{{$evaluationcenter->id}}/edit">
									<small class="badge badge-xs">Edit to change the passwod</small>
								</a>
							</td>
						</tr>
						<tr>
							<th>User Name (Data Entry Operator)</th>
							<td>{{$evaluationcenter->deuser ? $evaluationcenter->deuser->username : ''}}</td>
						</tr>
						<tr>
							<th>User Name</th>
							<td>
								<a href="{{url('nber/evaluationcenter/')}}/{{$evaluationcenter->id}}/edit">
									<small class="badge badge-xs">Edit to change the passwod</small>
								</a>
							</td>
						</tr>
					</table>
				@endif
			</div>
		</div>
	</div>
@endsection