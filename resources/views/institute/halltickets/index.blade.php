@extends('layouts.app')

@section('content')
    <style>
        .table-bordered>tbody>tr>td {
            font-weight: 100 !important;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>
                    Attendance for Term {{$term}} <b>{{ $ap->programme->course_name }} ( {{ $ap->academicyear->year }} )
                        <div class="pull-right">
                            <span class="" style="padding: 5px;"> Attendance Scan Copy: </span> &nbsp;








                            <?php $display = false; $i=1;
                            $disabled = 0; ?>

                            @if (!is_null($candidates))

                                                                                            <?php 

// print_r($candidates[0]);

// die(); 

?>

                                @if (!is_null($candidates[0]->attendances))


									<?php 
										if($candidates[0]->enable_edit == 1){
											$disabled = 0;
										}
                                        
									?>  

                                    @if ($candidates[0]->document_t != '')
                                        <?php $display = true; ?>
                                        <a target="_blank" 
                                            href="{{ asset('/files/attendance/') }}/{{ $candidates[0]->document_t }}"
                                            class="btn btn-xs btn-link"><i class="fa fa-download"></i> Theory </a>

                                        <a target="_blank"
                                            href="{{ asset('/files/attendance/') }}/{{ $candidates[0]->document_t }}"
                                            class="btn btn-xs btn-link"><i class="fa fa-download"></i> Practical </a>


                                        <button type="button" @if($disabled==1) disabled @endif class="btn btn-info btn-xs" data-toggle="modal"
                                            data-target="#uploadattendance">Re-upload </button>
                                    @else
                                        <button type="button" @if($disabled == 1) disabled @endif class="btn btn-info btn-xs" data-toggle="modal"
                                            data-target="#uploadattendance">Upload </button>
                                    @endif
                                @else
                                    <button type="button"  class="btn btn-info btn-xs" data-toggle="modal"
                                        data-target="#uploadattendance">Upload </button>
                                @endif
                            @endif
                        </div>
                </h4>

                            <?php 




?>






                <div id="uploadattendance" class="modal fade modal-xs" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->

                        <form class="form-horizontal" action="{{ url('uploadattendance') }}" enctype="multipart/form-data"
                            method='post' id="frmuploadattendance">
                            {!! csrf_field() !!}

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Upload Attendance</h4>
                                    <input type="hidden" name='approvedprogramme_id' value="{{ $id }}" />
                                    <input type="hidden" name='exam_id' value="{{ $exam_id }}" />
                                </div>
                                <div class="modal-body" style="min-height:100px;">

                                    <div class="form-group">
                                        <label class="control-label col-sm-6" for="document_t">Attendance Scan Copy -
                                            Theory:</label>
                                        <div class="col-sm-6">
                                            <input type="file" class="form-control" name="document_t" id="document_t" />
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label col-sm-6" for="document_p">Attendance Scan Copy -
                                            Practical:</label>
                                        <div class="col-sm-6">
                                            <input type="file" class="form-control" name="document_p" id="document_p" />
                                        </div>
                                    </div>
                                </div>

                                                                            <input type="hidden" class="form-control" name="term" id="term" value='{{$term }}' />

                                <div class="modal-footer">
                                    <button type="button"  onclick="javascript:submitForm();"
                                        class="btn btn-primary">Upload</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <script>
            function submitForm() {
                if (checkFileSize('#document_t')) {
                    if (checkFileSize('#document_p')) {
                        $('#frmuploadattendance').submit();
                    } else {
                        return false;
                    }
                }
                return false;
            }

            function checkFileSize(fname) {
                var ext = $(fname).val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['pdf']) == -1) {
                    swal("Error Occurred!!!", "Please upload the scanned file in .pdf format only.", "error");
                    $(fname).val(null);
                    return false;
                } else if ($(fname)[0].files[0].size > 2048576) {
                    swal("Error Occurred!!!", "Please upload the scanned file less than 2 MB file size.", "error");
                    $(fname).val(null);
                    return false;
                } else {
                    return true
                }
            }
        </script>
        @include('common.errorandmsg')

        <div class="row">
            <div class="col-md-12">
                @if ($display)
                    <table class="table  table-bordered">
                        <tr>
                            <th rowspan="2">Name</th>
                            <th rowspan="2">Enrolment Number</th>
                            <th rowspan="2">Previous Year Attendance</th>
                            <th colspan="3">Attendance</th>
                        </tr>
                        <tr>
                            <th>Theory</th>
                            <th>Practical</th>
                        </tr>
                        @foreach ($candidates->sortBy('enrolmentno') as $c)
                            <tr>
                                                                <td>{{ $i++}}</td>

                                <td>{{ $c->name }}</td>
                                <td>{{ $c->enrolmentno }}</td>



                                <td>
                                    <?php 
                                        $b = \App\Attendance::where('candidate_id', $c->candidate_id)->where('exam_id', '!=', $exam_id)->get(); 
                                        ?>
                                    @foreach ($b as $data)
                                        <strong>Theory {{ $data->exam->name }}:</strong>{{ $data->attendance_t }} <br>
                                        <strong>Practical {{ $data->exam->name }}:</strong>{{ $data->attendance_t }} <br>
                                    @endforeach
                                </td>



                                    @if ($c->attendance_t != null && $c->attendance_p != null)
                                        <td>{{ $c->attendance_t }}%</td>
                                        <td>{{ $c->attendance_p }}%</td>
                                        <td><button type="button" class="btn btn-link btn-xs " @if($disabled==1) disabled @endif 
                                                data-toggle="modal" data-target="#ht_{{$c->candidate_id}}">Edit</button>
                                        </td>
                                    @else
                                        <td colspan="3" class="text-center"><button @if($disabled==1) disabled @endif  type="button"
                                                class="btn btn-primary btn-xs" data-toggle="modal"
                                                data-target="#ht_{{$c->candidate_id}}">Attendance</button></td>
                                    @endif
                              

                            </tr>


                            <div id="ht_{{$c->candidate_id}}" class="modal fade modal-xs" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <form class="form-horizontal" action="{{ url('attendance') }}"
                                        enctype="multipart/form-data" method='post'>
                                        {!! csrf_field() !!}

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">{{ $c->name }}</h4>
                                                <input type="hidden" name='candidate_id' value="{{ $c->candidate_id }}" />
                                                <input type="hidden" name='exam_id' value="{{ $exam_id }}" />
                                                <input type="hidden" name='term' value="{{ $term }}" />

                                            </div>
                                            <div class="modal-body" style="min-height:100px;">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-6" for="attendance">Attendance
                                                        Percentage - Theory:</label>
                                                    <div class="col-sm-6">
                                                        <input type="number" class="form-control" name="attendance_t"
                                                            placeholder="Attendance Percentage" min='0'
                                                            max='100' step="any">
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label class="control-label col-sm-6" for="attendance">Attendance
                                                        Percentage - Practical:</label>
                                                    <div class="col-sm-6">
                                                        <input type="number" class="form-control" name="attendance_p"
                                                            placeholder="Attendance Percentage" min='0'
                                                            max='100' step="any">
                                                    </div>
                                                </div>



                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary" >Save</button>
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        @endforeach
                    </table>
                @else
                    <div class="alert alert-danger">
                        Please click on upload button to upload the scan copy of the attendance sheet.
                    </div>
<style>
    .table-container {
        max-width: 100%;
        overflow-x: auto;
        margin-top: 20px;
    }

    table.ui-table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        font-size: 14px;
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .ui-table thead {
        background-color: #2c3e50;
        color: #ffffff;
    }

    .ui-table th,
    .ui-table td {
        padding: 12px 14px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
        white-space: nowrap;
    }

    .ui-table th {
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
    }

    .ui-table tbody tr:hover {
        background-color: #f5f7fa;
    }

    .ui-table tbody tr:nth-child(even) {
        background-color: #fafafa;
    }

    .badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        color: #fff;
    }

    .badge-present {
        background-color: #27ae60;
    }

    .badge-absent {
        background-color: #c0392b;
    }
</style>

                @endif

            </div>
        </div>
    </div>



@endsection
