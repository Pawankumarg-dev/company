@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{asset('css/cropper.css')}}">
@endsection
@section('content')
<div class="container-fluid" >
		<div class="row">
			<div class="col-md-12">

				<ul class="breadcrumb" >
				  <li><a href="{{url('/dashboard')}}">Home</a></li>

				  <li><a href="{{url('/institutes')}}">Institute</a> :
				  <?php $pass=''; ?>
				  @if(app('request')->input('i'))
					  <a href="{{url('institute')}}/{{app('request')->input('i')}}">{{$institute}}</a> </li>
					  <?php $pass = '&i='.app('request')->input('i'); ?>
				  @else
				  	@if($institute!='')
				  			<a href="{{url('institute')}}/{{$i}}">{{$institute}}</a> </li>
				  	@else
				  		All</li>
				  	@endif
				  @endif
				  <li> <a href="{{url('programmes')}}"> Programme </a> :
				  @if(app('request')->input('p'))
				  	<?php $pass = '&p='.app('request')->input('p'); ?>
				  	{{$programme}}</li>
				  @else
				  	@if(app('request')->input('c'))
				  		<?php $pass = '&c='.app('request')->input('c'); ?>
				  		{{$programme}}</li>
				  	@else
				    	All </li>
				    @endif

				  @endif
				  @if(app('request')->input('s'))
					  <li>
					  	Candidates Application
					  	 <a href="{{url('candidateapplications')}}?{{$pass}}"><span class=" label label-default">All</span></a> &nbsp;
					  	@if(app('request')->input('s')=='1')
				  			  <span class=" label label-success">Pending</span>&nbsp;
				  			  <a href="{{url('candidateapplications')}}?s=2{{$pass}}"><span class=" label label-default">Approved</span></a>&nbsp;
				  			  <a href="{{url('candidateapplications')}}?s=3{{$pass}}"><span class=" label label-default">Rejected</span></a>&nbsp;
				  			  <a href="{{url('candidateapplications')}}?s=4{{$pass}}"><span class=" label label-default">Completed</span></a>
				  		@endif
				  		@if(app('request')->input('s')=='2')
				  			  <a href="{{url('candidateapplications')}}?s=1{{$pass}}"><span class=" label label-default">Pending</span></a>&nbsp;
				  			  <span class=" label label-success">Approved</span>&nbsp;
				  			  <a href="{{url('candidateapplications')}}?s=3{{$pass}}"><span class=" label label-default">Rejected</span></a>&nbsp;
				  			  <a href="{{url('candidateapplications')}}?s=4{{$pass}}"><span class=" label label-default">Completed</span></a>
				  		@endif
				  		@if(app('request')->input('s')=='3')
				  			  <a href="{{url('candidateapplications')}}?s=1{{$pass}}"><span class=" label label-default">Pending</span></a>&nbsp;
				  			  <a href="{{url('candidateapplications')}}?s=2{{$pass}}"><span class=" label label-default">Approved</span></a>&nbsp;
				  			  <span class=" label label-success">Rejected</span>
				  			  &nbsp;
				  			  <a href="{{url('candidateapplications')}}?s=4{{$pass}}"><span class=" label label-default">Completed</span></a>
				  		@endif
				  		@if(app('request')->input('s')=='4')
				  			  <a href="{{url('candidateapplications')}}?s=1{{$pass}}"><span class=" label label-default">Pending</span></a>&nbsp;
				  			  <a href="{{url('candidateapplications')}}?s=2{{$pass}}"><span class=" label label-default">Approved</span></a>&nbsp;
				  			  <a href="{{url('candidateapplications')}}?s=3{{$pass}}"><span class=" label label-default">Rejected</span></a>&nbsp;
				  			  <span class=" label label-success">Completed</span>
				  		@endif
					  	</li>
					  	<li>
					  		<span class="label label-success " style="border-radius: 10px!important;">{{$candidates->total()}}</span>
					  	</li>

				  @else
				  	<li>
				  		Candidate Applications :    <span class=" label label-success">All</span> &nbsp;
				  		<a href="{{url('candidateapplications')}}?s=1{{$pass}}"><span class=" label label-default">Pending</span></a>&nbsp;
				  		<a href="{{url('candidateapplications')}}?s=2{{$pass}}"><span class=" label label-default">Approved</span></a>&nbsp;
				  		<a href="{{url('candidateapplications')}}?s=3{{$pass}}"><span class=" label label-default">Rejected</span></a>
				  		<a href="{{url('candidateapplications')}}?s=4{{$pass}}"><span class=" label label-default">Completed</span></a>
				  	</li>
				  		<li>
					  		<span class="label label-success " style="border-radius: 10px!important;">{{$candidates->total()}}</span>
					  	</li>

				  @endif
				  <input class="form-control pull-right" style="width:300px;margin-top: -4px;" id="myInput" type="text" placeholder="Search..">
				</ul>
			</div>

			@include("common.errorandmsg")

			<div class="col-md-12">
				<div class="pull-right">
					{{$candidates->appends(request()->input())->links()}}
				</div>
			</div>
			<div class="col-md-12">
				<table class="table table-bordered table-striped">
				    <thead>
				      <tr>
				      	<th>Date</th>
				      	<th>Name</th>
				      	<th>Enrolment Number</th>
				      	<th>Course</th>
				        <th>Percentage</th>
				        <th>DOB	</th>
				        <th>Institute</th>
				        <th>Contact</th>
				        <th>Community</th>
				        <th>Disability</th>
				        <th>Status</th>
				        <th>Action/ View</th>
				      </tr>
				    </thead>
				    <tbody id="myTable">
						@foreach($candidates as $c)
							@if($c->approvedprogramme!=null)
								<tr>
									<td>
										{{$c->created_at}}
									</td>
									<td>
										{{$c->name}}

									</td>
									<td>

										<input type="text" id="{{$c->id}}" class="enno" value="{{$c->enrolmentno}}" />
									</td>
									<td>
										{{$c->approvedprogramme->programme->course_name}}
									</td>

									<td>
										{{$c->percentage}}
									</td>
									<td>
										{{$c->dob->format('d-m-Y')}}
									</td>
									<td>
										<a  target="_blank"  href="{{url('institute')}}/{{$c->approvedprogramme->institute->id}}" data-toggle="tooltip" title="{{$c->approvedprogramme->institute->name}}, Contact# {{$c->approvedprogramme->institute->contactnumber1}}, Email: {{$c->approvedprogramme->institute->email}}">
											{{$c->approvedprogramme->institute->user->username}} &nbsp;&nbsp;<i class="fa fa-share-square-o"></i>
										</a>
									</td>
									<td>
										{{$c->contactnumber}}
									</td>
									<td>
										{{$c->community->community}}
									</td>
									<td>
										{{$c->disability->disability}}
									</td>
									<td>
										{!!$c->statushtml()!!}
									</td>
									<td style="width:170px;">

										<div class="btn-group" style="width:170px;">

										<button type="button" onclick="javascript:reset('{{$c->id}}','{{$c->photo}}')" class="btn btn-default btn-xs"> &nbsp;Change Status</button>
										<a  class="btn btn-default btn-xs"  href="{{url('candidate')}}/{{$c->id}}"> &nbsp;Details</a>
									</div>
									</td>
								</tr>
							@endif
                        @endforeach

					</tbody>
				</table>
						@foreach($candidates as $c)
							@if($c->approvedprogramme!=null)
								@include('nber.applications.candidates.candidate')
							@endif
						@endforeach
			</div>

			<div class="col-md-12">
				<div class="pull-right">
					{{$candidates->appends(request()->input())->links()}}
				</div>
			</div>

		</div>
