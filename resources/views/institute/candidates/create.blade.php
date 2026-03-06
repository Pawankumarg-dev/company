@extends('layouts.app')
@section('style')
	<link rel="stylesheet" href="{{asset('css/chosen.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/cropper.css')}}">
	<style>
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
	</style>
	<script>
		$(document).ready(function () {
			var old = parseInt("{{old('state_id')}}");
			console.log(old);
			//loadPDistricts(old);
			$('#state_id').change();
		//	$('#form').on('submit', function(e) {
				
			//\\	$('#form')[0].submit();
		//	});
			$('#nationality_id').val(86).change();
			var formattedDate = new Date("{{$mindate}}");
			var d = String(formattedDate.getDate()).padStart(2, '0');
			var m =  String(formattedDate.getMonth() +1).padStart(2, '0');
			var y = formattedDate.getFullYear();
			var mindate  = y + "-" + m + "-" + d;
			$('input[name="dob"]').attr('max', mindate);
			$('input[name="ver_dob"]').attr('max', mindate);
			$('.max99').attr('maxlength',99);
			$('.max10').attr('maxlength',10);
			$('input[name="pincode"]').attr('maxlength','6');
			$('input[name="ppincode"]').attr('maxlength','6');
			$('input[name="ver_udid"]').attr('maxlength','23');
			$('input[name="udid"]').attr('maxlength','23');
			$('#aadhar').attr('maxlength','12');
			$('.year').attr('maxlength','4');
			//$('input[name="disabilityper"]').attr('maxlength','3');

			/*$('input[name="disabilityper"]').keyup(function(e)
			{
				if (/\D/g.test(this.value))
				{
					// Filter non-digits from input value.
					this.value = this.value.replace(/\D/g, '');
				}
			});*/
			$('input[name="udid"]').keypress(function (e) {
				var regex = new RegExp("^[a-zA-Z0-9/]+$");
				var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
				if (regex.test(str)) {
					return true;
				}
				e.preventDefault();
				return false;
			});
			$('input[name="ver_udid"]').keypress(function (e) {
				var regex = new RegExp("^[a-zA-Z0-9_]+$");
				var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
				if (regex.test(str)) {
					return true;
				}
				e.preventDefault();
				return false;
			});
			$('input[name="address"]').keyup(function(e){
				if($('#saa').is(':checked')){
					$('input[name="paddress"]').val($('input[name="address"]').val());
				}
			});
			$('input[name="pincode"]').keyup(function(e)
			{
				if (/\D/g.test(this.value))
				{
					// Filter non-digits from input value.
					this.value = this.value.replace(/\D/g, '');
				}
				if($('#saa').is(':checked')){
					$('input[name="ppincode"]').val($('input[name="pincode"]').val());
				}
			});
			$('input[name="ppincode"]').keyup(function(e)
			{
				if (/\D/g.test(this.value))
				{
					// Filter non-digits from input value.
					this.value = this.value.replace(/\D/g, '');
				}
			});
			$('.max10').keyup(function(e)
			{
				if (/\D/g.test(this.value))
				{
					// Filter non-digits from input value.
					this.value = this.value.replace(/\D/g, '');
				}
			});

			$('#aadhar').keyup(function(e)
			{
				if (/\D/g.test(this.value))
				{
					// Filter non-digits from input value.
					this.value = this.value.replace(/\D/g, '');
				}
			});
			
		});

		
		</script>
