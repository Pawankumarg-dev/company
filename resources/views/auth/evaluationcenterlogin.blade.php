@extends('layouts.auth')

@section('content')
    <div class="container-fluid" style="">
        <div class="row">
            <div class="col-md-12" style="background: #003A77;">
                <center>
                    <img src="{{asset('images/nber.png')}}" />
                </center>
            </div>

            <div class="col-md-6 col-md-offset-3" style="padding-top:40px;">
                <div class="panel panel-primary" style="box-shadow: 8px 8px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                    <div class="panel-heading" style="   background: linear-gradient(#003A77, #0F77BC);"> NBER Examination Cell</div>

                    <div class="panel-body">
                        <h4 style="margin-bottom: 20px;"><i class="fa fa-sign-in" ></i>&nbsp; Sign in</h4>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home">Institute</a></li>
                            <li><a data-toggle="tab" href="#menu1">NBER</a></li>
                            {{--
                            <li><a data-toggle="tab" href="#menu2">Student</a></li>
                            <li><a data-toggle="tab" href="#menu3">CLO</a></li>
                            --}}
                        </ul>
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active" style="border: 1px solid #ddd;border-top:0;padding-bottom: 20px;">
                                <?php $ulbl = 'Institute Code'; ?>
                                @include('auth.loginform')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br />
            <br />
            <div class="col-md-12">
                <center>
                    <a href='http://www.niepmdexaminationsnber.com'>Home</a>
                </center>
            </div>
        </div>
    </div>
@endsection
