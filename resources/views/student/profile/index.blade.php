@extends('layouts.app')
@section('script')
<script>
   function verification(){
      if($('#is_data_verified').is(':checked')){
         $('.is_data_verified').attr('disabled',false);
      }else{
         $('.is_data_verified').attr('disabled',true);
      }
      if($('#is_data_verified').is(':checked')){
         $('.is_data_verified').attr('disabled',false);
      }else{
         $('.is_data_verified').attr('disabled',true);
      }
   }
   function resent(){
	$('#otp').val(0);
	$('#form').submit();
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
   .tab-active{
      background: white;
      padding: 20px 10px;
      border: 1px solid #ccc;
   }
   </style>
   <?php $c = $candidate; ?>
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            @include('common.errorandmsg')
            {{-- 2023 Batch --}}

            
            @if(
               ($c->is_mobile_number_verified != 'Yes' && $c->approvedprogramme->academicyear_id == 12) 
               ||($c->approvedprogramme->institute_id=='1031'&& $c->approvedprogramme->academicyear_id == 11)
               || ($c->is_mobile_number_verified != 'Yes' && !is_null(\App\Allapplicant::where('candidate_id',$c->id)->first()) )
               || ($c->is_mobile_number_verified != 'Yes' && $c->approvedprogramme->academicyear_id == 13) 

               )
               <div class="panel panel-danger" style="">
                  <div class="panel-heading">
                     Please confirm your personal details
                  </div>
                  <div class="panel-body">
                     <form action="{{url('verifystudent')}}" enctype="multipart/form-data" method="post" id="form">
                        {!! csrf_field() !!}	
                        <div class="col-md-12">
                           <span>
                              <br> 
                              <input type="radio" name="dvalidation" value="1" checked > My application data is correct.</label>
                              <br> 
                              <input type="radio" name="dvalidation" value="0" > Correction required in the data.</label>

                              <br>
                              <br>
                              If you find any mismatch, please mention the details:
                              <br><textarea id="verify_comment" style="width:400px;" name="verify_comment" value=""  > </textarea> 
                              <br/>
                              <br>
                              <input type="checkbox" onclick="javascript:verification();" id="is_data_verified" name="is_data_verified"  > I will be attending all classes physically at this institute. If it is found that my attendance was marked fraudulently, I will be liable to termination as well as legal action. 
                              <br> <br>
                           </span>
                        </div>
                        <div class="panel-footer">
                           <button type="submit"   disabled id="submit" class="btn btn-primary confirmation is_data_verified" >Submit</button>
                        </div>
                     </form>
                  </div>
               </div>
               
            @endif

            @if($c->is_email_address_verified != 'Yes' && $c->approvedprogramme->academicyear_id == 12)
            <div class="panel panel-danger" style="">
               <div class="panel-heading">
                  Please verify your email address
               </div>
               <div class="panel-body">
                  <form action="{{url('generateemailotp')}}" enctype="multipart/form-data" method="post" id="form">
                     {!! csrf_field() !!}	
                     <div class="col-md-12">
                        <div class="form-group">
                          {{$c->email}}
                        </div>
                        <div class="form-group">
                           <label  @if($c->emailotp==0) class="hidden"  @else class="form-label" @endif >
                              OTP 
                           </label>
                           <input type="text" id="otp" style="max-width: 100px;" name="otp" placeholder="" @if($c->emailotp==0) class="hidden" value="0" @else class="form-control"  @endif>
                        </div>
                     </div>

                        <button type="submit"    id="submit" class="btn btn-primary pull-right btn-xs" >
                           @if($c->emailotp == 0)
                              Get OTP
                           @else
                           
				   Verify 

                           
			   @endif
      

                        </button>
			@if($c->emailotp  != 0)
                        	<a href="javascript:resent()" class="btn btn-secondary"> Resent </a>
			@endif
                  </form>
               </div>
            </div>
            
            @endif

            @if($c->is_email_address_verified == 'Yes' && $c->is_mobile_number_verified == 'Yes' && $c->approvedprogramme->academicyear_id > 11)
               <div class="panel panel-danger hidden" style="">
                  <div class="panel-heading">
                     <b>Enrolment Fee</b>
                  </div>
                  <div class="panel-body">
                     <table class="table table-bordered">
                        <tr>
                           <th>Fee</th>
                           <th>Amount</th>
                           <th>Status</th>
                        </tr>
                        <tr>
                           <td>
                              Enrolment Fee 
                           </td>
                           <td>₹ 500</td>
                           <td>
                              @if($c->feepayment_status == 1)
                                 Paid
                              @else
                                 Pending
                                 @include('student.profile.paymentform')
                                 
                              @endif
                           </td>
                        </tr>
                     </table>
                  </div>
               </div>
            @endif
            @if($c->is_data_verified != 'Yes' && $c->approvedprogramme->academicyear_id != 11)
               <div class="panel panel-danger" style="display:none;">
                  <div class="panel-heading">
                     Please confirm your personal details
                  </div>
                  <div class="panel-body">
                     <form action="{{url('verifystudent')}}" enctype="multipart/form-data" method="post" id="form">
                        {!! csrf_field() !!}	
                        <div class="col-md-12">
                           <span>
                              <br> 
                              <input type="radio" name="dvalidation" value="1" checked > My application data is correct.</label>
                              <br> 
                              <input type="radio" name="dvalidation" value="0" > Correction required in the data.</label>

                              <br>
                              <br>
                              If you find any mismatch, please mention the details:
                              <br><textarea id="verify_comment" style="width:400px;" name="verify_comment" value=""  > </textarea> 
                              <br/>
                              <br>
                              <input type="checkbox" onclick="javascript:verification();" id="is_data_verified" name="is_data_verified"  > I confirm the data given below 
                              <br> <br>
                           </span>
                        </div>
                        <div class="panel-footer">
                           <button type="submit"   disabled id="submit" class="btn btn-primary confirmation is_data_verified">Submit</button>
                        </div>
                     </form>
                  </div>
               </div>
            @endif
            <table class="table table-bordered tab-pane active" id="details_{{$c->id}}" style="width:100%!important;">
               <?php $candidate = $c; ?>
               @include('common.candidates.profile')
            </table>
         </div>
      </div>
   </div>
@endsection