@endsection
@section('content')

	<style>
		.heading{padding-top:0;padding-bottom: 10px;font-size:20px;}
		.chosen-container {width:100%!important;}
	</style>
	<form action="{{url('candidate')}}" enctype="multipart/form-data" method="post" id="form">
		{!! csrf_field() !!}
		<div class="container" >
			<div class="row">
				<div class="col-md-12">
					<ul class="breadcrumb" >
						<li><a href="{{url('/')}}">Home</a></li>
						<li><a href="{{url('/programme/'.$apid)}}"> {{$programme->course_name}}  ({{ $ap->academicyear->year }}) </a></li>
						<li> New Enrolment</li>
						<button type="submit" class="btn btn-primary pull-right btn-bc">Save</button>
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

						<div class="panel-body personal">
							<input name='approvedprogramme_id' type='hidden' value="{{$apid}}" />
							<input name='programmegroup_id' type="hidden" value="{{$programme->programmegroup_id}}" />
							<input name='status_id' value='1' type='hidden' />

							
							{{ Form::bsText('name',"Student's Name *",'',['class' => 'form-control max99 p']) }}
							{{ Form::bsText('fathername',"Father's Name *",'',['class' => 'form-control max99']) }}

							<!--{{ Form::bsSelectandText('salutation_id',$salutations,'salutation','Choose','fathername',"Father's / Husband's name") }}
							-->
							{{ Form::bsText('mothername',"Mother's name *",'',['class' => 'form-control max99']) }}
						<!--	@if($programme->programmegroup->id != '3')
								{{ Form::bsNumber('percentage',"HSc Percentage",1,100) }}

								<h4 class="red-text">
									<input type="checkbox" name='pex' id="pex"> Please click here to Apply for Percentage Exception </input> <br />
								</h4>
							@endif -->
							{{ Form::bsRadio('gender_id',$genders,'gender','Gender *') }}
							{{ Form::bsRadio('isdisabled',$yesno,'value','PwD *') }}
							<div class="showhideudid hidden">
								{{ Form::bsText('udid',"UDID or UDID Enrolment No") }}
							{{--	{{ Form::bsSelect('disabilitytype_id',$disabilities,'disabilityname','Disability Type')}}
								{{ Form::bsText('disabilityper',"Disability Percentage") }}
								--}}
							</div>
							{{ Form::bsDate('dob',"Date of Birth *") }}
							{{ Form::bsSelect('nationality_id',$nationalities,'name','Nationality *')}}
							<div class="form-group">
								<label for="aadhar" class="control-label">
										Aadhar Number *
								</label>
								<input type="text" id="aadhar" name="aadhar" class="form-control" value="{{ old('aadhar') }}" >
							</div>
							
							{{ Form::bsRadio('community_id',$communities,'community','Category *') }}
							{{ Form::bsRadio('ews',$yesno,'value',"Do you belong to EWS category? *") }}
							{{ Form::bsEmail('email',"Email ID *") }}
							{{ Form::bsText('contactnumber',"Mobile Number *",'',['class'=>'form-control max10']) }}
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<b>Correspondence Address</b>
						</div>
						<div class="panel-body">
							{{ Form::bsText('address',"Addresss *") }}
							{{ Form::bsSelect('state_id',$states,'state_name','State *')}}
							<div class="form-group " id="districtsdiv">
								<label for="District" class="control-label">
										District *
								</label>
								<select class="form-control" name="district_id" id="district_id">
								<option value="0">Choosesse District</option>

								</select>
							</div>
							<div class="form-group " id="subdistrictsdiv">
								<label for="subDistrict" class="control-label">
										Sub District / Tehsil / Taluk
								</label>
								<select class="form-control" name="subdistrict_id" id="subdistrict_id">
									<option value="0">Choose Sub District / Tehsil / Taluk</option>
								</select>
							</div>

							<div class="form-group " id="villagediv">
								<label for="block" class="control-label">
										Block/Village
								</label>
								<select class="form-control" name="village_id" id="village_id">
									<option value="0">Choose City/Village</option>
								</select>
							</div>
							{{ Form::bsText('pincode',"PIN Code *") }}
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<b>Permanent Address </b> &nbsp;&nbsp;&nbsp; <input type="checkbox"   id="saa"> Same as Correspondence Address </input>
						</div>
						<div class="panel-body per-add">
							{{ Form::bsText('paddress',"Addresss *",'',['class'=>'form-control saa']) }}
							{{ Form::bsSelect('pstate_id',$states,'state_name','State *')}}
							<div class="form-group " id="pdistrictsdiv">
								<label for="District" class="control-label">
										District *
								</label>
								<select class="form-control" name="pdistrict_id" id="pdistrict_id">
								<option value="0">Choosesse District</option>

								</select>
							</div>
							<div class="form-group " id="psubdistrictsdiv">
								<label for="subDistrict" class="control-label">
									Sub District / Tehsil / Taluk
								</label>
								<select class="form-control" name="psubdistrict_id" id="psubdistrict_id">
									<option value="0">Choose Sub District / Tehsil / Taluk</option>
								</select>
							</div>

							<div class="form-group " id="pvillagediv">
								<label for="block" class="control-label">
										Block/Village
								</label>
								<select class="form-control" name="pvillage_id" id="pvillage_id">
									<option value="0">Choose City/Village</option>
								</select>
							</div>
							{{ Form::bsText('ppincode',"PIN Code *",'',['class'=>'form-control saa']) }}
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<b>Education Details</b>
						</div>
						<div class="panel-body">
							<table class="table table-bordered">
								<tr>
									<th style="width:120px;">
										Name of the Examination passed
									</th>
									<th>
										Board/University
									</th>
									<th style="width:80px;">
										Year of Passing
									</th>
									<th style="width:80px;">
										Total Marks
									</th>
									<th style="width:80px;">
										Marks Obtained
									</th>
									<th style="width:80px;">
										%Obtained
									</th>
									<th>
										Subject(s)
									</th>
								</tr>
								@if($programme->programmegroup->tenth== 1)
								<tr>
									<td>
										10th *
										<input type="hidden" name="edugrade_1" id="edugrade_1"  value="10th" class="form-control" />

									</td>
									<td>
										<input type="text" class="form-control" id="board_1" name="board_1" value="{{old('board_1')}}" />
									</td>
									<td  style="width:80px;">
										<input type="text"  class="form-control year" id="yop_1" name="yop_1" value="{{old('yop_1')}}" />
									</td>
									<td>
										<input type="text" class="form-control num year" id="tmarks_1" name="tmarks_1" value="{{old('tmarks_1')}}" />
									</td>
									<td>
										<input type="text" class="form-control num year" id="omarks_1" onkeyup="javascript:calper(1);" name="omarks_1"  value="{{old('omarks_1')}}"  >
									</td>
									<td>
										<input type="text" class="form-control" id="percentage_1" name="percentage_1"  value="{{old('percentage_1')}}"   >
									</td>
									<td>
										<input type="text" class="form-control" id="subjects_1" name="subjects_1"  value="{{old('subjects_1')}}" >
									</td>
								</tr>
								@endif
								@if($programme->programmegroup->twelveth== 1)
								<tr>
									<td>
										12th *
										<input type="hidden" name="edugrade_2" id="edugrade_2" value="12th" class="form-control" />
									</td>
									<td>
										<input type="text" class="form-control" id="board_2" name="board_2"  value="{{old('board_2')}}"  >
									</td>
									<td  style="width:80px;">
										<input type="text"  class="form-control year" id="yop_2" name="yop_2"  value="{{old('yop_2')}}" />
									</td>
									<td>
										<input type="text" class="form-control num" id="tmarks_2" name="tmarks_2"  value="{{old('tmarks_2')}}"  >
									</td>
									<td>
										<input type="text" class="form-control num" id="omarks_2" onkeyup="javascript:calper(2);" name="omarks_2"  value="{{old('omarks_2')}}"  >
									</td>
									<td>
										<input type="text" class="form-control" id="percentage_2" name="percentage_2"  value="{{old('percentage_2')}}"  >
									</td>
									<td>
										<input type="text" class="form-control" id="subjects_2" name="subjects_2"  value="{{old('subjects_2')}}" >
									</td>
								</tr>
								@endif
								<tr>
									<td>
										<input type="text" name="edugrade_3" id="edugrade_3" placeholder="Any Other" class="form-control" />
									</td>
									<td>
										<input type="text" class="form-control" id="board_3" name="board_3"  value="{{old('board_3')}}"  >
									</td>
									<td  style="width:80px;">
										<input type="text"  class="form-control year" id="yop_3" name="yop_3"  value="{{old('yop_3')}}"  />
									</td>
									<td>
										<input type="text" class="form-control num" id="tmarks_3" name="tmarks_3"  value="{{old('tmarks_3')}}" >
									</td>
									<td>
										<input type="text" class="form-control num" id="omarks_3" onkeyup="javascript:calper(3);" name="omarks_3"  value="{{old('omarks_3')}}" >
									</td>
									<td>
										<input type="text" class="form-control" id="percentage_3" name="percentage_3"  value="{{old('percentage_3')}}"   >
									</td>
									<td>
										<input type="text" class="form-control" id="subjects_3" name="subjects_3"  value="{{old('subjects_3')}}" >
									</td>
								</tr>
								
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<b>Documents</b>
						</div>
						<div class="panel-body">
							<h4>Documents</h4>
							{{ Form::bsFile('photo',"Photo *",'image') }}
							<small>
								Only jpeg, jpg, and png image with maximum size 200KB and photo image widdth and height les than 800px allowed. 
							</small>
							<!--@if($programme->programmegroup->id != '3')
								{{ Form::bsFile('doc_dob',"SSLC / 12th Certificate as proof of date of birth") }}
								{{ Form::bsFile('doc_mark',"SSLC / 12th Marksheet") }}
							@else
								{{ Form::bsFile('doc_rci',"RCI - CRR Certificate") }}
								{{ Form::bsText('crr',"CRR Number") }}
								{{ Form::bsDate('date_of_reg',"Date of Registration - RCI-CRR") }}
								{{ Form::bsDate('date_of_ren',"Date of Renewal -  RCI-CRR") }}
							@endif -->
							<?php 
								if($programme->programmegroup->twelveth == 1){
									$desc = "10th & 12th";
								}else{
									$desc = "10th";
								}
							?>
							{{--{{ Form::bsFile('doc_dob',$desc . " Certificate *") }} --}}
							{{ Form::bsFile('doc_tenth', "10th Marksheet *") }}
							<small>Only PDF file with size 200KB to 2048 KB allowed</small>
							@if($programme->programmegroup->twelveth == 1)
							{{ Form::bsFile('doc_twelveth', "12th Marksheet *") }}
							<small>Only PDF file with size 200KB to 2048 KB allowed</small>

							@endif
							{{ Form::bsFile('doc_application', "Upload the scanned copy of the application form submitted by the student *") }}
							<div id="doc_community_form" class="hidden">
							{{ Form::bsFile('doc_community',"Proof of SC/ST or OBC Certificate as prescribed in Central Government format") }}
							</div>
							{{ Form::bsFile('signature',"Signature *",'image') }}
							<small>
								Scanned copy of the Signature of student. Only jpeg, jpg, and png image with maximum size 100KB.
							</small>
							<!--{{ Form::bsFile('doc_disability',"Disability Certificate, if the candidate has a disability") }}
							{{ Form::bsFile('doc_percentage_exception',"supporting State Norms G.O.s / Circulars for Percentage exception") }}
							-->
							<hr />

							{{--<label>Additional Documents (If required)</label>

							@for($i=0;$i<5;$i++)
								{{Form::bsFilewithdesc($i)}}
							@endfor

							<div style="width:100%;margin-top: 0px;" class="pull-left">
								<a href="javascript:addfile();" id='addlink'>Add document</a>
							</div>  --}}
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
			</div>
		</div>
		<div class="container">
		<div class="col-md-12" style="background: #FFF;padding:30px;">
							<span>* Mandatory</span>
			<button type="submit" class="btn btn-primary pull-right">Save</button>
			</div>
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
						<center style="height:300px!important;"><img  src="{{asset('images/pleasewait.gif')}}" id="image" style="height:300px!important;" /></center>
					</div>
					<input type='hidden' id='left' />
					<input type='hidden' id='top' />
					<input type='hidden' id='width' />
					<input type='hidden' id='height' />
					<input type='hidden' id='photofile' />
					<input type="hidden" id="fileimagename">
				</div>
				<div class="modal-footer">
					<button type='button' class="btn btn-primary pull-right" onclick="onsave();">Crop</button>
					<button type='button' class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	</div>

	<div id="udidModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Verify UDID / UDID Enrolment No
				</div>
				<div class="modal-body">
					<div style="padding-bottom:10px;">
						<small>Verify UDID/UDID Enrolment number and get candidate details</small>
					</div>
					{{ Form::bsText('ver_udid',"UDID or UDID Enrolment No",'',['class'=>'form-control ver_uid']) }}
					{{ Form::bsDate('ver_dob',"Date of Birth") }}
				</div>
				<div class="modal-footer">
					<button type='button' class="btn btn-primary pull-right" onclick="verifyudid();">Verify</button>
					<button type='button' class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	
	<script>
		function calper(id){
			if($('#tmarks_'+id).val()>0 && $('#omarks_'+id).val()>0 ){
				if(parseInt($('#omarks_'+id).val())>parseInt($('#tmarks_'+id).val())){
					swal({
						type: 'error',
						title: 'Obtained marks cannot be more than total marks',
						showConfirmButton: true,
						timer: 4500
					});
				}
				$('#percentage_'+id).val(((parseInt($('#omarks_'+id).val()) / parseInt($('#tmarks_'+id).val()))*100).toFixed(2));
			}
		}
