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

            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">

                    <li><a href="{{ url('/rci/dashboard') }}">Dashboard </a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Master Database <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/rci/masterdb/nbers/') }}">NBERs </a></li>
                            <li><a href="{{ url('/rci/masterdb/programmegroups/') }}">Programme Group</a></li>
                            <li><a href="{{ url('/rci/masterdb/programmes/') }}">Programmes</a></li>
                            <li><a href="{{ url('/rci/masterdb/institutes/') }}">Institutes</a></li>
                            <li><a href="{{ url('/rci/masterdb/academicyears') }}">Academic Years </a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('/rci/admissions/') }}">Admissions</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Reports <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('rci/report/result') }}" >Result Publishing </a></li>
                        </ul>
                    </li>
                
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Logs <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('rci/report/logs') }}">Candidate Changes</a>
                            </li>
                            <li>
                                <a href="{{ url('rci/report/markslogs') }}">Marks </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('rci/servicedesk') }}">Service Desk</a>
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

                    @if (strpos($url,'masterdb') === false) 
                        <ul class="nav navbar-nav navbar-right darkblue-background" style="color:white;">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"  style="color:white;">
                                    <i class="fa fa-btn fa-eye"></i>
                                    Ac.Yr: {{Session::get('academicyear')}} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    @foreach(\App\Academicyear::all()->sortByDesc('year') as $ay)
                                        @if($ay->id != Session::get('academicyear_id'))
                                            <li><a href="{{ url('/rci/changeayid/') }}/{{$ay->id}}">{{$ay->year}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    @endif

            </div>
        </div>
    </nav>
</div>