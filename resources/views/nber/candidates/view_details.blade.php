
@extends('layouts.app')
@section('script')
<script>
   
   function verification(){
      console.log($('input[name="dvalidation"]').val());
      if($('#is_mobile_number_verified').is(':checked')){
         $('#submit').attr('disabled',false);
      }else{
         $('#submit').attr('disabled',true);
      }
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

</script>
@endsection
@section('content')
<style>
   a.disabled {
  pointer-events: none;
  cursor: default;
  color: #ccc;
}
body{
   background:white!important;
}
</style>

<?php $c = $candidate; ?>
<div class="container">
<div class="row">
			<div class="col-md-12">

				<ul class="breadcrumb" style="background:transparent!important;">
					<li><a href="{{url('/nber/admissions')}}">Admissions</a></li>
					<li> <a href="{{url('nber/candidates')}}/{{$c->approvedprogramme->id}}"> {{$c->approvedprogramme->programme->course_name}}  - {{$c->approvedprogramme->academicyear->year}} - {{$c->approvedprogramme->institute->name}} - ({{$c->approvedprogramme->institute->user->username}}) </a> </li>
				</ul>
			</div>
		</div>
    
      <div class="row">
      <div class="col-md-12">
         @include('common.errorandmsg')

        
</div>

      <div class="col-md-12">

   <?php 
      $exam_ids = array_unique($c->applications->lists('exam_id')->toArray());
   ?>
   <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#details_{{$c->id}}">Details</a></li>
      <li><a data-toggle="tab" href="#docs_{{$c->id}}">Documents</a></li>
      
      <li><a href="#marks_{{$c->id}}" class=""  data-toggle="tab" >Marks</a></li>
      @if($candidate->approvedprogramme->academicyear_id < 12 || $candidate->approvedprogramme->programme_id = 57)
      <li><a data-toggle="tab" href="#marksheet_{{$c->id}}">Marksheets & Certificate</a></li>
   @endif
   @if(!is_null($reevaluationapplicaiton))
   <li><a  target="_blank" href="{{url('nber/exams/reevaluation/')}}/{{$reevaluationapplicaiton->id}}">Reevaluation Application</a></li>
   @endif
      @if($c->status_id!=4)
      <li><a href="#applications_{{$c->id}}" class=""  data-toggle="tab" >Supplementary Exam Applications</a></li>
      @endif
      <li><a href="#attendance_{{$c->id}}" class=""  data-toggle="tab" >Class Room Attendance</a></li>
            <li><a href="#payment_{{$c->id}}" class=""  data-toggle="tab" >Payments</a></li>

      <li><a href="#actions_{{$c->id}}" class="btn btn-xs btn-warning"  data-toggle="tab" >Actions</a></li>
      {{-- @if($c->status_id != 2 || $c->enable_name_edit == 1 )
       --}}

       <?php $nid = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id ; ?>
       @if( $nid == 3 || $nid == 2)
       {{-- <li><a href="{{url('nber/candidate/edit/')}}/{{$c->id}}" class="btn btn-xs btn-primary" target="_blank"  >Edit</a></li>  --}}
      @endif
      
      {{--
  @if($candidate->doc_application != null)
   <li><a data-toggle="tab" href="#application_{{$c->id}}">Application Form</a></li>
   @endif

   @if($candidate->doc_tenth != null)
   <li><a data-toggle="tab" href="#tenth_{{$c->id}}">10th Marksheet</a></li>
   @endif

   @if($candidate->doc_twelveth != null)
   <li><a data-toggle="tab" href="#twelveth_{{$c->id}}">12th Marksheet</a></li>
   @endif

   @if($candidate->doc_community != null)
   <li><a data-toggle="tab" href="#community_{{$c->id}}">Category Certificate</a></li>
   @endif
   --}}
   

  
   
   </ul>
   <?php $now = \Carbon\Carbon::now(); ?>
   <div class="tab-content">
   <div class="tab-pane" id="attendance_{{$c->id}}">
      @foreach($attendace as $attendace)
      <h5>{{$attendace->exam->name}}</h5>
      @if(!is_null($attendace))
   <table class="table table-bordered table-condensed">
      
      <tr>
         <th>Theory Attendance</th>
         <td>{{$attendace->attendance_t}}%</td>
      </tr>
      <tr>
         <th>Practicals Attendance</th>
         <td>{{$attendace->attendance_p}}%</td>
      </tr>
      </table>
      @endif
      @endforeach
      </div>
      <div class="tab-pane" id="payment_{{$c->id}}">

    <?php 
        $payment_exam = \App\Allapplicant::where('candidate_id', $c->id)->get(); 
        $payment_rev  = \App\Reevaluationapplication::where('candidate_id', $c->id)->get();
    ?>

    <table class="table table-bordered table-striped" style="width: 100%; background: #fff;">
        <thead class="text-center" style="background: #f2f2f2; font-weight: bold;">
            <tr>
                <th>Type</th>
                <th>Exam</th>
                <th>Total Amount</th>
                <th>Order ID</th>
                <th>Payment Status</th>
            </tr>
        </thead>

        <tbody>
            {{-- Exam Payments --}}
            @foreach ($payment_exam as $payment)
                <tr>
                    <td><strong>Exam</strong></td>
                    <td>{{ $payment->exam->name }}</td>
                    <td>{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->order_id }}</td>
                    <td>
                        @if ($payment->payment_status == 1)
                            <span style="color: green; font-weight: bold;">Paid</span>
                        @else
                            <span style="color: red; font-weight: bold;">Not Paid</span>
                        @endif
                    </td>
                </tr>
            @endforeach

            {{-- Reevaluation Payments --}}
            @foreach ($payment_rev as $payment)
                <tr>
                    <td><strong>Reevaluation</strong></td>
                    <td>{{ $payment->exam->name }}</td>
                    <td>{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->order_id }}</td>
                    <td>
                        @if ($payment->orderstatus_id == 1)
                            <span style="color: green; font-weight: bold;">Paid</span>
                        @else
                            <span style="color: red; font-weight: bold;">Not Paid</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>


      
      

   <div class="tab-pane" id="actions_{{$c->id}}">

