@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row">
			<div class="alert alert-success">
                <ul>
                    <li>
                        Before mapping, please check the exam center details and ensure all information is correct.
                    </li>
                   <li>
						If you need to update the exam center information, please go to "Others" and select "Exam Center".
					</li>
                    <li>
                        Please do not map more than the maximum capacity.
                    </li>
					<li>
                        For Mapping of exam Center Click on Add new Mapping.
                    </li>
                </ul>
            </div>
			<div class="col-sm-12">
				<h4>Exam Centers - {{$examname}}</h4>

				@include('common.errorandmsg')
 
				<table style="position: absolute;right:15px;top:10px;">
					<tr>
						{{-- <td>
							@if($show=='all')
								<a href="{{url('nber/exam/examcenter')}}?show=ec"   style="margin-right:10px;" class="btn  mb-2 btn-warning btn-xs pull-right">Show only Exam Centers</a>
							@else
								<a href="{{url('nber/exam/examcenter')}}?show=all"   style="margin-right:10px;" class="btn  mb-2 btn-warning btn-xs pull-right">Show Complete Mapping with Institute </a>
							@endif
						</td> --}}
						{{-- <td>
							<a class="btn  mb-2 btn-info btn-xs pull-right" style="margin-right:10px;" href="{{ url('nber/exam/examcenter') }}?download=1">Download</a>
						</td> --}}
						<td>
							<a href="{{url('nber/exam/examcenter/create')}}"  class="btn  mb-2 btn-primary btn-xs pull-right">Add New Mapping</a>
						</td>
						
					</tr>
				</table>
				
				
				<table class="table table-bordered table-condensed">
					<tr>
						<th>Slno</th>
						<th>Exam Center Code</th>
						<th>Exam Center</th>
						<th>Exam Center Address</th>
						<th>Contact</th>
												<th>Total Mapped</th>

						<th class="hidden">
							Question Papers Downloaded 
						</th>
						<th  class="hidden">
							Question Papers History
						</th>
						{{-- <th>Evaluation Center</th>
						
						<th>Confirmation</th>
						<th>No of students</th>
						<th>Hallticket</th> --}}
						
					</tr>
					<?php $slno = 1; ?>
					@foreach($examcenters->sortBy('institute.rci_code') as $ec)
					@if(!is_null($ec->externalexamcenter))
					
						<tr>
							<td>{{$slno}}
								<?php $slno++ ; ?>
							</td>
							<td>
								{{$ec->externalexamcenter->code}}
								<small class="text-muted">
									Temp Code : {{ $ec->externalexamcenter->id }}
								</small>
							</td>
							<td>
								<a href="{{url('nber/excenter')}}/{{$ec->externalexamcenter_id}}" target="_blank">
								{{$ec->externalexamcenter->name}}
								</a>
							</td>
							<td>
								{{$ec->externalexamcenter->address}}
								<br />
{{ $ec->externalexamcenter->lgdistrict->districtName ?? 'N/A' }}								<br />
								{{$ec->externalexamcenter->lgstate->state_name}}
								<br />
								PIN: {{$ec->externalexamcenter->pincode}}
							
							</td>
							<td>
								Contact Persion:{{$ec->externalexamcenter->contactperson}} <br />
								Mobile:{{$ec->externalexamcenter->contactnumber1}}<br />
								Email:{{$ec->externalexamcenter->email1}}
							</td>

							<td>
								<strong>Total capacity: {{ $ec->externalexamcenter->setting_capacity ?? 'Shitting Capacity not Added by NBER' }}</strong>

								<table class="table table-bordered mt-2">
									<thead>
										<tr>
											<th>NBER</th>
											<th>Institute</th>

											<th>Allocated</th>
											<th>Mapped date</th>
											<th>Edit</th>

										</tr>
									</thead>
									<tbody>
										@php
											$nberIds = explode(',', $ec->nber_ids ?? '');
											$maxCandidates = explode(',', $ec->max_candidates ?? '');
											$institute = explode(',', $ec->rci_code ?? '');
											$mapped_at = explode(',', $ec->mapped_at ?? '');
											$edit_id = explode(',', $ec->edit_id ?? '');
											$total=0;

										@endphp

										@if(!empty($nberIds[0]))
											@foreach($nberIds as $key => $nberId)
												<tr>
													<td>{{ \App\Nber::find($nberId)->name_code ?? 'N/A' }}</td>
													<td>{{ $institute[$key] ?? '0' }}</td>
													<td>{{ $maxCandidates[$key] ?? '0' }}</td>

													<td>{{ $mapped_at[$key] ?? 'Na' }}</td>

													<td>
														<a href="{{url('/')}}/nber/exam/examcenter/{{$edit_id[$key]}}">Remove</a>
													</td>

												<?php $total= $total + $maxCandidates[$key] ?? '0'; ?>
												</tr>
											@endforeach
											<tr>

												@if($total>$ec->externalexamcenter->setting_capacity ?? 0) <script>
