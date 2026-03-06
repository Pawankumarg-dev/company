@extends('layouts.app')
@section('content')
    <form class="form-horizontal" action="{{ url('/nber/theoryexams/examcenters/addexamcenterdetails') }}" method="POST"
          onsubmit="return validateForm()"
          role="form">
        {{ csrf_field() }}

        <input type="hidden" name="exam_id" value="{{ $exam->id }}" />

        <main>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{ $exam->name }} Examinations
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
                                                <li class="active">Add Exam Center</li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="panel-group">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        Add New Exam Center
                                                    </div>
                                                </div>

                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Code :</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control blue-text" name="code" id="code"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Password :</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control blue-text" name="password" id="password"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Name :</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control blue-text" name="name" id="name"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Address :</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control blue-text" name="address" id="address"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">District :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control blue-text" name="district" id="district"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">State :</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control blue-text" name="state" id="state">
                                                                <option value="0" selected>-- Select State --</option>
                                                                @foreach($states as $state)
                                                                    <option value="{{ $state->state_name }}">{{ strtoupper($state->state_name) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Pincode :</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control blue-text" name="pincode" id="pincode" maxlength="6"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Zone :</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control blue-text" name="zone_id" id="zone_id">
                                                                <option value="0" selected>-- Select Zone --</option>
                                                                @foreach($zones as $zone)
                                                                    <option value="{{ $zone->id }}">{{ strtoupper($zone->code) }} - {{ strtoupper($zone->name) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Contact No.# :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control blue-text" name="contactnumber1" id="contactnumber1"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Contact No.2# :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control blue-text" name="contactnumber2" id="contactnumber2"/>
                                                            (optional)
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Email# :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control blue-text" name="email1" id="email1"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Email2# :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control blue-text" name="email2" id="email2"/>
                                                            (optional)
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-10 col-sm-offset-2">
                                                            <button class="btn btn-primary" type="submit">Submit</button>
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
        </main>
    </form>

    <script>
        $(document).ready(function () {
            $('#code').keyup(function () {
                $(this).val($(this).val().toUpperCase());
            });

            $('#pincode').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });
        });

        function validateForm() {
            if(!$('#code').val()) {
                swal("Error Occurred!!!", "Please enter the Exam Center Code", "error");
                return false;
            }
            else {
                if(ajaxrequest_checkexamcentercode() == true) {
                    swal("Error Occurred!!!", "The Exam center Code is already exists.", "error");
                    return false;
                }
                else {
                    $('#code').val($.trim($('#code').val()));
                    if(!$('#name').val()) {
                        swal("Error Occurred!!!", "Please enter the Exam Center Name", "error");
                        return false;
                    }
                    else {
                        $('#name').val($.trim($('#name').val()));
                    }

                    if(!$('#address').val()) {
                        swal("Error Occurred!!!", "Please enter the Exam Center Name", "error");
                        return false;
                    }
                    else {
                        $('#address').val($.trim($('#address').val()));
                    }

                    if(!$('#district').val()) {
                        swal("Error Occurred!!!", "Please enter the District", "error");
                        return false;
                    }
                    else {
                        $('#district').val($.trim($('#district').val()));
                    }

                    if($('#state').val() == '0') {
                        swal("Error Occurred!!!", "Please select the State from the option", "error");
                        return false;
                    }

                    if(!$('#pincode').val()) {
                        swal("Error Occurred!!!", "Please enter the Pincode", "error");
                        return false;
                    }
                    else if($('#pincode').val().length != '6') {
                        swal("Error Occurred!!!", "Please enter the 6 digits Pincode", "error");
                        return false;
                    }
                    else {
                        $('#pincode').val($.trim($('#pincode').val()));
                    }

                    if($('#zone_id').val() == '0') {
                        swal("Error Occurred!!!", "Please select the Zone from the option", "error");
                        return false;
                    }

                    if(!$('#contactnumber1').val()) {
                        swal("Error Occurred!!!", "Please enter the contact number1", "error");
                        return false;
                    }
                    else {
                        $('#email1').val($.trim($('#email1').val()));
                    }

                    if($('#contactnumber2').val() == ''){
                        $('#contactnumber2').val('');
                    }
                    else {
                        $('#contactnumber2').val($.trim($('#contactnumber2').val()));
                    }

                    if(!$('#email1').val()) {
                        swal("Error Occurred!!!", "Please enter the Email", "error");
                        return false;
                    }

                    if($('#email2').val() == '') {
                        $('#email2').val('');
                    }
                    else{
                        $('#email2').val($.trim($('#email2').val()));
                    }
                }
            }

        }

        function ajaxrequest_checkexamcentercode() {
            var returnVal = false;
            $.ajax({
                async: false,
                type: "GET",
                url: "{{ url('/nber/theoryexams/examcenters/ajaxrequest/checkexamcentercode') }}?code=" + $('#code').val(),
                success: function (datafound) {
                    if (datafound == true) {
                        returnVal = true;
                    } else {
                        returnVal = false;
                    }
                }
            });
            return returnVal;
        }
    </script>
@endsection