var Verhoeff = {
        "d": [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            [1, 2, 3, 4, 0, 6, 7, 8, 9, 5],
            [2, 3, 4, 0, 1, 7, 8, 9, 5, 6],
            [3, 4, 0, 1, 2, 8, 9, 5, 6, 7],
            [4, 0, 1, 2, 3, 9, 5, 6, 7, 8],
            [5, 9, 8, 7, 6, 0, 4, 3, 2, 1],
            [6, 5, 9, 8, 7, 1, 0, 4, 3, 2],
            [7, 6, 5, 9, 8, 2, 1, 0, 4, 3],
            [8, 7, 6, 5, 9, 3, 2, 1, 0, 4],
            [9, 8, 7, 6, 5, 4, 3, 2, 1, 0]],
        "p": [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            [1, 5, 7, 6, 2, 8, 3, 0, 9, 4],
            [5, 8, 0, 3, 7, 9, 6, 1, 4, 2],
            [8, 9, 1, 6, 0, 4, 3, 5, 2, 7],
            [9, 4, 5, 3, 1, 2, 6, 8, 7, 0],
            [4, 2, 8, 6, 5, 7, 3, 9, 0, 1],
            [2, 7, 9, 3, 8, 0, 6, 4, 1, 5],
            [7, 0, 4, 6, 9, 1, 3, 2, 5, 8]],
        "j": [0, 4, 3, 2, 1, 5, 6, 7, 8, 9],
        "check": function (str) {
            var c = 0;
            str.replace(/\D+/g, "").split("").reverse().join("").replace(/[\d]/g, function (u, i) {
                c = Verhoeff.d[c][Verhoeff.p[i % 8][parseInt(u, 10)]];
            });
            return c;

        },
        "get": function (str) {

            var c = 0;
            str.replace(/\D+/g, "").split("").reverse().join("").replace(/[\d]/g, function (u, i) {
                c = Verhoeff.d[c][Verhoeff.p[(i + 1) % 8][parseInt(u, 10)]];
            });
            return Verhoeff.j[c];
        }
    };

    String.prototype.verhoeffCheck = (function () {
        var d = [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            [1, 2, 3, 4, 0, 6, 7, 8, 9, 5],
            [2, 3, 4, 0, 1, 7, 8, 9, 5, 6],
            [3, 4, 0, 1, 2, 8, 9, 5, 6, 7],
            [4, 0, 1, 2, 3, 9, 5, 6, 7, 8],
            [5, 9, 8, 7, 6, 0, 4, 3, 2, 1],
            [6, 5, 9, 8, 7, 1, 0, 4, 3, 2],
            [7, 6, 5, 9, 8, 2, 1, 0, 4, 3],
            [8, 7, 6, 5, 9, 3, 2, 1, 0, 4],
            [9, 8, 7, 6, 5, 4, 3, 2, 1, 0]];
        var p = [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            [1, 5, 7, 6, 2, 8, 3, 0, 9, 4],
            [5, 8, 0, 3, 7, 9, 6, 1, 4, 2],
            [8, 9, 1, 6, 0, 4, 3, 5, 2, 7],
            [9, 4, 5, 3, 1, 2, 6, 8, 7, 0],
            [4, 2, 8, 6, 5, 7, 3, 9, 0, 1],
            [2, 7, 9, 3, 8, 0, 6, 4, 1, 5],
            [7, 0, 4, 6, 9, 1, 3, 2, 5, 8]];

        return function () {
            var c = 0;
            this.replace(/\D+/g, "").split("").reverse().join("").replace(/[\d]/g, function (u, i) {
                c = d[c][p[i % 8][parseInt(u, 10)]];
            });
            return (c === 0);
        };
    })();
		function verifyudid(){
			console.log('start');
			if($('input[name="ver_dob"]').val()=='')
			{
				swal({
						type: 'error',
						title: 'Please enter valid Date of Birth',
						showConfirmButton: false,
						timer: 1500
					});
			}
			if($('input[name="ver_udid"]').val().length != 18 && $('input[name="ver_udid"]').val().length != 23){
				swal({
						type: 'error',
						title: 'Please enter valid UDID',
						showConfirmButton: false,
						timer: 1500
					});
			}
			var formData = new FormData();
		//	formData.append('udid','07070000023051473049');
	//		formData.append('dob','1955-01-01');
			/*$.ajax({
				url: 'https://delhigw.napix.gov.in/nic/depwd/udid-login/depwd-udidapi',
				method: 'POST',
				dataType: 'json',
				contentType: false,
				processData: false,
				data: formData,
				headers: {
					'X-Client-Id': '6c2a46576b620c5699cf6ab99e737a60',
					'accept': 'application/json',
					'clientsecret': '0b0019de595d0e91ee9524391de7ae2c',
					'content-type': 'application/json',
				},
				success: function (data) {
					swal({
						type: 'success',
						title: 'UDID Verified',
						showConfirmButton: false,
						timer: 1500
					});
					$('#udidModal').modal('hide');
					console.log(data);
				},
				error: function (data) {
					swal({
						type: 'error',
						title: 'Could not verify UDID, Please check the number and try again.',
						showConfirmButton: false,
						timer: 1500
					});
					console.log(data);
				}
			}); */
		/*	formData.append('udid','07070000023051473049');
			formData.append('dob','1955-01-01');

			$.ajax({
				url: 'https://www.swavlambancard.gov.in/Api/getApplicationInformation',
				method: 'POST',
				dataType: 'json',
				contentType: false,
				processData: false,
				data: formData,
				success: function (data) {
					swal({
						type: 'success',
						title: 'UDID Verified',
						showConfirmButton: false,
						timer: 1500
					});
					$('#udidModal').modal('hide');
					console.log(data);
				},
				error: function (data) {
					swal({
						type: 'error',
						title: 'Could not verify UDID, Please check the number and try again.',
						showConfirmButton: false,
						timer: 1500
					});
					console.log(data);
				}
			}); */
			
		}
		function showhideudid(){
			if($('input[type=radio][name=isdisabled]:checked').val()==0){
				$('.showhideudid').addClass('hidden');
			}else{
				$('.showhideudid').removeClass('hidden');
			}
		}

		function loadPDistricts(id){
				var formData = new FormData();
				var token = $('input[name=_token]');
				formData.append('state_id', $('#pstate_id').val());
				$.ajax({
					url: '{{url("getdistricts")}}',
					method: 'POST',
					dataType: 'json',
					contentType: false,
					processData: false,
					headers: {
						'X-CSRF-TOKEN': token.val()
					},
					data: formData,
					success: function (data) {
						if(data =='nodata' || data.length == 0 ){
							swal({
								type: 'warning',
								title: 'No data found',
								showConfirmButton: false,
								timer: 1500
							});
						}else{
						//	$('#pdistrictsdiv').removeClass('hidden');
							$('#pdistrict_id').html('');
							$('#psubdistrict_id').html('');
						//	$('#psubdistrictsdiv').addClass('hidden');
						//	$('#pvillagediv').addClass('hidden');
							$('#pvillage_id').html('');
							$('#pdistrict_id').append('<option value="0" selected disabled>Choose district</option>');
							data.forEach(function (value,key) {
								if(id!=0){
									if(id==value.id){
										$('#pdistrict_id').append('<option selected value="'+value.id+'">'+ value.districtName  +'</option>');
										loadPSubdistricts($('#subdistrict_id').val(),$('#village_id').val());
									}else{
										$('#pdistrict_id').append('<option value="'+value.id+'">'+ value.districtName  +'</option>');
									}
								}else{
									$('#pdistrict_id').append('<option value="'+value.id+'">'+ value.districtName  +'</option>');
								}
							});
						}
					},
					error: function (data) {
						swal({
								type: 'warning',
								title: 'No data found',
								showConfirmButton: false,
								timer: 1500
							});
					}
				});
			}
        $(document).ready(function() {
			/*if($("#saa").is(':checked')){
					$('.per-add').addClass('hidden');
				}else{
					$('.per-add').removeClass('hidden');
				}*/
				showhideudid();
				$('#name').attr('autofocus',true);
			$('input[type=radio][name=isdisabled]').change(function() {
				showhideudid();
				if (this.value == 1) {
					//$('#udidModal').modal('show');
				}
				else{
				//	$('#udidModal').modal('hide');
				}
			});
			$('#saa').on('change',function(){
				$('input[name="paddress"]').val($('input[name="address"]').val());
				$('input[name="ppincode"]').val($('input[name="pincode"]').val());
				if($(this).is(':checked')){
					if($('#state_id').val() > 0){
						$('#pstate_id').val($('#state_id').val());
						loadPDistricts($('#district_id').val());
					}
				/*	$('.saa').attr('disabled',true);
					$('#pstate_id').attr('disabled',true);
					$('#pdistrict_id').attr('disabled',true);
					$('#psubdistrict_id').attr('disabled',true);
					$('#pvillage_id').attr('disabled',true); 
				}else{
					$('.saa').attr('disabled',false);
					$('#pstate_id').attr('disabled',false);
					$('#pdistrict_id').attr('disabled',false);
					$('#psubdistrict_id').attr('disabled',false);
					$('#pvillage_id').attr('disabled',false);*/
				}
			});
			$('.num').keypress(function (e) {    
				var charCode = (e.which) ? e.which : event.keyCode    

				if (String.fromCharCode(charCode).match(/[^0-9]/g))    

					return false;                        

			});    
			$('#form').on('submit',function(e){
				//$('input').attr('disabled',false);
				var uid = $('#aadhar').val().replace(/\s/g, "");
				//if($("#nationality_id").val()==86){
					if (Verhoeff['check'](uid) === 0) {
					} else {
						swal({
							type: 'warning',
							title: 'Please enter valid Aadhar Card number',
							showConfirmButton: true,
							timer: 3500
						});
						return false;
					}
				//}
			});
			$('#isdisabled').on('change',function(){
				if($(this).val()==1){
					$('.disability').removeClass('hidden');
				}
			});
			$('#state_id').on('change',function(){
				var formData = new FormData();
				var token = $('input[name=_token]');
				formData.append('state_id', $('#state_id').val());
				console.log($('#state_id').val());
				$.ajax({
					url: '{{url("getdistricts")}}',
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
						if(data =='nodata' || data.length == 0 ){
							swal({
								type: 'warning',
								title: 'No data found',
								showConfirmButton: false,
								timer: 1500
							});
						}else{
						//	$('#districtsdiv').removeClass('hidden');
							$('#district_id').html('');
							$('#subdistrict_id').html('');
						//	$('#subdistrictsdiv').addClass('hidden');
						//	$('#villagediv').addClass('hidden');
							$('#village_id').html('');
							$('#district_id').append('<option value="0" selected disabled>Choose district</option>');
							var old = parseInt("{{old('district_id')}}");
							console.log("old"+old);
							data.forEach(function (value,key) {
							console.log(value.id);

								if(old===value.id){
									$('#district_id').append('<option selected  value="'+value.id+'">'+ value.districtName  +'</option>');
								}else{
									$('#district_id').append('<option  value="'+value.id+'">'+ value.districtName  +'</option>');
								}
							});
							if($('#saa').is(':checked')){
								$('#pstate_id').val($('#state_id').val());
								loadPDistricts();
							}
						}
					},
					error: function (data) {
						swal({
								type: 'warning',
								title: 'No data found',
								showConfirmButton: false,
								timer: 1500
							});
					}
				});
			});
			$('#district_id').on('change',function(){
				var formData = new FormData();
				var token = $('input[name=_token]');
				formData.append('district_id', $('#district_id').val());
				$.ajax({
					url: '{{url("getsubdistricts")}}',
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
						if(data =='nodata' || data.length == 0 ){
							swal({
								type: 'warning',
								title: 'No data found',
								showConfirmButton: false,
								timer: 1500
							});
						}else{
						//	$('#subdistrictsdiv').removeClass('hidden');
							$('#subdistrict_id').html('');
					//		$('#villagediv').removeClass('hidden');
							$('#village_id').html('');
							$('#subdistrict_id').append('<option value="0" selected disabled>Choose Sub district  / Tehsil / Taluk</option>');
							$('#village_id').append('<option value="0" selected disabled>Choose Block / Village </option>');
							if(data['subdistricts'].length == 0){
							//	$('#subdistrict_id').attr('disabled',true);
							}else{
							//	$('#subdistrict_id').attr('disabled',false);
							var old = parseInt("{{old('subdistrict_id')}}");

								data['subdistricts'].forEach(function (value,key) {
									if(value.id==old){
										$('#subdistrict_id').append('<option selected value="'+value.id+'">'+ value.Sub_district_Name  +'</option>');
									}else{
										$('#subdistrict_id').append('<option value="'+value.id+'">'+ value.Sub_district_Name  +'</option>');
									}
								});
							}
							if(data['blocks'].length == 0){
							//	$('#village_id').attr('disabled',true);
							}else{
							//	$('#village_id').attr('disabled',false);
							var old = parseInt("{{old('village_id')}}");

								data['blocks'].forEach(function (value,key) {
									if(value.id==old){
										$('#village_id').append('<option selected value="'+value.id+'">'+ value.Block_Name  +'</option>');
									}else{
										$('#village_id').append('<option value="'+value.id+'">'+ value.Block_Name  +'</option>');
									}
								}); 
							}
							if($('#saa').is(':checked')){
								$('#pdistrict_id').val($('#district_id').val());
								loadPSubdistricts(0,0);
							}
							
						}
					},
					error: function (data) {
						console.log(data);
						swal({
								type: 'warning',
								title: 'No data found',
								showConfirmButton: false,
								timer: 1500
							});
					}
				});
			});

			$('#pstate_id').on('change',function(){
				loadPDistricts(0);
			});
			function loadPDistricts(id){
				var formData = new FormData();
				var token = $('input[name=_token]');
				formData.append('state_id', $('#pstate_id').val());
				$.ajax({
					url: '{{url("getdistricts")}}',
					method: 'POST',
					dataType: 'json',
					contentType: false,
					processData: false,
					headers: {
						'X-CSRF-TOKEN': token.val()
					},
					data: formData,
					success: function (data) {
						if(data =='nodata' || data.length == 0 ){
							swal({
								type: 'warning',
								title: 'No data found',
								showConfirmButton: false,
								timer: 1500
							});
						}else{
						//	$('#pdistrictsdiv').removeClass('hidden');
							$('#pdistrict_id').html('');
							$('#psubdistrict_id').html('');
						//	$('#psubdistrictsdiv').addClass('hidden');
						//	$('#pvillagediv').addClass('hidden');
							$('#pvillage_id').html('');
							$('#pdistrict_id').append('<option value="0" selected disabled>Choose district</option>');
							data.forEach(function (value,key) {
								if(id!=0){
									if(id==value.id){
										$('#pdistrict_id').append('<option selected value="'+value.id+'">'+ value.districtName  +'</option>');
										loadPSubdistricts($('#subdistrict_id').val(),$('#village_id').val());
									}else{
										$('#pdistrict_id').append('<option value="'+value.id+'">'+ value.districtName  +'</option>');
									}
								}else{
									$('#pdistrict_id').append('<option value="'+value.id+'">'+ value.districtName  +'</option>');
								}
							});
						}
					},
					error: function (data) {
						swal({
								type: 'warning',
								title: 'No data found',
								showConfirmButton: false,
								timer: 1500
							});
					}
				});
			}
			$('#pdistrict_id').on('change',function(){
				loadPSubdistricts(0,0);
			});
			$('#subdistrict_id').on('change',function(){
				if($('#saa').is(':checked')){
					$('#psubdistrict_id').val($('#subdistrict_id').val());
				}
			});

			$('#village_id').on('change',function(){
				if($('#saa').is(':checked')){
					$('#pvillage_id').val($('#village_id').val());
				}
			});
			

			function loadPSubdistricts(tid,vid){
				var formData = new FormData();
				var token = $('input[name=_token]');
				formData.append('district_id', $('#pdistrict_id').val());
				$.ajax({
					url: '{{url("getsubdistricts")}}',
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
						if(data =='nodata' || data.length == 0 ){
							swal({
								type: 'warning',
								title: 'No data found',
								showConfirmButton: false,
								timer: 1500
							});
						}else{
							$('#psubdistrictsdiv').removeClass('hidden');
							$('#psubdistrict_id').html('');
							$('#pvillagediv').removeClass('hidden');
							$('#pvillage_id').html('');
							$('#psubdistrict_id').append('<option value="0" selected disabled>Choose Sub District / Tehsil / Taluk</option>');
							$('#pvillage_id').append('<option value="0" selected disabled>Choose Sub District / Tehsil / Taluk</option>');
							if(data['subdistricts'].length == 0){
								//	$('#psubdistrict_id').attr('disabled',true);
								
							}else{
								if(!$('#saa').is(':checked')){
								//	$('#psubdistrict_id').attr('disabled',false);
								}
								data['subdistricts'].forEach(function (value,key) {
									if(tid!=0){
										if(tid==value.id){
											$('#psubdistrict_id').append('<option selected value="'+value.id+'">'+ value.Sub_district_Name  +'</option>');
										}else{
											$('#psubdistrict_id').append('<option value="'+value.id+'">'+ value.Sub_district_Name  +'</option>');
										}
									}else{
											$('#psubdistrict_id').append('<option value="'+value.id+'">'+ value.Sub_district_Name  +'</option>');
									}
								});
							}
							if(data['blocks'].length == 0){
								//$('#pvillage_id').attr('disabled',true);
							}else{
								if(!$('#saa').is(':checked')){
								//	$('#pvillage_id').attr('disabled',false);
								}
								data['blocks'].forEach(function (value,key) {
									if(vid!=0){
										if(vid==value.id){
											$('#pvillage_id').append('<option selected value="'+value.id+'">'+ value.Block_Name  +'</option>');
										}else{
											$('#pvillage_id').append('<option value="'+value.id+'">'+ value.Block_Name  +'</option>');
										}
									}else{
										$('#pvillage_id').append('<option value="'+value.id+'">'+ value.Block_Name  +'</option>');
									}
								});
							}
							
						}
					},
					error: function (data) {
						swal({
								type: 'warning',
								title: 'No data found',
								showConfirmButton: false,
								timer: 1500
							});
					}
				});
			}

	

			
            //$(".ls").chosen();
            $('#doc_percentage_exception_form').addClass('hidden');
            if($('#community_id').val()<2){
                $('#doc_community_form').addClass('hidden');
            }
           /* if($('#disability_id').val()<2){
                $('#doc_disability_form').addClass('hidden');
            }
            if($('#pex').prop('checked')==false){
                $('#doc_percentage_exception_form').addClass('hidden');
            }*/
            //alert($('#pex').prop('checked'));
        });

        $('#disability_id').on('change',function(){
            if($(this).val()>1){
                $('#doc_disability_form').removeClass('hidden');
            }else{
                $('#doc_disability_form').addClass('hidden');
            }
        });

        $('#disability_id').on('change', function () {
            if($(this).val() == 5){
                $('#disability_name').attr('disabled', false);
            }
            else {
                $('#disability_name').attr('disabled', true);
            }
        })
        $('input[name="community_id"]').on('change',function(){
			console.log('t'+$(this).val());
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
        $('.file').on('change', function() {



        });
        function onsave(){
            //$('#myModal').modal('hide');
            var formData = new FormData();
            var token = $('input[name=_token]');
			var filename = $('#fileimagename').val();
            formData.append('height', $('#height').val());
            formData.append('width',  $('#width').val());
            formData.append('left', $('#left').val());
            formData.append('top', $('#top').val());
            formData.append('filename',$('#'+filename).val())
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
						
                        $("#"+filename+"_filename").prop('src',"{{asset('files')}}/temp/cropped/"+$('#'+filename).val());
                        //	$("#photo_filename").html("photo."+$('#photo').val().split('.').pop());
                        $("#"+filename+"_filename").removeClass('hidden');


                    }
                }

            });

        }

		

	</script>
@endsection

@section('script')
	<script src="{{asset('js/cropper.js')}}"></script>
@endsection
