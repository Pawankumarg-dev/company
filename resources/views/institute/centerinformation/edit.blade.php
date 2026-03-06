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

        td, th {
            vertical-align: middle !important;
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
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 darkblue-background">
                @include('layouts.nav.header')
            </div>
        </div>
    </div>
</section>
<!--header-->

<section class="container-fluid">
    <div class="row">
        <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
            <div class="right-text">
                <a href="{{ url('/logout') }}" class="btn btn-danger"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
            </div>
        </div>
    </div>
</section>


<form role="form" method="POST" action="{{url('/institute/center-information/update')}}" onsubmit="return validateForm()">
    {{ csrf_field() }}

    <input type="hidden" name="institute_id" id="institute_id" value="{{ $institute->id }}" />
    <input type="hidden" id="institute_code" value="{{ $institute->code }}" />
    <input type="hidden" name="update_remarks" id="update_remarks" value="" />
    <input type="hidden" id="is-email-address-verified" value="No">
    <input type="hidden" id="email-address-verification-code" value="">

    <input type="hidden" id="dummy_state_id" @if($institute->city_id == 0) value="0" @else value="{{ $institute->city->state_id }}" @endif />
    <input type="hidden" id="dummy_city_id" value="{{ $institute->city_id }}" />

    <input type="hidden" id="dummy_street_address" value="{{ $institute->street_address }}" />
    <input type="hidden" id="dummy_postoffice" value="{{ $institute->postoffice }}" />
    <input type="hidden" id="dummy_pincode" value="{{ $institute->pincode }}" />
    <input type="hidden" id="dummy_landmark" value="{{ $institute->landmark }}" />
    <input type="hidden" id="dummy_contactnumber1" value="{{ $institute->contactnumber1 }}" />
    <input type="hidden" id="dummy_contactnumber2" value="{{ $institute->contactnumber2 }}" />
    <input type="hidden" id="dummy_email" value="{{ $institute->email }}" />
    <input type="hidden" id="dummy_email2" value="{{ $institute->email2 }}" />
    <input type="hidden" id="dummy_website" value="{{ $institute->website }}" />
    <input type="hidden" id="dummy_faxno" value="{{ $institute->faxno }}" />

    <input type="hidden" id="dummy_headname" @if(!is_null($institutehead)) value="{{ $institutehead->name }}" @else value="" @endif />
    <input type="hidden" id="dummy_headdesignation" @if(!is_null($institutehead)) value="{{ $institutehead->designation }}" @else value="" @endif />
    <input type="hidden" id="dummy_headqualification" @if(!is_null($institutehead)) value="{{ $institutehead->qualification }}" @else value="" @endif />
    <input type="hidden" id="dummy_headrci_reg_no" @if(!is_null($institutehead)) value="{{ $institutehead->rci_reg_no }}" @else value="" @endif />
    <input type="hidden" id="dummy_heademail" @if(!is_null($institutehead)) value="{{ $institutehead->email }}" @else value="" @endif />
    <input type="hidden" id="dummy_headcontactnumber1" @if(!is_null($institutehead)) value="{{ $institutehead->contactnumber1 }}" @else value="" @endif />
    <input type="hidden" id="dummy_headcontactnumber2" @if(!is_null($institutehead)) value="{{ $institutehead->contactnumber2 }}" @else value="" @endif />

    <input type="hidden" id="dummy_certificateincharge_name" @if(!is_null($institutecertificateincharge)) value="{{ $institutecertificateincharge->name }}" @else value="" @endif />
    <input type="hidden" id="dummy_certificateincharge_designation" @if(!is_null($institutecertificateincharge)) value="{{ $institutecertificateincharge->designation }}" @else value="" @endif />
    <input type="hidden" id="dummy_certificateincharge_contactnumber1" @if(!is_null($institutecertificateincharge)) value="{{ $institutecertificateincharge->contactnumber1 }}" @else value="" @endif />
    <input type="hidden" id="dummy_certificateincharge_contactnumber2" @if(!is_null($institutecertificateincharge)) value="{{ $institutecertificateincharge->contactnumber2 }}" @else value="" @endif />
    <input type="hidden" id="dummy_certificateincharge_email" @if(!is_null($institutecertificateincharge)) value="{{ $institutecertificateincharge->email }}" @else value="" @endif />

    <input type="hidden" id="dummy_buildup_area" @if(!is_null($institutefacility)) value="{{ $institutefacility->buildup_area }}" @else value="" @endif />
    <input type="hidden" id="dummy_landarea" @if(!is_null($institutefacility)) value="{{ $institutefacility->landarea }}" @else value="" @endif />
    <input type="hidden" id="dummy_city_distance" @if(!is_null($institutefacility)) value="{{ $institutefacility->city_distance }}" @else value="" @endif />
    <input type="hidden" id="dummy_postoffice_distance" @if(!is_null($institutefacility)) value="{{ $institutefacility->postoffice_distance }}" @else value="" @endif />
    <input type="hidden" id="dummy_available_rooms" @if(!is_null($institutefacility)) value="{{ $institutefacility->available_rooms }}" @else value="" @endif />
    <input type="hidden" id="dummy_biometric_facility" @if(!is_null($institutefacility)) value="{{ $institutefacility->biometric_facility }}" @else value="" @endif />
    <input type="hidden" id="dummy_cctv_facility" @if(!is_null($institutefacility)) value="{{ $institutefacility->cctv_facility }}" @else value="" @endif />

    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="panel panel-primary">
                    <div class="panel-heading left-text">
                        Institute's Center Information
                    </div>

                    <div class="panel-body">

                        {{-- Centre Information Status --}}
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12 well well-sm white-background">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12 alert alert-info">
                                                <span class="bold-text" style="font-size: large">
                                                    Centre Information Status
                                                </span>
                                                </div>

                                                @if($institute->verify_status == '0')
                                                    <div class="col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-hover" role="table" width="100%"  style="font-size: large">
                                                                <tr>
                                                                    <td width="15%">
                                                                        Institute Details
                                                                    </td>
                                                                    <th>
                                                                        {{ $institute->code }} - {{ $institute->name }}
                                                                    </th>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ./Centre Information Status --}}

                        {{-- Postal Details of Institute --}}
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12 well well-sm white-background">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12 alert alert-info">
                                                    <span class="bold-text" style="font-size: large">
                                                        Institute's Postal Address
                                                    </span>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="state_id">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please select the State from the option
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <select class="form-control" name="state_id" id="state_id" @if($institute->verify_status == '1') disabled @endif>
                                                                @if($institute->city_id == 0)
                                                                    <option value="0" selected>-- Select State --</option>
                                                                    @foreach($states as $state)
                                                                        <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="0">-- Select State --</option>
                                                                    @foreach($states as $state)
                                                                        <option value="{{ $state->id }}"
                                                                                @if($institute->city->state->id == $state->id)
                                                                                selected
                                                                                @endif
                                                                        >{{ $state->state_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="city_id">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please select the District from the option
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <select class="form-control" name="city_id" id="city_id" @if($institute->verify_status == '1') disabled @endif onchange="updateRemarks()">
                                                                @if($institute->city_id != 0)
                                                                    <option value="0">-- Select District --</option>
                                                                    @foreach($cities as $city)
                                                                        @if($city->state_id == $institute->city->state_id)
                                                                            <option value="{{ $city->id }}"
                                                                                    @if($institute->city_id == $city->id)
                                                                                    selected
                                                                                    @endif
                                                                            >
                                                                                {{ $city->name }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="street_address">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the address of the Institute
                                                                    <span class="red-text">(Please do not enter District / State / Post Office / Pincode here)</span>
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" name="street_address" id="street_address" value="{{ strtoupper($institute->street_address) }}" placeholder="Enter the Address" @if($institute->verify_status == '1') disabled @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="postoffice">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the name of the nearby Post Office
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" name="postoffice" id="postoffice" value="{{ strtoupper($institute->postoffice) }}" placeholder="Enter nearby Post Office"  @if($institute->verify_status == '1') disabled @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="pincode">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the pincode
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="number" class="form-control" name="pincode" id="pincode" value="{{ $institute->pincode }}" placeholder="Enter Pincode"  @if($institute->verify_status == '1') disabled @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="landmark">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the Landmark
                                                                    <span class="red-text">(Please do not enter District / State here)</span>
                                                                </span>
                                                                <span class="green-text"><br>(optional)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" name="landmark" id="landmark" value="{{ strtoupper($institute->landmark) }}" placeholder="Enter the Landmark" @if($institute->verify_status == '1') disabled @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="contactnumber1">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the contact number of the Institute
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="number" class="form-control" name="contactnumber1" id="contactnumber1" value="{{ $institute->contactnumber1 }}" placeholder="Enter Contact No"  @if($institute->verify_status == '1') disabled @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="contactnumber2">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the alternate contact number of the Institute
                                                                </span>
                                                                <span class="green-text"><br>(optional)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="number" class="form-control" name="contactnumber2" id="contactnumber2" value="{{ $institute->contactnumber2 }}" placeholder="Enter Alternate Contact No"  @if($institute->verify_status == '1') disabled @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="email">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the email address of the Institute
                                                                    <span class="red-text">(Please enter the valid email address)</span>
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <input type="email" class="form-control" name="email" id="email" value="{{ $institute->email }}" placeholder="Enter Email Address"  @if($institute->verify_status == '1') disabled @endif>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div id="email-address-verify-button-div" class="col-sm-5 col-sm-offset-2">
                                                                        <button id="email-address-verify-button" type="button" class="btn btn-sm btn-warning" onclick="displayEmailAddressVerificationModal()">
                                                                            <span class="glyphicon glyphicon-circle-arrow-right"></span>
                                                                            Click here to Verify Email Address
                                                                        </button>
                                                                    </div>

                                                                    <div id="email-address-show-verified-div" class="col-sm-4 col-sm-offset-2 content-hide text-success">
                                                                        <strong>&check;&nbsp; Email Address Verified</strong>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="email2">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the alternate email address of the Institute

                                                            <span class="red-text">(Please enter if the institute have two email addresses)</span>
                                                                </span>
                                                                <span class="green-text"><br>(optional)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="email" class="form-control" name="email2" id="email2" value="{{ $institute->email2 }}" placeholder="Enter Alternate Email Address" @if($institute->verify_status == '1') disabled @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="website">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the website of the institute
                                                            <span class="red-text">(Please enter if the institute has website)</span>
                                                                </span>
                                                                <span class="green-text"><br>(optional)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" name="website" id="website" value="{{ $institute->website }}" placeholder="Enter website"  @if($institute->verify_status == '1') disabled @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="faxno">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the fax number
                                                            <span class="red-text">(Please enter if the institute has fax)</span>
                                                                </span>
                                                                <span class="green-text"><br>(optional)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="number" class="form-control" name="faxno" id="faxno" value="{{ $institute->faxno }}" placeholder="Enter Fax No."  @if($institute->verify_status == '1') disabled @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ./Postal Details of Institute --}}

                        {{-- Details of Head of Institute --}}
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12 well well-sm white-background">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12 alert alert-info">
                                                <span class="bold-text" style="font-size: large">
                                                    Head of Institute's Details
                                                </span>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="headname">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the Name of Head of the Institute
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" name="headname" id="headname" placeholder="Enter Name of Head"
                                                                   @if(is_null($institutehead))
                                                                   value=""
                                                                   @else
                                                                   value="{{ strtoupper($institutehead->name) }}"
                                                                   @endif
                                                                   @if($institute->verify_status == '1') disabled @endif
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="headname">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the Designation of Head of the Institute
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" name="headdesignation" id="headdesignation" placeholder="Enter Designation of Head"
                                                                   @if(is_null($institutehead))
                                                                   value=""
                                                                   @else
                                                                   value="{{ strtoupper($institutehead->designation) }}"
                                                                   @endif
                                                                   @if($institute->verify_status == '1') disabled @endif
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="headqualification">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the Qualification of Head of the Institute
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" name="headqualification" id="headqualification" placeholder="Enter Qualification of Head"
                                                                   @if(is_null($institutehead))
                                                                   value=""
                                                                   @else
                                                                   value="{{ $institutehead->qualification }}"
                                                                   @endif
                                                                   @if($institute->verify_status == '1') disabled @endif
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="headrci_reg_no">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the RCI's C.R.R. No. of Head of the Institute
                                                                </span>
                                                                <span class="green-text"><br>(optional)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" name="headrci_reg_no" id="headrci_reg_no" placeholder="Enter RCI CRR No. of Head"
                                                                   @if(is_null($institutehead))
                                                                   value=""
                                                                   @else
                                                                   value="{{ strtoupper($institutehead->rci_reg_no) }}"
                                                                   @endif
                                                                   @if($institute->verify_status == '1') disabled @endif
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="heademail">
                                                            <span class="blue-text" style="font-size: 17px">
                                                                Please enter the email address of Head of the Institute
                                                                <span class="red-text">(Please enter only one email address)</span>
                                                            </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="heademail" name="heademail"
                                                                   @if(is_null($institutehead))
                                                                   value=""
                                                                   @else
                                                                   value="{{ $institutehead->email }}"
                                                                   @endif

                                                                   @if($institute->verify_status == '1') disabled @endif
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="headcontactnumber1">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the mobile number of Head of Institute
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="number" class="form-control" id="headcontactnumber1" name="headcontactnumber1"
                                                                   @if(is_null($institutehead))
                                                                   value=""
                                                                   @else
                                                                   value="{{ $institutehead->contactnumber1 }}"
                                                                   @endif

                                                                   @if($institute->verify_status == '1') disabled @endif
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="headcontactnumber2">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the alternate mobile number of Head of Institute
                                                                </span>
                                                                <span class="green-text"><br>(optional)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="number" class="form-control" id="headcontactnumber2" name="headcontactnumber2"
                                                                   @if(is_null($institutehead))
                                                                   value=""
                                                                   @else
                                                                   value="{{ $institutehead->contactnumber2 }}"
                                                                   @endif

                                                                   @if($institute->verify_status == '1') disabled @endif
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ./Details of Head of Institute --}}

                        {{-- Details of Person Incharge for receiving Certificates / Statement of Marks --}}
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12 well well-sm white-background">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12 alert alert-info">
                                                <span class="bold-text" style="font-size: large">
                                                    Details of Person Incharge for receiving Certificates / Statement of Marks
                                                </span>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="certificateincharge_name">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the name of the Incharge Person
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-7">
                                                            <input type="name" class="form-control" id="certificateincharge_name" name="certificateincharge_name"
                                                                   @if(is_null($institutecertificateincharge))
                                                                   value=""
                                                                   @else
                                                                   value="{{ strtoupper($institutecertificateincharge->name) }}"
                                                                   @endif

                                                                   @if($institute->verify_status == '1') disabled @endif
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="certificateincharge_designation">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the desgination of the Incharge Person
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="certificateincharge_designation" name="certificateincharge_designation"
                                                                   @if(is_null($institutecertificateincharge))
                                                                   value=""
                                                                   @else
                                                                   value="{{ $institutecertificateincharge->designation }}"
                                                                   @endif

                                                                   @if($institute->verify_status == '1') disabled @endif
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="certificateincharge_contactnumber1">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the mobile number of the Incharge Person
                                                                    <span class="red-text">(Please enter in valid and working mobile number)</span>
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="number" class="form-control" id="certificateincharge_contactnumber1" name="certificateincharge_contactnumber1"
                                                                   @if(is_null($institutecertificateincharge))
                                                                   value=""
                                                                   @else
                                                                   value="{{ $institutecertificateincharge->contactnumber1 }}"
                                                                   @endif

                                                                   @if($institute->verify_status == '1') disabled @endif
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="certificateincharge_contactnumber2">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the alternate mobile number of the Incharge Person
                                                                    <span class="red-text">(Please enter in valid and working mobile number)</span>
                                                                </span>
                                                                <span class="green-text"><br>(optional)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="number" class="form-control" id="certificateincharge_contactnumber2" name="certificateincharge_contactnumber2"
                                                                   @if(is_null($institutecertificateincharge))
                                                                   value=""
                                                                   @else
                                                                   value="{{ $institutecertificateincharge->contactnumber2 }}"
                                                                   @endif

                                                                   @if($institute->verify_status == '1') disabled @endif
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="certificateincharge_email">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the email address of the Incharge Person
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="email" class="form-control" id="certificateincharge_email" name="certificateincharge_email"
                                                                   @if(is_null($institutecertificateincharge))
                                                                   value=""
                                                                   @else
                                                                   value="{{ $institutecertificateincharge->email }}"
                                                                   @endif

                                                                   @if($institute->verify_status == '1') disabled @endif
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ./Details of Person Incharge for receiving Certificates / Statement of Marks --}}

                        {{-- Facilities Details of Institute --}}
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12 well well-sm white-background">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12 alert alert-info">
                                                <span class="bold-text" style="font-size: large">
                                                    Institute Facility Details
                                                </span>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="buildup_area">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the Buildup Area of the Institute
                                                                    <span class="red-text">(Please enter in terms of Square feet)</span>
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="number" class="form-control" id="buildup_area" name="buildup_area"
                                                               @if(is_null($institutefacility))
                                                               value=""
                                                               @else
                                                               value="{{ $institutefacility->buildup_area }}"
                                                               @endif

                                                               @if($institute->verify_status == '1') disabled @endif
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="landarea">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the Land Area of the Institute
                                                                    <span class="red-text">(Please enter in terms of Square feet)</span>
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="number" class="form-control" id="landarea" name="landarea"
                                                               @if(is_null($institutefacility))
                                                               value=""
                                                               @else
                                                               value="{{ $institutefacility->landarea }}"
                                                               @endif

                                                               @if($institute->verify_status == '1') disabled @endif
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="city_distance">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the approximate distance from the city (bus stand / railway station)
                                                                    <span class="red-text">(Please enter in terms of Kilometers)</span>
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="number" class="form-control" id="city_distance" name="city_distance"
                                                               @if(is_null($institutefacility))
                                                               value=""
                                                               @else
                                                               value="{{ $institutefacility->city_distance }}"
                                                               @endif

                                                               @if($institute->verify_status == '1') disabled @endif
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="postoffice_distance">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the approximate distance from the nearest Post office
                                                                    <span class="red-text">(Please enter in terms of Kilometers)</span>
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="number" class="form-control" id="postoffice_distance" name="postoffice_distance"
                                                                   @if(is_null($institutefacility))
                                                                   value=""
                                                                   @else
                                                                   value="{{ $institutefacility->postoffice_distance }}"
                                                                   @endif

                                                                   @if($institute->verify_status == '1') disabled @endif
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="available_rooms">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Please enter the number of rooms available in the Institute
                                                                    <span class="red-text">(Please enter in terms of Numbers)</span>
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="number" class="form-control" id="available_rooms" name="available_rooms"
                                                                   @if(is_null($institutefacility))
                                                                   value=""
                                                                   @else
                                                                   value="{{ $institutefacility->available_rooms }}"
                                                                   @endif

                                                                   @if($institute->verify_status == '1') disabled @endif
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="biometric_facility">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Is Bio-metric facility available in the Institute?
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <select class="form-control" name="biometric_facility" id="biometric_facility" @if($institute->verify_status == '1') disabled @endif onchange="updateRemarks()">
                                                                @if(is_null($institutefacility))
                                                                    <option value="0">-- Select an option --</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                @else
                                                                    <option value="0">-- Select --</option>
                                                                    <option value="Yes"
                                                                            @if($institutefacility->biometric_facility == 'Yes')
                                                                            selected
                                                                            @endif
                                                                    >
                                                                        Yes
                                                                    </option>
                                                                    <option value="No"
                                                                            @if($institutefacility->biometric_facility == 'No')
                                                                            selected
                                                                            @endif
                                                                    >
                                                                        No
                                                                    </option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label for="cctv_facility">
                                                                <span class="blue-text" style="font-size: 17px">
                                                                    Is CCTV facility available in the Institute?
                                                                </span>
                                                                <span class="red-text"><br>(mandatory)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <select class="form-control" name="cctv_facility" id="cctv_facility" @if($institute->verify_status == '1') disabled @endif>
                                                                @if(is_null($institutefacility))
                                                                    <option value="0">-- Select an option --</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                @else
                                                                    <option value="0">-- Select --</option>
                                                                    <option value="Yes"
                                                                            @if($institutefacility->cctv_facility == 'Yes')
                                                                            selected
                                                                            @endif
                                                                    >
                                                                        Yes
                                                                    </option>

                                                                    <option value="No"
                                                                            @if($institutefacility->cctv_facility == 'No')
                                                                            selected
                                                                            @endif
                                                                    >
                                                                        No
                                                                    </option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ./Facilities Details of Institute --}}

                        @if($institute->verify_status == '0')
                            {{-- Submit --}}
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-12 well well-sm white-background">
                                        <div class="row">
                                            <div class="col-sm-12">

                                                {{-- Form Button --}}
                                                <div class="form-group">
                                                    <div class="col-sm-5">
                                                        <button type="submit"
                                                                @if($institute->verify_status == '1')
                                                                disabled
                                                                class="btn btn-default"
                                                                @else
                                                                class="btn btn-primary"
                                                                @endif
                                                        >
                                                            Submit
                                                        </button>

                                                        <button type="reset"
                                                                @if($institute->verify_status == '1')
                                                                disabled
                                                                class="btn btn-default"
                                                                @else
                                                                class="btn btn-danger"
                                                                @endif
                                                        >
                                                            Reset
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- ./Form Button --}}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ./Submit --}}
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </section>
</form>

