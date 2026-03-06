
<tr>
		<td rowspan="5">
			<h1> <span class="label label-info">			{{$candidate->approvedprogramme->institute->user->username}}</span></h1>

		</td>
		<td>
			Institute
		</td>
		<td>
			{{$candidate->approvedprogramme->institute->name}}
			@if(Auth::user()->usertype_id == 1)
			<br />	Contact Person: 	{{$candidate->approvedprogramme->institute->contact }}  - {{ $candidate->approvedprogramme->institute->contactnumber1 }} / {{$candidate->approvedprogramme->institute->contactnumber2 }}
			@endif 	
		</td>
	</tr>
	<tr>
		<td>
			Enrolment Number
		</td>
		<td>
			{{$candidate->enrolmentno}}
		</td>
	</tr>
<tr>
		<td>
			Programme
		</td>
		<td>
						{{$candidate->approvedprogramme->programme->name}}

		</td>
	</tr>
	<tr>
		<td>
			Programme Code
		</td>
		<td>
						{{$candidate->approvedprogramme->programme->course_name}}

		</td>
	</tr>
	<tr>
		<td>
			Admission Year
		</td>
		<td>
						{{$candidate->approvedprogramme->academicyear->year}}

		</td>
	</tr>
<tr>
	<td style="width:100px;vertical-align:top!important;" rowspan="17">
		<img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}" style="width: 100px;" class="img" /> 
	</td>
</tr>
<tr>
	<td style="width:200px;">
		Status:
	</td>
	<td>
		{!!$candidate->statushtml()!!}
	</td>
</tr>
<tr>
	<td style="width:200px;">
		Name:
	</td>
	<td>
		{{$candidate->name}}
	</td>
