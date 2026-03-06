@extends('layouts.app')
@section('content')

    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title">

                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="hidethis">
                                        <ul class="breadcrumb">
                                            <li class="heading">Quick Links: </li>
                                            <li><a href="{{ url('/nber/tracking/documentcorrection/') }}">Tracking</a></li>
                                            <li class="active">Add New</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <form class="form-horizontal">
                                            {{ csrf_field() }}
                                                <div class="form-group">
                                                    <label for="payment_required" class="control-label col-sm-2">
                                                        <div class="left-text">
                                                            Enrolment Number
                                                        </div>
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="enrolmentnumber" name="enrolmentnumber"
                                                                       placeholder="Enrolment No." maxlength="10" value="" />
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <button type="button" class="btn btn-primary" onclick="getcandidatedetails()">Search</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div id="loadingStatusPanel" class="panel panel-default" style="display: none">
                                        <div class="panel-body center-text">
                                            <img src="{{ asset('/images/processing.gif') }}" width="120" height="120"/>
                                        </div>
                                    </div>

                                    <form class="form-horizontal" role="form" method="POST"
                                          autocomplete="off" accept-charset="UTF-8"
                                          action="{{url('/nber/tracking/documentcorrection/adddetails/')}}" onsubmit="return validateform()">
                                        {{ csrf_field() }}

                                        <div id="loadDataPanel" class="panel panel-default" style="display: none">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" role="table">
                                                        <thead>
                                                        <tr>
                                                            <td width="15%">Enrolment No</td>
                                                            <td width="85%">
                                                                <input type="hidden" id="candidate_id" name="candidate_id">
                                                                <span id="candidateenrolmentnodata"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="15%">Name</td>
                                                            <td width="85%">
                                                                <span id="candidatenamedata"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="15%">Father's Name</td>
                                                            <td width="85%">
                                                                <span id="candidatefathernamedata"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="15%">Date of Birth</td>
                                                            <td width="85%">
                                                                <span id="candidatedobdata"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="15%">Email</td>
                                                            <td width="85%">
                                                                <span id="candidateemaildata"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="15%">Contact Number</td>
                                                            <td width="85%">
                                                                <div class="col-sm-2">
                                                                    <div class="row">
                                                                        <input type="text" class="form-control" id="candidatecontactnumberdata" name="candidatecontactnumberdata" />
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="15%">Course</td>
                                                            <td width="85%">
                                                                <span id="candidatecoursedata"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="15%">Institute</td>
                                                            <td width="85%">
                                                                <span id="candidateinstitutedata"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="15%">Subject</td>
                                                            <td width="85%">
                                                                <div class="col-sm-12">
                                                                    <div class="row">
                                                                        <input type="text" class="form-control" id="subject" name="subject" />
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <button type="submit" class="btn btn-primary">
                                                                    Submit
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>
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
    </main>

    <script>
    function getcandidatedetails() {
        var enrolmentnumber = $('#enrolmentnumber').val();
        var token = "{{ csrf_token() }}";

        if(enrolmentnumber == '') {
            alert('Please enter the enrolmentno');

        }
        else {
            $.ajax({
                url: "{{ url('/nber/tracking/ajaxrequest/getcandidatedetails') }}",
                type: "POST",
                dataType: "JSON",
                data: {_token: token, enrolmentnumber: enrolmentnumber},
                beforeSend:function() {
                    $("#loadingStatusPanel").show();
                    $('#loadDataPanel').hide();
                },
                success:function(data) {
                    if(data != 0) {
                        $('#candidate_id').val(data.candidate_id);
                        $('#candidatenamedata').html(data.candidate_name);
                        $('#candidateenrolmentnodata').html(data.candidate_enrolmentno);
                        $('#candidatefathernamedata').html(data.candidate_fathername);
                        $('#candidatedobdata').html(data.candidate_dob);
                        $('#candidateemaildata').html(data.candidate_email);
                        $('#candidatecontactnumberdata').val(data.candidate_contactnumber);
                        $('#candidatecoursedata').html(data.candidate_course);
                        $('#candidateinstitutedata').html(data.candidate_institutecode+" - "+data.candidate_institutename);
                    }
                    else {
                        alert("Please enter the valid Enrolment No.");
                    }
                },
                complete:function() {
                    $("#loadingStatusPanel").hide();
                    $('#loadDataPanel').show();
                }
            });
        }
    }

    function validateform() {
        if($('#candidatecontactnumberdata').val() == "") {
            return false;
        }
        if($('#subject').val() == "") {
            alert("Please enter Subject");
            return false;
        }
    }
    </script>

@endsection
