<!DOCTYPE html>
<html lang="en">
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
    @yield('style')
    <style>
        body {
            /*margin-top: -40px;*/
            background: #EEEEEE;
        }
        @media print {
            #printPageButton {
                display: none;
            }
        }

        .page-break {
            page-break-after: always;
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

        .green-background {
            background: green !important;
            color: white !important;
        }

        .brown-text {
            color: brown;
        }

        .grey-background {
            background: #EEEEEE;
        }

        .center-text {
            text-align: center !important;
        }

        .left-text {
            text-align: left !important;
        }

        .right-text {
            text-align: right !important;
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


        .h5-text {
            font-size: 20px;
            font-weight: bold;
        }
        .h6-text {
            font-size: 15px;
        }
        .h7-text {
            font-size: 12px;
        }
        .h8-text {
            font-size: 10px;
        }
        .left-text{
            text-align: left !important;
        }
        .right-text{
            text-align: right !important;
        }
        .center-text{
            text-align: center !important;
        }
        .courier_new_font{
            font-family: "Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace;
        }
    </style>
</head>
<body id="app-layout">


@yield('content')
@yield('script')

</body>
</html>