@if($candidate->status_id != 9 && (Auth::user()->id == 239184 || Auth::user()->id==87567 ||  Auth::user()->id==99540 || Auth::user()->id==87569 || Auth::user()->id==87568 || Auth::user()->id==88387))
<form action="{{url('/nber/discontinuecandidate')}}" method="post" >
    {{csrf_field()}}
    <div class="form-group " style="width:500px;">
        <button type="submit" class="btn btn-danger " style="margin-top:5px;">Mark as Discontinued </button>
             </div>
    <input type="hidden" name="id" value="{{$c->id}}">
</form>
@endif
@if($candidate->status_id == 6 || $candidate->status_id == 1 || $candidate->status_id == 7 || $candidate->status_id == 9 && (Auth::user()->id == 239184 || Auth::user()->id==87567 ||  Auth::user()->id==99540 || Auth::user()->id==87569 || Auth::user()->id==87568 || Auth::user()->id==88387))
  <form action="{{url('/nber/verifycandidate')}}" method="post" >
    {{csrf_field()}}
    <input type="hidden" name="id" value="{{$c->id}}">
{{-- @if( 
$c->approvedprogramme->programme->id==57 
|| 
   ($c->status_id != 9 && $c->approvedprogramme->enable_admission == 1 && $now->toDateString() <= \Carbon\Carbon::parse($c->approvedprogramme->enable_admission_till)->toDateString() )
||
(!is_null(\App\Allapplicant::where('candidate_id',$c->id)->first()) && $c->status_id != 2 )
) --}}
    <button type="submit" class="btn btn-success" > Mark as Document Verified</button>
    {{-- @endif --}}
  </form>
  <br />
@endif
@if($candidate->status_id == 6 && (Auth::user()->id == 239184 || Auth::user()->id==87567 ||  Auth::user()->id==99540 || Auth::user()->id==87569 || Auth::user()->id==87568 || Auth::user()->id==88387))
<form action="{{url('/nber/rejectcandidate')}}" method="post" >
            {{csrf_field()}}
            <div class="form-group" style="width:500px;">
								<input type="text" id="comment" name="comment" placeholder="What is missing"  class="form-control"  >
                        {{-- @if( 
                        $c->approvedprogramme->programme->id==57 || 
                        ($c->status_id != 9 && $c->approvedprogramme->enable_admission == 1 && $now->toDateString() <= \Carbon\Carbon::parse($c->approvedprogramme->enable_admission_till)->toDateString() )
                        ||
                        (!is_null(\App\Allapplicant::where('candidate_id',$c->id)->first()) && $c->status_id != 2 )
                        ) --}}
                <button type="submit" class="btn btn-warning "   style="margin-top:5px;">Mark as Incomplete Documents </button>
                        {{--  @endif --}}
							</div>
            <input type="hidden" name="id" value="{{$c->id}}">
        </form>
        @endif
        <form action="{{url('/nber/candidate/setpassword')}}" method="post">
         <div class="form-group" style="width:500px;">
         {{csrf_field()}}
         <input type="hidden" name='id' value="{{$c->id}}" >
         <input type="text" name="password" placeholder="Password"  class="form-control" >
         <button type="submit" class="btn btn-warning " style="margin-top:5px;">Change Password </button>
         </div>
        </form>
