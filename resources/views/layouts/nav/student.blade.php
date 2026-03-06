<?php $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ;?>

<div id="printPageButton" style="background:white;">
    <div class="container" style="background:white;">
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

            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">

                    <li><a href="{{ url('/profile') }}">Profile </a></li>
                    {{-- @if  ( (Session::get('candidate')->approvedprogramme->programme_id != 57 && Session::get('candidate')->status_id !=9  && Session::get('candidate')->enrolmentno != '' &&  !is_null(Session::get('candidate')->enrolmentno     )) 
                     ||  ( Session::get('candidate')->approvedprogramme_id == 8837 && Session::get('candidate')->status_id !=9 )
                    ) --}}
@if(Session::get('candidate')->status_id !=9  && Session::get('candidate')->enrolmentno != '' &&  !is_null(Session::get('candidate')->enrolmentno) && Session::get('academicyear_id') > 9 && Session::get('academicyear_id') != 14 && Session::get('academicyear_id') != 16) 

                       {{-- <li class=""><a href="{{ url('/student/exam/applications') }}">Exam Application June 2025 </a></li> --}}

                    <li class=""><a href="{{ url('/student/exam/applications?view=examform') }}">Exam Application 2026 Supplimentry </a></li>

                    
                    @endif

                    <li><a  href="{{ url('/student/exam/applications?view=result') }}">Exam Result - June 2025 </a></li>



                    @if(Session::get('academicyear_id')< 13 || Session::get('candidate')->approvedprogramme_id == 8837)

                    {{-- <li><a  href="{{ url('/examapplication/25') }}">Annual Exam Result  June 2024 </a></li> --}}
                    {{-- <li><a href="{{ url('/reevaluation') }}">Reevaluation Result</a></li>--}}
                    <li><a href="{{ url('/marksheetsandcertificate') }}">Marksheet and Certificate </a></li>
                        @if (\App\Allapplicant::where('exam_id', 27)->where('blocked', '!=', 1)->first())
                            {{-- <li class=""><a href="{{ url('/reevaluation') }}">Reevaluation 2025</a></li> --}}
                        @endif

                        {{-- <li><a href="{{ url('/examapplication') }}">Supplementary Exam Result </a></li> --}}
                    @endif
                    
                </ul> 

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/logoff') }}">Login</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-btn fa-user"></i>  {{ Session::get('candidatename') }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i>Profile</a></li>
                                <li><a href="{{ url('/logoff') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                    
                </ul>
            </div>
        </div>
    </nav>
</div>