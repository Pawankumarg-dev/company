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
    <link rel="stylesheet" href="{{asset('packages/bootstrap-3.3.7/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sweetalert/sweetalert.min.css')}}">
    <link rel="stylesheet"  href="{{asset('packages/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" />

{{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

<!-- JavaScripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js">
    </script>
    <script src="{{ asset('packages/moment/moment.min.js') }}"></script>
    <script src="{{asset('packages/bootstrap-3.3.7/js/bootstrap.min.js')}}"></script>

    {{-- <script src="{{asset('js/notify.min.js')}}"></script> --}}
    <script src="{{asset('packages/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Datetimepicker Bootstrap -->
    <script src="{{ asset('packages/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- ./Datetimepicker Bootstrap -->

    <script src="{{ asset('packages/bootstrap-fileinput/bootstrap.file-input.js') }}"></script>
    <link rel="stylesheet"  href="{{asset('css/style.css')}}" />
    <link rel="stylesheet"  href="{{asset('packages/bootstrap-imageupload/dist/css/bootstrap-imageupload.css')}}" />

    <script src="{{ asset('packages/bootstrap-imageupload/dist/js/bootstrap-imageupload.js') }}"></script>

    <!-- Bootstrap Toggle -->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!-- ./Bootstrap Toggle -->
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

        .minus15px-margin-top {
            margin-top: -15px !important;
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

        .bold-text {
            font-weight: bold;
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

        td, th {
            vertical-align: middle !important;
        }

        .h5-text {
            font-size: 20px !important;
            font-weight: bold !important;
        }
        .h6-text {
            font-size: 15px !important;
        }
        .h7-text {
            font-size: 12px !important;
        }
        .h8-text {
            font-size: 10px !important;
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
