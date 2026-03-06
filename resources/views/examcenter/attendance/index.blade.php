@extends('layouts.app')
@section('content')
<script>
    function validateFile(btn) {
            var filename = '.filename_'+btn;
            var ext = $(filename).val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['pdf','png','jpg','jpeg']) == -1){
                swal("Error Occurred!!!", "Please upload the scanned file in .pdf/.png/.jpg/.jpeg format only.", "error");
                $(filename).val(null);
                return false;
            }
            else if ($(filename)[0].files[0].size > 1048576) {
                swal("Error Occurred!!!", "Please upload the scanned file less than 1 MB file size.", "error");
                $(filename).val(null);
                return false;
            }
            else {
                $('.ext_'+btn).val(ext);
                $('.btn-'+btn).attr('disabled',false);
            }

        }
</script>
<style>
    .badge-success{
        background-color: green;
    }
    .badge-yellow{
        background-color: yellow;
        color:black;
    }
</style>
<div class="container">
	<div class="row">
		<div class="col-12">
            <h3>JUNE 2025  EXAMINATION - ATTENDANCE
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
            <span style="background-color:#F39532;color:white;border-radius:5px;padding:0 5px;margin-right:10px;">{{\Carbon\Carbon::parse($schedule->examdate)->format('d-M-Y')}} </span>
            <span style="background-color:#46974E;color:white;border-radius:5px;padding:0 5px;">
                {{\Carbon\Carbon::parse($schedule->starttime)->format('h:i A')}} to 
                            {{\Carbon\Carbon::parse($schedule->endtime)->format('h:i A')}}
            </span>
            </h4>
            <?php $slno = 1;  ?>
   
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th>Slno</th>
                    <th>
                        Programme
                    </th>
                    <th>
                        Subject Code
                    </th>
                    <th>
                        Subject
                    </th>
                    <th>
                        Institute
                    </th>
                    <th>
                         Admission Year
                    </th>
                    <th>
                        NBER
                    </th>
                    <th>Term</th>
                    <th class="bg-danger">Upload the attendance sheet</th>
                    <th class="bg-danger">
                        Mark Attendance
                    </th>
                </tr>
                @foreach($approvedprogrammes  as $ap)
                    <?php //$subject = $schedule->daytimetable($ap->programme_id)->subject; 
                   // $subject_id = $subject->id;
                   // $subject_ids = [$subject->id];
                    //$subject = \App\Subject::find($subject_id);
                    //$subject_ids = [$subject->id];
                  //  $checkalternativeof = \App\Subject::where('alternative_of',$subject_id)->first();
//                    if(!is_null($checkalternativeof)){
  //                      array_push($subject_ids,$checkalternativeof->id);
    //                }
      //              if($subject->alternative == 1){
        //                array_push($subject_ids, $subject->alternative_of);
          //          }

//                    $saids = \App\Newapplicant::where('approvedprogramme_id',$ap->approvedprogramme_id)->get()->pluck('id')->toArray();
  //                  $applicants = \App\Newapplication::whereIn('newapplicant_id',$saids)->whereIn('subject_id',$subject_ids)->count();
    //                $marked = \App\Newapplication::whereIn('newapplicant_id',$saids)->where('subject_id',$subject->id)->whereIn('externalattendance_id',[1,2])->count();
                    ?>
                 {{--   @if($applicants > 0) --}}
                        <tr>
                            <td>
                                {{$slno}}
                                <?php $slno++; ?>
                            </td>
                            <td>
                            <b>
                            {{$ap->programme->course_name}}</b>
                            
                                {{$ap->programme->name}} 
                            </td>
                            <td>
                                {!!$ap->subject->scode !!}
                            </td>

                            <td>
                                {!!$ap->subject->sname !!}
                            </td>
                            <td>
                            @if($schedule->description != 'Mockdrill')

                                <b>{{$ap->institute->rci_code}}</b> - {{$ap->institute->name}}
                                @else
                                DEMO 

                            @endif
                            </td>
                            <td style="">
                                {{$ap->approvedprogramme->academicyear->year}}
                            </td>
                            <td>
                                {{$ap->programme->nber->name_code}}
                            </td>
                            <td>
                                {!!$ap->subject->syear!!}
                            </td>
                            <?php 
                                        
                                    ?>
                            <td
                                class="@if($ap->scan_copy == 0) bg-danger @else bg-success @endif"
                            >
                            @if($schedule->description != 'Mockdrill')
                                <form action="{{url('examcenter/attendancesheet/')}}"   enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="approvedprogramme_id" value="{{$ap->approvedprogramme_id}}">
                                    <input type="hidden" name="subject_id" value="{{$ap->subject->id}}">
                                    <input type="hidden" name="examtimetable_id"  value="{{$ap->examtimetable_id}}">
                                    <input type="hidden" name="exampaper_id" value="{{$ap->id}}">
                                    <input type="hidden" class="ext_{{$ap->id}}" name="ext" />
                                  
                                    
                                    @if($ap->scan_copy == 0 )
                                        <span class="badge badge-yellow">
                                        Choose Scanned copy of attendance sheet
                                        </span>
                                    @else
                                    <span class="badge badge-success">
                                        Uploaded
                                    </span> 
                                    <a href="{{url('files/examattendancefiles/')}}/{{$ap->filename}}" target="_blank">Download</a>
                                    
                                    @endif 
                                    <input type="file" class="form-control filename_{{$ap->id}}" id="filename" name="filename" onchange="validateFile({{$ap->id}})" style="background:transparent;border:none;">
                                    <button type="submit" class="btn  @if($ap->scan_copy != 0) btn-primary @else  btn-light @endif  btn-xs btn-{{$ap->id}}" disabled>  
                                        @if($ap->scan_copy == 0) Upload @else Re-upload  @endif
                                    </button>
                                </form>
                                @endif
                            </td>
                            <?php 
                              //  $saids = \App\Newapplicant::where('approvedprogramme_id',$ap->approvedprogramme_id)->get()->pluck('id')->toArray();
                              //  $marked = \App\Newapplication::whereIn('newapplicant_id',$saids)->where('subject_id',$subject->id)->whereIn('externalattendance_id',[1,2])->count();
                            ?>
                            <td
                                class="@if($ap->attendance == 0) bg-danger @else bg-success @endif" 

                            >
                            @if($schedule->description != 'Mockdrill')

                                <a href="{{url('examcenter/attendance')}}/{{$ap->approvedprogramme_id}}?subject_id={{$ap->subject_id}}&examschedule_id={{$ap->examschedule_id}}" class="btn @if(($ap->attendance == 0)) btn-danger @else btn-success @endif--}} btn-sm">Mark Attendance</a>
                                @endif
                            </td>
                        </tr>
                    {{--@endif--}}
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection