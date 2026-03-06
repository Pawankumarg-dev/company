<div id="printPageButton">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 darkblue-background">
                @include('layouts.nav.header')
            </div>
        </div>
    </div>

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    NIEPMD - NBER Exam Cell
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Programmes <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/programmes') }}">Programmes </a></li>
                            <li><a href="{{ url('/programmegroups') }}">Groups </a></li>
                        </ul>
                    </li>

                    <li><a href="{{ url('/institutes') }}">Institutes </a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Applications <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/programmeapplications') }}">Institutes </a></li>
                            <li><a href="{{ url('/candidateapplications') }}">Candidates </a></li>
                            <li><a href="{{ url('/examapplications') }}">Examination </a></li>
                            <li><a href="{{ url('/attendanceapplications') }}">Attendance Exemptions </a></li>
                        </ul>
                    </li>
                    {{--
                    <li><a href="{{ url('/exams') }}">Exam</a></li>
                    --}}
                    <li><a href="{{ url('/nber/exams/') }}">Exams</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Payments <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/nber/payments/') }}">New </a></li>
                            <li><a href="{{ url('/payments') }}">Old </a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('/downloads') }}">Downloads </a></li>
                    <li><a href="{{ url('/nber/examresults/') }}">Results </a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-btn fa-search"></i>  <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li style="width:400px;">
                                <form action="{{url('search')}}" >
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input type="text" name='key' class="form-control" placeholder="Enrolment No/Name/Center Code/Name">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-primary" type="button"><i class="fa fa-btn fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>

                    <li  class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-bell-o"></i>&nbsp;&nbsp;<span class="label label-danger">{{Session::get('total')}}</span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            @if(Session::has('ap') && Session::get('ap') > 0)
                                <li><a href="{{ url('/programmeapplications?s=1') }}"><span class="label label-warning">{{Session::get('ap')}}</span> &nbsp;&nbsp;New Programme Application Verification</a></li>
                            @endif
                            @if(Session::has('c') && Session::get('c') > 0 )
                                <li><a href="{{ url('/candidateapplications?s=1') }}"><span class="label label-warning">{{Session::get('c')}}</span> &nbsp;&nbsp;New Candidate Enrolment Verification</a></li>
                            @endif
                            @if(Session::has('p') && Session::get('p') > 0 )
                                <li><a href="{{ url('/payments?s=1') }}"><span class="label label-warning">{{Session::get('p')}}</span> &nbsp;&nbsp;Payment Verification</a></li>
                            @endif
                            @if(Session::has('a') && Session::get('a') > 0 )
                                <li><a href="{{ url('/examapplications?s=1') }}"><span class="label label-warning">{{Session::get('a')}}</span> &nbsp;&nbsp;Exam Application Verification</a></li>
                            @endif
                            @if(Session::has('at') && Session::get('at') > 0 )
                                <li><a href="{{ url('/attendanceapplications?s=1') }}"><span class="label label-warning">{{Session::get('at')}}</span> &nbsp;&nbsp;Attendance Exemption Verification</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-btn fa-eye"></i> Ac.Yr: {{ \App\Academicyear::find(Session::get('academicyear_id'))->year }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            @foreach(\App\Academicyear::all()->sortByDesc('year') as $ay)
                                @if($ay->id != Session::get('academicyear_id'))
                                    <li><a href="{{ url('/changeayid/') }}/{{$ay->id}}">{{$ay->year}}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-btn fa-user"></i>  {{ Auth::user()->username }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                    <li class="dropdown">
                        <a  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-cogs"></i>  <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/settings') }}"><i class="fa fa-btn fa-globe"></i>Control Center</a></li>
                            <li><a href="{{ url('/academicyears') }}"><i class="fa fa-btn  fa-globe"></i> Academic Years</a></li>

                            <li><a href="{{ url('/examtypes') }}"><i class="fa fa-btn fa-globe"></i>Exam Types</a></li>
                            <li><a href="{{url('clos')}}"><i class="fa fa-btn fa-globe"></i>CLOs</a></li>
                            <li><a href="{{ url('/cloreportfiles') }}"><i class="fa fa-btn fa-globe"></i>CLO Report Files</a></li>
                            <li><a href="{{ url('/examattendancefiles') }}"><i class="fa fa-btn fa-globe"></i>Exam Attendance Files</a></li>
                        </ul>
                    </li>

                </ul>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/nber/examapplications/') }}">Exam Applications</a></li>
                    <li><a href="{{ url('/nber/exam-experts/') }}">Exam Experts</a></li>
                    <li><a href="{{ url('/nber/exam-centers/') }}">Exam Centers</a></li>
                    <li><a href="{{ url('/nber/baslp-exam/') }}">BASLP</a></li>
                    {{-- <li><a href="{{ url('/nber/correction-query') }}">Correction Query</a></li> --}}
                    <li><a href="{{ url('/nber/tracking/documentcorrection/') }}">Correction Request Tracking</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="container">
        <div class="row">
            <div class="center-text">
                <div class="col-sm-2 well well-sm white-background minus15px-margin-top">
                    <a href="{{ url('/nber/registrations/') }}">
                        Registrations
                    </a>
                </div>

                <div class="col-sm-2 well well-sm white-background minus15px-margin-top">
                    <a href="{{ url('/nber/examinations/') }}">
                        Examinations
                    </a>
                </div>

                <div class="col-sm-2 well well-sm white-background minus15px-margin-top">
                    <a href="{{ url('/nber/evaluations/') }}">
                        Evaluations
                    </a>
                </div>

                <div class="col-sm-2 well well-sm white-background minus15px-margin-top">
                    <a href="{{ url('/nber/provisionalcertificate/') }}">
                        Certifications
                    </a>
                </div>

                <div class="col-sm-2 well well-sm white-background minus15px-margin-top">
                    <a href="">
                        Accounts
                    </a>
                </div>

                <div class="col-sm-2 well well-sm white-background minus15px-margin-top">
                    <a href="{{ url('/nber/notifications/institute-information/show-institute-lists/') }}">
                        <span class="glyphicon glyphicon-bell"></span> Notifications
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>