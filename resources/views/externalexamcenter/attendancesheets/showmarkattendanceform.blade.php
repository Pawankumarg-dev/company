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
          action="{{url('/externalexamcenter/attendance/add/')}}" autocomplete="off" accept-charset="UTF-8"
          enctype="multipart/form-data"
          onsubmit="return ValidateForm()">
        {{ csrf_field() }}

        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
        <input type="hidden" name="externalexamcenter_id" value="{{ $externalexamcenter->id }}">
        <input type="hidden" name="externalexamcenter_code" value="{{ $externalexamcenter->code }}">
        <input type="hidden" name="examtimetable_id" value="{{ $examtimetable->id }}">
        <input type="hidden" name="approvedprogramme_id" value="{{ $approvedprogramme->id }}">

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                        <div class="center-text bold-text blue-text">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <tr>
                                        <th class="bg-info" width="15%">Examination Centre :</th>
                                        <th class="red-text">{{ $externalexamcenter->code }} - {{ $externalexamcenter->name }}</th>
                                    </tr>
                                    <tr>
                                        <th class="bg-info" width="15%">Date of Examination :</th>
                                        <th class="red-text">{{ $examtimetable->startdate->format('d-m-Y') }}</th>
                                    </tr>
                                    <tr>
                                        <th class="bg-info" width="15%">Course Code :</th>
                                        <th class="red-text">{{ $examtimetable->subject->programme->course_name }}</th>
                                    </tr>
                                    <tr>
                                        <th class="bg-info" width="15%">Subject :</th>
                                        <th class="red-text">{{ $examtimetable->subject->scode }} - {{ $examtimetable->subject->sname }}</th>
                                    </tr>
                                </table>
                            </div>
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
                                                        @foreach($languages as $language)
                                                            <option value="{{ $language->id }}">{{ $language->language }}</option>
                                                        @endforeach
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
                            <label for="filename" class="control-label col-sm-5">
                                <div  class="text-left">
                    <span class="blue-text">
                        Upload Scanned File of Attendance Sheet(s)
                        <span class="red-text">
                        *
                    </span><br>
                    </span>
                                    <span class="red-text">
                    (Only .pdf format file is allowed and the filesize should be less than 1 MB)
                    </span>
                                </div>
                            </label>
                            <div class="col-sm-3">
                                <div class="col-sm-6">
                                    <input type="file" id="filename" name="filename" onchange="validateFile()">
                                </div>
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

    function validateFile() {
        var ext = $("#filename").val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['pdf']) == -1){
            swal("Error Occurred!!!", "Please upload the scanned file in .pdf format only.", "error");
            $('#filename').val(null);
            return false;
        }
        else if ($("#filename")[0].files[0].size > 1048576) {
            swal("Error Occurred!!!", "Please upload the scanned file less than 1 MB file size.", "error");
            $("#filename").val(null);
            return false;
        }
        else {
            //$('#filename_link').attr('href', $('#filename').val());
            //$('#filename_display').html($('#filename')[0].files[0].name); //->filename

        }

    }

    function markattendancepresent(count) {
        var ext_attendance1 = document.getElementById('ext_attendance1' + count);
        $('#language_id'+count).attr('disabled', false);
        $('#answerbookletno'+count).attr('readonly', false);
        $('#attendanceremarks'+count).text('Present Marked');
    }

    function markattendanceabsent(count) {
        var ext_attendance2 = document.getElementById('ext_attendance2' + count);
        $('#language_id'+count).val("0").prop('selected', true);
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

        if($('#filename').val() == '') {
            swal("Error Occurred!!!", "Please upload the Scanned file of Attendance Sheet(s).", "error");
            return false;
        }
    }

</script>
