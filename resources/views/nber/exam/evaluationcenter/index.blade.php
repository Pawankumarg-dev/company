@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4>Evaluation Centers - {{$examname}}</h4>

				@include('common.errorandmsg')

				<a href="{{url('nber/exam/evaluationcenter')}}?download=1"
					style="position: absolute;right:15px;top:10px;" class="btn  mb-2 btn-primary btn-xs pull-right"
					>Download Stats</a>
				<table class="table table-bordered table-condensed">
					<tr>
						<th>Slno</th>
						<th>Evaluation Center Code</th>
						<th>Evaluation Center</th>
						<th>Details</th>
					</tr>
					<?php $slno = 1; ?>
					@foreach($evaluationcenters as $ec)
						<tr>
							<td>{{$slno}}
								<?php $slno++ ; ?>
							</td>
							<td>{{$ec->evaluationcenter->code}}</td>
							<td>
								<a href="{{url('nber/evaluationcenter')}}/{{$ec->evaluationcenter_id}}" target="_blank">
								{{$ec->evaluationcenter->name}}
								</a>
							</td>
							<td>
								<a href="{{url('nber/exam/evaluationcenter/')}}/{{$ec->evaluationcenter_id}}" class="btn btn-xs btn-primary">Details</a>
							</td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
@endsection