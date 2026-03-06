@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4>Exam Centers</h4>
				@include('common.errorandmsg')

				<a href="{{url('nber/excenter/create')}}" style="position: absolute;right:15px;top:10px;" class="btn  mb-2 btn-primary btn-xs pull-right">Add New</a>
				
				<table class="table table-bordered table-condensed">
					<tr>
						<th>Slno</th>
						<th>Exam Center Code</th>
						<th>Uploaded By</th>
						<th>Exam Center</th>
						<th>Address</th>
						<th>State</th>
						<th>District</th>
						<th>Details / Edit</th>
						<th>Consent Form</th>
					</tr>
					<?php $slno = 1; ?>
					@foreach($examcenters as $ec)
						<tr>
							<td>{{$slno}}
								<?php $slno++ ; ?>
							</td>
							<td>{{$ec->code}}</td>
							<td>{{ $ec->institute->rci_code }}</td>
							<td>{{$ec->name}}</td>
							<td>{{$ec->address}}</td>
							<td>{{$ec->lgstate ? $ec->lgstate->state_name  : $ec->state }}</td>
							<td>{{$ec->lgdistrict ? $ec->lgdistrict->districtName  : '' }}</td>
							<td>
								<a href="{{url('nber/excenter/')}}/{{$ec->id}}" class="btn btn-xs btn-primary">View</a>
								<a href="{{url('nber/excenter/')}}/{{$ec->id}}/edit" class="btn btn-xs btn-secondary">Edit</a>
							</td>
							<td>
								<a target="_blank" href="{{ url('images/institutes/exam-consent-form') }}/{{ $ec->consent_form }}">Download</a>
							</td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
@endsection