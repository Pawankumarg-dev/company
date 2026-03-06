@extends('layouts.app')
@section('content')

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
            <h3>JUNE 2024  EXAMINATION - ATTENDANCE
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
            <span style="background-color:#46974E;color:white;border-radius:5px;padding:0 5px;margin-right:10px;">
                {{\Carbon\Carbon::parse($schedule->starttime)->format('h:i A')}} to 
                            {{\Carbon\Carbon::parse($schedule->endtime)->format('h:i A')}}
            </span>
            <span style="background-color:#e04609;color:white;border-radius:5px;padding:0 5px;"> {{$externalexamcenter->code}} - {{$externalexamcenter->name}} </span>
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
                    <th>Term</th>
                    <th class="">Attendance sheet</th>
                    <th class="">
                         Attendance
                    </th>
                </tr>
                <?php $count = 0; $nber_id =   \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;?>
                @foreach($approvedprogrammes  as $ap)
                    @if($ap->programme->nber_id == $nber_id)
                    
                    <?php $subject = $schedule->daytimetable($ap->programme_id)->subject; 
                    $subject_id = $subject->id;
                    $subject_ids = [$subject->id];
                    //$subject = \App\Subject::find($subject_id);
                    //$subject_ids = [$subject->id];
                    $checkalternativeof = \App\Subject::where('alternative_of',$subject_id)->first();
                    if(!is_null($checkalternativeof)){
                        array_push($subject_ids,$checkalternativeof->id);
                    }
                    if($subject->alternative == 1){
                        array_push($subject_ids, $subject->alternative_of);
                    }

                    $saids = \App\Supplimentaryapplicant::where('block',null)->where('approvedprogramme_id',$ap->approvedprogramme_id)->get()->pluck('id')->toArray();
                    $applicants = \App\Supplimentaryapplication::whereIn('supplimentaryapplicant_id',$saids)->whereIn('subject_id',$subject_ids)->count();
                    $marked = \App\Supplimentaryapplication::whereIn('supplimentaryapplicant_id',$saids)->where('subject_id',$subject->id)->whereIn('externalattendance_id',[1,2])->count();
                    ?>

                    @if($applicants > 0)
                        <?php $count++; ?>
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
                                    {!!$subject->scode !!}
                                </td>

                                <td>
                                    {!!$subject->sname !!}
                                </td>
                                <td>
                                    <b>{{$ap->institute->rci_code}}</b> - {{$ap->institute->name}}
                                </td>
                                <td>
                                    {!!$subject->syear!!}
                                </td>
                                <?php 
                                            $up = \App\Examattendancesheet::where('exam_id',$exam_id)
                                                                        ->where('approvedprogramme_id',$ap->approvedprogramme_id)
                                                                        ->where('subject_id',$subject->id)
                                                                        ->first(); 
                                        ?>
                                <td
                                    class="@if(is_null($up)) bg-danger @else bg-success @endif"
                                >
                                @if(!is_null($up))
                                <a href="{{url('files/examattendancefiles/')}}/{{$up->filename}}" target="_blank">Download</a>
                                @else
                                Not Uploaded
                                @endif
                                </td>
                                
                                <td
                                    class="@if(($marked < 1)) bg-danger @else bg-success @endif"
                                >
                                    <a href="{{url('nber/exam/attendance/')}}/{{$externalexamcenter_id}}/edit?examschedule_id={{$schedule->id}}&approvedprogramme_id={{$ap->approvedprogramme_id}}&subject_id={{$subject->id}}" class="btn btn-xs @if(($marked < 1 )) btn-danger @else btn-success @endif">Attendance</a>
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
            </table>
            @if($count == 0)
                No Exam for this NBER
            @endif
        </div>
    </div>
</div>
@endsection