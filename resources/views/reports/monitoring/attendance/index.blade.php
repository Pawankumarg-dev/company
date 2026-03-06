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
            <h3>Jan 2025  EXAMINATION - ATTENDANCE
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
            <h3>{{ $examcenter->code }} - {{ $examcenter->name }}</h3>
            <h4>
            @if(!is_null($schedule))
            <span style="background-color:#F39532;color:white;border-radius:5px;padding:0 5px;margin-right:10px;">{{\Carbon\Carbon::parse($schedule->examdate)->format('d-M-Y')}} </span>
            <span style="background-color:#46974E;color:white;border-radius:5px;padding:0 5px;">
                {{\Carbon\Carbon::parse($schedule->starttime)->format('h:i A')}} to 
                            {{\Carbon\Carbon::parse($schedule->endtime)->format('h:i A')}}
            </span>
            @else
                All schedules
            @endif
            
            </h4>
            <?php $slno = 1;  ?>
         
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th>Slno</th>
                    @if(is_null($schedule))
                        <th>
                            Schedule
                        </th>
                    @endif
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
                        <th class="bg-danger">Uploaded  attendance sheet</th>
                    <th class="bg-danger">
                         Attendance Marked
                    </th>
                    <th>Verification Status</th>
                </tr>
                @foreach($approvedprogrammes  as $ap)
                        <tr>
                            <td>
                                {{$slno}}
                                <?php $slno++; ?>
                            </td>
                            @if(is_null($schedule))
                                <th>
                                    {{ $ap->examschedule->description }} - {{ $ap->examschedule->examdate }} ( {{ $ap->examschedule->starttime }} to {{ $ap->examschedule->endtime }})
                                </th>
                            @endif
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
                                <b>{{$ap->institute->rci_code}}</b> - {{$ap->institute->name}}
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
                                @if($ap->scan_copy == 1)
                                    <a href="{{url('files/examattendancefiles/')}}/{{$ap->filename}}" target="_blank">Download</a>
                                @endif
                            </td>
                            <?php 
                              //  $saids = \App\Newapplicant::where('approvedprogramme_id',$ap->approvedprogramme_id)->get()->pluck('id')->toArray();
                              //  $marked = \App\Newapplication::whereIn('newapplicant_id',$saids)->where('subject_id',$subject->id)->whereIn('externalattendance_id',[1,2])->count();
                            ?>
                            <td
                                class="@if($ap->attendance == 0) bg-danger @else bg-success @endif" 

                            >
                                <a href="{{url('/reports/verifyattendance')}}/{{$ap->approvedprogramme_id}}?subject_id={{$ap->subject_id}}&examschedule_id={{$ap->examschedule_id}}" class="btn @if(($ap->attendance == 0)) btn-danger @else btn-success @endif--}} btn-sm">Attendance</a>
                            </td>
                            <td
                            class="@if($ap->attn_verification == 0) bg-danger @endif  @if($ap->attn_verification == 2) bg-warning @endif  @if($ap->attn_verification == 1) bg-success @endif" 
                            >
                                @if($ap->attn_verification == 0)
                                    Not Verified
                                @endif
                                
                                @if($ap->attn_verification == 1)
                                    Verified
                                @endif
                                
                                @if($ap->attn_verification == 2)
                                    Correction Required
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