@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4>Evaluation Centers</h4>
				@include('common.errorandmsg')

				<a href="{{url('nber/evaluationcenter/create')}}" style="position: absolute;right:15px;top:10px;" class="btn  mb-2 btn-primary btn-xs pull-right">Add New</a>
				
				<table class="table table-bordered table-condensed">
					<tr>
						<th>Slno</th>
						<th>Evaluation Center Code</th>
						<th>Evaluation Center</th>
						<th>Address</th>
						<th>State</th>
						<th>Details / Edit</th>
					</tr>
					<?php $slno = 1; ?>
					@foreach($evaluationcenters as $ec)
						<tr>
							<td>{{$slno}}
								<?php $slno++ ; ?>
							</td>
							<td>{{$ec->code}}</td>
							<td>{{$ec->name}}</td>
							<td>{{$ec->address}}</td>
							<td>{{$ec->lgstate ? $ec->lgstate->state_name  : $ec->state }}</td>
							<td>
								<a href="{{url('nber/evaluationcenter/')}}/{{$ec->id}}" class="btn btn-xs btn-primary">View</a>
								<a href="{{url('nber/evaluationcenter/')}}/{{$ec->id}}/edit" class="btn btn-xs btn-secondary">Edit</a>
							</td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
@endsection