
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
</script>
@endsection
@section('content')
<style>
   a.disabled {
  pointer-events: none;
  cursor: default;
  color: #ccc;
}
</style>

<?php $c = $candidate; ?>
<div class="container">
<div class="row">
			<div class="col-md-12">

				<ul class="breadcrumb" style="background:transparent!important;">
					<li><a href="{{url('/enrolment')}}">Admissions</a></li>
					<li> {{$ap->programme->course_name}}  - {{$ap->academicyear->year}} </li>
					@if($candidates->count() <= $ap->maxintake)
						@if($ap->academicyear->current!=1 && \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id != 1)
							<a  class="btn btn-primary pull-right btn-bc" style="color:white;" href="{{url('candidate/create/'.$ap->id)}}">Add Candidate</a>
						@endif
						<a href="{{url('pdf')}}/{{$ap->id}}" class="btn btn-default pull-right  btn-bc" style="display:none;margin-right: 10px!important;"><i class="fa fa-print"></i> Print</a>
					@endif
				</ul>
			</div>
		</div>
		@include('common.errorandmsg')
    
      <div class="row">
      <div class="col-md-12">
         @include('common.errorandmsg')
         @if($c->is_mobile_number_verified != 'Yes')
      <div class="panel panel-danger">
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

			<button type="submit" disabled id="submit" class="btn btn-primary">Submit</button>
		</div>
</div></div>
@endif
</form>
 
      </div>
      </div>

   <?php 
      $exam_ids = array_unique($c->applications->lists('exam_id')->toArray());
   ?>
   <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#details_{{$c->id}}">Details</a></li>
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
      </div>
        </div>
     </div>
  </div>
 
        @endsection