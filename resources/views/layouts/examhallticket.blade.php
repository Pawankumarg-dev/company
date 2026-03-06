<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>

{{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700"> --}}

<!-- Styles -->
    <link rel="stylesheet" href="{{asset('packages/bootstrap-3.3.7/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sweetalert/sweetalert.min.css')}}">
    <link rel="stylesheet"  href="{{asset('packages/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" />
    <link rel="stylesheet"  href="{{asset('css/style.css')}}" />
    <link rel="stylesheet" href="{{ asset('packages/font-awesome/4.5.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet"  href="{{asset('packages/bootstrap-imageupload/dist/css/bootstrap-imageupload.css')}}" />

    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <script src="{{ asset('packages/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('packages/moment/moment.min.js') }}"></script>
    <script src="{{asset('packages/bootstrap-3.3.7/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('packages/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{asset('packages/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{ asset('packages/bootstrap-fileinput/bootstrap.file-input.js') }}"></script>
    <script src="{{ asset('packages/bootstrap-imageupload/dist/js/bootstrap-imageupload.js') }}"></script>
    @yield('style')
    <style>
        body {
            margin-top: 10px;
            background: #EEEEEE;
        }
        @media print {
            #printPageButton {
                display: none;
            }
            .noprint {
                display:none;
            }
            a[href]:after {
                display: none;
                visibility: hidden;
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

        .orange-text {
            color: darkorange;
        }
        .green-text {
            color: darkgreen;
        }
        .red-text {
            color: red !important;
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
        .notfound{
            display: none;
        }
    </style>
</head>
<body id="app-layout">

@yield('content')
@yield('script')

</body>
</html>
