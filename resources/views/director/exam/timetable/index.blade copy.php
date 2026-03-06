@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6">
            <?php $slno = 1; ?>
            <h3>{{$exam->name}} Examinations</h3>
            <div class="alert alert-success">
                Click <a target="_blank" href="{{ url('files/director/SOP.pdf') }}">here</a> for SOP - uploading question papers for supplementary exam 2025.
            </div>
            @include('common.errorandmsg')
            <br>
            Course: 
            <form action="{{url('/qp/exam/timetable')}}" method="get">
                {{csrf_field()}}
                @include('common.courses.dropdown')
            </form>
            @if(!is_null($course))
            <br>
            Revision: 
            <form action="{{url('/qp/exam/timetable')}}" method="get">
                {{csrf_field()}}
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                @include('common.programmes.dropdown')
            </form>
            @endif
        </div>
    </div>
            @if(!is_null($timetables))
            	<div class="row hidden">
                    <div class="col-md-12">
                <div class="alert alert-success ">No of Applicants: {{$countofcandidates}}</div>
                </div>
                </div>
                <div class="alert alert-danger"
                >
                    Please complete uploading all the remaining question papers for the  examinations till 23th Jan 2025,  tomorrow (19th Jan 2025) before 10:00 AM. The portal will be closed for processing the question papers from 10:00 AM onwards.
                    <ul>
                        <li>
                            Kindly upload all the 3 sets of each question papers, of each languages uploaded. 
                        </li>
                        <li>
                            Please do not upload question papers with out encrypting. 
                        </li>
                        <li>
                            Please make sure the password saved in the portal matches with the pdf password.
                        </li>
                        
                    </ul>
                </div>
            	<div class="row">

        		<div class="col-md-12">
                    <a href="{{url('qp/exam/timetable/create')}}?programme_id={{$programme->id}}" class="hidden btn btn-primary btn-xs pull-right">Add</a>
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
                            <th>Upload Question Paper</th>
                            
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
                            <td>
                                <a class="btn btn-xs btn-primary" href="{{url('qp/exam/timetable/')}}/{{$timetable->id}}">Question Paper Upload</a>
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