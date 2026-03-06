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
                <?php 
                        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
                    ?>
                @if(Auth::user()->id == 88387 || Auth::user()->id == 239776)
                    <a href="#" class="dropdown-toggle navbar-brand" data-toggle="dropdown" role="button" aria-expanded="false"  style="color:white;">
                        {{ \App\Nber::find($nber_id)->name_code }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        @foreach(\App\Nber::all() as $nber)
                            <li>
                                <a href="{{url('changenber')}}/{{$nber->id}}">{{$nber->name_code}}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ \App\Nber::find($nber_id)->name_code }}
                    </a>
                @endif
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">

                    @if(Session::get('admin') == 1)
                  {{--  <li><a href="{{ url('/nber/staffs') }}">Users </a></li> --}}
                    @endif

                   
                    
                    <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"  style="color:white;">
                                    Admissions <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{url('/nber/admissions')}}">Admissions</a>
                                    </li>
                                    <li><a href="{{ url('/nber/institutes') }}">Institutes</a></li>
                                    <li><a href="{{ url('/nber/programmes') }}">Programmes</a></li>
                                    <li>
                                        <a href="{{url('institute/enrolmentfees')}}">Enrolment Fee</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"  style="color:white;">
                                    
                                    Exam <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                
                                <li>
                                        @if(Auth::user()->id == 88387)
                                        <a href="{{url('nber/exam/examcenter')}}">Exam Centers</a>
                                        @endif
                                    </li>
                                    <li>
                                        <a href="{{url('nber/exam/schedules')}}"> Schedule</a>
                                    </li>
                                    <li>
                                        <a href="{{url('nber/exam/timetable')}}"> Timetable</a>
                                    </li>
                                    <li>
                                        <a href="{{url('nber/exam/applicants')}}"> Applications</a>
                                    </li>
                                    <li>
                                        <a href="{{url('nber/exam/applicantsummary')}}"> Application Summary</a>
                                    </li>
                                    <li><a href="{{ url('/nber/examattendance') }}">Exam Attendance Tracker</a></li> 
                                    <li><a href="{{ url('/nber/exam/evaluationtracking') }}">Exam Evaluation Tracker</a></li> 
                                    <li>
                                        <a href="{{url('nber/geotaggedphotos')}}">Practical Exam Progress</a>
                                    </li>
                                    <li>
                                        <a href="{{url('nber/internalmarkentry')}}">Internal Mark Entry</a>
                                    </li>
                                    <li>
                                        <a href="{{url('nber/exam/evaluationcenter')}}">Evaluation Centers</a>
                                    </li>
                                       <li><a href="{{ url('/nber/markentry') }}">Marks</a></li> 
                                       <li><a href="{{ url('/nber/publishresult') }}">Missing Results</a></li> 
                                       {{--
                                       <li><a href="{{ url('/nber/publishresult?attendance=1') }}">Missing Classroom attendance</a></li>  --}}
                                       
                                       <li><a href="{{ url('nber/examresult/institutewise') }}">Institutewise Results</a></li> 

                                    
                                       <li><a href="{{ url('/nber/exams/reevaluation') }}">Reevaluation Applications</a></li> 

                                        <li><a href="{{ url('nber/reevaluation/stats') }}">Reevaluation Reports</a></li> 
                                        <li><a href="{{ url('/nber/eligiblecandidates/supplementary') }}">Supplementary January 2025</a></li> 
                                        @if(Auth::user()->id == 88387)
                                        <li>
                                            <a href="{{url('nber/answerbooklets')}}">Answerbooklet scan</a>
                                        </li>
                               
                                        @endif
                                        <li>
                                            <a href="{{url('nber/practicalexaminer')}}">Practical Examiner Mapping</a>

                                            
                                        </li>
                                        
                                        
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"  style="color:white;">
                                    
                                    Verify <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                
                                    <li>
                                        <a href="{{url('/nber/verify/examcenters')}}">Exam center consent forms</a>
                                    </li>
                                    <li>
                                        <a class='' href="{{url('/nber/verify/facultydetails')}}">Faculties</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/nber/verify/facultyresp') }}">Facultie's Willingness for June 2025 exam</a>
                                    </li>
                                    <li>
                                        <a class="" href="{{url('/nber/verify/gpscoorinates')}}">GPS Coordinates & Geo Tag Photo</a>
                                    </li>
                                    <li>
                                        <a class="" href="{{url('/nber/verify/scholershipportalregno')}}">Scholership Portal Registration Number</a>
                                    </li>

                                    {{-- <li class="">
                                        <a class="" href="{{url('/nber/exam/verifyattnninternal')}}">Verify Attendance/Internal Marks</a>
                                    </li> --}}
                                    <li class="">
                                        <a class="" href="{{url('/nber/exam/verifyattnn-internal')}}">Internal Attendance</a>
                                    </li>

                                    <li class="">
                                        <a class="" href="{{url('/nber/internal-marksheet')}}">Verify Attendance/Internal Marks</a>
                                    </li>


                                    
                                    <li class="">
                                        <a class="" href="{{url('/marks-verification-course')}}">Verify External Marks</a>
                                    </li>
                                     <li>
                                            <a href="{{url('/reevaluationcenter/verify-marks')}}">Verify Reevaluation Marks</a>

                                            
                                        </li>
                                      <li>
                                            <a href="{{url('/nber/update-marks')}}" class="">Marks Updation Request</a>

                                            
                                        </li>



                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"  style="color:white;">
                                    
                                    Evaluation <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                
                                    <li>
                                        <a href="{{url('nber/evaluation')}}">Summary</a>
                                    </li>
                                    <li>
                                        <a class='' href="{{url('nber/evaluationprogress')}}">Progress</a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"  style="color:white;">
                                    
                                    Other <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                
                                <li><a href="{{ url('/nber/dashboard') }}">Dashboard </a></li>
                    
                                <li><a href="{{ url('/issues/') }}">Grievances</a></li>     
                                <li><a href="{{ url('/nber/excenter/') }}">Exam Centers</a></li>     
                                <li><a href="{{ url('/nber/evaluationcenter/') }}">Evaluation Centers</a></li>     
                                <li><a href="{{ url('/nber/examcenter/zone') }}">Zone</a></li>     
                                <li><a href="{{ url('/nber/paymentreports?type=enrolment') }}">Enrolment Payments</a></li>     
                                <li><a href="{{ url('/nber/paymentreports?type=exam') }}">Exam Payments</a></li>     
                                <li><a href="{{ url('/nber/paymentreports?type=reevaluation') }}">Revaluation Payments</a></li>  
                                <li><a href="{{ url('/nber/faculties') }}">Faculties </a></li>   
                                <li><a href="{{ url('/nber/clo') }}">Clo Report & Payment </a></li>   
                                {{-- <li><a href="{{ url('/nber/evaluators') }}">Evalutors</a></li>    --}}
                                <li><a class="hidden" href="{{ url('/nber/tabill') }}">TABILL</a></li>   
                                <li><a class="hidden" href="{{ url('/nber/track-payment') }}">Track Candidate Payment</a></li>   
    @if(Auth::user()->id==88387)

                                <li><a href="{{ url('/nber/index') }}"> Notice </a></li>
                                 <li><a href="{{ url('/nber/nber-dashboard') }}">Nber Dashboard</a></li>   
    @endif

                                
                                </ul>
                            </li>   
                            <li>
                            <form action="{{url('nber/candidate/search')}}" method="get" class="float-right" style="margin-top:10px;width:300px;">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" name="enrolmentno" class="form-control" style="height:30px;" @if(!empty($candidate)) value="{{$candidate->enrolmentno}}" @endif placeholder="Enrolment No or Name or Institute Code">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> Search </button>
                        </span>
                    </div>
                </form>
                            </li>
                    
                    
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/logoff') }}">Login</a></li>
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

                    @if(strpos($url,'nber/markentry') == true || strpos($url,'nber/exam') == true || strpos($url,'/nber/internal-marksheet') == true)

                        <ul class="nav navbar-nav navbar-right darkblue-background" style="color:white;">
                            <li class="dropdown">
                                <a href="#" style="background:orange!important;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"  style="color:white;">
                                    <i class="fa fa-btn fa-eye"></i>
                                    Exam: {{Session::get('examname')}} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    @foreach(\App\Exam::where('id', '>','18')->get() as $ey)
                                        @if($ey->id != Session::get('exam_id'))
                                            <li><a href="{{ url('/nber/changeeyid/') }}/{{$ey->id}}">{{$ey->name}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>

                    @endif


                    @if (strpos($url,'nber/dashboard') == true || strpos($url,'nber/admissions') == true ) 
                        <ul class="nav navbar-nav navbar-right darkblue-background" style="color:white;">
                            <li class="dropdown">
                                <a href="#" style="background:orange!important;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"  style="color:white;">
                                    <i class="fa fa-btn fa-eye"></i>
                                    Ac.Yr: {{Session::get('academicyear')}} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    @foreach(\App\Academicyear::all()->sortByDesc('year') as $ay)
                                        @if($ay->id != Session::get('academicyear_id'))
                                            <li><a href="{{ url('/nber/changeayid/') }}/{{$ay->id}}">{{$ay->year}}</a></li>
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