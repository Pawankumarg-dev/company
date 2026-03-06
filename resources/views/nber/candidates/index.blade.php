@extends('layouts.app')

@section('content')
	<style>
		body{
			background:white!important;
		}
	</style>
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<ul class="breadcrumb" style="background:transparent!important;">
					<li><a href="{{url('/nber/admissions')}}">Admissions</a></li>
					<li> {{$ap->programme->course_name}}  - {{$ap->academicyear->year}} - {{$ap->institute->name}} - ({{$ap->institute->user->username}}) </li>
					@if($candidates->count() <= $ap->maxintake)
						<!-- @if($ap->academicyear->current!=1 && \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id == 2)
					
						@endif -->
						@if($ap->academicyear_id < 12)			
						<a  class="btn btn-primary btn-bc hidden" style="color:white; margin-left: 250px;" href="{{url('classroomattendance')}}/{{$ap->id}}/25">Class Room Attendance</a>
						<a  class="btn btn-primary btn-bc hidden" style="color:white;" href="{{url('democlassroomattendance')}}/{{$ap->id}}/25">Demo Class Room Attendance</a>   
						@endif
						
						{{-- @if($ap->academicyear_id < 12)
						<a  class="btn btn-primary pull-right btn-bc hidden" style="color:white;" href="{{url('nber/candidate/create/'.$ap->id)}}">Add Candidate</a>  
						@endif --}}
						@if(\App\Nberstaff::where('user_id',Auth::user()->id)->first()->admin==1)
								<!--<a  class="btn btn-primary pull-right btn-bc" style="color:white;" href="{{url('nber/candidate/create/'.$ap->id)}}">Add Candidate</a>  -->
						@endif
						{{-- @if($ap->id == 8769)
						<a  class="btn btn-primary pull-right btn-bc " style="color:white;" href="{{url('nber/candidate/create/'.$ap->id)}}">Add Candidate</a>  
						@endif
						@if($ap->enable_admission == 1)
						<a  class="btn btn-primary pull-right btn-bc " style="color:white;" href="{{url('nber/candidate/create/'.$ap->id)}}">Add Candidate</a>  
						@endif --}}
						<a href="{{url('pdf')}}/{{$ap->id}}" class="btn btn-default pull-right  btn-bc" style="display:none;margin-right: 10px!important;"><i class="fa fa-print"></i> Print</a>
					@endif
				</ul>
			</div>
		</div>
		@include('common.errorandmsg')
		
		<div class="row">
			<div class="col-md-12">
				@if((!is_null($declaration) && !is_null($declaration->opt_verified_on) || $ap->academicyear_id < 12))		
				
				@if(!is_null($declaration) && !is_null($declaration->opt_verified_on))
				<div class="alert alert-info">
					Candiate data verification declaration form is uploaded by TTI. Click  
					
					<button type="button" class="btn btn-secondary btn-xs " data-toggle="modal" data-target="#myDeclarationModal" id="modalbtn"> here</button>
					to view the form.
				</div>

				@else
					<div class="alert alert-danger">
						Declaration is not uploaded.
					</div>
				@endif

				<div id="myDeclarationModal" class="modal  fade" role="dialog">
					<div class="modal-dialog " style="width:90%;">
						<div class="modal-content">
							<div class="modal-header">
								<h5><b>Declaration</b></h5>
							</div>
							<div class="modal-body">
								<p>
									I hereby declare that the candidates are admitted as per the norms and the details uploaded have been verified by me based on the candidate's original school certificates / mark sheets and goverment certificates.
									
									
									The details verified are as below: 
			
								</p>
								<ul>
									<li>
										Name of the candidate
									</li>
									<li>Father’s / Husband name                             </li>
									<li> Address</li>
									<li>Date of Birth                            </li>
									<li>Email</li>
									<li>Mobile number</li>
									<li>Colour scanned copies of original qualification  document</li>
									<li>Colour recent photo</li>
									<li>Eligibility conditions as per the norms</li>
								</ul>
								<p>
									Further, it is to mention that the candidate is informed to verify email & mobile number with OTP for payment of enrolment fees and generation of PRN number. I hereby take the responsibility of all the 
										 {{$declaration->no_of_candidates}} 
									candidates uploaded by the institute.  I do understand any corrections in the details of the students will not be accepted by NBER - RCI.
			
								</p>


	
								<p>
									<div class="form-group">
										<label for="name" class="control-label">Institute</label>
										<input type='text' name='course' disabled value="{{$ap->institute->rci_code}} - {{$ap->institute->name}}"  id="course" class="form-control"/>
									</div>
									<div class="form-group">
										<label for="name" class="control-label">Course</label>
										<input type='text' name='course' disabled value="{{$ap->programme->course->name}} - {{$ap->academicyear->year}} Batch"  id="course" class="form-control"/>
									</div>
									<div class="form-group">
										<label for="name" class="control-label">Name of the Course Coordinator / HOD</label>
										<input type='text' name='name'  disabled id="name" class="form-control" value="{{$declaration->name}}" />
									</div>
									<div class="form-group">
										<label for="name" class="control-label">Email Address</label>
										<input type='email' name='email' id="email"  class="form-control" disabled  value="{{$declaration->email}}"/>
									</div>
									<div class="form-group">
										<label for="name" class="control-label">Phone Number</label>
										<input type='text' name='mobile' id="mobile"  class="form-control" disabled  value="{{$declaration->mobile}}"/>
									</div>
									<div class="form-group">
										<label for="name" class="control-label">Email OTP Verified On </label>
										<input type='text' name='mobile' id="mobile"  class="form-control" disabled  value="{{\Carbon\Carbon::parse($declaration->opt_verified_on)->toDateTimeString()}}"/>
									</div>
									
									
								</p>
							</div>
							<div class="modal-footer">
								
								<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			@endif
				<table class="table table-striped">
					<tr>
						<th>Sl No</th>
						@if(Auth::user()->id == 88387)
							{{--<th>
								<input type="checkbox" name="mark_all">Change Mark</input>
								
							</th>
							<th>
								<input type="checkbox" name="data_all">Change Data</input>
								
							</th>
							<th>
								<input type="checkbox" name="incomplete_all">Incomplete</input>
								
							</th>--}}
						@endif
						<th>Name</th>
						<th>Enrolment Number</th>
						<th>Date of Birth</th>
						<th>Email</th>
						<th>Mobile Number</th>
						<th>Status</th>
						<th>Links</th>
					</tr>

					@if($candidates->count() > 0)
					<?php $slno = 1; ?>
					<form action="{{url('nber/enableedit')}}" method="post">
						<input type="hidden" name='apid' value="{{$ap->id}}">
						{{ csrf_field() }}
						@foreach($candidates->sortBy('enrolmentno') as $c)
							<tr>
								<td>
									{{$slno}}
									<?php $slno++; ?>
								</td>
								@if(Auth::user()->id == 88387)
								{{--<td>
									<input type="checkbox" class="mark_all"  name="mark_{{$c->id}}" 
									@if($c->currentapplicant && $c->currentapplicant->modify_mark) checked @endif 
									@if(is_null($c->currentapplicant)) disabled @endif
									/>
								</td>
								<td>
									<input type="checkbox" class="data_all"  name="data_{{$c->id}}" @if($c->modify_data) checked @endif />
								</td>
								<td>
									<input type="checkbox" class="incomplete_all"  name="incomplete_{{$c->id}}" 
									@if($c->currentapplicant && $c->currentapplicant->incomplete) checked @endif 
									@if(is_null($c->currentapplicant)) disabled @endif
									/>
								</td>--}}
								@endif
								<td>
									{{$c->name}}
									
								</td>
								<td>
									{{$c->enrolmentno}}
								</td>
								
								<td>
									{{\Carbon\Carbon::parse($c->dob)->format('d-m-Y')}}
								</td>
								<td>
									{{$c->email}}
									@if($c->email_otp_verified_on == '')
										<span class="label label-xs label-danger">Not Verified</span>
									
									@else
								
					
										<span class="label label-xs label-info">Verified</span>

									@endif
								</td>
								<td>
									{{$c->contactnumber}} 
									@if($c->is_mobile_number_verified == 'Yes')
										{{--<i class="fa fa-question verification_mark_{{$c->id}}"  style="color:red"></i> --}}
										<span class="label label-xs label-info">Verified</span>

										{{--<a class="verify_link_{{$c->id}} btn btn-xs btn-primary" href="javascript:verifymobile({{$c->id}},{{$c->contactnumber}} );">Verify</a> --}}
									@else
									{{--<<i class="fa fa-check" style="color:blue" title="Verified on {{$c->mobile_otp_verified_on}}"></i> --}}
									<span class="label label-xs label-danger">Not Verified</span>

									@endif
										<a href="javascript:changemobile({{$c->id}},'{{$c->name}}');"  class="btn btn-xs btn-warning hidden">Change Mobile Number </a>
								</td>
								<td>{!!$c->statushtml()!!}
								@if(is_null($c->aadhar))
										<span class='label label-danger hidden'>Aadhar Number Missing</span>
									@endif
								</td>
								<td>
								{{-- @if($c->status_id!=2 || $c->enable_name_edit == 1 || Auth::user()->id == 55540 ) 
								<a href="{{url('nber/candidate/edit').'/'.$c->id}}" class="btn btn-info btn-xs hidden"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>
								@endif
								 --}}
								@if(Auth::user()->id == 239184 || Auth::user()->id==87567 ||  Auth::user()->id==99540 || Auth::user()->id==87569 || Auth::user()->id==87568 || Auth::user()->id==88387)
									<a href="{{url('nber/candidate/edit').'/'.$c->id}}" class="btn btn-info btn-xs "><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>
								@endif
			

									<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal{{$c->id}}"><i class="fa fa-eye"></i> &nbsp;Quick View</button>
									<input type="hidden" value="{{$c->id}}">
									<a  class="btn btn-default btn-xs"  href="{{url('nber/candidate')}}/{{$c->id}}"><i class="fa fa-eye"></i> &nbsp;Details</a>


						
									{{-- {{\App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id}} --}}
									<?php $nid = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id ; ?>
									{{-- @if( $nid == 2 )
						<a href="{{url('nber/candidate/edit').'/'.$c->id}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>

						@endif --}}

									@if($ap->academicyear->current==1)
									{{-- <a href="{{url('nber/candidate/edit').'/'.$c->id}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a> --}}

									{{--

										@if($c->status_id == 2)
										@else
											<a href="{{url('nber/candidate/edit').'/'.$c->id}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>
										@endif
										<a href="javascript:confirm('{{$c->id}}','{{$c->name}}')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
										--}}
										
										{{--<a href="{{url('candidate/edit').'/'.$c->id}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>
										<a href="javascript:confirm({{$c->id}},'{{$c->name}}');" class="btn btn-danger btn-xs"><i class="fa fa-delete"></i>&nbsp;&nbsp;Delete</a> 
										
									@else
										@if($ap->academicyear->current!=1 && \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id == 2)
										
										<a href="javascript:confirm('{{$c->id}}','{{$c->name}}')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
										<a href="{{url('nber/candidate/edit').'/'.$c->id}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>
										@endif--}}
									@endif

								{{--	@if(\App\Nberstaff::where('user_id',Auth::user()->id)->first()->admin==1)
										<a href="javascript:confirm('{{$c->id}}','{{$c->name}}')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
										<a href="{{url('nber/candidate/edit').'/'.$c->id}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a> 
									@endif --}}
									<a href="javascript:confirm({{$c->id}},'{{$c->name}}')" class="btn btn-danger btn-xs hidden"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
									
									<a href="{{url('nber/hallticket/')}}/{{$c->id}}" class="btn btn-info btn-xs hidden">Hallticket</a> 

								</td>
							</tr>
						@endforeach
						<button type="submit" class="btn btn-primary btn-sm pull-right hidden"> Update</button>
					</form>
					@endif
				</table>
				
			</div>
		</div>

		
	</div>
	<input type="hidden" id="mobile-number">
	<input type="hidden" id="candidate-id">
	<input type="hidden" id="mobile-number-verification-code">
	<input type="hidden" id="email-address-verification-code">
	
	<input type="hidden" id="verifying" value="enrolment">
	<input type="hidden" id="email-address">
	<script>
		$(document).ready(function () {
			$('input[name="mark_all"]').on('change',function () {
				var sel = $("input[name='mark_all']:checked").val();
				if(sel){
					$('.mark_all').attr('checked',true);
				}else{
					$('.mark_all').attr('checked',false);
				}
			});
			$('input[name="data_all"]').on('change',function () {
				var sel = $("input[name='data_all']:checked").val();
				if(sel){
					$('.data_all').attr('checked',true);
				}else{
					$('.data_all').attr('checked',false);
				}
			});
			$('input[name="incomplete_all"]').on('change',function () {
				var sel = $("input[name='incomplete_all']:checked").val();
				if(sel){
					$('.incomplete_all').attr('checked',true);
				}else{
					$('.incomplete_all').attr('checked',false);
				}
			});
        });
		function changemobile(id,name){
			swal({
                title: 'Change Mobile number for '  + name  ,
                text: "Enter the 10 digit mobile number ",
				input: 'text',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Update!',
				inputValidator: (value) => {
					if (!(parseInt(value) > 6000000000 && parseInt(value) < 9999999999)) 
					{
						return 'Please enter a valid mobile number'
					}
					else {
						var formData = new FormData();
						var token = $('input[name=_token]');
						formData.append('id', id);
						formData.append('contactnumber', value);
						$.ajax({
							url: '{{url("nber/editmobile")}}',
							method: 'POST',
							dataType: 'json',
							contentType: false,
							processData: false,
							headers: {
								'X-CSRF-TOKEN': token.val()
							},
							data: formData,
							success: function (data) {
								console.log(data);
								if(data=='success'){
									swal({
										type: 'success',
										title: 'Mobile Number Updated',
										showConfirmButton: false,
										timer: 3000
									});
									setTimeout(function(){
										location.reload();
									}, 3000); 
								}else{
									if(data=='duplicate'){
										swal({
											type: 'warning',
											title: 'Duplicate mobile number',
											showConfirmButton: false,
											timer: 1500
										});
									}else{
										swal({
											type: 'warning',
											title: 'Could not update mobile number',
											showConfirmButton: false,
											timer: 1500
										});
									}
								}
							},
							error: function (data) {
								if(data.responseText == '{"contactnumber":["The contactnumber has already been taken."]}'){
									swal({
										type: 'warning',
										title: 'Mobile number is already been taken.',
										showConfirmButton: false,
										timer: 1500
									});
								}else{
									swal({
									type: 'warning',
									title: 'Could not update mobile number, please make sure a valid mobile number is given.',
									showConfirmButton: false,
									timer: 1500
								});
								}
								
							}
						});
					}
				},
            }).then((result) => {
                
            })
			$('.swal2-input').attr('maxlength',10);
		}

		function verifymobile(id,mobile_no){
			$('#mobile-number').val(mobile_no);
			$('#candidate-id').val(id);
			displayMobileNoVerificationModal();
		}
		function verifyemail(id,email){
			$('#email-address').val(email);
			$('#candidate-id').val(id);
			displayEmailAddressVerificationModal();
		}
        function confirm(id,name){
            swal({
                title: 'Are you sure?',
                text: "Delete candidate " + name ,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete!'
            }).then((result) => {
                if (result.value) {
                    window.location.replace("{{url('/nber/candidate/delete')}}/"+id);

                }
            })
        }

		function changename(id,name){
			swal({
                title: 'Change Name of '  + name  ,
                text: "Enter the correct name ",
				input: 'text',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Update!',
				inputValidator: (value) => {
					if (value == '') 
					{
						return 'Name cannot be empty!'
					}
					else {
						var formData = new FormData();
						var token = $('input[name=_token]');
						formData.append('id', id);
						formData.append('name', value);
						$.ajax({
							url: '{{url("nber/updatename")}}',
							method: 'POST',
							dataType: 'json',
							contentType: false,
							processData: false,
							headers: {
								'X-CSRF-TOKEN': token.val()
							},
							data: formData,
							success: function (data) {
								console.log(data);
								if(data=='success'){
									swal({
										type: 'success',
										title: 'Name Updated',
										showConfirmButton: false,
										timer: 3000
									});
									setTimeout(function(){
										location.reload();
									}, 3000); 
								}else{
									swal({
										type: 'warning',
										title: 'Could not update name',
										showConfirmButton: false,
										timer: 1500
									});
								}
							},
							error: function (data) {
								swal({
									type: 'warning',
									title: 'Could not update name',
									showConfirmButton: false,
									timer: 1500
								});
							}
						});
					}
				},
            }).then((result) => {
                
            })
		}

		function changeeno(id,name){
			swal({
                title: 'Change/Add enrolment no of '  + name  ,
                text: "Enter the correct enrolmentno ",
				input: 'text',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Update!',
				inputValidator: (value) => {
					if (value == '') 
					{
						return 'Enrolmentno cannot be empty!'
					}
					else {
						var formData = new FormData();
						var token = $('input[name=_token]');
						formData.append('id', id);
						formData.append('eno', value);
						$.ajax({
							url: '{{url("nber/updateeno")}}',
							method: 'POST',
							dataType: 'json',
							contentType: false,
							processData: false,
							headers: {
								'X-CSRF-TOKEN': token.val()
							},
							data: formData,
							success: function (data) {
								console.log(data);
								if(data=='success'){
									swal({
										type: 'success',
										title: 'EnrolmentNo Updated',
										showConfirmButton: false,
										timer: 3000
									});
									setTimeout(function(){
										location.reload();
									}, 3000); 
								}else{
									swal({
										type: 'warning',
										title: 'Could not update Enrolmentno',
										showConfirmButton: false,
										timer: 1500
									});
								}
							},
							error: function (data) {
								swal({
									type: 'warning',
									title: 'Could not update Enrolmentno',
									showConfirmButton: false,
									timer: 1500
								});
							}
						});
					}
				},
            }).then((result) => {
                
            })
		}
	</script>
    {{--@include('institute.common.otpverificationmodel')
    @include('institute.common.otpverificationjs') --}}

	@foreach($candidates->sortBy('enrolmentno') as $c)
        @include('nber.candidates.view')
	@endforeach
@endsection
