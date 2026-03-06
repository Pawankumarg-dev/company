<?php $title = 'NBER Dashboard' ?>

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

        .bold-text {
            font-weight: bold;
        }

        .center-text {
            text-align: center !important;
        }

        .green-text {
            color: darkgreen;
        }

        .red-text {
            color: red;
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
                    <!--
					National Board of Examination in Rehabilitation (NBER)<br/>
					(An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)<br />
					Examinations conducted by<br />
					National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)<br />
					(Dept. of Empowerment of Persons with Disabilities, Ministry of Social Justice and Empowerment,
					Govt. of India)
					-->

                    NIEPMD-NBER Examcell<br />
                    NBER Staff Dashboard
                </div>
            </div>
        </div>
    </div>
</header>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3"></div>

            <div class="col-sm-6 well well-sm white-background minus15px-margin-top">
                <table class="table table-condensed" role="table">
                    <caption class="center-text bold-text">
                        NBER Staff Information
                        <div class="text-right">
                            <a href="{{ url('/logout') }}" class="btn btn-danger">
                                Logout
                            </a>
                        </div>
                    </caption>

                    <tr>
                        <td width="20%">Name</td>
                        <td width="5%">:</td>
                        <td>{{ $nber->username }}</td>
                    </tr>
                    <tr>
                        <td>Designation</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Email ID</td>
                        <td>:</td>
                        <td>{{ $nber->email }}</td>
                    </tr>
                    <tr>
                        <td>Mobile Number 1</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Mobile Number 2</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div class="center-text">
                                <a href="{{ url('/institutes') }}" class="btn btn-success">
                                    Click here to enter the site
                                </a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-sm-3"></div>
        </div>
    </div>
</section>
<!--header-->

</body>
</html>