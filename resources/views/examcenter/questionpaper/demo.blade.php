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
<script>
    $(document).ready(function() { 

        $('.agent').val(window.navigator.userAgent);

     });

</script>
<div class="container">
	<div class="row">
		<div class="col-12">
            <h3>JANUARY 2025  EXAMINATION - QUESTION PAPERS
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
                <br> <br>
                <div class="alert alert-danger">
                    Close this page only after downloading all the Question Papers. This page is accessible only <b>one time</b> for the scheduled examination session.
                </div>
                <div class="alert alert-danger">
                    This is a demo page
                </div>
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th>Slno</th>
                    <th>
                        Course
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
                        Number of Students
                    </th>
                    <th>
                        NBER
                    </th>
                    <th>
                        Download Question Paper 
                        <a href="javascript:showAll();" class="btn btn-warning btn-xs pull-right showall hidden">Show All Languages</a>
                    </th>
                    <th class="bg-success">
                        Password
                    </th>
                </tr>
                <?php $slno = 1; ?>
                @foreach($exams  as $exam)
                    @if($slno < 5)
                        <tr>
                            <td>
                                {{$slno}} 
                            </td>
                            <td>
                                Example Course #{{ $slno }}
                            </td>
                            <td>
                                Example Code #{{ $slno }}
                            </td>
                            
                            <td>
                                Example Subject #{{ $slno }}
                            
                            </td>
                            <td>
                                Example Batch #{{ $slno }}
                            </td>
                            <td>
                                {{$exam->no_of_student}}
                            </td>
                            <td>
                                NBER #{{ $slno }}
                            </td>
                            <?php $slno++ ; ?>
                            <td>
                                <?php
                                        $ttcount = $exam->examtimetable->languages()->count();
                                        $omr_code = $exam->examtimetable->subject->omr_code;
                                        $examtimetable = \App\Examtimetable::find(2421);
                                    //  if($ttcount == 0){
                                    //     $sql = "SELECT tt.id from examtimetables  tt inner join subjects s on tt.subject_id = s.id  and  s.omr_code = "+ $omr_code +" inner join examtimetable_language ttl on ttl.examtimetable_id = tt.id WHERE tt.exam_id= 27 group by tt.id";
                                    //     $result = collect(DB::select($sql))->first();
                                    //     if(!is_null($result)){
                                    //         $examtimetable = \App\Examtimetable::find($result->id);
                                    //     }
                                    // }else{
                                    //     $examtimetable = $exam->examtimetable;
                                    // }    
                                    ?>
                                    @foreach($examtimetable->languages  as $paper)
                                        <?php $language_ids = explode(',',$exam['language_ids']); ?>
                                        <form   target="_blank" action="{{url('examcenter/downloadqp')}}" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="language_id" value="{{$paper->id}}">
                                            <input type="hidden" name="examtimetable_id" value="{{$exam->examtimetable_id}}">
                                            <input type="hidden" name="rand_string" value="{{$paper->pivot->rand_string}}">
                                            <input type="hidden" name="agent" class="agent">
                                            <button type="submit" class="btn btn-xs btn-primary " style="margin-right:5px;margin-bottom:5px;float:left">
                                                {{$paper->language}}
                                            </button>
                                        {{--  <a target="_blank" class="btn btn-xs btn-primary @if(in_array($paper->id,$language_ids) || $paper->id == 1 || $paper->id == 2 || $paper->id == 14)  @else hide @endif " style="margin-right:5px;margin-bottom:5px" href="{{url('files/questionpapers/')}}/{{$paper->pivot->question_paper}}">{{$paper->language}}</a> --}}
                                        </form>
                                    @endforeach
                            </td>
                            <td class="bg-success"><b class="text-red">DEMO@123</b></td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection