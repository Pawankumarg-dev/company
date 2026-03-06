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
                                    {{ $exam->name }} Examinations - Exam Attendance
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
                                                <li class="active">Update Exam Attendance</li>
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
                                                                    {{ $externalexamcenter->code }} - {{ $externalexamcenter->name }}
                                                                </div>
                                                            </div>

                                                            <div class="panel-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-condensed">
                                                                        <tr>
                                                                            <th class="bg-info blue-text" width="15%">Examination Centre :</th>
                                                                            <th class="red-text">{{ $externalexamcenter->code }} - {{ $externalexamcenter->name }}</th>
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
                                                                        <tr>
                                                                            <th class="bg-info blue-text" width="15%">Uploaded File :</th>
                                                                            <th class="red-text">
                                                                                @if (!is_null($filename))
                                                                                    <a href="{{asset('files/examattendancefiles').'/'.$filename}}" target="_blank">
                                                                                        File &nbsp;&nbsp;<i class="fa fa-share-square-o"></i>
                                                                                    </a>
                                                                                @else
                                                                                    <span class="label label-danger">File Not Found</span>
                                                                                @endif
                                                                            </th>
                                                                        </tr>
                                                                    </table>
                                                                </div>

                                                                <form class="form-horizontal" role="form" method="POST"
                                                                      action="{{url('/nber/theoryexams/examattendances/updateattendanceform/')}}" autocomplete="off" accept-charset="UTF-8"
                                                                      enctype="multipart/form-data"
                                                                      onsubmit="return ValidateForm()">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="exam_id" value="{{$exam->id}}">
                                                                    <input type="hidden" name="examtimetable_id" value="{{$examtimetable->id}}">
                                                                    <input type="hidden" name="externalexamcenter_id" value="{{$externalexamcenter->id}}">
                                                                    <input type="hidden" name="approvedprogramme_id" value="{{$approvedprogramme->id}}">

                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered table-hover blue-text">
                                                                            <tr>
                                                                                <th class="bg-info center-text" style="font-size: large" colspan="11">
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
                                                                                <th rowspan="2" class="center-text darkblue-background" width="15%">Reference<br>No.</th>
                                                                                <th rowspan="2" class="center-text darkblue-background" width="5%">Attendance Remarks</th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="center-text darkblue-background" width="10%">Photo</th>
                                                                                <th class="center-text darkblue-background" width="10%">Registration No.</th>
                                                                                <th class="center-text darkblue-background" width="20%">Name</th>
                                                                                <th class="center-text darkblue-background" width="5%">Present</th>
                                                                                <th class="center-text darkblue-background" width="5%">Absent</th>
                                                                            </tr>

                                                                            @php $count = 0; $sno = 1; @endphp
                                                                            @foreach($applications as $application)
                                                                                <input type="hidden" name="application_id[{{$count}}]" value="{{$application->id}}">

                                                                                @php
                                                                                    $markattendance = \App\Markexamattendance::where('application_id', $application->id)->first();
                                                                                @endphp
                                                                                <tr>
                                                                                    <td class="center-text">{{ $sno }}</td>
                                                                                    <td class="center-text">{{ $approvedprogramme->academicyear->year }}</td>
                                                                                    <td class="center-text">
                                                                                        <img src="{{asset('/files/enrolment/photos')}}/{{$application->candidate->photo}}"  style="width: 60px;" class="img" />
                                                                                    </td>
                                                                                    <td class="center-text">{{ $application->candidate->enrolmentno }}</td>
                                                                                    <td>{{ $application->candidate->name }}</td>
                                                                                    <td class="center-text">
                                                                                        <input type="radio" name="ext_attendance[{{ $count }}]" id="ext_attendance1_{{ $count }}" onclick="markattendancepresent({{ $count }})"
                                                                                               value="1"
                                                                                               @if(!is_null($markattendance)) @if($markattendance->externalattendance->id == 1)
                                                                                               checked
                                                                                                @endif  @endif
                                                                                        />
                                                                                    </td>
                                                                                    <td class="center-text">
                                                                                        <input type="radio" name="ext_attendance[{{ $count }}]" id="ext_attendance2_{{ $count }}" onclick="markattendanceabsent({{ $count }})"
                                                                                               value="2"
                                                                                               @if(!is_null($markattendance)) @if($markattendance->externalattendance->id == 2)
                                                                                               checked
                                                                                                @endif  @endif
                                                                                        />
                                                                                    </td>
                                                                                    <td class="center-text">
                                                                                        <select id="language_id{{ $count }}" name="language_id[{{ $count }}]" class="blue-text"
                                                                                        @if(!is_null($markattendance))
                                                                                            @if($markattendance->externalattendance->id == 2)

                                                                                                    @else
                                                                                                    @endif
                                                                                                @else
                                                                                                @endif
                                                                                        >
                                                                                            @if(!is_null($markattendance))
                                                                                                @if($markattendance->externalattendance->id == 2)
                                                                                                    <option value="0" selected>Select</option>
                                                                                                    @foreach($languages as $language)
                                                                                                        <option value="{{ $language->id }}">{{ $language->language }}</option>
                                                                                                    @endforeach
                                                                                                @else
                                                                                                    <option value="0" selected>Select</option>
                                                                                                    @foreach($languages as $language)
                                                                                                        <option value="{{ $language->id }}" @if($markattendance->language_id == $language->id) selected @endif>{{ $language->language }}</option>
                                                                                                    @endforeach
                                                                                                @endif
                                                                                            @else
                                                                                                <option value="0" selected>Select</option>
                                                                                                @foreach($languages as $language)
                                                                                                    <option value="{{ $language->id }}">{{ $language->language }}</option>
                                                                                                @endforeach
                                                                                            @endif>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td class="center-text">
                                                                                        <input type="text" id="answerbookletno{{ $count }}" name="answerbookletno[{{ $count }}]"
                                                                                               @if(!is_null($markattendance))
                                                                                               @if($markattendance->externalattendance->id == 2)
                                                                                               value=""
                                                                                               readonly
                                                                                               @else
                                                                                               value="{{ $markattendance->answersheet_serialnumber }}"
                                                                                               @endif
                                                                                               @else
                                                                                               readonly
                                                                                                @endif
                                                                                        >
                                                                                    </td>
                                                                                    <td class="center-text">
                                                                                        @if($markattendance->externalattendance_id == 1)
                                                                                            @if(!is_null($markattendance->dummy_number))
                                                                                                <span class="blue-text">{{ $markattendance->dummy_number }}</span>
                                                                                            @else
                                                                                                <span class="label label-danger">NOT AVAILABLE</span>
                                                                                            @endif
                                                                                        @else
                                                                                            <span class="label label-danger">NOT APPLICABLE</span>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="center-text">
                                                                                        <div id="attendanceremarks{{ $count }}">
                                                                                            @if(!is_null($markattendance))
                                                                                                @if($markattendance->externalattendance_id == 1)
                                                                                                    <span class="blue-text">{{ strtoupper($markattendance->externalattendance->attendance) }}</span>
                                                                                                @else
                                                                                                    <span class="red-text">{{ strtoupper($markattendance->externalattendance->attendance) }}</span>
                                                                                                @endif
                                                                                            @else
                                                                                                <span class="label label-default">
                                                                                                    Attendance Not
                                                                                                </span>
                                                                                            @endif
                                                                                        </div>

                                                                                        <span class="text-warning">Marked</span>
                                                                                    </td>
                                                                                </tr>
                                                                                @php $count++; $sno++; @endphp
                                                                            @endforeach
                                                                            <tr>
                                                                                <td colspan="11">
                                                                                    <div class="col-sm-6">
                                                                                        <button class="btn btn-primary btn-sm" type="submit" id="submit_button">Submit</button>
                                                                                        <button class="btn btn-danger btn-sm" type="reset" id="reset_button">Reset</button>
                                                                                    </div>
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

        });


        function markattendancepresent(count) {
            var ext_attendance1 = document.getElementById('ext_attendance1' + count);
            $('#language_id'+count).attr('disabled', false);
            $('#answerbookletno'+count).attr('readonly', false);
            $('#attendanceremarks'+count).text('PRESENT');

            if($('#attendanceremarks'+count).hasClass('red-text'))
                $('#attendanceremarks'+count).removeClass('red-text');

            $('#attendanceremarks'+count).addClass('blue-text');
        }

        function markattendanceabsent(count) {
            var ext_attendance2 = document.getElementById('ext_attendance2' + count);
            $('#language_id'+count).val('0').prop('selected', true);
            $('#language_id'+count).val("0").change();
            $('#answerbookletno'+count).val('');
            $('#answerbookletno'+count).attr('readonly', true);
            $('#attendanceremarks'+count).text('ABSENT');

            if($('#attendanceremarks'+count).hasClass('blue-text'))
                $('#attendanceremarks'+count).removeClass('blue-text');

            $('#attendanceremarks'+count).addClass('red-text');
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
