@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6">
            <?php $slno = 1; ?>
            <h3>{{$exam->name}} Examinations</h3>
            <br>
            Course: 
            <form action="{{url('/nber/exam/timetable')}}" method="get">
                {{csrf_field()}}
                @include('common.programmes.dropdown')
            </form>
        </div>
    </div>
            @if(!is_null($timetables))
            	<div class="row">
                    <div class="col-md-12">
                <div class="alert alert-success ">No of Applicants: {{$countofcandidates}}</div>
            </div>
                </div>
            	<div class="row">

        		<div class="col-md-12">
                    <a href="{{url('nber/exam/timetable/create')}}?programme_id={{$programme->id}}" class="btn btn-primary btn-xs pull-right">Add</a>
                </div>
                </div>
                @if($timetables->count()>0)
            	<div class="row">

        		<div class="col-md-12">
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <th>
                                SlNo
                            </th>
                            <th>
                                Type
                            </th>
                            <th>
                                Term
                            </th>
                            <th>
                                Subject Code
                            </th>
                            <th>Subject OMR code</th>
                            <th>
                                Subject
                            </th>
                            <th>
                                Date
                            </th>
                            <th>
                                Start Time
                            </th>
                            <th>
                                End Time
                            </th>
                            <th>Description</th>
                            <th class="">Answer Keys, QP Pattern & Evaluators</th>
                            <th>Remarks</th>
                        </tr>
                        @foreach($timetables as $timetable)
                        <tr>
                            <td>
                                {{$slno}}
                                <?php $slno++; ?>
                            </td>
                            <td>
                                {{$timetable->subject->subjecttype->type}}
                            </td>

                            <td>
                                {{$timetable->subject->syear}}
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
                                {{\Carbon\Carbon::parse($timetable->examschedule->examdate)->format('d-M-Y')}}
                            </td>
                            <td>
                                {{\Carbon\Carbon::parse($timetable->examschedule->starttime)->format('h:i A')}}
                            </td>
                            <td>
                                {{\Carbon\Carbon::parse($timetable->examschedule->endtime)->format('h:i A')}}
                            </td>
                            <td>
                                {{$timetable->examschedule->description}}
                            </td>
                            <td>

                                <a class="btn btn-xs btn-primary " href="{{url('nber/exam/answerkeys/')}}/{{$timetable->id}}">Question Paper Pattern & Answer Keys</a>
                            </td>
                            <td>
                                <form action="{{ url('nber/exam/timetable')}}/{{  $timetable->id }}" method="POST">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button class="btn btn-xs btn-danger">Delete</button>
                                </form>
                            <?php $als = \App\Applicationlanguage::where('examtimetable_id',$timetable->id)->first(); ?>
                                @if(!is_null($als))
                                    <?php $anskey = \App\Answerkey::where('examtimetable_id',$timetable->id)->first(); $tm =0 ; ?>
                                    @if(is_null($anskey))
                                        Answer Key not found
                                    @else
                                        <?php $qppattern = \App\Qppattern::where('examtimetable_id',$timetable->id)->get(); ?>
                                        @if($qppattern->count() ==0 )
                                            Question paper pattern not found
                                        @else
                                            @foreach($qppattern as $p)
                                                <?php $tm += $p->marks_per_question * $p->number_of_questions_to_answer ; ?>
                                            @endforeach
                                            @if($tm != $anskey->total_marks)
                                                Total marks in Question paper pattern is not matching with total marks max marks on the subject
                                            @endif
                                        @endif
                                    @endif

                                    <?php $soe = \App\Subjectofevaluator::where('examtimetable_id',$timetable->id)->pluck('language_id')->unique(); ?>
                                    @if($soe->count() != $als->no_of_languages)
                                        Evaluator details incomplete or missing
                                    @endif
                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                </div>
                @else
                	<div class="row">
                        <div class=" col-md-12">
                    <div class="alert alert-danger">No schedule found</div>
                </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection