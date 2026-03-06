@extends('layouts.app')

@section('content')

<script>
    function validateotp(otp){
        var apid = $('#approvedprogramme_id').val();
        var formData = new FormData();
		formData.append('approvedprogramme_id', apid); 
        formData.append('otp', otp ); 
        var token = $('input[name=_token]');
        $.ajax({
                url: "{{url('declarationform/verifyotp')}}",
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
                },
                error: function (data) {
                    if (data.status === 422) {
                        console.log(data);
                    } else {
                        console.log(data);
                    }
                }
            }).done(function(response) {
                if(response!='success'){
                    swal("Error Occurred!!!", 'Please enter the correct OTP', "error");
                }else{
                    swal("Thank you!!!", '', "success");
					window.location.href = "{{url('enrolment')}}"
                }
            });
    }
    //  function showotpinput(){
    //     swal({
    //             title: 'Enter the OTP' ,
    //             text: "Enter the 6 digit OTP received on your mobile ",
	// 			input: 'text',
    //             showCancelButton: true,
    //             confirmButtonColor: '#d33',
    //             cancelButtonColor: '#3085d6',
    //             confirmButtonText: 'Confirm!',
	// 			inputValidator: (value) => {
	// 				if (!(parseInt(value) >= 99999 && parseInt(value) < 1000000)) 
	// 				{
	// 					return 'Please enter valid OTP'
	// 				}
	// 				else {
	// 					validateotp(value);
	// 				}
	// 			},
    //         }).then((result) => {
                
    //         });
    // }

function showotpinput() {
    while (true) {
        const otp = prompt("Enter the 6-digit OTP received on your mobile:");

        if (otp === null) {
            // User clicked Cancel
            return;
        }

        if (/^\d{6}$/.test(otp)) {
            // Valid OTP
            validateotp(otp);
            return;
        } else {
            alert("Invalid OTP. Please enter a 6-digit number.");
        }
    }
}

    function enabledisableSubmit(type){
        //console.log(type);
        if(type!=='enable'){
            //console.log('disabling');
            $('#sendotp').attr('disabled',true);
            $('.loading').removeClass('hidden');
            $('.save').text('Please wait...');
        }else{
            $('#sendotp').attr('disabled',false);
            $('.loading').addClass('hidden');
            $('.save').text('Submit');
        }
    }
    function sendotp(){
        enabledisableSubmit('disable');
        var validation = true;
        var valstring = 'Please enter correct ';
        
        var name = $('#name').val();
        if(name.length < 3){
            validation = false;
            valstring += " Name ";
        }
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var email = $.trim($('#email').val());
        if(!regex.test(email)){
            validation = false;
            valstring += " email address ";
        }

		var mobile = $.trim($('#mobile').val());
		if(mobile.length < 10){
            validation = false;
            valstring += " Mobile ";
        }
        var fileInput = document.getElementById('file');
    var file = fileInput && fileInput.files.length > 0 ? fileInput.files[0] : null;

    if (!file) {
        validation = false;
        valstring += " PDF file ";
    } else {
        var isPDF = file.type === "application/pdf" || file.name.toLowerCase().endsWith(".pdf");
        var maxSize = 2 * 1024 * 1024; // 5 MB
        if (!isPDF) {
            validation = false;
            valstring += " (File must be a PDF) ";
        } else if (file.size > maxSize) {
            validation = false;
            valstring += " (PDF must be less than 2 MB) ";
        }
    }
        
		var apid = $('#approvedprogramme_id').val();
        if(validation){
            var formData = new FormData();
            formData.append('name', name); 
            formData.append('email', email); 
			formData.append('mobile', mobile); 
            formData.append('approvedprogramme_id', apid); 
			var fileInput = document.getElementById('file');
			var file = fileInput && fileInput.files.length > 0 ? fileInput.files[0] : null;
			if (file) {
				formData.append('file', file);
			}
			 if (file) {
            formData.append('file', file); // Append the file
        }
            var token = $('input[name=_token]');
            $.ajax({
                    url: "{{url('declarationform/sendotp')}}",
				    method: 'POST',
				    dataType: 'json',
					contentType: false,
					processData: false,
					headers: {
				    	'X-CSRF-TOKEN': token.val()
					},
				    data: formData,
				    success: function (data) {
						enabledisableSubmit('enable');
						console.log('Success');
                        console.log(data);
						if(data.result=='success'){
							showotpinput();
						}else{
                      	  swal("Error Occurred!!!", 'Could not send OTP, Please try again later.', "error");
						}
				    },
				    error: function (data) {
						console.log('Error');
                        if (data.status === 422) {
                            console.log(data);
                        } else {
                            console.log(data);
                        }
                    }
				}).done(function(response) {
                    enabledisableSubmit('enable');
                    if(response=='200'){
						console.log('Ok');
                        showotpinput();
                    }else{
                      //  swal("Error Occurred!!!", 'Could not send OTP, Please try again.', "error");
                    }
                });
                
        }else{
            swal("Error Occurred!!!", valstring, "error");
            enabledisableSubmit('enable');
        }
        
    }

   