</div>
   <div class="tab-pane" id="marksheet_{{$c->id}}">
   
       
         <table class="table table-bordered table-condensed">
                <tr>
                     <th>Exam</th>
                    <th>
                        Marksheet / Certificate
                    </th>
                    <th>
                        Result
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Download
                    </th>
                    <th class="hidden" >
                        Re-generate
                    </th>
                </tr>
                <?php $sep2023 = 0; ?>
                
                @if(!is_null($candidate->currentapplicant)              &&    (!is_null($candidate->currentapplicant->sl_no_marksheet_term_one) && !is_null($candidate->currentapplicant->term_one_result_id) )
                  )
                  <?php $sep2023 = 1; ?>
                <tr>
                     <td>
                        Sep 2023
                     </td>
                    <td>
                        Term One Marksheet
                    </td>
                    <td>
                        @if($candidate->currentapplicant->term_one_result_id == 1)
                        <span style="color:green;">Pass</span>
                        @endif
                        @if($candidate->currentapplicant->term_one_result_id == 0)
                        <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>
                     @if(!is_null($candidate->currentapplicant->marksheetissuded_date))
                    {{\Carbon\Carbon::parse($candidate->currentapplicant->marksheetissuded_date)->toFormattedDateString()}}
                    @endif
                    </td>
                    <td>
                    <a href="{{url('nber/marksheet')}}/{{$candidate->currentapplicant_id}}/1?v={{$candidate->new_changes}}">Download Term One Marksheet</a>
                    </td>
                    <td>
                     
                     <a class="" href="{{url('nber/marksheetregen')}}/{{$candidate->id}}/{{ $candidate->approvedprogramme->programme->numberofterms }}/0?term=1">Re-Generate</a><br><br>

                                          <a class="" href="{{url('nber/marksheetregen')}}/{{$candidate->id}}/{{ $candidate->approvedprogramme->programme->numberofterms }}/1?term=1">Forced Re-Generate</a>

                     {{-- @if((!is_null($candidate->currentapplicant)  ))
                        <a class="hidden" href="{{url('regenerate')}}/{{$candidate->id}}/1">Re-Generate</a><br>
                     @endif --}}
                    </td>
                    </tr>
                @endif
                @if(!is_null($candidate->currentapplicant) && 
                  $candidate->approvedprogramme->programme->numberofterms == 2 && $candidate->approvedprogramme->academicyear_id < 10
                //&& !is_null($candidate->currentapplicant->sl_no_marksheet_term_two) && !is_null($candidate->currentapplicant->term_two_result_id)
                )
                <?php $sep2023 = 1; ?>
                    <tr>
                     
                    <td>
                        Sep 2023
                     </td>
                    <td>
                        Term Two Marksheet
                    </td>
                    <td>
                        @if($candidate->currentapplicant->term_two_result_id == 1)
                        <span style="color:green;">Pass</span>
                        @endif
                        @if($candidate->currentapplicant->term_two_result_id == 0)
                        <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>
                     @if(!is_null($candidate->currentapplicant->marksheetissuded_date))
                        {{\Carbon\Carbon::parse($candidate->currentapplicant->marksheetissuded_date)->toFormattedDateString()}}
                     @endif
                    </td>
                    <td>
                     <a href="{{url('nber/marksheet')}}/{{$candidate->currentapplicant_id}}/2?v={{$candidate->new_changes}}">Download Term Two Marksheet</a>
                    </td>
                    <td>
                        <a class="" href="{{url('nber/marksheetregen')}}/{{$candidate->id}}/{{ $candidate->approvedprogramme->programme->numberofterms }}/0?term=2">Re-Generate</a><br>
                        <a class="" href="{{url('nber/marksheetregen')}}/{{$candidate->id}}/{{ $candidate->approvedprogramme->programme->numberofterms }}/1?term=2">Forced Re-Generate</a>

                        
                     {{-- @if((!is_null($candidate->currentapplicant)))
                        <a class="hidden" href="{{url('nber/markshesetregen')}}/{{$candidate->id}}/{{ $candidate->approvedprogramme->programme->numberofterms }}?term=1">Re-Generate</a><br>
                     @endif --}}
                    </td>
                    </tr>
                @endif
                @if(!is_null($candidate->currentapplicant) &&  !is_null($candidate->currentapplicant->slno_certificate) && is_null($candidate->currentapplicant->reevaluation_slno_certificate))
                    <tr>
                     <?php $sep2023 = 1; ?>
                    <td>
                        Sep 2023
                     </td>
                    <td>
                        Certificate
                    </td>
                    <th><span style="color:green;">Pass</span></th>
                    <td>
                        @if(!is_null($candidate->currentapplicant->certificate_date))
                           {{\Carbon\Carbon::parse($candidate->currentapplicant->certificate_date)->toFormattedDateString()}}
                        @endif
                    </td>
                    <td>
                    <a href="{{url('nber/certificate')}}/{{$candidate->currentapplicant_id}}?v={{$candidate->new_changes}}">Download Certificate</a>
                    </td>
                    <td>
                     <a class="" href="{{url('nber/certificate')}}/{{$candidate->currentapplicant_id}}/?v={{$candidate->new_changes}}&force=1">Re-Generate</a><br>

                    </td>
                    </tr>
                @endif

                
                   
                @if(!is_null($candidate->currentapplicant) && !is_null($candidate->currentapplicant->reevaluation_sl_no_marksheet_term_one) && !is_null($candidate->currentapplicant->reevaluation_term_one_result_id) )
                {{-- @if($candidate->currentapplicant->marksheetissuded_date  < $candidate->currentapplicant->reevaluation_marksheetissuded_date) --}}
                <tr>
                  <?php $sep2023 = 1; ?>
                <td>
                        Sep 2023
                     </td>
                    <td>
                        Term One Marksheet (Reevaluated)
                    </td>
                    <td>
                        @if($candidate->currentapplicant->reevaluation_term_one_result_id == 1)
                        <span style="color:green;">Pass</span>
                        @endif
                        @if($candidate->currentapplicant->reevaluation_term_one_result_id == 0)
                        <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>
                     
                    {{\Carbon\Carbon::parse($candidate->currentapplicant->reevaluation_marksheetissuded_date)->toFormattedDateString()}}
                    </td>
                    <td>
                     
                    <a href="{{url('nber/marksheet')}}/re/{{$candidate->currentapplicant_id}}/1?v={{$candidate->new_changes}}">Download Term One Marksheet</a>
                    </td>
                    {{-- <td>
                     <a class="hidden"  href="{{url('regenerate')}}/{{$candidate->currentapplicant_id}}/1">Regenerate</a>
                    </td> --}}
                    </tr>
                  {{--  @endif--}}
                @endif
                @if(!is_null($candidate->currentapplicant) && !is_null($candidate->currentapplicant->reevaluation_sl_no_marksheet_term_two) && !is_null($candidate->currentapplicant->reevaluation_term_two_result_id) )
                {{-- @if($candidate->currentapplicant->marksheetissuded_date  < $candidate->currentapplicant->reevaluation_marksheetissuded_date) --}}
                <tr>
                  <?php $sep2023 = 1; ?>
                <td>
                        Sep 2023
                     </td>
                    <td>
                        Term Two Marksheet (Reevaluated)
                    </td>
                    <td>
                        @if($candidate->currentapplicant->reevaluation_term_two_result_id == 1)
                        <span style="color:green;">Pass</span>
                        @endif
                        @if($candidate->currentapplicant->reevaluation_term_two_result_id == 0)
                        <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($candidate->currentapplicant->reevaluation_marksheetissuded_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('nber/marksheet')}}/re/{{$candidate->currentapplicant_id}}/2?v={{$candidate->new_changes}}">Download Term Two Marksheet</a>
                    </td>
                    {{-- <td>
                     <a class="hidden"  href="{{url('regenerate')}}/{{$candidate->currentapplicant_id}}/2">Regenerate</a>
                    </td> --}}
                    </tr>
                  {{-- @endif --}}
                @endif
                @if(!is_null($candidate->currentapplicant) && !is_null($candidate->currentapplicant->reevaluation_slno_certificate))
                    <tr>
                     <?php $sep2023 = 1; ?>
                    <td>
                        Sep 2023
                     </td>
                    <td>
                        Certificate  (Reevaluated)
                    </td>
                    <th><span style="color:green;">Pass</span></th>
                    <td>
                        {{\Carbon\Carbon::parse($candidate->currentapplicant->reevaluation_certificate_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('nber/certificate')}}/re/{{$candidate->currentapplicant_id}}?v={{$candidate->new_changes}}">Download Certificate</a>
                    </td>
                    <td>
                        
                    </td>
                    </tr>
                @endif
                @if(Auth::user()->id == 88387 || Auth::user()->usertype_id == 1)
               @if(!is_null($candidate->supplimentaryresults) && $candidate->supplimentaryresults->count() > 0)
                  <?php $result = $candidate->supplimentaryresults->first() ; ?>
                  @if(!is_null($result->marksheet_sl_no_first_year))
                     <tr>
                        <td>Supplementary (April 2024)</td>
                        <td>Term One Marksheet</td>
                        <td>
                           @if($result->first_year_result == 1)
                              <span style="color:green;">Pass</span>
                           @endif
                           @if(!is_null($result->first_year_result) && $result->first_year_result == 0)
                              <span style="color:red;">Fail</span>
                           @endif
                        </td>
                        <td>
                           {{\Carbon\Carbon::parse($result->marksheetissuded_date)->toFormattedDateString()}}
                        </td>
                        <td> <a href="{{url('downloadsupms')}}/{{$candidate->id}}/1">Download First Year Marksheet</a> </td>
                        {{-- @if(Auth::user()->id == 88387) --}}

                        <td>   
                            <a class="" href="{{url('generatesupp2024')}}/{{$candidate->id}}/{{$candidate->approvedprogramme->programme->numberofterms}}/0">Re-Generate</a><br>
                            <a class="" href="{{url('generatesupp2024')}}/{{$candidate->id}}/{{$candidate->approvedprogramme->programme->numberofterms}}/1">Forced Re-Generate</a>
                            
                        </td>
                        {{-- @endif  --}}
                     </tr>
                  @endif
                  @if(!is_null($result->marksheet_sl_no_second_year))
                     <tr>
                        <td>Supplementary (April 2024)</td>
                        <td>Term Two Marksheet</td>
                        <td>
                           @if($result->second_year_result == 1)
                              <span style="color:green;">Pass</span>
                           @endif
                           @if(!is_null($result->second_year_result) && $result->second_year_result == 0)
                              <span style="color:red;">Fail</span>
                           @endif
                        </td>
                        <td>
                           {{\Carbon\Carbon::parse($result->marksheetissuded_date)->toFormattedDateString()}}
                        </td>
                        <td> <a href="{{url('downloadsupms')}}/{{$candidate->id}}/2">Download Second Year Marksheet</a> </td>
                        
                        {{-- @if(Auth::user()->id == 88387) --}}
                        <td>   
                           <a class="" href="{{url('generatesupp2024')}}/{{$candidate->id}}/{{$candidate->approvedprogramme->programme->numberofterms}}/0">Re-Generate</a><br>
                                                      <a class="" href="{{url('generatesupp2024')}}/{{$candidate->id}}/{{$candidate->approvedprogramme->programme->numberofterms}}/1">Forced Re-Generate</a>

                       </td>
                       {{-- @endif --}}
                     </tr>
                  @endif
                  @if(!is_null($result->slno_certificate))
                     <tr>
                        <td>Supplementary (April 2024)</td>
                        <td>Certificate</td>
                        <td>
                           <span style="color:green;">Pass</span>
                        </td>
                        <td>
                           {{\Carbon\Carbon::parse($result->certificate_date)->toFormattedDateString()}}
                        </td>
                        <td><a href="{{url('downloadsupcert')}}/{{$candidate->id}}">Download Certificate</a></td>
                     </tr>
                  @endif
               @endif
               @if( $candidate->newresults->count() > 0)
                  <?php $result = $candidate->newresults->first() ; ?>
                  @if($result->status_id == 1)
                     @if(!is_null($result->marksheet_sl_no_first_year))
                        <tr>
                           <td>July 2024</td>
                           <td>Term One Marksheet</td>
                           <td>
                              @if($result->first_year_result == 1)
                                 <span style="color:green;">Pass</span>
                              @endif
                              @if(!is_null($result->first_year_result) && $result->first_year_result == 0)
                                 <span style="color:red;">Fail</span>
                              @endif
                           </td>
                           <td>
                              {{\Carbon\Carbon::parse($result->marksheetissuded_date)->toFormattedDateString()}}
                           </td>
                           <td> <a href="{{url('downloadjuly2024ms')}}/{{$candidate->id}}/1?v={{$result->version}}">Download First Year Marksheet</a> </td>

                           <td>   
                                 <a class="" href="{{url('generatemain2024')}}/{{$candidate->id}}/{{$candidate->approvedprogramme->programme->numberofterms}}/0">Re-Generate</a><br>
                                 <a class="" href="{{url('generatemain2024')}}/{{$candidate->id}}/{{$candidate->approvedprogramme->programme->numberofterms}}/1">Force Re-Generate</a><br>
                          </td>
                        </tr>
                     @endif
                     @if(!is_null($result->marksheet_sl_no_second_year))
                        <tr>
                           <td>June 2024</td>
                           <td>Term Two Marksheet</td>
                           <td>
                              @if($result->second_year_result == 1)
                                 <span style="color:green;">Pass</span>
                              @endif
                              @if(!is_null($result->second_year_result) && $result->second_year_result == 0)
                                 <span style="color:red;">Fail</span>
                              @endif
                           </td>
                           <td>
                              {{\Carbon\Carbon::parse($result->marksheetissuded_date)->toFormattedDateString()}}
                           </td>
                           <td> <a href="{{url('downloadjuly2024ms')}}/{{$candidate->id}}/2?v={{$result->version}}">Download Second Year Marksheet</a> </td>
                           <td>   
                                 <a class="" href="{{url('generatemain2024')}}/{{$candidate->id}}/{{$candidate->approvedprogramme->programme->numberofterms}}/0">Re-Generate</a><br>
                                                                  <a class="" href="{{url('generatemain2024')}}/{{$candidate->id}}/{{$candidate->approvedprogramme->programme->numberofterms}}/1">Force Re-Generate</a><br>

                          </td>
                        </tr>
                     @endif
                     @if(!is_null($result->slno_certificate))
                        <tr>
                           <td>June 2024</td>
                           <td>Certificate</td>
                           <td>
                              <span style="color:green;">Pass</span>
                           </td>
                           <td>
                              {{\Carbon\Carbon::parse($result->certificate_date)->toFormattedDateString()}}
                           </td>
                           <td><a href="{{url('downloadjuly2024cert')}}/{{$candidate->id}}?v={{$result->version}}">Download Certificate</a></td>
                        </tr>
                     @endif
                  @endif
               @endif
               @if(!is_null($candidate->newresultreevaluations) && $candidate->newresultreevaluations->count() > 0)
                  <?php $result = $candidate->newresultreevaluations->first() ; ?>
                  @if($result->status_id == 1 || $result->status_id == 5)
                     @if(!is_null($result->marksheet_sl_no_first_year))
                        <tr>
                           <td>June 2024</td>
                           <td>Term One Marksheet (Reevaluated)</td>
                           <td>
                              @if($result->first_year_result == 1)
                                 <span style="color:green;">Pass</span>
                              @endif
                              @if(!is_null($result->first_year_result) && $result->first_year_result == 0)
                                 <span style="color:red;">Fail</span>
                              @endif
                           </td>
                           <td>
                              {{\Carbon\Carbon::parse($result->marksheetissuded_date)->toFormattedDateString()}}
                           </td>
                           <td> <a href="{{url('downloadjuly2024msre')}}/{{$candidate->id}}/1?v={{$result->version}}">Download First Year Marksheet</a> </td>

                           <td>   
                              <a class="" href="{{url('generaterev2024')}}/{{$candidate->id}}/{{$candidate->approvedprogramme->programme->numberofterms}}/0">Re-Generate</a><br>
                              <a class="" href="{{url('generaterev2024')}}/{{$candidate->id}}/{{$candidate->approvedprogramme->programme->numberofterms}}/1">Force Re-Generate</a><br>
                          </td>                        </tr>
                     @endif
                     @if(!is_null($result->marksheet_sl_no_second_year))
                        <tr>
                           <td>June 2024</td>
                           <td>Term Two Marksheet (Reevaluated)</td>
                           <td>
                              @if($result->second_year_result == 1)
                                 <span style="color:green;">Pass</span>
                              @endif
                              @if(!is_null($result->second_year_result) && $result->second_year_result == 0)
                                 <span style="color:red;">Fail</span>
                              @endif
                           </td>
                           <td>
                              {{\Carbon\Carbon::parse($result->marksheetissuded_date)->toFormattedDateString()}}
                           </td>
                           <td> <a href="{{url('downloadjuly2024msre')}}/{{$candidate->id}}/2?v={{$result->version}}">Download Second Year Marksheet</a> </td>

                           <td>   
                              
                              <a class="" href="{{url('generaterev2024')}}/{{$candidate->id}}/{{$candidate->approvedprogramme->programme->numberofterms}}/0">Re-Generate</a><br>
                              <a class="" href="{{url('generaterev2024')}}/{{$candidate->id}}/{{$candidate->approvedprogramme->programme->numberofterms}}/1">Force Re-Generate</a><br>
                          </td>
                        </tr>
                     @endif
                     @if(!is_null($result->slno_certificate))
                        <tr>
                           <td>June 2024</td>
                           <td>Certificate (Reevaluated)</td>
                           <td>
                              <span style="color:green;">Pass</span>
                           </td>
                           <td>
                              {{\Carbon\Carbon::parse($result->certificate_date)->toFormattedDateString()}}
                           </td>
                           <td><a href="{{url('downloadjuly2024certre')}}/{{$candidate->id}}?v={{$result->version}}">Download Certificate</a></td>
                        </tr>
                     @endif
                  @endif
               @endif







<?php $after_2025_allresults = \App\Allresult::where('candidate_id', $candidate->id)->get()->groupBy('exam_id'); ?>

@foreach($after_2025_allresults as $examGroup)
    @foreach($examGroup as $result)
                @if(!is_null($result->comment) && (Auth::user()->id == 88387 || Auth::user()->id == 239776))

    <tr>
                            <td>{{ $result->comment }}</td>  

    </tr>
    @endif

        @if($result->status_id == 1 || (Auth::user()->id == 88387 && $result->status_id == 3)|| $result->status_id == 2)
            {{-- First Year Marksheet --}}
            @if(!is_null($result->marksheet_sl_no_first_year))
                <tr>
                    <td>{{ $result->exam->name ?? 'Exam' }}</td>

                    <td>Term One Marksheet</td>
                    <td>
                        @if($result->first_year_result == 1)
                            <span style="color:green;">Pass</span>
                        @elseif($result->first_year_result == 0)
                            <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($result->marksheetissuded_date)->toFormattedDateString() }}</td>
                    <td>
                        <a href="{{ url('downloadjan2025ms') }}/{{ $result->exam_id }}/{{ $candidate->id }}/1?v={{ $result->version }}">Download First Year Marksheet</a>
                        {{-- <small>{{ $result->comment }}</small> --}}
                    </td>
                        <td>
                            <a href="{{ url('generatemain2025') }}/{{ $candidate->id }}/{{ $candidate->approvedprogramme->programme->numberofterms }}/{{ $result->exam_id }}/0">Re-Generate</a><br>
                            <a href="{{ url('generatemain2025') }}/{{ $candidate->id }}/{{ $candidate->approvedprogramme->programme->numberofterms }}/{{ $result->exam_id }}/1">Force Re-Generate</a><br>
                        </td>
                </tr>
            @endif

            {{-- Second Year Marksheet --}}
            @if(!is_null($result->marksheet_sl_no_second_year))
                <tr>
                    <td>{{ $result->exam->name ?? 'Exam' }}</td>
                    <td>Term Two Marksheet</td>
                    <td>
                        @if($result->second_year_result == 1)
                            <span style="color:green;">Pass</span>
                        @elseif($result->second_year_result == 0)
                            <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($result->marksheetissuded_date)->toFormattedDateString() }}</td>
                    <td>
                        <a href="{{ url('downloadjan2025ms') }}/{{ $result->exam_id }}/{{ $candidate->id }}/2?v={{ $result->version }}">Download Second Year Marksheet</a>
                                                {{-- <small>{{ $result->comment }}</small> --}}

                    </td>
                        <td>
                            <a href="{{ url('generatemain2025') }}/{{ $candidate->id }}/{{ $candidate->approvedprogramme->programme->numberofterms }}/{{ $result->exam_id }}/0">Re-Generate</a><br>
                            <a href="{{ url('generatemain2025') }}/{{ $candidate->id }}/{{ $candidate->approvedprogramme->programme->numberofterms }}/{{ $result->exam_id }}/1">Force Re-Generate</a><br>
                        </td>
                </tr>
            @endif

            {{-- Certificate --}}
            @if(!is_null($result->slno_certificate) && is_null($result->slno_certificate_re))
                <tr>
                    <td>{{ $result->exam->name ?? 'Exam' }}</td>
                    <td>Certificate</td>
                    <td>
                        <span style="color:green;">Pass</span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($result->certificate_date)->toFormattedDateString() }}</td>
                    <td>
                        <a href="{{ url('downloadjan2025cert') }}/{{ $result->exam_id }}/{{ $candidate->id }}?v={{ $result->version }}">Download Certificate</a>
                        {{-- <small>{{ $result->comment }}</small> --}}

                    </td>
                </tr>
            @endif



              @if(!is_null($result->marksheet_sl_no_first_year_re))
                <tr>
                    <td>{{ $result->exam->name ?? 'Exam' }}</td>

                    <td>Term One Marksheet (Reevaluated)</td>
                    <td>
                        @if($result->first_year_result_re == 1)
                            <span style="color:green;">Pass</span>
                        @elseif($result->first_year_result_re == 0)
                            <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($result->marksheetissuded_date_re)->toFormattedDateString() }}</td>
                    <td>
                        <a href="{{ url('downloadjan2025ms-re') }}/{{ $result->exam_id }}/{{ $candidate->id }}/1?v={{ $result->version }}">Download First Year Marksheet</a>
                        {{-- <small>{{ $result->comment }}</small> --}}
                    </td>
                </tr>
            @endif

            {{-- Second Year Marksheet --}}
            @if(!is_null($result->marksheet_sl_no_second_year_re))
                <tr>
                    <td>{{ $result->exam->name ?? 'Exam' }}</td>
                    <td>Term Two Marksheet (Reevaluated)</td>
                    <td>
                        @if($result->second_year_result_re == 1)
                            <span style="color:green;">Pass</span>
                        @elseif($result->second_year_result_re == 0)
                            <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($result->marksheetissuded_date_re)->toFormattedDateString() }}</td>
                    <td>
                        <a href="{{ url('downloadjan2025ms-re') }}/{{ $result->exam_id }}/{{ $candidate->id }}/2?v={{ $result->version }}">Download Second Year Marksheet</a>
                                                {{-- <small>{{ $result->comment }}</small> --}}

                    </td>
                       
                </tr>
            @endif

            {{-- Certificate --}}
            @if(!is_null($result->slno_certificate_re))
                <tr>
                    <td>{{ $result->exam->name ?? 'Exam' }}</td>
                    <td>Certificate (Reevaluated)</td>
                    <td>
                        <span style="color:green;">Pass</span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($result->certificate_date_re)->toFormattedDateString() }}</td>
                    <td>
                        <a href="{{ url('downloadjan2025cert-re') }}/{{ $result->exam_id }}/{{ $candidate->id }}?v={{ $result->version }}">Download Certificate</a>
                        {{-- <small>{{ $result->comment }}</small> --}}

                    </td>
                </tr>
            @endif
        @endif
