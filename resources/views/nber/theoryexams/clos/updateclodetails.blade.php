@extends('layouts.app')
@section('content')
    <form class="form-horizontal" action="{{ url('/nber/theoryexams/clo/updateclodetails') }}" method="POST"
          onsubmit="return validateForm()"
          role="form">
        {{ csrf_field() }}

        <input type="hidden" name="exam_id" value="{{ $exam->id }}" />
        <input type="hidden" name="user_id" value="{{ $user_id }}" />
        <input type="hidden" name="clo_id" value="{{ $clo->id }}" />

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
                                                    <a href="{{ url('/nber/theoryexams/clo/'.$exam->id) }}">CLO</a>
                                                </li>
                                                <li class="active">Update CLO details</li>
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
                                                        Update CLO details
                                                    </div>
                                                </div>

                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Nodal Officer :</label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control blue-text" name="nodalofficer_id" id="nodalofficer_id">
                                                                <option value="0" selected>-- Select Option --</option>
                                                                @foreach($nodalofficers as $nodalofficer)
                                                                    <option value="{{ $nodalofficer->id }}" @if($nodalofficer->id == $clo->nodalofficer_id) selected @endif>{{ $nodalofficer->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Exam Center Code :</label>
                                                        <div class="col-sm-2">
                                                            <select class="form-control blue-text" name="externalexamcenter_id" id="externalexamcenter_id">
                                                                <option value="0" selected>-- Select Option --</option>
                                                                @foreach($externalexamcenters as $externalexamcenter)
                                                                    <option value="{{ $externalexamcenter->id }}" @if($externalexamcenter->id == $clo->externalexamcenter_id) selected @endif>{{ $externalexamcenter->code }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Title :</label>
                                                        <div class="col-sm-2">
                                                            <select class="form-control blue-text" name="title_id" id="title_id">
                                                                <option value="0" selected>-- Select Option --</option>
                                                                @foreach($titles as $title)
                                                                    <option value="{{ $title->id }}" @if($title->id == $clo->title_id) selected @endif>{{ $title->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Code :</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control blue-text" name="code" id="code" value="{{ $clo->code }}"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Password :</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control blue-text" name="password" id="password" value="{{ $clo->password }}"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Name :</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control blue-text" name="name" id="name" value="{{ $clo->name }}"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Contact No.# :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control blue-text" name="contactnumber1" id="contactnumber1" value="{{ $clo->contactnumber1 }}"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Contact No.2# :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control blue-text" name="contactnumber2" id="contactnumber2" value="{{ $clo->contactnumber2 }}"/>
                                                            (optional)
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Email# :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control blue-text" name="email1" id="email1" value="{{ $clo->email1 }}"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Email2# :</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control blue-text" name="email2" id="email2" value="{{ $clo->email2 }}"/>
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

            $('#contactnumber1').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

            $('#contactnumber2').keypress(function (e) {
                //if the letter is not digit, then stop type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });
        });

        function validateForm() {
            if($('#nodalofficer_id').val() == '0') {
                swal("Error Occurred!!!", "Please select the Nodal Officer from the option", "error");
                return false;
            }

            if($('#externalexamcenter_id').val() == '0') {
                swal("Error Occurred!!!", "Please select the Exam Center Code from the option", "error");
                return false;
            }

            if($('#title_id').val() == '0') {
                swal("Error Occurred!!!", "Please select the Title from the option", "error");
                return false;
            }

            if(!$('#name').val()) {
                swal("Error Occurred!!!", "Please enter the CLO name", "error");
                return false;
            }
            else {
                $('#name').val($.trim($('#name').val()));
            }

            if($('#contactnumber1').val().length != '10') {
                swal("Error Occurred!!!", "Please enter the 10 digits Contact number1", "error");
                $('#contactnumber1').focus();
                return false;
            }

            if(!$('#contactnumber1').val()) {
                swal("Error Occurred!!!", "Please enter the contact number1", "error");
                return false;
            }
            else {
                $('#contactnumber1').val($.trim($('#contactnumber1').val()));
            }

            if($('#contactnumber2').val() == ''){
                $('#contactnumber2').val('');
            }
            else {
                if($('#contactnumber2').val().length != '10') {
                    swal("Error Occurred!!!", "Please enter the 10 digits Contact number2", "error");
                    $('#contactnumber2').focus();
                    return false;
                }

                $('#contactnumber2').val($.trim($('#contactnumber2').val()));
            }

            if(!$('#email1').val()) {
                swal("Error Occurred!!!", "Please enter the Email1", "error");
                return false;
            }
            else {
                $('#email1').val($.trim($('#email1').val()));
            }

            if($('#email2').val() == '') {
                $('#email2').val('');
            }
            else{
                $('#email2').val($.trim($('#email2').val()));
            }
        }
    </script>
@endsection

