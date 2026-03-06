@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    <form class="form-horizontal" id="reset-password-form" method="POST" autocomplete="off" action="/password/update">
                        {{ csrf_field() }}
                        <!-- Password Field -->
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" onpaste="return false;" class="form-control" name="password" autocomplete="off">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" onpaste="return false;" autocomplete="off" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- Send OTP Button -->
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="button" id="send-otp" class="btn btn-primary">
                                    <i class="fa fa-btn fa-send"></i> Reset Password
                                </button>
                            </div>
                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('packages\jquery\jquery-3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#send-otp').on('click', function() {
            var password = $('#password').val();  
            var confirmPassword = $('#password-confirm').val();  
            
            if (password !== confirmPassword) {
                alert('Password and Confirm Password do not match.');
             $('#password').val('');   
                $('#password-confirm').val('');   
                return;
            }  
            else {
                $('#reset-password-form').submit();  // Submitting the form
            }      
        });
    });
</script>

@endsection
