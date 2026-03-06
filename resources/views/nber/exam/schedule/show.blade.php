@extends('layouts.app')
@section('content')
<div class="container">
    <style>
        .not-selected{
            background: gray;
            color: white;
        }
    </style>
	<div class="row">
		<div class="col-12">
            <?php $slno = 1; ?>
            <h3>{{$schedule->description}} - {{$exam->name}} Examinations</h3>
            @if($show=='courses')
                <a href="{{url('nber/exam/schedules/')}}/{{$schedule->id}}?get=allEmailIDs" class="btn btn-xs btn-primary hidden">Get All Email IDs</a>
                <br> <br>
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th>
                            SlNo
                        </th>
                        <th>
                            Course
                        </th>
                        <th>
                            Subjet Code
                        </th>
                        <th>
                            ORM Subject Code
                        </th>
                        <th>
                            Subject
                        </th>
                        <th>Question Paper Pattern, Answer Keys and Evaluators</th>
                    </tr>
                    @foreach($schedule->examtimetables->sortBy('subject.programme.course_name') as $timetable)
                        @if(!is_null($timetable->subject))
                            @if($timetable->subject->programme->nber_id == $nber_id)
                                <tr>
                                    <td>
                                        {{$slno}}
                                        <?php $slno++; ?>
                                    </td>
                                    <td>
                                        {{$timetable->subject->programme->course_name}}
                                    </td>
                                    <td>
                                        {{$timetable->subject->scode}}
                                    </td>
                                    <td>
                                        {{ str_pad($timetable->subject->omr_code,5,'0', STR_PAD_LEFT) }}
                                    </td>
                                    <td>
                                        {{$timetable->subject->sname}}
                                    </td>
                                    <td>
                                        <a class="btn btn-xs btn-primary " href="{{url('nber/exam/answerkeys/')}}/{{$timetable->id}}">Question Paper Pattern, Answer Keys and Evaluators</a>
                                    </td>
                                    <td class="hidden">
                                        <a href="{{url('nber/exam/schedules/')}}/{{$schedule->id}}?get=allEmailIDs&sid={{$timetable->subject_id}}" class="btn btn-warning btn-xs hidden">Email IDs</a>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                </table>
            @else
                <a href="{{url('nber/exam/schedules/')}}/{{$schedule->id}}" class="btn btn-xs btn-primary">Back</a>

                <br> <br>

                <div class="btn-group" role="group" aria-label="...">
                    <a href="{{url('nber/exam/schedules/')}}/{{$schedule->id}}?get=allEmailIDs" class="btn btn-default @if($min!=1) not-selected @endif">For All Strength</a>

                    {{--<a href="{{url('nber/exam/schedules/')}}/{{$schedule->id}}?get=allEmailIDs&min=1&max=100" class="btn btn-default @if($min!=1 || $max!=100) not-selected @endif">Less than 100 Strength</a>
                    <a href="{{url('nber/exam/schedules/')}}/{{$schedule->id}}?get=allEmailIDs&min=100&max=300" class="btn btn-default @if($min!=100) not-selected @endif">100 to 299 Strength</a>
                    <a href="{{url('nber/exam/schedules/')}}/{{$schedule->id}}?get=allEmailIDs&min=300&max=1200" class="btn btn-default @if($min!=300) not-selected @endif">300 or more Strength</a>--}}
                </div>
                <br />
                <br />

                <div class="alert alert-danger" style="word-wrap: break-word;">
                    Select the below Email IDs and paste in the <b>bcc</b> while sending out the password
                </div>
                <div class="alert alert-success" style="word-wrap: break-word;">
                    {!!$emails!!}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection