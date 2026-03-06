
@extends('layouts.app')
@section('script')
<script>
   function verification(){
      console.log($('input[name="dvalidation"]').val());
      if($('#is_mobile_number_verified').is(':checked')){
         $('.is_mobile_number_verified').attr('disabled',false);
      }else{
         $('.is_mobile_number_verified').attr('disabled',true);
      }
      if($('#is_data_verified').is(':checked')){
         $('.is_data_verified').attr('disabled',false);
      }else{
         $('.is_data_verified').attr('disabled',true);
      }
   }
   $('#declare').on('click',function(){
      if($('#declare')[0].checked){
         $('#pay').prop('disabled',false);
      }else{
         $('#pay').prop('disabled',true);
      }
   });
   $('#showpayment').on('click',function(){
      var reevaluation =  $('.reevaluation:checked').length;
      var retotal =  $('.retotal:checked').length;
      var photocopy =  $('.photocopy:checked').length;
      $('#reevaluation_count').html(reevaluation);
      $('#retotalling_count').html(retotal);
      $('#photocopy_count').html(photocopy);
      var reevaluationfee = reevaluation * {{$reevaluationfee->reevaluation_fee}};
      var retotalfee = retotal * {{$reevaluationfee->retotalling_fee}};
      var photocopyfee = photocopy * {{$reevaluationfee->photocopying_fee}};
      let INR = new Intl.NumberFormat('en-US', {
         style: 'currency',
         currency: 'INR',
      });
      $('#reevaluation_fee').html(INR.format(reevaluationfee));
      $('#retotalling_fee').html(INR.format(retotalfee));
      $('#photocopy_fee').html(INR.format(photocopyfee));
      var totalfee = reevaluationfee+retotalfee+photocopyfee;
      $('#total_fee').html(INR.format(totalfee));
      $('#amount').val(totalfee);
      if(totalfee>0){
         $('#declare').prop('checked', false);
         $('#pay').prop('disabled',true);
         $('#myModal').modal('show');
      }else{
         swal({
            type: 'warning',
            title: 'Please choose the papers',
            showConfirmButton: false,
            timer: 1500
         });
      }
      return false;
   });
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
         @if($c->is_mobile_number_verified != 'Yes' && $c->approvedprogramme->academicyear_id == 11)
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
                           <input type="checkbox" onclick="javascript:verification();" id="is_mobile_number_verified" name="is_mobile_number_verified"  > I will be attending all classes physically at this institute. If it is found that my attendance was marked fraudulently, I will be liable to termination as well as legal action. 
                           <br> <br>
                        </span>
                     </div>
                     <div class="panel-footer">
                        <button type="submit"   disabled id="submit" class="btn btn-primary confirmation is_mobile_number_verified" >Submit</button>
                     </div>
                  </form>
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
         <div class="panel panel-success">
               <div class="panel-heading">
                  Marksheets and Certificate
               </div>
               <div class="panel-body">
                  <?php $gen = 0; ?>
               @if(!is_null($c->currentapplicant))
               @if(!is_null($c->currentapplicant->sl_no_marksheet_term_one) && !is_null($c->currentapplicant->term_one_result_id) && $c->currentapplicant->first_year_pappers > 0)
                    <li>
                    <a href="{{url('student/marksheet')}}/{{$c->currentapplicant_id}}/1?v={{$c->new_changes}}">Download Term One Marksheet</a>
                    <?php $gen = 1; ?>
                    </li>
                @endif
                @endif
                @if(!is_null($c->currentapplicant))
                @if(!is_null($c->currentapplicant->sl_no_marksheet_term_two) && !is_null($c->currentapplicant->term_two_result_id))
                    <li>
                    <a href="{{url('student/marksheet')}}/{{$c->currentapplicant_id}}/2?v={{$c->new_changes}}">Download Term Two Marksheet</a>
                    </li>
                    <?php $gen = 1; ?>
                @endif
                @endif
                @if(!is_null($c->currentapplicant))
                @if(!is_null($c->currentapplicant->slno_certificate) && $c->currentapplicant->final_result == 1)
                    <li>
                    <a href="{{url('student/certificate')}}/{{$c->currentapplicant_id}}?v={{$c->new_changes}}">Download Certificate</a>
                    </li>
                    <?php $gen = 1; ?>
                @endif
                @endif
                @if($gen == 0)
                  Could not find the marksheet or certificate.
                @endif
               </div>
            </div>
      </div>
   </div>
   <?php 
      $exam_ids = array_unique($c->applications->lists('exam_id')->toArray());
   ?>
   <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#details_{{$c->id}}">Profile</a></li>
      @if($c->status_id!=4)
      <li><a href="#applications_{{$c->id}}" class="disabled"  data-toggle="tab" >Exam Applications</a></li>
      @endif

      <li class="dropdown">
    <a class="dropdown-toggle disabled" data-toggle="dropdown" href="#">Marks
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
      <?php $count = 0 ; ?>
      @foreach($exam_ids as $exam_id)
      <?php $exam = \App\Exam::find($exam_id) ?>
         @if($exam->status_id!=1)
            <li><a data-toggle="tab" href="#marks_{{$c->id}}_{{$exam->id}}">{{$exam->name}}</a></li>         
            <?php $count += 1; ?>
         @endif
      @endforeach
      @if($count==0)
         <li> <a href="#">NA</a> </li>
      @endif
    </ul>
  </li>

  <li><a href="#reevaluation_{{$c->id}}"   data-toggle="tab" @if($candidate->id != 122630 ) style="display:none;" @endif >Re-evaluation</a></li>
      
   </ul>
   <div class="tab-content">

   <table  id="applications_{{$c->id}}" class="table table-bordered  tab-pane">
      <tr>
         <th>Exam</th>
         <th>Subject Code</th>
         <th>Subject Name</th>
         <th>Theory/Practical</th>
         
         
      </tr>
      @foreach($c->applications as $appl)
         @if($appl->exam->status_id==1)
            <tr>
               <td>{{$appl->exam->name}}</td>
               <td>{{$appl->subject->scode}}</td>
               <td>{{$appl->subject->sname}}</td>
               <td>{{$appl->subject->subjecttype->type}}</td>
            </tr>
         @endif
      @endforeach
   </table>


      @foreach($exam_ids as $exam_id)
      <?php $exam = \App\Exam::find($exam_id) ?>
         @if($exam->status_id!=1)
            
      <div id="marks_{{$c->id}}_{{$exam->id}}" class="tab-pane">
         
         <center><h4><i class="fa fa-calendar"></i> &nbsp;{{$exam->name}}</h4 ></center>
         
   <table   class="table table-bordered  ">
      <tr>
         
         <th>Subject Code</th>
         <th>Subject Name</th>
         <th>Theory/Practical</th>
         <th>Internal</th>
         <th>External</th>
         <th>Result</th>
      </tr>
      @foreach($c->applications as $appl)
         @if($appl->exam->id==$exam->id)
            @if($appl->exam->status_id!=1)
               <tr>
         
                  <td>{{$appl->subject->scode}}</td>
                  <td>{{$appl->subject->sname}}</td>
                  <td>{{$appl->subject->subjecttype->type}}</td>
                  @if($appl->mark)
                     <td>{{$appl->mark->internal}}</td>
                     <td>{{$appl->mark->external}}</td>
                     <td>{{$appl->mark->result()}}</td>
                  @else
                     <td></td><td></td><td></td>
                  @endif
               </tr>
            @endif
         @endif
      @endforeach
   </table>
</div>
   @endif
      @endforeach
      
         <table class="table table-bordered tab-pane active" id="details_{{$c->id}}" style="width:100%!important;">
         	<?php $candidate = $c; ?>
            @include('common.candidates.profile')
         </table>
         <div id="reevaluation_{{$c->id}}" class=" tab-pane tab-active" style="min-height:180px;">
            @include('student.reevaluation.index')
         </div>
        </div>
     </div>
   </div>
   
    
 
@endsection