@endforeach
@endforeach

        @endif

    











            
            @if(Auth::user()->id == 88387)
               <?php $exam_id = 0; $subjecttype_id = 0;  $term = 0; $table_count = 0;  $new_table=0;?>

               @foreach($marks as $m)

               <?php $new_table++; ?>
                        @if($new_table == 1)
                        <tr class="">

               <td><small style="font-weight:100;">Exam</small> <span class="red"> {{$m->name}}</span></td>
               @if($m->exam_id==22 && !is_null($candidate->currentapplicant)   &&  $sep2023 == 0)

               <td>
                  <a class="" href="{{url('nber/marksheetregen')}}/{{$candidate->currentapplicant_id}}/{{ $candidate->approvedprogramme->programme->numberofterms }}&force=1">Generate</a>
               </td>

               @endif
               @if($m->exam_id==24 && $candidate->supplimentaryresults->count() < 1)
               <td>   
                  <a class="" href="{{url('generatesupp2024')}}/{{$candidate->id}}/{{$candidate->approvedprogramme->programme->numberofterms}}">Generate  </a>
              </td>
               @endif

               @if($m->exam_id==25 && $candidate->newresults->count() < 1)
               <td>   
                  <a class="" href="{{url('generatemain2024')}}/{{$candidate->id}}/{{$candidate->approvedprogramme->programme->numberofterms}}">Generate</a>
              </td>
              
               @endif
               @if($m->exam_id==26 && $candidate->allresults->count() < 1)
               <td>   
                  <a class="" href="{{url('generatemain2025')}}/{{$candidate->id}}/{{$candidate->approvedprogramme->programme->numberofterms}}">Generate</a>
              </td>
               @endif

            </tr>
         @endif
            
         @endforeach
         @endif

            </table>

