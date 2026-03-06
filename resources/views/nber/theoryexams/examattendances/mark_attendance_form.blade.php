@extends('layouts.app')
@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{ $exam->name }} Examinations - Exam Attendance - Mark Attendance Form
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
                                                <li class="active">Exam Attendance</li>
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
                                                        <p class="center-text">
                                                            <a href="{{ url('/nber/theoryexams/examcentermapping/updateinstitutemappingform/'.$exam->id) }}" class="btn btn-sm btn-primary">
                                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;Institute Mapping
                                                            </a>
                                                            <a href="" class="btn btn-sm btn-primary">
                                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;Candidate Mapping
                                                            </a>
                                                            <a href="{{ url('/nber/theoryexams/examcentermapping/showmappedinstitutes/'.$exam->id) }}" class="btn btn-sm btn-success">
                                                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Mapped Institutes
                                                            </a>
                                                            <a href="{{ url('/nber/theoryexams/examcentermapping/showmappedcandidates/'.$exam->id) }}" class="btn btn-sm btn-success">
                                                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Mapped Candidates
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="panel panel-info">
                                                            <div class="panel-heading">
                                                                <div class="panel-title">
                                                                    {{ $examcenter->code }} - {{ $examcenter->name }}
                                                                </div>
                                                            </div>

                                                            <div class="panel-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-condensed">
                                                                        <tr>
                                                                            <th class="bg-info blue-text" width="15%">Examination Centre :</th>
                                                                            <th class="red-text">{{ $examcenter->code }} - {{ $examcenter->name }}</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="bg-info blue-text" width="15%">Date of Examination :</th>
                                                                            <th class="red-text">{{ $examtimetable->startdate->format('d-m-Y') }} ({{ $examtimetable->startdate->format('H:i A') }} - {{ $examtimetable->enddate->format('H:i A') }})</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="bg-info blue-text" width="15%">Course Code :</th>
                                                                            <th class="red-text">{{ $examtimetable->subject->programme->course_name }}</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="bg-info blue-text" width="15%">Subject :</th>
                                                                            <th class="red-text">{{ $examtimetable->subject->scode }} - {{ $examtimetable->subject->sname }}</th>
                                                                        </tr>
                                                                    </table>
                                                                </div>

                                                                <form class="form-horizontal" role="form" method="POST"
                                                                      action="{{url('#')}}" autocomplete="off" accept-charset="UTF-8"
                                                                      enctype="multipart/form-data"
                                                                      onsubmit="return ValidateForm()">
                                                                    {{ csrf_field() }}

                                                                    @php $count = 0; @endphp

                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered table-hover blue-text">
                                                                            <tr>
                                                                                <th class="bg-info center-text" style="font-size: large" colspan="10">
                                                                                    {{ $approvedprogramme->institute->code }} - {{ $approvedprogramme->institute->name }}
                                                                                </th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th rowspan="2" class="center-text darkblue-background" width="5%">S.No.</th>
                                                                                <th rowspan="2" class="center-text darkblue-background" width="5%">Batch</th>
                                                                                <th colspan="3" class="center-text darkblue-background">Candidate Details</th>
                                                                                <th colspan="2" class="center-text darkblue-background">Mark Attendance</th>
                                                                                <th rowspan="2" class="center-text darkblue-background" width="15%">Language written</th>
                                                                                <th rowspan="2" class="center-text darkblue-background" width="15%">Answer Booklet's<br>Serial No.</th>
                                                                                <th rowspan="2" class="center-text darkblue-background" width="5%">Attendance Remarks</th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="center-text darkblue-background" width="10%">Photo</th>
                                                                                <th class="center-text darkblue-background" width="10%">Registration No.</th>
                                                                                <th class="center-text darkblue-background" width="20%">Name</th>
                                                                                <th class="center-text darkblue-background" width="5%">Present</th>
                                                                                <th class="center-text darkblue-background" width="5%">Absent</th>
                                                                            </tr>

                                                                            @php $sno = 1; @endphp
                                                                            @foreach($applications as $application)
                                                                                <input type="hidden" name="application_id[]" value="{{$application->id}}">
                                                                                <tr>
                                                                                    <td>{{ $sno }}</td>
                                                                                    <td>{{ $approvedprogramme->academicyear->year }}</td>
                                                                                    <td>
                                                                                        <img src="{{asset('/files/enrolment/photos')}}/{{$application->candidate->photo}}"  style="width: 60px;" class="img" />
                                                                                    </td>
                                                                                    <td>{{ $application->candidate->enrolmentno }}</td>
                                                                                    <td>{{ $application->candidate->name }}</td>
                                                                                    <td class="center-text">
                                                                                        <input type="radio" name="ext_attendance[{{ $count }}]" id="ext_attendance1_{{ $count }}" onclick="markattendancepresent({{ $count }})"
                                                                                               value="1"
                                                                                        />
                                                                                    </td>
                                                                                    <td class="center-text">
                                                                                        <input type="radio" name="ext_attendance[{{ $count }}]" id="ext_attendance2_{{ $count }}" onclick="markattendanceabsent({{ $count }})"
                                                                                               value="2"
                                                                                        />
                                                                                    </td>
                                                                                    <td class="center-text">
                                                                                        <select id="language_id{{ $count }}" name="language_id[{{ $count }}]" class="blue-text">
                                                                                            <option value="0">Select</option>
                                                                                            {{--
                                                                                            @foreach($languages as $language)
                                                                                                <option value="{{ $language->id }}">{{ $language->language }}</option>
                                                                                            @endforeach
                                                                                            --}}
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" id="answerbookletno{{ $count }}" name="answerbookletno[{{ $count }}]" readonly/>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div id="attendanceremarks{{ $count }}" class="red-text">
                                                                                            Attendance Not Marked
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                @php $count++; $sno++; @endphp
                                                                            @endforeach


                                                                        </table>
                                                                    </div>

                                                                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                                                                        <div class="form-group">
                                                                            <div class="blue-text">
                                                                                <label for="filename" class="control-label col-sm-5 left-text">
                                                                                    Upload Scanned File of Attendance Sheet(s)
                                                                                    <span class="red-text">*</span><br>
                                                                                    <span class="red-text">
                                                                                        (Only .pdf format file is allowed and the filesize should be less than 1 MB)
                                                                                    </span><br>
                                                                                </label>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="col-sm-6">
                                                                                    <input type="file" id="filename" name="filename" onchange="validateFile()">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                                                                        <div class="form-group">
                                                                            <div class="col-sm-10">
                                                                                <button class="btn btn-primary btn-sm" type="submit" id="submit_button">
                                                                                    <span class="glyphicon glyphicon-ok-sign"></span>
                                                                                    Submit
                                                                                </button>
                                                                                <button class="btn btn-danger btn-sm" type="reset" id="reset_button">
                                                                                    <span class="glyphicon glyphicon-remove-sign"></span>
                                                                                    Reset
                                                                                </button>
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

        });


        function markattendancepresent(count) {
            var ext_attendance1 = document.getElementById('ext_attendance1' + count);
            $('#language_id'+count).attr('disabled', false);
            $('#answerbookletno'+count).attr('readonly', false);
            $('#attendanceremarks'+count).text('Present Marked');
            addLanguages(count);
        }

        function markattendanceabsent(count) {
            var ext_attendance2 = document.getElementById('ext_attendance2' + count);
            $('#language_id'+count).val('0').prop('selected', true);
            $('#language_id'+count).val("0").change();
            $('#answerbookletno'+count).val('');
            $('#answerbookletno'+count).attr('readonly', true);
            $('#attendanceremarks'+count).text('Absent Marked');
        }

        function addLanguages(count) {
            var iterateMe = <?=json_encode($languages)?>;

            $('#language_id'+count).append('<option value="1">English</option>');
            $('#language_id'+count).append('<option value="2">Hindi</option>');
            $('#language_id'+count).append('<option value="3">Oriya</option>');
            $('#language_id'+count).append('<option value="4">Telugu</option>');
            $('#language_id'+count).append('<option value="4">Malayalam</option>');
        }

        function ValidateForm() {
            for (var i = 0; i < "{{ $count }}"; i++) {

                if(!$('#ext_attendance1_'+i).is(':checked') && !$('#ext_attendance2_'+i).is(':checked')) {
                    $('#ext_attendance1_'+i).focus();
                    swal("Error Occurred!!!", "Please Mark Attendance.", "error");
                    return false;
                }
                if($('#ext_attendance1_'+i).is(':checked')) {
                    if($('#language_id'+i).val() == "0") {
                        swal("Error Occurred!!!", "Please Select the language written.", "error");
                        return false;
                    }
                    if(!$('#answerbookletno'+i).val()){
                        swal("Error Occurred!!!", "Please enter the Answer Booklet Serial No..", "error");
                        return false;
                    }
                }
            }
        }

    </script>
@endsection
