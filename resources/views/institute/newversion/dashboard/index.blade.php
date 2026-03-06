<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">


    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/3.3.6/bootstrap.min.css')}}" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('packages/sweetalert/sweetalert.min.css')}}">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.4.2/css/all.css' integrity='sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns' crossorigin='anonymous'>

{{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

<!-- JavaScripts -->
    <script src="{{asset('js/2.2.3/jquery.min.js')}}" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="{{asset('js/bootstrap.min.js')}}" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="{{asset('js\chosen.jquery.min.js')}}"></script>
    {{-- <script src="{{asset('js/notify.min.js')}}"></script> --}}
    <script src="{{asset('packages/sweetalert/sweetalert.min.js')}}"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11 and Android browser -->
    <script src="{{asset('js/core.js')}}"></script>
    <link rel="stylesheet"  href="{{asset('css/style.css')}}" />

    <style>
        body {
            /*margin-top: -40px;*/
            background: #EEEEEE;
        }

        .equal-height-row {
            display: flex;
        }

        .minus15px-margin-top {
            margin-top: -15px !important;
        }

        .white-background {
            background-color: white;
            color: black;
        }

        .black-background {
            background-color: black;
            color: white;
        }

        .red-background {
            background-color: red;
            color: white;
        }

        .ghostwhite-background {
            background-color: ghostwhite;
            color: deepskyblue;
        }

        .darkblue-background {
            background-color: darkblue;
            color: white;
        }

        .grey-background {
            background: #EEEEEE;
        }

        .bold1-text {
            font-weight: bold;
        }

        .center-text{
            text-align: center !important;
        }

        .blue-text {
            color: blue;
        }

        .yellow-text {
            color: yellow;
        }

        .icon-text {
            font-size: 30px;
        }

        .footer {
            background: #3fc3ee;
            color: white;
        }

        . {
            display: flex; /* equal height of the children */
        }

    </style>
</head>

<body>

<!--header-->
<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm darkblue-background">
                <div class="center-text">
                    National Board of Examination in Rehabilitation (NBER)<br/>
                    (An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text">
                    {{$institute->user->username}} - {{$institute->name}}
                </div>
            </div>
        </div>
    </div>
</header>
<!--header-->

<section class="minus15px-margin-top">
    <div class="container-fluid">
        <div class="row equal-height-row">
            <div class="col-sm-2 well well-sm ghostwhite-background" style="width: 17% !important;">
                <ul class="list-group center-text">
                    <li class="list-group-item"><span class="glyphicon glyphicon-home"></span><br/>Center Information</li>
                    <li class="list-group-item">Courses</li>
                    <li class="list-group-item">Enrolment</li>
                    <li class="list-group-item">Candidate Information</li>
                    <li class="list-group-item">Exam Applications</li>
                    <li class="list-group-item">Online Mark Entry</li>
                    <li class="list-group-item">Class Attendance Upload</li>
                    <li class="list-group-item">Exam Timetable</li>
                    <li class="list-group-item">Hallticket Download</li>
                    <li class="list-group-item">Exam Result</li>
                    <li class="list-group-item">Re-evaluation</li>
                    <li class="list-group-item">Payment</li>
                    <li class="list-group-item">Contact NBER</li>
                    <li class="list-group-item">Logout</li>
                </ul>
            </div>

            <div class="col-sm-10 well well-sm white-background" style="width: 100% !important;">
                <p>Center Information</p>
                <p>Institute Code : {{$institute->code}}</p>
                <p>Institute Name : {{$institute->name}} </p>
                <p>Institute Address : {{$institute->address1}}
                    @if($institute->address1 != '')
                        ,
                    @endif
                    {{ $institute->address2 }}
                    @if($institute->address2 != '')
                        ,
                    @endif
                    {{ $institute->city_id }}

                    {{ $institute->pincode }}

                </p>
                <p>
                    Institute Email : {{ $institute->email }}
                </p>
            </div>
        </div>
    </div>
</section>

<!--Main layout-->
<main>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-default">
                                        <div class="center-text">
                                            <a href="{{ url('/institute/centerinformation/'.$institute->id) }}"
                                               target="_blank">
                                                <span class="glyphicon glyphicon-home icon-text"></span><br>
                                                Center Information
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-default">
                                        <div class="center-text">
                                            <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                <span class="glyphicon glyphicon-th-large icon-text"></span><br>
                                                Course Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-default">
                                        <div class="center-text">
                                            <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                <span class="glyphicon glyphicon-th icon-text"></span><br>
                                                Enrolment
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-default">
                                        <div class="center-text">
                                            <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                <span class="glyphicon glyphicon-user icon-text"></span><br>
                                                Candidate Information
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-default">
                                        <div class="center-text">
                                            <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                <span class="glyphicon glyphicon-th-list icon-text"></span><br>
                                                Exam Application
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-default">
                                        <div class="center-text">
                                            <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                <span class="glyphicon glyphicon-list-alt icon-text"></span><br>
                                                Online Mark Entry
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-default">
                                        <div class="center-text">
                                            <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                <span class="glyphicon glyphicon-user icon-text"></span><br>
                                                Class Attendance
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-default">
                                        <div class="center-text">
                                            <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                <span class="glyphicon glyphicon-calendar icon-text"></span><br>
                                                Exam Timetable
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-default">
                                        <div class="center-text">
                                            <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                <span class="glyphicon glyphicon-user icon-text"></span><br>
                                                Hall Ticket
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-default">
                                        <div class="center-text">
                                            <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                <span class="glyphicon glyphicon-user icon-text"></span><br>
                                                Result
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-default">
                                        <div class="center-text">
                                            <a href="{{ url('/institute/centerinformation/'.$institute->id) }}" style="color: deeppink">
                                                <span class="glyphicon glyphicon-user icon-text"></span><br>
                                                Re-evaluation
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-default">
                                        <div class="center-text">
                                            <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                <i class='fas fa-rupee-sign icon-text'></i><br>
                                                Payment
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body bg-default">
                                        <div class="center-text">
                                            <a href="{{ url('/institute/centerinformation/'.$institute->id) }}">
                                                <span class="glyphicon glyphicon-earphone icon-text"></span><br>
                                                Contact NBER
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="center-text">
                                            <a href="{{ url('/institute/centerinformation/'.$institute->id) }}"  style="color: red">
                                                <span class="glyphicon glyphicon-log-out icon-text"></span><br>
                                                Logout
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--Main layout-->

<!--Footer-->
<footer>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm grey-background center-text">

            </div>
        </div>
    </div>
</footer>
<!--Footer-->

</body>

</html>