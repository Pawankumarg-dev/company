@extends('layouts.app')

@section('content')

<div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                    		@include('common.errorandmsg')
							@if(file_exists(public_path('files/enrolment/photos/'.$c->photo)))
							
							
							@if($c->applications->count()>0)
								@if($c->attendances->where('exam_id','2')->count()>0)
									@if($c->attendances->where('exam_id','2')->first()->attendance_t >= 75)
										<a href='/hallticketdownload?exam_id=2' class="btn btn-xs btn-info"> <i class="fa fa-download"></i> &nbsp;&nbsp; Hallticket</a>
									@else

										@if($c->attendances->where('exam_id','2')->first()->exemption == '2')
											<a href='/hallticketdownload?exam_id=2' class="btn btn-xs btn-info"> <i class="fa fa-download"></i> &nbsp;&nbsp; Hallticket</a>
										@else
											@if($c->attendances->where('exam_id','2')->first()->document_exemption != null)
												@if($c->attendances->where('exam_id','2')->first()->exemption == '1')
													<i class="fa fa-info-circle"></i> &nbsp; Pending approval for Attendance Exemption.
												@endif
												@if($c->attendances->where('exam_id','2')->first()->exemption == '3')
													<i class="fa fa-info-circle"></i> &nbsp; Request for Attendance Exemption is rejected.
												@endif
											@else
												@if($c->attendances->where('exam_id','2')->first()->attendance_t == null)
													<i class="fa fa-info-circle"></i> &nbsp;Attendance not uploaded. Please contact your institute.
												@else
													<i class="fa fa-info-circle"></i> &nbsp;Not enough attendance to appear for Exam.
												@endif											@endif
										@endif
									@endif
								@else
									<i class="fa fa-info-circle"></i> &nbsp;Attendance not uploaded. Please contact your institute.
								@endif
							@else
								<i class="fa fa-info-circle"></i> &nbsp;No Examination Application Found.
							@endif

							@else
								<i class="fa fa-info-circle"></i> &nbsp;Photo is missing.
							@endif
							</div>
						</div>
					</div>
@endsection