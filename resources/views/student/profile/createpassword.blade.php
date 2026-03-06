@extends('layouts.app')
@section('script')
<script>
   function verification(){
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

            <form class="form-horizontal" role="form" method="POST"  autocomplete="off" action="{{ url('/student/createpassword') }}">
               {{ csrf_field() }}
               <div class="col-md-6">
                  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                     <h4>Create New Password </h4>
                     @include('common.errorandmsg')
                     <input  type="password" onpaste="return false;" minlength="6" class="form-control num" autocomplete="off" name="password" id="password" placeholder="New Password" >
                     <input  type="password" onpaste="return false;" minlenght="6" class="form-control num" autocomplete="off" name="password_confirmation" id="confirmpassword" style="margin-top:10px;" placeholder="Confirm Password" >
                     <button class="btn btn-primary " style="margin-top:5px;margin-bottom:10px;" id="save" >Save</button>
                  </div>
               </div>
         </div>
      </div>
   </div>
@endsection