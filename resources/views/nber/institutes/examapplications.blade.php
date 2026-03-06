
@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
			{{csrf_field()}}

				<table class="table table-borded">
					<tr>
						<th>SlNo</th>
						<th>RCI Code</th>
						<th>Name</th>
						<th>Exam Center</th>
						<th>Programme</th>
						<th>NBER</th>
						<th>Academic Year</th>
						<th>Number of Candidates</th>
						<th>Application Received</th>
					</tr>
					<?php $slno = 1; ?>
					@foreach($institutes->sortby('user.username') as $institute)
						@if($institute->approvedprogrammes()->where('academicyear_id','>',6)->where('academicyear_id','!=',11)->count() >0 )
							<?php $sum = 0; ?>
							@foreach($institute->approvedprogrammes()->where('academicyear_id','>',6)->where('academicyear_id','!=',11)->get() as $ap)
									<?php $sum += $ap->registeredcandidatecount($ap->id); ?>
								<tr>
									<td>
										{{$slno}}
										<?php $slno++; ?>
									</td>
									<td>
										{{$institute->user->username}}
									</td>
									<td>
										{{$institute->name}}
									</td>
									{{--<td style="width:300px;">
										<?php
											//$kvname = \App\Kvtti::where('institute_id',$institute->id)->first(); 
											if(\App\Kvtti::where('institute_id',$institute->id)->count()>0){
												$kvname = \App\Kvtti::where('institute_id',$institute->id)->first();
												$ecenter = \App\Externalexamcenter::where('id',$kvname->externalexamcenter_id);
												if($ecenter->count()>0){
													$execenter = $ecenter->first();
													echo '('.$execenter->code. ') - ' ;
													echo $execenter->address ;
												} 
											}
										?>
									</td>--}}
									<td>
										{{$ap->programme->name}}
									</td>
									<td>
										{{$ap->programme->nber->name_code}}
									</td>
									<td>
										{{$ap->academicyear->year}}
									</td>
									<td>
										{{$ap->candidates->count()}}
									</td>
									<td>
										{{$ap->applications->count()}}
									</td>
								</tr>
							@endforeach

						@endif
					@endforeach
				</table>				
			</div>
		</div>
	</div>
	<script>
		function changepassword(id,name){
			swal({
                title: 'Change/Add password for Username '  + name  ,
                text: "Enter the new password ",
				input: 'text',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Update!',
				inputValidator: (value) => {
					if (value == '') 
					{
						return 'Password cannot be empty!'
					}
					else {
						var formData = new FormData();
						var token = $('input[name=_token]');
						formData.append('id', id);
						formData.append('password', value);
						$.ajax({
							url: '{{url("nber/changeinstitutepassword")}}',
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
										title: 'Password Updated',
										showConfirmButton: false,
										timer: 3000
									});
									setTimeout(function(){
										location.reload();
									}, 3000); 
								}else{
									console.log(data);
									swal({
										type: 'warning',
										title: 'Could not update the password',
										showConfirmButton: false,
										timer: 1500
									});
								}
							},
							error: function (data) {
								console.log(data);

								swal({
									type: 'warning',
									title: 'Could not update the password',
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
@endsection