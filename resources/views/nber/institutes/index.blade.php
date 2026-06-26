
@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
			{{csrf_field()}}

				<table class="table table-boarded">
					<tr>
						<th>SlNo</th>
						<th>RCI Code</th>
						<th>Name</th>
						<th>Contact #1</th>
						<th>Contact #2</th>
						<!--<th>Exam Center</th> -->
						<th>Password</th>
					</tr>
					<?php $slno = 1; ?>
					@foreach($institutes->sortby('rci_code') as $institute)
						@if($institute->id != 1004 &&  $institute->approvedprogrammes()->where('academicyear_id','>',6)->count() >0 )
							<?php $sum = 0; $applications = 0;?>
							@foreach($institute->approvedprogrammes as $ap)
									<?php 
										$sum += $ap->registeredcandidatecount($ap->id); 
										//$applications += $ap->subjects->count();
									?>

							@endforeach
							@if(1)
								<tr>
									<td>
										{{$slno}}
										<?php $slno++; ?>
									</td>
									<td>
										@if(!is_null($institute->user))
										{{$institute->user->username}}
										@endif
									</td>
									<td>
										{{$institute->name}}
									</td>
									<td>
										{{$institute->contactnumber1}}
									</td>

									<td>
										{{$institute->contactnumber2}}
									</td>
									<td style="width:300px;">
										<?php
											$kvname = \App\Kvtti::where('institute_id',$institute->id)->first(); 
											if(\App\Kvtti::where('institute_id',$institute->id)->count()>0){
												$kvname = \App\Kvtti::where('institute_id',$institute->id)->first();
												$ecenter = \App\Externalexamcenter::where('id',$kvname->externalexamcenter_id);
												if($ecenter->count()>0){
													$execenter = $ecenter->first();
													$institute->update(['externalexamcenter_id'=>$execenter->id]);
													echo '('.$execenter->code. ') - ' ;
													echo $execenter->address ;
												} 
											}
										?>
									</td>
									
									<td>
										<a href="javascript:changepassword({{$institute->id}},'{{$institute->rci_code}}')" class="btn btn-sm btn-primary">Change</a>
									</td>
								</tr>
							@endif
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