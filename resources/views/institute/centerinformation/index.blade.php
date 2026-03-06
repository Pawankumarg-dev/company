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

<section class="minus15px-margin-top">
    <div class="container-fluid">
        <div class="col-sm-12 well well-sm white-background" style="width: 100% !important;">
            <div class="row">
                <div class="col-sm-12">

                    @if (Session::has('messages') )
                        @include('common.errorandmsg')
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{url('/institute/center-information/update')}}">
                        {{ csrf_field() }}
                        <h4>
                            <i class="fa fa-arrow-right"> </i> <u>Center Information</u>
                        </h4>
                        <hr />

                        <input type="hidden" name="institute_id" value="{{ $institute->id }}">

                        <div class="form-group">
                            <div class="col-sm-12">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                            <label for="code" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Institute Code</div>
                            </label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="code" name="code"
                                       value="{{ $institute->code }}" disabled/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Institute Name</div>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ $institute->name }}" disabled/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('address1') ? 'has-error' : '' }}">
                            <label for="address1" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Street</div>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="address1" name="address1"
                                       value="{{ $institute->address1 }}"

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('address2') ? 'has-error' : '' }}">
                            <label for="address2" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Village/Area</div>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="address2" name="address2"
                                       value="{{ $institute->address2 }}"

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('address3') ? 'has-error' : '' }}">
                            <label for="address3" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Taluk</div>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="address3" name="address3"
                                       value="{{ $institute->address3 }}"

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('postoffice') ? 'has-error' : '' }}">
                            <label for="postoffice" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Post office</div>
                            </label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="postoffice" name="postoffice"
                                       value="{{ $institute->postoffice }}"

                                       @if($institute->edit_status == '1') disabled @endif
                                >
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('landmark') ? 'has-error' : '' }}">
                            <label for="landmark" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Landmark</div>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="landmark" name="landmark"
                                       value="{{ $institute->landmark }}"

                                       @if($institute->edit_status == '1') disabled @endif
                                >
                            </div>
                        </div>


                        <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                            <label for="city" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">District and State</div>
                            </label>
                            <div class="col-sm-3">
                                <select class="form-control" name="city" @if($institute->edit_status == '1') disabled @endif>
                                    @if(is_null($institute))
                                        <option value="-">-- Select District and State --</option>
                                        @foreach($cities as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}, {{ $c->state->state_name }} </option>
                                        @endforeach
                                    @else
                                        <option value="-">-- Select District and State --</option>
                                        @foreach($cities as $c)
                                            <option value="{{ $c->id }}"
                                                    @if($institute->city_id == $c->id)
                                                    selected
                                                    @endif
                                            >
                                                {{ $c->name }}, {{ $c->state->state_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('pincode') ? 'has-error' : '' }}">
                            <label for="pincode" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Pincode</div>
                            </label>
                            <div class="col-sm-1">
                                <input type="number" class="form-control" id="pincode" name="pincode"
                                       value="{{ $institute->pincode }}"

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('contactnumber1') ? 'has-error' : '' }}">
                            <label for="contactnumber1" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Contact Number</div>
                            </label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="contactnumber1" name="contactnumber1"
                                       value="{{ $institute->contactnumber1 }}"

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                            <div class="col-sm-5">
                                (Please enter Institute's official contact number)
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('contactnumber2') ? 'has-error' : '' }}">
                            <label for="contactnumber2" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Alternate Number</div>
                            </label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="contactnumber2" name="contactnumber2"
                                       value="{{ $institute->contactnumber2 }}"

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                            <div class="col-sm-5">
                                (optional) (Please enter Institute's official alternate contact number)
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Email</div>
                            </label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ $institute->email }}"

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                            <div class="col-sm-5">
                                (Please enter Institute's official email to contact)
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('website') ? 'has-error' : '' }}">
                            <label for="website" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Website</div>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="website" name="website"
                                       value="{{ $institute->website }}"

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                            <div class="col-sm-5">
                                (optional) (Please enter Institute's official website)
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('faxno') ? 'has-error' : '' }}">
                            <label for="faxno" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Fax Number</div>
                            </label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="faxno" name="faxno"
                                       value="{{ $institute->faxno }}"

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                            <div class="col-sm-5">
                                (optional)
                            </div>
                        </div>

                        <h4>
                            <i class="fa fa-arrow-right"> </i> <u>Head of Institute</u>
                        </h4>
                        <hr />


                        <div class="form-group {{ $errors->has('headname') ? 'has-error' : '' }}">
                            <label for="headname" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Name</div>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="headname" name="headname"
                                       @if(is_null($instituteheads))
                                       value=""
                                       @else
                                       value="{{ $instituteheads->name }}"
                                       @endif

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('headdesignation') ? 'has-error' : '' }}">
                            <label for="headdesignation" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Designation</div>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="headdesignation" name="headdesignation"
                                       @if(is_null($instituteheads))
                                       value=""
                                       @else
                                       value="{{ $instituteheads->designation }}"
                                       @endif

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('headqualification') ? 'has-error' : '' }}">
                            <label for="headqualification" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Qualification</div>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="headqualification" name="headqualification"
                                       @if(is_null($instituteheads))
                                       value=""
                                       @else
                                       value="{{ $instituteheads->qualification }}"
                                       @endif

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('headrcino') ? 'has-error' : '' }}">
                            <label for="headrcino" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">RCI Reg. No</div>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="headrcino" name="headrcino"
                                       @if(is_null($instituteheads))
                                       value=""
                                       @else
                                       value="{{ $instituteheads->rci_reg_no }}"
                                       @endif

                                       @if($institute->edit_status == '1') disabled @endif
                                >
                            </div>
                            <div class="col-sm-5">
                                (optional)
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('heademail') ? 'has-error' : '' }}">
                            <label for="heademail" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Email</div>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="heademail" name="heademail"
                                       @if(is_null($instituteheads))
                                       value=""
                                       @else
                                       value="{{ $instituteheads->email }}"
                                       @endif

                                       @if($institute->edit_status == '1') disabled @endif
                                >
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('headcontactnumber1') ? 'has-error' : '' }}">
                            <label for="headcontactnumber1" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Contact Number</div>
                            </label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="headcontactnumber1" name="headcontactnumber1"
                                       @if(is_null($instituteheads))
                                       value=""
                                       @else
                                       value="{{ $instituteheads->contactnumber1 }}"
                                       @endif

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('headcontactnumber2') ? 'has-error' : '' }}">
                            <label for="headcontactnumber2" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Alternate Number</div>
                            </label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="headcontactnumber2" name="headcontactnumber2"
                                       @if(is_null($instituteheads))
                                       value=""
                                       @else
                                       value="{{ $instituteheads->contactnumber2 }}"
                                       @endif

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                            <div class="col-sm-5">
                                (optional)
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('headfaxno') ? 'has-error' : '' }}">
                            <label for="headfaxno" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Fax Number</div>
                            </label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="headfaxno" name="headfaxno"
                                       @if(is_null($instituteheads))
                                       value=""
                                       @else
                                       value="{{ $instituteheads->faxno }}"
                                       @endif

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                            <div class="col-sm-5">
                                (optional)
                            </div>
                        </div>

                        <h4>
                            <i class="fa fa-arrow-right"> </i> <u>Institute Facilities</u>
                        </h4>
                        <hr />

                        <div class="form-group {{ $errors->has('buildup_area') ? 'has-error' : '' }}">
                            <label for="buildup_area" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Buildup Area</div>
                            </label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="buildup_area" name="buildup_area"
                                       @if(is_null($institutefacility))
                                       value=""
                                       @else
                                       value="{{ $institutefacility->buildup_area }}"
                                       @endif

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                            <div class="col-sm-5">
                                (in square feet)
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('landarea') ? 'has-error' : '' }}">
                            <label for="landarea" class="control-label col-sm-1">
                                <div class="" style="text-align: left !important;">Land Area</div>
                            </label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="landarea" name="landarea"
                                       @if(is_null($institutefacility))
                                       value=""
                                       @else
                                       value="{{ $institutefacility->landarea }}"
                                       @endif

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                            <div class="col-sm-5">
                                (in square feet)
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('city_distance') ? 'has-error' : '' }}">
                            <label for="city_distance" class="control-label col-sm-3">
                                <div class="" style="text-align: left !important;">Distance from the city (bus stand / railway station)</div>
                            </label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="city_distance" name="city_distance"
                                       @if(is_null($institutefacility))
                                       value=""
                                       @else
                                       value="{{ $institutefacility->city_distance }}"
                                       @endif

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                            <div class="col-sm-5">
                                (in km)
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('postoffice_distance') ? 'has-error' : '' }}">
                            <label for="postoffice_distance" class="control-label col-sm-3">
                                <div class="" style="text-align: left !important;">Distance from the nearest Head Post office</div>
                            </label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="postoffice_distance" name="postoffice_distance"
                                       @if(is_null($institutefacility))
                                       value=""
                                       @else
                                       value="{{ $institutefacility->postoffice_distance }}"
                                       @endif

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                            <div class="col-sm-5">
                                (in km)
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('available_rooms') ? 'has-error' : '' }}">
                            <label for="available_rooms" class="control-label col-sm-3">
                                <div class="" style="text-align: left !important;">Number of rooms in your Institute</div>
                            </label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="available_rooms" name="available_rooms"
                                       @if(is_null($institutefacility))
                                       value=""
                                       @else
                                       value="{{ $institutefacility->available_rooms }}"
                                       @endif

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                            <div class="col-sm-5">
                                (in numbers)
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('classroom_size') ? 'has-error' : '' }}">
                            <label for="classroom_size" class="control-label col-sm-3">
                                <div class="" style="text-align: left !important;">Size of the Classrooms</div>
                            </label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="classroom_size" name="classroom_size"
                                       @if(is_null($institutefacility))
                                       value=""
                                       @else
                                       value="{{ $institutefacility->classroom_size }}"
                                       @endif

                                       @if($institute->edit_status == '1') disabled @endif
                                />
                            </div>
                            <div class="col-sm-5">
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('biometric_facility') ? 'has-error' : '' }}">
                            <label for="biometric_facility" class="control-label col-sm-3">
                                <div class="" style="text-align: left !important;">Is Biometric facility available in your institute ?</div>
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" name="biometric_facility" @if($institute->edit_status == '1') disabled @endif>
                                    @if(is_null($institutefacility))
                                        <option value="-">-- Select an option --</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    @else
                                        <option value="-">-- Select an option --</option>
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

                        <div class="form-group {{ $errors->has('cctv_facility') ? 'has-error' : '' }}">
                            <label for="cctv_facility" class="control-label col-sm-3">
                                <div class="" style="text-align: left !important;">Is CCTV facility available in your institute ?</div>
                            </label>
                            <div class="col-sm-2">
                                <select class="form-control" name="cctv_facility" @if($institute->edit_status == '1') disabled @endif>
                                    @if(is_null($institutefacility))
                                        <option value="-">-- Select an option --</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    @else
                                        <option value="-">-- Select an option --</option>
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

                        <div class="form-group">
                            <div class="col-sm-5">
                                <button type="submit"
                                        @if($institute->edit_status == '1')
                                        disabled
                                        class="btn btn-default"
                                        @else
                                        class="btn btn-primary"
                                        @endif
                                >
                                    Submit
                                </button>
                            </div>
                        </div>

                    </form>

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