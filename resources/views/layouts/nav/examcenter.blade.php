<?php $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ;?>

<div id="printPageButton" style="background:white">
    <div class="container" style="background:white">
        <div class="row">
            <div class="col-sm-12">
                <!--<img src="{{ url(asset('/images/header.png')) }}" class="img-rounded img-responsive center-block" height="60%"/> -->
                @include('layouts.nav.header')
            </div>
        </div>
    </div>

                   
    <nav class="navbar navbar-default navbar-static-top darkblue-background">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">
                    <?php 
                        $code = \App\Externalexamcenter::where('user_id',Auth::user()->id)->first()->code;
                    ?>
                    {{ $code }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/examcenter/schedule') }}">Examinations </a></li>
                    <?php $ec_id =  \App\Externalexamcenter::where('user_id',Auth::user()->id)->first()->id; ?>
                     @if(!$ec_id==1584)
               
                    <li><a href="{{ url('/examcenter/timetable') }}">Timetable </a></li>
                    <li><a href="{{ url('/examcenter/institutes') }}">Course Details </a></li>
                    @endif
                    <li style="" class="dropdown ">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Resources <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            
                            <li><a target="_blank"  href="{{ url('/files/examcenter/Scheme_Exam_2024.pdf') }}">Scheme of Examination </a></li>
                            <li><a target="_blank"  href="{{ url('/files/examcenter/CS.pdf') }}">Duties of Centre Superintendent (CS) </a></li>
                            <li><a target="_blank"  href="{{ url('/files/examcenter/CLO.pdf') }}">Duties of Central Level Observer (CLO)</a></li>
                            <li><a target="_blank"  href="{{ url('/files/examcenter/Invigilator.pdf') }}">Duties of Invigilator </a></li>
                            <li><a target="_blank" href="{{ url('/files/examcenter/Malpractice.pdf') }}">Malpractice Case Report Form </a></li>
                            <li><a target="_blank" href="{{ url('/files/examcenter/DailyReportCS-1.pdf') }}">Daily Report - CS </a></li>
                            <li><a target="_blank" href="{{ url('/files/examcenter/DailyReportCLO-1.pdf') }}">Daily Report - CLO </a></li>
                            <li><a target="_blank" href="{{ url('/files/examcenter/Demand-Letter.pdf') }}">Demand Letter</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-btn fa-user"></i>  {{ Auth::user()->username }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logoff') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                    
                </ul>

            </div>
        </div>
    </nav>
</div>