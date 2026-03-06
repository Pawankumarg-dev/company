<br /><br />
<form class="form-horizontal form_{{$form}}"  autocomplete="off" role="form" method="POST" action="{{ url('/login') }}" >
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">{{$ulbl}}</label>

                            <div class="col-md-6">
                                <input id="text" type="username" autocomplete="off"  class="form-control"  name="username" value="{{ old('username') }}">

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            @if($otpauth == true)
                            <label for="password" class="col-md-4 control-label">OTP</label>
                            @else
                            <label for="password" class="col-md-4 control-label">Password</label>
                            @endif

                            <div class="col-md-6">
                                <input id="password" type="password"  class="form-control" name="password" autocomplete="off">

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
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" autocomplete="off"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary submit submit_{{$form}}">
                                    <i class="fa fa-btn fa-sign-in"></i> Sign In
                                </button>
                                <a class="btn btn-link hidden" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            </div>
                        </div>
                    </form>
              

                    