<style>
	.green-text {
		color: darkgreen;
	}
	.blue-text {
		color: darkblue;
	}
	.red-text {
		color: red;
	}
	.bold-text {
		font-weight: bold;
	}
	.center-text {
		text-align: center !important;
	}
</style>

@extends('layouts.app')

@section('content')
	<div class="container-fluid" >
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb" >
					<li><a href="{{url('/dashboard')}}">Home</a></li>
					<li><a href="{{url('/institutes')}}"> Institutes </a></li>
					<li>{{$institute->user->username}}</li>
				</ul>
			</div>

			<div class="col-md-12">

				<table class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>Code</th>
						<th>Name</th>
						<th>Password</th>
						<th>Center Number</th>
						<th>Email</th>
						<th>Address</th>
						<th>Contact Number(s)</th>
						<th>Links</th>
					</tr>
					</thead>
					<tbody id="myTable">
					<tr>
						<td>{{$institute->user->username}}</td>
						<td>
							<div class="blue-text">{{$institute->name}}</div>
						</td>
						<td>
							<div class="red-text center-text">{{$institute->user->confirmation_code}}</div>
						</td>
						<td>
							<div class="green-text bold-text">{{$institute->enrolmentcode}}</div>
						</td>
						<td>
							{{$institute->email}}
						</td>
						<td>
							@if($institute->address1 != '') {{$institute->address1}}, @endif
							@if($institute->address2 != '') {{$institute->address2}}, @endif
							@if($institute->address3 != '') {{$institute->address3}}, @endif
							<br> Post office -
							@if($institute->postoffice != '') <b>{{ $institute->postoffice }}</b>, @endif
							@if(!is_null($institute->city_id))
								<br>
								District - <b>{{ $institute->city->name }}</b>,
								State - <b>{{ $institute->city->state->state_name }}</b>,
							@endif
							@if($institute->pincode != '') <br>Pincode - <b>{{$institute->pincode}}</b>. @endif
							@if($institute->landmark != '') <br>Landmark - {{$institute->landmark}} @endif
						</td>
						<td>
							@if($institute->contactnumber1 != '') {{$institute->contactnumber1}}, @endif
							@if($institute->contactnumber2 != '')
								<br>
								{{$institute->contactnumber2}}
							@endif
						</td>
						<td>
							<a href="javascript:edit();" class="btn btn-xs btn-primary "><i class="fa fa-edit"></i> Edit</a>

					</tr>

					</tbody>
				</table>
			</div>
			<div class="col-md-12">
				<a style='margin-bottom: 5px' href="{{url('programmeapplications')}}?i={{$institute->id}}" class="btn btn-xs btn-info">Programmes</a>
				<a style='margin-bottom: 5px' href="{{url('candidateapplications')}}?i={{$institute->id}}" class="btn btn-xs btn-info">Candidates</a>
				<a href="{{url('payments')}}?i={{$institute->id}}" class="btn btn-xs btn-info">Payments</a>
				<a href="{{url('examapplications')}}?i={{$institute->id}}" class="btn btn-xs btn-info">Exam Applications</a>
			</div>
			<div class="col-md-12">
				<br />
				@if($institute->approvedprogrammes->count() > 0)
					<table class="table table-bordered table-striped">
						<thead>
						<tr>
							<th>Programme</th>
							<th>Max Intake</th>
							<th>Candidates Applied</th>
							<th>Payments marked for</th>
							<th>Approved</th>
							<th>Rejected</th>
							<th>Pending</th>
						</tr>
						</thead>
						<tbody>
						@foreach($institute->approvedprogrammes as $ap)
							@if($ap->academicyear_id==Session::get('academicyear_id'))
								@php
									$approved = $ap->candidates()->statuscount($ap->id,'2')->count();
                                    $rejected = $ap->candidates()->statuscount($ap->id,'3')->count();
                                    $pending = $ap->candidates()->statuscount($ap->id,'1')->count();
								@endphp
								<tr>
									<th>{{$ap->programme->name}}</th>
									<th>{{$ap->maxintake}}</th>

									<th><a href="{{url('candidateapplications')}}?p={{$ap->id}}">{{$ap->candidates->count()}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a></th>

									<th><a href="{{url('payments')}}?i={{$institute->id}}">{{$ap->paid_for}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a></th>
									<th><a href="{{url('candidateapplications')}}?s=2&p={{$ap->id}}">{{$approved}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a></th>
									<th><a href="{{url('candidateapplications')}}?s=3&p={{$ap->id}}">{{$rejected}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a></th>
									<th><a href="{{url('candidateapplications')}}?s=1&p={{$ap->id}}">{{$pending}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a></th>
								</tr>
							@endif
						@endforeach
						</tbody>
					</table>
				@endif
			</div>
		</div>
	</div>

	<form action="/institute/{{$institute->id}}/update" method="get">
		<div id="edit_modal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Edit
					</div>
					<div class="modal-body">
						{!! Form::bsText('username','Code',$institute->user->username) !!}
						{!! Form::bsText('name','Name',$institute->name) !!}
						{!! Form::bsText('password','Password',$institute->user->confirmation_code) !!}
						{!! Form::bsText('enrolmentcode', 'Center Number', $institute->enrolmentcode) !!}
						{!! Form::bsText('email','Email',$institute->email) !!}
						{{--
                        {!! Form::bsText('address','Address',$institute->address) !!}
                        --}}
						{!! Form::bsText('contactnumber1','Contact No',$institute->contactnumber1) !!}
						{!! Form::bsText('contactnumber2','Alternative Contact No',$institute->contactnumber2) !!}
						{!! Form::bsText('pincode','Pincode',$institute->pincode) !!}

					</div>
					<div class="modal-footer">
						<button type='submit' class="btn btn-primary pull-right">Update</button>
						<button type='button' class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<script>
        function edit(id){
            $('#edit_modal').modal('show');
        }
		@if(Request::has('mode'))
        $(document).ready(function(){
            $('#edit_modal').modal('show');
        });
		@endif
	</script>



@endsection