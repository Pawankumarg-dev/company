<br /><br />
        <div class="form-horizontal">
            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                <label for="username" class="col-md-4 control-label" style="text-align:right;">{{$ulbl}}</label>
                @if(!Session::has('use_password') || Session::get('use_password') == '-1')
                    <form autocomplete="off" class="form-horizontal" role="form" method="POST" action="{{ url('/studentlogin') }}"  >
                    {{ csrf_field() }}
                    <div class="col-md-6">
                        <input autocomplete="off"  type="text" class="form-control num" name="mobilenu" id="mobilenu" value="{{ old('username') }}">
                        <div class="form-group">
                            
                                <button type="submit" class="btn btn-primary" style="margin-top:10px;">
                                    <i class="fa fa-btn fa-sign-in"></i> Continue
                                </button>

                                <a class="btn btn-link hidden" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            
                        </div>
                    
                        @if ($errors->has('username'))
                            <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                    </form>
                @endif

                @if(Session::has('use_password') && Session::get('use_password') == '1')
                    <form class="form-horizontal" role="form" method="POST" autocomplete="off" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <div class="col-md-6">
                        <input  type="text" class="form-control num" name="mobilenu" onpaste="return false;"  autocomplete="off" id="mobilenu" value="{{Session::get('mobile')}}" disabled>
                        <input  type="hidden" class="form-control num" name="mobilenuun" onpaste="return false;" autocomplete="off" id="mobilenunu" value="{{Session::get('mobile')}}">
                        <input  type="hidden" class="form-control num" name="username" onpaste="return false;" autocomplete="off" id="mobilenunu" value="{{Session::get('mobile')}}">
                        @if(Session::get('use_password') == '0')
                        <!-- <button class="btn btn-primary " style="margin-top:5px;margin-bottom:10px;" id="sendotp" >Get OTP</button><br />
                        <div class="hidden" id="resend" >OTP Sent. Didn't receive? <a href="javascript:sendotp();">Resend</a> <br> </div>  -->
                        @endif
                        
                        @if ($errors->has('username'))
                            <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        @if(Session::get('use_password') == '0')
                            <!-- <label for="password" class="col-md-4 control-label"  style="margin-top:5px;">OTP</label> -->
                        @endif
                        @if(Session::get('use_password') == '1')
                            <label for="password" class="col-md-4 control-label"  style="margin-top:5px;">Password</label>
                        @endif
                        

                        <div class="col-md-6">
                            <input id="password"  style="margin-top:5px;" onpaste="return false;" type="password" class="form-control" name="password" autocomplete="off">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="Captcha" class="col-md-4 control-label">Captcha</label>
                        
                            <div class="col-md-6">

                                <input type="hidden" name="tab" value="{{ $form }}">

                                <img src="{{url('/')}}/captcha?tab={{ $form }}" id="captcha-{{ $form }}" class="captcha" alt="captcha">
                        
                                <button type="button" onclick="refreshCaptcha('{{ $form }}')">
                                    <i class="fa fa-refresh" style="font-size: 28px;"></i>
                                </button>
                                <input id="text" type="text" autocomplete="off" onpaste="return false;" class="form-control"  name="captcha">
                        
                                @if ($errors->has('captcha'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('captcha') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label"></label>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary" style="margin-top:10px;">
                                <i class="fa fa-btn fa-sign-in"></i> Sign In
                            </button>
                            </form>
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/cancellogin') }}">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-secondary" style="margin-top:10px;">
                                <i class="fa fa-btn fa-sign-in"></i> Cancel
                            </button>
                            </form>
                            @if(Session::get('use_password') == '1')
                                <a style="margin-top:10px;" class="btn btn-link" href="{{ url('/password/resettootp') }}">Forgot Your Password?</a>
                            @endif
                        </div>
                    </div>                    
                @endif

                 <!-- Change Password with DOB -->
                @if(Session::has('use_password') && Session::get('use_password') == '0')
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/changepassword') }}">
                        {{ csrf_field() }}
                        <div class="col-md-6">
                            <input  type="text" class="form-control num" name="mobilenu" id="mobilenu" value="{{Session::get('mobile')}}" disabled>
                            <input  type="hidden" class="form-control num" name="mobilenuun" id="mobilenunu" value="{{Session::get('mobile')}}">
                            <input  type="hidden" class="form-control num" autocomplete="off" name="username" id="mobilenunu" value="{{Session::get('mobile')}}">
                            @if(Session::get('use_password') == '0')
                            <!-- <button class="btn btn-primary " style="margin-top:5px;margin-bottom:10px;" id="sendotp" >Get OTP</button><br />
                            <div class="hidden" id="resend" >OTP Sent. Didn't receive? <a href="javascript:sendotp();">Resend</a> <br> </div>  -->
                            @endif
                            
                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                            @if(Session::get('use_password') == '0')
                            <label for="dob" class="col-md-4 control-label"  style="margin-top:5px;">DOB</label>
                            <div class="col-md-6">
                                <input id="dob"  style="margin-top:5px;" type="date" class="form-control" name="dob" autocomplete="off" value="{{ old('dob') }}">

                                @if ($errors->has('dob'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @endif                                                                                
                        </div>                       

                        <div class="form-group{{ $errors->has('enrolmentno') ? ' has-error' : '' }}">
                            @if(Session::get('use_password') == '0')                                    
                                <label for="enrolmentno" class="col-md-4 control-label"  style="margin-top:5px;">Enrolment Number</label>
                                <div class="col-md-6">
                                <input id="enrolmentno"  style="margin-top:5px;" type="text" class="form-control" name="enrolmentno" autocomplete="off" value="{{ old('enrolmentno') }}">

                                @if ($errors->has('enrolmentno'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('enrolmentno') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @endif                                                                                                       
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            @if(Session::get('use_password') == '1')
                                <label for="password" class="col-md-4 control-label"  style="margin-top:5px;">Password</label>
                                <div class="col-md-6">
                                    <input id="password"  style="margin-top:5px;" onpaste="return false;" type="password" class="form-control" name="password" autocomplete="off">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label"></label>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" style="margin-top:10px;">
                                    <i class="fa fa-btn fa-sign-in"></i> Sign In
                                </button>
                                </form>
                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/cancellogin') }}">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-secondary" style="margin-top:10px;">
                                    <i class="fa fa-btn fa-sign-in"></i> Cancel
                                </button>
                                </form>
                                @if(Session::get('use_password') == '1')
                                    <a style="margin-top:10px;" class="btn btn-link" href="{{ url('/changepassword') }}">Forgot Your Password?</a>
                                @endif
                            </div>
                        </div>
                    </form>
                @endif                

                {{-- for otp --}}
                @if(Session::has('use_password') && Session::get('use_password') == '2')
                    <form class="form-horizontal" role="form" autocomplete="off" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <div class="col-md-6">
                        <input  type="text" class="form-control num" name="mobilenu" id="mobilenu" value="{{Session::get('mobile')}}" disabled>
                        <input  type="hidden" class="form-control num" name="mobilenuun" id="mobilenunu" value="{{Session::get('mobile')}}">
                        <input  type="hidden" class="form-control num" autocomplete="off" name="username" id="mobilenunu" value="{{Session::get('mobile')}}">
                        @if(Session::get('use_password') == '2')
                        <button class="btn btn-primary " style="margin-top:5px;margin-bottom:10px;" id="sendotp" >Get OTP</button><br />
                        <div class="hidden" id="resend" >OTP Sent. Didn't receive? <a href="javascript:sendotp();">Resend</a> <br> </div> 
                        @endif
                        
                        @if ($errors->has('username'))
                            <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        @if(Session::get('use_password') == '2')
                            <label for="password" class="col-md-4 control-label"  style="margin-top:5px;">OTP</label>
                        @endif
                        @if(Session::get('use_password') == '1')
                            <label for="password" class="col-md-4 control-label"  style="margin-top:5px;">Password</label>
                        @endif
                        

                        <div class="col-md-6">
                            <input id="password"  style="margin-top:5px;" onpaste="return false;" type="password" class="form-control" name="password" autocomplete="off">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Captcha" class="col-md-4 control-label">Captcha</label>
                    
                        <div class="col-md-6">

                            <input type="hidden" name="tab" value="{{ $form }}">

                            <img src="{{url('/')}}/captcha?tab={{ $form }}" id="captcha-{{ $form }}" class="captcha" alt="captcha">
                    
                            <button type="button" onclick="refreshCaptcha('{{ $form }}')">
                                <i class="fa fa-refresh" style="font-size: 28px;"></i>
                            </button>
                            <input id="text" type="text" autocomplete="off" class="form-control"  name="captcha">
                    
                            @if ($errors->has('captcha'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('captcha') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label"></label>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary" style="margin-top:10px;">
                                <i class="fa fa-btn fa-sign-in"></i> Sign In
                            </button>
                            </form>
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/cancellogin') }}">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-secondary" style="margin-top:10px;">
                                <i class="fa fa-btn fa-sign-in"></i> Cancel
                            </button>
                            </form>
                            @if(Session::get('use_password') == '1')
                                <a style="margin-top:10px;" class="btn btn-link" href="{{ url('/password/resettootp') }}">Forgot Your Password?</a>
                            @endif
                        </div>
                    </div>
                    </form>    
                @endif 
                
            </div>
        </div> 
                        

                    <script>
                        $('document').ready(function () {
                            
                            $('.num').on('change',function (e) {    
                                var charCode = (e.which) ? e.which : event.keyCode    
                                $('#mobilenuun').val($('#mobilenu').val());
                                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                                    return false;                        
                            }); 
                        });
                        	$('.num').keypress(function (e) {    
                                var charCode = (e.which) ? e.which : event.keyCode    
                                $('#mobilenuun').val($('#mobilenu').val());
                                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                                    return false;                        
                            }); 
                        function sendotp(){
                        $('#mobilenuun').val($('#mobilenu').val());
                        if($('#mobilenu').val().length !=10){
                            swal({
                                type: 'warning',
                                title: 'Please enter your  mobile number',
                                showConfirmButton: true,
                                timer: 3500
                            });
                            $('#sendotp').attr('disabled',false);

                            return false;
                        }else{
                            $('#resend').addClass('hidden');
                            var token = $('input[name=_token]');
                            var formData = new FormData();
            				formData.append('username',$('#mobilenu').val());
                            console.log($('#mobilenu').val());
                            $.ajax({
                                url: "{{url('/generateotp')}}",
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
                                    if(data['error']){
                                        swal({
                                            type: 'warning',
                                            title: data['error'],
                                            showConfirmButton: true,
                                            timer: 3500
                                        });
                                        $('#sendotp').attr('disabled',false);

                                    }else{
                                        $('#resend').removeClass('hidden');

                                    }
                                },
                                error: function (data) {
                                    console.log(data);
                                    if (data.status === 200) {
                                    $('#resend').removeClass('hidden');

                                    } else {

                                    }
                                }
                            });
                        }

                    }
                    $(document).ready(function () {
                        $("#sendotp").on('click',function(){
                            $(this).attr('disabled',true);
                            sendotp();
                        });
                    });

                    </script>