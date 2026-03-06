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

                                            @if($institute->verify_status == '1')
                                                <div class="col-sm-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover" role="table" width="100%"  style="font-size: large">
                                                            <tr>
                                                                <td width="15">
                                                                    Institute Details
                                                                </td>
                                                                <th>
                                                                    {{ $institute->code }} - {{ $institute->name }}
                                                                </th>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    Current Status
                                                                </td>
                                                                <th>
                                                                        <span class="label label-danger">
                                                                            Pending
                                                                        </span>
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
                                                            @if(is_null($institute))
                                                                <option value="0" selected>-- Select State --</option>
                                                                @foreach($states as $state)
                                                                    <option value="{{ $state->id }}">{{$state->state_name}}</option>
                                                                @endforeach
                                                            @elseif(is_null($institute->city_id) || $institute->city_id == '' || $institute->city_id == '0')
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
                                                            @if(!is_null($institute->city_id))
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
                                                    <div class="col-sm-4">
                                                        <input type="email" class="form-control" name="email" id="email" value="{{ $institute->email }}" placeholder="Enter Email Address"  @if($institute->verify_status == '1') disabled @endif>
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
                </div>

            </div>
        </div>
    </div>
</section>

<!--Footer-->
<footer class="container-fluid">
    <div class="row">
        <div class="col-sm-12 well well-sm white-background minus15px-margin-top center-text">
            In case of queries, please send email to <span class="bold-text blue-text">niepmd.examinations@gmail.com</span>
        </div>
    </div>
</footer>
<!--Footer-->


</body>

</html>