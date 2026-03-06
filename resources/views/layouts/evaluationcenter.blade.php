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
                        $name = \App\Evaluationcenter::where('user_id',Auth::user()->id)->orWhere('deuser_id',Auth::user()->id)->first()->name;
                    ?>
                    {{ $name }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li class="hidden"><a class="hidden" href="{{ url('/evaluationcenter') }}"> Home </a></li>
                    <li class="hidden"><a href="{{ url('/evaluationcenter/progress') }}"> Progress </a></li>
                    <li><a href="{{ url('/reeevaluation') }}"> Revaluation </a></li>
                    
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