<div id="printPageButton">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 darkblue-background">
                <!--<img src="{{ url(asset('/images/header.png')) }}" class="img-rounded img-responsive center-block" height="60%"/> -->
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
                    OEMS
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                {{--
                @if(Session::get('admin') == 1)

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Administration <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/nber/settings') }}">Settings </a></li>
                            <li><a href="{{ url('/nber/staffs') }}">Staff Accounts </a></li>
                            <li><a href="{{ url('/programmegroups/') }}">Programme Groups </a></li>
                            <li><a href="{{ url('/programmes') }}">Programmes </a></li>
                            <li><a href="{{ url('/academicyears') }}">Academic Years </a></li>
                            <li><a href="{{ url('/examcontrols') }}">Configure Batches </a></li>
                        </ul>
                    </li>
                    @endif
                    --}}
                    <li><a href="{{ url('/nber/institutes/showinstitutes') }}">Institutes </a></li>
                    <li><a href="{{ url('/nber/enrolments/candidate-data/verification-status/')}}/{{\App\Academicyear::where('current',1)->first()->id}}">Enrolments </a></li>
                    <li><a href="{{ url('/nber/exams/') }}">Exams</a></li>
                    <li><a href="{{ url('/nber/evaluations/') }}">Evaluations</a></li>
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
                    <li><a href="{{ url('/nber/tracking/documentcorrection/') }}">Correction Request Tracking</a></li>
                    
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Reports <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/enrolments/enrolmentnumber/showlists') }}/{{\App\Academicyear::where('current',1)->first()->id}}">Candidate Verification </a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    {{--<li class="dropdown">
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
                    </li>--}}
                    {{--
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
                    --}}
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
                </ul>
            </div>
        </div>
    </nav>
</div>