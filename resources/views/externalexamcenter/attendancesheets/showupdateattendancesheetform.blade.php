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

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm darkblue-background minus15px-margin-top">
                    <div class="center-text bold-text">

                        {{$title}}

                    </div>
                </div>
            </div>
        </div>
    </section>

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
                                <th class="bg-info blue-text" width="15%">Institute :</th>
                                <th class="red-text">{{ $approvedprogramme->institute->code }} - {{ $approvedprogramme->institute->name }}</th>
                            </tr><tr>
                                <th class="bg-info blue-text" width="15%">Batch :</th>
                                <th class="red-text">{{ $approvedprogramme->academicyear->year }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <form class="form-horizontal" role="form" method="POST"
                          action="{{url('/externalexamcenter/attendance/updateattendancesheet/')}}" autocomplete="off" accept-charset="UTF-8"
                          enctype="multipart/form-data"
                          onsubmit="return ValidateForm()">
                        {{ csrf_field() }}

                        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                        <input type="hidden" name="externalexamcenter_id" value="{{ $externalexamcenter->id }}">
                        <input type="hidden" name="examtimetable_id" value="{{ $examtimetable->id }}">
                        <input type="hidden" name="approvedprogramme_id" value="{{ $approvedprogramme->id }}">
                        <input type="hidden" name="oldfilename" value="{{ $oldfilename }}">

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
                            <div class="col-sm-6">
                                <div class="col-sm-6">
                                    <input type="file" class="form-control" id="filename" name="filename" onchange="validateFile()" value="">

                                    
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-5">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>&nbsp;
                                    Save
                                </button>
                                <button type="button" class="btn btn-sm btn-danger">
                                    <span class="glyphicon glyphicon-remove"></span>&nbsp;
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
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

        function ValidateForm() {
            if($('#filename').val() == '') {
                swal("Error Occurred!!!", "Please upload the Scanned file of Attendance Sheet(s).", "error");
                return false;
            }
        }
    </script>
@endsection
