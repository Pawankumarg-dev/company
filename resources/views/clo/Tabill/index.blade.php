@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4>Bill</h4>
				@include('common.errorandmsg')
              

				<a href="{{url('/clo/tabill/create')}}" style="position: absolute;right:15px;top:10px;" class="btn  mb-2 btn-primary btn-xs pull-right">Apply For T.A</a>
				<table class="table table-bordered table-condensed">
					<tr>
						<th>Slno</th>
						<th>Date</th>
						<th>Exam Details</th>
						{{-- <th>Total Amount</th> --}}
						<th>Approved Amount</th>
						<th>T.A Form</th>
						<th>Clo Report</th>
                        <th>Payment Status</th>
                       
					</tr>
					<?php $slno = 1; ?>
					@foreach($bill as $e)
						<tr>
							<td>{{$slno}}
								<?php $slno++ ; ?>
							</td>
                            <td>{{ \Carbon\Carbon::parse($e->created_at)->format('d/m/Y') }}</td>
                            <td>@if(!is_null($e->exam_id)){{$e->exam->name}}@endif</td>
							{{-- <td>{{$e->demand_amount}}</td> --}}
							<td>{{$e->amount}}</td>
							<td><iframe src="{{ url('/') }}/files/examcenter/TABILL/{{$e->ta_form}}" frameborder="10"></iframe></td>
							<td><iframe src="{{ url('/') }}/files/examcenter/Clo-report/{{$e->clo_report}}" frameborder="10"></iframe></td>
							<td>{{$e->payment_status}} @if($e->payment_status=='reject') :{{$e->reason}} @endif</td>
							<td>
								@if($e->payment_status=='reject')
								<a href="{{url('/')}}/clo/tabill/{{$e->id}}" class="btn btn-xs btn-secondary">Edit</a>
								@endif
							</td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>

@endsection