</div>
<form>
	{!! csrf_field() !!}
</form>
<button type="button" class="btn btn-info btn-lg hidden" data-toggle="modal" data-target="#myModal" id='modalbtn'>Open Modal</button>
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
    	<div class="modal-content">
    		<div class="modal-header">
    			Crop Image
    		</div>
      		<div class="modal-body">
	  			<div class="img-container" id='imgcropbox' style="height:300px!important;" >
	  		 		<center style="height:300px!important;"><img id="image" src="{{asset('images/pleasewait.gif')}}" style="height:300px!important;" /></center>
	  			</div>
			  	<input type='hidden' id='left' />
		        <input type='hidden' id='top' />
		        <input type='hidden' id='width' />
		        <input type='hidden' id='height' />
		        <input type='hidden' id='photofile' />
		        <input type='hidden' id='photo' />
		        <input type="hidden" id='cid' />
			  </div>
			  <div class="modal-footer">
		      	<button type='button' class="btn btn-primary pull-right" onclick="onsave();">Crop</button>
		        <button type='button' class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
			  </div>
			</div>
		 </div>
	</div>
</div>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
   $(".enno").on("change", function() {

   		var formData = new FormData();
		var token = $('input[name=_token]');

		formData.append('id', this.id);
		formData.append('enno',  $('#'+this.id).val());
		console.log(formData);


		$.ajax({
		    url: '{{url("updateenno")}}',
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
		  		swal('Enrolment Number updated');



		    }
		}

		});




  });
});
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

  	function update(status,c){
  		$('#frmStatusUpdate_'+c).prop('action',"{{url('/candidate/')}}/" + status + "/"+c);
  		$('#frmStatusUpdate_'+ c).submit();
  	}
  	function reset(id,fname){
  		$('#photo').val(fname);
  		$('#cid').val(id);
  		if(fname.split('/').shift()=='cropped'){
  			$('#myModal'+id).modal('show');


  		}else{
  			$('#image').cropper({
				aspectRatio: 4 / 5,
				crop: function(e) {
					$('#left').val(e.x);
					$('#top').val(e.y);
					$('#width').val(e.width);
					$('#height').val(e.height);
				}
			})
	  		$('#image').cropper('replace',"{{asset('files/enrolment/photos/')}}/"+fname);
			$('#myModal').modal('show');
	  		$("input[name='comment']").val('');
  		}
  	}
  	function onsave(){
		var formData = new FormData();
		var token = $('input[name=_token]');

		formData.append('height', $('#height').val());
		formData.append('width',  $('#width').val());
		formData.append('left', $('#left').val());
		formData.append('top', $('#top').val());
		formData.append('filename',$('#photo').val())
		formData.append('cid',$('#cid').val())
		console.log(formData);
		  $.ajax({
		    url: '{{url("cropimageadmin")}}',
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
		  		console.log('uploaded the cordinates'+data);
		  		$('#myModal').modal('hide');
		  		$('#img_'+$('#cid').val()).prop('src','{{"files/enrolment/photos/cropped/"}}' + $('#photo').val());
		  		$('#myModal'+$('#cid').val()).modal('show');


		    }
		}

		});


		}

</script>
@endsection
@section('script')
	<script src="{{asset('js/cropper.js')}}"></script>
@endsection