</script>
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<ul class="breadcrumb" style="background:transparent!important;">
					<li><a href="{{url('/nber/admissions')}}">Enrolment</a></li>
					<li> {{$ap->programme->course_name}}  - {{$ap->academicyear->year}} </li>
					@if($candidates->count() <= $ap->maxintake)
						@if($ap->academicyear->current==1)
							{{--<a  class="btn btn-primary pull-right btn-bc" style="color:white;" href="{{url('candidate/create/'.$ap->id)}}">Add Candidate</a> --}}
						@endif
						@if($ap->id ==   8838)
							{{-- <a  class="btn btn-primary pull-right btn-bc" style="color:white;" href="{{url('candidate/create/'.$ap->id)}}">Add Candidate</a> --}}
						@endif
						@php
							$now = Carbon\Carbon::now();
						@endphp
						{{-- @if(( $ap->enable_admission == 1 && $now->toDateString() <= \Carbon\Carbon::parse($ap->enable_admission_till)->toDateString()  )  
						
						) 
							<a  class="btn btn-primary pull-right btn-bc" style="color:white;" href="{{url('candidate/create/'.$ap->id)}}">Add Candidate</a>
						@endif --}}
						<a href="{{url('pdf')}}/{{$ap->id}}" class="btn btn-default pull-right  btn-bc" style="margin-right: 10px!important;display:none;"><i class="fa fa-print"></i> Print</a>
					@endif
					
					@if($candidates->count() <= $ap->maxintake && $ap->academicyear_id == 12)
						{{--@if($ap->academicyear->current==1)
							@if($ap->id == 65  ) 
							<a  class="btn btn-primary pull-right btn-bc " style="color:white;" href="{{url('candidate/create/'.$ap->id)}}">Add Candidate</a>
							@endif
						@endif--}}
					@endif
				</ul>
			</div>



		</div>
		@include('common.errorandmsg')

		<div class="row">
			<div class="col-md-12">

				@if($candidates->where('incomplete_2024_data',1)->count() > 0)
					<div
						class="alert alert-danger"
					>
						Some of the condidate details are incomplete. Please update all the details.
					</div>
				@else
					
				@endif

				<table class="table  table-bordered">
					<tr>
						<th>Sl No</th>
						<th>Name</th>
						<th>Enrolment Number</th>
						<th>Photo</th>
						<th>Date of Birth</th>
						<th>Email</th>
						<th>Mobile Number</th><th> Mobille OTP Verification Status <small class="text-muted">By Student</small></th>
						<th>Document Verfification Status <small class="text-muted">By NBER</small> </th>
						<th>Links</th>
					</tr>
					@if($candidates->count() > 0)
					{{csrf_field()}}

					<?php $slno =1; ?>
					@foreach($candidates as $c)
						@if(!is_null($c))
						<tr @if($c->incomplete_2024_data == 1) class="bg-danger" @endif>
						<td>
								{{$slno}}
								<?php $slno++; ?>
							</td>
							<td>{{$c->name}}</td>
							<td>{{$c->enrolmentno}}</td>
							<td>
								{{--@if($c->approvedprogramme->academicyear_id != 11 )

							{{ Form::bsFiledirect('photo',"",'image',$c->photo,'files/enrolment/photos',$c->id) }}
								@else --}}
								<img src="{{url('files/enrolment/photos')}}/{{$c->photo}}" alt="" style="height:100px;">
							{{--@endif--}}
							</td>
							<td>{{\Carbon\Carbon::parse($c->dob)->format('d-m-Y')}}
							</td>
							<td>
								{{$c->email}}
							</td>
							<td>
								{{$c->contactnumber}} 
							</td>
							<td>
								@if($c->is_mobile_number_verified == 'Yes' )
									{{--<i class="fa fa-question verification_mark_{{$c->id}}"  style="color:red"></i> --}}
									<span class="label label-xs label-info">Verified</span>
									{{--<a class="verify_link_{{$c->id}} btn btn-xs btn-primary" href="javascript:verifymobile({{$c->id}},{{$c->contactnumber}} );">Verify</a> --}}
								@else
								{{--<<i class="fa fa-check" style="color:blue" title="Verified on {{$c->mobile_otp_verified_on}}"></i> --}}
								<span class="label label-xs label-danger">Not Verified</span>
								{{--<a href="javascript:changemobile({{$c->id}},'{{$c->name}}');" class="btn btn-xs btn-warning">Change Mobile Number </a> --}}
								@endif
								
								@if($c->approvedprogramme->academicyear_id < 11)
									<a href="javascript:changemobile({{$c->id}},'{{$c->name}}');" style="display:none;" class="btn btn-xs btn-warning">Change Mobile Number </a>
								@endif
							</td>
							<td>
								{!!$c->statushtml()!!}
							</td>
							<td>

								<button type="button" class="btn btn-success btn-xs " data-toggle="modal" style="text-decoration: none; color:black;margin: 3px;" data-target="#myModal{{$c->id}}"><i class="fa fa-eye"></i> &nbsp;Quick View</button>
								@if($c->approvedprogramme->academicyear_id < 13)

									<a href="{{route('mark_details' ,$c->id)}}" class="btn btn-info btn-xs "style="text-decoration: none; color:black;margin: 3px;"><i class="fa fa-eye"></i> &nbsp;Marks Details</a>
									@endif 


								<input type="hidden" value="{{$c->id}}">

								@if($c->approvedprogramme->academicyear_id == 14 && $c->status_id !=2 && $c->status_id !=9 && $now->toDateString() <= \Carbon\Carbon::parse($c->approvedprogramme->enable_admission_till)->toDateString())   

									{{-- <a href="{{url('candidate/edit').'/'.$c->id}}" class="btn btn-info btn-xs none"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a> --}}
									<a href="javascript:confirm({{$c->id}},'{{$c->name}}');" class="btn btn-danger btn-xs none"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
									@endif 

									{{--									@if($c->status_id == 1 || $c->status_id ==7 || $c->status_id ==8 || $c->incomplete_data == 1)
									<a href="{{url('candidate/edit').'/'.$c->id}}" class="btn btn-info btn-xs hidden"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>
									@endif --}}
							{{--		@if($c->approvedprogramme->academicyear_id == 12 && $c->status_id !=2 && $c->status_id !=9)   

									<a href="{{url('candidate/edit').'/'.$c->id}}" class="btn btn-info btn-xs none"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>
									<a href="javascript:confirm({{$c->id}},'{{$c->name}}');" class="btn btn-danger btn-xs none"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
									@endif 
									@if (($c->status_id == 1 || $c->status_id == 7) && $c->approvedprogramme->academicyear_id > 11 )
									<a href="{{url('candidate/edit').'/'.$c->id}}" class="btn btn-info btn-xs hidden"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>
									@endif
									
									
									
									@if(!($c->status_id == 9 || $c->status_id == 2) && $c->approvedprogramme->enable_admission == 1 && $now->toDateString() <= \Carbon\Carbon::parse($c->approvedprogramme->enable_admission_till)->toDateString() )
										<a href="{{url('candidate/edit').'/'.$c->id}}" class="btn btn-info btn-xs hidden none"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>
										<a href="javascript:confirm({{$c->id}},'{{$c->name}}');" class="btn btn-danger btn-xs hidden none"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
									@endif

									--}}
									{{-- @if($c->approvedprogramme_id == 8837 || $c->approvedprogramme_id == 8838 || $c->approvedprogramme_id == 7494)
										<a href="{{url('candidate/edit').'/'.$c->id}}" class="btn btn-info btn-xs  "><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>
										<a href="javascript:confirm({{$c->id}},'{{$c->name}}');" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
									@endif --}}
								</td>
						</tr>
						@endif
					@endforeach
					@endif
				</table>

				@if(($ap->enable_admission == 1 && $now->toDateString() <= \Carbon\Carbon::parse($ap->enable_admission_till)->toDateString()) || ($now->toDateString() >= \Carbon\Carbon::parse($ap->enable_admission_till)->toDateString())) 



				@if(is_null($ap->admissiondeclaration->opt_verified_on) || (!is_null($ap->admissiondeclaration) && $ap->admissiondeclaration->no_of_candidates < $candidates->where('status_id','!=',9)->count() ))
					<div class="alert alert-danger  ">
						<h4>Admitted Student Declaration submitted by Institute <button type="button" class="btn btn-info btn-lg btn-xs " data-toggle="modal" data-target="#myModal" id="modalbtn">Click here</button></h4>
						
						<!--h4>Student Enroment Data Verification</!--h4>--16092025>-->
						<p>
							NOTE:- Verify the uploaded data of the student. NBER RCI will not accept any requests in spelling correction, DOB changes etc once the enrolment no is issued.
							After verfication,
							
							to confirm the same.
							{{ csrf_field() }}
						</p>
					</div>
					@endif
				 @endif 
			</div>
		</div>
	</div>
	<input type="hidden" id="mobile-number">
	<input type="hidden" id="candidate-id">
	<input type="hidden" id="mobile-number-verification-code">
	<input type="hidden" id="email-address-verification-code">
		{!! csrf_field() !!}
	<input type="hidden" id="verifying" value="enrolment">
	<input type="hidden" id="email-address">
	<script>
		$(document).ready(function () {
			$('.swal2-input').attr('maxlength',10);
			$('.swal2-input').keyup(function(e)
			{
				if (/\D/g.test(this.value))
				{
					// Filter non-digits from input value.
					this.value = this.value.replace(/\D/g, '');
				}
			});
		});
		
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
							url: '{{url("institute/editmobile")}}',
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
                    window.location.replace("{{url('candidate/delete')}}/"+id);

                }
            })
        }
	</script>
    {{--@include('institute.common.otpverificationmodel')
    @include('institute.common.otpverificationjs') --}}

	{{--@foreach($candidates as $c)
        @include('institute.candidates.view')
	@endforeach--}}



	<?php $declaration = $ap->admissiondeclaration; ?>
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h3><b>Declaration</b></h3>
				</div>
				<div class="modal-body">
					<p>
						I hereby declare that the candidates are admitted as per the norms/eligibility/reservation policy and the details uploaded have been verified by me based on the candidate's original school certificates / mark sheets and goverment certificates.
						
						
						The verified details are as below: 

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
						<li>Colour scanned copies of original qualification and category document</li>
						<li>Colour recent photo</li>
						<li>Eligibility conditions as per the norms</li>
						<li>Reservation as per policy</li>
					</ul>
					<p>
						Further, it is to mention that the candidate is informed to verify email & mobile number with OTP for payment of enrolment fees and generation of PRN number. I hereby take the responsibility of all the 
							 {{$candidates->count()}} 
						candidates uploaded by the institute.  I do understand any corrections in the details of the students will not be accepted by NBER - RCI.

					</p>
					<p>
						<div class="form-group">
							<label for="name" class="control-label">Course</label>
							<input type='text' name='course' disabled value="{{$ap->programme->course->name}} - {{$ap->academicyear->year}} Batch"  id="course" class="form-control"/>
						</div>
						<div class="form-group">
							<label for="name" class="control-label">Name of the Course Coordinator / HOD</label>
							<input type='text' name='name'  id="name" class="form-control"/>
						</div>
						<div class="form-group">
							<label for="name" class="control-label">Email Address</label>
							<input type='email' name='email' id="email"  class="form-control"/>
						</div>
						<div class="form-group">
							<label for="name" class="control-label">Phone Number</label>
							<input type='text' name='mobile' id="mobile"  class="form-control"/>
						</div>
						<div class="form-group">
							<label for="name" class="control-label">Merit List</label>
							<input type="file" name="file" id="file" accept="application/pdf" class="form-control" required />
						</div>
						
						<div class="form-group hidden" id="otp-form">
							<label for="otp" class="control-label">OTP </label>
							
							<input type='text' id="otp" value="{{$declaration->otp}}" name='otp'  class="form-control"/>
						</div>
						<input type="hidden" id="approvedprogramme_id" value={{$ap->id}}>
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" id="sendotp" class="btn btn-primary pull-right" onclick="sendotp();">

							<img src="{{url('images/loading1.gif')}}" class="hidden loading" style="width: 18px;margin-right: 10px;">
	
							<span class="save">  Submit</span>
						
					</button>
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	@foreach($candidates->sortBy('enrolmentno') as $c)
        @include('institute.candidates.view')
	@endforeach

@endsection

@section('script')
	<script src="{{asset('js/cropper.js')}}"></script>
@endsection
