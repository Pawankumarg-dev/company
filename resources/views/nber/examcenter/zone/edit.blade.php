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
                <h4>District - Zone</h4>
				@include('common.errorandmsg')
				<form action="{{ url('nber/examcenter/zone/') }}/{{$district->id}}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="_method" value="PUT"> 

                    <button class="btn  mb-2 btn-primary btn-xs pull-right" style="position: absolute;right:15px;top:10px;">Save</button> 
                	<a href="{{ url('nber/examcenter/zone/') }}" style="position: absolute;right:55px;top:10px;"
                    class="btn btn-success btn-xs mb-2 pull-right">Back</a>

					<table class="table table-bordered table-condensed">
						<tr>
							<th>
								District
							</th>
							<td>
								{{$district->name}} ({{$district->state}})
							</td>
						</tr>
						<tr>
							<th>Zone/Exam Center</th>
							<td>
								<select name="statezone_id" id="statezone_id" class="edit-field">
									<option value="0" disabled>--Please Select--</option>
									@foreach($statezones as $state)
										<option value="{{$state->id}}" @if($state->id == $district->statezone_id) selected @endif>{{$state->name}} ({{$state->state}})</option>
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
