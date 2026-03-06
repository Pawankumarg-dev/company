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
                <h4> Evaluation Center</h4>
				@include('common.errorandmsg')
					<a href="{{url('nber/exam/evaluationcenter')}}/{{$evaluationcenter->id}}?downloadall=1"
						style="position: absolute;right:15px;top:10px;" class="btn  mb-2 btn-primary btn-xs pull-right"
						>Download All Application Details</a>
					<table class="table table-bordered table-condensed">
						<tr>
							<th>Evaluation Center</th>
							<td>
								<b>
									{{$evaluationcenter->code}} - {{$evaluationcenter->name}}
								</b>
							</td>
						</tr>
						<tr>
							<th>Exam Centers</th>
							<td>
								@if($examcenters->count() > 0)
									<table class="table table-bordered table-condensed">
										<tr>
											<th>Exam Center Code</th>
											<th>Exam Center</th>
										</tr>
										
										@foreach($examcenters as $ec)
											<tr>
												<td>
													{{$ec->externalexamcenter->code}} 
												</td>
												<td>
													{{$ec->externalexamcenter->name}}
												</td>
											</tr>
										@endforeach
									</table>
								@endif
							</td>
						</tr>
						<tr>
							<th>No Of Papers</th>
							<td>
								<table class="table table-bordered table-condensed">
									<tr>
										<th rowspan="2">
											Course
										</th>
										<th rowspan="2">
											No of Papers (Applied)
										</th>
										<th colspan="3">Attendance</th>
										<th rowspan="2">Evaluated</th>
										<th rowspan="2">Applications</th>
									</tr>
									<tr>
										<th>Present</th>
										<th>Absent</th>
										<th>Pending</th>
									</tr>
									@foreach($courses as $subject)
									<tr class="@if($subject->pending == 0 && $subject->present == $subject->evaluated) bg-success @else bg-danger @endif">
										<td>
											{{$subject->course_name}}
										</td>
										<td class="text-center">
											{{$subject->nofpappers}}
										</td>
										<td class="text-center">
											{{$subject->present}}
										</td>
										<td class="text-center">
											{{$subject->absent}}
										</td>
										<td class="text-center">
											{{$subject->pending}}
										</td>
										<td class="text-center">
											{{$subject->evaluated}}
										</td>
										<td>
											<a href="{{url('nber/exam/evaluationcenter')}}/{{$evaluationcenter->id}}?programme_id={{$subject->programme_id}}"
												class="btn   btn-primary btn-xs"
												>Download Application Details</a>
										</td>
									</tr>
									@endforeach
								</table>
							</td>
						</tr>
						<tr>
							<th>No Of Papers</th>
							<td>
								<table class="table table-bordered table-condensed">
									<tr>
										<th rowspan="2">
											Course
										</th>
										<th rowspan="2">
											Subject
										</th>
										<th rowspan="2">
											No of Papers
										</th>
										<th colspan="3">Attendance</th>
										<th rowspan="2">Evaluated</th>
										<th rowspan="2">Applications</th>
									</tr>
									<tr>
										<th>Present</th>
										<th>Absent</th>
										<th>Pending</th>
									</tr>
									@foreach($sa as $subject)
									<tr  class="@if($subject->pending == 0 && $subject->present == $subject->evaluated) bg-success @else bg-danger @endif">
										<td>
											{{$subject->course_name}}
										</td>
										<td>
											{{$subject->scode}} - {{$subject->sname}}
										</td>
										<td class="text-center">
											{{$subject->nofpappers}}
										</td>
										<td class="text-center">
											{{$subject->present}}
										</td>
										<td class="text-center">
											{{$subject->absent}}
										</td>
										<td class="text-center">
											{{$subject->pending}}
										</td>
										<td class="text-center">
											{{$subject->evaluated}}
										</td>
										<td>
											<a href="{{url('nber/exam/evaluationcenter')}}/{{$evaluationcenter->id}}?subject_id={{$subject->id}}"
												class="btn   btn-primary btn-xs"
												>Download Application Details</a>
										</td>
									</tr>
									@endforeach
								</table>
							</td>
						</tr>
					</table>
				</form>
            </div>
        </div>
    </div>
@endsection
