@extends('layouts.app')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title">
                                August 2023 Examinations
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="hidethis">
                                        <ul class="breadcrumb">
                                         {{--   <li class="heading">Quick Links: </li>
                                            <li>
                                                <a href="{{ url('/institute/dashboard/home') }}">Home</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations') }}">Examinations</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations/'.$exam->id) }}">{{ $exam->name }} Examinations</a>
                                            </li> --}}
                                            <li class="active">Exam Applications</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-condensed table-hover">
                                        <thead>
                                        <tr>
                                            <th width="5%" class="center-text">S.No</th>
                                            <th width="15%" class="center-text">Course</th>
                                            <th width="5%" class="center-text">Batch</th>
                                          {{-- <th width="10%" class="center-text">Course Approval</th> --}}
                                            <th width="10%" class="center-text">No. of Students with Enrolment</th>
                                            <th class="center-text">Exam Application Link</th>
                                            <th class="center-text">No. of Students applied for Exam</th>
                                            <th class="center-text">Mark Entry</th>
                                            <th class="center-text">Practical Exam</th>
                                            <th class="center-text">Attendance</th>
                                            <th class="center-text">Hall Tickets</th> 
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $sno = 1; @endphp
                                        @foreach($approvedprogrammes as $approvedprogramme)
                                            <tr>
                                                <td class="center-text">{{ str_pad($sno, 2, "0", STR_PAD_LEFT) }}@php $sno++; @endphp</td>
                                                <td>{{ $approvedprogramme->programme->course_name }}</td>
                                                <td class="center-text">{{ $approvedprogramme->academicyear->year }}</td>
                                              {{--  <td class="center-text">
                                                    <span class="label label-{{ $approvedprogramme->status->class }}">
                                                        {{ $approvedprogramme->status->status }}
                                                    </span>
                                                </td> --}}
                                                <td class="center-text">
                                                    <span class="label label-info">
                                                        {{ $approvedprogramme->enrolmentcandidatecount($approvedprogramme->id) }}
                                                    </span>
                                                </td> 
                                                <td class="center-text">
                                                   {{-- <a href="{{ url('/institute/examinations/applications/'.$exam->id.'/'.$approvedprogramme->id) }}" class="btn btn-sm btn-success"> --}}
                                                    <a href="{{ url('/institute/examinations/applications/22/'.$approvedprogramme->id) }}" class="btn btn-sm btn-success">
                                                        <span class="glyphicon glyphicon-arrow-right"></span> Click Here
                                                    </a>
                                                </td>
                                               {{-- @php
                                                    $examappliedcandidatecount = $approvedprogramme->examappliedcandidatecount($exam->id, $approvedprogramme->id);
                                                @endphp
                                               <td class="center-text">{{ $examappliedcandidatecount }}</td>--}}
                                               {{-- @if($examappliedcandidatecount != 0) 
                                                    @if($exam->institute_markentry == 1)--}}
                                                        <td class="center-text">
                                                        {{--   <a href="{{url('/institute/exammarksentry/'.$exam->id.'/showlist/'.$approvedprogramme->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                           --}} <a href="{{url('/institute/exammarksentry/22/showlist/'.$approvedprogramme->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                        </td>
                                                        <td class="center-text">
                                                         {{--   <a href="{{url('/institute/practicalexam/'.$exam->id.'/showpage/'.$approvedprogramme->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Practical Exam</a> --}}
                                                        </td> 
                                                        {{--     @else
                                                        <td></td>
                                                        <td></td>
                                                    @endif 
                                                     @if($exam->attendance_upload == 1)--}}
                                                            <td class="center-text">
                                                            {{--   <a href="{{url('attendanceupload/'.$approvedprogramme->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Attendance</a> --}}
                                                             <a href="{{url('attendanceupload/'.$approvedprogramme->id).'/22'}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Attendance</a>
                                                            </td> 
                                                     {{--  @else
                                                        <td>

                                                        </td>
                                                    @endif
                                                    @if($exam->hallticket_download == 1)
                                                       <td class="center-text">
                                                            @if($approvedprogramme->applications->count() != 0)
                                                            <a href="{{url('/institute/hallticket-download/showcandidateslist/22/'.$approvedprogramme->id)}}" class="btn btn-info btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Theory Hallticket</a>
                                                            @endif
                                                        </td> 
                                                    @else
                                                        <td>

                                                        </td>
                                                    @endif
                                                    @else
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endif --}}
                                              
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
