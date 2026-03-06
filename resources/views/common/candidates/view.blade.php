<div class="modal-body">
         <table class="table table-bordered tab-pane active" id="details_{{$c->id}}">
         	<tr>
         		<td>
         			Programme
         		</td>
         		<td>
         			{{$c->approvedprogramme->programme->course_name}}
         		</td>
         		<td>
         			Institute
         		</td>
         		<td>
         			<a href="#" data-toggle="tooltip" title="{{$c->approvedprogramme->institute->name}}">
						{{$c->approvedprogramme->institute->user->username}} 
					</a>
         		</td>
         		<td>
				 {{-- @if($c->approvedprogramme->programme->programmegroup_id != '3')
         			Percentage
                  @else
					CRR Number
                  @endif 
				  Percentage--}}
				  Documents 
				 </td>
				 <td>
					@if($c->approvedprogramme_id > 4174)
					Application Form: <br />
					<a href="{{asset('files/enrolment/applications').'/'.$c->doc_application}}" target="_blank">{{$c->doc_application}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a>
					@endif
					@if($c->community_id>1)
         				@if($c->doc_community == NULL)
         				@else
							 <br />
							Category: <br />
							<a href="{{asset('files/enrolment/c').'/'.$c->doc_community}}" target="_blank">{{$c->doc_community}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a>
						@endif
         			@endif

         		</td>
         		<td>
				 {{-- @if($c->approvedprogramme->programme->programmegroup_id != '3')
            			{{$c->percentage}}
            			@if($c->doc_mark==NULL)
            				<strong style="font-color:red;">Markscard missing</strong>
            			@else
            				<br /><a href="{{asset('files/enrolment/marksheets').'/'.$c->doc_mark}}" target="_blank">{{$c->doc_mark}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a>
            			@endif
            			
            			@if($c->doc_percentage_exception!=NULL)
            				<br /><a href="{{asset('files/enrolment/p').'/'.$c->doc_percentage_exception}}" target="_blank">{{$c->doc_percentage_exception}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a>
            			@endif
                  @else
                     {{$c->crr}}, Reg Date:
                     {{$c->date_of_reg}}, @if($c->date_of_ren) Renewal Date: {{$c->date_of_ren}} @endif
                     @if($c->doc_rci==NULL)
                        <strong style="font-color:red;">CRR Certificate is missing</strong>
                     @else
                        <br /><a href="{{asset('files/enrolment/crr').'/'.$c->doc_rci}}" target="_blank">{{$c->doc_rci}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a>
                     @endif
                     @if($c->doc_mark!=NULL)
                     <br />Marks: <a href="{{asset('files/enrolment/marksheets').'/'.$c->doc_mark}}" target="_blank">{{$c->doc_mark}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a>
                     @endif
                  @endif --}}
         		</td>
         	</tr>
         	<tr>
         		<td>
         			Date of Birth
         		</td>
         		<td>
         			{{\Carbon\Carbon::parse($c->dob)->format('d-m-Y')}}
					{{--
            			@if($c->doc_dob==NULL)
                        @if($c->approvedprogramme->programme->programmegroup_id != '3')
            				  <strong style="font-color:red;">Proof missing</strong>
                        @endif
            			@else
            				<br /><a href="{{asset('files/enrolment/dateofbirth').'/'.$c->doc_dob}}" target="_blank">{{$c->doc_dob}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a>
            			@endif
					--}}
                  
         		</td>
         		<td>
         			Contact
         		</td>
         		<td>
         			{{$c->contactnumber}}
         		</td>
         		<td>
         			Community
         		</td>
         		<td>
                  
         			{{$c->community->community}}
         			@if($c->community_id>1)
         				@if($c->doc_community == NULL)
         					<strong style="font-color:red;">Certificate missing</strong>
         				@else
         					<br /><a href="{{asset('files/enrolment/c').'/'.$c->doc_community}}" target="_blank">{{$c->doc_community}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a>
         				@endif
         			@endif
         		</td>
         	</tr>
         	<tr>
         		<td>
         			Disability
         		</td>
         		<td>
				    
					@if($c->approvedprogramme_id > 4174)

						@if($c->isdisabled == 1)
							UDID / UDID Enrolment: {{$c->udid}} ,
						@endif
					@else
						@if($c->disability_id > 0)
							{{$c->disability->disability}}
						@endif
					@endif
         		</td>
         		<td>
         			Father's Name
         		</td>
         		<td>
         			
         			{{$c->fathername}}
         		</td>
         		<td>
         			Mother's Name
         		</td>
         		<td>
         			{{$c->mothername}}
         		</td>
         	</tr>
         		<tr>
         		<td>
				 Correspondence Address
         		</td>
         		<td>
				 {{$c->address}} ,
				 @if($c->approvedprogramme_id > 4174)
					<br />
					@if($c->state_id > 0)
						{{$c->lgstate->state_name}}
					@endif
					<br />
					@if($c->district_id >0 )
						{{$c->district->districtName}}
					@endif
					<br />
					@if($c->subdistrict_id > 0 )
						{{$c->subdistrict->Sub_district_Name}}
					@endif
					<br />
					@if($c->village_id > 0)
						{{$c->village->Block_Name}}
					@endif
					<br />
					@if($c->pincode != '')
						PIN Code: {{$c->pincode}}
					@endif
				@endif
         		</td>

				 <td>
				 Permanent Address 
				</td>
         		<td>
				{{$c->paddress}} 
					<br />
					@if($c->pstate_id > 0)
						{{$c->plgstate->state_name}}
					@endif
					<br />
					@if($c->pdistrict_id > 0)
						{{$c->pdistrict->districtName}}
					@endif
					<br />
					@if($c->psubdistrict_id > 0)
						{{$c->psubdistrict->Sub_district_Name}}
					@endif
					<br />
					@if($c->pvillage_id != null && $c->pvillage_id > 0)
						{{$c->pvillage->Block_Name}}
					@endif
					<br />
					@if($c->ppincode != '')
					PIN Code: {{$c->ppincode}}
					@endif
         		</td>
         		<td>
         			Aadhar #
         		</td>
         		<td>
					*** {{substr($c->aadhar,-4)}}
         		</td>
         	</tr>
         	<tr>
         		<td>
         			Email
         		</td>
         		<td>
         			{{$c->email}}
         		</td>
         		<td>
         			Gender
         		</td>
         		<td>
                  @if($c->gender)
         			   {{$c->gender->gender}}
                  @endif
         		</td>
         		<td >
         			Photo
         		</td>
         		<td >
         			<a href="{{url('files/enrolment/photos/').'/'.$c->photo}}" target="_blank" >
         				<img id="img_{{$c->id}}" src="{{url('files/enrolment/photos/').'/'.$c->photo}}" style="width:120px;" />
         			</a>
         		</td>
         		
         	</tr>
         	{{--<tr>
         		<td colspan="4">
         			Additional Documents
                  @if($c->candidatefiles)
         			@if($c->candidatefiles->count() > 0)
         				@foreach($c->candidatefiles as $ad)
         				<br /> {{$ad->description}} : <a  target="_blank" href="{{url('files/enrolment/additional/').'/'.$ad->filename}}">{{$ad->filename}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a> 
         				@endforeach
         			@endif
                  @endif
         		</td>
         		
         	</tr>--}}
            @if($c->candidateapprovals)
         	@if($c->candidateapprovals->count() > 0)
         		<tr>
         			<td colspan="6">
         				Remarks:<br />
         				@foreach($c->candidateapprovals as $ap)
                        @if($ap->user)
	         				{{$ap->created_at}} : {{$ap->user->username}}  {{$ap->comment}}  
                        @else
                        {{$ap->created_at}} :   {{$ap->comment}}  
                        @endif
	         				<br />
         				@endforeach
	         		</td>
	         	</tr>
	         @endif
            @endif
         </table>
		 @if($c->approvedprogramme_id > 4174)
         <table class="table table-bordered tab-pane active" id="education_{{$c->id}}">
			<tr>
				<th>Education</th>
				<th>Board</th>
				<th>Year of passing</th>
				<th>Total Marks</th>
				<th>Obtained Marks</th>
				<th>Percentage</th>
				<th>Subjects</th>
				<th>Marksheet</th>
			</tr>
			@foreach($c->educations as $edu)
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
			@endif
      </div>
        