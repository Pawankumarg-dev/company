@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row">
        <div class="col-md-6">
            @include('common.errorandmsg')
            <form action="{{url('confirmemail')}}">
                {!! csrf_field() !!}	
                <div class="form-group">
                    <label for="aadhar" class="control-label">
                        Please enter the OTP 
                        <br>
                        <small class="text-muted"> Please enter the OTP received in your email address. </small>
                    </label>
                    <input type="text" id="otp" name="otp" class="form-control" >
                </div>
                <button class="btn btn-xs btn-primary pull-right">Verifiy</button>
            </form>
        </div>
    </div>
</div>

@endsection