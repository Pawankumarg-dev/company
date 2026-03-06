@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h3><i class="fa fa-arrow-right"> </i> Exam Applications, Mark Entry, Attendance Upload, Hall ticket & more  </h3>

                <hr />
            </div>
        </div>
        @include('common.errorandmsg')

        <div class="row">
            <div class="col-md-12">
                @foreach($exams as $e)
                    <h4><i class="fa fa-calendar"></i> {{$e->name}}
                        @if($e->status_id==1)
                            <div class="pull-right">
                                <a href="{{url('qpdownload')}}/{{$e->id}}" class="btn btn-xs btn-info">Question Papers</a>

                                <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#timetable"><i class="fa fa-table"></i>&nbsp;Time Table </button>

                                @include('institute.exam.timetable')
                            </div>
                        @endif
                    </h4>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th width="20%">Programme Code</th>
                            <th width="10%">Batch</th>
                            <th width="70%">Links</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($approvedprogrammes as $ap)
                            @if($exambatches->where('exam_id', $e->id)->where('programme_id', $ap->programme_id)
                            ->where('academicyear_id', $ap->academicyear_id)->count() == '1')
                                <tr>
                                    <td>{{ $ap->programme->course_name }}</td>
                                    <td>{{ $ap->academicyear->year }}</td>
                                    <td>
                                        @if($e->institute_markentry == 1)
                                            @if($ap->applications->where('exam_id', $e->id)->count() != 0)
                                                <a href="{{url('/institute/exammarksentry/'.$e->id.'/showlist/'.$ap->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>

                                            @else

                                            @endif
                                        @endif

                                        @if($e->status_id == 1 || $e->status_id == 3)
                                            <a href="{{url('/institute/practicalexam/'.$e->id.'/showpage/'.$ap->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Practical Exam</a>
                                        @endif

                                        @if($e->exam_application == 1)
                                                <a href="{{url('applications/'.$ap->id).'/'.$e->id}}"  class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> &nbsp;&nbsp;Exam Applications</a>
                                        @endif

                                        @if($e->status_id==1)
                                                {{--<a href="{{url('/institute/practicalexam/'.$e->id.'/showpage/'.$ap->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Practical Exam</a>--}}

                                                {{--
                                                <a href="{{url('applications/'.$ap->id).'/'.$e->id}}"  class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> &nbsp;&nbsp;Exam Applications</a>
                                                <a href="{{url('/institute/exammarksentry/'.$e->id.'/showlist/'.$ap->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                <a href="{{url('/institute/practicalexam/'.$e->id.'/showpage/'.$ap->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Practical Exam</a>
                                                --}}

                                                {{--
                                            <a href="{{url('marks/'.$ap->id).'/'.$e->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                --}}
                                            @if($e->programme->programmegroup->attendance_upload==1)
                                                @if($ap->applications->where('exam_id', $e->id)->count() != 0)
                                                <a href="{{url('halltickets/'.$ap->id).'/'.$e->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Attendance</a>
                                                @endif
                                            @endif
                                            @if($ap->programme->programmegroup->hallticket_download==1)
                                                @if($ap->applications->where('exam_id', $e->id)->count() != 0)
                                                <a href="{{url('/institute/hallticket-download/'.$e->id.'/show-candidates-list/'.$ap->id)}}" class="btn btn-info btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Theory Hallticket</a>
                                                @endif
                                            @endif
                                        @elseif($e->status_id==0 || $e->status_id == 3)
                                            @foreach($erds as $erd)
                                                @if($erd->exam_id == $e->id)
                                                    @if($erd->programme_id == $ap->programme_id)
                                                        @if($erd->academicyear_id == $ap->academicyear_id)
                                                            @if($erd->publish_status == 1)
                                                                <a href="{{url('/result/'.$e->id).'/'.$ap->id}}" class="btn btn-info btn-sm" target="_blank">
                                                                    <i class="fa fa-eye"></i> Result
                                                                </a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else

                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        function modalpop(id){
            $('#programme_id').val(id);
            $('#myForm').attr('action',"{{url('approvedprogramme')}}");
            $('#myModal').modal('show');
        }
        function editdata(pid,id,maxintake){
            $('#programme_id').val(pid);
            $('form').attr('action',"{{url('approvedprogramme')}}/"+id+"/edit");
            $('#myModal').modal('show');
            $('#maxintake').val(maxintake);
        }
        function deleteap(id){
            $('form').attr('action',"{{url('approvedprogramme')}}/"+id+"/delete");
            $('#myDeleteModal').modal('show');

        }
    </script>
@endsection
