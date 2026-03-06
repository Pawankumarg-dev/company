@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4>Districts</h4>
				<table class="table table-bordered table-condensed">
					<tr>
						<th>Slno</th>
						<th>State</th>
						<th>District</th>
						<th>Zone/Exam Center</th>
						<th>Details / Edit</th>
					</tr>
					<?php $slno = 1; ?>
					@foreach($districts as $ec)
						<tr>
							<td>{{$slno}}
								<?php $slno++ ; ?>
							</td>
							<td>{{$ec->state}}</td>
							<td>{{$ec->name}}</td>
							<td>{{$ec->statezone ? $ec->statezone->name : ''}}</td>
							<td>
								<a href="{{url('nber/examcenter/zone/')}}/{{$ec->id}}/edit" class="btn btn-xs btn-secondary">Edit</a>
							</td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
@endsection