<!--Footer-->
<footer class="container-fluid">
    <div class="row">
        <div class="col-sm-12 well well-sm white-background minus15px-margin-top center-text">
            In case of queries, please send email to <span class="bold-text blue-text">niepmd.examinations@gmail.com</span>
        </div>
    </div>
</footer>
<!--Footer-->

<!-- Email Address Verification Modal -->
<div class="modal fade" id="email-address-verification-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Email Address Verification</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label left-text blue-text" for="verify-email-address">Email Address :</label>
                            <input type="text" class="form-control blue-text" id="verify-email-address" name="verify-email-address" maxlength="10" readonly />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <button type="button" id="send-email-address-verification-code-button" class="btn btn-success" onclick="sendEmailAddressVerificationCode()"><span class="glyphicon glyphicon-phone"></span>&nbsp; Send Verification Code</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="email-address-loader-div" class="col-sm-12 content-hide">
                        <div class="form-group">
                            <div id="email-address-loader" class="loader"></div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div id="display-email-address-verification-code-entry-field-div" class="content-hide">
                            <div class="form-group">
                                <p class="form-control-static alert alert-success">Please enter 4-digit Verification Code sent to your Mobile No</p>
                            </div>
                            <div class="form-group">
                                <label class="control-label left-text blue-text" for="email-address-verification-code-2">Verification Code :</label>
                                <input type="text" class="form-control blue-text" id="email-address-verification-code-2" name="email-address-verification-code-2" maxlength="4" placeholder="4-digit Verification Code" />
                            </div>
                            <button type="button" class="btn btn-success" onclick="verifyEmailAddressVerificationCode()"><span class="glyphicon glyphicon-phone"></span>&nbsp; Verify Code</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#state_id').on('change',function(){
            var stateID = $(this).val();
            if(stateID){
                $.ajax({
                    type:"GET",
                    url:"{{url('get-city-list')}}?state_id="+stateID,
                    success:function(res){
                        if(res){
                            $("#city_id").empty();
                            $("#city_id").append('<option value="0">-- Select District --</option>');

                            $.each(res, function () {
                                $("#city_id").append('<option value="'+this.id+'">'+this.name+'</option>');
                            })

                        }else{
                            $("#city_id").empty();
                        }
                    }
                });
            }
            else{
                $("#city_id").empty();
            }
        });

        $('#postoffice').keyup(function () {
            $(this).val($(this).val().toUpperCase());
        });

        $('#street_address').keyup(function () {
            $(this).val($(this).val().toUpperCase());
        });

        $('#landmark').keyup(function () {
            $(this).val($(this).val().toUpperCase());
        });

        $('#headname').keyup(function () {
            $(this).val($(this).val().toUpperCase());
        });

        $('#headdesignation').keyup(function () {
            $(this).val($(this).val().toUpperCase());
        });

        $('#headrcino').keyup(function () {
            $(this).val($(this).val().toUpperCase());
        });

        $('#certificateincharge_name').keyup(function () {
            $(this).val($(this).val().toUpperCase());
        });

        $('#certificateincharge_designation').keyup(function () {
            $(this).val($(this).val().toUpperCase());
        });

        $('#email').blur(function () {
            if($('#email').is(':valid')) {

            }
            else {
                alert('Invalid Email ID entered');
                $('#email').focus();

                $('#email').val('');

            }
        });

        $('#email2').blur(function () {

            if($('#email2').is(':valid')) {

            }
            else {
                alert('Invalid email2 ID entered');
                $('#email2').focus();

                $('#email2').val('');
            }
        });

        $('#heademail').blur(function () {
            if($('#heademail').is(':valid')) {

            }
            else {
                alert('Invalid Email ID entered');
                $('#heademail').focus();

                $('#heademail').val('');

            }
        });
    });

    function validateForm() {
        if($('#state_id').val() == '0') {
            $('#state_id').focus();
            swal("Error Occurred!!!", "Please select the State from the option", "error");

            return false;
        }

        if($('#city_id').val() == '0') {
            $('#city_id').focus();
            swal("Error Occurred!!!", "Please select the District from the option", "error");

            return false;
        }

        if(!$('#street_address').val()) {
            $('#street_address').focus();
            swal("Error Occurred!!!", "Please enter the address of the Institute", "error");

            return false;
        }

        if(!$('#postoffice').val()) {
            $('#postoffice').focus();
            swal("Error Occurred!!!", "Please enter the name of the nearby Post Office", "error");

            return false;
        }

        if(!$('#pincode').val()) {
            $('#pincode').focus();
            swal("Error Occurred!!!", "Please enter the pincode", "error");

            return false;
        }

        if(!$('#contactnumber1').val()) {
            $('#contactnumber1').focus();
            swal("Error Occurred!!!", "Please enter the contact number of the Institute", "error");

            return false;
        }

        if(!$('#email').val()) {
            $('#email').focus();
            swal("Error Occurred!!!", "Please enter the email address of the Institute", "error");

            return false;
        }

        if($('#is-email-address-verified').val() == "No") {
            $('#email').focus();
            swal("Error Occurred!!!", "Please click the Verify Email Address Button to verify the Institute email address", "error");


            return false;
        }

        if(!$('#headname').val()) {
            $('#headname').focus();
            swal("Error Occurred!!!", "Please enter the Name of Head of the Institute", "error");

            return false;
        }

        if(!$('#headdesignation').val()) {
            $('#headdesignation').focus();
            swal("Error Occurred!!!", "Please enter the Designation of Head of the Institute", "error");

            return false;
        }

        if(!$('#headqualification').val()) {
            $('#headqualification').focus();
            swal("Error Occurred!!!", "Please enter the Qualification of Head of the Institute", "error");

            return false;
        }

        if(!$('#heademail').val()) {
            $('#heademail').focus();
            swal("Error Occurred!!!", "Please enter the email address of Head of the Institute", "error");

            return false;
        }

        if(!$('#headcontactnumber1').val()) {
            $('#headcontactnumber1').focus();
            swal("Error Occurred!!!", "Please enter the mobile number of Head of Institute", "error");

            return false;
        }

        if(!$('#certificateincharge_name').val()) {
            $('#certificateincharge_name').focus();
            swal("Error Occurred!!!", "Please enter the name of the Incharge Person", "error");

            return false;
        }

        if(!$('#certificateincharge_designation').val()) {
            $('#certificateincharge_designation').focus();
            swal("Error Occurred!!!", "Please enter the desgination of the Incharge Person", "error");

            return false;
        }

        if(!$('#certificateincharge_contactnumber1').val()) {
            $('#certificateincharge_contactnumber1').focus();
            swal("Error Occurred!!!", "Please enter the mobile number of the Incharge Person", "error");

            return false;
        }

        if(!$('#certificateincharge_email').val()) {
            $('#certificateincharge_email').focus();
            swal("Error Occurred!!!", "Please enter the mobile number of the Incharge Person", "error");

            return false;
        }

        if(!$('#buildup_area').val()) {
            $('#buildup_area').focus();
            swal("Error Occurred!!!", "Please enter the Buildup Area of the Institute", "error");

            return false;
        }

        if(!$('#landarea').val()) {
            $('#landarea').focus();
            swal("Error Occurred!!!", "Please enter the Land Area of the Institute", "error");

            return false;
        }

        if(!$('#city_distance').val()) {
            $('#city_distance').focus();
            swal("Error Occurred!!!", "Please enter the approximate distance from the city (bus stand / railway station)", "error");

            return false;
        }

        if(!$('#postoffice_distance').val()) {
            $('#postoffice_distance').focus();
            swal("Error Occurred!!!", "Please enter the approximate distance from the nearest Post office", "error");

            return false;
        }

        if(!$('#available_rooms').val()) {
            $('#available_rooms').focus();
            swal("Error Occurred!!!", "Please enter the number of rooms available in the Institute", "error");

            return false;
        }

        if($('#biometric_facility').val() == '0') {
            $('#biometric_facility').focus();
            swal("Error Occurred!!!", "Is Bio-metric facility available in the Institute?", "error");

            return false;
        }

        if($('#cctv_facility').val() == '0') {
            $('#cctv_facility').focus();
            swal("Error Occurred!!!", "Is CCTV facility available in the Institute?", "error");

            return false;
        }

        updateRemarks();
        return true;
    }

    function updateRemarks() {
        var remarks = "";
        var count = parseInt("1");

        if($('#dummy_state_id').val() != $('#state_id').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute\'s State';
            count++;
        }

        if($('#dummy_city_id').val() != $('#city_id').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute\'s District';
            count++;
        }

        if($('#dummy_street_address').val().toUpperCase() != $('#street_address').val().toUpperCase()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute\'s Street Address';
            count++;
        }

        if($('#dummy_postoffice').val().toUpperCase() != $('#postoffice').val().toUpperCase()) {

            if(count != "1") {
                remarks += ', ';
            }
            remarks += 'Institute\'s Post Office';
            count++;
        }

        if($('#dummy_pincode').val() != $('#pincode').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute\'s Pincode';
            count++;
        }

        if($('#dummy_landmark').val().toUpperCase() != $('#landmark').val().toUpperCase()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute\'s Landmark';
            count++;
        }

        if($('#dummy_contactnumber1').val() != $('#contactnumber1').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute\'s Contact No.';
            count++;
        }

        if($('#dummy_contactnumber2').val() != $('#contactnumber2').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute\'s Alternate Contact No.';
            count++;
        }

        if($('#dummy_email').val() != $('#email').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute\'s Email';
            count++;
        }

        if($('#dummy_email2').val() != $('#email2').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute\'s Alternate Email';
            count++;
        }

        if($('#dummy_website').val() != $('#website').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute\'s Website';
            count++;
        }

        if($('#dummy_faxno').val() != $('#faxno').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute\'s Fax Number';
            count++;
        }

        if($('#dummy_headname').val().toUpperCase() != $('#headname').val().toUpperCase()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Head\'s Name';
            count++;
        }

        if($('#dummy_headdesignation').val().toUpperCase() != $('#headdesignation').val().toUpperCase()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Head\'s Designation';
            count++;
        }

        if($('#dummy_headqualification').val() != $('#headqualification').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Head\'s Qualification';
            count++;
        }

        if($('#dummy_headrci_reg_no').val().toUpperCase() != $('#headrci_reg_no').val().toUpperCase()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Head\'s Reg. CRR No.';
            count++;
        }

        if($('#dummy_headcontactnumber1').val() != $('#headcontactnumber1').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Head\'s Contact No.';
            count++;
        }

        if($('#dummy_headcontactnumber2').val() != $('#headcontactnumber2').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Head\'s Alternate Contact No.';
            count++;
        }

        if($('#dummy_certificateincharge_name').val().toUpperCase() != $('#certificateincharge_name').val().toUpperCase()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Certificate Incharge\'s Name';
            count++;
        }

        if($('#dummy_certificateincharge_designation').val().toUpperCase() != $('#certificateincharge_designation').val().toUpperCase()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Certificate Incharge\'s Designation';
            count++;
        }

        if($('#dummy_certificateincharge_contactnumber1').val() != $('#certificateincharge_contactnumber1').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Certificate Incharge\'s Contact No.';
            count++;
        }

        if($('#dummy_certificateincharge_contactnumber2').val() != $('#certificateincharge_contactnumber2').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Certificate Incharge\'s Alternate Contact No.';
            count++;
        }

        if($('#dummy_certificateincharge_email').val() != $('#certificateincharge_email').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Certificate Incharge\'s Email';
            count++;
        }

        if($('#dummy_buildup_area').val() != $('#buildup_area').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Facility\'s Buildup Area';
            count++;
        }

        if($('#dummy_landarea').val() != $('#landarea').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Facility\'s Land Area';
            count++;
        }

        if($('#dummy_city_distance').val() != $('#city_distance').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Facility\'s City Distance';
            count++;
        }

        if($('#dummy_postoffice_distance').val() != $('#postoffice_distance').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Facility\'s Postoffice Distance';
            count++;
        }

        if($('#dummy_available_rooms').val() != $('#available_rooms').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Facility\'s No. of Classroom';
            count++;
        }

        if($('#dummy_biometric_facility').val() != $('#biometric_facility').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Facility\'s Biometric Facility';
            count++;
        }

        if($('#dummy_cctv_facility').val() != $('#cctv_facility').val()) {

            if(count != "1") {
                remarks += ', ';
            }

            remarks += 'Institute Facility\'s CCTV Facility';
            count++;
        }

        $('#update_remarks').val(remarks);
    }

    function displayEmailAddressVerificationModal() {
        if($('#email').val() === "") {
            swal("Error Occurred!!!", "Please enter Email Address", "error");
        }
        else {
            var mailformat = "^[a-zA-Z0-9]+(\.[_a-zA-Z0-9]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,15})$";

            if (!$('#email').val().match(mailformat)) {
                swal("Error Occurred!!!", "Please enter a valid email address", "error");
            }
            else {
                $.ajax({
                    url: "{{ url('/institute/center-information/ajaxrequest/checkemailaddressexist') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {_token: "{{ csrf_token() }}", emailAddress: $.trim($('#email').val()), instituteId: $('#institute_id').val()},
                    success:function(data) {
                        if(data == "Not Exist" || data == "Self-Exist") {
                            $('#email-address-verification-modal').modal({backdrop: 'static', keyboard: false});
                            $('#verify-email-address').val($('#email').val());
                        }
                        else {
                            swal("Error Occurred!!!", "Email Address already exist", "error");
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText);
                    }
                })
            }
        }
    }

    function sendEmailAddressVerificationCode() {
        var emailAddressVerificationCode = Math.floor(1000 + Math.random() * 9000);
        $('#email-address-verification-code').val(emailAddressVerificationCode);

        $.ajax({
            url: "{{ url('/institute/center-information/ajaxrequest/sendemailaddressverificationcode') }}",
            type: "POST",
            dataType: "JSON",
            data : {_token: "{{ csrf_token() }}", emailAddress: $.trim($('#email').val()), verificationCode : emailAddressVerificationCode, instituteCode: $.trim($('#institute_code').val())},
            beforeSend:function() {
                $('#send-email-address-verification-code-button').html('<span class="glyphicon glyphicon-phone"></span>&nbsp; Re-Send Verification Code');
                if($('#display-email-address-verification-code-entry-field-div').hasClass('content-show')) {
                    $('#display-email-address-verification-code-entry-field-div').removeClass('content-show').addClass('content-hide');
                }

                if($('#email-address-loader-div').hasClass('content-hide')) {
                    $('#email-address-loader-div').removeClass('content-hide').addClass('content-show');
                }
            },
            success:function(data) {
                if(data) {
                    $('#email-address-loader-div').removeClass('content-show').addClass('content-hide');

                    if($('#display-email-address-verification-code-entry-field-div').hasClass('content-hide')) {
                        $('#display-email-address-verification-code-entry-field-div').removeClass('content-hide').addClass('content-show');
                    }
                    swal("Congratulations!!!", "4-digit Verification code has been sent to your Email Address.", "success");
                }

                // if($('#display-email-address-verification-code-entry-field-div').hasClass('content-hide')) {
                //     $('#display-email-address-verification-code-entry-field-div').removeClass('content-hide').addClass('content-show');
                // }
                // swal("Congratulations!!!", "4-digit Verification code has been sent to your Email Address.", "success");
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            },
            complete:function() {

            }
        });
    }

    function verifyEmailAddressVerificationCode() {
        if($('#email-address-verification-code').val() == $('#email-address-verification-code-2').val()) {
            swal("Congratulations!!!", "Email Address verified successfully", "success");

            $('#email').prop('readonly', true);
            $('#is-email-address-verified').val('Yes');

            $('#email-address-verify-button-div').removeClass('content-show').addClass('content-hide');
            $('#email-address-show-verified-div').removeClass('content-hide').addClass('content-show');

            $('#email-address-verification-modal').modal("hide");
        }
        else {
            swal("Error Occurred!!!", "Entered Verification code does not match. Please re-enter verification code or Click Re-Send Verification Code", "error");
        }
    }
</script>

</body>

</html>