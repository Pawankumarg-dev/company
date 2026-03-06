@extends('layouts.app')
@section('content')
<script>
    function showAll(){
            $('.hide').removeClass('hide');
            $('.showall').addClass('hide');
        }
</script>

<style>
    .hide{
        display: none;
    }
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
            <h3>JUNE 2024  EXAMINATION - QUESTION PAPERS
            </h3>
            @include('common.errorandmsg')
            <h4>
            <span style="background-color:#F39532;color:white;border-radius:5px;padding:0 5px;margin-right:10px;">{{\Carbon\Carbon::parse($schedule->examdate)->format('d-M-Y')}} </span>
            <span style="background-color:#46974E;color:white;border-radius:5px;padding:0 5px;">
                {{\Carbon\Carbon::parse($schedule->starttime)->format('h:i A')}} to 
                            {{\Carbon\Carbon::parse($schedule->endtime)->format('h:i A')}}
            </span>
            </h4>
            <?php $slno = 1;  ?>
            <a href="{{url('examcenter/schedule')}}" class="pull-right btn btn-xs btn-primary"
                style="margin-top:-35px;"
                >Back</a>
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
                        Batches
                    </th>
                    <th>
                        No Of Students
                    </th>
                    <th>
                        NBER
                    </th>
                    <th>
                        Email 
                    </th>
                    <th>
                        Download Question Paper 
                        <a href="javascript:showAll();" class="btn btn-warning btn-xs pull-right showall">Show All Languages</a>
                    </th>
                </tr>
                <?php $slno = 1; ?>
                @foreach($exams  as $exam)
                    <tr>
                        <td>
                            {{$slno}} <?php $slno++ ; ?>
                        </td>
                        <td>
                            {{$exam['display_code']}}
                        </td>
                        <td>
                            {{$exam['scode']}}
                        </td>
                        
                        <td>
                            {{$exam['sname']}} 
                            <?php 
                               /* $hasalt = false;
                                if($exam['has_alternative'] == 1){
                                    $hasalt =true;
                                    $altsubjects = \App\Subject::where('alternative_of',$exam['subject_id'])->get();
                                    foreach($altsubjects as $asubject){
                                        echo ' <br /> <b>or</b> <br/> '.$asubject->sname . ' (Alternative)';
                                    }
                                }*/
                            ?>
                        </td>
                        <td>
                            {{$exam['batches']}}
                        </td>
                        <td>
                            {{$exam['noofstudent']}}
                        </td>
                        <td>
                            {{$exam['name_code']}}
                        </td>
                        <td>
                            {{$exam['email']}}
                        </td>
                        <td>
                            <?php
                                $timetable = \App\Examtimetable::find($exam['id']);
                            ?>
                            @if($hasalt)
                                <table class="table  table-bordered table-condensed">
                                    <tr>
                                        <th>Main</th>
                                        <td>
                                            @foreach($timetable->languages  as $paper)
                                                <?php $language_ids = explode(',',$exam['language_ids']); ?>
                                                <a target="_blank" class="btn btn-xs btn-primary @if(in_array($paper->id,$language_ids) || $paper->id == 1 || $paper->id == 2 || $paper->id == 14)  @else hide @endif " style="margin-right:5px;margin-bottom:5px" href="{{url('files/questionpapers/')}}/{{$paper->pivot->question_paper}}">{{$paper->language}}</a>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @foreach($altsubjects as $asubject)
                                        <tr>
                                            <th>Alternative</th>
                                            <td>
                                                <?php
                                                    $timetable = \App\Examtimetable::where('subject_id',$asubject->id)->where('exam_id',25)->first();
                                                ?>
                                                @foreach($timetable->languages  as $paper)
                                                    <?php $language_ids = explode(',',$exam['language_ids']); ?>
                                                    <a target="_blank" class="btn btn-xs btn-primary @if(in_array($paper->id,$language_ids) || $paper->id == 1 || $paper->id == 2 || $paper->id == 14)  @else hide @endif " style="margin-right:5px;margin-bottom:5px" href="{{url('files/questionpapers/')}}/{{$paper->pivot->question_paper}}">{{$paper->language}}</a>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            @else
                                @foreach($timetable->languages  as $paper)
                                    <?php $language_ids = explode(',',$exam['language_ids']); ?>
                                    <a target="_blank" class="btn btn-xs btn-primary @if(in_array($paper->id,$language_ids) || $paper->id == 1 || $paper->id == 2 || $paper->id == 14)  @else hide @endif " style="margin-right:5px;margin-bottom:5px" href="{{url('files/questionpapers/')}}/{{$paper->pivot->question_paper}}">{{$paper->language}}</a>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection