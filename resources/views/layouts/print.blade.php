<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="{{asset('css/normalize.min.css')}}">

    <!-- Load paper.css for happy printing -->
    <!--
    <link rel="stylesheet" href="{{asset('css/paper.css')}}">
    -->

    <link rel="stylesheet" href="{{ asset('/css/paper.css') }}">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
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
        .monotype-text {
            font-family: "Monotype Corsiva";
        }

        .table-borderless > tbody > tr > td,
        .table-borderless > tbody > tr > th,
        .table-borderless > tfoot > tr > td,
        .table-borderless > tfoot > tr > th,
        .table-borderless > thead > tr > td,
        .table-borderless > thead > tr > th {
            border: none;
        }
        @media print {
            #printPageButton {
                display: none;
            }
            #noprint {
                display: none;
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

        .green-text {
            color: darkgreen;
        }

        .red-text {
            color: red;
        }

        .blue-text {
            color: blue;
        }

        .brown-text {
            color: brown;
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

        td, th {
            vertical-align: middle !important;
        }

        . {
            display: flex; /* equal height of the children */
        }
        .page-break {
            page-break-after: always;
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
            font-size: 18px;
        }

        .justified-text {
            text-align: justify;
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
        .box {
            border-style: solid;
            padding: 5px;
        }
        .dotted-box {
            border-style: dashed;
        }
        .image-box {
            border-style: solid;
        }
        .custom-sheet {
            height: 700px !important;
        }
        .capital-text {
            text-transform: uppercase;
        }
        .italic-text {
            font-style: italic;
        }
        .center-div {
            margin:0 auto;
        }
    </style>
</head>

<body id="app-layout">

@yield('content')
@yield('script')

</body>
</html>
