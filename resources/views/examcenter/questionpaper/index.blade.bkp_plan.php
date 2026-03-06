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
                        Subject OMR Code
                    </th>
                    <th>
                        Subject
                    </th>
                    
                    <th>
                        Number of Students
                    </th>
                    <th>
                        NBER
                    </th>
                  
                    <th>
                        Download Question Paper 
                        <a href="javascript:showAll();" class="btn btn-warning btn-xs pull-right showall ">Show All Languages</a>
                    </th>
                    <th class="bg-success">
                        Password
                    </th>
                </tr>
                <?php $slno = 1; ?>
                @foreach($exams  as $exam)
                    <tr>
                        <td>
                            {{$slno}} <?php $slno++ ; ?>
                        </td>
                        <td>
                            {{$exam->courses}}
                        </td>
                        <td>
                            
                            {{$exam->subjectcode}}
                            
                        </td>
                        <td>
                            {{$exam->subject->omr_code}}
                        </td>
                        <td>
                           {{$exam->subject->sname}}
                           
                        </td>
                     
                        <td>
                            {{$exam->no_of_student}}
                        </td>
                        <td>
                            {{$exam->programme->nber->name_code}}
                        </td>
                     
                        <td>
                                <?php 
                                        $examtimetable = $exam->examtimetable; 
                                        $ttcount = $exam->examtimetable->languages()->count();
                                        if($ttcount == 0){
                                            $examtimetable = \App\Examtimetable::find($exam->examtimetable->omr_examtimetable_id);
                                        }
                                            $ttcount = $examtimetable->languages()->count();
                                            if($ttcount == 0){
                                                $omr_code = $examtimetable->subject->omr_code;
                                                $examtimetable = \App\Examtimetable::find($examtimetable->omr_examtimetable_id);
                                                // $sql = "SELECT tt.id from examtimetables  tt inner join subjects s on tt.subject_id = s.id  and  s.omr_code = "+ $omr_code +" inner join examtimetable_language ttl on ttl.examtimetable_id = tt.id WHERE tt.exam_id= 27 group by tt.id";
                                                // $result = collect(DB::select($sql))->first();
                                                // if(!is_null($result)){
                                                //     $examtimetable = \App\Examtimetable::find($result->id);
                                                // }else{
                                                //     echo "QP Not found";
                                                // }
                                                            {
                                                    

                                                }
                                            }
                                            
                                            
                                            ?>
                        
                        @if($examtimetable->examschedule_id == 69 || $examtimetable->examschedule_id == 70)
                                            
                                @foreach($examtimetable->languages as $paper)

                                    <?php

                                            $field = 'question_paper_'.$examtimetable->examschedule->qpset;
                                            $file = $paper->pivot->$field;
                                    
                                    
                                        if($examtimetable->id == 2668){
                                            $field = 'question_paper_1';
                                            $file = $paper->pivot->$field;
                                        }
                                    ?>

                                    <a class="btn btn-xs btn-primary  " target="_blank" href="{{ url('files/questionpapers/27') }}/{{ $file }}">{{ $paper->language }}</a>
                                @endforeach 
                                
                                <?php 
                                
                                    if($examtimetable->id == 2327){
                                        echo "<b>Alternative Paper:</b><br />"; ?>
                                        <a class="btn btn-xs btn-primary  " target="_blank" href="{{ url('files/14113') }}/1.pdf">English</a>
                                        <a class="btn btn-xs btn-primary  " target="_blank" href="{{ url('files/14113') }}/2.pdf">Hindi</a>
                                        <a class="btn btn-xs btn-primary  " target="_blank" href="{{ url('files/14113') }}/3.pdf">Marathi</a>

                                        <?php 
                                            
                                        
                                    }
                                    ?>
                        </td>
                        @endif
                        
                        
                        
                        <td class="bg-success"><b class="text-red  ">{{$examtimetable->password}}</b></td> 
                    
                    </tr>


                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection