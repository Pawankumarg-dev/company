@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6">
            <?php $slno = 1; ?>
            <h3>{{$exam->name}} Examinations</h3>
            @include('common.errorandmsg')
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
                            <th class="hidden">Upload Question Paper</th>
                            <th>
                                Created By
                            </th>
                            <td>
                                Delete
                            </td>
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
                            <td class="hidden">
                                <a class="btn btn-xs btn-primary" href="{{url('nber/exam/timetable/')}}/{{$timetable->id}}">Question Paper Upload</a>
                            </td>

                            <td>
                                @if(!is_null($timetable->user_id))
                                    {{$timetable->user->username}}
                                @endif
                            </td>
                            <td>
                                <form action="{{url('nber/exam/timetable/')}}/{{$timetable->id}}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE"> 
                                    <button type="submit" class="btn btn-xs btn-danger" disabled>Delete</button>
                                </form> 
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