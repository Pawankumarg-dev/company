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
                    {{ $externalexamcenter->code }} - {{ $externalexamcenter->name }}
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text blue-text">
                        <a href="{{ url('/demoexternalexamcenter/showhomepage') }}" class="btn btn-sm btn-success">Click to go for Home Page</a>
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
          action="{{url('/demoexternalexamcenter/demoattendancesheet/addattendance/')}}" autocomplete="off" accept-charset="UTF-8"
          enctype="multipart/form-data"
          onsubmit="return ValidateForm()">
        {{ csrf_field() }}

        <input type="hidden" name="externalexamcenter_id" value="{{ $externalexamcenter->id }}">
        <input type="hidden" name="externalexamcenter_code" value="{{ $externalexamcenter->code }}">
        <input type="hidden" name="id" value="{{ $id }}">

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                        <div class="center-text bold-text blue-text">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <tr>
                                        <th class="bg-info h5-text" width="18%">Date of Examination :</th>
                                        <th class="red-text h5-text">{{ date('d-m-Y') }}</th>
                                    </tr>
                                    <tr>
                                        <th class="bg-info h5-text" width="18%">Course Code :</th>
                                        <th class="red-text h5-text">Course-{{ $id }}</th>
                                    </tr>
                                    <tr>
                                        <th class="bg-info h5-text" width="18%">Subject Code :</th>
                                        <th class="red-text h5-text">Subject Code-{{ $id }}</th>
                                    </tr>
                                    <tr>
                                        <th class="bg-info h5-text" width="18%">Subject Name :</th>
                                        <th class="red-text h5-text">Subject Name-{{ $id }}</th>
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
                                            Institute Code-1 & Name-1
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
                                    @for($i=0; $i<5; $i++)
                                        <tr>
                                            <td class="center-text blue-text">{{ $sno }}</td>
                                            <td class="center-text blue-text">20__</td>
                                            <td class="center-text blue-text"></td>
                                            <td class="center-text blue-text">{{ $sno }}{{ $sno }}{{ $sno }}{{ $sno }}{{ $sno }}</td>
                                            <td class="center-text blue-text">Name-{{ $sno }}</td>
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
                                        @php $sno++; $count++; @endphp
                                    @endfor
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
                                    (Only .pdf format file is allowed and the filesize should be less than 3 MB)
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
        else if ($("#filename")[0].files[0].size > 3145728) {
            swal("Error Occurred!!!", "Please upload the scanned file less than 3 MB file size.", "error");
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
