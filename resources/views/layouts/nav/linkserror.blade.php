
<style>
        .navbar-default .navbar-nav>li>a{
            color:#fff;    
        }

        .navbar-default .navbar-nav>li>a:hover{
            color:#cfcfcf;    
        }
        .navbar-default .navbar-nav>.open>a, .navbar-default .navbar-nav>.open>a:focus, .navbar-default .navbar-nav>.open>a:hover{
            background: orange!important;
            color:#000!important;
        }
    </style>
    
@if(Auth::user())
    @if(Auth::user()->usertype_id==1)
        @include('layouts.nav.nber')
    @endif
    @if(Auth::user()->usertype_id==2)
        @include('layouts.nav.institute')
    @endif
    @if(Auth::user()->usertype_id==3)
        @include('layouts.nav.student')
    @endif
    @if(Auth::user()->usertype_id==4)
        @include('layouts.nav.clo')
    @endif
    @if(Auth::user()->usertype_id==5)
        @include('layouts.nav.rci')
    @endif
    @if(Auth::user()->usertype_id==6)
        @include('layouts.nav.examcenter')
    @endif
    @if(Auth::user()->usertype_id==7 || Auth::user()->usertype_id==8)
        @include('layouts.nav.evaluationcenter')
    @endif
    @if(Auth::user()->usertype_id==9)
        @include('layouts.nav.reports')
    @endif
@else
    @include('layouts.nav.publicerror')
@endif