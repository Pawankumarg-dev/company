@extends('layouts.app')
<style>
    .upper-text {
        text-transform:uppercase;
    }
</style>

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('institute/coursecoordinators')}}">Course Coordinators</a></li>
                    <li>Add Course Coordinator</li>
                </ul>
            </div>
        </div>
    </div>

    <form name="coursecoordinatorform" id="coursecoordinatorform" class="form-horizontal" role="form" method="POST"
          action="{{url('/institute/coursecoordinators/save')}}" autocomplete="off" accept-charset="UTF-8">
        {{ csrf_field() }}
        <input type="hidden" name="institute_id" id="institute_id" value="{{ $institute->id }}">
        <input type="hidden" name="salutation_id" id="salutation_id" value="0">
        <input type="hidden" name="languageselectcount" id="languageselectcount" value="0">


        <div class="container">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel-group">

                            {{-- Display of Institute's Details--}}
                            <div class="panel panel-info">
                                <div class="panel-heading"><div class="blue-text center-text large-text">Institute's Details</div></div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label col-sm-1 medium-text">Code :</label>
                                        <div class="col-sm-1">
                                            <label class="control-label blue-text medium-text">{{ strtoupper($institute->code) }}</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-1 medium-text">Name :</label>
                                        <div class="col-sm-11">
                                            <label class="control-label blue-text medium-text">{{ strtoupper($institute->name) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ./Display of Institute's Details--}}

                            {{-- Display of Course Coordinator's Personal Details--}}
                            <div class="panel panel-info">
                                <div class="panel-heading"><div class="blue-text center-text large-text">Course Coordinator's Personal Details</div></div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="title_id">Select the Title<span class="red-text large-text">*</span>:</label>

                                        <div class="col-sm-2">
                                            <select class="form-control blue-text medium-text" name="title_id" id="title_id">
                                                <option value="0" selected>Select</option>
                                                <option value="1">Dr.</option>
                                                <option value="2">Mr.</option>
                                                <option value="3">Mrs.</option>
                                                <option value="4">Ms.</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="name">Enter Name<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-7">
                                                    <input type="text" name="name" id="name" class="form-control blue-text upper-text medium-text"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="relationtype_id">Select the Relation Type<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-2">
                                            <select class="form-control blue-text medium-text" name="relationtype_id" id="relationtype_id">
                                                <option value="0" selected>Select</option>
                                                @foreach($relationtypes as $relationtype)
                                                    <option value="{{ $relationtype->id }}">{{ $relationtype->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    --}}

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="relationtype_id">Select the Relation Type<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <select class="form-control blue-text medium-text" name="relationtype_id" id="relationtype_id">
                                                        <option value="0" selected>Select</option>
                                                        @foreach($relationtypes as $relationtype)
                                                            <option value="{{ $relationtype->id }}">{{ $relationtype->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-9">
                                                    <label id="label_relationtype" class="control-label red-text medium-text">(Father/Mother/Husband/Guardian) of the Course Coordinator</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="relationname">Enter the Relation's Name<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-7">
                                                    <input type="text" name="relationname" id="relationname" class="form-control blue-text upper-text medium-text"/>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label id="label_relationname" class="control-label red-text medium-text"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="dob">Select the Date of Birth<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class='input-group date' id='dob_datetimepicker'>
                                                        <input type='text' name="dob" id="dob" class="form-control blue-text medium-text" placeholder="Choose Date"/>
                                                        <div class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </div>

                                                        <script type="text/javascript">
                                                            $(function () {
                                                                $('#dob_datetimepicker').datetimepicker({
                                                                    format: 'DD-MM-YYYY',
                                                                    maxDate: 'now'
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="gender_id">Select the Gender<span class="red-text large-text">*</span>:</label>

                                        <div class="col-sm-6">
                                            <label class="radio-inline">
                                                <input type="radio" name="gender_id" id="gender_id1" value="1"><span id="gender_label1" class="label label-default medium-text">Male</span>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="gender_id" id="gender_id2" value="2"><span id="gender_label2" class="label label-default medium-text">Female</span>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="gender_id" id="gender_id3" value="3"><span id="gender_label3" class="label label-default medium-text">Third Gender</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="disability_status">Are you a person with benchmark disability?<span class="red-text large-text">*</span>:</label>

                                        <div class="col-sm-6">
                                            <label class="radio-inline">
                                                <input type="radio" name="disability_status" id="disability_status1" value="Yes"><span id="disability_label1" class="label label-default medium-text">Yes</span>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="disability_status" id="disability_status2" value="No"><span id="disability_label2" class="label label-default medium-text">No</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="disability_type">Enter the type of disability:</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="disability_type" id="disability_type" class="form-control blue-text upper-text medium-text"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="disabilitycertificate_number">Enter the Disability Certificate Number:</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="disabilitycertificate_number" id="disabilitycertificate_number" class="form-control blue-text upper-text medium-text"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="aadhaarcard_number">Enter the Aadhaar Card number<span class="red-text large-text">*</span>:</label>

                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input type="text" name="aadhaarcard_number" id="aadhaarcard_number" class="form-control blue-text upper-text medium-text" maxlength="12">
                                                </div>
                                                <div class="col-sm-8">
                                                    <label class="control-label red-text medium-text">(12 digits)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-10">
                                            <button type="button" id="validate_button1">Validate Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ./Display of Course Coordinator's Personal Details--}}

                            {{-- Display of Course Coordinator's Communication Details--}}
                            <div class="panel panel-info">
                                <div class="panel-heading"><div class="blue-text center-text large-text">Course Coordinator's Communication Details</div></div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="mobile_number1">Enter your working mobile number<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input type="text" name="mobile_number1" id="mobile_number1" class="form-control blue-text upper-text medium-text" maxlength="10" />
                                                </div>
                                                <div class="col-sm-8">
                                                    <label class="control-label red-text medium-text">(10 digits)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="confirm_mobile_number2">Do you have alternate working mobile number?<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-7">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="confirm_mobile_number2" id="confirm_mobile_number2_1" value="Yes"><span id="confirm_label1" class="label label-default medium-text">Yes</span>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="confirm_mobile_number2" id="confirm_mobile_number2_2" value="No"><span id="confirm_label2" class="label label-default medium-text">No</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="mobile_number2">Enter your alternate working mobile number:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input type="text" name="mobile_number2" id="mobile_number2" class="form-control blue-text upper-text medium-text" maxlength="10" />

                                                </div>
                                                <div class="col-sm-8">
                                                    <label class="control-label red-text medium-text">(10 digits)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="whatsapp_number">Enter your whatsapp number<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control blue-text upper-text medium-text" maxlength="10" />
                                                </div>
                                                <div class="col-sm-8">
                                                    <label class="control-label red-text medium-text">(10 digits)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="email_address1">Enter your email address<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <input type="email" name="email_address1" id="email_address1" class="form-control blue-text upper-text medium-text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="confirm_email_address2">Do you have alternate email address?<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-7">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="confirm_email_address2" id="confirm_email_address2_1" value="Yes"><span id="confirm_label1" class="label label-default medium-text">Yes</span>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="confirm_email_address2" id="confirm_email_address2_2" value="No"><span id="confirm_label2" class="label label-default medium-text">No</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="email_address2">Enter your alternate email address:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <input type="email" name="email_address2" id="email_address2" class="form-control blue-text upper-text medium-text"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="address">Enter your at present address<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <input type="text" name="address" id="address" class="form-control blue-text upper-text medium-text" />
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="control-label red-text medium-text">(without State/District/Pincode)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="state_id">Select the State<span class="red-text large-text">*</span>:</label>

                                        <div class="col-sm-4">
                                            <select class="form-control blue-text medium-text" name="state_id" id="state_id">
                                                <option value="0" selected>Select</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}">{{ strtoupper($state->state_name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="city_id">Select the District<span class="red-text large-text">*</span>:</label>

                                        <div class="col-sm-4">
                                            <select class="form-control blue-text medium-text" name="city_id" id="city_id">
                                                <option value="0" selected>Select</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="pincode">Enter the Pincode<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input type="text" name="pincode" id="pincode" class="form-control blue-text upper-text medium-text" maxlength="6" />
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="control-label red-text medium-text">(6 digits)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-10">
                                            <button type="button" id="validate_button2">Validate Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ./Display of Course Coordinator's Communication Details--}}

                            {{-- Display of Course Coordinator's Registration Number Details--}}
                            <div class="panel panel-info">
                                <div class="panel-heading"><div class="blue-text center-text large-text">Course Coordinator's Registration Number Details</div></div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="coursecoordinatorcoursetype_id">Select the Registration No. Issuing Council<span class="red-text large-text">*</span>:</label>

                                        <div class="col-sm-4">
                                            <select class="form-control blue-text medium-text" name="coursecoordinatorcoursetype_id" id="coursecoordinatorcoursetype_id">
                                                <option value="0" selected>Select</option>
                                                @foreach($coursecoordinatorcoursetypes as $coursecoordinatorcoursetype)
                                                    <option value="{{ $coursecoordinatorcoursetype->id }}">{{ strtoupper($coursecoordinatorcoursetype->council_name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="registration_number">Enter your Registration No.<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <input type="text" name="registration_number" id="registration_number" class="form-control blue-text upper-text medium-text">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label id="label_registration_number" class="control-label red-text medium-text"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="registration_year">Select the year of Registration<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class='input-group date' id='registration_year_datetimepicker'>
                                                        <input type='text' name="registration_year" id="registration_year" class="form-control blue-text medium-text" placeholder="Choose Year"/>
                                                        <div class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </div>

                                                        <script type="text/javascript">
                                                            $(function () {
                                                                $('#registration_year_datetimepicker').datetimepicker({
                                                                    format: 'YYYY',
                                                                    maxDate: 'now'
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="expiration_year">Select the year of Expiration<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class='input-group date' id='expiration_year_datetimepicker'>
                                                        <input type='text' name="expiration_year" id="expiration_year" class="form-control blue-text medium-text" placeholder="Choose Year"/>
                                                        <div class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </div>

                                                        <script type="text/javascript">
                                                            $(function () {
                                                                $('#expiration_year_datetimepicker').datetimepicker({
                                                                    format: 'YYYY'
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-10">
                                            <button type="button" id="validate_button3">Validate Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ./Display of Course Coordinator's Registration Number Details--}}

                            {{-- Display of Course Coordinator's Educational Qualification Details--}}
                            <div class="panel panel-info">
                                <div class="panel-heading"><div class="blue-text center-text large-text">Course Coordinator's Educational Qualification Details</div></div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="tempcourse_mode">Select the Course Mode<span class="red-text large-text">*</span>:</label>

                                        <div class="col-sm-2">
                                            <select class="form-control blue-text medium-text" name="tempcourse_mode" id="tempcourse_mode">
                                                <option value="0" selected>Select</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="tempcourse_id">Select the Course Name<span class="red-text large-text">*</span>:</label>

                                        <div class="col-sm-8">
                                            <select class="form-control blue-text medium-text" name="tempcourse_id" id="tempcourse_id">
                                                <option value="0" selected>Select</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="tempcourse_completion_year">Select the year of completion of course<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class='input-group date' id='tempcourse_completion_year_datetimepicker'>
                                                        <input type='text' name="tempcourse_completion_year" id="tempcourse_completion_year" class="form-control blue-text medium-text" placeholder="Choose Year"/>
                                                        <div class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </div>

                                                        <script type="text/javascript">
                                                            $(function () {
                                                                $('#tempcourse_completion_year_datetimepicker').datetimepicker({
                                                                    format: 'YYYY',
                                                                    maxDate: 'now'
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="tempcourse_institute_name">Enter the Name of the Institute studied<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <input type="text" name="tempcourse_institute_name" id="tempcourse_institute_name" class="form-control blue-text upper-text medium-text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="tempcourse_institute_state">Select the State of the Institute located<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-4">
                                            <select class="form-control blue-text medium-text" name="tempcourse_institute_state" id="tempcourse_institute_state">
                                                <option value="0" selected>Select</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}">{{ strtoupper($state->state_name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-10">
                                            <button type="button" id="add_button1" class="btn btn-default" disabled>Add Details</button>
                                            <button type="button" id="add_button2" class="btn btn-default" disabled>Click here to Add Educational Qualifications Details</button>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="qualification_table" class="table table-bordered" role="table">
                                            <tr>
                                                <th width="5%">S.No.</th>
                                                <th width="10%">Course Mode</th>
                                                <th width="30%">Course Name</th>
                                                <th>Institute</th>
                                                <th width="5%">Year of Completion</th>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-10">
                                            <button type="button" id="validate_button4">Validate Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ./Display of Course Coordinator's Educational Qualification Details--}}

                            {{-- Display of Course Coordinator's Present Working Experience Details--}}
                            <div class="panel panel-info">
                                <div class="panel-heading"><div class="blue-text center-text large-text">Course Coordinator's Present Working Experience Details</div></div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text">Present Working Institute/Organization:</label>
                                        <div class="col-sm-8">
                                            <label class="control-label blue-text medium-text left-text">{{ strtoupper($institute->name) }}, {{ strtoupper($institute->city->state->state_name) }}</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text">Designation:</label>
                                        <div class="col-sm-4">
                                            <label class="control-label blue-text medium-text">Course Coordinator</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="present_programme_id">Select the Course<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-3">
                                            <select class="form-control blue-text medium-text" name="present_programme_id" id="present_programme_id">
                                                <option value="0" selected>Select</option>
                                                @foreach($programmes as $programme)
                                                    <option value="{{ $programme->id }}">{{ $programme->course_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="present_joining_date">Select the date of Joining<span class="red-text large-text">*</span>:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class='input-group date' id='present_joining_date_datetimepicker'>
                                                        <input type='text' name="present_joining_date" id="present_joining_date" class="form-control blue-text medium-text" placeholder="Choose Date"/>
                                                        <div class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </div>

                                                        <script type="text/javascript">
                                                            $(function () {
                                                                $('#present_joining_date_datetimepicker').datetimepicker({
                                                                    format: 'DD-MM-YYYY',
                                                                    maxDate: 'now'
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-10">
                                            <button type="button" id="validate_button5">Validate Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ./Display of Course Coordinator's Present Working Experience Details--}}

                            {{-- Display of Course Coordinator's Past Teaching Work Experience Details--}}
                            <div class="panel panel-info">
                                <div class="panel-heading"><div class="blue-text center-text large-text">Course Coordinator's Past Teaching Work Experience Details</div></div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="confirm_pastexperience">Do you have Past Teaching Work Experience?<span class="red-text large-text">*</span>:</label>

                                        <div class="col-sm-6">
                                            <label class="radio-inline">
                                                <input type="radio" name="confirm_pastexperience" id="confirm_pastexperience1" value="Yes"><span id="pastexperience_label1" class="label label-default medium-text">Yes</span>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="confirm_pastexperience" id="confirm_pastexperience2" value="No"><span id="pastexperience_label2" class="label label-default medium-text">No</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="temppast_designation">Select the Designation:</label>
                                        <div class="col-sm-3">
                                            <select class="form-control blue-text medium-text" name="temppast_designation" id="temppast_designation">
                                                <option value="0" selected>Select</option>
                                                <option value="Course Coordinator">Course Coordinator</option>
                                                <option value="Course Faculty">Course Faculty</option>
                                                <option value="Special Educator">Special Educator</option>
                                                <option value="Special Teacher">Special Teacher</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="temppast_institute_name">Enter the Name of the Institute worked:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <input type="text" name="temppast_institute_name" id="temppast_institute_name" class="form-control blue-text upper-text medium-text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="temppast_institute_state">Select the State of the Institute worked:</label>
                                        <div class="col-sm-4">
                                            <select class="form-control blue-text medium-text" name="temppast_institute_state" id="temppast_institute_state">
                                                <option value="0" selected>Select</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}">{{ strtoupper($state->state_name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="temppast_joining_date">Select the date of Joining:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class='input-group date' id='temppast_joining_date_datetimepicker'>
                                                        <input type='text' name="temppast_joining_date" id="temppast_joining_date" class="form-control blue-text medium-text" placeholder="Choose Date"/>
                                                        <div class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </div>

                                                        <script type="text/javascript">
                                                            $(function () {
                                                                $('#temppast_joining_date_datetimepicker').datetimepicker({
                                                                    format: 'DD-MM-YYYY',
                                                                    maxDate: 'now'
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4 medium-text" for="temppast_relieving_date">Select the date of Relieving:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class='input-group date' id='temppast_relieving_date_datetimepicker'>
                                                        <input type='text' name="temppast_relieving_date" id="temppast_relieving_date" class="form-control blue-text medium-text" placeholder="Choose Date"/>
                                                        <div class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </div>

                                                        <script type="text/javascript">
                                                            $(function () {
                                                                $('#temppast_relieving_date_datetimepicker').datetimepicker({
                                                                    format: 'DD-MM-YYYY',
                                                                    maxDate: 'now'
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-10">
                                            <button type="button" id="add_button3" class="btn btn-default">Add Details</button>
                                            <button type="button" id="add_button4" class="btn btn-default">Click here to Add Work Experience Details</button>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="past_experience_table" class="table table-bordered" role="table">
                                            <tr>
                                                <th width="4%">S.No.</th>
                                                <th width="41%">Institution</th>
                                                <th width="10%">Designation</th>
                                                <th width="9%">Date of Joining</th>
                                                <th width="9%">Date of Relieving</th>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-10">
                                            <button type="button" id="validate_button6">Validate Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ./Display of Course Coordinator's Past Teaching Work Experience Details--}}

                            {{-- Display of Course Coordinator's Languages Known Details--}}
                            <div class="panel panel-info">
                                <div class="panel-heading"><div class="blue-text center-text large-text">Course Coordinator's Languages known Details</div></div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th width="5%" class="center-text">S.No.</th>
                                                <th>Languages</th>
                                                <th class="center-text">Read</th>
                                                <th class="center-text">Write</th>
                                                <th class="center-text">Speak</th>
                                                <th class="center-text" width="40%">Remarks</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @php $sno = '1'; $count = '0'; @endphp
                                            @foreach($languages as $language)
                                                <tr>
                                                    <td class="center-text">
                                                        <input type="checkbox" name="language_checkbox[]" id="language_checkbox{{$count}}" value="{{$count}}" onclick="enabledisablefield({{$count}})">
                                                        <input type="hidden" name="language_id[]" id="language_id{{$count}}" value="{{$language->id}}">
                                                        <input type="hidden" id="language_name{{$count}}" value="{{$language->language}}">
                                                    </td>
                                                    <td>{{ $language->language }}</td>
                                                    <td class="center-text">
                                                        <input type="checkbox" name="read_checkbox[]" id="read_checkbox{{$count}}" value="0" onclick="updateremarks({{$count}})">
                                                        <input type="hidden" name="read_status[]" id="read_status{{$count}}" value="0">
                                                    </td>
                                                    <td class="center-text">
                                                        <input type="checkbox" name="write_checkbox[]" id="write_checkbox{{$count}}" value="0" onclick="updateremarks({{$count}})">
                                                        <input type="hidden" name="write_status[]" id="write_status{{$count}}" value="0">
                                                    </td>
                                                    <td class="center-text">
                                                        <input type="checkbox" name="speak_checkbox[]" id="speak_checkbox{{$count}}" value="0" onclick="updateremarks({{$count}})">
                                                        <input type="hidden" name="speak_status[]" id="speak_status{{$count}}" value="0">
                                                    </td>
                                                    <td class="center-text">
                                                        <span class="medium-text red-text" id="remarks{{$count}}"></span>
                                                    </td>
                                                </tr>
                                                @php $sno++; $count++; @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-10">
                                            <button type="button" id="validate_button7">Validate Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ./Display of Course Coordinator's Languages Known Details--}}

                            {{-- Display of Head of the Institute's Declaration--}}
                            <div class="panel panel-info">
                                <div class="panel-heading"><div class="blue-text center-text large-text">Head of the Institute's Declaration</div></div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="checkbox-inline"><input type="checkbox" id="confirm_checkbox" onclick="confirmcheckbox()">I, {{strtoupper($institute->institutehead->name)}}, {{strtoupper($institute->institutehead->designation)}}, hereby certify that the above entered information(s) for the Course Coordinator are found to be true/genuine.</label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <button type="submit" id="submit_button1">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ./Display of Head of the Institute's Declaration--}}

                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </form>

    <script>
        function defaultfields() {
            /*Personal Details Fields*/
            $('#name').attr('readonly', true);
            $('#relationtype_id').attr('disabled', true);
            $('#relationname').attr('readonly', true);
            $('#dob').attr('readonly', true);
            $('input[name="gender_id"]').attr('disabled', true);
            $('input[name="disability_status"]').attr('disabled', true);
            $('#disability_type').attr('readonly', true);
            $('#disabilitycertificate_number').attr('readonly', true);
            $('#aadhaarcard_number').attr('readonly', true);
            $('#validate_button1').attr('disabled', true);
            $('#validate_button1').addClass('btn btn-default');

            /*Communication Details Fields*/
            $('#mobile_number1').attr('readonly', true);
            $('input[name="confirm_mobile_number2"]').attr('disabled', true);
            $('#mobile_number2').attr('readonly', true);
            $('#whatsapp_number').attr('readonly', true);
            $('#email_address1').attr('readonly', true);
            $('input[name="confirm_email_address2"]').attr('disabled', true);
            $('#email_address2').attr('readonly', true);
            $('#address').attr('readonly', true);
            $('#state_id').attr('disabled', true);
            $('#city_id').attr('disabled', true);
            $('#pincode').attr('readonly', true);
            $('#validate_button2').attr('disabled', true);
            $('#validate_button2').addClass('btn btn-default');

            /*Registration Number Fields*/
            $('#coursecoordinatorcoursetype_id').attr('disabled', true);
            $('#registration_number').attr('readonly', true);
            $('#registration_year').attr('readonly', true);
            $('#expiration_year').attr('readonly', true);
            $('#validate_button3').attr('disabled', true);
            $('#validate_button3').addClass('btn btn-default');

            /*Educational Qualification Fields*/
            $('#tempcourse_mode').attr('disabled', true);
            $('#tempcourse_id').attr('disabled', true);
            $('#tempcourse_completion_year').attr('readonly', true);
            $('#tempcourse_institute_name').attr('readonly', true);
            $('#tempcourse_institute_state').attr('disabled', true);
            $('#add_button1').attr('disabled', true);
            $('#add_button1').addClass('btn btn-default');
            $('#add_button2').attr('disabled', true);
            $('#add_button2').addClass('btn btn-default');
            $('#validate_button4').attr('disabled', true);
            $('#validate_button4').addClass('btn btn-default');

            /*Present Working Experience Fields*/
            $('#present_programme_id').attr('disabled', true);
            $('#present_joining_date').attr('readonly', true);
            $('#validate_button5').attr('disabled', true);
            $('#validate_button5').addClass('btn btn-default');

            /*Past Teaching Work Experience Fields*/
            $('input[name="confirm_pastexperience"]').attr('disabled', true);
            $('#temppast_designation').attr('disabled', true);
            $('#temppast_institute_name').attr('readonly', true);
            $('#temppast_institute_state').attr('disabled', true);
            $('#temppast_joining_date').attr('readonly', true);
            $('#temppast_relieving_date').attr('readonly', true);
            $('#add_button3').attr('disabled', true);
            $('#add_button3').addClass('btn btn-default');
            $('#add_button4').attr('disabled', true);
            $('#add_button4').addClass('btn btn-default');
            $('#validate_button6').attr('disabled', true);
            $('#validate_button6').addClass('btn btn-default');

            /*Languages known Fields*/
            $('input[name="language_checkbox[]"]').attr('disabled', true);
            $('input[name="read_checkbox[]"]').attr('disabled', true);
            $('input[name="write_checkbox[]"]').attr('disabled', true);
            $('input[name="speak_checkbox[]"]').attr('disabled', true);
            $('#validate_button7').attr('disabled', true);
            $('#validate_button7').addClass('btn btn-default');

            /*HoI Declaration Fields*/
            $('#confirm_checkbox').attr('disabled', true);
            $('#submit_button1').attr('disabled', true);
            $('#submit_button1').addClass('btn btn-default');
        }

        $(document).ready(function(){
            defaultfields();

            $('#title_id').on('change',function(){
                if($('#title_id').val() == '0') {

                    $('#name').val('');
                    $('#name').attr('readonly', true);

                    $('#relationtype_id option[value="0"]').prop('selected', true);
                    $('#relationtype_id').attr('disabled', true);
                    $('#relationname').val('');
                    $('#relationname').attr('readonly', true);
                    $('#label_relationname').text('');

                    $('#dob').val('');
                    $('#dob').attr('readonly', true);

                    $('input[name="gender_id"]').prop('checked', false);
                    $('input[name="gender_id"]').attr('disabled', true);

                    $('input[name="disability_status"]').prop('checked', false);
                    $('input[name="disability_status"]').attr('disabled', true);
                    $('#disability_type').val('');
                    $('#disability_type').attr('readonly', true);
                    $('#disabilitycertificate_number').val('');
                    $('#disabilitycertificate_number').attr('readonly', true);

                    $('#aadhaarcard_number').val('');
                    $('#aadhaarcard_number').attr('readonly', true);

                    $('#validate_button1').attr('disabled', true);
                    $('#validate_button1').removeClass('btn-primary').addClass('btn-default');

                }
                else{
                    $('#name').attr('readonly', false);
                    $('#relationtype_id').attr('disabled', false);
                    $('#dob').attr('readonly', false);
                    $('input[name="gender_id"]').attr('disabled', false);
                    $('input[name="disability_status"]').attr('disabled', false);
                    $('#aadhaarcard_number').attr('readonly', false);

                    $('#validate_button1').attr('disabled', false);
                    $('#validate_button1').removeClass('btn-default').addClass('btn-primary');
                }
            });

            $('#relationtype_id').on('change',function(){
                if($('#relationtype_id').val() == '0') {
                    $('#relationname').val('');
                    $('#label_relationname').text('');
                    $('#relationname').attr('readonly', true);
                }
                else{
                    $('#label_relationname').text('('+$('#relationtype_id option:selected').text()+'\'s Name)');
                    $('#relationname').attr('readonly', false);
                }
            });

            $('input[name="disability_status"]').on('change', function () {
                if($(this).val() == 'Yes') {
                    $("#disability_type").attr('readonly', false);
                    $("#disabilitycertificate_number").attr('readonly', false);
                }
                else {
                    $("#disability_type").val('');
                    $("#disabilitycertificate_number").val('');
                    $("#disability_type").attr('readonly', true);
                    $("#disabilitycertificate_number").attr('readonly', true);
                }
            });

            //stop typing anything other than numbers for aadhaarcard number
            $('#aadhaarcard_number').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

            $('#validate_button1').click(function(e){
                if($('#title_id option:selected').val() == '0') {
                    swal("Error Occurred!!!", "Please select the Title in the Personal Details.", "error");
                    return false;
                }
                if(!$('#name').val()) {
                    swal("Error Occurred!!!", "Please enter the Name in the Personal Details.", "error");
                    return false;
                }
                else {
                    $('#name').val($('#name').val().toUpperCase());
                }
                if($('#relationtype_id option:selected').val() == '0') {
                    swal("Error Occurred!!!", "Please select the Relation Type in the Personal Details.", "error");
                    return false;
                }
                if(!$('#relationname').val()) {
                    swal("Error Occurred!!!", "Please enter the Relation Name in the Personal Details.", "error");
                    return false;
                }
                else {
                    $('#relationname').val($('#relationname').val().toUpperCase());
                }
                if(!$('#dob').val()) {
                    swal("Error Occurred!!!", "Please select the Date of Birth in the Personal Details.", "error");
                    return false;
                }
                if(!$('input[name="gender_id"]:checked').val()) {
                    swal("Error Occurred!!!", "Please select the Gender in the Personal Details.", "error");
                    return false;
                }
                if(!$('input[name="disability_status"]:checked').val()) {
                    swal("Error Occurred!!!", "Please confirm the Disability Status in the Personal Details.", "error");
                    return false;
                }
                if($('input[name="disability_status"]:checked').val() == 'Yes') {
                    if(!$("#disability_type").val()) {
                        swal("Error Occurred!!!", "Please enter the Disability Type in the Personal Details.", "error");
                        return false;
                    }
                    if(!$('#disabilitycertificate_number').val()) {
                        swal("Error Occurred!!!", "Please enter the Disability Certificate Number in the Personal Details.", "error");
                        return false;
                    }
                }
                else {
                    $('#disability_type').val($('#disability_type').val().toUpperCase());
                    $('#disabilitycertificate_number').val($('#disabilitycertificate_number').val().toUpperCase());
                }
                if(!$('#aadhaarcard_number').val()) {
                    swal("Error Occurred!!!", "Please enter the Aadhaar Card Number in the Personal Details.", "error");
                    return false;
                }
                if($('#aadhaarcard_number').val().length != '12') {
                    swal("Error Occurred!!!", "Please enter the 12 digits Aadhaar Card Number in the Personal Details.", "error");
                    $('#aadhaarcard_number').focus();
                    return false;
                }
                if(ajaxrequest_checkaadhaarcardnumber() == true) {
                    return false;
                }

                swal("Thank You!!!", "Your Personal details are validated successfully!", "success");

                if($('#relationtype_id').val() == '4') {
                    $('#salutation_id').val('4');
                }
                else if($('#relationtype_id').val() == '3') {
                    $('#salutation_id').val('3');
                }
                else {
                    if($('input[name="gender_id"]:checked').val() == '1') {
                        $('#salutation_id').val('1');
                    }
                    else {
                        $('#salutation_id').val('2');
                    }
                }

                $('#title_id option:not(:selected)').attr('disabled', true);
                $('#title_id option:not(:selected)').hide();
                $('#name').attr('readonly', true);
                $('#relationtype_id option:not(:selected)').attr('disabled', true);
                $('#relationtype_id option:not(:selected)').hide();
                $('#relationname').attr('readonly', true);
                $('#dob').attr('readonly', true);
                $('#dob').attr('readonly', true);
                $('input[name="gender_id"]:not(:checked)').attr('disabled', true);
                $('input[name="disability_status"]:not(:checked)').attr('disabled', true);
                $("#disability_type").attr('readonly', true);
                $("#disabilitycertificate_number").attr('readonly', true);
                $('#aadhaarcard_number').attr('readonly', true);
                $('#validate_button1').attr('disabled', true);
                $('#validate_button1').removeClass('btn-primary').addClass('btn-default');

                $('#mobile_number1').attr('readonly', false);
                $('input[name="confirm_mobile_number2"]').attr('disabled', false);
                $('#whatsapp_number').attr('readonly', false);
                $('#email_address1').attr('readonly', false);
                $('input[name="confirm_email_address2"]').attr('disabled', false);
                $('#address').attr('readonly', false);
                $('#state_id').attr('disabled', false);
                $('#city_id').attr('disabled', false);
                $('#pincode').attr('readonly', false);
                $('#validate_button2').attr('disabled', false);
                $('#validate_button2').removeClass('btn-default').addClass('btn-primary');
            });

            function ajaxrequest_checkaadhaarcardnumber() {
                var returnVal = false;
                $.ajax({
                    async: false,
                    type:"GET",
                    url:"{{ url('/institute/coursecoordinators/ajaxrequest/checkaadhaarcardnumber') }}?aadhaarcard_number="+$('#aadhaarcard_number').val(),
                    success:function(datafound){

                        if(datafound == true) {
                            swal("Error Occurred!!!", "The Aadhaarcard No. is already exists.", "error");
                            returnVal = true;
                        }
                        else {
                            returnVal = false;
                        }
                    }
                });
                return returnVal;
            }

            //stop typing anything other than numbers for mobile number1
            $('#mobile_number1').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

            $('input[name="confirm_mobile_number2"]').on('change', function (e) {
                if($(this).val() == 'Yes') {
                    $("#mobile_number2").attr('readonly', false);
                }
                else {
                    $('#mobile_number2').val('');
                    $('#mobile_number2').attr('readonly', true);
                }
            });

            //stop typing anything other than numbers for whatsapp number
            $('#whatsapp_number').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

            //stop typing anything other than numbers for mobile number2
            $('#mobile_number2').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

            $('input[name="confirm_email_address2"]').on('change', function (e) {
                if($(this).val() == 'Yes') {
                    $('#email_address2').attr('readonly', false);
                }
                else {
                    $('#email_address2').val('');;
                    $('#email_address2').attr('readonly', true);
                }
            });

            //stop typing anything other than numbers for pincode
            $('#pincode').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

            //to get CityId by selecting States
            $('#state_id').on('change',function(){
                if($(this).val() != '0'){
                    $.ajax({
                        async: false,
                        type:"GET",
                        url:"{{url('/institute/coursecoordinators/ajaxrequest/getcityid')}}?state_id="+$(this).val(),
                        success:function(data){
                            if(data){
                                $("#city_id").empty();
                                $("#city_id").attr('disabled', false);
                                $("#city_id").append('<option value="0">-- Select District --</option>');

                                $.each(data, function () {
                                    $("#city_id").append('<option value="'+this.id+'">'+this.name+'</option>');
                                })

                            }
                            else{
                                $("#city_id").empty();
                            }
                        }
                    });
                }
                else{
                    $("#city_id").attr('disabled', true);
                    $("#city_id").empty();
                }
            });
            
            $('#validate_button2').click(function () {
                if(!$('#mobile_number1').val() || $('#mobile_number1').val().length != '10'){
                    swal("Error Occurred!!!", "Please enter the 10 digits working Mobile Number in the Communication Details.", "error");
                    $('#mobile_number1').focus();
                    return false;
                }
                if(ajaxrequest_checkmobilenumber() == true) {
                    return false;
                }
                if(!$('input[name="confirm_mobile_number2"]:checked').val()) {
                    swal("Error Occurred!!!", "Please confirm the alternate Number status in the Communication Details.", "error");
                    return false;
                }
                if($('input[name="confirm_mobile_number2"]:checked').val() == 'Yes') {
                    if(!$('#mobile_number2').val() || $('#mobile_number2').val().length != '10'){
                        swal("Error Occurred!!!", "Please enter the 10 digits working alternate Mobile Number in the Communication Details.", "error");
                        $('#mobile_number2').focus();
                        return false;
                    }
                    if($('#mobile_number1').val() == $('#mobile_number2').val()) {
                        swal("Error Occurred!!!", "The entered alternate mobile number is same as the main mobile number entered in the Communication Details.", "error");
                        $('#mobile_number2').focus();
                        return false;
                    }
                }
                if(!$('#whatsapp_number').val() || $('#whatsapp_number').val().length != '10'){
                    swal("Error Occurred!!!", "Please enter the 10 digits working whatsapp Number in the Communication Details.", "error");
                    $('#whatsapp_number').focus();
                    return false;
                }
                if(ajaxrequest_whatsappnumber() == true) {
                    return false;
                }
                if(!$('#email_address1').val()) {
                    swal("Error Occurred!!!", "Please enter the valid Email Address in the Communication Details.", "error");
                    $('#email_address1').focus();
                    return false;
                }
                else if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($('#email_address1').val())) {
                    swal("Error Occurred!!!", "Please enter the valid Email Address in the Communication Details.", "error");
                    $('#email_address1').focus();
                    $('#email_address1').val('');
                    return false;
                }
                else {
                    $('#email_address1').val($('#email_address1').val().toUpperCase());
                }
                if(ajaxrequest_emailaddress() == true) {
                    return false;
                }
                if(!$('input[name="confirm_email_address2"]:checked').val()) {
                    swal("Error Occurred!!!", "Please confirm the alternate Email Address status in the Communication Details.", "error");
                    return false;
                }
                if($('input[name="confirm_email_address2"]:checked').val() == 'Yes'){
                    if(!$('#email_address2').val()){
                        swal("Error Occurred!!!", "Please enter the alternate valid Email Address in the Communication Details.", "error");
                        $('#email_address2').focus();
                        return false;
                    }
                    else if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($('#email_address2').val())) {
                        swal("Error Occurred!!!", "Please enter the valid Email Address in the Communication Details.", "error");
                        $('#email_address2').focus();
                        $('#email_address2').val('');
                        return false;
                    }
                    else {
                        $('#email_address2').val($('#email_address2').val().toUpperCase());
                    }

                    if($('#email_address1').val() == $('#email_address2').val()) {
                        swal("Error Occurred!!!", "The entered alternate Email Address is same as the main Email Address entered in the Communication Details.", "error");
                        $('#email_address2').focus();
                        return false;
                    }
                }
                if(!$('#address').val()) {
                    swal("Error Occurred!!!", "Please enter the Address in the Communication Details.", "error");
                    $('#address').focus();
                    return false;
                }
                else {
                    $('#address').val($('#address').val().toUpperCase());
                }
                if($('#state_id').val() == '0') {
                    swal("Error Occurred!!!", "Please select the State in the Communication Details.", "error");
                    return false;
                }
                if($('#city_id').val() == '0') {
                    swal("Error Occurred!!!", "Please select the District in the Communication Details.", "error");
                    return false;
                }
                if(!$('#pincode').val() || $('#pincode').val().length != '6') {
                    swal("Error Occurred!!!", "Please enter the 6 digits valid Pin code in the Communication Details.", "error");
                    return false;
                }

                swal("Thank You!!!", "Your Communication details are validated successfully!", "success");

                $('#mobile_number1').attr('readonly', true);
                $('input[name="confirm_mobile_number2"]:not(:checked)').attr('disabled', true);
                $('#mobile_number2').attr('readonly', true);
                $('#whatsapp_number').attr('readonly', true);
                $('#email_address1').attr('readonly', true);
                $('input[name="confirm_email_address2"]:not(:checked)').attr('disabled', true);
                $('#email_address2').attr('readonly', true);
                $('#address').attr('readonly', true);
                $('#state_id option:not(:selected)').hide();
                $('#city_id option:not(:selected)').attr('disabled', true);
                $('#city_id option:not(:selected)').hide();
                $('#pincode').attr('readonly', true);
                $('#validate_button2').attr('disabled', true);
                $('#validate_button2').removeClass('btn-primary').addClass('btn-default');

                $('#coursecoordinatorcoursetype_id').attr('disabled', false);
            });

            function ajaxrequest_checkmobilenumber() {
                var returnVal = false;
                $.ajax({
                    async: false,
                    type:"GET",
                    url:"{{ url('/institute/coursecoordinators/ajaxrequest/checkmobilenumber') }}?mobile_number1="+$('#mobile_number1').val(),
                    success:function(datafound){

                        if(datafound == true) {
                            swal("Error Occurred!!!", "The entered Mobile Number is already exists.", "error");
                            returnVal = true;
                        }
                        else {
                            returnVal = false;
                        }
                    }
                });
                return returnVal;
            }

            function ajaxrequest_whatsappnumber() {
                var returnVal = false;
                $.ajax({
                    async: false,
                    type:"GET",
                    url:"{{ url('/institute/coursecoordinators/ajaxrequest/checkwhatsappnumber') }}?whatsapp_number="+$('#whatsapp_number').val(),
                    success:function(datafound){

                        if(datafound == true) {
                            swal("Error Occurred!!!", "The entered Whatsapp Number is already exists.", "error");
                            returnVal = true;
                        }
                        else {
                            returnVal = false;
                        }
                    }
                });
                return returnVal;
            }

            function ajaxrequest_emailaddress() {
                var returnVal = false;
                $.ajax({
                    async: false,
                    type:"GET",
                    url:"{{ url('/institute/coursecoordinators/ajaxrequest/checkemailaddress') }}?email_address1="+$('#email_address1').val(),
                    success:function(datafound){

                        if(datafound == true) {
                            swal("Error Occurred!!!", "The entered Email Address is already exists.", "error");
                            returnVal = true;
                        }
                        else {
                            returnVal = false;
                        }
                    }
                });
                return returnVal;
            }

            $('#coursecoordinatorcoursetype_id').on('change',function(){
                if($('#coursecoordinatorcoursetype_id').val() == '0') {
                    $('#registration_number').val('');
                    $('#registration_number').attr('readonly', true);
                    $('#label_registration_number').text('');
                    $('#registration_year').val('');
                    $('#registration_year').attr('readonly', true);
                    $('#expiration_year').val('');
                    $('#expiration_year').attr('readonly', true);
                    $('#tempcourse_mode option[value="0"]').prop('selected', true);
                    $('#tempcourse_mode').attr('disabled', true);
                    $('#tempcourse_id option[value="0"]').prop('selected', true);
                    $('#tempcourse_id').attr('disabled', true);
                    $('#validate_button3').attr('disabled', true);
                    $('#validate_button3').removeClass('btn-primary').addClass('btn-default');
                }
                else{
                    $('#registration_number').val('');
                    $('#registration_number').attr('readonly', false);

                    if($('#coursecoordinatorcoursetype_id').val() == '1') {
                        $('#label_registration_number').text('(RCI\'s CRR No.)');
                    }
                    else {
                        $('#label_registration_number').text('(SNC\'s RN&RM No.)');
                    }

                    if($(this).val() != '0'){
                        $.ajax({
                            async: false,
                            type:"GET",
                            url:"{{url('/institute/coursecoordinators/ajaxrequest/getcoursecoordinatorcoursemode')}}?coursecoordinatorcoursetype_id="+$('#coursecoordinatorcoursetype_id').val(),
                            success:function(data){
                                if(data){
                                    $("#tempcourse_mode").empty();
                                    $("#tempcourse_mode").attr('disabled', true);
                                    $("#tempcourse_mode").append('<option value="0">Select</option>');
                                    $("#tempcourse_id").empty();
                                    $("#tempcourse_id").attr('disabled', true);
                                    $("#tempcourse_id").append('<option value="0">Select</option>');
                                    $.each(data, function () {
                                        $("#tempcourse_mode").append('<option value="'+this.course_mode+'">'+this.course_mode+'</option>');
                                    })
                                }
                                else{
                                    $("#tempcourse_mode").empty();
                                    $("#tempcourse_id").empty();
                                }
                            }
                        });
                    }
                    else{
                        $('#tempcourse_mode').empty();
                        $('#tempcourse_id').empty();
                        $('#tempcourse_mode').attr('disabled', true);
                    }

                    $('#registration_year').val('');
                    $('#registration_year').attr('readonly', false);
                    $('#expiration_year').val('');
                    $('#expiration_year').attr('readonly', false);
                    $('#validate_button3').attr('disabled', false);
                    $('#validate_button3').removeClass('btn-default').addClass('btn-primary');
                }
            });

            $('#validate_button3').click(function () {
                if(!$('#registration_number').val()) {
                    swal("Error Occurred!!!", "Please enter the Registration Number in the Registration Number Details.", "error");
                    $('#registration_number').focus();
                    return false;
                }
                else {
                    $('#registration_number').val($('#registration_number').val().toUpperCase());
                }
                if(ajaxrequest_registrationnumber() == true) {
                    return false;
                }

                if(!$('#registration_year').val()) {
                    swal("Error Occurred!!!", "Please enter the Registration Year in the Registration Number Details.", "error");
                    $('#registration_year').focus();
                    return false;
                }

                if(!$('#expiration_year').val()) {
                    swal("Error Occurred!!!", "Please enter the Expiration Year in the Registration Number Details.", "error");
                    $('#expiration_year').focus();
                    return false;
                }

                if($('#registration_year').val() == $('#expiration_year').val()) {
                    swal("Error Occurred!!!", "Registration year and Expiration Year of the Registration Number cannot be same", "error");
                    $('#expiration_year').focus();
                    $('#expiration_year').val('');
                    return false;
                }
                if($('#registration_year').val() > $('#expiration_year').val()) {
                    swal("Error Occurred!!!", "Expiration year cannot be lesser than Registration Year of the Registration Number", "error");
                    $('#expiration_year').focus();
                    $('#expiration_year').val('');
                    return false;
                }

                swal("Thank You!!!", "Your Registration Number details are validated successfully!", "success");

                $('#coursecoordinatorcoursetype_id option:not(:selected)').attr('disabled', true);
                $('#coursecoordinatorcoursetype_id option:not(:selected)').hide();
                $('#registration_number').attr('readonly', true);
                $('#registration_year').attr('readonly', true);
                $('#expiration_year').attr('readonly', true);
                $('#validate_button3').attr('disabled', true);
                $('#validate_button3').removeClass('btn-primary').addClass('btn-default');

                $('#tempcourse_mode').attr('disabled', false);
            });

            function ajaxrequest_registrationnumber() {
                var returnVal = false;
                $.ajax({
                    async: false,
                    type:"GET",
                    url:"{{ url('/institute/coursecoordinators/ajaxrequest/registrationnumber') }}?registration_number="+$('#registration_number').val(),
                    success:function(datafound){

                        if(datafound == true) {
                            swal("Error Occurred!!!", "The entered Registration Number is already exists.", "error");
                            returnVal = true;
                        }
                        else {
                            returnVal = false;
                        }
                    }
                });
                return returnVal;
            }

            $('#tempcourse_mode').on('change',function(){
                if($(this).val() != '0'){
                    $.ajax({
                        async: false,
                        type:"GET",
                        url:"{{url('/institute/coursecoordinators/ajaxrequest/getcoursecoordinatorcourseid')}}?coursecoordinatorcoursetype_id="+$('#coursecoordinatorcoursetype_id').val()+"&course_mode="+$('#tempcourse_mode option:selected').text(),
                        success:function(data){
                            if(data){
                                $('#tempcourse_id').empty();
                                $('#tempcourse_id').attr('disabled', false);
                                $('#tempcourse_id').append('<option value="0">Select</option>');

                                $.each(data, function () {
                                    $('#tempcourse_id').append('<option value="'+this.id+'">'+this.course_name+'</option>');
                                })
                            }
                            else{
                                $('#tempcourse_id').empty();
                            }
                        }
                    });
                }
                else{
                    $("#tempcourse_id").empty();
                    $("#tempcourse_id").attr('disabled', true);
                    $("#tempcourse_id").append('<option value="0">Select</option>');
                    $("#tempcourse_completion_year").val('');
                    $("#tempcourse_completion_year").attr('readonly', true);
                    $("#tempcourse_institute_name").val('');
                    $("#tempcourse_institute_name").attr('readonly', true);
                    $("#tempcourse_institute_state option[value='0']").prop('selected', true);
                    $("#tempcourse_institute_state").attr('disabled', true);
                    $('#add_button1').attr('disabled', true);
                    $('#add_button1').removeClass('btn-primary').addClass('btn-default');
                }
            });

            $('#tempcourse_id').on('change',function(){
                if($(this).val() != '0'){
                    $('#tempcourse_completion_year').attr('readonly', false);
                    $('#tempcourse_institute_name').attr('readonly', false);
                    $("#tempcourse_institute_state").attr('disabled', false);
                    $('#add_button1').attr('disabled', false);
                    $('#add_button1').removeClass('btn-default').addClass('btn-primary');
                }
                else{
                    $("#tempcourse_completion_year").val('');
                    $("#tempcourse_completion_year").attr('readonly', true);
                    $("#tempcourse_institute_name").val('');
                    $("#tempcourse_institute_name").attr('readonly', true);
                    $("#tempcourse_institute_state option[value='0']").prop('selected', true);
                    $("#tempcourse_institute_state").attr('disabled', true);
                    $('#add_button1').attr('disabled', true);
                    $('#add_button1').removeClass('btn-primary').addClass('btn-default');
                }
            });
            
            $('#add_button1').click(function () {
                if($('#tempcourse_mode').val() == '0') {
                    swal("Error Occurred!!!", "Please select the Course Mode in the Educational Qualification Details.", "error");
                    return false;
                }
                if($('#tempcourse_id').val() == '0') {
                    swal("Error Occurred!!!", "Please select the Course Name in the Educational Qualification Details.", "error");
                    return false;
                }
                if(!$('#tempcourse_completion_year').val()) {
                    swal("Error Occurred!!!", "Please select the Course Completion Year in the Educational Qualification Details.", "error");
                    return false;
                }
                if(!$('#tempcourse_institute_name').val()) {
                    swal("Error Occurred!!!", "Please enter the Name of the Institute studied in the Educational Qualification Details.", "error");
                    return false;
                }
                else {
                    $('#tempcourse_institute_name').val($('#tempcourse_institute_name').val().toUpperCase())
                }
                if($('#tempcourse_institute_state').val() == '0') {
                    swal("Error Occurred!!!", "Please select the State of the Institute studied in the Educational Qualification Details.", "error");
                    return false;
                }

                var html = '';
                var hiddentype = '';
                var length = parseInt($('#qualification_table tr').length);
                length--;
                html += '<tr>';
                html += '<td>'+$('#qualification_table tr').length+'</td>';
                html += '<td>'+$('#tempcourse_mode option:selected').text()+'</td>';
                hiddentype += '<input type="hidden" name="coursecoordinatorcourse_count[]" value="'+length+'">';
                hiddentype += '<input type="hidden" name="coursecoordinatorcourse_id[]" id="coursecoordinatorcourse_id'+length+'" value="'+$('#tempcourse_id').val()+'">';
                hiddentype += '<input type="hidden" name="course_institute_name[]" id="course_institute_name'+length+'" value="'+$('#tempcourse_institute_name').val()+'">';
                hiddentype += '<input type="hidden" name="course_institute_stateid[]" id="course_institute_stateid'+length+'" value="'+$('#tempcourse_institute_state').val()+'">';
                hiddentype += '<input type="hidden" name="course_completion_year[]" id="course_completion_year'+length+'" value="'+$('#tempcourse_completion_year').val()+'">';
                $('#coursecoordinatorform').append(hiddentype);
                html += '<td>'+$('#tempcourse_id option:selected').text()+'</td>';
                html += '<td>'+$('#tempcourse_institute_name').val()+', '+$('#tempcourse_institute_state option:selected').text()+'</td>';
                html += '<td>'+$('#tempcourse_completion_year').val()+'</td>';
                html += '</tr>';
                $('#qualification_table').append(html);

                swal("Thank You!!!", "Your Educational Qualification details are added successfully!", "success");

                $("#tempcourse_mode").attr('disabled', true);
                $("#tempcourse_mode option[value='0']").prop('selected', true);
                $("#tempcourse_id").val('0').change();
                $("#tempcourse_id").attr('disabled', true);
                $("#tempcourse_completion_year").val('');
                $("#tempcourse_completion_year").attr('readonly', true);
                $("#tempcourse_institute_name").val('');
                $("#tempcourse_institute_name").attr('readonly', true);
                $("#tempcourse_institute_state option[value='0']").prop('selected', true);
                $("#tempcourse_institute_state").attr('disabled', true);
                $('#add_button1').attr('disabled', true);
                $('#add_button1').removeClass('btn-primary').addClass('btn-default');
                $('#add_button2').attr('disabled', false);
                $('#add_button2').removeClass('btn-primary').addClass('btn-success');
                $('#validate_button4').attr('disabled', false);
                $('#validate_button4').removeClass('btn-default').addClass('btn-primary');
            });

            $('#add_button2').click(function (){
                $("#tempcourse_mode").attr('disabled', false);
                $('#add_button2').attr('disabled', true);
                $('#add_button2').removeClass('btn-success').addClass('btn-default');
            });

            $('#validate_button4').click(function (){
                $('#tempcourse_mode').val('0').change();
                $("#tempcourse_mode").attr('disabled', true);
                /*
                $('#tempcourse_id').val('0').change();
                $("#tempcourse_id").attr('disabled', true);
                $('#tempcourse_completion_year').val();
                $('#tempcourse_institute_name').val();
                $('#tempcourse_institute_state').val();
                */

                swal("Thank You!!!", "Your Educational Qualification details are validated successfully!", "success");

                $('#add_button2').attr('disabled', true);
                $('#add_button2').removeClass('btn-success').addClass('btn-default');
                $('#validate_button4').attr('disabled', true);
                $('#validate_button4').removeClass('btn-primary').addClass('btn-default');

                $('#present_programme_id').attr('disabled', false);
            });

            $('#present_programme_id').on('change', function(){
                if($(this).val() != '0'){
                    $('#present_joining_date').attr('readonly', false);
                    $('#validate_button5').attr('disabled', false);
                    $('#validate_button5').removeClass('btn-default').addClass('btn-primary');
                }
                else{
                    $('#present_joining_date').val('');
                    $('#present_joining_date').attr('readonly', true);
                    $('#validate_button5').attr('disabled', true);
                    $('#validate_button5').removeClass('btn-primary').addClass('btn-default');
                }
            });

            $('#validate_button5').click(function () {
                if(!$('#present_joining_date').val()) {
                    swal("Error Occurred!!!", "Please select the Date of Joining in the Present Working Experience Details.", "error");
                    return false;
                }

                swal("Thank You!!!", "Your Present Working Experience details are validated successfully!", "success");

                $('#present_programme_id option:not(:selected)').attr("disabled", true);
                $('#present_programme_id option:not(:selected)').hide();
                $('#present_joining_date').attr('readonly', true);
                $('#validate_button5').attr('disabled', true);
                $('#validate_button5').removeClass('btn-primary').addClass('btn-default');

                $('input[name="confirm_pastexperience"]').attr('disabled', false);
            });

            $('input[name="confirm_pastexperience"]').on('change', function() {

               if($(this).val() == 'No') {
                   $('#temppast_designation').val('0').change();
                   $('#temppast_designation').attr('disabled', true);
                   $('#validate_button6').attr('disabled', false);
                   $('#validate_button6').removeClass('btn-default').addClass('btn-primary');
               }
               else {
                   $('#temppast_designation').attr('disabled', false);
                   $('#temppast_designation').val('0').change();
               }
            });

            $('#temppast_designation').on('change',function(){
                if($(this).val() != '0'){
                    $('#temppast_institute_name').attr('readonly', false);
                    $('#temppast_institute_name').attr('disabled', false);
                    $('#temppast_institute_state').attr('disabled', false);
                    $('#temppast_institute_state option:not(:selected)').attr("disabled", false);
                    $('#temppast_institute_state option:not(:selected)').show();
                    $('#temppast_joining_date').attr('readonly', false);
                    $('#temppast_relieving_date').attr('readonly', false);
                    $('#add_button3').attr('disabled', false);
                    $('#add_button3').removeClass('btn-default').addClass('btn-primary');
                }
                else{
                    $('#temppast_institute_name').val('');
                    $('#temppast_institute_name').attr('readonly', true);
                    $('#temppast_institute_state').val('0').change();
                    $('#temppast_institute_state').attr('disabled', true);
                    $('#temppast_joining_date').val('');
                    $('#temppast_joining_date').attr('readonly', true);
                    $('#temppast_relieving_date').val('');
                    $('#temppast_relieving_date').attr('readonly', true);
                    $('#add_button3').attr('disabled', true);
                    $('#add_button3').removeClass('btn-primary').addClass('btn-default');
                }
            });

            $('#add_button3').click(function () {
                    var join_date = moment($('#temppast_joining_date').val(), ["DD-MM-YYYY"], true).format("YYYY-MM-DD");
                    var releave_date = moment($('#temppast_relieving_date').val(), ["DD-MM-YYYY"], true).format("YYYY-MM-DD");

                    if (!$('#temppast_institute_name').val()) {
                        swal("Error Occurred!!!", "Please enter the Name of the Institute/Organisation worked in the Past Teaching Work Experience Details.", "error");
                        return false;
                    } else {
                        $('#temppast_institute_name').val($('#temppast_institute_name').val().toUpperCase());
                    }
                    if ($('#temppast_institute_state').val() == '0') {
                        swal("Error Occurred!!!", "Please select the State of the Institute/Organisation worked in the Past Teaching Work Experience Details.", "error");
                        return false;
                    }
                    if (!$('#temppast_joining_date').val()) {
                        swal("Error Occurred!!!", "Please select the Select the date of Joining in the Past Teaching Work Experience Details.", "error");
                        return false;
                    } else if (!$('#temppast_relieving_date').val()) {
                        swal("Error Occurred!!!", "Please select the Select the date of Relieving in the Past Teaching Work Experience Details.", "error");
                        return false;
                    } else {
                        var join_date = moment($('#temppast_joining_date').val(), ["DD-MM-YYYY"], true).format("YYYY-MM-DD");
                        var releave_date = moment($('#temppast_relieving_date').val(), ["DD-MM-YYYY"], true).format("YYYY-MM-DD");

                        if (moment(moment(join_date)).isSame(moment(releave_date)) == true) {
                            swal("Error Occurred!!!", "Joining Date and Relieving Date cannot be same", "error");
                            $('#temppast_relieving_date').val('');
                            return false;
                        }
                        if (moment(moment(join_date)).isBefore(moment(releave_date)) == false) {
                            swal("Error Occurred!!!", "Relieving Date cannot exceed Joining Date", "error");
                            $('#temppast_relieving_date').val('');
                            return false;
                        }
                    }

                    var html = '';
                    var hiddentype = '';
                    var length = parseInt($('#past_experience_table tr').length);
                    length--;
                    html += '<tr>';
                    html += '<td>' + $('#past_experience_table tr').length + '</td>';
                    html += '<td>' + $('#temppast_institute_name').val() + ', ' + $('#temppast_institute_state option:selected').text() + '</td>';
                    html += '<td>' + $('#temppast_designation').val() + '</td>';
                    html += '<td>' + $('#temppast_joining_date').val() + '</td>';
                    html += '<td>' + $('#temppast_relieving_date').val() + '</td>';
                    html += '</tr>';
                    $('#past_experience_table').append(html);

                    hiddentype += '<input type="hidden" name="past_count[]" value="' + length + '">';
                    hiddentype += '<input type="hidden" name="past_designation[]" id="past_designation' + length + '" value="' + $('#temppast_designation').val() + '">';
                    hiddentype += '<input type="hidden" name="past_institute_name[]" id="past_institute_name' + length + '" value="' + $('#temppast_institute_name').val() + '">';
                    hiddentype += '<input type="hidden" name="past_institute_state[]" id="past_institute_state' + length + '" value="' + $('#temppast_institute_state').val() + '">';
                    hiddentype += '<input type="hidden" name="past_joining_date[]" id="past_joining_date' + length + '" value="' + $('#temppast_joining_date').val() + '">';
                    hiddentype += '<input type="hidden" name="past_relieving_date[]" id="past_relieving_date' + length + '" value="' + $('#temppast_relieving_date').val() + '">';
                    $('#coursecoordinatorform').append(hiddentype);

                swal("Thank You!!!", "Your Past Teaching Work Experience details are added successfully!", "success");

                $('input[name="confirm_pastexperience"]:not(:checked)').attr('disabled', true);
                $("#temppast_designation option[value='0']").prop('selected', true);
                $('#temppast_designation option:not(:selected)').attr("disabled", true);
                $('#temppast_designation option:not(:selected)').hide();
                $('#temppast_institute_name').val('');
                $('#temppast_institute_name').attr('readonly', true);
                $("#temppast_institute_state option[value='0']").prop('selected', true);
                $('#temppast_institute_state option:not(:selected)').attr("disabled", true);
                $('#temppast_institute_state option:not(:selected)').hide();
                $('#temppast_joining_date').val('');
                $('#temppast_joining_date').attr('readonly', true);
                $('#temppast_relieving_date').val('');
                $('#temppast_relieving_date').attr('readonly', true);
                $('#add_button3').attr('disabled', true);
                $('#add_button3').removeClass('btn-primary').addClass('btn-default');
                $('#add_button4').attr('disabled', false);
                $('#add_button4').removeClass('btn-default').addClass('btn-success');
                $('#validate_button6').attr('disabled', false);
                $('#validate_button6').removeClass('btn-default').addClass('btn-primary');
            });

            $('#add_button4').click(function (){
                $('#temppast_designation option:not(:selected)').attr("disabled", false);
                $('#temppast_designation option:not(:selected)').show();
                $('#add_button4').attr('disabled', true);
                $('#add_button4').removeClass('btn-success').addClass('btn-default');
            });

            $('#validate_button6').click(function (){

                $("#temppast_designation").val('0').change();
                $("#temppast_designation").attr('disabled', true);

                $('input[name="confirm_pastexperience"]:not(:checked)').attr('disabled', true);
                swal("Thank You!!!", "Your Past Teaching Work Experience details are validated successfully!", "success");

                $('#add_button3').attr('disabled', true);
                $('#add_button3').removeClass().addClass('btn btn-default');
                $('#add_button4').attr('disabled', true);
                $('#add_button4').removeClass('btn-success').addClass('btn-default');
                $('#validate_button6').attr('disabled', true);
                $('#validate_button6').removeClass('btn-primary').addClass('btn-default');

                $('input[name="language_checkbox[]"]').attr('disabled', false);
                $('#validate_button7').attr('disabled', false);
                $('#validate_button7').removeClass('btn-default').addClass('btn-primary');
            });

            $('#validate_button7').click(function () {
                var count = 0;

                for(var i=0; i<"{{$sno}}"; i++) {
                    if($('#language_checkbox'+i).prop("checked") == true){
                        if($('#read_checkbox'+i).prop("checked") == true || $('#write_checkbox'+i).prop("checked") == true || $('#speak_checkbox'+i).prop("checked") == true) {
                            count++;
                        }
                        else {
                            swal("Error Occurred!!!", "Please select atleast any one option of Read/Write/Speak in the "+$('#language_name'+i).val()+" language", "error");
                            return false;
                        }
                    }
                }
                if(count == 0) {
                    swal("Error Occurred!!!", "Please select atleast any one Language shown in the Languages known Details.", "error");
                    return false;
                }
                var html = '';
                for(var i=0; i<"{{$sno}}"; i++) {
                    if($('#language_checkbox'+i).prop("checked") == true) {
                        var el = '<input type="hidden" name="language_count[]" value="'+i+'">';
                        $('#coursecoordinatorform').append(el);
                    }

                    $('#language_checkbox'+i).attr('disabled', true);
                    $('#read_checkbox'+i).attr('disabled', true);
                    $('#write_checkbox'+i).attr('disabled', true);
                    $('#speak_checkbox'+i).attr('disabled', true);
                }

                $('#validate_button7').attr('disabled', true);
                $('#validate_button7').removeClass("btn-primary").addClass("btn-default");
                $('#confirm_checkbox').attr('disabled', false);

                swal("Thank You!!!", "The Language known details are validated successfully!", "success");
            });
        });

        function enabledisablefield(count) {
            if($('#language_checkbox'+count).prop("checked") == true) {
                $('#remarks'+count).text($('#language_name'+count).val()+' is Selected.');
                $('#read_checkbox'+count).attr('disabled', false);
                $('#write_checkbox'+count).attr('disabled', false);
                $('#speak_checkbox'+count).attr('disabled', false);
            }
            else {
                $('#remarks'+count).text('');
                $('#read_checkbox'+count).prop("checked", false);
                $('#read_checkbox'+count).attr('disabled', true);
                $('#write_checkbox'+count).prop("checked", false);
                $('#write_checkbox'+count).attr('disabled', true);
                $('#speak_checkbox'+count).prop("checked", false);
                $('#speak_checkbox'+count).attr('disabled', true);
            }
        }

        function updateremarks(count) {
            var remarks = '';

            if($('#read_checkbox'+count).is(":checked")) {
                remarks += 'Read';
                $('#read_status'+count).val('1');
            }
            else {
                $('#read_status'+count).val('0');
            }
            if($('#write_checkbox'+count).is(":checked")) {
                if($('#read_status'+count).val() == '1') {
                    remarks +=', ';
                }

                $('#write_status'+count).val('1');
                remarks += 'Write';
            }
            else {
                $('#write_status'+count).val('0');
            }
            if($('#speak_checkbox'+count).is(":checked")) {
                if($('#read_status'+count).val() == '1' || $('#write_status'+count).val() == '1') {
                    remarks +=', ';
                }

                $('#speak_status'+count).val('1');
                remarks += 'Speak';
            }
            else {
                $('#speak_status'+count).val('0');
            }
            $('#remarks'+count).text(remarks);
        }

        function confirmcheckbox() {
            if($('#confirm_checkbox').prop("checked") == true) {
                $('#submit_button1').attr('disabled', false);
                $('#submit_button1').removeClass("btn-default").addClass("btn-primary");
            }
            else {
                $('#submit_button1').attr('disabled', true);
                $('#submit_button1').removeClass("btn-primary").addClass("btn-default");
            }
        }

    </script>
@endsection