<strong style="color: red">
  Note: Please use the “Force Regenerate” option only in case of any change in marks or discrepancy in the percentage. After clicking on regenerate, please wait for 3 working days.
</strong>
   </div>
   <div class="tab-pane" id="marks_{{$c->id}}">
         @include('nber.candidates.marks')
   </div>
   <div class="tab-pane" id="applications_{{$c->id}}" > 
 {{--  <table  class="table table-bordered ">
      <tr>
         <th>Term</th>
         <th>Subject Code</th>
         <th>Subject Name</th>
         <th>Theory/Practical</th>
         
         
      </tr>
      @foreach($c->applications as $appl)
         @if($appl->exam->status_id==1)
            <tr>
               <td>{{$appl->subject->syear}}</td>
               <td>{{$appl->subject->scode}}</td>
               <td>{{$appl->subject->sname}}</td>
               <td>{{$appl->subject->subjecttype->type}}</td>
            </tr>
         @endif
      @endforeach

   </table>
--}}
   <h4>
      {{$current_exam->name}} 
   </h4> {{--
   <br>
   Exam Center: 
   <br>
   <table  class="table table-bordered ">
      <tr>
         <th>Term</th>
         <th>Subject Code</th>
         <th>Subject Name</th>
         <th>Theory/Practical</th>
         <th>Schedule</th>
         <th>Application Status</th>
         <th>Fee</th>
         
         
      </tr>
      @if(!is_null($backlogsubjects))
         @foreach($backlogsubjects as $subject)
          @include('nber.candidates.examapplications')
         @endforeach
      @endif

      @if(!is_null($termsubjects))
         @foreach($termsubjects as $subject)
            @include('nber.candidates.examapplications')
         @endforeach
      @endif

   </table>
      --}}
      <?php $applicant = $supplimentaryapplicant; ?>

   @include('common.exam.applicant')
   </div>
      @foreach($exam_ids as $exam_id)
      <?php $exam = \App\Exam::find($exam_id) ?>
         @if($exam->status_id!=1)
            
      <div id="marks_{{$c->id}}_{{$exam->id}}" class="tab-pane">
         
         <center><h4><i class="fa fa-calendar"></i> &nbsp;{{$exam->name}}</h4 ></center>
         
   <table   class="table table-bordered  ">
      <tr>
         <th rowspan="2">Term</th>
         <th rowspan="2">Subject Code</th>
         <th rowspan="2">Subject Name</th>
         <th rowspan="2">Theory/Practical</th>
         <th colspan="4">Internal</th>
         <th  colspan="4">External</th>
         <th  rowspan="2">Result</th>
      </tr>
      <tr>
         <th>
            Max
         </th>
         <th>
            Min
         </th>
         <th>
            Score
         </th>
         <th>
            Result
         </th>
         <th>
            Max
         </th>
         <th>
            Min
         </th>
         <th>
            Score
         </th>
         <th>
            Result
         </th>
      </tr>
      <?php $imin= 0; $iscore = 0; $emin = 0; $escore = 0; $eresult = 0 ; $iresult = 0; $sresult=0; $fresult = 1;?>
      @foreach($c->applications as $appl)
         @if($appl->exam->id==$exam->id)
            @if($appl->exam->status_id!=1)
               <tr>
                  <td>{{$appl->subject->syear}}</td>
                  <td>{{$appl->subject->scode}}</td>
                  <td>{{$appl->subject->sname}}</td>
                  <td>{{$appl->subject->subjecttype->type}}</td>
                  @if($appl->mark)
                     <td>{{$appl->subject->imax_marks}}</td>
                     <?php 
                        $imin= $appl->subject->imin_marks; 
                        $iscore = $appl->mark->internal;
                        $iresult = $iscore < $imin ? 0: 1; 
                     ?>
                     <td>{{$imin}}</td>
                     <td>{{$iscore}}</td>
                     <td>
                        @if($iresult==0) F @else P @endif
                     </td>
                     <td>{{$appl->subject->emax_marks}}</td>
                     <?php 
                        $emin= $appl->subject->emin_marks; 
                        $escore = $appl->mark->external;
                        $eresult = $escore < $emin ? 0: 1; 
                        $sresult= $iresult * $eresult;
                        $fresult *= $sresult;
                     ?>
                     <td>{{$emin}}</td>
                     <td>{{$escore}}</td>
                     <td>
                        @if($eresult==0) F @else P @endif
                     </td>
                     <td>
                     @if($sresult==0) F @else P @endif
                     </td>
                  @else
                     <td></td><td></td><td></td><td></td>
                     <td></td><td></td><td></td><td></td>
                     <td></td>
                  @endif
               </tr>
            @endif
         @endif
      @endforeach
      <tr>
         <th colspan="11" style="text-align:right">
            Result
         </th>
         <th colspan="2" style="text-align:right">
            @if($fresult==0) Fail @else Pass @endif
         </th>
      </tr>
   </table>

