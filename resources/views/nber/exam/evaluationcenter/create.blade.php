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
                <h4>Add Exam Center</h4>
				@include('common.errorandmsg')
				<form action="{{ url('nber/exam/examcenter/') }}" method="POST">
					{{ csrf_field() }}

                    <button class="btn  mb-2 btn-primary btn-xs pull-right" style="position: absolute;right:15px;top:10px;">Save</button> 
                	<a href="{{ url('nber/exam/examcenter/') }}" style="position: absolute;right:55px;top:10px;"
                    class="btn btn-success btn-xs mb-2 pull-right">Back</a>
					<input type="hidden" name="exam_id" value={{Session::get('exam_id')}}>
					<table class="table table-bordered table-condensed">
						<tr>
							<th>Exam Center</th>
							<td>
								<select name="externalexamcenter_id" id="externalexamcenter_id" class="edit-field">
									<option value="0" disabled>--Please Select--</option>
									@foreach($externalexamcenters as $ec)
										<option value="{{$ec->id}}" > {{$ec->code}} - {{$ec->name}}</option>
									@endforeach
								</select>
							</td>
						</tr>
						<tr>
							<th>For the State</th>
							<td>
								<select name="lgstate_id" id="lgstate_id" class="edit-field">
									<option value="0" disabled>--Please Select--</option>
									@foreach($lgstates as $state)
										<option value="{{$state->id}}">{{$state->state_name}}</option>
									@endforeach
								</select>
							</td>
						</tr>
					</table>
				</form>
            </div>
        </div>
    </div>
@endsection