alert("{{ $ec->externalexamcenter->code }} Mapped more than seating capacity");
</script> @endif
												<td @if($total>$ec->externalexamcenter->setting_capacity ?? 0) style="color:red" @endif><strong>Mapped Student:</strong> {{$total}} </td>
											</tr>
										@else
											<tr>
												<td colspan="2">No allocations</td>
											</tr>
										@endif
									</tbody>
								</table>
							</td>




							<td class='hidden'>
								<a href="{{url('nber/excenter')}}/{{$ec->externalexamcenter_id}}?req=otp" target="_blank" class="btn btn-xs btn-danger">
									Disable OTP
									</a>
							</td>
							
							<td class="text-center hidden">
								@if($ec->externalexamcenter->questionpaperotps->count() > 0)
									{{ $ec->externalexamcenter->questionpaperotps()->where('exam_id',27)->count() }}
								@else 
									0
								@endif
							</td>

							<td class="text-center hidden">
								@if($ec->externalexamcenter->questionpaperdownloadhistories->count() > 0)
									{{ $ec->externalexamcenter->questionpaperdownloadhistories()->where('id','>',8054)->count() }}
								@else 
									0
								@endif
							</td>
							
						{{-- <td>
							@if(!is_null($ec->states) && $ec->states->count() > 0)
								@foreach($ec->states as $state)
									<span class="badge text-bg-info">
									{{$state->state_name}} 
									</span>

									@if($state->pivot->statezone_id > 0)
									<span class="badge text-bg-warning" style="background-color:blue;">
										{{\App\Statezone::find($state->pivot->statezone_id)->name}}
									</span>
									@endif
								@endforeach
							@endif
							<a href="{{url('nber/exam/examcenter/')}}/{{$ec->id}}/edit" class="btn btn-xs btn-secondary">Modify</a>
						</td> --}}
						
						@if($show=='all')
							<td class="hidden">
								@if(!is_null($ec->institute->rci_code)) {{ $ec->institute->rci_code }} @endif - {{ $ec->institute->name }} <br />
								@if(!is_null($ec->institute->district_id)) {{$ec->institute->district->districtName}} @endif <br />
								{{ $ec->institute->state->state_name}} 
							</td>
						@endif
						<td class="hidden"></td>
							<td class="hidden">
								{{-- <input type="checkbox" data-id="{{$ec->externalexamcenter->id}}" @if($ec->externalexamcenter->confirm_availability == 1) data-chkval="1" @else data-chkval="0" @endif class="confirmation availability availability_{{ $ec->externalexamcenter->id }}"> Availability <br />
								<input type="checkbox" data-id="{{$ec->externalexamcenter->id}}" @if($ec->externalexamcenter->confirm_address == 1)  data-chkval="1" @else data-chkval="0" @endif class="confirmation address address_{{ $ec->externalexamcenter->id }}"> Address<br />
								<input type="checkbox" data-id="{{$ec->externalexamcenter->id}}" @if($ec->externalexamcenter->confirm_mobile == 1)  data-chkval="1" @else data-chkval="0" @endif class="confirmation mobile mobile_{{ $ec->externalexamcenter->id }}"> Mobile 		<br />					
								<input type="checkbox" data-id="{{$ec->externalexamcenter->id}}" @if($ec->externalexamcenter->confirm_email == 1)  data-chkval="1" @else data-chkval="0" @endif class="confirmation email email_{{ $ec->externalexamcenter->id }}"> Email 							 --}}
							</td>
							<td class="hidden">
								@if($show=='all')
									<?php
									$institutes = \App\Examcenter::where('exam_id',Session::get('exam_id'))->where('externalexamcenter_id',$ec->externalexamcenter_id)->pluck('institute_id')->toArray();
										$students = \App\Maxstudent::where('exam_id',Session::get('exam_id'))->whereIn('institute_id',$institutes)->sum('max_student');
										// $ms = \App\Maxstudent::where('institute_id',$ec->institute_id)->first();
										// if(!is_null($ms)){
										// 	$students = $ms->max_student;
										// }else{
										// 	$students = 0;
										// }
									?>
								@else
									<?php 
										$institutes = \App\Examcenter::where('exam_id',Session::get('exam_id'))->where('externalexamcenter_id',$ec->externalexamcenter_id)->pluck('institute_id')->toArray();
										$students = \App\Maxstudent::where('exam_id',Session::get('exam_id'))->whereIn('institute_id',$institutes)->sum('max_student');
									?>
										
								@endif
								{{ $students }}
							</td>
							<td class="hidden">Not generated</td>
						@if($show=='all')
							{{-- <td> --}}
								{{-- <form action="{{ url('nber/exam/examcenter') }}/{{ $ec->id }}" method="post">
									<input type="hidden" name="_method" value="DELETE">
									 {{ csrf_field() }}
								<button class="btn btn-xs btn-danger">Delete</button>
							</form> --}}
							{{-- <a class="btn btn-xs btn-warning" href="{{ url('nber/excenter/')}}/{{$ec->externalexamcenter->id}}/edit">Edit Exam Center Details</a>		 --}}
							{{-- </td> --}}
						@endif
						{{-- @if($show=='ec')
						<td>
							<a class="btn btn-xs btn-warning" href="{{ url('nber/excenter/')}}/{{$ec->externalexamcenter->id}}/edit">Edit Exam Center Details</a>
						</td>
						@endif --}}
						
						</tr>
						@endif
					@endforeach
				</table>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			$('.confirmation').each(function(){
				if($(this).data('chkval') == 1){
					$(this).attr('checked',true);
				}else{
					$(this).attr('checked',false);
				}
			});
			$('.confirmation').on('change',function(){
				var type;
				if($(this).hasClass('availability')){
					type = 'availability';
				}
				
				if($(this).hasClass('address')){
					type = 'address';
				}
				
				if($(this).hasClass('email')){
					type = 'email';
				}
				
				if($(this).hasClass('mobile')){
					type = 'mobile';
				}
				var confirmation = 0;
				if($(this).is(":checked")){
					confirmation = 1;
				}
				var token = "{{ csrf_token() }}";
				var formData = new FormData();
				formData.append('id', $(this).data('id'));
				formData.append('confrimation',confirmation);
				formData.append('type',type);
				$.ajax({
					url: '{{url("nber/exam/examcenterstatus")}}',
					method: 'POST',
					dataType: 'json',
					contentType: false,
					processData: false,
					headers: {
						'X-CSRF-TOKEN': token
					},
					data: formData,
					success: function (data) {
					},
					error: function (data) {
						swal({
								type: 'warning',
								title: 'Not updated ',
								showConfirmButton: false,
								timer: 1500
							});
					}
				});
			});
		});
	</script>
@endsection