</div>
   @endif
      @endforeach
      <div id="docs_{{$c->id}}" class="tab-pane" style="width:100%!importan;min-widtH:800px;min-heigh:1000px;">
   @if($candidate->doc_application != null)
      <h3>Application Form</h3>
      <embed src="{{asset('files/enrolment/applications/').'/'.$c->doc_application}}" frameborder="0" width="100%" height="100%" style="min-height:900px;"></embed>
   @endif
   @if($candidate->doc_tenth != null)
      <h3>10th Marksheet</h3>
      <embed src="{{asset('files/enrolment/marksheets/tenth/').'/'.$c->doc_tenth}}" frameborder="0" width="100%" height="100%" style="min-height:900px;"></embed>
   @endif
   @if($candidate->doc_twelveth != null)
      <h3>12th Marksheet</h3>
      <embed src="{{asset('files/enrolment/marksheets/twelveth/').'/'.$c->doc_twelveth}}" frameborder="0" width="100%" height="100%" style="min-height:900px;"></embed>
   @endif
   @if($candidate->doc_community != null)
      <h3>Category Certificate</h3>
      <embed src="{{asset('files/enrolment/c/').'/'.$c->doc_community}}" frameborder="0" width="100%" height="100%" style="min-height:900px;"></embed>
   @endif
   </div>

         <table class="table table-bordered tab-pane active" id="details_{{$c->id}}" style="width:100%!important;">
         	<?php $candidate = $c; ?>
            @include('common.candidates.profile')
         </table>
      </div>
        </div>
     </div>
  </div>
 
        @endsection
