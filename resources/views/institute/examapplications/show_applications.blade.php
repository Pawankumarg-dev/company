@extends('layouts.app')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4>
                    {{$exam->name}} Examinations
                    </h4>

                    <table class="table table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th rowspan="1" width="5%" class="center-text">Batch</th>
                                <th rowspan="1"  width="15%">Course</th>
                                <th rowspan="1"  class="center-text">Links</th>
                                {{--  <th rowspan="1"  class="center-text">Attendance</th>
                                <th colspan="1" class="center-text">Mark Entry</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($approvedprogrammes as $approvedprogramme)
                            <tr>
                                <td class="center-text">{{ $approvedprogramme->academicyear->year }}</td>
                                <td>{{ $approvedprogramme->programme->course_name }}</td>
                                <td class="center-text">
                                    @if($exam->download_marksheet == 1)
                                    <a href="{{ url('/institute/examinations/applications/'.$exam->id.'/'.$approvedprogramme->id) }}" class="btn btn-sm btn-success">
                                    <i class="fa fa-th"></i> &nbsp;&nbsp;  Marksheet and Certificates
                                    </a>
                                    @endif
                                    
                                    @if($exam->attendance_upload == 1)
                                    <a href="{{url('attendanceupload/'.$approvedprogramme->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Attendance</a>
                                    @endif
                                </td>
                                {{--   <td class="center-text">
                                    <a href="{{url('attendanceupload/'.$approvedprogramme->id).'/22'}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Attendance</a>
                                </td> 
                                 <td class="center-text">
                                   <a href="{{url('institute/exammarksentry/internal-practical/add-form/22/'.$approvedprogramme->id)}}" class="btn btn-primary btn-sm "><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                    <a href="{{url('institute/exammarksentry/internal-practical/view/22/'.$approvedprogramme->id)}}" class="btn btn-info btn-sm " style="margin-top:5px;"><i class="glyphicon glyphicon-eye-open"></i> &nbsp;&nbsp;View Marks</a>
                                </td>
                                <td class="center-text">
                                <a href="{{url('institute/exammarksentry/external-practical/add-form/22/'.$approvedprogramme->id)}}" class="btn btn-primary btn-sm "><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                    <a href="{{url('institute/exammarksentry/external-practical/view/22/'.$approvedprogramme->id)}}" class="btn btn-info btn-sm "  style="margin-top:5px;"><i class="glyphicon glyphicon-eye-open"></i> &nbsp;&nbsp;View Marks</a>
                                </td>
                                <td class="center-text">
                                <a href="{{url('institute/exammarksentry/internal-theory/add-form/22/'.$approvedprogramme->id)}}" class="btn btn-primary btn-sm "><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                    <a href="{{url('institute/exammarksentry/internal-theory/view/22/'.$approvedprogramme->id)}}" class="btn btn-info btn-sm "  style="margin-top:5px;"><i class="glyphicon glyphicon-eye-open"></i> &nbsp;&nbsp;View Marks</a>
                                </td>
                                <td class="center-text">
                                    <a href="{{url('institute/markentry')}}?apid={{$approvedprogramme->id}}" class=" btn btn-info btn-sm">Mark Entry</a>
                                </td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
