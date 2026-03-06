@extends('layouts.app')
@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{ $examcenter->code }} - {{ $examcenter->name }}
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li>
                                                    <a href="{{ url('/nber/exams') }}">Exams</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/nber/theoryexams/'.$exam->id) }}">{{ $exam->name }} Theory</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/nber/theoryexams/examcenters/'.$exam->id) }}">Exam Centers</a>
                                                </li>
                                                <li class="active">{{ $examcenter->code }}</li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-info">
                                            <div class="panel-body">
                                                <div class="panel panel-warning">
                                                    <div class="panel-heading">
                                                        <div class="panel-title">
                                                            Edit Exam Center Details
                                                        </div>
                                                    </div>

                                                    <div class="panel-body">
                                                        <form class="form-horizontal" action="{{ url('/nber/theoryexams/examcenters/editexamcenterdetails') }}" method="POST"
                                                              onsubmit="return validateForm()" role="form">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="exam_id" value="{{ $exam->id }}" />
                                                            <input type="hidden" name="examcenter_id" value="{{ $examcenter->id }}" />

                                                            <div class="form-group">
                                                                <div class="text-left blue-text col-sm-3">
                                                                    <label for="gender" class="control-label">
                                                                        Exam Centre Code :
                                                                        <span class="red-text">*</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <input type="text" class="form-control blue-text" name="code" id="code" value="{{ $examcenter->code }}" />
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="text-left blue-text col-sm-3">
                                                                    <label for="gender" class="control-label">
                                                                        Exam Center Password :
                                                                        <span class="red-text">(optional)</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input type="text" class="form-control blue-text" name="password" id="password" value="{{ $examcenter->password }}" />
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="text-left blue-text col-sm-3">
                                                                    <label for="gender" class="control-label">
                                                                        Exam Center Name :
                                                                        <span class="red-text">*</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control blue-text" name="name" id="name" value="{{ $examcenter->name }}" />
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="text-left blue-text col-sm-3">
                                                                    <label for="gender" class="control-label">
                                                                        Address :
                                                                        <span class="red-text">*</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control blue-text" name="address" id="address" value="{{ $examcenter->address }}" />
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="text-left blue-text col-sm-3">
                                                                    <label for="gender" class="control-label">
                                                                        District :
                                                                        <span class="red-text">*</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control blue-text" name="district" id="district" value="{{ $examcenter->district }}" />
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="text-left blue-text col-sm-3">
                                                                    <label for="gender" class="control-label">
                                                                        State :
                                                                        <span class="red-text">*</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <select class="form-control blue-text" name="state" id="state">
                                                                        @foreach($states as $state)
                                                                            <option value="{{ $state->state_name }}" @if($examcenter->state == $state->state_name) selected @endif>{{ strtoupper($state->state_name) }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="text-left blue-text col-sm-3">
                                                                    <label for="gender" class="control-label">
                                                                        Pincode :
                                                                        <span class="red-text">*</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <input type="text" class="form-control blue-text" name="pincode" id="pincode" maxlength="6" value="{{ $examcenter->pincode }}" />
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="text-left blue-text col-sm-3">
                                                                    <label for="gender" class="control-label">
                                                                        Zone :
                                                                        <span class="red-text">*</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <select class="form-control blue-text" name="zone_id" id="zone_id">
                                                                        @foreach($zones as $zone)
                                                                            <option value="{{ $zone->id }}" @if($examcenter->zone_id == $zone->id) selected @endif>{{ strtoupper($zone->code) }} - {{ strtoupper($zone->name) }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="text-left blue-text col-sm-3">
                                                                    <label for="gender" class="control-label">
                                                                        Contact No. 1# :
                                                                        <span class="red-text">*</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control blue-text" name="contactnumber1" id="contactnumber1" value="{{ $examcenter->contactnumber1 }}" />
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="text-left blue-text col-sm-3">
                                                                    <label for="gender" class="control-label">
                                                                        Contact No. 2# :
                                                                        <span class="red-text">(optional)</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control blue-text" name="contactnumber2" id="contactnumber2" value="{{ $examcenter->contactnumber2 }}" />
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="text-left blue-text col-sm-3">
                                                                    <label for="gender" class="control-label">
                                                                        Email 1# :
                                                                        <span class="red-text">*</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control blue-text" name="email1" id="email1" value="{{ $examcenter->email1 }}" />
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="text-left blue-text col-sm-3">
                                                                    <label for="gender" class="control-label">
                                                                        Email 2# :
                                                                        <span class="red-text">(optional)</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control blue-text" name="email2" id="email2" value="{{ $examcenter->email2 }}" />
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="text-left blue-text col-sm-3">
                                                                    <label for="gender" class="control-label">
                                                                        Active Status
                                                                        <span class="red-text">*</span>
                                                                    </label>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <label class="radio-inline">
                                                                        <input type="radio" name="active_status" id="active_status1" value="0" @if($examcenter->active_status == 0) checked @endif><span id="gender-label1" class="label label-danger">Not Active</span>
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input type="radio" name="active_status" id="active_status2" value="1" @if($examcenter->active_status == 1) checked @endif><span id="gender-label2" class="label label-success">Active</span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-sm-10 col-sm-offset-3">
                                                                    <button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-ok-sign"></span>&nbsp;Submit</button>
                                                                    <button class="btn btn-danger btn-sm" type="reset"><span class="glyphicon glyphicon-remove-sign"></span>&nbsp;Reset</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function(){
            //stop typing anything other than numbers for contact number2#
            $('#pincode').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

            //stop typing anything other than numbers for contact number1#
            $('#contactnumber1').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

            //stop typing anything other than numbers for contact number2#
            $('#contactnumber2').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });
        });

        function validateForm() {
            if($('#code').val() == "") {
                swal("Error Occurred!!!", "Please enter the Exam Center Code", "error");
                return false;
            }

            if($('#name').val() == "") {
                swal("Error Occurred!!!", "Please enter the Exam Center Name", "error");
                return false;
            }

            if($('#address').val() == "") {
                swal("Error Occurred!!!", "Please enter the Exam Center Address", "error");
                return false;
            }

            if($('#district').val() == "") {
                swal("Error Occurred!!!", "Please enter the Exam Center District", "error");
                return false;
            }

            if($('#district').val() == "") {
                swal("Error Occurred!!!", "Please enter the Exam Center District", "error");
                return false;
            }

            if($('#contactnumber1').val() == "") {
                swal("Error Occurred!!!", "Please enter the Contact Number 1#", "error");
                return false;
            }

            if($('#email1').val() == "") {
                swal("Error Occurred!!!", "Please enter the Email 1#", "error");
                return false;
            }

            if(!$('input[name="active_status"]').is(':checked')) {
                swal("Error Occurred!!!", "Please select the Active Status", "error");
                return false;
            }
        }
    </script>
@endsection