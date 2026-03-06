@extends('layouts.externalexamcenter')

@section('content')
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm darkblue-background">
                    <div class="center-text">
                        <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                        <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                        <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                        <span class="h8-text">(An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text blue-text">
                    {{ $externalexamcenter->code }} - {{ $externalexamcenter->name }},
                    @if($externalexamcenter->address != ''){{ $externalexamcenter->address }},@endif
                    @if($externalexamcenter->district != ''){{ $externalexamcenter->district }},@endif
                    @if($externalexamcenter->state != ''){{ $externalexamcenter->state }}@endif
                    @if($externalexamcenter->state != '') - {{ $externalexamcenter->pincode }}.@endif
                    @if($externalexamcenter->contactnumber1 != '')<br>Contact No(s): {{ $externalexamcenter->contactnumber1 }}@endif @if($externalexamcenter->contactnumber2 != ''), {{ $externalexamcenter->contactnumber2 }}@endif
                    @if($externalexamcenter->email1 != '')<br>Email(s): {{ $externalexamcenter->email1 }}@endif @if($externalexamcenter->email2 != ''), {{ $externalexamcenter->email2 }}@endif

                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text blue-text">
                        <a href="{{ url('/externalexamcenter/'.$externalexamcenter->id.'/show-home-page/'.$exam->id) }}" class="btn btn-sm btn-success">Click to go for Home Page</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text blue-text">
                        {{ $title }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <form class="form-horizontal" role="form" method="POST"
          action="{{url('/externalexamcenter/attendance/update/')}}" autocomplete="off" accept-charset="UTF-8"
          enctype="multipart/form-data"
          onsubmit="return ValidateForm()">
        {{ csrf_field() }}

        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
        <input type="hidden" name="externalexamcenter_id" value="{{ $externalexamcenter->id }}">
        <input type="hidden" name="externalexamcenter_code" value="{{ $externalexamcenter->code }}">
        <input type="hidden" name="examtimetable_id" value="{{ $examtimetable->id }}">
        <input type="hidden" name="approvedprogramme_id" value="{{ $approvedprogramme->id }}">
        <input type="hidden" name="filename" value="{{ $filename }}">

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th class="bg-info blue-text" width="15%">Examination Centre :</th>
                                <th class="red-text">{{ $externalexamcenter->code }} - {{ $externalexamcenter->name }}</th>
                            </tr>
                            <tr>
                                <th class="bg-info blue-text" width="15%">Date of Examination :</th>
                                <th class="red-text">{{ $examtimetable->startdate->format('d-m-Y') }}</th>
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
                                    <a href="{{asset('files/examattendancefiles').'/'.$filename}}" target="_blank">
                                        File &nbsp;&nbsp;<i class="fa fa-share-square-o"></i>
                                    </a>
                                </th>
                            </tr>
                            <tr>
                                <th class="bg-info blue-text" width="15%">Update Uploaded File :</th>
                                <td>
                                    <a href="{{ url('/externalexamcenter/attendance/updateattendancesheetform/'.$exam->id.'/'.$externalexamcenter->id.'/'.$examtimetable->id.'/'.$approvedprogramme->id) }}">
                                        Click here to Update
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </section>

        @php $count = 0; @endphp
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                            <div class="center-text bold-text blue-text">
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
                                            <input type="hidden" name="application_id[{{$count}}]" value="{{$application->id}}">

                                            @php
                                                $markattendance = \App\Markexamattendance::where('application_id', $application->id)->first();
                                            @endphp
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
                                                <td>
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
                                                <td>
                                                    <div id="attendanceremarks{{ $count }}" class="red-text">
                                                        @if(!is_null($markattendance))
                                                            @if($markattendance->externalattendance_id == 1)
                                                                <span class="blue-text">{{ strtoupper($markattendance->externalattendance->attendance) }}</span>
                                                            @else
                                                                <span class="red-text">{{ strtoupper($markattendance->externalattendance->attendance) }}</span>
                                                            @endif
                                                        @else
                                                            Attendance Not Marked
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @php $count++; $sno++; @endphp
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                        <div class="form-group">
                            <div class="col-sm-10">
                                <button class="btn btn-primary btn-sm" type="submit" id="submit_button">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </form>
@endsection
<script>
    $(document).ready(function(){

    });


    function markattendancepresent(count) {
        var ext_attendance1 = document.getElementById('ext_attendance1' + count);
        $('#language_id'+count).attr('disabled', false);
        $('#answerbookletno'+count).attr('readonly', false);
        $('#attendanceremarks'+count).text('Present Marked');
    }

    function markattendanceabsent(count) {
        var ext_attendance2 = document.getElementById('ext_attendance2' + count);
        $('#language_id'+count).val('0').prop('selected', true);
        $('#language_id'+count).val("0").change();
        $('#answerbookletno'+count).val('');
        $('#answerbookletno'+count).attr('readonly', true);
        $('#attendanceremarks'+count).text('Absent Marked');
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
