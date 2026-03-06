<br /><br />
        <div class="form-horizontal">
            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                <label for="username" class="col-md-4 control-label"  style="text-align:right;">Mobile Number</label>
              

        
                {{-- for otp --}}
                    <form class="form-horizontal" role="form" method="POST" autocomplete="off" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <div class="col-md-6">
                        <input  type="text" class="form-control number_only" name="username" id="username" onpaste="return false;" autocomplete="off" value="{{Session::get('mobile')}}">
                        <button class="btn btn-primary " style="margin-top:5px;margin-bottom:10px;" id="sendotp" disabled >Get OTP</button><br />
                        <div class="hidden" id="resend" >OTP Sent. Didn't receive? <a href="javascript:sendotp();">Resend</a> <br> </div> 
                        
                        
                        @if ($errors->has('username'))
                            <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        
                            <label for="password" class="col-md-4 control-label"  style="margin-top:5px;">OTP</label>

                        <div class="col-md-6">
                            <input id="password"  style="margin-top:5px;" type="password" onpaste="return false;" disabled class="form-control" name="password" autocomplete="off">

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

                            <img src="{{url('/')}}/captcha?tab={{ $form }}" id="captcha-{{ $form }}" alt="captcha" class="captcha">
                    
                            <button type="button" onclick="refreshCaptcha('{{ $form }}')">
                                <i class="fa fa-refresh" style="font-size: 28px;"></i>
                            </button>
                            <input id="text" type="text" autocomplete="off" onpaste="return false;" class="form-control captcha" name="captcha">
                    
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
                        </div>
                    </div>
                    </form>    
                
            </div>
        </div> 
                        

                    <script>
                        $('document').ready(function () {
                            if($('#username').val().length ==10){
                                $('#sendotp').attr('disabled',false);
                            }
                            $('.number_only').bind('keyup paste', function(){
                                    this.value = this.value.replace(/[^0-9]/g, '');
                                    if($('#username').val().length ==10){
                                        $('#sendotp').attr('disabled',false);
                                    }else{
                                        $('#sendotp').attr('disabled',true);
                                    }
                            });
                        });
                        	
                        function sendotp(){
                            username
                        if($('#username').val().length !=10){
                            swal({
                                type: 'warning',
                                title: 'Please enter your t mobile number',
                                showConfirmButton: true,
                                timer: 3500
                            });
                            $('#sendotp').attr('disabled',false);

                            return false;
                        }else{
                            $('#resend').addClass('hidden');
                            var token = $('input[name=_token]');
                            var formData = new FormData();
            				formData.append('username',$('#username').val());
                            console.log($('#username').val());
                            $.ajax({
                                url: "{{url('/direcotgenerateotp')}}",
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
                                        $('#password').removeAttr('disabled');
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