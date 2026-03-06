<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">




    <title>National Board of Examination in Rehabilitation(NBER)</title>

    <!-- Fonts -->

{{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700"> --}}

<!-- Styles -->
    <link rel="stylesheet" href="{{asset('packages/bootstrap-3.3.7/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sweetalert/sweetalert.min.css')}}">
    <link rel="stylesheet"  href="{{asset('packages/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" />
    <link rel="stylesheet"  href="{{asset('css/style.css')}}" />
    <link rel="stylesheet" href="{{ asset('packages/font-awesome/4.5.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet"  href="{{asset('packages/bootstrap-imageupload/dist/css/bootstrap-imageupload.css')}}" />
    <link href="{{('/css/select2.min.css')}}" rel="stylesheet" />
{{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

<!-- JavaScripts -->
    <script src="{{ asset('packages/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('packages/moment/moment.min.js') }}"></script>
    <script src="{{asset('packages/bootstrap-3.3.7/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('packages/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{asset('packages/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{ asset('packages/bootstrap-fileinput/bootstrap.file-input.js') }}"></script>
    <script src="{{ asset('packages/bootstrap-imageupload/dist/js/bootstrap-imageupload.js') }}"></script>
    <script src="{{ asset('packages/tableexport/tableExport.js') }}"></script>
    <script src="{{ url('/js/select2.min.js') }}"></script>
    @yield('style')
    <style>
        body {
            /*margin-top: -40px;*/
            background: #EEEEEE;
        }

        .custom-pageheader {
            background: #EEEEEE;
        }

        .lucida-text {
            font-family: "Lucida Calligraphy";
        }
        .adobe {
            font-family: "Adobe Caslon Pro";
        }
        .yu {
            font-family: "Yu Gothic Light";
        }
        .arial-text {
            font-family: "Arial";
        }
        .courier-text {
            font-family: "Courier New";
        }

        .table-borderless > tbody > tr > td,
        .table-borderless > tbody > tr > th,
        .table-borderless > tfoot > tr > td,
        .table-borderless > tfoot > tr > th,
        .table-borderless > thead > tr > td,
        .table-borderless > thead > tr > th {
            border: none !important;
        }
        .table{
            background-color: #fff;
        }
        #printPageButton{
            background:white!important;
        }
        @media print {
            #printPageButton {
                display: none;
            }
            #printPage {
                size: A4 landscape;
            }
            .hidethis {
                display: none;
            }
            .hidelink:after {
                content: none !important;
            }
            a[href]:after {
                content: none !important;
            }
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
            background-color: red !important;
            color: white !important;
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
            color: darkorange !important;
        }

        .green-text {
            color: darkgreen !important;
        }

        .red-text {
            color: red !important;
        }

        .blue-text {
            color: blue !important;
        }

        .brown-text {
            color: brown !important;
        }

        .yellow-text {
            color: yellow !important;
        }

        .black-text {
            color: black !important;
        }

        .icon-text {
            font-size: 30px;
        }

        .large-text {
            font-size: large;
        }

        .footer {
            background: #3fc3ee;
            color: white;
        }

        td, th {
            vertical-align: middle !important;
        }

        . {
            display: flex; /* equal height of the children */
        }
        .page-break {
            page-break-after: always;
        }

        .h4-text {
            font-size: 25px;
            font-weight: bold;
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

        .medium-text {
            font-size: medium;
        }

        .justified-text {
            text-align: justify;
            text-justify: inter-word;
        }

        .red-button {
            background-color: red !important;
            color: white !important;
        }

        .red-button:focus,
        .red-button:hover {
            background-color: indianred !important;
            border-color: indianred !important;
            color: white !important;
        }

        .breadcrumb {
            padding: 10px !important;
            background-color: cornsilk;
        }
        .breadcrumb a, .breadcrumb > .heading, .breadcrumb > .active{
            font-size: medium;
            color: blue;
        }
        .breadcrumb > .active{
            font-weight: bold;
            color: red;
        }
        .breadcrumb > li + li:before {
            content: "\00BB";
            color: blue;
            font-size: large;
        }
        .uppercase-text {
            text-transform: uppercase !important;
        }
        .notfound{
            display: none;
        }
        .table-condensed .progress {
            margin-bottom: 0 !important;
        }
        .wrimagecard{
            margin-top: 0;
            margin-bottom: 1.5rem;
            text-align: left;
            position: relative;
            background: #fff;
            box-shadow: 12px 15px 20px 0px rgba(46,61,73,0.15);
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        .wrimagecard .fa{
            position: relative;
            font-size: 70px;
        }
        .wrimagecard-topimage_header{
            padding: 20px;
        }
        a.wrimagecard:hover, .wrimagecard-topimage:hover {
            box-shadow: 2px 4px 8px 0px rgba(46,61,73,0.2);
        }
        .wrimagecard-topimage a {
            width: 100%;
            height: auto;
            display: block;
        }
        .wrimagecard-topimage_title {
            padding: 10px 10px;
            height: 80px;
            padding-bottom: 0.75rem !important;
            position: relative;
        }
        .wrimagecard-topimage a {
            border-bottom: none;
            text-decoration: none;
            color: #525c65;
            transition: color 0.3s ease;
        }

        .custom-link:hover, .custom-link:visited, .custom-link:link, .custom-link:active
        {
            text-decoration: none;
        }

        .content-hide {
            /*visibility: hidden !important;*/
            display: none !important;
        }

        .content-show {
            /*visibility: visible;*/
            display: inline !important;
        }

        .loader {
            margin: auto !important;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid blue;
            border-right: 16px solid green;
            border-bottom: 16px solid red;
            border-left: 16px solid pink;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .center-div {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body id="app-layout">
@include('layouts.nav.links')
@yield('content')
@yield('script')

</body>
</html>
