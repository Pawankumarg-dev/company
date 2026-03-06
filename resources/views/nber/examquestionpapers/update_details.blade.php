@extends('layouts.app')

@section('content')
    @if(Session::has('message'))
        <input type="hidden" id="message" value="{{ Session::get('message') }}" />
        <script>
            swal($("#message").val(), "Updated Successfully!!!", "success")
        </script>
    @endif

    <section class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{ $exam->name }} Examinations - Question Papers
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
                                                    <a href="{{ url('/nber/examquestionpapers/'.$exam->id) }}">Question Papers</a>
                                                </li>
                                                <li class="active">{{ isset($subject) ? $subject->scode : "" }}

                                                </li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-info">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="panel panel-info">
                                                            <div class="panel-heading">
                                                                <div class="panel-title">
                                                                    Exam Question Paper
                                                                    {{ isset($examtimetable->startdate) ? "(".$examtimetable->startdate->format("d-m-Y").")" : "" }}
                                                                </div>
                                                            </div>

                                                            <div class="panel-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover table-bordered table-condensed">
                                                                        <tr>
                                                                            <th class="left-text brown-text bold-text" width="10%">Course</th>
                                                                            <th class="center-text brown-text bold-text" width="5%">Start Time</th>
                                                                            <th class="center-text brown-text bold-text" width="5%">End Time</th>
                                                                            <th class="center-text brown-text bold-text" width="5%">Exam Duration</th>
                                                                            <th class="center-text brown-text bold-text" width="5%">Subject Code</th>
                                                                            <th class="left-text brown-text bold-text" width="25%">Subject Name</th>
                                                                            <th class="center-text brown-text bold-text" width="10%">Password</th>
                                                                            <th class="center-text brown-text bold-text" width="10%">Question Paper</th>
                                                                        </tr>

                                                                        <tr>
                                                                            <td class="left-text blue-text bold-text">{{ isset($subject) ? $subject->programme->course_name : "" }}</td>
                                                                            <td class="center-text blue-text bold-text">{{ $examtimetable->startdate->format('h:i A') }}</td>
                                                                            <td class="center-text blue-text bold-text">{{ $examtimetable->enddate->format('h:i A') }}</td>
                                                                            <td class="center-text blue-text bold-text">
                                                                                @php
                                                                                    $startdatetime = new DateTime(($examtimetable->startdate));
                                                                                    $enddatetime = new DateTime(($examtimetable->enddate));
                                                                                    $showdatetime = \Carbon\Carbon::now()->subMinutes(15);
                                                                                @endphp

                                                                                @if (!is_null($startdatetime) && !is_null($enddatetime))
                                                                                    @php $interval = $startdatetime->diff($enddatetime); @endphp

                                                                                    {{ ($interval->format('%i') == 0) ?
                                                                                        $interval->format('%h hour(s)') :
                                                                                        $interval->format('%h hour(s) %i minute(s)') }}
                                                                                @endif
                                                                            </td>
                                                                            <td class="center-text red-text bold-text">{{ isset($subject) ? $subject->scode : "" }}</td>
                                                                            <td class="left-text red-text bold-text">{{ isset($subject) ? $subject->sname : "" }}</td>
                                                                            <td class="center-text text-danger bold-text">
                                                                                @if(empty($examtimetable->password) || is_null($examtimetable->password))
                                                                                    <span class="label label-danger">Not Available</span>
                                                                                @else
                                                                                    {{ $examtimetable->startdate < $showdatetime ?
                                                                                           $examtimetable->password :
                                                                                           base64_encode($examtimetable->password) }}
                                                                                @endif
                                                                            </td>
                                                                            <td class="center-text red-text bold-text">
                                                                                @if(empty($examtimetable->questionpaper) || is_null($examtimetable->questionpaper))
                                                                                    <span class="label label-danger">Not Available</span>
                                                                                @else
                                                                                    <a href="{{ asset('/files/questionpapers/'.$examtimetable->questionpaper) }}" class="btn btn-primary btn-sm" target="_blank">
                                                                                        <span class="glyphicon glyphicon-download-alt"></span>
                                                                                        &nbsp; Download
                                                                                    </a>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="panel panel-info">
                                                            <div class="panel-heading">
                                                                <div class="panel-title">
                                                                    Update Details
                                                                </div>
                                                            </div>

                                                            <div class="panel-body">
                                                                <form class="form-horizontal" action="{{ url('nber/examquestionpapers/update') }}" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                                                                    {{csrf_field()}}
                                                                    <input type="hidden" name="instituteId" value="">
                                                                    <input type="hidden" id="selectCheckbox" value="0">
                                                                    <input type="hidden" name="examtimetableId" value="{{ $examtimetable->id }}">

                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered" role="table">
                                                                            <tr>
                                                                                <td class="center-text" width="5%">
                                                                                    <input type="checkbox" name="isPasswordSelected" id="isPasswordSelected" value="0">
                                                                                </td>
                                                                                <td class="bold-text blue-text" width="15%">Password</td>
                                                                                <td width="95%">
                                                                                    <div class="col-sm-3">
                                                                                        <input type="text" id="password" name="password" class="form-control blue-text" readOnly>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="center-text" width="5%">
                                                                                    <input type="checkbox" name="isFileSelected" id="isFileSelected" value="0">
                                                                                </td>
                                                                                <td class="bold-text blue-text" width="15%">Question Paper</td>
                                                                                <td width="95%">
                                                                                    <div class="col-sm-4">
                                                                                        <input type="file" id="filename" name="filename" class="form-control blue-text" disabled  onchange="validateFile()">
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="3">
                                                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                                                        <span class="glyphicon glyphicon-ok"></span>&nbsp;
                                                                                        Update
                                                                                    </button>
                                                                                    <button type="reset" class="btn btn-danger btn-sm">
                                                                                        <span class="glyphicon glyphicon-remove"></span>&nbsp;
                                                                                        Cancel
                                                                                    </button>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
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
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function(){
            $("#isPasswordSelected").change(function() {
                if ($(this).is(':checked') == true) {
                    $(this).val(1);
                    $("#selectCheckbox").val(parseInt($("#selectCheckbox").val()) + 1);
                    $("#password").prop("readOnly", false);
                }
                else {
                    $(this).val(0);
                    $("#selectCheckbox").val(parseInt($("#selectCheckbox").val()) - 1);
                    $("#password").val("");
                    $("#password").prop("readOnly", true);
                }
            });
            $("#isFileSelected").change(function() {
                if ($(this).is(':checked') == true) {
                    $(this).val(1);
                    $("#selectCheckbox").val(parseInt($("#selectCheckbox").val()) + 1);
                    $("#filename").prop("disabled", false);
                }
                else {
                    $(this).val(0);
                    $("#selectCheckbox").val(parseInt($("#selectCheckbox").val()) - 1);
                    $('#filename').val(null);
                    $("#filename").prop("disabled", true);
                }
            });
        });

        function validateForm() {
            if ($("#selectCheckbox").val() == 0) {
                swal("Error Occurred!!!", "Please select any Update Details option", "error");
                return false;
            }

            if ($("#isPasswordSelected").is(':checked') == true) {
                if ($('#password').val() == "") {
                    swal("Error Occurred!!!", "Please enter the Password", "error");
                    return false;
                }
            }

            if ($("#isFileSelected").is(':checked') == true) {
                if ($('#filename').get(0).files.length === 0) {
                    swal("Error Occurred!!!", "Please upload the Question Paper", "error");
                    return false;
                }
            }
        }

        function validateFile() {
            var ext = $('#filename').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['pdf']) == -1){
                swal("Error Occurred!!!", "Please upload the scanned file in .pdf format only.", "error");
                $('#filename').val(null);
                return false;
            }
            // else if ($('#filename')[0].files[0].size > 1048576) {
            //     swal("Error Occurred!!!", "Please upload the scanned file less than 1 MB file size.", "error");
            //     $('#filename').val(null);
            //     return false;
            // }
            // else {
            // }
        }
    </script>
@endsection