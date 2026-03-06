<div id="printPageButton"  style="background:white;">
    <div class="container" style="background:white;">
        <div class="row">
            <div class="col-sm-12 ">
               <!-- <img src="{{ url(asset('/images/header.png')) }}" class="img-rounded img-responsive center-block" height="60%"/> -->
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
                    <li><a href="{{ url('/') }}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    @if (!Auth::guest())
                    <li><form action="{{url('searchcandidates')}}" >
                            <div class="input-group" style="width:300px;margin-top:7px;margin-right: 5px;">
                                <input type="text" name='key' class="form-control" placeholder="Search with Enrolment# or Name">
                                <span class="input-group-btn">
                                                <button type="submit" class="btn btn-primary" type="button"><i class="fa fa-btn fa-search"></i></button>
                                            </span>
                            </div></form>
                    </li>
                    @endif

                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <!-- <li><a href="{{ url('/login#institute') }}" class="login" style="background-color:green;">Institute Login</a></li>
                        <li><a href="{{ url('/login#student') }}" class="login" style="background-color:orange;">Student Login</a></li> -->
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->username }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/">{{\App\Institute::where('user_id',Auth::user()->id)->first()->name}}</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</div>

    