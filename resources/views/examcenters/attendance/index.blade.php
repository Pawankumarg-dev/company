@extends('layouts.app')
@section('content')
<script>
    function validateFile() {
            var ext = $("#filename").val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['pdf']) == -1){
                //swal("Error Occurred!!!", "Please upload the scanned file in .pdf format only.", "error");
                //$('#filename').val(null);
                //return false;
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
</script>
<div class="container">
	<div class="row">
		<div class="col-12">
            <h3>Sept-Oct 2023 Examinations
            </h3>

            @if (Session::has('messages') )
	<script>
		$(document).ready(function () {
		
		//$.notify("{{Session::get('messages')}}", "success", { position:"right bottom" });
		swal({

  type: 'success',
  title: '{{Session::get('messages')}}',
  showConfirmButton: false,
  timer: 1500
});
		});
		<?php Session::forget('messages'); ?>
	</script>
@endif
		
            <h4>
            {{\Carbon\Carbon::parse($examdate)->format('d-M-Y')}} 
                            {{\Carbon\Carbon::parse($starttime)->format('h:i A')}} to 
                            {{\Carbon\Carbon::parse($endtime)->format('h:i A')}}
            </h4>
            <?php $slno = 1;  ?>
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th>Slno</th>
                    <th>
                        Programme
                    </th>
                    <th>
                        Subject
                    </th>
                    <th>
                        Institute
                    </th>
                    <th>
                        NBER
                    </th>
                    <th>Batch</th>
                    <th>
                        Link
                    </th>
                    <th>Upload the attendance sheet</th>
                </tr>
                @foreach($approvedprogrammes  as $ap)
                 
                        <?php $application = \App\Kvdailysubject::where('approvedprogramme_id',$ap->id)->where('examdate',$examdate)->where('starttime',$starttime)->first(); ?>
                    @if(!is_null($application) )
                  {{--  @if(!is_null($application->applied_candidate_count)) --}}
                        <tr>
                            <td>
                                {{$slno}}
                                <?php $slno++; ?>
                            </td>
                            <td>
                            <b>
                            {{$ap->programme->course_name}}</b>
                            - 
                                {{$ap->programme->name}} 
                            </td>
                            <td>
                                <b>
                                {{$application->subject->scode}} 
                                </b>
                                {{$application->subject->sname}} 
                            </td>
                            <td>
                                <b>{{$ap->institute->rci_code}}</b> - {{$ap->institute->name}}
                            </td>
                            <td>
                                {{$ap->programme->nber->name_code}}
                            </td>
                            <td>
                                @if($application->subject->syear==2)
                                    II Year
                                @else
                                    I Year
                                @endif
                            </td>
                            <td>
                                <a href="{{url('examcenter/attendance/')}}/{{$ap->id}}/{{$application->subject_id}}?examdate={{$examdate}}&starttime={{$starttime}}&endtime={{$endtime}}"  class="btn btn-info btn-sm" style="margin-left:10px;" target="_blank">Mark the attendance</a>
                            </td>
                            <td>
                            <form action="{{url('examcenter/attendance/uploadsheet')}}"   enctype="multipart/form-data" method="post">
                                {{ csrf_field() }}
                        <?php $up = \App\Examattendancesheet::where('approvedprogramme_id',$ap->id)->where('subject_id',$application->subject_id)->first(); ?>
                                <input type="hidden" name="approvedprogramme_id" value="{{$ap->id}}">
                                <input type="hidden" name="subject_id" value="{{$application->subject_id}}">
                                @if(is_null($up))
                                Choose Scanned copy of attendance sheet
                                @else
                                Uploaded
                                @endif 
                            <input type="file" class="form-control" id="filename" name="filename" onchange="validateFile()" value="">
                            <button type="submit" class="btn btn-info btn-sm"> @if(is_null($up)) Upload @else Re-upload @endif</button>
                            </form>
                            </td>
                        </tr>
                        {{-- @endif --}}
                    @endif
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection