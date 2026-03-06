<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>NIEPMD NBER Examination Cell</title>

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

        . {
            display: flex; /* equal height of the children */
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

<!--header-->
<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm darkblue-background">
                <div class="col-sm-12 darkblue-background">
                    @include('layouts.nav.header')
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

<section class="container-fluid">
    <div class="row">
        <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
            <div class="center-text">
                {{--<a href="{{ url('/examinations') }}" class="btn btn-success"><i class="fa fa-btn fa fa-arrow-right"></i>Click here to enter into the website</a>--}}
                <a href="{{ url('/institute/dashboard/home') }}" class="btn btn-success"><i class="fa fa-btn fa fa-arrow-right"></i>Click here to enter into the website</a>
                <a href="{{ url('/logout') }}" class="btn btn-danger"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
            </div>
        </div>
    </div>
</section>

<section class="minus15px-margin-top">
    <div class="container-fluid">
        <div class="col-sm-12 well well-sm white-background" style="width: 100% !important;">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-striped table-bordered table-condensed">
                        <caption class="blue-text bold-text">Institute Information</caption>
                        <tr>
                            <th class="green-text" style="width: 15%">Institute Code</th>
                            <th class="center-text" style="width: 2%">:</th>
                            <td class="blue-text">{{ $institute->code }}</td>
                        </tr>
                        <tr>
                            <th class="green-text">Institute Name</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">{{ strtoupper($institute->name) }}</td>
                        </tr>
                        <tr>
                            <th class="green-text">Address</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">
                                @if($institute->street_address != '') {{$institute->street_address}} @endif
                                @if(!is_null($institute->postoffice))
                                    <br>{{ $institute->postoffice }} POST OFFICE,
                                @endif
                                @if($institute->city_id != 0)
                                    <br>{{ $institute->city->name }} DIST., {{ $institute->city->state->state_name }}
                                @endif
                                @if($institute->pincode != '') - {{$institute->pincode}}. @endif
                                @if($institute->landmark != '') <br>LANDMARK - {{$institute->landmark}} @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="green-text">Email Address</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">{{ $institute->email }}</td>
                        </tr>
                        <tr>
                            <th class="green-text">Alternate Email Address</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">{{ $institute->email2 }}</td>
                        </tr>
                        <tr>
                            <th class="green-text">Contact Number(s)</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">
                                @if($institute->contactnumber1 != '') {{$institute->contactnumber1}}@endif
                                @if($institute->contactnumber2 != '')
                                    , {{$institute->contactnumber2}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="green-text">Website</th>
                            <td class="center-text">:</td>
                            <td class="blue-text">@if($institute->website != '') {{$institute->website}} @else NIL @endif</td>
                        </tr>
                        <tr>
                            <th class="green-text">Fax No.</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">@if($institute->faxno != '') {{$institute->faxno}} @else NIL @endif</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-striped table-bordered table-condensed">
                        <caption class="blue-text bold-text">Institute Head Information</caption>
                        <tr>
                            <th class="green-text" style="width: 15%">Name</th>
                            <th class="center-text" style="width: 2%">:</th>
                            <td class="blue-text">{{ $instituteheads->name }}</td>
                        </tr>
                        <tr>
                            <th class="green-text">Designation</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">{{ $instituteheads->designation }}</td>
                        </tr>
                        <tr>
                            <th class="green-text">Qualification</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">{{ $instituteheads->qualification }}</td>
                        </tr>
                        <tr>
                            <th class="green-text">RCI Reg. No.</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">{{ $instituteheads->rci_reg_no }}</td>
                        </tr>
                        <tr>
                            <th class="green-text">Email Address</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">{{ $instituteheads->email }}</td>
                        </tr>
                        <tr>
                            <th class="green-text">Contact Number(s)</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">
                                @if($instituteheads->contactnumber1 != '') {{$instituteheads->contactnumber1}}@endif
                                @if($instituteheads->contactnumber2 != ''), {{$instituteheads->contactnumber2}}@endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-striped table-bordered table-condensed">
                        <caption class="blue-text bold-text">Details of Person Incharge for receiving Certificates / Statement of Marks</caption>
                        <tr>
                            <th class="green-text" style="width: 15%">Name</th>
                            <th class="center-text" style="width: 2%">:</th>
                            <td class="blue-text">{{ $institutecertificateincharge->name }}</td>
                        </tr>
                        <tr>
                            <th class="green-text">Designation</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">{{ $institutecertificateincharge->designation }}</td>
                        </tr>
                        <tr>
                            <th class="green-text">Email Address</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">{{ $institutecertificateincharge->email }}</td>
                        </tr>
                        <tr>
                            <th class="green-text">Contact Number(s)</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">
                                @if($institutecertificateincharge->contactnumber1 != '') {{$institutecertificateincharge->contactnumber1}} @endif
                                @if($institutecertificateincharge->contactnumber2 != '')
                                    , {{$institutecertificateincharge->contactnumber2}}
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-striped table-bordered table-condensed">
                        <caption class="blue-text bold-text">Institute Facilities Information</caption>
                        <tr>
                            <th class="green-text" style="width: 15%">Buildup Area</th>
                            <th class="center-text" style="width: 2%">:</th>
                            <td class="blue-text">
                                @if($institutefacility->buildup_area != '')
                                    {{ $institutefacility->buildup_area }} (in square feet)
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="green-text">Land Area</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">
                                @if($institutefacility->landarea != '')
                                    {{ $institutefacility->landarea }} (in square feet)
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="green-text">Distance from the city (bus stand / railway station)</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">
                                @if($institutefacility->city_distance != '')
                                    {{ $institutefacility->city_distance }} (in kms)
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="green-text">Distance from the nearest Head Post office</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">
                                @if($institutefacility->postoffice_distance != '')
                                    {{ $institutefacility->postoffice_distance }} (in kms)
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="green-text">Available number of rooms</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">
                                @if($institutefacility->available_rooms != '')
                                    {{ $institutefacility->available_rooms }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="green-text">Size of the Classrooms</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">
                                @if($institutefacility->classroom_size != '')
                                    {{ $institutefacility->classroom_size }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="green-text">Biometric Facility Availability</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">
                                @if($institutefacility->biometric_facility != '')
                                    {{ $institutefacility->biometric_facility }}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="green-text">CCTV Facility Availability</th>
                            <th class="center-text">:</th>
                            <td class="blue-text">
                                @if($institutefacility->cctv_facility != '')
                                    {{ $institutefacility->cctv_facility }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>



</body>

</html>