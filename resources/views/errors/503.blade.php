<!DOCTYPE html>
<html>
<head>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <title>Website Maintenance</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">


    <!-- Styles -->

    E:\xampp\htdocs\rcinber\public\css\3.3.6\bootstrap.min.css
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
        html, body {
            height: 100%;
        }

        body {
            background-color: #EEEEEE;
        }

        /*
         body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 200;
            font-family: 'Lato';
            background-color: #EEEEEE;

        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {

            font-size: 50px;
            margin-bottom: 40px;
        }
        */

        .panel {
            margin-top: 50px !important;
        }

        .equal-div {
            display: flex;
        }

        .red-text {
            color: red;
        }

        .blue-text {
            color: #003A77;
        }

        .bold-text {
            font-weight: bolder !important;
        }
    </style>
</head>
<body>
{{--
<div class="container">
    <div class="content">

        <div class="title">Updating Software...<br />Be right back.</div>


            <div class="title">
                The website that you are looking is under maintenance.....<br />
                Sorry for the inconvience caused.....<br />
                We'll be back online shortly.....<br />
            </div>
        </div>
    </div>
    --}}

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="equal-div">
                        <div class="col-sm-4">
                            <img src="{{asset('/images/maintenance.jpg')}}" class="img" style="height: 75%"/>
                        </div>

                        <div class="col-sm-8">
                           <br />
                            <p>
                            <h1 class="red-text">Website under Maintenance</h1>
                            <hr />
                            </p>

                            <h4 class="blue-text">

NBER-RCI portal i.e. https://rciber.org.in is initiating the process of migration to NIC server.  The portal will not be operational from 20-07-2024 (Saturday) 9.00 AM to 21-07-2024 (Sunday) 12.00 Noon. Inconvenience caused regretted.                   
	 </h4>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
