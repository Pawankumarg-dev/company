@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{asset('css/chosen.min.css')}}">
<link rel="stylesheet" href="{{asset('css/cropper.css')}}">

.hidden{
			display:none;
		}
		.community_id_3, .value_community_id_3{
			display:none;
		}
		.form-control{
			max-width:500px;
			border-radius:0;
			-webkit-box-shadow:none;
			box-shadow:none;
			-webkit-transition:none;
			transition:none;
		}
		.breadcrumb{
			background-color:#fff!important;
		}
		th{
			background:#f5f5f5;
		}
		body{
			background:#fff!important;
		}
		.personal .form-group{
			float: left;
			width: 320px;
			margin-right: 10px;
		}
@endsection
@section('content')
<style>
	.heading{padding-top:0;padding-bottom: 10px;font-size:20px;}
	.chosen-container {width:100%!important;}
</style>
<form action="{{url('candidate/update'.'/'.$candidate->id)}}" enctype="multipart/form-data" method="post">
	{!! csrf_field() !!}
	<div class="container-fluid" >
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb" >
				  <li><a href="{{url('/')}}">Home</a></li>
				  <li><a href="{{url('/programme/'.$apid)}}"> {{$programme->course_name}} </a></li>
				  <li>Enrolment</li>
				  <li> {{$candidate->name}}</li>
				  <button type="submit" class="btn btn-primary pull-right btn-bc">Update</button>
				</ul>
				
			</div>
			
		</div>
		@include('common.errorandmsg')
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<b>Personal Details</b>
					</div>
					<div class="panel-body">
						<input name='approvedprogramme_id' type='hidden' value="{{$apid}}" />
						<input name='programmegroup_id' type="hidden" value="{{$programme->programmegroup_id}}" />
						<input name='status_id' value='1' type='hidden' />
						{{ Form::bsText('name',"Student's Name *",$candidate->name,['class' => 'form-control max99 p']) }}
						{{ Form::bsText('fathername',"Father's Name *",$candidate->fathername,['class' => 'form-control max99']) }}
						{{ Form::bsText('mothername',"Mother's name",$candidate->mothername) }}
						{{ Form::bsRadio('gender_id',$genders,'gender','Gender',null,$candidate->gender_id) }}	
						{{ Form::bsRadio('isdisabled',$yesno,'value','PwD *',$candidate->isdisabled) }}
						{{ Form::bsText('udid',"UDID or UDID Enrolment No",$candidate->udid) }}
						{{ Form::bsDate('dob',"Date of Birth",$candidate->dob) }}
						{{ Form::bsSelect('nationality_id',$nationalities,'name','Nationality *',null,$candidate->nationality_id)}}
						<div class="form-group">
								<label for="aadhar" class="control-label">
										Aadhar Number *
								</label>
								<input type="text" id="aadhar" name="aadhar" class="form-control" value="{{ $candidate->aadhar}}" >
							</div>
						{{ Form::bsRadio('community_id',$communities,'community','Category *',null,$candidate->community_id) }}
							
						{{ Form::bsTextarea('address',"Addresss",$candidate->address) }}
						{{ Form::bsSelect('city_id',$cities,'name','City','state',$candidate->city_id) }}					
						{{ Form::bsText('pincode',"PIN Code",$candidate->pincode) }}
						{{ Form::bsText('contactnumber',"Contact Number",$candidate->contactnumber) }}
						{{ Form::bsText('email',"Email ID",$candidate->email) }}			
					</div>
				 </div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						Documents
					</div>
					<div class="panel-body">
					<h4>Documents</h4>
						{{ Form::bsFile('photo',"Photo",'image',$candidate->photo,'files/enrolment/photos') }}
					@if($programme->programmegroup->id != '3')
						{{ Form::bsFile('doc_dob',"SSLC / 12th Certificate as proof of date of birth",null,$candidate->doc_dob,'files/enrolment/dateofbirth') }}
						{{ Form::bsFile('doc_mark',"SSLC / 12th Marksheet",null,$candidate->doc_mark,'files/enrolment/marksheets') }}
					@else
						{{ Form::bsFile('doc_rci',"RCI - CRR Certificate",null,$candidate->doc_rci,'files/enrolment/crr') }}
						{{ Form::bsText('crr',"CRR Number",$candidate->crr) }}
						{{ Form::bsDate('date_of_reg',"Date of Registration - RCI-CRR",$candidate->date_of_reg) }}
						{{ Form::bsDate('date_of_ren',"Date of Renewal -  RCI-CRR",$candidate->date_of_ren) }}
					@endif

						{{ Form::bsFile('doc_community',"Proof of SC/ST or OBC Certificate as prescribed in Central Government format",null,$candidate->doc_community,'files/enrolment/c') }}				
						{{ Form::bsFile('doc_disability',"Disability Certificate, if the candidate has a disability",null,$candidate->doc_disability,'files/enrolment/d') }}
						{{ Form::bsFile('doc_percentage_exception',"supporting State Norms G.O.s / Circulars for Percentage exception",null,$candidate->doc_percentage_exception,'files/enrolment/p') }}

					<hr />
					
					 	<label>Additional Documents (If required)</label>
					 	
					 	@if($candidate->candidatefiles->count() > 0)
					 		@foreach($candidate->candidatefiles as $af)
					 			<br />{{$af->description}} : <a target="_blank" href="{{url('files/enrolment/additional').'/'.$af->filename}}" style='margin-left: 10px;'> {{$af->filename}} </a>
					 		@endforeach
					 	@endif
				
						@for($i=0;$i<5;$i++)
							{{Form::bsFilewithdesc($i)}}
						@endfor
			    	 <div style="width:100%;margin-top: 0px;" class="pull-left">
			    	 	<a href="javascript:addfile();" id='addlink'>Add document</a>
			    	 </div>
			    	 <input type='hidden' value="0" id="filecount">
			    	 <script>
			    	 	function addfile(){
			    	 		var c = $('#filecount').val();
			    	 		
			    	 		$('#divfilename_'+c).removeClass('hidden');
			    	 		$('#filecount').val(parseInt(c)+1);
			    	 		if(c==4){
			    	 			$('#addlink').addClass('hidden');
			    	 		}
			    	 		
			    	 	}
			    	 </script>
			  
					</div>
	            </div>
			</div>
					
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						Reason to edit
					</div>
					<div class="panel-body">
						{{ Form::bsTextarea('comment',"Reason to update the details") }}	
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12" style="background: #EEEEEE;padding:30px;">
			<button type="submit" class="btn btn-primary pull-right">Update</button>
		</div>
	</div>
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
	  		 		<center style="height:300px!important;"><img src="{{asset('images/pleasewait.gif')}}" id="image" style="height:300px!important;" /></center>
	  			</div>
			  	<input type='hidden' id='left' />
		        <input type='hidden' id='top' />
		        <input type='hidden' id='width' />
		        <input type='hidden' id='height' />
		        <input type='hidden' id='photofile' />
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
	$(document).ready(function() {
		$(".ls").chosen();
		if($('#community_id').val()<2){
			$('#doc_community_form').addClass('hidden');
		}
		if($('#disability_id').val()<2){
			$('#doc_disability_form').addClass('hidden');
		}
		if($('#pex').prop('checked')==false){
			$('#doc_percentage_exception_form').addClass('hidden');
		}
		//alert($('#pex').prop('checked'));
	});
	$('#disability_id').on('change',function(){
		if($(this).val()>1){
			$('#doc_disability_form').removeClass('hidden');
		}else{
			$('#doc_disability_form').addClass('hidden');
		}
	});
	$('#community_id').on('change',function(){
		if($(this).val()>1){
			$('#doc_community_form').removeClass('hidden');
		}else{
			$('#doc_community_form').addClass('hidden');
		}
	});
	$('#pex').on('change',function(){
		if($(this).prop('checked')==true){
			$('#doc_percentage_exception_form').removeClass('hidden');
		}else{
			$('#doc_percentage_exception_form').addClass('hidden');
		}
	});
	function onsave(){
		var formData = new FormData();
		var token = $('input[name=_token]');
		
		formData.append('height', $('#height').val());
		formData.append('width',  $('#width').val());
		formData.append('left', $('#left').val());
		formData.append('top', $('#top').val());
		formData.append('filename',$('#photo').val());
		console.log(formData);
		  $.ajax({
		    url: '{{url("cropimage")}}',
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
		  		console.log('uploaded the cordinates');
		  		$('#myModal').modal('hide');
		  		$("#photo_filename").prop('src',"{{asset('files/temp/cropped/')}}/"+$('#photo').val());
			//	$("#photo_filename").html("photo."+$('#photo').val().split('.').pop());
				$("#photo_filename").removeClass('hidden');
	        	
	        		
		    }
		}
		
		});

			console.log($('#photo').val());
		}
	
</script> 
@endsection
@section('script')
	<script src="{{asset('js/cropper.js')}}"></script>
@endsection