</tr>
<tr>
		<td>
			Father's Name
		</td>
		<td>
			{{$candidate->fathername}}
		</td>
	</tr>
	<tr>
		<td>
			Mother's Name
		</td>
		<td>
			{{$candidate->mothername}}
		</td>
	</tr>
	<tr>
		<td>
			Gender
		</td>
		<td>
			@if($candidate->gender_id > 0)
			{{$candidate->gender->gender}}
			@endif
		</td>
	</tr>
	<tr>
		<td>
			PwD
		</td>
		<td>
			@if($c->isdisabled == 1)
				UDID / UDID Enrolment: {{$candidate->udid}} ,
			@else
				@if($c->disablity_id > 0)
					{{$c->disability->disability}}
				@else
					No
				@endif
			@endif
		</td>
	</tr>
	<tr>
		<td>
			DOB
		</td>
		<td>
			<?php 
			 $date = \Carbon\Carbon::parse($candidate->dob);
            $dob =  $date->toFormattedDateString();
            ?>
			{{$dob}}
		</td>
	</tr>
	<tr>
		<td>
		@if($c->approvedprogramme_id > 4174)
			Nationality
			@endif
		</td>
		<td>
		@if($c->approvedprogramme_id > 4174)
		@if(!is_null($candidate->nationality_id))
			{{$candidate->nationality->name}}
			@endif
			@endif

		</td>
	</tr>

	
	<tr>
		<td>
			Aadhar Number
		</td>
		<td>
			{{$candidate->aadhar}}
		</td>
	</tr>
	<tr>
		<td>
			Category
		</td>
		<td>
		{{$candidate->community->community}} 
		</td>
	</tr>
	
	<tr>
		<td>
		@if($c->approvedprogramme_id > 4174)
		Do You Belong To EWS Category? 
		@endif
		</td>
		<td>
		@if($c->approvedprogramme_id > 4174)
			@if($candidate->ews == 1) Yes @else No @endif
		@endif

		</td>
	</tr>
	<tr>
		<td>
			Email ID
		</td>
		<td>
			{{$candidate->email}}
		</td>
	</tr>

	<tr>
		<td>
			Mobile Number
		</td>
		<td>
			{{$candidate->contactnumber}}
			@if(Auth::user()->usertype_id == 1)
			<a href="javascript:changemobile({{$candidate->id}},'{{$candidate->name}}');"  class="btn btn-xs btn-warning">Change Mobile Number </a>
			@endif
		</td>
	</tr>

	<tr>
		<td>
			Currespondance Address
		</td>
		<td>
			<strong>Address: </strong>{{$candidate->address}}
			<br />
		@if($c->approvedprogramme_id > 4174)
					@if($c->state_id > 0)
						<strong>State: </strong>{{$candidate->lgstate->state_name}}
					@endif
					<br />
					@if(!is_null($c->district_id) && $c->district_id !=0 )
						<strong>District: </strong>{{$candidate->district->districtName}}
					@endif
					<br />
					@if(!is_null($c->subdistrict_id) && $c->subdistrict_id != 0 )
						<strong>Subdistrict: </strong>{{$candidate->subdistrict->Sub_district_Name}}
					@endif
					<br />
					@if(!is_null($c->village_id) && $c->village_id != 0)
						<strong>Block/ Village: </strong>{{$candidate->village->Block_Name}}
					@endif
					<br />
					@if($c->pincode != '')
						<strong>PIN Code: </strong>{{$candidate->pincode}}
					@endif
				@endif
		</td>
	</tr>
	<tr>
		<td>
			Permanent Address
		</td>
		<td>
		@if($c->approvedprogramme_id > 4174)

		<strong>Address: </strong>{{$candidate->paddress}} 
					<br />
					@if($c->pstate_id > 0)
						<strong>State: </strong>{{$candidate->plgstate->state_name}}
					@endif
					<br />
					@if($c->pdistrict_id > 0)
						<strong>District: </strong>{{$candidate->pdistrict->districtName}}
					@endif
					<br />
					@if($c->psubdistrict_id > 0)
						<strong>Subdistrict: </strong>{{$candidate->psubdistrict->Sub_district_Name}}
					@endif
					<br />
					@if($c->pvillage_id != null && $c->pvillage_id > 0)
						<strong>Block/ Village: </strong>{{$candidate->pvillage->Block_Name}}
					@endif
					<br />
					@if($c->ppincode != '')
					<strong>PIN Code:</strong> {{$candidate->ppincode}}
					@endif 
				@endif
		</td>
	</tr>
	<tr>
		<td>
	@if($c->approvedprogramme_id > 4174)

			Education Details
			@endif
		</td>
		<td>

		@if($c->approvedprogramme_id > 4174)

		<table class="table table-bordered tab-pane active" id="education_{{$candidate->id}}">
			<tr>
				<th>Education</th>
				<th>Board</th>
				<th>Year of passing</th>
				<th>Total Marks</th>
				<th>Optained Marks</th>
				<th>Percentage</th>
				<th>Subjects</th>
				<th>Marksheet</th>
			</tr>
			@foreach($candidate->educations as $edu)
				<tr>
					<td>{{$edu->edugrade}}</td>
					<td>{{$edu->board}}</td>
					<td>{{$edu->yop}}</td>
					<td>{{$edu->tmarks}}</td>
					<td>{{$edu->omarks}}</td>
					<td>{{$edu->percentage}}</td>
					<td>{{$edu->subjects}}</td>
					<td>
					@if($edu->edugrade == '10th')
					<a href="{{asset('files/enrolment/marksheets/tenth/').'/'.$c->doc_tenth}}" target="_blank">10th Marksheet&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a>
					@endif
					
					@if($edu->edugrade == '12th')
					<a href="{{asset('files/enrolment/marksheets/twelveth/').'/'.$c->doc_twelveth}}" target="_blank">12th Marksheet&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a>
					@endif
					</td>
				</tr>
			@endforeach
         </table>
		</td>
		@endif
	</tr>
<tr>
		<td>
			Other
		</td>
		<td>
					{{--@if($candidate->disability_id>1)
         				@if($candidate->doc_disability == NULL)
         					<strong style="font-color:red;">Disability Certificate missing</strong>
         				@else
         					Disability Certificate: <a href="{{asset('files/enrolment/d').'/'.$candidate->doc_disability}}" target="_blank">{{$candidate->doc_disability}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a>
         				@endif
         				<br />
         			@endif--}}


					@if($candidate->community_id > 1 &&  $candidate->doc_community == NULL)
						<strong style="font-color:red;">Coummiunity Certificate missing</strong>
					@else
					Community Certificate:  <a href="{{asset('files/enrolment/c').'/'.$candidate->doc_community}}" target="_blank">{{$candidate->doc_community}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a>
					@endif
					<br />

         			@if($candidate->candidatefiles)
         			@if($candidate->candidatefiles->count() > 0)
         				@foreach($candidate->candidatefiles as $ad)
         				 {{$ad->description}} : <a  target="_blank" href="{{url('files/enrolment/additional/').'/'.$ad->filename}}">{{$ad->filename}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a> <br />
         				@endforeach
         			@endif
                  @endif

		</td>
	</tr>
	
	

