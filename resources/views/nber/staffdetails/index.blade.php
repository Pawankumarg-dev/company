<?php $title = 'NBER Dashboard' ?>

        <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('packages/bootstrap-3.3.7/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sweetalert/sweetalert.min.css')}}">
    <link rel="stylesheet"  href="{{asset('packages/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('packages/font-awesome/4.5.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet"  href="{{asset('css/style.css')}}" />

    <!-- JavaScripts -->
    <script src="{{ asset('packages/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('packages/moment/moment.min.js') }}"></script>
    <script src="{{asset('packages/bootstrap-3.3.7/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('packages/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{asset('packages/sweetalert/sweetalert.min.js')}}"></script>

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
        .content-hide {
            /*visibility: hidden !important;*/
            display: none !important;
        }

        .content-show {
            /*visibility: visible;*/
            display: inline !important;
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
                    @include('layouts.nav.header')
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
                @if(!is_null($nberstaff))
                    <table class="table table-condensed table-hover" role="table">
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
                            <td class="blue-text">{{ $nberstaff->name }}</td>
                        </tr>
                        <tr>
                            <td>Designation</td>
                            <td>:</td>
                            <td class="blue-text">{{ $nberstaff->designation }}</td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td>:</td>
                            <td class="blue-text">{{ $nberstaff->gender->gender }}</td>
                        </tr>
                        <tr>
                            <td>Date of Birth</td>
                            <td>:</td>
                            <td class="blue-text">{{ $nberstaff->dob->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td>Mobile Number</td>
                            <td>:</td>
                            <td class="blue-text">{{ $nberstaff->mobile_number }}</td>
                        </tr>
                        <tr>
                            <td>Email Address</td>
                            <td>:</td>
                            <td class="blue-text">{{ $nberstaff->email_address }}</td>
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
                @else
                    @include('nber.staffdetails.create_staff_details')
                @endif
            </div>

            <div class="col-sm-3"></div>
        </div>
    </div>
</section>
<!--header-->

</body>
</html>